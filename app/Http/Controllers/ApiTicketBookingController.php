<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TicketBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTicketBookingController extends Controller
{
    // POST /api/tickets -> create new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'visit_date' => 'required|date',
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'required|string|max:50',
            'visitor_email' => 'nullable|email',
            'visitor_city' => 'nullable|string',
            'adult_count' => 'required|integer|min:1',
            'child_count' => 'required|integer|min:0',
            'payment_method' => 'required|string',
        ]);

        $destination = Destination::find($validated['destination_id']);
        if (! $destination) {
            return response()->json(['success' => false, 'message' => 'Destinasi tidak ditemukan.'], 404);
        }

        $price_per_ticket = $destination->ticket_price;
        $total_amount = ($validated['adult_count'] + $validated['child_count']) * $price_per_ticket;
        // Assume cleanliness_fee is 0 or handled here, we'll keep it simple

        $dateStr = date('ymd', strtotime($validated['visit_date']));
        $randomSuffix = rand(1000, 9999);
        $booking_code = "MOR-{$dateStr}-{$randomSuffix}";
        $qr_validation_code = "VALID-{$booking_code}-".Str::random(8);

        $booking = TicketBooking::create([
            'booking_code' => $booking_code,
            'destination_id' => $validated['destination_id'],
            'visit_date' => $validated['visit_date'],
            'visitor_name' => $validated['visitor_name'],
            'visitor_phone' => $validated['visitor_phone'],
            'visitor_email' => $validated['visitor_email'] ?? null,
            'visitor_city' => $validated['visitor_city'] ?? null,
            'adult_count' => $validated['adult_count'],
            'child_count' => $validated['child_count'],
            'price_per_ticket' => $price_per_ticket,
            'cleanliness_fee' => 0,
            'total_amount' => $total_amount,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'qr_validation_code' => $qr_validation_code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => $booking->load('destination'),
        ], 201);
    }

    // GET /api/tickets/{bookingCode}
    public function show($bookingCode)
    {
        $booking = TicketBooking::where('booking_code', $bookingCode)->with('destination')->first();
        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking,
        ]);
    }

    // --- PROTECTED ADMIN ROUTES ---

    // GET /api/admin/tickets
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => TicketBooking::with('destination')->latest()->get(),
        ]);
    }

    // POST /api/admin/tickets/validate (Scan QR)
    public function validateQr(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        // Format is often bookingCode or qr_validation_code depending on the QR
        // Let's check both
        $booking = TicketBooking::where('qr_validation_code', $request->qr_code)
            ->orWhere('booking_code', $request->qr_code)
            ->with('destination')
            ->first();

        if (! $booking) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau tiket tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tiket valid',
            'data' => $booking,
        ]);
    }

    // POST /api/admin/tickets/{bookingCode}/check-in
    public function checkIn($bookingCode)
    {
        $booking = TicketBooking::where('booking_code', $bookingCode)->first();

        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        if ($booking->payment_status === 'checked_in' || $booking->checked_in_at !== null) {
            return response()->json(['success' => false, 'message' => 'Ticket already used.'], 400);
        }

        $booking->payment_status = 'checked_in';
        $booking->checked_in_at = now();
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil check-in.',
            'data' => $booking->load('destination'),
        ]);
    }

    // PUT /api/admin/tickets/{bookingCode}/status
    public function updateStatus(Request $request, $bookingCode)
    {
        $request->validate(['status' => 'required|in:pending,paid,checked_in,cancelled']);

        $booking = TicketBooking::where('booking_code', $bookingCode)->first();

        if (! $booking) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        $booking->payment_status = $request->status;
        if ($request->status === 'checked_in') {
            $booking->checked_in_at = now();
        }
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah.',
            'data' => $booking->load('destination'),
        ]);
    }
}
