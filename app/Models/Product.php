<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'is_published' => 'boolean',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getFirstImageUrlAttribute()
    {
        $images = $this->images ?: [];
        return Artist::resolveImage($images[0] ?? null);
    }
}
