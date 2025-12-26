<!-- Expectancy Card (Full Width) -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-gray-400 text-sm">{{ __('analysis.stats.expectancy') }}</p>
                <h3 class="text-2xl font-bold mt-1">
                    ${{ number_format($expectancy, 2) }}
                    <span class="text-lg text-gray-400">{{ __('analysis.stats.per_trade') }}</span>
                </h3>
                <p class="text-gray-500 text-sm mt-2">
                    {{ __('analysis.stats.expectancy_description') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="bg-gray-700/50 rounded-lg p-4">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 lg:gap-8 text-center">
                        <div>
                            <p class="text-xs text-gray-500">{{ __('analysis.stats.total_profit') }}</p>
                            <p class="text-lg font-bold text-green-400">${{ number_format($totalProfit, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">{{ __('analysis.stats.total_loss') }}</p>
                            <p class="text-lg font-bold text-red-400">${{ number_format($totalLoss, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">{{ __('analysis.stats.net_profit') }}</p>
                            <p class="text-lg font-bold {{ $netProfit >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                ${{ number_format($netProfit, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
