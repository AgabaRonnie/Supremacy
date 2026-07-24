<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'reference';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateReference(): string
    {
        do {
            $reference = 'SS-' . strtoupper(Str::random(8));
        } while (static::where('reference', $reference)->exists());

        return $reference;
    }

    public function getWhatsappUrlAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', (string) SiteSetting::get('whatsapp'));

        $lines = $this->items->map(
            fn ($i) => "- {$i->title} x{$i->quantity} (UGX " . number_format($i->unit_price * $i->quantity) . ')'
        )->implode("\n");

        $text = "Hello Supremacy Studios, I want to complete my order {$this->reference}:\n"
            . $lines . "\nTotal: UGX " . number_format($this->total)
            . "\nName: {$this->name}";

        return "https://wa.me/{$number}?text=" . urlencode($text);
    }
}
