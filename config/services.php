<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Konfigurasi layanan pihak ketiga seperti Google Maps API.
    | API key diambil aman dari environment variable (.env) tanpa hardcode.
    |
    */

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY', ''),
    ],

];
