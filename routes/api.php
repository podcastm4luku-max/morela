<?php

use App\Http\Controllers\ApiTicketBookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Models\Destination;
use App\Models\GalleryVideo;
use App\Models\SocialMedia;
use App\Models\TouristRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Ticketing API
Route::post('/tickets', [ApiTicketBookingController::class, 'store']);
Route::get('/tickets/{bookingCode}', [ApiTicketBookingController::class, 'show']);

// Payment API
Route::post('/payment/{bookingCode}/create', [PaymentController::class, 'createPayment']);
Route::post('/payment/callback', [PaymentController::class, 'callback']);
Route::get('/payment/{bookingCode}/status', [PaymentController::class, 'status']);
Route::post('/payment/simulate/{bookingCode}', [PaymentController::class, 'simulateCallback']);

// Destinations API
Route::get('/destinations', function () {
    $dests = Destination::where('published', true)->get()->map(function ($dest) {
        if (str_starts_with($dest->image_url, '/storage/')) {
            $dest->image_url = url($dest->image_url);
        }

        return $dest;
    });

    return response()->json(['data' => $dests]);
});

Route::get('/destinations/{id}', function ($id) {
    $destination = Destination::where('published', true)->find($id);
    if (! $destination) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'data' => $destination,
    ]);
});

// Tourist Routes API
Route::get('/tourist-routes', function () {
    return response()->json([
        'data' => TouristRoute::where('is_active', true)->with('destinations')->get(),
    ]);
});

Route::get('/tourist-routes/{id}', function ($id) {
    $route = TouristRoute::where('is_active', true)->with('destinations')->find($id);
    if (! $route) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'data' => $route,
    ]);
});

// Social Media API
Route::get('/social-media', function () {
    return response()->json([
        'data' => SocialMedia::where('is_active', true)->orderBy('sort_order')->get(),
    ]);
});

Route::get('/social-media/{id}', function ($id) {
    $social = SocialMedia::where('is_active', true)->find($id);
    if (! $social) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'data' => $social,
    ]);
});

// Gallery Videos API
Route::get('/gallery-videos', function () {
    $videos = GalleryVideo::latest()->get()->map(function ($vid) {
        if (str_starts_with($vid->video_url, '/storage/')) {
            $vid->video_url = url($vid->video_url);
        }

        return $vid;
    });

    return response()->json(['data' => $videos]);
});

Route::get('/gallery-videos/{id}', function ($id) {
    $video = GalleryVideo::where('is_published', true)->find($id);
    if (! $video) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'data' => $video,
    ]);
});

// Route::middleware('auth:sanctum')->group(function () {
// Admin Ticketing
Route::get('/admin/tickets', [ApiTicketBookingController::class, 'index']);
Route::post('/admin/tickets/validate', [ApiTicketBookingController::class, 'validateQr']);
Route::post('/admin/tickets/{bookingCode}/check-in', [ApiTicketBookingController::class, 'checkIn']);
Route::put('/admin/tickets/{bookingCode}/status', [ApiTicketBookingController::class, 'updateStatus']);

// Destinations CRUD
Route::post('/destinations', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string|unique:destinations,slug',
        'category' => 'required|string',
        'tagline' => 'required|string',
        'description' => 'required|string',
        'location' => 'required|string',
        'image_url' => 'nullable|string',
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
    ]);
    if ($request->hasFile('image_file')) {
        $path = $request->file('image_file')->store('destinations', 'public');
        $validated['image_url'] = url('/storage/'.$path);
    }
    $validated['published'] = true;
    $dest = Destination::create($validated);

    return response()->json($dest, 201);
});

Route::put('/destinations/{id}', function (Request $request, $id) {
    $dest = Destination::findOrFail($id);
    $dest->update($request->all());

    return response()->json($dest);
});

Route::delete('/destinations/{id}', function ($id) {
    Destination::findOrFail($id)->delete();

    return response()->json(null, 204);
});

// Tourist Routes CRUD
Route::post('/tourist-routes', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string|unique:tourist_routes,slug',
        'start_name' => 'required|string',
        'start_latitude' => 'required|numeric',
        'start_longitude' => 'required|numeric',
        'end_name' => 'required|string',
        'end_latitude' => 'required|numeric',
        'end_longitude' => 'required|numeric',
    ]);
    $validated['is_active'] = true;
    $route = TouristRoute::create($validated);

    return response()->json($route, 201);
});

Route::put('/tourist-routes/{id}', function (Request $request, $id) {
    $route = TouristRoute::findOrFail($id);
    $route->update($request->all());

    return response()->json($route);
});

