<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\LinkClick;
use App\Models\PageView;
use App\Models\Track;

/**
 * Lightweight first-party analytics: page views on artist pages and clicks
 * on streaming/social links. Never breaks a request — failures are silent.
 */
class Analytics
{
    private static function isBot(): bool
    {
        $ua = strtolower((string) request()->userAgent());

        return $ua === '' || preg_match('/bot|crawl|spider|slurp|curl|wget|facebookexternalhit|whatsapp|telegram|preview/i', $ua);
    }

    public static function view(Artist $artist, string $page, ?Track $track = null): void
    {
        if (self::isBot()) {
            return;
        }

        try {
            PageView::create([
                'artist_id' => $artist->id,
                'page' => $page,
                'track_id' => optional($track)->id,
            ]);
        } catch (\Throwable $e) {
            // analytics must never break the page
        }
    }

    public static function click(Artist $artist, string $platform, ?Track $track = null): void
    {
        if (self::isBot()) {
            return;
        }

        try {
            LinkClick::create([
                'artist_id' => $artist->id,
                'track_id' => optional($track)->id,
                'platform' => $platform,
            ]);
        } catch (\Throwable $e) {
            //
        }
    }
}
