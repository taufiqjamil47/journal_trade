<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-3">
    <!-- Balance -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm">{{ __('analysis.stats.balance') }}</p>
                <div class="flex items-center gap-2">
                    <h3 id="balanceText" class="text-2xl font-bold mt-2">******</h3>
                    <h3 id="balanceValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($balance, 2) }}</h3>
                    <button id="toggleBalance" type="button"
                        class="mt-2 px-2 rounded-lg hover:bg-primary-500/30 transition-colors"
                        title="{{ __('analysis.stats.toggle_balance') }}">
                        <i id="balanceIcon" class="fas fa-eye-slash text-primary-500 text-lg"></i>
                    </button>
                </div>
            </div>
            <div class="bg-primary-500/20 p-2 rounded-lg">
                <i class="fas fa-wallet text-primary-500"></i>
            </div>
        </div>
    </div>

    <!-- Win Rate -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm">{{ __('analysis.stats.win_rate') }}</p>
                <h3 class="text-xl font-bold mt-1">{{ $winrate }}%</h3>
            </div>
            <div class="bg-green-500/20 p-2 rounded-lg">
                <i class="fas fa-trophy text-green-500"></i>
            </div>
        </div>
    </div>

    <!-- Net Profit -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm">{{ __('analysis.stats.net_profit') }}</p>
                <h3 class="text-xl font-bold mt-1 {{ $netProfit >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    ${{ number_format($netProfit, 2) }}
                </h3>
            </div>
            <div class="bg-blue-500/20 p-2 rounded-lg">
                <i class="fas fa-chart-line text-blue-500"></i>
            </div>
        </div>
    </div>
</div>
