@extends('layouts.app')

@section('title', 'Pesan E-Tiket Wisata - Morela Tourism')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-10">

    <div class="space-y-3 max-w-3xl">
        <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">SISTEM RESERVASI ONLINE</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 tracking-tight">
            Pemesanan E-Tiket Wisata Desa Morela
        </h1>
        <p class="text-sm text-stone-600">
            Dapatkan tiket masuk resmi tanpa antre di loket. Mendukung pembayaran instan melalui QRIS Nasional (Bank Maluku Malut, BCA, BRI, Mandiri, e-Wallet) dan Virtual Account.
        </p>
    </div>

    <!-- Booking Form & Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7">
            <form action="{{ route('tickets.store') }}" method="POST" class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs space-y-6">
                @csrf

                <!-- Step 1: Destinasi -->
                <div class="space-y-3">
                    <label class="text-xs font-semibold text-stone-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px]">1</span>
                        <span>Pilih Destinasi Wisata</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($destinations as $dest)
                            <label class="relative flex items-start gap-3 p-3.5 rounded-2xl border cursor-pointer hover:bg-stone-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                                <input type="radio" name="destination_id" value="{{ $dest->id }}" class="mt-1 text-emerald-600 focus:ring-emerald-500" {{ (old('destination_id', $selectedDestinationId) == $dest->id) ? 'checked' : '' }} required>
                                <div>
                                    <div class="font-serif font-bold text-xs text-stone-900">{{ $dest->name }}</div>
                                    <div class="font-mono text-xs font-semibold text-emerald-800">{{ $dest->formatted_price }}</div>
                                    <div class="text-[10px] text-stone-400">{{ $dest->visiting_hours }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2: Tanggal & Jumlah Pengunjung -->
                <div class="space-y-3 pt-4 border-t border-stone-100">
                    <label class="text-xs font-semibold text-stone-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px]">2</span>
                        <span>Tanggal & Jumlah Pengunjung</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Tanggal Kunjungan</span>
                            <input type="date" name="visit_date" min="{{ date('Y-m-d') }}" value="{{ old('visit_date', date('Y-m-d')) }}" class="w-full px-3 py-2 bg-stone-50 border border-stone-200 rounded-xl font-medium focus:border-emerald-600" required>
                        </div>
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Pengunjung Dewasa</span>
                            <input type="number" name="adult_count" min="1" max="50" value="{{ old('adult_count', 2) }}" class="w-full px-3 py-2 bg-stone-50 border border-stone-200 rounded-xl font-mono font-bold focus:border-emerald-600" required>
                        </div>
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Anak-anak (&lt; 10 Thn)</span>
                            <input type="number" name="child_count" min="0" max="50" value="{{ old('child_count', 0) }}" class="w-full px-3 py-2 bg-stone-50 border border-stone-200 rounded-xl font-mono focus:border-emerald-600">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Data Pengunjung -->
                <div class="space-y-3 pt-4 border-t border-stone-100">
                    <label class="text-xs font-semibold text-stone-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px]">3</span>
                        <span>Data Kontak Pemesan</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Nama Lengkap *</span>
                            <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" placeholder="Contoh: Muhammad Ramli" class="w-full px-3 py-2 border border-stone-200 rounded-xl bg-stone-50 focus:border-emerald-600" required>
                        </div>
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Nomor WhatsApp / HP *</span>
                            <input type="tel" name="visitor_phone" value="{{ old('visitor_phone') }}" placeholder="081234567890" class="w-full px-3 py-2 border border-stone-200 rounded-xl bg-stone-50 focus:border-emerald-600 font-mono" required>
                        </div>
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Email</span>
                            <input type="email" name="visitor_email" value="{{ old('visitor_email') }}" placeholder="ramli@gmail.com" class="w-full px-3 py-2 border border-stone-200 rounded-xl bg-stone-50 focus:border-emerald-600">
                        </div>
                        <div>
                            <span class="font-semibold text-stone-600 block mb-1">Asal Domisili</span>
                            <input type="text" name="visitor_city" value="{{ old('visitor_city', 'Kota Ambon') }}" class="w-full px-3 py-2 border border-stone-200 rounded-xl bg-stone-50 focus:border-emerald-600">
                        </div>
                    </div>
                </div>

                <!-- Step 4: Metode Bayar -->
                <div class="space-y-3 pt-4 border-t border-stone-100">
                    <label class="text-xs font-semibold text-stone-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px]">4</span>
                        <span>Metode Pembayaran</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <label class="p-3.5 rounded-2xl border cursor-pointer hover:bg-stone-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                            <input type="radio" name="payment_method" value="qris" checked class="text-emerald-600">
                            <div class="font-bold text-stone-900 mt-1">QRIS Instan</div>
                            <div class="text-[10px] text-stone-500">Bank Maluku Malut, BCA, BRI, GoPay, OVO.</div>
                        </label>
                        <label class="p-3.5 rounded-2xl border cursor-pointer hover:bg-stone-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                            <input type="radio" name="payment_method" value="va_bca" class="text-emerald-600">
                            <div class="font-bold text-stone-900 mt-1">Virtual Account</div>
                            <div class="text-[10px] text-stone-500">Transfer otomatis ATM / M-Banking.</div>
                        </label>
                        <label class="p-3.5 rounded-2xl border cursor-pointer hover:bg-stone-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                            <input type="radio" name="payment_method" value="cash_on_site" class="text-emerald-600">
                            <div class="font-bold text-stone-900 mt-1">Bayar di Lokasi</div>
                            <div class="text-[10px] text-stone-500">Tunai di pos loket masuk Morela.</div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-200 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-xl text-sm shadow-xs transition-colors">
                        Lanjutkan ke Pembayaran →
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Retribusi & Keuntungan -->
        <div class="lg:col-span-5 space-y-6">
            <div class="p-6 bg-white rounded-3xl border border-stone-200 shadow-xs space-y-4 text-xs">
                <div class="font-serif text-lg font-bold text-stone-900">Rincian Retribusi Resmi</div>
                <div class="space-y-2 text-stone-600">
                    <div class="flex justify-between">
                        <span>Biaya Kebersihan & Asuransi Pesisir:</span>
                        <span class="font-mono font-bold text-stone-900">Rp 2.000 / transaksi</span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-relaxed">
                        Dana retribusi dikelola secara transparan oleh Pemerintah Negeri Morela untuk kelestarian alam dan keselamatan pengunjung.
                    </p>
                </div>
            </div>

            <div class="p-6 bg-stone-900 text-white rounded-3xl space-y-3 text-xs">
                <div class="font-bold text-amber-400 uppercase text-[10px]">Cek Status Tiket Anda</div>
                <p class="text-stone-300 text-[11px]">Sudah pernah memesan tiket sebelumnya? Masukkan kode booking untuk cetak e-tiket:</p>
                <form action="{{ route('tickets.check') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="search_query" placeholder="MOR-XXXX-XXXX" class="flex-1 px-3 py-2 bg-stone-800 border border-stone-700 rounded-xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500" required>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-semibold">Cari</button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
