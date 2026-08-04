<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Services\Mt5SyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncMt5Accounts extends Command
{
    protected $signature = 'mt5:sync {--account_id=}';
    protected $description = 'Sync MT5 data for connected accounts.';

    public function handle(Mt5SyncService $syncService)
    {
        $accountId = $this->option('account_id');
        $accounts = Account::where('mt5_sync_enabled', true)
            ->when($accountId, fn($query) => $query->where('id', $accountId))
            ->get();

        if ($accounts->isEmpty()) {
            $this->info('No MT5 connected accounts found.');
            return 0;
        }

        foreach ($accounts as $account) {
            $this->info('Syncing account ' . $account->id . ' (' . $account->name . ')');
            try {
                $result = $syncService->syncAccountTradesFromMt5($account);
                $this->info('Success: created ' . $result['created'] . ', updated ' . $result['updated'] . ', errors ' . count($result['errors']));
            } catch (\Throwable $exception) {
                Log::error('MT5 scheduled sync failed for account ' . $account->id . ': ' . $exception->getMessage());
                $account->update([
                    'mt5_last_sync_at' => now(),
                    'mt5_last_sync_status' => 'failed',
                    'mt5_last_sync_message' => $exception->getMessage(),
                ]);
                $this->error('Failed: ' . $exception->getMessage());
            }
        }

        return 0;
    }
}
