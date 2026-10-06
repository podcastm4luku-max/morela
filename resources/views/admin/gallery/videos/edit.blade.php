@extends('layouts.admin')

@section('title', 'Edit Video Galeri - Admin Morella')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.gallery-videos.index') }}" class="hover:text-emerald-700">Video Galeri</a>
                <span>/</span>
                <span class="text-stone-900 font-medium">Edit: {{ $video->title }}</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">
                Edit Data Video Dokumentasi
            </h1>
        </div>
        <a href="{{ route('admin.gallery-videos.index') }}" class="px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('admin.gallery-videos.update', $video->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Video -->
            <div>
                <label for="title" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Judul Video Dokumentasi <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $video->title) }}" 
                    required 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Kategori Video <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                    >
                        <option value="wisata" {{ old('category', $video->category) == 'wisata' ? 'selected' : '' }}>🏝️ Wisata & Pesisir</option>
                        <option value="budaya" {{ old('category', $video->category) == 'budaya' ? 'selected' : '' }}>🏛️ Budaya & Tradisi (Pukul Sapu)</option>
                        <option value="alam" {{ old('category', $video->category) == 'alam' ? 'selected' : '' }}>🌿 Alam & Hutan Rempah</option>
                        <option value="umkm" {{ old('category', $video->category) == 'umkm' ? 'selected' : '' }}>🛍️ UMKM & Kuliner</option>
                        <option value="pengabdian" {{ old('category', $video->category) == 'pengabdian' ? 'selected' : '' }}>🎓 Pengabdian KKN UNIDAR</option>
                    </select>
                </div>

                <!-- Durasi Video -->
                <div>
                    <label for="duration" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Durasi Video
                    </label>
                    <input 
                        type="text" 
                        id="duration" 
                        name="duration" 
                        value="{{ old('duration', $video->duration) }}" 
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                    >
                </div>
            </div>

            <!-- Ganti File Video (Maks. 500MB) -->
            <div class="p-4 bg-stone-50 border border-stone-200 rounded-2xl space-y-2">
                <label for="video_file" class="block text-xs font-semibold text-stone-800">
                    Ganti Berkas Video (Maksimal 500 MB)
                </label>
                <input 
                    type="file" 
                    id="video_file" 
                    name="video_file" 
                    accept="video/mp4,video/quicktime,video/webm,video/x-matroska"
                    class="block w-full text-xs text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-700 file:text-white hover:file:bg-emerald-600 cursor-pointer"
                >
                <p class="text-[11px] text-stone-500">
                    Ukuran saat ini: {{ $video->file_size_mb }} MB. Kosongkan jika tidak ingin mengganti file video. Batas unggah: 500 MB.
                </p>
            </div>

            <!-- Atau URL Video Streaming -->
            <div>
                <label for="video_url" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    URL Video Streaming / MP4
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url" 
                    value="{{ old('video_url', $video->video_url) }}" 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 font-mono focus:outline-none focus:border-emerald-600 focus:bg-white"
                >
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Deskripsi / Sinopsis Video
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >{{ old('description', $video->description) }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.gallery-videos.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs">
                    Perbarui Video (Maks. 500MB)
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
