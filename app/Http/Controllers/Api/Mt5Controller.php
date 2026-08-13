<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\Mt5SyncService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Mt5Controller extends Controller
{
    // Mt5Controller.php
    public function webhook(Request $request, Mt5SyncService $syncService): JsonResponse
    {
        $rawContent = $request->getContent();
        $rawContent = str_replace("\0", "", $rawContent);
        $decoded = json_decode($rawContent, true);

        Log::info('MT5 Webhook Received', [
            'decoded' => $decoded,
            'account_id' => $decoded['account_id'] ?? null,
        ]);

        $accountId = $decoded['account_id'] ?? null;
        if (!$accountId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing account_id in webhook payload.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $account = Account::find($accountId);
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => "Account with id {$accountId} tidak ditemukan.",
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            // 🔥 PISAHKAN POSISI TERBUKA DAN HISTORY
            $result = $syncService->syncAccountTradesFromPayload($account, $decoded);

            return response()->json([
                'success' => true,
                'message' => 'MT5 webhook sinkronisasi berhasil.',
                'result' => $result,
            ], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            Log::error('MT5 webhook error: ' . $exception->getMessage(), [
                'account_id' => $accountId,
                'payload' => $decoded,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses webhook MT5.',
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
