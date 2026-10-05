@extends('layouts.admin')

@section('title', 'Dashboard Utama - Admin Morela Tourism')

@section('content')
<div class="space-y-8">

    <!-- Welcome Header -->
    <div class="p-6 bg-white rounded-3xl border border-stone-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 uppercase tracking-widest mb-1">
                <span>Ringkasan Pengelolaan & Statistik Portal</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 tracking-tight">
                Selamat Datang di Dashboard Morella
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Pantau destinasi wisata, transaksi e-tiket retribusi, dan seluruh akun media sosial resmi desa secara terpadu.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.social-media.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition-colors">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="18" cy="5" r="3" stroke-width="2"/><circle cx="6" cy="12" r="3" stroke-width="2"/><circle cx="18" cy="19" r="3" stroke-width="2"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/></svg>
                <span>Kelola Media Sosial</span>
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="2" y="6" width="20" height="12" rx="2" stroke-width="2"/><path d="M10 6v12M14 6v12" stroke-dasharray="2 2"/></svg>
                <span>Loket E-Tiket</span>
            </a>
        </div>
    </div>

    <!-- Top KPI Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Total Destinasi</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $totalDestinations }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">Spot Wisata Leihitu</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Pemesanan Tiket</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $totalBookings }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">{{ $checkedInCount }} Pengunjung Check-In</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Pendapatan Retribusi</div>
            <div class="font-mono text-2xl sm:text-3xl font-bold text-stone-900 truncate">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <div class="text-[11px] text-emerald-700 font-medium">Kas PADes Morella</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Video Dokumentasi</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $totalVideos ?? $galleryVideos->count() }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">Video (Maks. 500MB)</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1 col-span-2 sm:col-span-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Media Sosial</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $totalActiveSocial }} / {{ $availableSocialMedia->count() }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">Saluran Aktif</div>
        </div>
    </div>

    <!-- 🌟 SEKSI MEDIA SOSIAL TERSEDIA DI DASHBOARD UTAMA (SESUAI REQUEST) -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-stone-100">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-emerald-700">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="18" cy="5" r="3" stroke-width="2"/>
                        <circle cx="6" cy="12" r="3" stroke-width="2"/>
                        <circle cx="18" cy="19" r="3" stroke-width="2"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/>
                    </svg>
                    <span>INTEGRASI MEDIA SOSIAL & INFORMASI DESA</span>
                </div>
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900">
                    Akun Media Sosial yang Tersedia
                </h2>
                <p class="text-xs text-stone-500">
                    Daftar akun media sosial resmi yang telah diinput via sistem CRUD dan tayang di website publik Morela Tourism.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.social-media.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition-colors"
                >
                    <span>Menu Media Sosial</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a 
                    href="{{ route('admin.social-media.create') }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Akun</span>
                </a>
            </div>
        </div>

        <!-- Grid of Available Social Media Cards -->
        @if($availableSocialMedia->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($availableSocialMedia as $soc)
                    <div class="p-4 rounded-2xl border border-stone-200 bg-stone-50/60 hover:bg-white hover:border-emerald-300 hover:shadow-xs transition-all flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs uppercase border {{ $soc->badge_color }}">
                                        {{ substr($soc->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-stone-900 text-xs flex items-center gap-1">
                                            <span>{{ $soc->name }}</span>
                                        </h3>
                                        <div class="text-[10px] text-stone-400 font-mono">
                                            {{ $soc->slug }}
                                        </div>
                                    </div>
                                </div>

                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $soc->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $soc->is_active ? 'bg-emerald-600' : 'bg-stone-400' }}"></span>
                                    <span>{{ $soc->is_active ? 'Aktif' : 'Draft' }}</span>
                                </span>
                            </div>

                            @if($soc->username)
                                <div class="px-2.5 py-1.5 bg-white rounded-lg border border-stone-200 text-[11px] font-mono text-stone-700 truncate">
                                    {{ $soc->username }}
                                </div>
                            @endif

                            @if($soc->description)
                                <p class="text-[11px] text-stone-500 line-clamp-2 leading-relaxed">
                                    {{ $soc->description }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-4 mt-3 border-t border-stone-200/60 flex items-center justify-between text-xs">
                            <span class="text-[10px] text-stone-400 font-mono">Urutan #{{ $soc->sort_order }}</span>
                            <div class="flex items-center gap-1.5">
                                <a 
                                    href="{{ $soc->url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    class="p-1.5 rounded-lg text-stone-500 hover:text-emerald-700 hover:bg-emerald-50 transition-colors"
                                    title="Kunjungi Tautan"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <a 
                                    href="{{ route('admin.social-media.edit', $soc->id) }}" 
                                    class="px-2 py-1 rounded-lg text-emerald-800 bg-emerald-50 hover:bg-emerald-100 font-semibold text-[11px] transition-colors"
                                >
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-stone-400 bg-stone-50 rounded-2xl border border-stone-200">
                <p class="text-xs">Belum ada akun media sosial yang ditambahkan.</p>
                <a href="{{ route('admin.social-media.create') }}" class="inline-block mt-2 text-xs font-semibold text-emerald-700 hover:underline">
                    + Tambah Akun Media Sosial Pertama
                </a>
            </div>
        @endif
    </div>

    <!-- 🎥 SEKSI VIDEO DOKUMENTASI TERKINI DI DASHBOARD UTAMA (SESUAI REQUEST) -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-stone-100">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-emerald-700">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polygon points="23 7 16 12 23 17 23 7"/>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                    </svg>
                    <span>DOKUMENTASI MULTIMEDIA WISATA</span>
                </div>
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-stone-900">
                    Video Galeri Dokumentasi (Maks. 500MB)
                </h2>
                <p class="text-xs text-stone-500">
                    Koleksi video promosi, tradisi Pukul Sapu, dan dokumenter kegiatan desa hasil pengelolaan CRUD galeri video.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.gallery-videos.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition-colors"
                >
                    <span>Menu Galeri Video</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a 
                    href="{{ route('admin.gallery-videos.create') }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Unggah Video (Maks. 500MB)</span>
                </a>
            </div>
        </div>

        @if(isset($galleryVideos) && $galleryVideos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($galleryVideos as $vid)
                    <div class="bg-stone-50 rounded-2xl border border-stone-200 overflow-hidden flex flex-col justify-between group hover:border-emerald-300 hover:bg-white hover:shadow-xs transition-all">
                        <div>
                            <div class="relative aspect-video bg-stone-900 overflow-hidden">
                                <img 
                                    src="{{ $vid->thumbnail_url ?: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80' }}" 
                                    alt="{{ $vid->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                    <a 
                                        href="{{ $vid->video_url }}" 
                                        target="_blank"
                                        class="w-10 h-10 rounded-full bg-emerald-600/90 text-white flex items-center justify-center shadow-md transform group-hover:scale-110 transition-transform"
                                        title="Putar Video"
                                    >
                                        <svg class="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    </a>
                                </div>
                                <div class="absolute bottom-1.5 right-1.5 px-1.5 py-0.5 bg-black/80 text-white text-[9px] font-mono rounded">
                                    {{ $vid->duration ?: '03:00' }}
                                </div>
                                <div class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-stone-900/90 text-amber-300 border border-stone-700 text-[9px] font-mono rounded">
                                    {{ $vid->file_size_mb }} MB
                                </div>
                            </div>

                            <div class="p-3.5 space-y-1.5">
                                <div class="text-[10px] text-emerald-700 font-semibold uppercase tracking-wider">
                                    {{ strtoupper($vid->category) }}
                                </div>
                                <h3 class="font-serif font-bold text-xs text-stone-900 line-clamp-1">
                                    {{ $vid->title }}
                                </h3>
                                @if($vid->description)
                                    <p class="text-[11px] text-stone-500 line-clamp-2 leading-relaxed">
                                        {{ $vid->description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 border-t border-stone-200/60 bg-white/50 flex items-center justify-between text-xs">
                            <a 
                                href="{{ $vid->video_url }}" 
                                target="_blank" 
                                class="text-emerald-700 hover:underline font-semibold text-[11px] flex items-center gap-1"
                            >
                                <span>Tonton Video</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a 
                                href="{{ route('admin.gallery-videos.edit', $vid->id) }}" 
                                class="text-stone-500 hover:text-emerald-800 text-[11px]"
                            >
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-stone-400 bg-stone-50 rounded-2xl border border-stone-200">
                <p class="text-xs">Belum ada video galeri yang diunggah.</p>
                <a href="{{ route('admin.gallery-videos.create') }}" class="inline-block mt-2 text-xs font-semibold text-emerald-700 hover:underline">
                    + Unggah Video Pertama (Maks. 500MB)
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Ticket Bookings Table -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 sm:p-8 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-lg font-bold text-stone-900">
                Transaksi E-Tiket Terbaru
            </h2>
            <a href="{{ route('admin.tickets.index') }}" class="text-xs text-emerald-700 font-semibold hover:underline">
                Lihat Seluruh Tiket →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-200/80 text-[11px] font-semibold text-stone-500 uppercase">
                        <th class="py-3 px-4">Kode Booking</th>
                        <th class="py-3 px-4">Destinasi</th>
                        <th class="py-3 px-4">Pengunjung</th>
                        <th class="py-3 px-4">Total Retribusi</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($recentBookings as $b)
                        <tr class="hover:bg-stone-50">
                            <td class="py-3 px-4 font-mono font-bold text-stone-800">{{ $b->booking_code }}</td>
                            <td class="py-3 px-4 text-stone-700">{{ $b->destination ? $b->destination->name : '-' }}</td>
                            <td class="py-3 px-4 text-stone-700">{{ $b->visitor_name }} ({{ $b->adult_count }} org)</td>
                            <td class="py-3 px-4 font-mono text-emerald-800 font-semibold">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $b->payment_status === 'checked_in' ? 'bg-emerald-100 text-emerald-800' : ($b->payment_status === 'paid' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ strtoupper($b->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-stone-400">Belum ada transaksi tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
