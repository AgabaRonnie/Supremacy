<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistLink extends Model
{
    protected $guarded = [];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
