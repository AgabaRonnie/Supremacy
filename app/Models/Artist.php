<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artist extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /* ------------------------------- Relations ------------------------------ */

    public function links()
    {
        return $this->hasMany(ArtistLink::class)->orderBy('sort_order');
    }

    public function socialLinks()
    {
        return $this->links()->where('type', 'social');
    }

    public function streamingLinks()
    {
        return $this->links()->where('type', 'streaming');
    }

    public function albums()
    {
        return $this->hasMany(Album::class)->orderBy('sort_order');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class)->orderBy('sort_order');
    }

    public function singles()
    {
        return $this->tracks()->whereNull('album_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('starts_at');
    }

    public function upcomingEvents()
    {
        return $this->events()->where('starts_at', '>=', now());
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('sort_order');
    }

    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class)->where('is_active', true);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /* ------------------------------- Helpers -------------------------------- */

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Images may be a full URL (dummy/seeded) or a local path.
    public function getPhotoUrlAttribute()
    {
        return $this->resolveImage($this->photo);
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->resolveImage($this->cover_image);
    }

    public static function resolveImage($path, $fallback = 'img/final_logo.JPG')
    {
        if (!$path) {
            return asset($fallback);
        }
        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
    }
}
