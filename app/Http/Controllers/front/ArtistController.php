<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Track;
use App\Services\Analytics;
use Endroid\QrCode\Builder\Builder;

class ArtistController extends Controller
{
    public function show(Artist $artist)
    {
        abort_unless($artist->is_published, 404);

        $artist->load([
            'links',
            'albums' => fn ($q) => $q->published()->withCount('tracks'),
            'singles' => fn ($q) => $q->published()->orderByDesc('release_date'),
            'products' => fn ($q) => $q->published(),
            'videos' => fn ($q) => $q->published(),
            'subscriptionPlans',
        ]);

        $upcomingEvents = $artist->upcomingEvents()->published()->get();

        Analytics::view($artist, 'profile');

        return view('front.artist', compact('artist', 'upcomingEvents'));
    }

    /**
     * Smart link: /{artist}/{track} — one shareable page for a song with
     * every platform on it (like Linkfire, but ours).
     */
    public function smartlink(Artist $artist, Track $track)
    {
        abort_unless($artist->is_published && $track->is_published, 404);

        $track->load('album');

        Analytics::view($artist, 'smartlink', $track);

        return view('front.smartlink', compact('artist', 'track'));
    }

    /**
     * Electronic Press Kit: /{artist}/epk — a print-ready one-pager for
     * promoters, media and bookers (browser Print -> Save as PDF).
     */
    public function epk(Artist $artist)
    {
        abort_unless($artist->is_published, 404);

        $artist->load([
            'links',
            'albums' => fn ($q) => $q->published(),
            'tracks' => fn ($q) => $q->published()->orderByDesc('release_date'),
        ]);

        $upcomingEvents = $artist->upcomingEvents()->published()->get();
        $pastEventsCount = $artist->events()->published()->where('starts_at', '<', now())->count();

        Analytics::view($artist, 'epk');

        return view('front.epk', compact('artist', 'upcomingEvents', 'pastEventsCount'));
    }

    // QR code that opens the artist's page — for posters, flyers and sharing.
    public function qr(Artist $artist)
    {
        abort_unless($artist->is_published, 404);

        $result = Builder::create()
            ->data(url('/' . $artist->slug))
            ->size(640)
            ->margin(24)
            ->build();

        return response($result->getString(), 200)
            ->header('Content-Type', $result->getMimeType())
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
