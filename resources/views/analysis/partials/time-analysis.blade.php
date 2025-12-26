<!-- Time-Based Analysis -->
<div class="my-4">
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-primary-300">{{ __('analysis.time_analysis.title') }}</h2>
        <div class="text-sm text-gray-500">
            <i class="fas fa-clock mr-1"></i>
            {{ __('analysis.time_analysis.subtitle') }}
        </div>
    </div>

    <!-- Time Performance Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Best Trading Hour -->
        <div class="bg-gradient-to-br from-green-900/20 to-gray-800 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.time_analysis.best_hour') }}</p>
                    <h3 class="text-2xl font-bold mt-1 text-green-400">
                        @if ($bestHour && $bestHour['hour'] !== 'Unknown')
                            {{ str_pad($bestHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $bestHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                        @else
                            N/A
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mt-2">
                        @if ($bestHour && $bestHour['hour'] !== 'Unknown')
                            ${{ number_format($bestHour['profit'] ?? 0, 2) }} · {{ $bestHour['winrate'] ?? 0 }}%
                            {{ __('analysis.stats.winrate_short') }}
                        @else
                            {{ __('analysis.time_analysis.no_data') }}
                        @endif
                    </p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <i class="fas fa-crown text-green-500 text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Worst Trading Hour -->
        <div class="bg-gradient-to-br from-red-900/20 to-gray-800 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.time_analysis.worst_hour') }}</p>
                    <h3 class="text-2xl font-bold mt-1 text-red-400">
                        @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                            {{ str_pad($worstHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $worstHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                        @else
                            N/A
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mt-2">
                        @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                            ${{ number_format($worstHour['profit'] ?? 0, 2) }} ·
                            {{ $worstHour['winrate'] ?? 0 }}%
                            {{ __('analysis.stats.winrate_short') }}
                        @else
                            {{ __('analysis.time_analysis.no_data') }}
                        @endif
                    </p>
                </div>
                <div class="bg-red-500/20 p-3 rounded-lg">
                    <i class="fas fa-skull-crossbones text-red-500 text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Busiest Trading Hour -->
        <div class="bg-gradient-to-br from-blue-900/20 to-gray-800 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.time_analysis.busiest_hour') }}</p>
                    <h3 class="text-2xl font-bold mt-1 text-blue-400">
                        @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                            {{ str_pad($busiestHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $busiestHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                        @else
                            N/A
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mt-2">
                        @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                            {{ $busiestHour['trades'] ?? 0 }} {{ __('analysis.stats.trades') }} ·
                            ${{ number_format($busiestHour['profit'] ?? 0, 2) }}
                        @else
                            {{ __('analysis.time_analysis.no_data') }}
                        @endif
                    </p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <i class="fas fa-bullseye text-blue-500 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Hourly Performance Chart dengan Loading -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-primary-300">
                    {{ __('analysis.time_analysis.hourly_performance') }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ __('analysis.time_analysis.hourly_description') }}</p>
            </div>
            <div class="text-sm text-gray-400">
                <i class="fas fa-chart-bar mr-1"></i>
                {{ $tradingTimeStats['trading_frequency'] ?? __('analysis.time_analysis.low') }}
                {{ __('analysis.time_analysis.frequency') }}
            </div>
        </div>

        <!-- Chart Container dengan Loading State -->
        <div id="hourlyChartContainer" class="h-64 relative">
            <div id="hourlyChartLoading" class="chart-loading">
                <div class="chart-loading-spinner"></div>
                <p class="chart-loading-text">{{ __('analysis.loading.hourly_performance') }}</p>
            </div>
            <div id="hourlyChartNoData" class="chart-no-data" style="display: none;">
                <div class="flex flex-col items-center justify-center h-full text-gray-500">
                    <i class="fas fa-clock text-3xl mb-3"></i>
                    <p class="text-base">{{ __('analysis.time_analysis.no_hourly_data') }}</p>
                    <p class="text-sm">{{ __('analysis.time_analysis.start_trading') }}</p>
                </div>
            </div>
            <canvas id="hourlyChart" class="chart-canvas" style="display: none;"></canvas>
        </div>
    </div>

    <!-- Session-Time Heatmap (Collapsible) -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-bold text-primary-300">{{ __('analysis.time_analysis.heatmap_title') }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ __('analysis.time_analysis.heatmap_description') }}</p>
            </div>
            <button id="toggleHeatmap" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-expand"></i>
            </button>
        </div>

        <!-- Heatmap Container dengan Scroll Horizontal -->
        <div id="heatmapContainer" class="overflow-x-auto lg:overflow-visible">
            <div class="inline-block min-w-full">
                <!-- Header row with times (columns) -->
                <div class="flex mb-1">
                    <!-- Day label header -->
                    <div class="w-16 flex-shrink-0 text-xs text-gray-500 text-center py-1">
                        {{ __('analysis.time_analysis.day') }}
                    </div>

                    <!-- Hour columns -->
                    <div class="flex flex-1">
                        @for ($hour = 0; $hour < 24; $hour++)
                            @php
                                $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <div class="flex-1 min-w-0 text-xs text-gray-500 text-center py-1">
                                {{ $hourStr }}
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Data rows for each day -->
                @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayIndex => $dayName)
                    <div class="flex mb-1">
                        <!-- Day label -->
                        <div class="w-16 flex-shrink-0 text-xs text-gray-400 text-center py-1 font-medium">
                            {{ __("analysis.days_short.$dayName") }}
                        </div>

                        <!-- Hourly data for this day -->
                        <div class="flex flex-1">
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                    $data = $heatmapData[$dayIndex][$hour] ?? ['profit' => 0, 'trades' => 0];
                                    $profit = $data['profit'];
                                    $trades = $data['trades'];
                                    $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                    $nextHour = str_pad($hour + 1, 2, '0', STR_PAD_LEFT);

                                    // Determine color intensity
                                    if ($trades == 0) {
                                        $bgColor = 'bg-gray-900';
                                        $textColor = 'text-gray-700';
                                    } else {
                                        // Find max/min profit for scaling
                                        $allProfits = [];
                                        foreach ($heatmapData as $dayData) {
                                            foreach ($dayData as $hourData) {
                                                if (isset($hourData['profit'])) {
                                                    $allProfits[] = abs($hourData['profit']);
                                                }
                                            }
                                        }
                                        $maxProfit = $allProfits ? max($allProfits) : 0;

                                        if ($maxProfit > 0) {
                                            $intensity = min(100, (abs($profit) / $maxProfit) * 100);
                                        } else {
                                            $intensity = 0;
                                        }

                                        if ($profit > 0) {
                                            $bgColor = 'bg-green-900';
                                            $textColor = 'text-green-400';
                                        } elseif ($profit < 0) {
                                            $bgColor = 'bg-red-900';
                                            $textColor = 'text-red-400';
                                        } else {
                                            $bgColor = 'bg-gray-800';
                                            $textColor = 'text-gray-400';
                                        }
                                    }
                                @endphp

                                <div class="relative group flex-1 min-w-0">
                                    <div class="mx-0.5 h-8 {{ $bgColor }} rounded {{ $trades > 0 ? 'cursor-pointer hover:opacity-80' : '' }} transition-all flex items-center justify-center"
                                        data-day="{{ $dayIndex }}" data-hour="{{ $hourStr }}"
                                        data-profit="{{ $profit }}" data-trades="{{ $trades }}">

                                        @if ($trades > 0)
                                            @php
                                                // Format profit display
                                                $displayProfit = $profit >= 0 ? '+' : '';
                                                $displayProfit .= number_format($profit, 0);

                                                // Adjust font size based on length
                                                $profitStr = (string) $profit;
                                                $length = strlen($profitStr);
                                                $fontSizeClass = match (true) {
                                                    $length >= 5 => 'text-[8px]',
                                                    $length >= 4 => 'text-[9px]',
                                                    $length >= 3 => 'text-[10px]',
                                                    default => 'text-xs',
                                                };
                                            @endphp

                                            <span
                                                class="{{ $fontSizeClass }} {{ $textColor }} font-medium truncate px-0.5">
                                                {{ $displayProfit }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($trades > 0)
                                        <div class="absolute z-50 hidden group-hover:block bg-gray-900 border border-gray-700 rounded-lg p-2 text-xs shadow-xl min-w-48"
                                            style="left: 50%; transform: translateX(-50%); bottom: calc(100% + 8px);">
                                            <div class="font-medium {{ $textColor }}">
                                                {{ $hourStr }}:00-{{ $nextHour }}:00
                                            </div>
                                            <div class="text-gray-400 mt-1">
                                                {{ __('analysis.time_analysis.day_label') }}:
                                                {{ __("analysis.days.$dayName") }}
                                            </div>
                                            <div class="text-gray-400">
                                                {{ __('analysis.stats.trades') }}: {{ $trades }}
                                            </div>
                                            <div class="{{ $textColor }} font-medium mt-1">
                                                P/L: ${{ number_format($profit, 2) }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div class="flex justify-center items-center mt-4 text-xs text-gray-500">
            <div class="flex items-center mr-4">
                <div class="w-4 h-4 bg-green-900 rounded mr-1"></div>
                <span>{{ __('analysis.time_analysis.profitable') }}</span>
            </div>
            <div class="flex items-center mr-4">
                <div class="w-4 h-4 bg-red-900 rounded mr-1"></div>
                <span>{{ __('analysis.time_analysis.unprofitable') }}</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-900 rounded mr-1"></div>
                <span>{{ __('analysis.time_analysis.no_trades') }}</span>
            </div>
        </div>
    </div>

    <!-- Day of Week & Monthly Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Day of Week Performance dengan Loading -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
            <h3 class="text-lg font-bold text-primary-300 mb-4">
                {{ __('analysis.time_analysis.day_of_week_performance') }}</h3>

            <!-- Chart Container dengan Loading State -->
            <div id="dayOfWeekChartContainer" class="h-56 mb-4 relative">
                <div id="dayOfWeekChartLoading" class="chart-loading">
                    <div class="chart-loading-spinner"></div>
                    <p class="chart-loading-text">{{ __('analysis.loading.day_of_week_chart') }}</p>
                </div>
                <canvas id="dayOfWeekChart" class="chart-canvas" style="display: none;"></canvas>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.time_analysis.day') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.trades') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.winrate') }}</th>
                            <th class="text-right py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.time_analysis.pl') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dayOfWeekPerformance->sortBy('day_number') as $day)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                <td class="py-2 text-sm">{{ __("analysis.days_short.{$day['short_name']}") }}
                                </td>
                                <td class="py-2 text-center text-sm">{{ $day['trades'] }}</td>
                                <td class="py-2 text-center text-sm">
                                    <span class="{{ $day['winrate'] >= 50 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $day['winrate'] }}%
                                    </span>
                                </td>
                                <td
                                    class="py-2 text-right font-medium {{ $day['profit'] >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                    ${{ number_format($day['profit'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Trends dengan Loading -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
            <h3 class="text-lg font-bold text-primary-300 mb-4">{{ __('analysis.time_analysis.monthly_trends') }}
            </h3>

            <!-- Chart Container dengan Loading State -->
            <div id="monthlyChartContainer" class="h-56 mb-4 relative">
                <div id="monthlyChartLoading" class="chart-loading">
                    <div class="chart-loading-spinner"></div>
                    <p class="chart-loading-text">{{ __('analysis.loading.monthly_trends') }}</p>
                </div>
                <canvas id="monthlyChart" class="chart-canvas" style="display: none;"></canvas>
            </div>

            <div class="overflow-y-auto h-64">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.time_analysis.month') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.trades') }}</th>
                            <th class="text-center py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.stats.winrate') }}</th>
                            <th class="text-right py-2 text-gray-400 font-medium text-sm">
                                {{ __('analysis.time_analysis.pl') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyPerformance->sortDesc() as $month)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                <td class="py-2 text-sm">{{ $month['month_name'] }}</td>
                                <td class="py-2 text-center text-sm">{{ $month['trades'] }}</td>
                                <td class="py-2 text-center text-sm">
                                    <span class="{{ $month['winrate'] >= 50 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $month['winrate'] }}%
                                    </span>
                                </td>
                                <td
                                    class="py-2 text-right font-medium {{ $month['profit'] >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                    ${{ number_format($month['profit'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
