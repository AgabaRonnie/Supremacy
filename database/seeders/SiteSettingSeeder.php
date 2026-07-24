<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            'site_name' => 'Supremacy Studios',
            'tagline' => 'Music Label & Recording Studio — Kampala, Uganda',
            'address' => 'Nankulabye, Makerere Hill Road, Kampala, Uganda',
            'phone' => '+256 700 000000',
            'whatsapp' => '+256 700 000000',
            'email' => 'info@supremacystudios.com',
            'instagram' => 'https://instagram.com/supremacystudios',
            'x' => 'https://x.com/supremacystudios',
            'youtube' => 'https://youtube.com/@supremacystudios',
            'tiktok' => 'https://tiktok.com/@supremacystudios',
            'facebook' => 'https://facebook.com/supremacystudios',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }
    }
}
