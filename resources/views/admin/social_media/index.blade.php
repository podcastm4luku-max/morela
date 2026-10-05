@extends('layouts.admin')

@section('title', 'Kelola Media Sosial - Admin Morela Tourism')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-2xl border border-stone-200/80 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">
                <span>Manajemen Saluran Informasi</span>
            </div>
            <h1 class="font-serif text-2xl font-bold text-stone-900 tracking-tight">
                Media Sosial Resmi Morela
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Kelola akun media sosial desa dan kontak promosi wisata yang ditampilkan pada footer dan halaman kontak publik.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.social-media.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Media Sosial</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 bg-white rounded-2xl border border-stone-200/80 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-semibold uppercase text-stone-400">Total Akun Terdaftar</div>
                <div class="text-2xl font-bold text-stone-900 mt-0.5">{{ $socialMedia->total() }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-stone-200/80 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-semibold uppercase text-emerald-600">Aktif Tayang di Publik</div>
                <div class="text-2xl font-bold text-emerald-700 mt-0.5">{{ $totalActive }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-stone-200/80 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-semibold uppercase text-stone-400">Nonaktif / Draft</div>
                <div class="text-2xl font-bold text-stone-500 mt-0.5">{{ $totalInactive }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-400 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl border border-stone-200/80 p-4 shadow-xs">
        <form method="GET" action="{{ route('admin.social-media.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama platform, username, atau link URL..." 
                    class="w-full pl-9 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 placeholder-stone-400 focus:outline-none focus:border-emerald-600 focus:bg-white transition-colors"
                >
            </div>

            <div class="w-full sm:w-48">
                <select 
                    name="status" 
                    onchange="this.form.submit()" 
                    class="w-full px-3 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-800 focus:outline-none focus:border-emerald-600 focus:bg-white"
                >
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Hanya Nonaktif</option>
                </select>
            </div>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.social-media.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-600 rounded-xl text-xs font-medium text-center transition-colors">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-2xl border border-stone-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-200/80 text-[11px] font-semibold text-stone-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">Urutan</th>
                        <th class="py-3.5 px-4">Platform & Ikon</th>
                        <th class="py-3.5 px-4">Username / Handle</th>
                        <th class="py-3.5 px-4">Tautan URL</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($socialMedia as $item)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            
                            <!-- Sort Order -->
                            <td class="py-4 px-4 text-center">
                                <span class="w-6 h-6 rounded-md bg-stone-100 text-stone-600 font-mono text-[11px] font-semibold inline-flex items-center justify-center">
                                    {{ $item->sort_order }}
                                </span>
                            </td>

                            <!-- Platform & Icon -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs uppercase border {{ $item->badge_color }}">
                                        @if(in_array(strtolower($item->icon), ['instagram', 'facebook', 'youtube', 'tiktok', 'whatsapp', 'twitter', 'telegram']))
                                            <span class="font-mono text-xs">{{ substr($item->name, 0, 2) }}</span>
                                        @else
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-stone-900 flex items-center gap-1.5">
                                            <span>{{ $item->name }}</span>
                                            <span class="text-[10px] text-stone-400 font-mono">({{ $item->slug }})</span>
                                        </div>
                                        @if($item->description)
                                            <p class="text-[11px] text-stone-400 truncate max-w-xs mt-0.5">
                                                {{ $item->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Username -->
                            <td class="py-4 px-4 font-medium text-stone-800">
                                @if($item->username)
                                    <span class="font-mono text-[11px] px-2 py-0.5 bg-stone-100 text-stone-700 rounded-md">
                                        {{ $item->username }}
                                    </span>
                                @else
                                    <span class="text-stone-300 italic">-</span>
                                @endif
                            </td>

                            <!-- URL -->
                            <td class="py-4 px-4 text-stone-600">
                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 hover:underline max-w-xs truncate" title="{{ $item->url }}">
                                    <span class="truncate">{{ $item->url }}</span>
                                    <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-4 px-4 text-center">
                                <form method="POST" action="{{ route('admin.social-media.toggle', $item->id) }}" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit" 
                                        title="Klik untuk ubah status (Aktif/Nonaktif)"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition-all {{ $item->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-stone-100 text-stone-500 hover:bg-stone-200' }}"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-600 animate-pulse' : 'bg-stone-400' }}"></span>
                                        <span>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a 
                                        href="{{ route('admin.social-media.edit', $item->id) }}" 
                                        class="p-1.5 text-stone-600 hover:text-emerald-700 hover:bg-stone-100 rounded-lg transition-colors" 
                                        title="Edit Data"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <form 
                                        method="POST" 
                                        action="{{ route('admin.social-media.destroy', $item->id) }}" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus media sosial {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.');"
                                        class="inline-block"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" 
                                            title="Hapus Media Sosial"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-2xl bg-stone-100 text-stone-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="18" cy="5" r="3" stroke-width="2"/><circle cx="6" cy="12" r="3" stroke-width="2"/><circle cx="18" cy="19" r="3" stroke-width="2"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/></svg>
                                    </div>
                                    <div class="font-serif text-base font-bold text-stone-800">Belum ada akun media sosial</div>
                                    <p class="text-xs text-stone-500">
                                        Data media sosial yang ditambahkan akan muncul di sini dan tayang di website publik Morela Tourism.
                                    </p>
                                    <div class="pt-2">
                                        <a href="{{ route('admin.social-media.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            <span>Tambah Akun Pertama</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($socialMedia->hasPages())
            <div class="p-4 border-t border-stone-100 bg-stone-50 flex items-center justify-between">
                {{ $socialMedia->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