Route::delete('/tourist-routes/{id}', function ($id) {
    TouristRoute::findOrFail($id)->delete();

    return response()->json(null, 204);
});

// Social Media CRUD
Route::post('/social-media', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string|unique:social_media,slug',
        'icon' => 'required|string',
        'url' => 'required|url',
    ]);
    $validated['is_active'] = true;
    $sm = SocialMedia::create($validated);

    return response()->json($sm, 201);
});

Route::put('/social-media/{id}', function (Request $request, $id) {
    $sm = SocialMedia::findOrFail($id);
    $sm->update($request->all());

    return response()->json($sm);
});

Route::delete('/social-media/{id}', function ($id) {
    SocialMedia::findOrFail($id)->delete();

    return response()->json(null, 204);
});

// Gallery Videos CRUD
Route::post('/gallery-videos', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string',
        // slug removed from validation
        'category' => 'nullable|string',
        'description' => 'nullable|string',
        'video_file' => 'nullable|file|max:512000',
        'video_url' => 'nullable|string',
    ]);

    if ($request->hasFile('video_file')) {
        $path = $request->file('video_file')->store('gallery/videos', 'public');
        $validated['video_url'] = url('/storage/'.$path);
    }

    $validated['is_published'] = true;
    $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();
    $gv = GalleryVideo::create($validated);

    return response()->json($gv, 201);
});

Route::put('/gallery-videos/{id}', function (Request $request, $id) {
    $gv = GalleryVideo::findOrFail($id);
    $data = $request->all();

    if (isset($data['video_url']) && str_starts_with($data['video_url'], 'blob:')) {
        unset($data['video_url']);
    }

    if ($request->hasFile('video_file')) {
        $file = $request->file('video_file');
        if ($file->isValid()) {
            // Delete old physical file if exists and is local
            if ($gv->video_url && str_starts_with($gv->video_url, url('/storage/'))) {
                $oldPath = str_replace(url('/storage/').'/', '', $gv->video_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $file->store('gallery/videos', 'public');
            $data['video_url'] = url('/storage/'.$path);
        }
    }

    $gv->update($data);

    return response()->json($gv);
});

Route::delete('/gallery-videos/{id}', function ($id) {
    GalleryVideo::findOrFail($id)->delete();

    return response()->json(null, 204);
});
// });

// App Settings
use App\Http\Controllers\AppSettingController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

Route::get('/settings', [AppSettingController::class, 'index']);
Route::post('/settings', [AppSettingController::class, 'update']);

Route::get('/test-post-size', function () {
    return UploadedFile::getMaxFilesize();
});
Route::get('/test-post-size-2', function () {
    return ini_get('post_max_size');
});

// ... existing code ...

// Gallery Images CRUD
Route::get('/gallery-images', function () {
    $images = \App\Models\GalleryImage::latest()->get()->map(function ($img) {
        if (str_starts_with($img->image_path, '/storage/')) {
            $img->image_path = url($img->image_path);
        }
        return $img;
    });
    return response()->json(['data' => $images]);
});

Route::post('/gallery-images', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'title' => 'required|string',
        'category' => 'nullable|string',
        'description' => 'nullable|string',
        'image_file' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // 10MB max
    ]);

    if ($request->hasFile('image_file')) {
        $path = $request->file('image_file')->store('gallery/images', 'public');
        $validated['image_path'] = url('/storage/'.$path);
    } else {
        $validated['image_path'] = '';
    }

    $validated['is_published'] = true;
    
    // Add missing fields to avoid DB constraint errors if any
    
    

    $img = \App\Models\GalleryImage::create($validated);
    return response()->json($img, 201);
});

Route::put('/gallery-images/{id}', function (Illuminate\Http\Request $request, $id) {
    $img = \App\Models\GalleryImage::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image_file')) {
        $file = $request->file('image_file');
        if ($file->isValid()) {
            if ($img->image_path && str_starts_with($img->image_path, url('/storage/'))) {
                $oldPath = str_replace(url('/storage/').'/', '', $img->image_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $file->store('gallery/images', 'public');
            $data['image_path'] = url('/storage/'.$path);
        }
    }
    
    $img->update($data);
    return response()->json($img);
});

Route::delete('/gallery-images/{id}', function ($id) {
    $img = \App\Models\GalleryImage::findOrFail($id);
    if ($img->image_path && str_starts_with($img->image_path, url('/storage/'))) {
        $oldPath = str_replace(url('/storage/').'/', '', $img->image_path);
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }
    $img->delete();
    return response()->json(null, 204);
});
