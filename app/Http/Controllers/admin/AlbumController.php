<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $albums = $this->scoped(Album::query())
            ->with('artist')->withCount('tracks')
            ->orderBy('artist_id')->orderBy('sort_order')
            ->get();

        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.form', ['album' => new Album(), 'artists' => $this->artistOptions()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request);
        $data['slug'] = $this->uniqueSlugFor(Album::class, $data['title'], null, $data['artist_id']);

        if ($cover = $this->resolveImageInput($request, 'cover', 'albums')) {
            $data['cover'] = $cover;
        }

        Album::create($data);

        return redirect()->route('admin.albums.index')->with('success', 'Album added.');
    }

    public function edit(Album $album)
    {
        $this->authorizeOwnership($album);
        return view('admin.albums.form', ['album' => $album, 'artists' => $this->artistOptions()]);
    }

    public function update(Request $request, Album $album)
    {
        $this->authorizeOwnership($album);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request);
        }
        if ($data['title'] !== $album->title) {
            $data['slug'] = $this->uniqueSlugFor(Album::class, $data['title'], $album->id, $album->artist_id);
        }
        if ($cover = $this->resolveImageInput($request, 'cover', 'albums')) {
            $data['cover'] = $cover;
        }

        $album->update($data);

        return redirect()->route('admin.albums.index')->with('success', 'Album updated.');
    }

    public function destroy(Album $album)
    {
        $this->authorizeOwnership($album);
        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'Album deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'description' => 'nullable|string|max:5000',
            'price' => 'nullable|numeric|min:0',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
            'links' => $this->collectLinks($request),
        ];
    }
}
