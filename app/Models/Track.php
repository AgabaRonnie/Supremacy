<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];

    protected $casts = [
        'links' => 'array',
        'release_date' => 'date',
        'is_free' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getCoverUrlAttribute()
    {
        return Artist::resolveImage($this->cover ?: optional($this->album)->cover);
    }
}
