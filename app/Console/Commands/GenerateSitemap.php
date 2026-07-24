<?php

namespace App\Console\Commands;

use App\Models\Artist;
use App\Models\NewsPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate sitemap.xml for Supremacy Studios';

    public function handle()
    {
        Log::info('GenerateSitemap command started');

        $sitemap = Sitemap::create();

        // Homepage
        $sitemap->add(
            Url::create(url('/'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );

        // Static pages
        $pages = [
            '/artists' => 0.9,
            '/studio' => 0.8,
            '/services' => 0.8,
            '/events' => 0.8,
            '/news' => 0.7,
            '/about' => 0.6,
            '/contact' => 0.6,
            '/join' => 0.7,
        ];

        foreach ($pages as $path => $priority) {
            $sitemap->add(
                Url::create(url($path))
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority($priority)
            );
        }

        // Artist micro-sites — the most important shareable pages
        foreach (Artist::published()->get() as $artist) {
            $sitemap->add(
                Url::create(url('/' . $artist->slug))
                    ->setLastModificationDate($artist->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.9)
            );
        }

        // News articles
        foreach (NewsPost::published()->get() as $post) {
            $sitemap->add(
                Url::create(url('/news/' . $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap generated successfully.');
        Log::info('Sitemap generated successfully');
    }
}
