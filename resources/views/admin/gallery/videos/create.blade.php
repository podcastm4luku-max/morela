@extends('layouts.admin')

@section('title', 'Unggah Video Galeri (Maks. 500MB) - Admin Morela')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.gallery-videos.index') }}" class="hover:text-emerald-700">Video Galeri</a>
                <span>/</span>
                <span class="text-stone-900 font-medium">Unggah Video Baru</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">
                Unggah Video Dokumentasi (Maksimal 500 MB)
            </h1>
        </div>
        <a href="{{ route('admin.gallery-videos.index') }}" class="px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
            ← Kembali
        </a>
    </div>

    <!-- Alert Batas 500MB -->
    <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center gap-3 text-xs text-amber-900 shadow-xs">
        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div>
            <strong>Ketentuan Ukuran Berkas:</strong> Sistem membatasi ukuran unggahan berkas video hingga <strong>maksimal 500 Megabytes (500 MB)</strong>. Format yang diterima: <code>.mp4</code>, <code>.mov</code>, <code>.webm</code>, <code>.mkv</code>.
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('admin.gallery-videos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Video -->
            <div>
                <label for="title" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Judul Video Dokumentasi <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Contoh: Liputan Tradisi Pukul Sapu 7 Syawal Negeri Morela"
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
                        <option value="wisata">🏝️ Wisata & Pesisir</option>
                        <option value="budaya">🏛️ Budaya & Tradisi (Pukul Sapu)</option>
                        <option value="alam">🌿 Alam & Hutan Rempah</option>
                        <option value="umkm">🛍️ UMKM & Kuliner</option>
                        <option value="pengabdian">🎓 Pengabdian KKN UNIDAR</option>
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
                        value="{{ old('duration', '03:30') }}" 
                        placeholder="Contoh: 04:15"
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                    >
                </div>
            </div>

            <!-- Upload File Video (Maks. 500MB) -->
            <div class="p-4 bg-stone-50 border border-stone-200 rounded-2xl space-y-2">
                <label for="video_file" class="block text-xs font-semibold text-stone-800">
                    Unggah Berkas Video Asli (Maksimal 500 MB)
                </label>
                <input 
                    type="file" 
                    id="video_file" 
                    name="video_file" 
                    accept="video/mp4,video/quicktime,video/webm,video/x-matroska"
                    class="block w-full text-xs text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-700 file:text-white hover:file:bg-emerald-600 cursor-pointer"
                >
                <p class="text-[11px] text-stone-500">
                    Batas ukuran: <strong>500 MB</strong>. Bila file berukuran besar, Anda juga dapat mengisi tautan video streaming di bawah.
                </p>
            </div>

            <!-- Atau URL Video Streaming -->
            <div>
                <label for="video_url" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Atau Tautan URL Video Langsung (Streaming / MP4 / CDN)
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url" 
                    value="{{ old('video_url') }}" 
                    placeholder="https://.../video.mp4"
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 font-mono focus:outline-none focus:border-emerald-600 focus:bg-white"
                >
            </div>

            <!-- Thumbnail URL -->
            <div>
                <label for="thumbnail_url" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    URL Foto Cover / Sampul Video
                </label>
                <input 
                    type="url" 
                    id="thumbnail_url" 
                    name="thumbnail_url" 
                    value="{{ old('thumbnail_url', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80') }}" 
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
                    placeholder="Tuliskan keterangan isi video dokumentasi..."
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.gallery-videos.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs">
                    Simpan & Unggah Video (Maks. 500MB)
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
