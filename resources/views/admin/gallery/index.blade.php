@extends('layouts.admin')

@section('title', 'Kelola Gambar Galeri - Admin Morella')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">
                <span>Galeri Multimedia Desa</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900 tracking-tight">
                Data Gambar & Foto
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Kelola foto dokumentasi, wisata, dan budaya.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.gallery.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Unggah Gambar</span>
            </a>
        </div>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($images as $image)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden group shadow-sm hover:shadow-md transition-shadow">
                <div class="aspect-video w-full bg-stone-100 overflow-hidden relative">
                    <img src="{{ $image->image_path }}" alt="{{ $image->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-2 right-2 flex gap-1">
                        @if($image->is_published)
                            <span class="px-2 py-1 bg-emerald-500 text-white text-[10px] font-bold rounded-md shadow-sm">PUBLIK</span>
                        @else
                            <span class="px-2 py-1 bg-stone-500 text-white text-[10px] font-bold rounded-md shadow-sm">DRAFT</span>
                        @endif
                    </div>
                </div>
                <div class="p-4 space-y-2">
                    @if($image->category)
                        <div class="text-[10px] font-bold text-emerald-600 uppercase">{{ $image->category }}</div>
                    @endif
                    <h3 class="font-serif font-bold text-sm text-stone-900 leading-tight line-clamp-2">
                        {{ $image->title }}
                    </h3>
                    <div class="flex items-center justify-between pt-3 mt-3 border-t border-stone-100">
                        <a href="{{ route('admin.gallery.edit', $image->id) }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $image->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-stone-500 bg-white rounded-3xl border border-stone-200 border-dashed">
                <svg class="w-12 h-12 mx-auto text-stone-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="font-medium text-sm">Belum ada data gambar.</p>
                <p class="text-xs mt-1">Mulai dengan mengunggah gambar pertama Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($images->hasPages())
        <div class="mt-6">
            {{ $images->links() }}
        </div>
    @endif

</div>
@endsection
