<!-- resources/views/analysis/partials/summary-alert.blade.php -->
<div class="bg-primary-900/30 rounded-xl p-4 border border-primary-700/30 mb-6">
    <div class="flex items-center">
        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
            <i class="fas fa-chart-pie text-primary-500"></i>
        </div>
        <div>
            <h3 class="font-bold text-primary-300">{{ $summary['entry_type'] }}
                <span class="text-gray-400 font-normal">({{ $summary['session'] }})</span>
            </h3>
            <p class="text-gray-300 text-sm mt-1">
                {{ $summary['trades'] }} {{ __('analysis.stats.trades') }} ·
                {{ __('analysis.stats.winrate') }}: <span class="font-semibold">{{ $summary['winrate'] }}%</span> ·
                <span class="{{ $summary['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">
                    ${{ number_format($summary['profit_loss'], 2) }}
                </span>
            </p>
        </div>
    </div>
</div>
