<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function show(Artist $artist)
    {
        abort_unless($artist->is_published, 404);

        $artist->load([
            'links',
            'albums' => fn ($q) => $q->published(),
            'singles' => fn ($q) => $q->published(),
            'products' => fn ($q) => $q->published(),
            'videos' => fn ($q) => $q->published(),
            'subscriptionPlans',
        ]);

        $upcomingEvents = $artist->upcomingEvents()->published()->get();

        return view('front.artist', compact('artist', 'upcomingEvents'));
    }
}
