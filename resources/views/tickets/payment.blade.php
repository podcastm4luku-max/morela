@extends('layouts.app')

@section('title', 'Pembayaran QRIS E-Tiket -Negeri  Morella')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12 space-y-6">

    <div class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-stone-200">
            <div>
                <span class="text-[10px] font-semibold text-amber-700 uppercase tracking-wider">MENUNGGU PEMBAYARAN</span>
                <h2 class="font-serif text-2xl font-bold text-stone-900 mt-0.5">Selesaikan Pembayaran E-Tiket</h2>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-stone-400 block">Status:</span>
                <span class="font-bold text-amber-600 text-xs uppercase px-2 py-0.5 rounded bg-amber-50 border border-amber-200">
                    {{ strtoupper($booking->payment_status) }}
                </span>
            </div>
        </div>

        <!-- Terminal QRIS -->
        <div class="p-6 bg-stone-50 rounded-2xl border border-stone-200 flex flex-col items-center justify-center space-y-4">
            <div class="font-bold text-stone-900 text-sm tracking-widest">
                QRIS · STANDAR PEMBAYARAN NASIONAL
            </div>

            <!-- SVG QR Matrix -->
            <div class="w-56 h-56 bg-white p-4 rounded-2xl border-2 border-stone-300 shadow-sm flex flex-col items-center justify-center relative">
                <svg viewBox="0 0 100 100" class="w-full h-full text-stone-900" fill="currentColor">
                    <rect x="5" y="5" width="28" height="28" rx="2" fill="#047857" />
                    <rect x="10" y="10" width="18" height="18" fill="white" />
                    <rect x="14" y="14" width="10" height="10" fill="#047857" />

                    <rect x="67" y="5" width="28" height="28" rx="2" fill="#047857" />
                    <rect x="72" y="10" width="18" height="18" fill="white" />
                    <rect x="76" y="14" width="10" height="10" fill="#047857" />

                    <rect x="5" y="67" width="28" height="28" rx="2" fill="#047857" />
                    <rect x="10" y="72" width="18" height="18" fill="white" />
                    <rect x="14" y="76" width="10" height="10" fill="#047857" />

                    <rect x="36" y="12" width="6" height="6" fill="#0f172a" />
                    <rect x="48" y="12" width="6" height="6" fill="#047857" />
                    <rect x="36" y="38" width="8" height="8" fill="#0f172a" />
                    <rect x="48" y="38" width="6" height="6" fill="#047857" />
                    <rect x="60" y="38" width="8" height="8" fill="#0f172a" />
                    <rect x="38" y="52" width="8" height="8" fill="#047857" />
                    <rect x="52" y="52" width="8" height="8" fill="#0f172a" />
                    <circle cx="50" cy="50" r="8" fill="white" stroke="#047857" stroke-width="2" />
                    <circle cx="50" cy="50" r="4" fill="#047857" />
                </svg>
            </div>

            <div class="text-center space-y-1">
                <div class="text-xs font-semibold text-stone-800">
                    Merchant: <span class="text-emerald-800">POKDARWIS NEGERI MORELLA</span>
                </div>
                <div class="font-mono text-2xl font-bold text-stone-900">
                    {{ $booking->formatted_total }}
                </div>
                <div class="text-xs text-stone-500 font-mono">
                    Kode Booking: <strong>{{ $booking->booking_code }}</strong>
                </div>
            </div>
        </div>

        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-900 space-y-1">
            <div class="font-semibold">Petunjuk Pembayaran:</div>
            <p>1. Buka Mobile Banking (Bank Maluku Malut, BCA, BRI, Mandiri) atau e-Wallet (GoPay, OVO, Dana).</p>
            <p>2. Pindai kode QRIS di atas lalu pastikan nama penerima <strong>POKDARWIS NEGERI MORELLA</strong>.</p>
            <p>3. Setelah transfer berhasil, klik tombol konfirmasi di bawah ini.</p>
        </div>

        <!-- Form Konfirmasi -->
        <form action="{{ route('tickets.confirm', $booking->booking_code) }}" method="POST" class="pt-2">
            @csrf
            <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-xl text-sm shadow-xs transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Saya Sudah Bayar (Konfirmasi Pembayaran)</span>
            </button>
        </form>
    </div>

</div>
@endsection
