<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Mt5ApiClient
{
    public function fetchTrades(Account $account): array
    {
        $server = trim($account->mt5_server ?? '');
        if (empty($server)) {
            throw new \RuntimeException('MT5 server URL belum diatur.');
        }

        $url = $this->buildTradesUrl($account);
        $request = Http::timeout(30)->acceptJson();

        if (!empty($account->mt5_api_token)) {
            $request = $request->withToken($account->mt5_api_token);
        }

        Log::info('Requesting MT5 trades from ' . $url, ['account_id' => $account->id]);

        $response = $request->get($url);

        if ($response->failed()) {
            $detail = $this->formatHttpErrorDetail($response);
            if ($response->status() === 404) {
                throw new \RuntimeException('Endpoint MT5 tidak ditemukan (404). Pastikan server yang Anda masukkan adalah URL endpoint JSON yang benar, misalnya https://your-mt5-api.example.com/trades?login=... atau kirim payload ke webhook aplikasi ini. ' . $detail);
            }

            throw new \RuntimeException('Gagal mengambil data MT5. HTTP status: ' . $response->status() . $detail);
        }

        $payload = $response->json();
        if (!is_array($payload)) {
            throw new \RuntimeException('Respons MT5 tidak valid. Diharapkan format JSON array atau objek dengan kunci trades.');
        }

        return $payload;
    }

    protected function buildTradesUrl(Account $account): string
    {
        $server = trim($account->mt5_server ?? '');
        $server = $this->normalizeServerUrl($server);

        $path = parse_url($server, PHP_URL_PATH) ?? '';
        $path = rtrim($path, '/');

        $looksLikeTradesEndpoint = preg_match('#/(trades?|orders?|positions?|history|api(?:/.*)?)$#i', $path) === 1;
        $baseUrl = $server;

        if (empty($path) || $path === '/') {
            $baseUrl = $server . '/trades';
        } elseif (!$looksLikeTradesEndpoint) {
            $baseUrl = $server . '/trades';
        }

        if (!empty($account->mt5_login)) {
            return $this->appendQuery($baseUrl, ['login' => $account->mt5_login]);
        }

        return $baseUrl;
    }

    protected function normalizeServerUrl(string $server): string
    {
        $server = trim($server);
        $server = preg_replace('/\s+/', '', $server);

        if (!Str::startsWith($server, ['http://', 'https://'])) {
            $server = 'https://' . $server;
        }

        $server = rtrim($server, '/');
        if (!filter_var($server, FILTER_VALIDATE_URL)) {
            throw new \RuntimeException('MT5 server URL tidak valid: ' . $server);
        }

        $host = parse_url($server, PHP_URL_HOST);
        if (empty($host) || $host === $server) {
            throw new \RuntimeException('MT5 server host tidak valid: ' . $server);
        }

        if (gethostbyname($host) === $host) {
            throw new \RuntimeException('Gagal menyelesaikan nama host MT5: ' . $host . '. Pastikan MT5 server berupa hostname yang dapat di-resolve atau URL lengkap.');
        }

        return $server;
    }

    protected function appendQuery(string $url, array $params): string
    {
        $delimiter = Str::contains($url, '?') ? '&' : '?';
        return $url . $delimiter . http_build_query($params);
    }

    protected function formatHttpErrorDetail($response): string
    {
        $body = trim((string) $response->body());
        if (empty($body)) {
            return '';
        }

        $snippet = strip_tags($body);
        $snippet = preg_replace('/\s+/', ' ', $snippet);
        $snippet = trim((string) $snippet);

        if ($snippet === '') {
            return '';
        }

        return ' Respons server: ' . Str::limit($snippet, 180);
    }
}
