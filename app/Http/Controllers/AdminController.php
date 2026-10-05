<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\TicketBooking;
use App\Models\SocialMedia;
use App\Models\GalleryVideo;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDestinations = Destination::count();
        $totalBookings = TicketBooking::count();
        $totalRevenue = TicketBooking::whereIn('payment_status', ['paid', 'checked_in'])->sum('total_amount');
        $checkedInCount = TicketBooking::where('payment_status', 'checked_in')->count();
        $recentBookings = TicketBooking::with('destination')->latest()->take(6)->get();

        // Data Media Sosial untuk Dashboard Utama
        $availableSocialMedia = SocialMedia::ordered()->get();
        $totalActiveSocial = SocialMedia::where('is_active', true)->count();

        // Data Video Galeri (Maks. 500MB) untuk Dashboard Utama
        $galleryVideos = GalleryVideo::published()->latest()->take(8)->get();
        $totalVideos = GalleryVideo::count();

        return view('admin.dashboard', compact(
            'totalDestinations',
            'totalBookings',
            'totalRevenue',
            'checkedInCount',
            'recentBookings',
            'availableSocialMedia',
            'totalActiveSocial',
            'galleryVideos',
            'totalVideos'
        ));
    }

    public function tickets()
    {
        $bookings = TicketBooking::with('destination')->latest()->paginate(15);
        $totalRevenue = TicketBooking::whereIn('payment_status', ['paid', 'checked_in'])->sum('total_amount');
        return view('admin.tickets', compact('bookings', 'totalRevenue'));
    }

    public function checkIn(Request $request)
    {
        $request->validate(['booking_code' => 'required|string']);
        $code = trim(strtoupper($request->booking_code));

        $booking = TicketBooking::where('booking_code', $code)->first();

        if (!$booking) {
            return back()->with('error', "Kode booking {$code} tidak ditemukan.");
        }

        if ($booking->payment_status === 'checked_in') {
            return back()->with('warning', "Pengunjung {$booking->visitor_name} sudah melakukan check-in sebelumnya pada {$booking->checked_in_at}.");
        }

        $booking->update([
            'payment_status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return back()->with('success', "Validasi berhasil! Pengunjung {$booking->visitor_name} ({$booking->adult_count} orang) telah di-check in.");
    }

    public function updateTicketStatus(Request $request, $id)
    {
        $booking = TicketBooking::findOrFail($id);
        $status = $request->validate(['status' => 'required|in:pending,paid,checked_in,cancelled'])['status'];

        $booking->update([
            'payment_status' => $status,
            'paid_at' => $status === 'paid' ? now() : $booking->paid_at,
        ]);

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }
}
