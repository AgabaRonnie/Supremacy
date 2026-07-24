<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tracks = $this->scoped(Track::query())
            ->with(['artist', 'album'])
            ->orderBy('artist_id')->orderByDesc('release_date')
            ->get();

        return view('admin.tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('admin.tracks.form', [
            'track' => new Track(),
            'artists' => $this->artistOptions(),
            'albums' => $this->scoped(Album::query())->orderBy('title')->get(['id', 'title', 'artist_id']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request);
        $data['slug'] = $this->uniqueSlugFor(Track::class, $data['title'], null, $data['artist_id']);
        $data['album_id'] = $this->validAlbumId($request, $data['artist_id']);

        if ($cover = $this->resolveImageInput($request, 'cover', 'tracks')) {
            $data['cover'] = $cover;
        }

        Track::create($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track added.');
    }

    public function edit(Track $track)
    {
        $this->authorizeOwnership($track);

        return view('admin.tracks.form', [
            'track' => $track,
            'artists' => $this->artistOptions(),
            'albums' => $this->scoped(Album::query())->orderBy('title')->get(['id', 'title', 'artist_id']),
        ]);
    }

    public function update(Request $request, Track $track)
    {
        $this->authorizeOwnership($track);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request);
        }
        $artistId = $data['artist_id'] ?? $track->artist_id;
        if ($data['title'] !== $track->title) {
            $data['slug'] = $this->uniqueSlugFor(Track::class, $data['title'], $track->id, $artistId);
        }
        $data['album_id'] = $this->validAlbumId($request, $artistId);

        if ($cover = $this->resolveImageInput($request, 'cover', 'tracks')) {
            $data['cover'] = $cover;
        }

        $track->update($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track updated.');
    }

    public function destroy(Track $track)
    {
        $this->authorizeOwnership($track);
        $track->delete();

        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted.');
    }

    // Album must belong to the same artist as the track.
    private function validAlbumId(Request $request, int $artistId): ?int
    {
        $albumId = $request->input('album_id');
        if (!$albumId) {
            return null;
        }

        $album = Album::find($albumId);
        return ($album && (int) $album->artist_id === $artistId) ? (int) $albumId : null;
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'preview_audio' => 'nullable|url|max:500',
            'is_free' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]) + [
            'is_free' => $request->boolean('is_free'),
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
            'links' => $this->collectLinks($request),
        ];
    }
}
