<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryVideo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.gallery.videos.index', compact('videos'));
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
            'title'         => 'required|string|max:200',
            'category'      => 'required|string|in:alam,budaya,wisata,umkm,pengabdian',
            'description'   => 'nullable|string|max:1000',
            'duration'      => 'nullable|string|max:20',
            'author'        => 'nullable|string|max:100',
            'video_url'     => 'nullable|url|max:255',
            // Validasi file video maksimal 500 MB (512000 KB)
            'video_file'    => 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:512000',
        ], [
            'title.required'     => 'Judul video wajib diisi.',
            'category.required'  => 'Kategori video wajib dipilih.',
            'video_file.max'     => 'Ukuran berkas video melebihi batas maksimal 500 MB (512.000 KB).',
            'video_file.mimes'   => 'Format video harus berupa MP4, MOV, AVI, WebM, atau MKV.',
        ]);

        $videoUrl = $validated['video_url'] ?? null;
        $fileSizeMb = 0;
        $thumbnailUrl = null;

        // Auto thumbnail if youtube URL
        if ($videoUrl && str_contains($videoUrl, 'youtube.com/watch?v=')) {
            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $queryArgs);
            if (isset($queryArgs['v'])) {
                $thumbnailUrl = 'https://img.youtube.com/vi/' . $queryArgs['v'] . '/maxresdefault.jpg';
            }
        } elseif ($videoUrl && str_contains($videoUrl, 'youtu.be/')) {
            $path = parse_url($videoUrl, PHP_URL_PATH);
            $thumbnailUrl = 'https://img.youtube.com/vi' . $path . '/maxresdefault.jpg';
        }

        // Jika mengunggah berkas video langsung
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileSizeMb = round($file->getSize() / (1024 * 1024), 2);

            // Double check batas 500 MB
            if ($fileSizeMb > 500) {
                return back()->withInput()->withErrors(['video_file' => 'Ukuran berkas video melebihi batas 500 MB.']);
            }

            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/videos', $fileName);
            $videoUrl = '/storage/videos/' . $fileName;
        }

        if (empty($videoUrl)) {
            return back()->withInput()->withErrors(['video_file' => 'Harap unggah file video (maks. 500MB) atau masukkan URL video streaming.']);
        }

        GalleryVideo::create([
            'title'         => $validated['title'],
            'slug'          => Str::slug($validated['title']) . '-' . Str::random(5),
            'category'      => $validated['category'],
            'description'   => $validated['description'],
            'duration'      => $validated['duration'] ?? '03:00',
            'file_size_mb'  => $fileSizeMb > 0 ? $fileSizeMb : ($request->input('file_size_mb') ?? 50),
            'author'        => $validated['author'] ?? 'Tim Dokumentasi Desa Morela',
            'video_url'     => $videoUrl,
            'thumbnail_url' => $thumbnailUrl ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
            'is_published'  => true,
        ]);

        return redirect()->route('admin.gallery-videos.index')
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
            'title'         => 'required|string|max:200',
            'category'      => 'required|string|in:alam,budaya,wisata,umkm,pengabdian',
            'description'   => 'nullable|string|max:1000',
            'duration'      => 'nullable|string|max:20',
            'author'        => 'nullable|string|max:100',
            'video_url'     => 'nullable|url|max:255',
            'video_file'    => 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:512000',
        ], [
            'video_file.max' => 'Ukuran berkas video melebihi batas maksimal 500 MB.',
        ]);

        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileSizeMb = round($file->getSize() / (1024 * 1024), 2);

            if ($fileSizeMb > 500) {
                return back()->withInput()->withErrors(['video_file' => 'Ukuran video melebihi batas maksimal 500 MB.']);
            }

            // Hapus file lama jika ada di storage lokal
            if ($video->video_url && str_starts_with($video->video_url, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $video->video_url);
                Storage::delete($oldPath);
            }

            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/videos', $fileName);
            $video->video_url = '/storage/videos/' . $fileName;
            $video->file_size_mb = $fileSizeMb;
        } elseif (!empty($validated['video_url'])) {
            $video->video_url = $validated['video_url'];
            
            // Auto thumbnail if youtube URL
            if (str_contains($video->video_url, 'youtube.com/watch?v=')) {
                parse_str(parse_url($video->video_url, PHP_URL_QUERY), $queryArgs);
                if (isset($queryArgs['v'])) {
                    $video->thumbnail_url = 'https://img.youtube.com/vi/' . $queryArgs['v'] . '/maxresdefault.jpg';
                }
            } elseif (str_contains($video->video_url, 'youtu.be/')) {
                $path = parse_url($video->video_url, PHP_URL_PATH);
                $video->thumbnail_url = 'https://img.youtube.com/vi' . $path . '/maxresdefault.jpg';
            }
        }

        $video->title = $validated['title'];
        $video->category = $validated['category'];
        $video->description = $validated['description'];
        $video->duration = $validated['duration'] ?? $video->duration;
        $video->author = $validated['author'] ?? $video->author;

        $video->save();

        return redirect()->route('admin.gallery-videos.index')
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

        return redirect()->route('admin.gallery-videos.index')
            ->with('success', "Video '{$title}' berhasil dihapus.");
    }
}
