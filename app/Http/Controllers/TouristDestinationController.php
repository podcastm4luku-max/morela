<?php

namespace App\Http\Controllers;

use App\Models\TouristDestination;
use App\Models\TouristRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TouristDestinationController extends Controller
{
    /**
     * Dashboard Ringkasan Peta Wisata & Jelajah Negeri Morela
     * Route: /admin/tourist-maps
     */
    public function mapOverview()
    {
        $destinations = TouristDestination::orderBy('sort_order')->get();
        $routes = TouristRoute::with('destinations')->orderBy('sort_order')->get();

        $stats = [
            'total_destinations' => $destinations->count(),
            'active_destinations' => $destinations->where('is_active', true)->count(),
            'total_routes' => $routes->count(),
            'active_routes' => $routes->where('is_active', true)->count(),
        ];

        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        return view('admin.tourist_maps.index', compact('destinations', 'routes', 'stats', 'googleMapsApiKey'));
    }

    /**
     * Tampilkan daftar destinasi wisata
     * Route: /admin/tourist-destinations
     */
    public function index(Request $request)
    {
        $query = TouristDestination::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $destinations = $query->orderBy('sort_order')->paginate(15);
        $totalActive = TouristDestination::where('is_active', true)->count();
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        return view('admin.tourist_destinations.index', compact('destinations', 'totalActive', 'googleMapsApiKey'));
    }

    /**
     * Form tambah destinasi wisata baru dengan peta interaktif
     */
    public function create()
    {
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');
        $nextOrder = (TouristDestination::max('sort_order') ?? 0) + 1;

        // Koordinat default: Pusat Negeri Morela (-3.5512, 128.2045)
        $defaultLat = -3.5512000;
        $defaultLng = 128.2045000;

        return view('admin.tourist_destinations.create', compact('googleMapsApiKey', 'nextOrder', 'defaultLat', 'defaultLng'));
    }

    /**
     * Simpan destinasi wisata baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:tourist_destinations,slug',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:300',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'image' => 'nullable|string|max:500',
            'google_maps_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:1',
        ], [
            'name.required' => 'Nama destinasi wisata wajib diisi.',
            'latitude.required' => 'Titik koordinat Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus bernilai antara -90 sampai 90.',
            'longitude.required' => 'Titik koordinat Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus bernilai antara -180 sampai 180.',
            'slug.unique' => 'Slug destinasi ini sudah digunakan.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        // Pastikan slug unik
        $baseSlug = $slug;
        $count = 1;
        while (TouristDestination::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        // Generate URL navigasi Google Maps jika kosong
        $googleMapsUrl = $validated['google_maps_url'] ?? null;
        if (empty($googleMapsUrl)) {
            $googleMapsUrl = "https://www.google.com/maps/dir/?api=1&destination={$validated['latitude']},{$validated['longitude']}";
        }

        $destination = TouristDestination::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'image' => $validated['image'] ?? null,
            'google_maps_url' => $googleMapsUrl,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
            'sort_order' => $validated['sort_order'] ?? ((TouristDestination::max('sort_order') ?? 0) + 1),
        ]);

        return redirect()->route('admin.tourist-destinations.index')
            ->with('success', "Destinasi wisata '{$destination->name}' berhasil ditambahkan ke peta!");
    }

    /**
     * Form edit destinasi wisata
     */
    public function edit($id)
    {
        $destination = TouristDestination::findOrFail($id);
        $googleMapsApiKey = config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY', '');

        return view('admin.tourist_destinations.edit', compact('destination', 'googleMapsApiKey'));
    }

    /**
     * Update data destinasi wisata
     */
    public function update(Request $request, $id)
    {
        $destination = TouristDestination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'slug' => "nullable|string|max:200|unique:tourist_destinations,slug,{$id}",
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:300',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'image' => 'nullable|string|max:500',
            'google_maps_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:1',
        ], [
            'name.required' => 'Nama destinasi wisata wajib diisi.',
            'latitude.required' => 'Titik koordinat Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus bernilai antara -90 sampai 90.',
            'longitude.required' => 'Titik koordinat Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus bernilai antara -180 sampai 180.',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        // Generate URL navigasi Google Maps jika kosong
        $googleMapsUrl = $validated['google_maps_url'] ?? null;
        if (empty($googleMapsUrl)) {
            $googleMapsUrl = "https://www.google.com/maps/dir/?api=1&destination={$validated['latitude']},{$validated['longitude']}";
        }

        $destination->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'image' => $validated['image'] ?? null,
            'google_maps_url' => $googleMapsUrl,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
            'sort_order' => $validated['sort_order'] ?? $destination->sort_order,
        ]);

        return redirect()->route('admin.tourist-destinations.index')
            ->with('success', "Destinasi wisata '{$destination->name}' berhasil diperbarui!");
    }

    /**
     * Hapus destinasi wisata
     */
    public function destroy($id)
    {
        $destination = TouristDestination::findOrFail($id);
        $name = $destination->name;
        $destination->delete();

        return redirect()->route('admin.tourist-destinations.index')
            ->with('success', "Destinasi wisata '{$name}' berhasil dihapus dari peta.");
    }

    /**
     * Toggle status aktif/draft destinasi
     */
    public function toggleStatus($id)
    {
        $destination = TouristDestination::findOrFail($id);
        $destination->is_active = ! $destination->is_active;
        $destination->save();

        $statusText = $destination->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Status destinasi '{$destination->name}' berhasil {$statusText}.");
    }
}
