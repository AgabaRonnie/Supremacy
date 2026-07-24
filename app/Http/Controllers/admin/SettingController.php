<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Whitelisted editable settings: key => [label, type]
    public const FIELDS = [
        'site_name' => ['Site Name', 'text'],
        'tagline' => ['Tagline', 'text'],
        'address' => ['Address', 'text'],
        'phone' => ['Phone', 'text'],
        'whatsapp' => ['WhatsApp Number', 'text'],
        'email' => ['Email', 'email'],
        'instagram' => ['Instagram URL', 'url'],
        'x' => ['X (Twitter) URL', 'url'],
        'youtube' => ['YouTube URL', 'url'],
        'tiktok' => ['TikTok URL', 'url'],
        'facebook' => ['Facebook URL', 'url'],
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function edit()
    {
        $values = collect(self::FIELDS)->mapWithKeys(
            fn ($meta, $key) => [$key => SiteSetting::get($key)]
        );

        return view('admin.settings.form', ['fields' => self::FIELDS, 'values' => $values]);
    }

    public function update(Request $request)
    {
        foreach (array_keys(self::FIELDS) as $key) {
            SiteSetting::set($key, (string) $request->input($key, ''));
        }

        return back()->with('success', 'Site settings saved.');
    }
}
