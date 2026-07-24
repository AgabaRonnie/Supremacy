<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $img = fn ($id) => "https://images.unsplash.com/{$id}?auto=format&fit=crop&w=1200&q=80";

        $services = [
            [
                'title' => 'Music Recording & Production',
                'summary' => 'World-class recording, mixing and mastering at our studio in Nankulabye — free for signed artists, bookable by everyone else.',
                'image' => $img('photo-1519892300165-cb5542fb47c7'),
            ],
            [
                'title' => 'Music Distribution',
                'summary' => 'Custom distribution that puts your music on Spotify, Apple Music, Boomplay, Audiomack, YouTube Music and more.',
                'image' => $img('photo-1571330735066-03aaa9429d89'),
            ],
            [
                'title' => 'Playlist Pitching',
                'summary' => 'We pitch your releases to editorial and independent playlists across the major streaming platforms.',
                'image' => $img('photo-1524650359799-842906ca1c06'),
            ],
            [
                'title' => 'Artist Management & Development',
                'summary' => 'Branding, strategy, bookings and career growth — the full machinery behind every Supremacy artist.',
                'image' => $img('photo-1511671782779-c97d3d27a1d4'),
            ],
            [
                'title' => 'Publishing & Sync Licensing',
                'summary' => 'We place music in film, TV, adverts and games, and make sure songwriters get paid.',
                'image' => $img('photo-1487180144351-b8472da7d491'),
            ],
        ];

        foreach ($services as $i => $s) {
            Service::create([
                'title' => $s['title'],
                'slug' => Str::slug($s['title']),
                'summary' => $s['summary'],
                'description' => $s['summary'] . ' (Full service description to be added.)',
                'image' => $s['image'],
                'sort_order' => $i,
            ]);
        }
    }
}
