<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia;
use Illuminate\Support\Str;

class SocialMediaController extends Controller
{
    /**
     * Tampilkan daftar seluruh media sosial
     */
    public function index(Request $request)
    {
        $query = SocialMedia::query();

        // Fitur pencarian berdasarkan nama, username, atau URL
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status aktif
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $socialMedia = $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->paginate(10);
        $totalActive = SocialMedia::where('is_active', true)->count();
        $totalInactive = SocialMedia::where('is_active', false)->count();

        return view('admin.social_media.index', compact('socialMedia', 'totalActive', 'totalInactive'));
    }

    /**
     * Form tambah media sosial baru
     */
    public function create()
    {
        $nextOrder = (SocialMedia::max('sort_order') ?? 0) + 1;
        return view('admin.social_media.create', compact('nextOrder'));
    }

    /**
     * Simpan media sosial baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:100|unique:social_media,slug',
            'icon'        => 'required|string|max:50',
            'url'         => 'required|url|max:255',
            'username'    => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required' => 'Nama platform media sosial wajib diisi.',
            'url.required'  => 'Tautan URL profil wajib diisi.',
            'url.url'       => 'Format URL tidak valid (harus diawali http:// atau https://).',
            'icon.required' => 'Ikon media sosial wajib dipilih.',
            'slug.unique'   => 'Slug sudah digunakan oleh platform lain.',
        ]);

        $validated['slug'] = !empty($validated['slug']) 
            ? Str::slug($validated['slug']) 
            : Str::slug($validated['name']);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        SocialMedia::create($validated);

        return redirect()->route('admin.social-media.index')
            ->with('success', "Media sosial {$validated['name']} berhasil ditambahkan!");
    }

    /**
     * Form edit media sosial
     */
    public function edit($id)
    {
        $social = SocialMedia::findOrFail($id);
        return view('admin.social_media.edit', compact('social'));
    }

    /**
     * Perbarui data media sosial yang ada
     */
    public function update(Request $request, $id)
    {
        $social = SocialMedia::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => "nullable|string|max:100|unique:social_media,slug,{$id}",
            'icon'        => 'required|string|max:50',
            'url'         => 'required|url|max:255',
            'username'    => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required' => 'Nama platform media sosial wajib diisi.',
            'url.required'  => 'Tautan URL profil wajib diisi.',
            'url.url'       => 'Format URL tidak valid (harus diawali http:// atau https://).',
            'icon.required' => 'Ikon media sosial wajib dipilih.',
            'slug.unique'   => 'Slug sudah digunakan oleh platform lain.',
        ]);

        $validated['slug'] = !empty($validated['slug']) 
            ? Str::slug($validated['slug']) 
            : Str::slug($validated['name']);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        $social->update($validated);

        return redirect()->route('admin.social-media.index')
            ->with('success', "Data media sosial {$social->name} berhasil diperbarui!");
    }

    /**
     * Hapus media sosial
     */
    public function destroy($id)
    {
        $social = SocialMedia::findOrFail($id);
        $name = $social->name;
        $social->delete();

        return redirect()->route('admin.social-media.index')
            ->with('success', "Media sosial {$name} berhasil dihapus!");
    }

    /**
     * Toggle status aktif/non-aktif dengan satu klik
     */
    public function toggleStatus($id)
    {
        $social = SocialMedia::findOrFail($id);
        $social->is_active = !$social->is_active;
        $social->save();

        $statusText = $social->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Media sosial {$social->name} berhasil {$statusText}!");
    }
}
