<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyConverter
{
    protected $client;
    protected $baseUrl = 'https://v6.exchangerate-api.com/v6';
    protected $apiKey = 'de88c5115b7e6818fbc47595';
    protected $cacheKey = 'exchange_rates';
    protected $cacheTtl = 3600; // 1 hour

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false, // untuk development, production sebaiknya true
        ]);

        $this->cacheTtl = config('finance.converter.cache_ttl', 3600);
        $this->apiKey = config('finance.converter.api_key', $this->apiKey);
        $this->baseUrl = config('finance.converter.api_url', $this->baseUrl);
    }

    /**
     * Get exchange rate from base currency to target currency
     */
    public function getRate(string $from = 'IDR', string $to = 'USD'): float
    {
        try {
            $rates = $this->getRates();

            if (!isset($rates[$from]) || !isset($rates[$to])) {
                Log::warning("Currency rate not found for {$from} to {$to}");
                return $this->getFallbackRate($from, $to);
            }

            // API biasanya return rate terhadap base (EUR), jadi perlu kalkulasi
            $baseRate = $rates[$from] ?? 1;
            $targetRate = $rates[$to] ?? 1;

            return $targetRate / $baseRate;
        } catch (\Exception $e) {
            Log::error('Currency conversion error: ' . $e->getMessage());
            return $this->getFallbackRate($from, $to);
        }
    }

    /**
     * Convert amount from one currency to another
     */
    public function convert(float $amount, string $from = 'IDR', string $to = 'USD'): float
    {
        $rate = $this->getRate($from, $to);
        return round($amount * $rate, 2);
    }

    /**
     * Get all exchange rates from cache or API
     */
    protected function getRates(): array
    {
        return Cache::remember($this->cacheKey, $this->cacheTtl, function () {
            $rates = $this->fetchRatesFromApi();
            // Cache timestamp juga
            Cache::put($this->cacheKey . '_timestamp', time(), $this->cacheTtl);
            return $rates;
        });
    }

    /**
     * Fetch rates from external API
     */
    protected function fetchRatesFromApi(): array
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/{$this->apiKey}/latest/USD", [
                'query' => [
                    'symbols' => 'IDR,USD,EUR'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data || !isset($data['conversion_rates'])) {
                throw new \Exception('Invalid API response structure');
            }

            return $data['conversion_rates'];
        } catch (RequestException $e) {
            Log::error('Exchange rate API error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fallback rates jika API gagal
     */
    protected function getFallbackRate(string $from, string $to): float
    {
        $fallbackRates = [
            'IDR' => [
                'USD' => 1 / config('finance.idr_to_usd_rate', 16000),
                'EUR' => 1 / config('finance.idr_to_eur_rate', 17000),
            ],
            'USD' => [
                'IDR' => config('finance.idr_to_usd_rate', 16000),
                'EUR' => config('finance.usd_to_eur_rate', 0.85),
            ],
            'EUR' => [
                'IDR' => config('finance.eur_to_idr_rate', 17000),
                'USD' => config('finance.eur_to_usd_rate', 1.18),
            ],
        ];

        return $fallbackRates[$from][$to] ?? 1;
    }

    /**
     * Clear cache untuk force refresh rate
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Get last update time
     */
    public function getLastUpdate(): ?string
    {
        $cached = Cache::get($this->cacheKey . '_timestamp');
        return $cached ? date('Y-m-d H:i:s', $cached) : null;
    }

    /**
     * Debug cache info
     */
    public function debugCache(): array
    {
        return [
            'rates_cache' => Cache::get($this->cacheKey),
            'timestamp_cache' => Cache::get($this->cacheKey . '_timestamp'),
            'cache_key' => $this->cacheKey,
            'cache_ttl' => $this->cacheTtl,
        ];
    }
}
