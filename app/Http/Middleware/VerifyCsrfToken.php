<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',                    // Semua API routes
        'api/mt5/webhook',          // Spesifik webhook
        'mt5/webhook',              // Alternatif
        '*/webhook',                // Wildcard
    ];
}
