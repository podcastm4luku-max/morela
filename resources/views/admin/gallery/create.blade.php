@extends('layouts.admin')

@section('title', 'Unggah Gambar Galeri - Admin Morella')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.gallery.index') }}" class="hover:text-emerald-700">Data Gambar</a>
                <span>/</span>
                <span class="text-stone-900 font-medium">Unggah Gambar Baru</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">
                Unggah Gambar & Foto
            </h1>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
            +? Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs">
        @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-700">
            <strong class="block mb-2 font-bold">Terjadi Kesalahan:</strong>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Gambar -->
            <div>
                <label for="title" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Judul Gambar / Foto <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >
            </div>

            <!-- Kategori & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="category" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                    >
                        <option value="wisata">Wisata & Pemandangan</option>
                        <option value="budaya">Budaya & Tradisi</option>
                        <option value="umkm">UMKM & Ekonomi Kreatif</option>
                        <option value="umum">Umum / Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="is_published" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Status Tayang
                    </label>
                    <select 
                        id="is_published" 
                        name="is_published" 
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                    >
                        <option value="1">Publik (Tampil di Website)</option>
                        <option value="0">Draft (Sembunyikan)</option>
                    </select>
                </div>
            </div>

            <!-- Upload File Gambar -->
            <div class="p-4 bg-stone-50 border border-stone-200 rounded-2xl space-y-2">
                <label for="image" class="block text-xs font-semibold text-stone-800">
                    Pilih File Gambar <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    required
                    accept="image/jpeg,image/png,image/webp,image/jpg"
                    class="block w-full text-xs text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-700 file:text-white hover:file:bg-emerald-600 cursor-pointer"
                >
                <p class="text-[11px] text-stone-500">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 5 MB.
                </p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Deskripsi / Keterangan (Opsional)
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.gallery.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs">
                    Simpan & Unggah
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
