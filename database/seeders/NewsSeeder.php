<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $img = fn ($id) => "https://images.unsplash.com/{$id}?auto=format&fit=crop&w=1200&q=80";

        $posts = [
            [
                'title' => 'Supremacy Studios signs Trekka Man',
                'excerpt' => 'The newest voice of Kampala hip-hop joins the family.',
                'image' => $img('photo-1508700115892-45ecd05ae2ad'),
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Rinex Pro announces "Kampala Nights Live"',
                'excerpt' => 'The debut album comes to the stage at Lugogo Cricket Oval.',
                'image' => $img('photo-1493225457124-a3eb161ffa5f'),
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Studio upgrade complete at Nankulabye',
                'excerpt' => 'New console, new booth, same legendary sound.',
                'image' => $img('photo-1519892300165-cb5542fb47c7'),
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($posts as $p) {
            NewsPost::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']),
                'excerpt' => $p['excerpt'],
                'body' => $p['excerpt'] . ' (Dummy article body — full story will be written by the admin.)',
                'image' => $p['image'],
                'published_at' => $p['published_at'],
            ]);
        }
    }
}
