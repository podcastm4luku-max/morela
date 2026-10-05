@extends('layouts.app')

@section('title', 'E-Tiket Resmi - ' . $booking->booking_code)

@section('content')
<div class="max-w-xl mx-auto px-4 py-12 space-y-6">

    <div class="bg-white rounded-3xl border border-stone-200 shadow-2xl overflow-hidden text-stone-900">
        
        <!-- Header Boarding Pass -->
        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-stone-900 text-white p-6 pb-8">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] uppercase font-semibold tracking-widest text-emerald-300">
                        PEMERINTAH NEGERI MORELA & POKDARWIS
                    </span>
                    <h2 class="font-serif text-2xl font-bold tracking-tight text-white">E-TIKET WISATA RESMI</h2>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase bg-emerald-500/20 text-emerald-200 border border-emerald-400/40">
                    {{ $booking->payment_status === 'paid' ? 'LUNAS (CONFIRMED)' : ($booking->payment_status === 'checked_in' ? 'CHECKED-IN' : 'PENDING') }}
                </span>
            </div>

            <div class="mt-4">
                <div class="text-[10px] text-stone-300 uppercase">KODE BOOKING</div>
                <div class="font-mono text-xl font-bold text-amber-300 tracking-wider">
                    {{ $booking->booking_code }}
                </div>
            </div>
        </div>

        <!-- Tear line -->
        <div class="relative flex items-center justify-between px-6 -my-3 z-10">
            <div class="w-6 h-6 rounded-full bg-stone-100 -ml-9 border border-stone-300"></div>
            <div class="flex-1 border-b-2 border-dashed border-stone-300 mx-2"></div>
            <div class="w-6 h-6 rounded-full bg-stone-100 -mr-9 border border-stone-300"></div>
        </div>

        <!-- Ticket Body Details -->
        <div class="p-6 sm:p-7 space-y-6 pt-6">
            <div class="space-y-1">
                <div class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">Destinasi Wisata</div>
                <h3 class="font-serif text-xl font-bold text-stone-900">{{ $booking->destination->name }}</h3>
                <p class="text-xs text-stone-500">{{ $booking->destination->location }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-stone-50 border border-stone-200 text-xs">
                <div>
                    <div class="text-[10px] text-stone-400 uppercase font-semibold">TANGGAL WISATA</div>
                    <div class="font-semibold text-stone-800 text-sm mt-0.5">{{ $booking->visit_date->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-stone-400 uppercase font-semibold">NAMA PENGUNJUNG</div>
                    <div class="font-semibold text-stone-800 text-sm mt-0.5 truncate">{{ $booking->visitor_name }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-stone-400 uppercase font-semibold">JUMLAH TIKET</div>
                    <div class="font-medium text-stone-800 mt-0.5">{{ $booking->adult_count }} Dewasa {{ $booking->child_count > 0 ? "· {$booking->child_count} Anak" : '' }}</div>
                </div>
                <div>
                    <div class="text-[10px] text-stone-400 uppercase font-semibold">TOTAL BAYAR</div>
                    <div class="font-mono font-bold text-emerald-800 text-sm mt-0.5">{{ $booking->formatted_total }}</div>
                </div>
            </div>

            <!-- Barcode & QR Validator -->
            <div class="p-4 bg-stone-50 rounded-2xl border border-stone-200 flex flex-col items-center justify-center space-y-2">
                <div class="w-32 h-32 bg-white p-2 rounded-lg border border-stone-200 flex items-center justify-center shadow-xs">
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

                        <rect x="38" y="38" width="8" height="8" fill="#0f172a" />
                        <rect x="52" y="38" width="6" height="6" fill="#047857" />
                        <rect x="42" y="52" width="6" height="6" fill="#047857" />
                        <rect x="54" y="52" width="8" height="8" fill="#0f172a" />
                    </svg>
                </div>
                <div class="font-mono text-xs text-stone-500">{{ $booking->qr_validation_code }}</div>
                <p class="text-[10px] text-stone-400 text-center">Tunjukkan tiket ini kepada petugas di loket masuk Negeri Morela.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-5 bg-stone-50 border-t border-stone-200 flex items-center justify-between">
            <button onclick="window.print()" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white rounded-xl text-xs font-semibold transition-colors">
                Cetak E-Tiket (Print / PDF)
            </button>
            <a href="{{ route('home') }}" class="text-xs text-stone-600 hover:text-emerald-700 font-medium">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</div>
@endsection
