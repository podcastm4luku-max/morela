@extends('layouts.admin')

@section('title', 'Kelola Video Galeri (Maks. 500MB) - Admin Morella')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">
                <span>Galeri Multimedia Desa</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900 tracking-tight">
                Video Dokumentasi & Promosi (Maks. 500MB)
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Kelola file video dokumenter, ritual adat Pukul Sapu, dan keindahan pesisir dengan batas unggah maksimal 500 MB per video.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.gallery-videos.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Unggah Video (Maks. 500MB)</span>
            </a>
        </div>
    </div>

    <!-- Info Banner Maks. 500MB -->
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs text-emerald-900 shadow-xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>
                <strong>Ketentuan Berkas Video:</strong> Format didukung: MP4, MOV, WebM, MKV. Ukuran maksimal: <strong>500 MB</strong> (512.000 KB). Video otomatis tayang di halaman utama & portal galeri.
            </span>
        </div>
    </div>

    <!-- Video Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <!-- Video Thumbnail Preview with Play Icon Overlay -->
                    <div class="relative aspect-video bg-stone-900 overflow-hidden">
                        <img 
                            src="{{ $video->thumbnail_url ?: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80' }}" 
                            alt="{{ $video->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90"
                        >
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <a 
                                href="{{ $video->video_url }}" 
                                target="_blank" 
                                class="w-12 h-12 rounded-full bg-emerald-600/90 hover:bg-emerald-500 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform"
                                title="Putar Video"
                            >
                                <svg class="w-5 h-5 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </a>
                        </div>
                        <div class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/80 text-white text-[10px] font-mono rounded-md">
                            {{ $video->duration ?: '03:00' }}
                        </div>
                        <div class="absolute top-2 left-2 px-2 py-0.5 bg-stone-900/80 text-amber-300 border border-stone-700 text-[10px] font-mono rounded-md">
                            {{ $video->file_size_mb }} MB / Max 500MB
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between text-[10px] text-stone-500 uppercase tracking-wider">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 rounded-md font-semibold">
                                {{ strtoupper($video->category) }}
                            </span>
                            <span>{{ $video->created_at->format('d M Y') }}</span>
                        </div>

                        <h3 class="font-serif font-bold text-sm text-stone-900 line-clamp-1">
                            {{ $video->title }}
                        </h3>

                        @if($video->description)
                            <p class="text-xs text-stone-500 line-clamp-2 leading-relaxed">
                                {{ $video->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-3 bg-stone-50 border-t border-stone-100 flex items-center justify-between text-xs">
                    <a 
                        href="{{ $video->video_url }}" 
                        target="_blank" 
                        class="text-emerald-700 hover:text-emerald-900 font-medium inline-flex items-center gap-1"
                    >
                        <span>Putar Video</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <div class="flex items-center gap-1">
                        <a 
                            href="{{ route('admin.gallery-videos.edit', $video->id) }}" 
                            class="p-1.5 text-stone-600 hover:text-emerald-700 hover:bg-stone-200 rounded-lg transition-colors" 
                            title="Edit Video"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>

                        <form 
                            method="POST" 
                            action="{{ route('admin.gallery-videos.destroy', $video->id) }}" 
                            onsubmit="return confirm('Hapus video {{ $video->title }}?');" 
                            class="inline-block"
                        >
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="p-1.5 text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" 
                                title="Hapus Video"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 bg-white rounded-3xl border border-stone-200 text-center text-stone-400 space-y-3">
                <p class="text-sm font-semibold">Belum ada video dokumentasi yang diunggah.</p>
                <a href="{{ route('admin.gallery-videos.create') }}" class="inline-block px-4 py-2 rounded-xl bg-emerald-700 text-white text-xs font-semibold">
                    + Unggah Video Pertama (Maks. 500MB)
                </a>
            </div>
        @endforelse
    </div>

    @if($videos->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-stone-200">
            {{ $videos->links() }}
        </div>
    @endif

</div>
@endsection
