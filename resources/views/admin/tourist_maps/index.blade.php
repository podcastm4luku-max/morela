@extends('layouts.admin')

@section('title', 'Peta Wisata & Jelajah Negeri Morela - Admin Dashboard')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="p-6 bg-white rounded-3xl border border-stone-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 uppercase tracking-widest mb-1">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor"/></svg>
                <span>Sistem Informasi Geografis & Navigasi Wisata</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 tracking-tight">
                Peta Wisata & Jelajah Negeri Morela
            </h1>
            <p class="text-xs text-stone-500 mt-1 max-w-2xl">
                Kelola titik koordinat destinasi wisata alam, pantai, sejarah, sentra UMKM, dan susun rute perjalanan interaktif terpadu dengan Google Maps.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.tourist-destinations.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Tambah Destinasi</span>
            </a>
            <a href="{{ route('admin.tourist-routes.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                <span>+ Buat Rute Wisata</span>
            </a>
            <a href="{{ route('map.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold transition-colors">
                <span>Buka Peta Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- API Key Notice Banner if empty -->
    @if(empty($googleMapsApiKey))
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div class="text-xs text-amber-900 space-y-1">
                <div class="font-bold">Google Maps API belum dikonfigurasi</div>
                <p>
                    Silakan tambahkan <code class="bg-amber-100 px-1.5 py-0.5 rounded font-mono text-amber-900 font-bold">GOOGLE_MAPS_API_KEY=your_key</code> pada berkas <code class="font-mono">.env</code> untuk mengaktifkan pemuatan peta Google Maps interaktif secara langsung. Sistem saat ini tetap aktif dan mendukung input koordinat serta navigasi eksternal Google Maps.
                </p>
            </div>
        </div>
    @endif

    <!-- 4 KPI Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Total Destinasi</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $stats['total_destinations'] }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">{{ $stats['active_destinations'] }} Destinasi Aktif Tayang</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Rute Perjalanan</div>
            <div class="font-mono text-3xl font-bold text-stone-900">{{ $stats['total_routes'] }}</div>
            <div class="text-[11px] text-emerald-700 font-medium">{{ $stats['active_routes'] }} Rute Aktif</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Pusat Wilayah</div>
            <div class="font-mono text-sm font-bold text-stone-900 truncate">Negeri Morella</div>
            <div class="text-[11px] text-stone-500 font-mono">-3.5512, 128.2045</div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-stone-200/80 shadow-xs space-y-1">
            <div class="text-[11px] font-semibold uppercase text-stone-400">Integrasi Peta</div>
            <div class="font-mono text-sm font-bold text-emerald-800 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Google Maps Ready</span>
            </div>
            <div class="text-[11px] text-stone-500">Navigasi Dinamis GPS</div>
        </div>
    </div>

    <!-- Interactive Map Preview -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-serif text-lg font-bold text-stone-900">
                    Pratinjau Peta Spasial Destinasi & Rute
                </h2>
                <p class="text-xs text-stone-500">
                    Marker lokasi dan rute yang telah disimpan di database.
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Destinasi Wisata</span>
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Rute Perjalanan</span>
                </span>
            </div>
        </div>

        <div id="admin-overview-map" class="w-full h-80 sm:h-96 rounded-2xl bg-stone-100 border border-stone-200 overflow-hidden relative">
            <div id="map-fallback-banner" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center text-stone-500 bg-stone-100">
                <svg class="w-12 h-12 text-stone-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor"/></svg>
                <div class="font-bold text-stone-800 text-sm">Peta Interaktif Morela</div>
                <p class="text-xs text-stone-500 max-w-md mt-1">
                    {{ count($destinations) }} destinasi dan {{ count($routes) }} rute terdaftar di sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Links between Destinations & Routes Management -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Kelola Destinasi -->
        <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-stone-900">Kelola Destinasi Wisata</h3>
                <p class="text-xs text-stone-500 leading-relaxed">
                    Atur titik koordinat GPS, foto, deskripsi, alamat, dan urutan destinasi yang akan ditampilkan di peta publik.
                </p>
            </div>
            <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                <span class="text-xs text-stone-500 font-mono">{{ $stats['total_destinations'] }} Destinasi Terdaftar</span>
                <a href="{{ route('admin.tourist-destinations.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white text-xs font-semibold transition-colors shadow-xs">
                    <span>Buka Kelola Destinasi</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Card Kelola Rute Wisata -->
        <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-stone-900">Kelola Rute Perjalanan Wisata</h3>
                <p class="text-xs text-stone-500 leading-relaxed">
                    Susun rute perjalanan multi-destinasi dengan estimasi jarak, durasi waktu tempuh, dan navigasi multi-waypoint otomatis Google Maps.
                </p>
            </div>
            <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                <span class="text-xs text-stone-500 font-mono">{{ $stats['total_routes'] }} Rute Terdaftar</span>
                <a href="{{ route('admin.tourist-routes.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold transition-colors shadow-xs">
                    <span>Buka Kelola Rute</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>

@if(!empty($googleMapsApiKey))
<script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&libraries=places&callback=initAdminOverviewMap" async defer></script>
<script>
function initAdminOverviewMap() {
    const fallback = document.getElementById('map-fallback-banner');
    if (fallback) fallback.style.display = 'none';

    const morelaCenter = { lat: -3.5512, lng: 128.2045 };
    const map = new google.maps.Map(document.getElementById('admin-overview-map'), {
        center: morelaCenter,
        zoom: 13,
        mapTypeId: 'terrain',
        mapTypeControl: false,
    });

    const destinations = @json($destinations);
    const bounds = new google.maps.LatLngBounds();
    let hasCoords = false;

    destinations.forEach(dest => {
        if (dest.latitude && dest.longitude) {
            hasCoords = true;
            const pos = { lat: parseFloat(dest.latitude), lng: parseFloat(dest.longitude) };
            bounds.extend(pos);

            const marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: dest.name,
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                }
            });

            const infoContent = `
                <div style="font-family: sans-serif; padding: 4px; max-width: 220px;">
                    <strong style="color: #065f46; font-size: 13px;">${dest.name}</strong>
                    <p style="font-size: 11px; color: #57534e; margin: 4px 0;">${dest.address || 'Negeri Morela'}</p>
                    <a href="${dest.google_maps_url || 'https://www.google.com/maps/dir/?api=1&destination=' + dest.latitude + ',' + dest.longitude}" target="_blank" style="font-size: 11px; color: #047857; text-decoration: underline; font-weight: bold;">
                        Mulai Navigasi ➔
                    </a>
                </div>
            `;
            const infoWindow = new google.maps.InfoWindow({ content: infoContent });
            marker.addListener('click', () => infoWindow.open(map, marker));
        }
    });

    if (hasCoords) {
        map.fitBounds(bounds);
    }
}
</script>
@endif

@endsection
