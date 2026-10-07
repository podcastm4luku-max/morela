<?php

namespace App\Http\Controllers;

use App\Models\TouristDestination;
use App\Models\TouristRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TouristRouteController extends Controller
{
    /**
     * Tampilkan daftar rute wisata
     * Route: /admin/tourist-routes
     */
    public function index(Request $request)
    {
        $query = TouristRoute::with('destinations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('start_name', 'like', "%{$search}%")
                    ->orWhere('end_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $routes = $query->orderBy('sort_order')->paginate(12);
        $totalActive = TouristRoute::where('is_active', true)->count();
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        return view('admin.tourist_routes.index', compact('routes', 'totalActive', 'googleMapsApiKey'));
    }

    /**
     * Form tambah rute wisata baru
     */
    public function create()
    {
        $destinations = TouristDestination::where('is_active', true)->orderBy('sort_order')->get();
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');
        $nextOrder = (TouristRoute::max('sort_order') ?? 0) + 1;

        // Default: Pusat Negeri Morela
        $defaultLat = -3.5512000;
        $defaultLng = 128.2045000;

        return view('admin.tourist_routes.create', compact('destinations', 'googleMapsApiKey', 'nextOrder', 'defaultLat', 'defaultLng'));
    }

    /**
     * Simpan rute wisata baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:tourist_routes,slug',
            'description' => 'nullable|string',
            'start_name' => 'required|string|max:150',
            'start_latitude' => ['required', 'numeric', 'between:-90,90'],
            'start_longitude' => ['required', 'numeric', 'between:-180,180'],
            'end_name' => 'required|string|max:150',
            'end_latitude' => ['required', 'numeric', 'between:-90,90'],
            'end_longitude' => ['required', 'numeric', 'between:-180,180'],
            'distance' => 'nullable|string|max:50',
            'duration' => 'nullable|string|max:50',
            'google_maps_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:1',
            'destinations' => 'nullable|array',
            'destinations.*' => 'exists:tourist_destinations,id',
            'destination_orders' => 'nullable|array',
        ], [
            'name.required' => 'Nama rute wisata wajib diisi.',
            'start_name.required' => 'Nama titik awal perjalanan wajib diisi.',
            'start_latitude.required' => 'Latitude titik awal wajib diisi.',
            'start_longitude.required' => 'Longitude titik awal wajib diisi.',
            'end_name.required' => 'Nama titik akhir perjalanan wajib diisi.',
            'end_latitude.required' => 'Latitude titik akhir wajib diisi.',
            'end_longitude.required' => 'Longitude titik akhir wajib diisi.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $baseSlug = $slug;
        $count = 1;
        while (TouristRoute::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        $route = TouristRoute::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'start_name' => $validated['start_name'],
            'start_latitude' => $validated['start_latitude'],
            'start_longitude' => $validated['start_longitude'],
            'end_name' => $validated['end_name'],
            'end_latitude' => $validated['end_latitude'],
            'end_longitude' => $validated['end_longitude'],
            'distance' => $validated['distance'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
            'sort_order' => $validated['sort_order'] ?? ((TouristRoute::max('sort_order') ?? 0) + 1),
        ]);

        // Hubungkan destinasi yang dilewati dengan urutan sort_order
        if (! empty($validated['destinations'])) {
            $syncData = [];
            $orders = $request->input('destination_orders', []);
            foreach ($validated['destinations'] as $index => $destId) {
                $syncData[$destId] = [
                    'sort_order' => isset($orders[$destId]) ? (int) $orders[$destId] : ($index + 1),
                ];
            }
            $route->destinations()->sync($syncData);
        }

        // Otomatis buat Google Maps Navigation URL jika kosong
        if (empty($route->google_maps_url)) {
            $route->google_maps_url = $route->navigation_url;
            $route->save();
        }

        return redirect()->route('admin.tourist-routes.index')
            ->with('success', "Rute perjalanan '{$route->name}' berhasil dibuat!");
    }

    /**
     * Form edit rute wisata
     */
    public function edit($id)
    {
        $route = TouristRoute::with('destinations')->findOrFail($id);
        $destinations = TouristDestination::where('is_active', true)->orderBy('sort_order')->get();
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        $attachedIds = $route->destinations->pluck('id')->toArray();
        $attachedOrders = $route->destinations->pluck('pivot.sort_order', 'id')->toArray();

        return view('admin.tourist_routes.edit', compact('route', 'destinations', 'attachedIds', 'attachedOrders', 'googleMapsApiKey'));
    }

    /**
     * Update data rute wisata
     */
    public function update(Request $request, $id)
    {
        $route = TouristRoute::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => "nullable|string|max:200|unique:tourist_routes,slug,{$id}",
            'description' => 'nullable|string',
            'start_name' => 'required|string|max:150',
            'start_latitude' => ['required', 'numeric', 'between:-90,90'],
            'start_longitude' => ['required', 'numeric', 'between:-180,180'],
            'end_name' => 'required|string|max:150',
            'end_latitude' => ['required', 'numeric', 'between:-90,90'],
            'end_longitude' => ['required', 'numeric', 'between:-180,180'],
            'distance' => 'nullable|string|max:50',
            'duration' => 'nullable|string|max:50',
            'google_maps_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:1',
            'destinations' => 'nullable|array',
            'destinations.*' => 'exists:tourist_destinations,id',
            'destination_orders' => 'nullable|array',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $route->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'start_name' => $validated['start_name'],
            'start_latitude' => $validated['start_latitude'],
            'start_longitude' => $validated['start_longitude'],
            'end_name' => $validated['end_name'],
            'end_latitude' => $validated['end_latitude'],
            'end_longitude' => $validated['end_longitude'],
            'distance' => $validated['distance'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
            'sort_order' => $validated['sort_order'] ?? $route->sort_order,
        ]);

        // Sync destinasi
        $syncData = [];
        if (! empty($validated['destinations'])) {
            $orders = $request->input('destination_orders', []);
            foreach ($validated['destinations'] as $index => $destId) {
                $syncData[$destId] = [
                    'sort_order' => isset($orders[$destId]) ? (int) $orders[$destId] : ($index + 1),
                ];
            }
        }
        $route->destinations()->sync($syncData);

        // Update google_maps_url jika kosong
        if (empty($route->google_maps_url)) {
            $route->google_maps_url = $route->navigation_url;
            $route->save();
        }

        return redirect()->route('admin.tourist-routes.index')
            ->with('success', "Rute perjalanan '{$route->name}' berhasil diperbarui!");
    }

    /**
     * Hapus rute wisata
     */
    public function destroy($id)
    {
        $route = TouristRoute::findOrFail($id);
        $name = $route->name;
        $route->destinations()->detach();
        $route->delete();

        return redirect()->route('admin.tourist-routes.index')
            ->with('success', "Rute perjalanan '{$name}' berhasil dihapus.");
    }

    /**
     * Toggle status aktif/draft rute
     */
    public function toggleStatus($id)
    {
        $route = TouristRoute::findOrFail($id);
        $route->is_active = ! $route->is_active;
        $route->save();

        $statusText = $route->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Status rute '{$route->name}' berhasil {$statusText}.");
    }
}
