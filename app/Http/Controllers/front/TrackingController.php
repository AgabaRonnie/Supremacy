<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\ArtistLink;
use App\Models\Track;
use App\Services\Analytics;

/**
 * Click-tracked redirects: /go/... logs the click, then sends the fan to the
 * real platform. Powers the per-artist analytics in the portal.
 */
class TrackingController extends Controller
{
    // Artist profile links (social + streaming): /go/link/{artistLink}
    public function link(ArtistLink $link)
    {
        $link->load('artist');

        Analytics::click($link->artist, $link->platform);

        return redirect()->away($link->url);
    }

    // Track platform links: /go/track/{track}/{platform}
    public function track(Track $track, string $platform)
    {
        $links = $track->links ?? [];
        abort_unless(isset($links[$platform]), 404);

        Analytics::click($track->artist, $platform, $track);

        return redirect()->away($links[$platform]);
    }
}
