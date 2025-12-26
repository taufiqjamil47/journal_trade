<!-- Two Column Charts -->
<div class="my-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-primary-300">{{ __('analysis.pair_analysis.title') }}</h2>
        <div class="text-sm text-gray-500">
            <i class="fas fa-dollar mr-1"></i>
            {{ __('analysis.pair_analysis.subtitle') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profit/Loss per Symbol dengan Loading -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-primary-300">
                        {{ __('analysis.pair_analysis.profit_loss_symbol') }}</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ __('analysis.pair_analysis.profit_loss_description') }}</p>
                </div>
                <div class="bg-blue-500/20 p-2 rounded-lg">
                    <i class="fas fa-coins text-blue-500"></i>
                </div>
            </div>

            <!-- Chart Container dengan Loading State -->
            <div id="pairChartContainer" class="h-56 mb-4 relative">
                <div id="pairChartLoading" class="chart-loading">
                    <div class="chart-loading-spinner"></div>
                    <p class="chart-loading-text">{{ __('analysis.loading.pair_chart') }}</p>
                </div>
                <canvas id="pairChart" class="chart-canvas" style="display: none;"></canvas>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.pair_analysis.symbol') }}</th>
                            <th class="text-right py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.pair_analysis.total_pl') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pairData as $symbol => $pl)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                <td class="py-2 text-sm">{{ $symbol }}</td>
                                <td
                                    class="py-2 text-right font-medium {{ $pl >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                    {{ number_format($pl, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Performance per Entry Type dengan Loading -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-primary-300">
                        {{ __('analysis.pair_analysis.performance_entry_type') }}</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ __('analysis.pair_analysis.performance_description') }}</p>
                </div>
                <div class="bg-green-500/20 p-2 rounded-lg">
                    <i class="fas fa-chart-bar text-green-500"></i>
                </div>
            </div>

            <!-- Chart Container dengan Loading State -->
            <div id="entryTypeChartContainer" class="h-56 mb-4 relative">
                <div id="entryTypeChartLoading" class="chart-loading">
                    <div class="chart-loading-spinner"></div>
                    <p class="chart-loading-text">{{ __('analysis.loading.entry_type_chart') }}</p>
                </div>
                <canvas id="entryTypeChart" class="chart-canvas" style="display: none;"></canvas>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.pair_analysis.entry_type') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.trades') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.winrate') }}</th>
                            <th class="text-right py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.pair_analysis.pl') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entryTypeData as $type => $data)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                <td class="py-2 text-sm">{{ $type ?? 'N/A' }}</td>
                                <td class="py-2 text-center text-sm">{{ $data['trades'] }}</td>
                                <td class="py-2 text-center text-sm">{{ $data['winrate'] }}%</td>
                                <td
                                    class="py-2 text-right font-medium {{ $data['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                    {{ number_format($data['profit_loss'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
