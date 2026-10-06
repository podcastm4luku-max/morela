<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - Negeri Morella')</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
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
</head>
<body class="bg-stone-100 text-stone-900 font-sans antialiased min-h-screen flex flex-col">

    <!-- Top Admin Bar -->
    <header class="bg-stone-900 border-b border-stone-800 text-stone-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" title="Kembali ke Portal Publik">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold shadow-xs">
                            M
                        </div>
                        <div>
                            <div class="font-serif font-bold text-sm text-white tracking-wide">NEGERI MORELLA</div>
                            <div class="text-[10px] text-emerald-400 font-medium">Panel Administrasi & Pengelola</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3 text-xs">
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-stone-300 hover:text-white hover:bg-stone-800 border border-stone-700/60 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Lihat Website</span>
                    </a>
                    <div class="h-4 w-px bg-stone-700 hidden sm:block"></div>
                    <span class="px-2.5 py-1 bg-stone-800 text-stone-300 rounded-md text-[11px] font-medium border border-stone-700">
                        Admin Negeri Morella & UNIDAR
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Main Body with Sidebar Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1 w-full grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Sidebar Admin Navigation -->
        <aside class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-stone-200/80 p-4 shadow-xs sticky top-22 space-y-4">
                
                <div class="px-3 py-2 bg-stone-50 rounded-xl border border-stone-100 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center">
                        ADM
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-bold text-stone-800 truncate">Pemerintah Negeri Morella</div>
                        <div class="text-[10px] text-stone-500 truncate">Pokdarwis & Tim UNIDAR</div>
                    </div>
                </div>

                <nav class="space-y-1 text-xs font-medium">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }} transition-colors">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-700' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
                        <span>Dashboard Utama</span>
                    </a>

                    <!-- Destinasi Wisata -->
                    <a href="{{ route('destinations.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-stone-600 hover:bg-stone-50 hover:text-stone-900 transition-colors">
                        <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor"/></svg>
                        <span>Destinasi Wisata</span>
                    </a>

                    <!-- E-Tiket & Loket -->
                    <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl {{ request()->routeIs('admin.tickets.*') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }} transition-colors">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.tickets.*') ? 'text-emerald-700' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="2" y="6" width="20" height="12" rx="2" stroke-width="2"/><path d="M10 6v12M14 6v12" stroke-dasharray="2 2"/></svg>
                        <span>E-Tiket & Pembayaran</span>
                    </a>

                    <!-- 🌟 MENU MEDIA SOSIAL (BARU SESUAI TUGAS) -->
                    <a href="{{ route('admin.social-media.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl {{ request()->routeIs('admin.social-media.*') ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-stone-700 hover:bg-stone-100 hover:text-stone-900 font-semibold' }} transition-all">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.social-media.*') ? 'text-white' : 'text-stone-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="18" cy="5" r="3" stroke-width="2"/>
                                <circle cx="6" cy="12" r="3" stroke-width="2"/>
                                <circle cx="18" cy="19" r="3" stroke-width="2"/>
                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/>
                                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/>
                            </svg>
                            <span>Media Sosial</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.social-media.*') ? 'bg-emerald-700 text-emerald-100' : 'bg-stone-100 text-stone-500' }}">
                            Baru
                        </span>
                    </a>

                    <!-- UMKM & Produk -->
                    <a href="{{ route('umkm.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-stone-600 hover:bg-stone-50 hover:text-stone-900 transition-colors">
                        <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>UMKM & Kuliner</span>
                    </a>

                    <!-- Warta & Berita -->
                    <a href="{{ route('news.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-stone-600 hover:bg-stone-50 hover:text-stone-900 transition-colors">
                        <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Warta Desa & KKN</span>
                    </a>

                    <!-- Budaya & Tradisi -->
                    <a href="{{ route('culture.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-stone-600 hover:bg-stone-50 hover:text-stone-900 transition-colors">
                        <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        <span>Arsip Budaya</span>
                    </a>

                    <!-- Galeri Gambar -->
                    <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl {{ request()->routeIs('admin.gallery.*') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }} transition-colors">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.gallery.*') ? 'text-emerald-700' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Data Gambar</span>
                    </a>

                    <!-- Galeri Video -->
                    <a href="{{ route('admin.gallery-videos.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl {{ request()->routeIs('admin.gallery-videos.*') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }} transition-colors">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.gallery-videos.*') ? 'text-emerald-700' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>Data Video</span>
                    </a>
                </nav>

                <div class="pt-3 border-t border-stone-100 text-[11px] text-stone-400">
                    <p class="font-medium text-stone-600">Sistem Versi 2.4</p>
                    <p>Negeri Morella & Universitas Darussalam Ambon</p>
                </div>
            </div>
        </aside>

        <!-- Right Main View Content Area -->
        <main class="lg:col-span-9 space-y-6">
            
            <!-- Session Flash Alerts -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl text-xs sm:text-sm shadow-xs">
                    <div class="font-semibold mb-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Harap periksa kesalahan input berikut:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-amber-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Admin Footer -->
    <footer class="bg-stone-900 text-stone-400 border-t border-stone-800 text-xs py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div>© {{ date('Y') }} Negeri Morella. Sistem Pengelolaan Informasi & Promosi Wisata Negeri Morella.</div>
            <div class="text-[11px] text-stone-500">Program Pengabdian KKN UNIDAR Ambon</div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
