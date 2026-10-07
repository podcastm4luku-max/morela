<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // For admin panel
        if ($request->is('admin/*')) {
            $images = GalleryImage::latest()->paginate(12);

            return response()->view('admin.gallery.index', compact('images'))
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        // For public frontend
        $images = GalleryImage::where('is_published', true)->latest()->paginate(12);

        return response()->view('gallery.index', compact('images'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if (!$file->isValid()) {
                return back()->withInput()->withErrors(['image' => 'File gagal diunggah. Pastikan file valid dan ukurannya tidak melebihi batas server (' . ini_get('upload_max_filesize') . ').']);
            }

            $fileName = time().'_'.Str::slug($validated['title']).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/gallery_images', $fileName);
            
            if (!$path || !Storage::exists('public/gallery_images/' . $fileName)) {
                return back()->withInput()->withErrors(['image' => 'Gagal menyimpan file gambar ke server.']);
            }
            
            $imagePath = '/storage/gallery_images/'.$fileName;
        }

        GalleryImage::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'image_path' => $imagePath ?? null,
            'is_published' => $request->has('is_published') ? (bool) $request->input('is_published') : true,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Data gambar berhasil disimpan.');
    }

    public function edit($id)
    {
        $image = GalleryImage::findOrFail($id);

        return view('admin.gallery.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $image = GalleryImage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if (!$file->isValid()) {
                return back()->withInput()->withErrors(['image' => 'File gagal diunggah. Pastikan file valid dan ukurannya tidak melebihi batas server (' . ini_get('upload_max_filesize') . ').']);
            }

            $fileName = time().'_'.Str::slug($validated['title']).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/gallery_images', $fileName);
            
            if (!$path || !Storage::exists('public/gallery_images/' . $fileName)) {
                return back()->withInput()->withErrors(['image' => 'Gagal menyimpan file gambar ke server.']);
            }

            // Hapus file lama hanya setelah file baru berhasil disimpan
            if ($image->image_path && str_starts_with($image->image_path, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $image->image_path);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $image->image_path = '/storage/gallery_images/'.$fileName;
        }

        $image->title = $validated['title'];
        $image->description = $validated['description'];
        $image->category = $validated['category'];
        $image->is_published = $request->has('is_published') ? (bool) $request->input('is_published') : false;

        $image->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Data gambar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);

        // Delete old file
        if ($image->image_path && str_starts_with($image->image_path, '/storage/')) {
            $oldPath = str_replace('/storage/', 'public/', $image->image_path);
            Storage::delete($oldPath);
        }

        $image->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Data gambar berhasil dihapus.');
    }
}
