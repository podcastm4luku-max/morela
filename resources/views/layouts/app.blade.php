<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Morela Tourism - Jelajah Pesona Morela')</title>
    <meta name="description" content="Portal Digital Pariwisata Desa Morela: Alam, Budaya & Masyarakat. Kolaborasi Program Pengabdian Mahasiswa Universitas Darussalam Ambon.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite or CDN) -->
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
<body class="bg-stone-50 text-stone-900 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 flex flex-col min-h-screen">

    <!-- 🌴 NAVBAR UTAMA (Dengan Menu Tiket Wisata) -->
    <header class="sticky top-0 z-40 bg-stone-900/95 backdrop-blur-md border-b border-stone-800 text-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Zone 1: Brand Wordmark -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-800 flex items-center justify-center text-white shadow-md border border-emerald-500/30 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-serif text-lg sm:text-xl font-bold tracking-tight text-white">
                            MORELA TOURISM
                        </div>
                        <p class="text-[10px] text-stone-400 tracking-wide uppercase">
                            Leihitu · Maluku Tengah
                        </p>
                    </div>
                </a>

                <!-- Zone 2: Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('home') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        Beranda
                    </a>

                    <a href="{{ route('destinations.index') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('destinations.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        Destinasi
                    </a>

                    <!-- Fitur Pembayaran E-Tiket di Navbar Utama -->
                    <a href="{{ route('tickets.index') }}" class="px-3 py-1.5 rounded-lg flex items-center gap-1.5 {{ request()->routeIs('tickets.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <rect x="2" y="6" width="20" height="12" rx="2" stroke-width="2"/>
                            <path d="M10 6v12M14 6v12" stroke-dasharray="2 2"/>
                        </svg>
                        <span>Tiket Wisata</span>
                    </a>

                    <a href="{{ route('culture.index') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('culture.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        Budaya
                    </a>

                    <a href="{{ route('umkm.index') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('umkm.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        UMKM
                    </a>

                    <a href="{{ route('map.index') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('map.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}">
                        Peta Wisata
                    </a>

                    <!-- Menu Media Sosial di Navbar Utama -->
                    <a href="{{ route('admin.social-media.index') }}" class="px-3 py-1.5 rounded-lg flex items-center gap-1.5 {{ request()->routeIs('admin.social-media.*') ? 'text-emerald-400 font-semibold bg-stone-800/80' : 'text-stone-300 hover:text-white hover:bg-stone-800/40' }}" title="Media Sosial Resmi Morela">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="18" cy="5" r="3" stroke-width="2"/>
                            <circle cx="6" cy="12" r="3" stroke-width="2"/>
                            <circle cx="18" cy="19" r="3" stroke-width="2"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/>
                        </svg>
                        <span>Media Sosial</span>
                    </a>

                    <div class="relative group">
                        <button class="px-3 py-1.5 rounded-lg text-stone-300 hover:text-white hover:bg-stone-800/40">
                            Lainnya ▾
                        </button>
                        <div class="absolute right-0 top-full mt-1 w-52 py-2 bg-stone-900 border border-stone-800 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150">
                            <a href="{{ route('events.index') }}" class="block px-4 py-2 text-sm text-stone-300 hover:text-emerald-400 hover:bg-stone-800">
                                Agenda & Event
                            </a>
                            <a href="{{ route('news.index') }}" class="block px-4 py-2 text-sm text-stone-300 hover:text-emerald-400 hover:bg-stone-800">
                                Warta Desa & KKN
                            </a>
                            <a href="{{ route('gallery.index') }}" class="block px-4 py-2 text-sm text-stone-300 hover:text-emerald-400 hover:bg-stone-800">
                                Galeri Foto
                            </a>
                            <a href="{{ route('program.unidar') }}" class="block px-4 py-2 text-sm text-stone-300 hover:text-emerald-400 hover:bg-stone-800">
                                Pengabdian UNIDAR
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Zone 3: Admin & Quick Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold rounded-lg bg-emerald-700 hover:bg-emerald-600 text-white shadow-sm transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Blade Section -->
    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-950 text-stone-300 border-t border-stone-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-xs">
                <div class="space-y-3">
                    <span class="font-serif text-lg font-bold text-white">MORELA TOURISM</span>
                    <p class="text-stone-400">Portal Resmi Digitalisasi Pariwisata & Arsip Budaya Desa Morella, Leihitu, Maluku Tengah.</p>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold text-white uppercase">Layanan Cepat</span>
                    <ul class="space-y-1 text-stone-400">
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-emerald-400">Destinasi Wisata</a></li>
                        <li><a href="{{ route('tickets.index') }}" class="hover:text-emerald-400 font-semibold text-emerald-400">Pesan E-Tiket Online</a></li>
                        <li><a href="{{ route('culture.index') }}" class="hover:text-emerald-400">Tradisi Pukul Sapu</a></li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold text-white uppercase">Program Pengabdian</span>
                    <p class="text-stone-400">Universitas Darussalam Ambon & Pemerintah Negeri Morella.</p>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold text-white uppercase">Kontak Balai Desa</span>
                    <p class="text-stone-400">+62 812-3456-7800 (Sekretariat Negeri Morela)</p>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-stone-800 text-stone-500 text-center text-xs">
                © {{ date('Y') }} Pemerintah Negeri Morella & Universitas Darussalam Ambon.
            </div>
        </div>
    </footer>

</body>
</html>
