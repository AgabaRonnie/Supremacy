<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\ArtistLink;
use App\Models\Event;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\Track;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ArtistSeeder extends Seeder
{
    /**
     * NOTE: All content below is DUMMY/PLACEHOLDER data (bios, links, images,
     * prices, dates). Real content will be fed in by admins or by the artists
     * themselves through the artist portal, where they can edit/delete all of it.
     */
    public function run()
    {
        $img = fn ($id, $w = 1200) => "https://images.unsplash.com/{$id}?auto=format&fit=crop&w={$w}&q=80";

        $artists = [
            [
                'name' => 'Rinex Pro',
                'tagline' => 'The sound of the new Kampala.',
                'genre' => 'Afrobeat / Dancehall',
                'bio' => "Rinex Pro is an Afrobeat and dancehall artist signed to Supremacy Studios, Kampala. Known for high-energy performances and melodies that fuse East African rhythm with modern Afro-pop, Rinex Pro has been building a loyal following across Uganda and beyond.\n\nSince joining Supremacy Studios, Rinex Pro has released a string of singles and headlined shows around Kampala, steadily becoming one of the most exciting new voices on the scene.",
                'photo' => 'uploads/artists/rinex-pro.jpg',
                'cover_image' => $img('photo-1493225457124-a3eb161ffa5f', 1800),
                'gallery' => [$img('photo-1470225620780-dba8ba36b745'), $img('photo-1516450360452-9312f5e86fc7'), $img('photo-1514320291840-2e0a9bf2a9ae')],
                'joined_year' => 2022,
                'sort_order' => 1,
                'links' => [
                    ['social', 'instagram', 'https://instagram.com/rinexpro'],
                    ['social', 'x', 'https://x.com/rinexpro'],
                    ['social', 'tiktok', 'https://tiktok.com/@rinexpro'],
                    ['social', 'youtube', 'https://youtube.com/@rinexpro'],
                    ['streaming', 'spotify', 'https://open.spotify.com/artist/rinexpro'],
                    ['streaming', 'apple-music', 'https://music.apple.com/artist/rinexpro'],
                    ['streaming', 'boomplay', 'https://boomplay.com/artists/rinexpro'],
                    ['streaming', 'audiomack', 'https://audiomack.com/rinexpro'],
                ],
                'albums' => [
                    [
                        'title' => 'Kampala Nights',
                        'cover' => $img('photo-1470229722913-7c0e2dbbafd3', 900),
                        'release_date' => '2025-11-14',
                        'description' => 'The debut album — 12 tracks about the city after dark.',
                        'price' => 25000,
                        'tracks' => ['City Lights', 'Omukwano', 'Till Morning', 'Nankulabye Anthem'],
                    ],
                ],
                'singles' => [
                    ['Fire Tonight', '2026-03-20', 5000],
                    ['Sikika', '2026-06-05', 5000],
                    ['One Call', '2025-08-01', null],
                ],
                'products' => [
                    ['Rinex Pro "Kampala Nights" Tee', 45000, $img('photo-1521572163474-6864f9cf17ab', 900), 'Official black & white album tee. 100% cotton.'],
                    ['Rinex Pro Snapback Cap', 35000, $img('photo-1588850561407-ed78c282e89b', 900), 'Embroidered logo snapback.'],
                ],
                'events' => [
                    ['Kampala Nights Live', 'Lugogo Cricket Oval', 'Kampala', '+45 days', 'UGX 30,000 - 100,000'],
                    ['Campus Tour: Makerere', 'Makerere University Freedom Square', 'Kampala', '+20 days', 'Free entry'],
                ],
                'videos' => [
                    ['Fire Tonight (Official Video)', 'https://www.youtube.com/watch?v=M7lc1UVf-VE'],
                    ['Sikika (Visualizer)', 'https://www.youtube.com/watch?v=ScMzIvxBSi4'],
                ],
                'plans' => [
                    ['Inner Circle', 10000, 'monthly', ['Early access to new releases', 'Exclusive behind-the-scenes content', 'Monthly Q&A']],
                ],
            ],
            [
                'name' => 'Voltag Music',
                'tagline' => 'Electric Afro-fusion, engineered at Supremacy.',
                'genre' => 'Afro-Electronic / Producer',
                'bio' => "Voltag Music is a producer and performing artist blending Afro rhythms with electronic energy. As one of the in-house creative forces at Supremacy Studios, Voltag has produced records for artists across the label while building a solo catalogue of genre-bending releases.\n\nWhen not on stage, Voltag is behind the console at the Supremacy recording studio in Nankulabye, shaping the label's signature sound.",
                'photo' => 'uploads/artists/voltag-music.jpg',
                'cover_image' => $img('photo-1470225620780-dba8ba36b745', 1800),
                'gallery' => [$img('photo-1524650359799-842906ca1c06'), $img('photo-1519892300165-cb5542fb47c7')],
                'joined_year' => 2021,
                'sort_order' => 2,
                'links' => [
                    ['social', 'instagram', 'https://instagram.com/voltagmusic'],
                    ['social', 'youtube', 'https://youtube.com/@voltagmusic'],
                    ['social', 'facebook', 'https://facebook.com/voltagmusic'],
                    ['streaming', 'spotify', 'https://open.spotify.com/artist/voltagmusic'],
                    ['streaming', 'apple-music', 'https://music.apple.com/artist/voltagmusic'],
                    ['streaming', 'audiomack', 'https://audiomack.com/voltagmusic'],
                ],
                'albums' => [
                    [
                        'title' => 'Voltage',
                        'cover' => $img('photo-1459749411175-04bf5292ceea', 900),
                        'release_date' => '2026-01-30',
                        'description' => 'An 8-track electronic Afro-fusion project.',
                        'price' => 20000,
                        'tracks' => ['Plug In', 'Current', 'Shockwave', 'Grid'],
                    ],
                ],
                'singles' => [
                    ['High Voltage', '2026-05-15', 5000],
                    ['Amplify', '2025-12-12', null],
                ],
                'products' => [
                    ['Voltag Hoodie', 90000, $img('photo-1556821840-3a63f95609a7', 900), 'Heavyweight black hoodie with white Voltag print.'],
                ],
                'events' => [
                    ['Voltag Live Set — Industry Night', 'Design Hub Kampala', 'Kampala', '+30 days', 'UGX 20,000'],
                ],
                'videos' => [
                    ['High Voltage (Live Session)', 'https://www.youtube.com/watch?v=M7lc1UVf-VE'],
                ],
                'plans' => [],
            ],
            [
                'name' => 'Ronnie Peace',
                'tagline' => 'Soul, truth and melody.',
                'genre' => 'R&B / Soul',
                'bio' => "Ronnie Peace is an R&B and soul singer-songwriter whose music speaks about love, hope and everyday life in Uganda. With a voice that critics call 'honey over fire', Ronnie Peace writes and records at Supremacy Studios, where every song is crafted to last.\n\nRonnie's live acoustic sessions have become a signature — intimate, honest and unforgettable.",
                'photo' => 'uploads/artists/ronnie-peace.jpg',
                'cover_image' => $img('photo-1511671782779-c97d3d27a1d4', 1800),
                'gallery' => [$img('photo-1487180144351-b8472da7d491'), $img('photo-1598488035139-bdbb2231ce04')],
                'joined_year' => 2023,
                'sort_order' => 3,
                'links' => [
                    ['social', 'instagram', 'https://instagram.com/ronniepeace'],
                    ['social', 'x', 'https://x.com/ronniepeace'],
                    ['social', 'youtube', 'https://youtube.com/@ronniepeace'],
                    ['streaming', 'spotify', 'https://open.spotify.com/artist/ronniepeace'],
                    ['streaming', 'apple-music', 'https://music.apple.com/artist/ronniepeace'],
                    ['streaming', 'boomplay', 'https://boomplay.com/artists/ronniepeace'],
                ],
                'albums' => [],
                'singles' => [
                    ['Peace of Mind', '2026-04-10', 5000],
                    ['Nkwagala', '2026-02-14', 5000],
                    ['Sunrise', '2025-10-03', null],
                ],
                'products' => [
                    ['Ronnie Peace Acoustic Sessions CD', 30000, $img('photo-1539375665275-f9de415ef9ac', 900), 'Limited-edition signed CD.'],
                ],
                'events' => [
                    ['Acoustic Night with Ronnie Peace', 'The Square Place', 'Kampala', '+15 days', 'UGX 50,000'],
                ],
                'videos' => [
                    ['Nkwagala (Official Video)', 'https://www.youtube.com/watch?v=ScMzIvxBSi4'],
                ],
                'plans' => [
                    ['Superfan', 15000, 'monthly', ['Unreleased acoustic versions', 'Meet & greet priority', 'Name in album credits']],
                ],
            ],
            [
                'name' => 'Trekka Man',
                'tagline' => 'Straight from the streets, straight to the top.',
                'genre' => 'Hip-Hop / Drill',
                'bio' => "Trekka Man is the rawest pen at Supremacy Studios — a hip-hop and drill artist telling the real stories of Kampala's streets. The newest signing on the roster, Trekka Man is currently locked in the studio working on his debut project.\n\nKeep your eyes here — the first drop is loading.",
                'photo' => 'uploads/artists/trekka-man.jpg',
                'cover_image' => $img('photo-1508700115892-45ecd05ae2ad', 1800),
                'gallery' => [],
                'joined_year' => 2026,
                'sort_order' => 4,
                'links' => [
                    ['social', 'instagram', 'https://instagram.com/trekkaman'],
                    ['social', 'tiktok', 'https://tiktok.com/@trekkaman'],
                    ['streaming', 'audiomack', 'https://audiomack.com/trekkaman'],
                ],
                // Intentionally sparse: demonstrates the "no albums / no events /
                // no merch yet" empty states on the artist page.
                'albums' => [],
                'singles' => [
                    ['Trekk Talk (Freestyle)', '2026-07-01', null],
                ],
                'products' => [],
                'events' => [],
                'videos' => [],
                'plans' => [],
            ],
        ];

        foreach ($artists as $data) {
            $artist = Artist::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'tagline' => $data['tagline'],
                'genre' => $data['genre'],
                'bio' => $data['bio'],
                'photo' => $data['photo'],
                'cover_image' => $data['cover_image'],
                'gallery' => $data['gallery'],
                'location' => 'Kampala, Uganda',
                'joined_year' => $data['joined_year'],
                'is_published' => true,
                'sort_order' => $data['sort_order'],
            ]);

            foreach ($data['links'] as $i => [$type, $platform, $url]) {
                ArtistLink::create([
                    'artist_id' => $artist->id,
                    'type' => $type,
                    'platform' => $platform,
                    'url' => $url,
                    'sort_order' => $i,
                ]);
            }

            foreach ($data['albums'] as $a) {
                $album = Album::create([
                    'artist_id' => $artist->id,
                    'title' => $a['title'],
                    'slug' => Str::slug($a['title']),
                    'cover' => $a['cover'],
                    'release_date' => $a['release_date'],
                    'description' => $a['description'],
                    'price' => $a['price'],
                    'links' => [
                        'spotify' => 'https://open.spotify.com/album/' . Str::slug($a['title']),
                        'apple-music' => 'https://music.apple.com/album/' . Str::slug($a['title']),
                        'boomplay' => 'https://boomplay.com/albums/' . Str::slug($a['title']),
                    ],
                ]);

                foreach ($a['tracks'] as $i => $trackTitle) {
                    Track::create([
                        'artist_id' => $artist->id,
                        'album_id' => $album->id,
                        'title' => $trackTitle,
                        'slug' => Str::slug($trackTitle),
                        'release_date' => $a['release_date'],
                        'price' => 3000,
                        'links' => [
                            'spotify' => 'https://open.spotify.com/track/' . Str::slug($trackTitle),
                            'apple-music' => 'https://music.apple.com/song/' . Str::slug($trackTitle),
                        ],
                        'sort_order' => $i,
                    ]);
                }
            }

            foreach ($data['singles'] as $i => [$title, $date, $price]) {
                Track::create([
                    'artist_id' => $artist->id,
                    'album_id' => null,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'cover' => $data['cover_image'],
                    'release_date' => $date,
                    'price' => $price,
                    'is_free' => $price === null,
                    'links' => [
                        'spotify' => 'https://open.spotify.com/track/' . Str::slug($title),
                        'apple-music' => 'https://music.apple.com/song/' . Str::slug($title),
                        'boomplay' => 'https://boomplay.com/songs/' . Str::slug($title),
                        'audiomack' => 'https://audiomack.com/song/' . Str::slug($title),
                    ],
                    'sort_order' => $i,
                ]);
            }

            foreach ($data['products'] as $i => [$name, $price, $image, $description]) {
                Product::create([
                    'artist_id' => $artist->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'price' => $price,
                    'images' => [$image],
                    'stock' => 50,
                    'sort_order' => $i,
                ]);
            }

            foreach ($data['events'] as [$title, $venue, $city, $offset, $priceInfo]) {
                Event::create([
                    'artist_id' => $artist->id,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'venue' => $venue,
                    'city' => $city,
                    'starts_at' => now()->modify($offset)->setTime(19, 0),
                    'price_info' => $priceInfo,
                    'image' => $data['cover_image'],
                    'description' => 'Dummy event details — full description will be added by the admin or the artist.',
                ]);
            }

            foreach ($data['videos'] as $i => [$title, $url]) {
                Video::create([
                    'artist_id' => $artist->id,
                    'title' => $title,
                    'youtube_url' => $url,
                    'sort_order' => $i,
                ]);
            }

            foreach ($data['plans'] as [$name, $price, $interval, $perks]) {
                SubscriptionPlan::create([
                    'artist_id' => $artist->id,
                    'name' => $name,
                    'price' => $price,
                    'interval' => $interval,
                    'perks' => $perks,
                ]);
            }

            // Artist portal login. Default password = stage name (lowercase, no
            // spaces) + 2026, e.g. "rinexpro2026". Artists change it after handover.
            $defaultPassword = Str::lower(str_replace(' ', '', $data['name'])) . '2026';
            User::firstOrCreate(
                ['email' => Str::slug($data['name'], '') . '@supremacystudios.com'],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($defaultPassword),
                    'role' => 'artist',
                    'artist_id' => $artist->id,
                ]
            );
        }
    }
}
