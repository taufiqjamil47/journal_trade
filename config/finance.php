<?php

return [
    // Rate konversi default (fallback jika API gagal)
    'idr_to_usd_rate' => env('IDR_TO_USD_RATE', 16000),
    'usd_to_eur_rate' => env('USD_TO_EUR_RATE', 0.85),
    'eur_to_idr_rate' => env('EUR_TO_IDR_RATE', 17000),
    'eur_to_usd_rate' => env('EUR_TO_USD_RATE', 1.18),
    'idr_to_eur_rate' => env('IDR_TO_EUR_RATE', 17000),

    // Currency converter settings
    'converter' => [
        'cache_ttl' => env('CURRENCY_CACHE_TTL', 3600), // 1 hour
        'api_url' => env('CURRENCY_API_URL', 'https://v6.exchangerate-api.com/v6'),
        'api_key' => env('EXCHANGE_RATE_API_KEY', 'de88c5115b7e6818fbc47595'),
        'supported_currencies' => ['IDR', 'USD', 'EUR'],
    ],
];
