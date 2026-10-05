@extends('layouts.admin')

@section('title', 'Edit Media Sosial - ' . $social->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.social-media.index') }}" class="hover:text-emerald-700">Media Sosial</a>
                <span>/</span>
                <span class="text-stone-900 font-medium">Edit: {{ $social->name }}</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">
                Edit Media Sosial: {{ $social->name }}
            </h1>
        </div>
        <a href="{{ route('admin.social-media.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Edit Form Container -->
    <div class="bg-white rounded-2xl border border-stone-200/80 p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('admin.social-media.update', $social->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <!-- Platform Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Nama Platform / Media Sosial <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $social->name) }}" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                    >
                    @error('name')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Slug Identifier
                    </label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug', $social->slug) }}" 
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 font-mono focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                    >
                    @error('slug')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Ikon Platform <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="icon" 
                        name="icon" 
                        required
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                    >
                        <option value="instagram" {{ old('icon', $social->icon) == 'instagram' ? 'selected' : '' }}>📷 Instagram</option>
                        <option value="facebook" {{ old('icon', $social->icon) == 'facebook' ? 'selected' : '' }}>📘 Facebook</option>
                        <option value="youtube" {{ old('icon', $social->icon) == 'youtube' ? 'selected' : '' }}>▶️ YouTube</option>
                        <option value="tiktok" {{ old('icon', $social->icon) == 'tiktok' ? 'selected' : '' }}>🎵 TikTok</option>
                        <option value="whatsapp" {{ old('icon', $social->icon) == 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                        <option value="twitter" {{ old('icon', $social->icon) == 'twitter' ? 'selected' : '' }}>✖️ X (Twitter)</option>
                        <option value="telegram" {{ old('icon', $social->icon) == 'telegram' ? 'selected' : '' }}>✈️ Telegram</option>
                        <option value="globe" {{ old('icon', $social->icon) == 'globe' ? 'selected' : '' }}>🌐 Website / Link Khusus</option>
                    </select>
                    @error('icon')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username / Handle -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Username / Handle / Nomor
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username', $social->username) }}" 
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 font-mono focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                    >
                    @error('username')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Full URL -->
            <div>
                <label for="url" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Tautan Lengkap URL <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="url" 
                    id="url" 
                    name="url" 
                    value="{{ old('url', $social->url) }}" 
                    required 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 font-mono focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                >
                @error('url')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-stone-700 mb-1.5">
                    Deskripsi Singkat Saluran
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="2" 
                    class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                >{{ old('description', $social->description) }}</textarea>
                @error('description')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-semibold text-stone-700 mb-1.5">
                        Urutan Tampilan
                    </label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        value="{{ old('sort_order', $social->sort_order) }}" 
                        min="0"
                        class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                    >
                    @error('sort_order')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active Checkbox -->
                <div class="flex items-center pt-6">
                    <label class="relative flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $social->is_active) ? 'checked' : '' }} 
                            class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-stone-300"
                        >
                        <div>
                            <span class="text-xs font-semibold text-stone-800">Status Aktif (Tayang Publik)</span>
                            <p class="text-[11px] text-stone-500">Tampilkan saluran ini di website resmi Morela Tourism.</p>
                        </div>
                    </label>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-stone-100 flex items-center justify-between">
                <span class="text-[11px] text-stone-400">
                    Terakhir diperbarui: {{ $social->updated_at ? $social->updated_at->format('d M Y H:i') : '-' }}
                </span>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.social-media.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-200 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Perbarui Perubahan</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
