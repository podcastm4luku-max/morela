<?php

namespace App\Http\Controllers;

use App\Models\GalleryVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryVideoController extends Controller
{
    /**
     * Tampilkan daftar video galeri
     */
    public function index(Request $request)
    {
        $query = GalleryVideo::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->latest()->paginate(12);

        return response()->view('admin.gallery.videos.index', compact('videos'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Form upload video baru
     */
    public function create()
    {
        return view('admin.gallery.videos.create');
    }

    /**
     * Simpan video baru dengan validasi ketat maksimal 500 MB (512.000 KB)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|in:alam,budaya,wisata,umkm,pengabdian',
            'description' => 'nullable|string|max:1000',
            'duration' => 'nullable|string|max:20',
            'author' => 'nullable|string|max:100',
            // Validasi file video maksimal 500 MB (512000 KB)
            'video_file' => 'required|file|mimes:mp4,mov,avi,webm,mkv|max:512000',
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'category.required' => 'Kategori video wajib dipilih.',
            'video_file.required' => 'Berkas video wajib diunggah.',
            'video_file.max' => 'Ukuran berkas video melebihi batas maksimal 500 MB (512.000 KB).',
            'video_file.mimes' => 'Format video harus berupa MP4, MOV, AVI, WebM, atau MKV.',
        ]);

        $fileSizeMb = 0;
        $thumbnailUrl = null;

        // Jika mengunggah berkas video langsung
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            
            if (!$file->isValid()) {
                return back()->withInput()->withErrors(['video_file' => 'File gagal diunggah. Pastikan file valid dan ukurannya tidak melebihi batas server (' . ini_get('upload_max_filesize') . ').']);
            }

            $fileSizeMb = round($file->getSize() / (1024 * 1024), 2);

            // Double check batas 500 MB
            if ($fileSizeMb > 500) {
                return back()->withInput()->withErrors(['video_file' => 'Ukuran berkas video melebihi batas 500 MB.']);
            }

            $fileName = time().'_'.Str::slug($validated['title']).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/videos', $fileName);
            
            if (!$path || !Storage::exists('public/videos/' . $fileName)) {
                return back()->withInput()->withErrors(['video_file' => 'Gagal menyimpan file video ke server.']);
            }
            
            $videoUrl = '/storage/videos/'.$fileName;
        }

        GalleryVideo::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(5),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'duration' => $validated['duration'] ?? '03:00',
            'file_size_mb' => $fileSizeMb,
            'author' => $validated['author'] ?? 'Tim Dokumentasi Desa Morela',
            'video_url' => $videoUrl,
            'thumbnail_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
            'is_published' => true,
        ]);

        return redirect()->route('admin.gallery-videos.index', ['t' => time()])
            ->with('success', "Video '{$validated['title']}' berhasil diunggah (Ukuran: {$fileSizeMb} MB / Maks. 500MB)!");
    }

    /**
     * Form edit video
     */
    public function edit($id)
    {
        $video = GalleryVideo::findOrFail($id);

        return view('admin.gallery.videos.edit', compact('video'));
    }

    /**
     * Update data video
     */
    public function update(Request $request, $id)
    {
        $video = GalleryVideo::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|in:alam,budaya,wisata,umkm,pengabdian',
            'description' => 'nullable|string|max:1000',
            'duration' => 'nullable|string|max:20',
            'author' => 'nullable|string|max:100',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:512000',
        ], [
            'video_file.max' => 'Ukuran berkas video melebihi batas maksimal 500 MB.',
        ]);

        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');

            if (!$file->isValid()) {
                return back()->withInput()->withErrors(['video_file' => 'File gagal diunggah. Pastikan file valid dan ukurannya tidak melebihi batas server (' . ini_get('upload_max_filesize') . ').']);
            }

            $fileSizeMb = round($file->getSize() / (1024 * 1024), 2);

            if ($fileSizeMb > 500) {
                return back()->withInput()->withErrors(['video_file' => 'Ukuran video melebihi batas maksimal 500 MB.']);
            }

            $fileName = time().'_'.Str::slug($validated['title']).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/videos', $fileName);

            if (!$path || !Storage::exists('public/videos/' . $fileName)) {
                return back()->withInput()->withErrors(['video_file' => 'Gagal menyimpan file video ke server.']);
            }

            // Hapus file lama hanya setelah file baru berhasil disimpan
            if ($video->video_url && str_starts_with($video->video_url, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $video->video_url);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $video->video_url = '/storage/videos/'.$fileName;
            $video->file_size_mb = $fileSizeMb;
        }

        $video->title = $validated['title'];
        $video->category = $validated['category'];
        $video->description = $validated['description'];
        $video->duration = $validated['duration'] ?? $video->duration;
        $video->author = $validated['author'] ?? $video->author;

        $video->save();

        return redirect()->route('admin.gallery-videos.index', ['t' => time()])
            ->with('success', "Data video '{$video->title}' berhasil diperbarui!");
    }

    /**
     * Hapus video
     */
    public function destroy($id)
    {
        $video = GalleryVideo::findOrFail($id);
        $title = $video->title;

        // Hapus file fisik dari storage jika ada
        if ($video->video_url && str_starts_with($video->video_url, '/storage/')) {
            $oldPath = str_replace('/storage/', 'public/', $video->video_url);
            Storage::delete($oldPath);
        }

        $video->delete();

        return redirect()->route('admin.gallery-videos.index', ['t' => time()])
            ->with('success', "Video '{$title}' berhasil dihapus.");
    }
}
