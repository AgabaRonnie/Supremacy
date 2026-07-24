<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FanSubscription extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
