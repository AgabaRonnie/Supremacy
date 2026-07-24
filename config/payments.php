<?php

/*
|--------------------------------------------------------------------------
| Payments configuration — Supremacy Studios
|--------------------------------------------------------------------------
|
| driver: which gateway to use once its keys are filled in.
|   'whatsapp'    -> no online gateway yet; buyers complete orders on WhatsApp
|   'flutterwave' -> Mobile Money (MTN/Airtel) + cards via Flutterwave
|   'pesapal'     -> Mobile Money + cards via Pesapal
|
| TODO(SUPREMACY): when you receive the real API keys, put them in .env and
| switch PAYMENT_DRIVER. Nothing else on the site needs to change — the
| checkout automatically starts charging online once keys are present.
|
*/

return [

    'driver' => env('PAYMENT_DRIVER', 'whatsapp'),

    'currency' => env('PAYMENT_CURRENCY', 'UGX'),

    'flutterwave' => [
        'public_key' => env('FLUTTERWAVE_PUBLIC_KEY', ''),   // TODO: FLWPUBK-xxxx
        'secret_key' => env('FLUTTERWAVE_SECRET_KEY', ''),   // TODO: FLWSECK-xxxx
        'secret_hash' => env('FLUTTERWAVE_SECRET_HASH', ''), // TODO: webhook verification hash
        'base_url' => env('FLUTTERWAVE_BASE_URL', 'https://api.flutterwave.com/v3'),
    ],

    'pesapal' => [
        'consumer_key' => env('PESAPAL_CONSUMER_KEY', ''),       // TODO
        'consumer_secret' => env('PESAPAL_CONSUMER_SECRET', ''), // TODO
        'base_url' => env('PESAPAL_BASE_URL', 'https://pay.pesapal.com/v3'),
    ],
];
