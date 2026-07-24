<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $artists = Artist::withCount(['tracks', 'albums', 'products', 'events'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        $artist = new Artist();
        return view('admin.artists.form', compact('artist'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($request->input('name'));
        $data['photo'] = $this->resolveImageInput($request, 'photo');
        $data['cover_image'] = $this->resolveImageInput($request, 'cover_image');

        $artist = Artist::create($data);
        $this->syncLinks($artist, $request);

        return redirect()->route('admin.artists.index')->with('success', 'Artist added successfully.');
    }

    public function edit(Artist $artist)
    {
        $artist->load('links');
        return view('admin.artists.form', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $this->validated($request);

        if ($request->input('name') !== $artist->name) {
            $data['slug'] = $this->uniqueSlug($request->input('name'), $artist->id);
        }

        if ($photo = $this->resolveImageInput($request, 'photo')) {
            $data['photo'] = $photo;
        }
        if ($cover = $this->resolveImageInput($request, 'cover_image')) {
            $data['cover_image'] = $cover;
        }

        $artist->update($data);
        $this->syncLinks($artist, $request);

        return redirect()->route('admin.artists.index')->with('success', 'Artist updated successfully.');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Artist deleted.');
    }

    /* ------------------------------- Internals ------------------------------ */

    private function validated(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'joined_year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }

    private function uniqueSlug($name, $ignoreId = null)
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (Artist::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    // Accepts either a file upload (photo / cover_image) or a pasted URL
    // (photo_url / cover_image_url). Returns a storable value or null.
    private function resolveImageInput(Request $request, $field)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $name = time() . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artists'), $name);
            return 'uploads/artists/' . $name;
        }

        if ($url = $request->input($field . '_url')) {
            return $url;
        }

        return null;
    }

    private function syncLinks(Artist $artist, Request $request)
    {
        $links = collect($request->input('links', []))
            ->filter(fn ($l) => !empty($l['platform']) && !empty($l['url']));

        $artist->links()->delete();

        foreach ($links->values() as $i => $l) {
            ArtistLink::create([
                'artist_id' => $artist->id,
                'type' => $l['type'] ?? 'social',
                'platform' => Str::slug($l['platform']),
                'url' => $l['url'],
                'sort_order' => $i,
            ]);
        }
    }
}
