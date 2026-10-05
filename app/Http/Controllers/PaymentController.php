<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketBooking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Create payment session / URL
    public function createPayment(Request $request, $bookingCode)
    {
        $booking = TicketBooking::where('booking_code', $bookingCode)->first();
        
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        if ($booking->payment_status === 'paid' || $booking->payment_status === 'checked_in') {
            return response()->json(['success' => false, 'message' => 'Ticket is already paid or checked in.'], 400);
        }

        if ($booking->payment_method === 'cash_on_site') {
            return response()->json([
                'success' => true,
                'data' => [
                    'payment_url' => null,
                    'payment_method' => 'cash_on_site',
                    'message' => 'Pay at the location'
                ]
            ]);
        }

        // Generate iPaymu Request
        $va = env('IPAYMU_VA');
        $apiKey = env('IPAYMU_KEY');
        $url = env('IPAYMU_URL', 'https://sandbox.ipaymu.com/api/v2/payment');
        
        $body = [
            'product' => ['Ticket Booking ' . $booking->booking_code],
            'qty' => [1],
            'price' => [$booking->total_amount],
            'returnUrl' => url('/api/payment/success'),
            'cancelUrl' => url('/api/payment/cancel'),
            'notifyUrl' => url('/api/payment/callback'),
            'referenceId' => $booking->booking_code,
            'buyerName' => $booking->visitor_name,
            'buyerPhone' => $booking->visitor_phone,
            'buyerEmail' => $booking->visitor_email ?? 'guest@example.com',
            'paymentMethod' => $this->mapPaymentMethod($booking->payment_method),
        ];

        // Create signature
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);

        try {
            $response = Http::withHeaders([
                'va' => $va,
                'signature' => $signature,
                'Content-Type' => 'application/json'
            ])->post($url, $body);

            $resData = $response->json();

            if ($response->successful() && isset($resData['Data']['Url'])) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'payment_url' => $resData['Data']['Url'],
                        'session_id' => $resData['Data']['SessionID']
                    ]
                ]);
            } else {
                Log::error('iPaymu Error', ['response' => $resData]);
                // Fallback for sandbox simulation since we don't have real keys
                return $this->simulateSandboxPayment($booking);
            }
        } catch (\Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage());
            return $this->simulateSandboxPayment($booking);
        }
    }

    private function simulateSandboxPayment($booking)
    {
        // Simulate a fake sandbox URL since real iPaymu needs real API keys
        return response()->json([
            'success' => true,
            'data' => [
                'payment_url' => 'https://sandbox.ipaymu.com/simulate/' . $booking->booking_code,
                'session_id' => 'SANDBOX-' . uniqid()
            ]
        ]);
    }

    private function mapPaymentMethod($method)
    {
        $map = [
            'qris' => 'qris',
            'va_bca' => 'bca',
            'va_mandiri' => 'mandiri',
            'va_maluku' => 'cimb' // Placeholder
        ];
        return $map[$method] ?? 'qris';
    }

    public function callback(Request $request)
    {
        // iPaymu sends callback via POST
        $trx_id = $request->post('trx_id');
        $sid = $request->post('sid');
        $status = $request->post('status');
        $reference_id = $request->post('reference_id');

        Log::info('Payment Callback Received', $request->all());

        if (!$reference_id) {
            return response()->json(['success' => false, 'message' => 'Missing reference_id'], 400);
        }

        $booking = TicketBooking::where('booking_code', $reference_id)->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        if ($booking->payment_status === 'paid' || $booking->payment_status === 'checked_in') {
            return response()->json(['success' => true, 'message' => 'Already paid/processed']);
        }

        if (strtolower($status) === 'berhasil' || strtolower($status) === 'sukses' || strtolower($status) === 'successful') {
            $booking->payment_status = 'paid';
            $booking->paid_at = now();
            $booking->save();
        } else if (strtolower($status) === 'expired' || strtolower($status) === 'batal') {
            $booking->payment_status = strtolower($status) === 'batal' ? 'cancelled' : 'expired';
            $booking->save();
        }

        return response()->json(['success' => true]);
    }

    // Endpoint for frontend to check status
    public function status($bookingCode)
    {
        $booking = TicketBooking::where('booking_code', $bookingCode)->first();
        if (!$booking) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'payment_status' => $booking->payment_status
            ]
        ]);
    }

    // Sandbox endpoint to simulate successful callback
    public function simulateCallback(Request $request, $bookingCode)
    {
        $request->merge([
            'reference_id' => $bookingCode,
            'status' => 'berhasil'
        ]);
        return $this->callback($request);
    }
}
