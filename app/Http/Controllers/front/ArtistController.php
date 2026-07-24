<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Artist;
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

        return view('front.artist', compact('artist', 'upcomingEvents'));
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
