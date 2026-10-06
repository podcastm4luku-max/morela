@extends('layouts.app')

@section('title', 'Galeri Gambar - Jelajah Pesona Morella')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10 text-center">
        <h1 class="font-serif text-4xl font-bold text-stone-900 mb-4">Galeri Dokumentasi</h1>
        <p class="text-stone-500 max-w-2xl mx-auto">Kumpulan foto dan dokumentasi kegiatan, pariwisata, serta budaya di Negeri Morela.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($images as $image)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group border border-stone-100">
                <div class="aspect-square relative overflow-hidden bg-stone-100">
                    <img src="{{ $image->image_path }}" alt="{{ $image->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    @if($image->category)
                        <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-1">{{ $image->category }}</div>
                    @endif
                    <h3 class="font-serif font-bold text-sm text-stone-900 leading-tight mb-2">{{ $image->title }}</h3>
                    @if($image->description)
                        <p class="text-xs text-stone-500 line-clamp-2">{{ $image->description }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-stone-400">
                <p>Belum ada foto dalam galeri.</p>
            </div>
        @endforelse
    </div>

    @if($images->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $images->links() }}
        </div>
    @endif
</div>
@endsection
