<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristDestination;
use App\Models\TouristRoute;

class TouristMapController extends Controller
{
    /**
     * Halaman Publik Peta Wisata & Jelajah Negeri Morela
     * Route: GET /peta-wisata
     */
    public function index(Request $request)
    {
        $destinations = TouristDestination::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $routes = TouristRoute::where('is_active', true)
            ->with(['destinations' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->get();

        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        // Selected item if query parameter provided
        $selectedDestination = null;
        if ($request->filled('destinasi')) {
            $selectedDestination = $destinations->firstWhere('slug', $request->destinasi);
        }

        $selectedRoute = null;
        if ($request->filled('rute')) {
            $selectedRoute = $routes->firstWhere('slug', $request->rute);
        }

        return view('pages.tourist-map', compact(
            'destinations',
            'routes',
            'googleMapsApiKey',
            'selectedDestination',
            'selectedRoute'
        ));
    }

    /**
     * Endpoint API Publik untuk Destinasi Aktif
     * Route: GET /api/tourist-destinations
     */
    public function apiDestinations()
    {
        $destinations = TouristDestination::where('is_active', true)
            ->orderBy('sort_order')
            ->select([
                'id', 'name', 'slug', 'description', 'address',
                'latitude', 'longitude', 'image', 'google_maps_url', 'sort_order'
            ])
            ->get()
            ->map(function ($dest) {
                return [
                    'id'               => $dest->id,
                    'name'             => $dest->name,
                    'slug'             => $dest->slug,
                    'description'      => $dest->description,
                    'address'          => $dest->address,
                    'latitude'         => (float) $dest->latitude,
                    'longitude'        => (float) $dest->longitude,
                    'image'            => $dest->image,
                    'google_maps_url'  => $dest->navigation_url,
                    'coordinates_text' => $dest->coordinates_text,
                ];
            });

        return response()->json([
            'success' => true,
            'count'   => $destinations->count(),
            'data'    => $destinations,
        ]);
    }

    /**
     * Endpoint API Publik untuk Rute Perjalanan Aktif
     * Route: GET /api/tourist-routes
     */
    public function apiRoutes()
    {
        $routes = TouristRoute::where('is_active', true)
            ->with(['destinations' => function ($q) {
                $q->where('is_active', true)->select([
                    'tourist_destinations.id', 'name', 'slug', 'latitude', 'longitude', 'address'
                ]);
            }])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($r) {
                return [
                    'id'              => $r->id,
                    'name'            => $r->name,
                    'slug'            => $r->slug,
                    'description'     => $r->description,
                    'start_name'      => $r->start_name,
                    'start_latitude'  => (float) $r->start_latitude,
                    'start_longitude' => (float) $r->start_longitude,
                    'end_name'        => $r->end_name,
                    'end_latitude'    => (float) $r->end_latitude,
                    'end_longitude'   => (float) $r->end_longitude,
                    'distance'        => $r->distance,
                    'duration'        => $r->duration,
                    'google_maps_url' => $r->navigation_url,
                    'destinations'    => $r->destinations->map(function ($d) {
                        return [
                            'id'        => $d->id,
                            'name'      => $d->name,
                            'latitude'  => (float) $d->latitude,
                            'longitude' => (float) $d->longitude,
                            'order'     => $d->pivot->sort_order,
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'count'   => $routes->count(),
            'data'    => $routes,
        ]);
    }
}
