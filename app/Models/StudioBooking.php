<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudioBooking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'preferred_date' => 'date',
    ];
}
