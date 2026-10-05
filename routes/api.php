<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Destination;
use App\Models\TouristRoute;
use App\Models\SocialMedia;
use App\Models\GalleryVideo;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiTicketBookingController;
use App\Http\Controllers\PaymentController;

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
    return response()->json([
        'data' => Destination::where('published', true)->get()
    ]);
});

Route::get('/destinations/{id}', function ($id) {
    $destination = Destination::where('published', true)->find($id);
    if (!$destination) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json([
        'data' => $destination
    ]);
});

// Tourist Routes API
Route::get('/tourist-routes', function () {
    return response()->json([
        'data' => TouristRoute::where('is_active', true)->with('destinations')->get()
    ]);
});

Route::get('/tourist-routes/{id}', function ($id) {
    $route = TouristRoute::where('is_active', true)->with('destinations')->find($id);
    if (!$route) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json([
        'data' => $route
    ]);
});

// Social Media API
Route::get('/social-media', function () {
    return response()->json([
        'data' => SocialMedia::where('is_active', true)->orderBy('sort_order')->get()
    ]);
});

Route::get('/social-media/{id}', function ($id) {
    $social = SocialMedia::where('is_active', true)->find($id);
    if (!$social) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json([
        'data' => $social
    ]);
});

// Gallery Videos API
Route::get('/gallery-videos', function () {
    return response()->json([
        'data' => GalleryVideo::latest()->get()
    ]);
});

Route::get('/gallery-videos/{id}', function ($id) {
    $video = GalleryVideo::where('is_published', true)->find($id);
    if (!$video) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json([
        'data' => $video
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
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
            'image_url' => 'required|string'
        ]);
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
            'end_longitude' => 'required|numeric'
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
            'slug' => 'required|string|unique:gallery_videos,slug',
            'video_url' => 'required|string',
        ]);
        $validated['is_published'] = true;
        $gv = GalleryVideo::create($validated);
        return response()->json($gv, 201);
    });
    
    Route::put('/gallery-videos/{id}', function (Request $request, $id) {
        $gv = GalleryVideo::findOrFail($id);
        $gv->update($request->all());
        return response()->json($gv);
    });

    Route::delete('/gallery-videos/{id}', function ($id) {
        GalleryVideo::findOrFail($id)->delete();
        return response()->json(null, 204);
    });
});

// App Settings
use App\Http\Controllers\AppSettingController;
Route::get('/settings', [AppSettingController::class, 'index']);
Route::post('/settings', [AppSettingController::class, 'update']);
