<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\TicketBooking;

class TicketController extends Controller
{
    /**
     * Tampilkan formulir pemesanan e-tiket wisata
     */
    public function index(Request $request)
    {
        $destinations = Destination::where('published', true)->get();
        $selectedDestinationId = $request->query('destination_id', $destinations->first()?->id);
        
        return view('tickets.booking', compact('destinations', 'selectedDestinationId'));
    }

    /**
     * Simpan reservasi tiket baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'required|string|max:20',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_city' => 'nullable|string|max:100',
            'adult_count' => 'required|integer|min:1|max:50',
            'child_count' => 'nullable|integer|min:0|max:50',
            'payment_method' => 'required|in:qris,va_maluku,va_bca,va_mandiri,cash_on_site',
        ]);

        $destination = Destination::findOrFail($validated['destination_id']);
        $adultCount = (int) $validated['adult_count'];
        $childCount = (int) ($validated['child_count'] ?? 0);
        $pricePerTicket = $destination->ticket_price;
        $cleanlinessFee = 2000;

        $subtotal = ($adultCount * $pricePerTicket) + ($childCount * round($pricePerTicket * 0.5));
        $totalAmount = $subtotal + $cleanlinessFee;

        $bookingCode = TicketBooking::generateBookingCode();
        $qrValidationCode = "VALID-{$bookingCode}";

        $booking = TicketBooking::create([
            'booking_code' => $bookingCode,
            'destination_id' => $destination->id,
            'visit_date' => $validated['visit_date'],
            'visitor_name' => $validated['visitor_name'],
            'visitor_phone' => $validated['visitor_phone'],
            'visitor_email' => $validated['visitor_email'],
            'visitor_city' => $validated['visitor_city'] ?? 'Kota Ambon',
            'adult_count' => $adultCount,
            'child_count' => $childCount,
            'price_per_ticket' => $pricePerTicket,
            'cleanliness_fee' => $cleanlinessFee,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'cash_on_site' ? 'pending' : 'pending',
            'qr_validation_code' => $qrValidationCode,
        ]);

        return redirect()->route('tickets.payment', $booking->booking_code)
            ->with('success', 'Reservasi berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    /**
     * Halaman instruksi & pembayaran QRIS / Virtual Account
     */
    public function payment($booking_code)
    {
        $booking = TicketBooking::with('destination')->where('booking_code', $booking_code)->firstOrFail();
        return view('tickets.payment', compact('booking'));
    }

    /**
     * Konfirmasi simulasi pembayaran lunas
     */
    public function confirmPayment($booking_code)
    {
        $booking = TicketBooking::where('booking_code', $booking_code)->firstOrFail();
        
        $booking->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('tickets.show', $booking->booking_code)
            ->with('success', 'Pembayaran QRIS berhasil dikonfirmasi! E-Tiket Anda siap digunakan.');
    }

    /**
     * Tampilan E-Tiket boarding pass resmi (Bisa dicetak / disimpan PDF)
     */
    public function show($booking_code)
    {
        $booking = TicketBooking::with('destination')->where('booking_code', $booking_code)->firstOrFail();
        return view('tickets.show', compact('booking'));
    }

    /**
     * Cari tiket berdasarkan kode booking atau nomor telepon
     */
    public function checkStatus(Request $request)
    {
        $request->validate(['search_query' => 'required|string']);
        $query = trim($request->input('search_query'));

        $booking = TicketBooking::with('destination')
            ->where('booking_code', strtoupper($query))
            ->orWhere('visitor_phone', 'like', "%{$query}%")
            ->first();

        if (!$booking) {
            return back()->with('error', "Tiket dengan kode atau nomor '{$query}' tidak ditemukan.");
        }

        return redirect()->route('tickets.show', $booking->booking_code);
    }
}
