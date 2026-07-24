<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'perks' => 'array',
        'is_active' => 'boolean',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
