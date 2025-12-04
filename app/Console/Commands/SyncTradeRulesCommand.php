<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;

class SyncTradeRulesCommand extends Command
{
    protected $signature = 'trades:sync-rules';
    protected $description = 'Sync trading rules from pivot table to rules column';

    public function handle()
    {
        $this->info('🔄 Syncing trade rules...');

        // Ambil semua trades yang punya tradingRules
        $trades = Trade::has('tradingRules')->with('tradingRules')->get();

        $bar = $this->output->createProgressBar($trades->count());

        foreach ($trades as $trade) {
            // Panggil method sync
            $trade->syncRulesToColumn();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Successfully synced ' . $trades->count() . ' trades!');

        // Cek trades tanpa rules
        $tradesWithoutRules = Trade::doesntHave('tradingRules')
            ->whereNotNull('rules')
            ->count();

        if ($tradesWithoutRules > 0) {
            $this->warn('⚠️ Found ' . $tradesWithoutRules . ' trades with rules column but no pivot data.');
        }
    }
}
