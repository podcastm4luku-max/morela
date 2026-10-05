<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Negeri Morella - Jelajah Pesona Morella (Hybrid)</title>
    <meta name="description" content="Portal Digital Pariwisata Desa Morela: Alam, Budaya & Masyarakat. Kolaborasi Program Pengabdian Mahasiswa Universitas Darussalam Ambon." />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Alpine.js untuk interaksi Blade statis -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Config untuk Blade CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Plus Jakarta Sans', 'sans-serif'],
              serif: ['Playfair Display', 'serif'],
              mono: ['JetBrains Mono', 'monospace'],
            }
          }
        }
      }
    </script>

    <!-- React SPA Assets -->
    @php
        $cssFiles = glob(public_path('assets/*.css'));
        $jsFiles = glob(public_path('assets/index-*.js'));
        $cssUrl = count($cssFiles) > 0 ? '/assets/' . basename($cssFiles[0]) : '';
        $jsUrl = count($jsFiles) > 0 ? '/assets/' . basename(end($jsFiles)) : '';
    @endphp
    @if($cssUrl)
        <link rel="stylesheet" crossorigin href="{{ $cssUrl }}">
    @endif
    @if($jsUrl)
        <script type="module" crossorigin src="{{ $jsUrl }}"></script>
    @endif
  </head>
  <body class="bg-stone-50 text-stone-900 antialiased font-sans selection:bg-emerald-100 selection:text-emerald-900 flex flex-col min-h-screen">
    
    <!-- Bagian 1: React SPA (Header, Main Content, Modals) -->
    <div id="root" class="flex-grow"></div>

    <!-- Bagian 2: Laravel Blade Footer (Hybrid Prototype) -->
    <footer x-data="{ expanded: false }" class="bg-stone-950 text-stone-300 border-t border-stone-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
          
          <!-- Column 1: Portal Identity -->
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-800 flex items-center justify-center text-white shadow-md border border-emerald-500/30">
                <!-- SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
              </div>
              <span class="font-serif text-xl font-bold tracking-tight text-white">
                NEGERI MORELA
              </span>
            </div>
            <p class="text-xs text-stone-400 leading-relaxed">
              Portal Digital Pariwisata Desa Morela: Media promosi keindahan alam pesisir, cagar budaya sakral, serta etalase produk UMKM kreatif masyarakat Leihitu, Maluku Tengah.
            </p>
            <div class="text-xs text-stone-400 pt-2 space-y-1">
              {{-- <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>Negeri Morela, Kec. Leihitu, Kab. Maluku Tengah, Maluku</span>
              </div>
              <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>+62 812-3456-7800 (Sekretariat Negeri)</span>
              </div> --}}
            </div>

            <!-- Social Media from Backend -->
            @if(isset($socialMedia) && $socialMedia->count() > 0)
              <div class="pt-2">
                <div class="text-[10px] font-semibold text-stone-500 uppercase tracking-wider mb-1.5">
                  Media Sosial Resmi:
                </div>
                <div class="flex flex-wrap gap-1.5">
                  @foreach($socialMedia as $s)
                    <a href="{{ $s->url }}" target="_blank" rel="noopener noreferrer" class="px-2 py-0.5 rounded-md bg-stone-900 border border-stone-800 hover:border-emerald-600/50 text-[10px] text-stone-400 hover:text-emerald-400 transition-colors inline-flex items-center gap-1" title="{{ $s->name }}">
                      <span>{{ $s->name }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            @endif
          </div>

          <!-- Column 2: Program Pengabdian -->
          <div class="space-y-4">
            <div class="flex items-center gap-2 text-sm font-semibold text-white uppercase tracking-wider">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
              <span>Program Pengabdian</span>
            </div>
            <div class="p-3.5 rounded-xl bg-stone-900 border border-stone-800 space-y-2 cursor-pointer hover:bg-stone-800/80 transition-colors" @click="expanded = !expanded">
              <div class="text-xs font-semibold text-emerald-400 flex items-center justify-between">
                UNIVERSITAS DARUSSALAM AMBON
                <span x-show="!expanded" class="text-xs opacity-50">+</span>
                <span x-show="expanded" class="text-xs opacity-50" x-cloak>-</span>
              </div>
              <p class="text-[11px] text-stone-300 leading-relaxed">
                Program Pengabdian Masyarakat Mahasiswa: "Digitalisasi Potensi Pariwisata dan Ekonomi Kreatif Desa Morela".
              </p>
              <div x-show="expanded" x-transition class="pt-2 mt-2 border-t border-stone-700">
                <p class="text-[10px] text-stone-400">Tim Mahasiswa Pengabdian Batch 2026 yang diinisiasi untuk memberikan dorongan teknologi ke pariwisata Desa Morela.</p>
              </div>
            </div>
          </div>

          <!-- Column 3: Navigasi Cepat (Disabled in Hybrid Prototype) -->
          <div class="space-y-4">
            <div class="text-sm font-semibold text-white uppercase tracking-wider">
              Navigasi Pintar
            </div>
            <ul class="space-y-2 text-xs">
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'destinations' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Destinasi Wisata Unggulan</button></li>
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'tickets' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Pemesanan E-Tiket Wisata</button></li>
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'culture' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Arsip Budaya & Tradisi Pukul Sapu</button></li>
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'umkm' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Katalog UMKM & Oleh-oleh</button></li>
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'map' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Peta Interaktif Leihitu</button></li>
              <li><button onclick="window.dispatchEvent(new CustomEvent('changeReactView', { detail: { view: 'admin' } }))" class="hover:text-emerald-400 transition-colors cursor-pointer">Dashboard Pengelola Desa</button></li>
            </ul>
            <p class="text-[9px] text-emerald-500/70 italic">*Navigasi ini sekarang terhubung ke SPA React via Custom Event API.</p>
          </div>

          <!-- Column 4: Statistik & Informasi Kunjungan -->
          <div class="space-y-4">
            <div class="text-sm font-semibold text-white uppercase tracking-wider">
              Statistik Portal
            </div>
            <div class="p-3.5 rounded-xl bg-stone-900 border border-stone-800 space-y-2">
              <div class="text-[11px] text-stone-400">
                Kunjungan Bulan Ini (Server-side)
              </div>
              <div class="font-mono text-2xl font-bold text-white tabular-nums tracking-tight">
                2.845
              </div>
              <div class="w-full bg-stone-800 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full w-[85%] rounded-full"></div>
              </div>
              <p class="text-[10px] text-stone-400">
                Tingkat kunjungan wisatawan meningkat 140%
              </p>
            </div>
          </div>
        </div>

        </div>
    </footer>

  </body>
</html>
