<?php

namespace App\Observers;

use Illuminate\Console\Command;
use App\Models\Trade;

class SyncTradeRules extends Command
{
    protected $signature = 'trades:sync-rules {--reverse : Sync dari kolom ke pivot}';
    protected $description = 'Sync trading rules antara pivot table dan kolom rules';

    public function handle()
    {
        if ($this->option('reverse')) {
            $this->syncFromColumnToPivot();
        } else {
            $this->syncFromPivotToColumn();
        }
    }

    protected function syncFromPivotToColumn()
    {
        $this->info('🔄 Sinkronisasi dari tabel pivot ke kolom aturan...');

        $trades = Trade::has('tradingRules')->with('tradingRules')->get();

        $bar = $this->output->createProgressBar($trades->count());

        foreach ($trades as $trade) {
            $ruleNames = $trade->tradingRules->pluck('name')->toArray();

            $trade->withoutEvents(function () use ($trade, $ruleNames) {
                $trade->update(['rules' => implode(',', $ruleNames)]);
            });

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Tersinkronisasi ' . $trades->count() . ' perdagangan dari pivot ke kolom.');
    }

    protected function syncFromColumnToPivot()
    {
        $this->info('🔄 Sinkronisasi dari kolom aturan ke tabel pivot...');

        $trades = Trade::whereNotNull('rules')->where('rules', '!=', '')->get();

        $bar = $this->output->createProgressBar($trades->count());

        foreach ($trades as $trade) {
            $ruleNames = array_map('trim', explode(',', $trade->rules));

            $ruleIds = \App\Models\TradingRule::whereIn('name', $ruleNames)
                ->pluck('id')
                ->toArray();

            $trade->tradingRules()->sync($ruleIds);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Tersinkronisasi ' . $trades->count() . ' perdagangan dari kolom ke tabel pivot.');
    }
}
