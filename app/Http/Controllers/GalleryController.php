<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // For admin panel
        if ($request->is('admin/*')) {
            $images = GalleryImage::latest()->paginate(12);
            return view('admin.gallery.index', compact('images'));
        }

        // For public frontend
        $images = GalleryImage::where('is_published', true)->latest()->paginate(12);
        return view('gallery.index', compact('images')); // Assuming public view
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
            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/gallery_images', $fileName);
            $imagePath = '/storage/gallery_images/' . $fileName;
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
            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            
            // Delete old file
            if ($image->image_path && str_starts_with($image->image_path, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $image->image_path);
                Storage::delete($oldPath);
            }
            
            $file->storeAs('public/gallery_images', $fileName);
            $image->image_path = '/storage/gallery_images/' . $fileName;
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
