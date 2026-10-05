<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $query = Destination::where('published', true);

        if ($category && in_array($category, ['pantai', 'alam', 'pemandangan', 'religi_sejarah', 'budaya'])) {
            $query->where('category', $category);
        }

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $destinations = $query->latest()->paginate(9);
        return view('destinations.index', compact('destinations', 'category'));
    }

    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)->where('published', true)->firstOrFail();
        $relatedDestinations = Destination::where('published', true)
            ->where('id', '!=', $destination->id)
            ->where('category', $destination->category)
            ->take(3)
            ->get();

        return view('destinations.show', compact('destination', 'relatedDestinations'));
    }

    public function qrCode($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        return view('destinations.qr', compact('destination'));
    }


    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:destinations,slug|max:255',
            'category' => 'required|in:pantai,alam,pemandangan,religi_sejarah,budaya',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'image_url' => 'required|string|max:255',
            'published' => 'boolean',
        ]);

        Destination::create($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destination created.');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug,' . $destination->id,
            'category' => 'required|in:pantai,alam,pemandangan,religi_sejarah,budaya',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'image_url' => 'required|string|max:255',
            'published' => 'boolean',
        ]);

        $destination->update($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destination updated.');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return redirect()->route('admin.destinations.index')->with('success', 'Destination deleted.');
    }

}
