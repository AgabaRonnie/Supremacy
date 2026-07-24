<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Artist portal: an artist edits their OWN public profile.
 * Identity fields (name, slug, published state) stay label-controlled.
 */
class ProfileController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $artist = Artist::with('links')->findOrFail($this->ownArtistId());
        return view('admin.portal.profile', compact('artist'));
    }

    public function update(Request $request)
    {
        $artist = Artist::findOrFail($this->ownArtistId());

        $data = $request->validate([
            'tagline' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:10000',
            'location' => 'nullable|string|max:255',
            'joined_year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
        ]);

        if ($photo = $this->resolveImageInput($request, 'photo', 'artists')) {
            $data['photo'] = $photo;
        }
        if ($cover = $this->resolveImageInput($request, 'cover_image', 'artists')) {
            $data['cover_image'] = $cover;
        }

        $artist->update($data);

        // Sync social/streaming links
        $links = collect($request->input('links', []))
            ->filter(fn ($l) => !empty($l['platform']) && !empty($l['url']));

        $artist->links()->delete();
        foreach ($links->values() as $i => $l) {
            ArtistLink::create([
                'artist_id' => $artist->id,
                'type' => in_array(($l['type'] ?? ''), ['social', 'streaming']) ? $l['type'] : 'social',
                'platform' => Str::slug($l['platform']),
                'url' => $l['url'],
                'sort_order' => $i,
            ]);
        }

        return back()->with('success', 'Your profile has been updated. Check your public page to see it live.');
    }
}
