@extends('Layouts.index')
@section('title', 'Trading Analysis')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Trading Analysis
                    </h1>
                    <p class="text-gray-500 mt-1">Analisis tingkat lanjut dan wawasan kinerja</p>
                </div>

                <!-- Navigation -->
                <div class="flex flex-wrap gap-3">
                    <!-- Back to Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Basic Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-3">
            <!-- Balance -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">Balance</p>
                        <h3 class="text-xl font-bold mt-1">${{ number_format($balance, 2) }}</h3>
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
                        <p class="text-gray-400 text-sm">Win Rate</p>
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
                        <p class="text-gray-400 text-sm">Net Profit</p>
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

        <!-- Expectancy Card (Full Width) -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Harapan Sistem</p>
                        <h3 class="text-2xl font-bold mt-1">
                            ${{ number_format($expectancy, 2) }}
                            <span class="text-lg text-gray-400">per trade</span>
                        </h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Rata-rata keuntungan yang diharapkan per perdagangan berdasarkan statistik saat ini
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="bg-gray-700/50 rounded-lg p-4">
                            <div class="grid grid-cols-3 gap-8 text-center">
                                <div>
                                    <p class="text-xs text-gray-500">Total Profit</p>
                                    <p class="text-lg font-bold text-green-400">${{ number_format($totalProfit, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total Loss</p>
                                    <p class="text-lg font-bold text-red-400">${{ number_format($totalLoss, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Net Profit</p>
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

        <!-- Risk Management Metrics -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-primary-300">Risk Management</h2>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-shield mr-1"></i>
                    Risk Assessment
                </div>
            </div>

            <!-- Advanced Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
                <!-- Profit Factor -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Profit Factor</p>
                            <h3 class="text-xl font-bold mt-1">
                                @if (is_numeric($profitFactor))
                                    {{ number_format($profitFactor, 2) }}
                                @else
                                    {{ $profitFactor }}
                                @endif
                            </h3>
                        </div>
                        <div class="bg-purple-500/20 p-2 rounded-lg">
                            <i class="fas fa-scale-balanced text-purple-500"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-xs text-gray-500">
                            @if (is_numeric($profitFactor))
                                @if ($profitFactor > 2)
                                    <span class="text-green-400">Excellent</span>
                                @elseif($profitFactor > 1.5)
                                    <span class="text-yellow-400">Good</span>
                                @elseif($profitFactor > 1)
                                    <span class="text-orange-400">Marginal</span>
                                @else
                                    <span class="text-red-400">Unprofitable</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Average Win/Loss -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Avg Win/Loss</p>
                            <h3 class="text-xl font-bold mt-1">{{ number_format($averageRR, 2) }}:1</h3>
                        </div>
                        <div class="bg-blue-500/20 p-2 rounded-lg">
                            <i class="fas fa-arrows-left-right text-blue-500"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Avg Win</p>
                            <p class="text-sm font-medium text-green-400">${{ number_format($averageWin, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Avg Loss</p>
                            <p class="text-sm font-medium text-red-400">${{ number_format($averageLoss, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Largest Trades -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Perdagangan Terbesar</p>
                            <h3 class="text-xl font-bold mt-1">
                                ${{ number_format(abs($largestWin) + abs($largestLoss), 2) }}
                            </h3>
                        </div>
                        <div class="bg-yellow-500/20 p-2 rounded-lg">
                            <i class="fas fa-chart-simple text-yellow-500"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Kemenangan Terbesar</p>
                            <p class="text-sm font-medium text-green-400">${{ number_format($largestWin, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Kerugian Terbesar</p>
                            <p class="text-sm font-medium text-red-400">${{ number_format($largestLoss, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Win/Loss Streaks -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Win/Loss Streaks</p>
                            <h3 class="text-xl font-bold mt-1">
                                @if ($currentStreakType == 'win')
                                    <span class="text-green-400">{{ $currentStreak }}W</span>
                                @elseif($currentStreakType == 'loss')
                                    <span class="text-red-400">{{ $currentStreak }}L</span>
                                @else
                                    -
                                @endif
                            </h3>
                        </div>
                        <div class="bg-indigo-500/20 p-2 rounded-lg">
                            <i class="fas fa-fire-flame-curved text-indigo-500"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Best Win Streak</p>
                            <p class="text-sm font-medium text-green-400">{{ $longestWinStreak }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500">Worst Loss Streak</p>
                            <p class="text-sm font-medium text-red-400">{{ $longestLossStreak }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Max Drawdown -->
                <div
                    class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-500/5 rounded-full -translate-y-6 translate-x-6">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-gray-400 text-sm">Max Drawdown</p>
                                <h3 class="text-2xl font-bold mt-1 text-red-400">
                                    {{ number_format($maxDrawdownPercentage, 1) }}%
                                </h3>
                                <p class="text-gray-500 text-sm">${{ number_format($maxDrawdown, 2) }}</p>
                            </div>
                            <div class="bg-red-500/20 p-3 rounded-lg">
                                <i class="fas fa-arrow-down text-red-500 text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Current DD: {{ number_format($currentDrawdownPercentage, 1) }}%</span>
                                <span>{{ $currentDrawdownPercentage <= 10 ? 'Low' : ($currentDrawdownPercentage <= 20 ? 'Medium' : 'High') }}</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full"
                                    style="width: {{ min($currentDrawdownPercentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recovery Factor -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Recovery Factor</p>
                            <h3 class="text-2xl font-bold mt-1">
                                @if (is_numeric($recoveryFactor))
                                    {{ number_format($recoveryFactor, 2) }}
                                @else
                                    {{ $recoveryFactor }}
                                @endif
                            </h3>
                            <p class="text-gray-500 text-sm">Profit per $1 drawdown</p>
                        </div>
                        <div class="bg-green-500/20 p-3 rounded-lg">
                            <i class="fas fa-arrow-up-from-bracket text-green-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            @if (is_numeric($recoveryFactor))
                                @if ($recoveryFactor > 2)
                                    <span class="text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i> Excellent Recovery
                                    </span>
                                @elseif($recoveryFactor > 1)
                                    <span class="text-yellow-400">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Moderate Recovery
                                    </span>
                                @else
                                    <span class="text-red-400">
                                        <i class="fas fa-times-circle mr-1"></i> Poor Recovery
                                    </span>
                                @endif
                            @else
                                <span class="text-green-400">
                                    <i class="fas fa-infinity mr-1"></i> No Drawdown
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sharpe Ratio -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Sharpe Ratio</p>
                            <h3 class="text-2xl font-bold mt-1">
                                {{ number_format($sharpeRatio, 2) }}
                            </h3>
                            <p class="text-gray-500 text-sm">Risk-adjusted returns</p>
                        </div>
                        <div class="bg-blue-500/20 p-3 rounded-lg">
                            <i class="fas fa-chart-line text-blue-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            @if ($sharpeRatio > 1.5)
                                <span class="text-green-400">
                                    <i class="fas fa-star mr-1"></i> Excellent
                                </span>
                            @elseif($sharpeRatio > 1)
                                <span class="text-yellow-400">
                                    <i class="fas fa-star-half-alt mr-1"></i> Good
                                </span>
                            @elseif($sharpeRatio > 0)
                                <span class="text-orange-400">
                                    <i class="fas fa-chart-line mr-1"></i> Acceptable
                                </span>
                            @else
                                <span class="text-red-400">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Risky
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Risk Consistency -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-gray-400 text-sm">Consistency Score</p>
                            <h3 class="text-2xl font-bold mt-1">
                                {{ $consistencyScore }}%
                            </h3>
                            <p class="text-gray-500 text-sm">Bulan Menguntungkan</p>
                        </div>
                        <div class="bg-purple-500/20 p-3 rounded-lg">
                            <i class="fas fa-chart-pie text-purple-500 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full"
                                style="width: {{ $consistencyScore }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $monthlyReturns->filter(fn($m) => $m['profit'] > 0)->count() }} profitable</span>
                            <span>{{ $monthlyReturns->count() }} total months</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Risk Metrics (Expanded on click) -->
            <div class="mt-2">
                <button id="toggleRiskDetails"
                    class="flex items-center justify-center w-full py-2 text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-chevron-down mr-2"></i>
                    <span class="text-sm">Tampilkan Risk Metrik Terperinci</span>
                </button>

                <div id="riskDetails" class="hidden mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Risk per Trade -->
                        <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                            <h4 class="font-medium text-gray-300 mb-3">Risk Per Trade</h4>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-400">Average Risk</span>
                                        <span
                                            class="{{ $averageRiskPerTrade <= 2 ? 'text-green-400' : ($averageRiskPerTrade <= 5 ? 'text-yellow-400' : 'text-red-400') }}">
                                            {{ $averageRiskPerTrade }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-1.5 rounded-full"
                                            style="width: {{ min($averageRiskPerTrade * 10, 100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-400">Max Risk</span>
                                        <span class="text-red-400">{{ $maxRiskPerTrade }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-red-500 to-orange-500 h-1.5 rounded-full"
                                            style="width: {{ min($maxRiskPerTrade * 5, 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Recommended: 1-2% risk per trade
                                </div>
                            </div>
                        </div>

                        <!-- Risk/Reward Distribution -->
                        <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                            <h4 class="font-medium text-gray-300 mb-3">Risk/Reward Profile</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Avg R:R Ratio</span>
                                    <span
                                        class="{{ $averageRiskReward >= 2 ? 'text-green-400' : ($averageRiskReward >= 1 ? 'text-yellow-400' : 'text-red-400') }}">
                                        {{ $averageRiskReward }}:1
                                    </span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    @if ($averageRiskReward >= 2)
                                        <i class="fas fa-check-circle text-green-400 mr-1"></i>
                                        Good risk management - seeking 2:1 or better
                                    @elseif($averageRiskReward >= 1)
                                        <i class="fas fa-exclamation-circle text-yellow-400 mr-1"></i>
                                        Risk equals reward - consider improving
                                    @else
                                        <i class="fas fa-times-circle text-red-400 mr-1"></i>
                                        Risk exceeds reward - needs improvement
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Position Size Analysis -->
                        <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                            <h4 class="font-medium text-gray-300 mb-3">Position Size Performance</h4>
                            @if ($positionSizes->count() > 0)
                                <div class="space-y-2 max-h-32 overflow-y-auto pr-2">
                                    @foreach ($positionSizes as $size => $data)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-400">{{ $size }}</span>
                                            <div class="flex items-center">
                                                <span
                                                    class="{{ $data['profit'] >= 0 ? 'text-green-400' : 'text-red-400' }} mr-2">
                                                    ${{ number_format($data['profit'], 2) }}
                                                </span>
                                                <span
                                                    class="text-xs {{ $data['winrate'] >= 50 ? 'text-green-400' : 'text-red-400' }}">
                                                    {{ $data['winrate'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No position size data available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Analysis Section -->
        <div class="my-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-primary-300">Time Analysis</h2>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Trading Time Patterns
                </div>
            </div>

            <!-- Time Performance Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Best Trading Hour -->
                <div class="bg-gradient-to-br from-green-900/20 to-gray-800 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Jam Terbaik untuk Trading</p>
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
                                    WR
                                @else
                                    No data available
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
                            <p class="text-gray-400 text-sm">Jam Terburuk untuk Trading</p>
                            <h3 class="text-2xl font-bold mt-1 text-red-400">
                                @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                                    {{ str_pad($worstHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $worstHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="text-gray-500 text-sm mt-2">
                                @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                                    ${{ number_format($worstHour['profit'] ?? 0, 2) }} · {{ $worstHour['winrate'] ?? 0 }}%
                                    WR
                                @else
                                    No data available
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
                            <p class="text-gray-400 text-sm">Jam Paling Aktif</p>
                            <h3 class="text-2xl font-bold mt-1 text-blue-400">
                                @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                                    {{ str_pad($busiestHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $busiestHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="text-gray-500 text-sm mt-2">
                                @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                                    {{ $busiestHour['trades'] ?? 0 }} trades ·
                                    ${{ number_format($busiestHour['profit'] ?? 0, 2) }}
                                @else
                                    No data available
                                @endif
                            </p>
                        </div>
                        <div class="bg-blue-500/20 p-3 rounded-lg">
                            <i class="fas fa-bullseye text-blue-500 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hourly Performance Chart -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-primary-300">Hourly Performance</h3>
                        <p class="text-gray-500 text-sm mt-1">Profit by hour of day (GMT)</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-chart-bar mr-1"></i>
                        {{ $tradingTimeStats['trading_frequency'] ?? 'Low' }} Frequency
                    </div>
                </div>

                @if ($hourlyPerformance->isNotEmpty() && $hourlyPerformance->keys()->filter(fn($h) => $h !== 'Unknown')->isNotEmpty())
                    <div class="h-64">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-gray-500">
                        <i class="fas fa-clock text-3xl mb-3"></i>
                        <p class="text-base">No hourly data available</p>
                        <p class="text-sm">Start trading to see time-based analysis</p>
                    </div>
                @endif
            </div>

            <!-- Day of Week & Monthly Performance -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Day of Week Performance -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <h3 class="text-lg font-bold text-primary-300 mb-4">Day of Week Performance</h3>
                    <div class="h-56 mb-4">
                        <canvas id="dayOfWeekChart"></canvas>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-2 text-gray-400 font-medium text-sm">Day</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Trades</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Winrate</th>
                                    <th class="text-right py-2 text-gray-400 font-medium text-sm">P/L ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dayOfWeekPerformance->sortBy('day_number') as $day)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                        <td class="py-2 text-sm">{{ $day['short_name'] }}</td>
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

                <!-- Monthly Trends -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <h3 class="text-lg font-bold text-primary-300 mb-4">Monthly Trends</h3>
                    <div class="h-56 mb-4">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                    <div class="overflow-y-auto h-64">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-2 text-gray-400 font-medium text-sm">Month</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Trades</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Winrate</th>
                                    <th class="text-right py-2 text-gray-400 font-medium text-sm">P/L ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($monthlyPerformance->take(6)->sortDesc() as $month) --}}
                                @foreach ($monthlyPerformance->sortDesc() as $month)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                        <td class="py-2 text-sm">{{ $month['month_name'] }}</td>
                                        <td class="py-2 text-center text-sm">{{ $month['trades'] }}</td>
                                        <td class="py-2 text-center text-sm">
                                            <span
                                                class="{{ $month['winrate'] >= 50 ? 'text-green-400' : 'text-red-400' }}">
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

            <!-- Session-Time Heatmap (Collapsible) -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-primary-300">Session-Time Heatmap</h3>
                        <p class="text-gray-500 text-sm mt-1">Best session-time combinations</p>
                    </div>
                    <button id="toggleHeatmap" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <div id="heatmapContainer" class="verflow-visible relative z-0">
                    <div class="min-w-max">
                        <!-- Header row with times (columns) -->
                        <div class="grid grid-cols-25 gap-1 mb-1">
                            <div class="text-xs text-gray-500 text-center py-1">Day</div>
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                    $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="text-xs text-gray-500 text-center py-1">{{ $hourStr }}:00</div>
                            @endfor
                        </div>

                        <!-- Data rows for each day -->
                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayIndex => $dayName)
                            <div class="grid grid-cols-25 gap-1 mb-1">
                                <!-- Day label -->
                                <div class="text-xs text-gray-400 text-center py-1 font-medium">
                                    {{ $dayName }}
                                </div>

                                <!-- Hourly data for this day -->
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
                                            $intensity = 'No Trades';
                                        } else {
                                            $maxProfit = max(array_column(array_merge(...$heatmapData), 'profit'));
                                            $minProfit = min(array_column(array_merge(...$heatmapData), 'profit'));
                                            $range = max(abs($maxProfit), abs($minProfit));

                                            if ($range > 0) {
                                                $intensity = (abs($profit) / $range) * 100;
                                            } else {
                                                $intensity = 0;
                                            }

                                            if ($profit > 0) {
                                                $greenIntensity = min(100, 50 + $intensity / 2);
                                                $bgColor = 'bg-green-900';
                                                $textColor = 'text-green-400';
                                            } elseif ($profit < 0) {
                                                $redIntensity = min(100, 50 + $intensity / 2);
                                                $bgColor = 'bg-red-900';
                                                $textColor = 'text-red-400';
                                            } else {
                                                $bgColor = 'bg-gray-800';
                                                $textColor = 'text-gray-400';
                                            }
                                        }
                                    @endphp

                                    <div class="relative group">
                                        <div class="w-full h-8 {{ $bgColor }} rounded {{ $trades > 0 ? 'cursor-pointer hover:opacity-80' : '' }} transition-all"
                                            data-day="{{ $dayIndex }}" data-hour="{{ $hourStr }}"
                                            data-profit="{{ $profit }}" data-trades="{{ $trades }}">
                                            <div class="flex items-center justify-center h-full">
                                                @if ($trades > 0)
                                                    <span class="text-xs {{ $textColor }} font-medium">
                                                        {{ $profit >= 0 ? '+' : '' }}{{ number_format($profit, 0) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($trades > 0)
                                            <div class="absolute z-50 hidden group-hover:block bg-gray-900 border border-gray-700 rounded-lg p-2 text-xs shadow-xl min-w-32"
                                                style="left: 50%; bottom: calc(100% + 8px);">
                                                <div class="font-medium {{ $textColor }}">
                                                    {{ $hourStr }}:00-{{ $nextHour }}:00
                                                </div>
                                                <div class="text-gray-400 mt-1">
                                                    Day: {{ $dayName }}
                                                </div>
                                                <div class="text-gray-400">
                                                    Trades: {{ $trades }}
                                                </div>
                                                <div class="{{ $textColor }} font-medium mt-1">
                                                    P/L: ${{ number_format($profit, 2) }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex justify-center items-center mt-4 text-xs text-gray-500">
                    <div class="flex items-center mr-4">
                        <div class="w-4 h-4 bg-green-900 rounded mr-1"></div>
                        <span>Profitable</span>
                    </div>
                    <div class="flex items-center mr-4">
                        <div class="w-4 h-4 bg-red-900 rounded mr-1"></div>
                        <span>Unprofitable</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gray-900 rounded mr-1"></div>
                        <span>No Trades</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Charts -->
        <div class="my-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-primary-300">Pair & Entry Type Analysis</h2>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-dollar mr-1"></i>
                    Pair & Entry
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
                <form method="GET" action="{{ route('analysis.index') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Period Filter -->
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-300 mb-1">Period</label>
                        <select name="period" onchange="this.form.submit()"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 30 Days</option>
                        </select>
                    </div>

                    <!-- Session Filter -->
                    <div>
                        <label for="session" class="block text-sm font-medium text-gray-300 mb-1">Session</label>
                        <select name="session" onchange="this.form.submit()"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $sessionFilter === 'all' ? 'selected' : '' }}>All Sessions</option>
                            @foreach ($availableSessions as $sessionName)
                                <option value="{{ $sessionName }}"
                                    {{ $sessionFilter === $sessionName ? 'selected' : '' }}>
                                    {{ $sessionName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Entry Type Filter -->
                    <div>
                        <label for="entry_type" class="block text-sm font-medium text-gray-300 mb-1">Entry Type</label>
                        <select name="entry_type" onchange="this.form.submit()"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $entryFilter === 'all' ? 'selected' : '' }}>All Types</option>
                            @foreach ($availableEntryTypes as $entryType)
                                <option value="{{ $entryType }}" {{ $entryFilter === $entryType ? 'selected' : '' }}>
                                    {{ $entryType }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            @if ($summary)
                <!-- Summary Alert -->
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
                                {{ $summary['trades'] }} trades ·
                                Winrate: <span class="font-semibold">{{ $summary['winrate'] }}%</span> ·
                                <span
                                    class="{{ $summary['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">
                                    ${{ number_format($summary['profit_loss'], 2) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Profit/Loss per Symbol -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">Profit/Loss per Symbol</h2>
                            <p class="text-gray-500 text-sm mt-1">Kinerja berdasarkan pasangan perdagangan</p>
                        </div>
                        <div class="bg-blue-500/20 p-2 rounded-lg">
                            <i class="fas fa-coins text-blue-500"></i>
                        </div>
                    </div>
                    <div class="h-56 mb-4">
                        <canvas id="pairChart"></canvas>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-2 text-gray-400 font-medium text-sm">Symbol</th>
                                    <th class="text-right py-2 text-gray-400 font-medium text-sm">Total P/L ($)</th>
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

                <!-- Performance per Entry Type -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">Performance per Entry Type</h2>
                            <p class="text-gray-500 text-sm mt-1">Analisis efektivitas strategi</p>
                        </div>
                        <div class="bg-green-500/20 p-2 rounded-lg">
                            <i class="fas fa-chart-bar text-green-500"></i>
                        </div>
                    </div>
                    <div class="h-56 mb-4">
                        <canvas id="entryTypeChart"></canvas>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-2 text-gray-400 font-medium text-sm">Entry Type</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Trades</th>
                                    <th class="text-center py-2 text-gray-400 font-medium text-sm">Winrate</th>
                                    <th class="text-right py-2 text-gray-400 font-medium text-sm">P/L ($)</th>
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

        <!-- Session Analysis Section -->
        <!-- Buat section baru untuk session analysis -->

    </div>
    <script>
        // Tambahkan di script section
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function() {
                // Toggle detail view atau tooltip
                const tooltip = this.querySelector('.stat-tooltip');
                if (tooltip) {
                    tooltip.classList.toggle('hidden');
                }
            });
        });

        // Animate number counters
        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.textContent = formatNumber(value);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Tambahkan di script section (setelah animasi counter)
        // Risk Metrics Toggle
        const toggleRiskDetails = document.getElementById('toggleRiskDetails');
        const riskDetails = document.getElementById('riskDetails');
        const toggleRiskIcon = toggleRiskDetails?.querySelector('i');

        if (toggleRiskDetails && riskDetails) {
            toggleRiskDetails.addEventListener('click', function() {
                riskDetails.classList.toggle('hidden');
                if (toggleRiskIcon) {
                    if (riskDetails.classList.contains('hidden')) {
                        toggleRiskIcon.classList.remove('fa-chevron-up');
                        toggleRiskIcon.classList.add('fa-chevron-down');
                        toggleRiskDetails.querySelector('span').textContent = 'Tampilkan Risk Metrik Terperinci';
                    } else {
                        toggleRiskIcon.classList.remove('fa-chevron-down');
                        toggleRiskIcon.classList.add('fa-chevron-up');
                        toggleRiskDetails.querySelector('span').textContent =
                            'Sembunyikan Risk Metrik Terperinci';
                    }
                }
            });
        }

        // Drawdown Gauge Chart (jika mau lebih fancy)
        function createDrawdownGauge(currentDD, maxDD) {
            const ctx = document.createElement('canvas');
            ctx.width = 100;
            ctx.height = 100;

            // ... kode untuk gauge chart ...
        }

        function formatNumber(num) {
            if (num >= 1000) {
                return '$' + (num / 1000).toFixed(1) + 'k';
            }
            return '$' + num.toFixed(2);
        }

        // Jalankan animasi saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                const value = parseFloat(stat.textContent.replace(/[^0-9.-]+/g, ""));
                if (!isNaN(value)) {
                    animateCounter(stat, 0, value, 1000);
                }
            });
        });
    </script>

    <script>
        // Hourly Performance Chart
        const hourlyCtx = document.getElementById('hourlyChart');
        if (hourlyCtx) {
            const hourlyData = @json($hourlyPerformance->sortKeys());
            const hourlyLabels = Object.keys(hourlyData).map(hour => {
                const nextHour = (parseInt(hour) + 1) % 24;
                return hour.padStart(2, '0') + ':00-' + nextHour.toString().padStart(2, '0') + ':00';
            });
            const hourlyProfits = Object.values(hourlyData).map(data => data.profit);
            const hourlyTrades = Object.values(hourlyData).map(data => data.trades);

            new Chart(hourlyCtx, {
                type: 'bar',
                data: {
                    labels: hourlyLabels,
                    datasets: [{
                        label: 'Profit ($)',
                        data: hourlyProfits,
                        backgroundColor: hourlyProfits.map(p =>
                            p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                        ),
                        borderColor: hourlyProfits.map(p =>
                            p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                        ),
                        borderWidth: 1,
                        borderRadius: 4,
                        yAxisID: 'y',
                    }, {
                        label: 'Trades',
                        data: hourlyTrades,
                        type: 'line',
                        borderColor: 'rgba(59, 130, 246, 0.8)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(75, 85, 99, 0.3)'
                            },
                            ticks: {
                                color: '#9ca3af',
                                maxRotation: 45
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: {
                                color: 'rgba(75, 85, 99, 0.3)'
                            },
                            ticks: {
                                color: '#9ca3af',
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.9)',
                            titleColor: '#f3f4f6',
                            bodyColor: '#f3f4f6',
                            borderColor: 'rgba(75, 85, 99, 0.5)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.datasetIndex === 0) {
                                        label += '$' + context.parsed.y.toFixed(2);
                                    } else {
                                        label += context.parsed.y + ' trades';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Day of Week Chart
        const dowCtx = document.getElementById('dayOfWeekChart');
        if (dowCtx) {
            const dowData = @json($dayOfWeekPerformance->sortBy('day_number'));
            const dowLabels = Object.values(dowData).map(d => d.short_name);
            const dowProfits = Object.values(dowData).map(d => d.profit);
            const dowWinrates = Object.values(dowData).map(d => d.winrate);

            new Chart(dowCtx, {
                type: 'bar',
                data: {
                    labels: dowLabels,
                    datasets: [{
                        label: 'Profit ($)',
                        data: dowProfits,
                        backgroundColor: dowProfits.map(p =>
                            p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                        ),
                        borderColor: dowProfits.map(p =>
                            p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                        ),
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const dataIndex = context.dataIndex;
                                    const winrate = dowWinrates[dataIndex];
                                    return `Winrate: ${winrate}%`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            const monthlyData = @json($monthlyPerformance->sortKeys()->take(12));
            const monthlyLabels = Object.values(monthlyData).map(m => m.month_name);
            const monthlyProfits = Object.values(monthlyData).map(m => m.profit);

            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Monthly Profit ($)',
                        data: monthlyProfits,
                        borderColor: 'rgba(139, 92, 246, 0.8)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.9)',
                            titleColor: '#f3f4f6',
                            bodyColor: '#f3f4f6'
                        }
                    }
                }
            });
        }

        // Heatmap Toggle
        const toggleHeatmap = document.getElementById('toggleHeatmap');
        const heatmapContainer = document.getElementById('heatmapContainer');

        if (toggleHeatmap && heatmapContainer) {
            toggleHeatmap.addEventListener('click', function() {
                heatmapContainer.classList.toggle('max-h-96');
                heatmapContainer.classList.toggle('overflow-y-auto');

                if (toggleHeatmap.querySelector('i').classList.contains('fa-expand')) {
                    toggleHeatmap.querySelector('i').classList.remove('fa-expand');
                    toggleHeatmap.querySelector('i').classList.add('fa-compress');
                } else {
                    toggleHeatmap.querySelector('i').classList.remove('fa-compress');
                    toggleHeatmap.querySelector('i').classList.add('fa-expand');
                }
            });
        }

        // Heatmap Cell Click
        document.querySelectorAll('#heatmapContainer [data-trades]').forEach(cell => {
            cell.addEventListener('click', function() {
                const hour = this.getAttribute('data-hour');
                const day = this.getAttribute('data-day');
                const profit = parseFloat(this.getAttribute('data-profit'));
                const trades = parseInt(this.getAttribute('data-trades'));

                if (trades > 0) {
                    // Bisa buka modal atau filter untuk trades pada waktu tertentu
                    alert(
                        `Hour: ${hour}:00\nDay: ${['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][day]}\nTrades: ${trades}\nProfit: $${profit.toFixed(2)}`
                    );
                }
            });
        });
    </script>

    <script>
        // Pair Chart
        const pairCtx = document.getElementById('pairChart').getContext('2d');
        const pairLabels = @json($pairData->keys());
        const pairValues = @json($pairData->values());

        if (pairLabels.length > 0) {
            new Chart(pairCtx, {
                type: 'bar',
                data: {
                    labels: pairLabels,
                    datasets: [{
                        label: 'Profit/Loss ($)',
                        data: pairValues,
                        backgroundColor: pairValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 0.7)' :
                            'rgba(239, 68, 68, 0.7)'),
                        borderColor: pairValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 1)' :
                            'rgba(239, 68, 68, 1)'),
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.9)',
                            titleColor: '#f3f4f6',
                            bodyColor: '#f3f4f6',
                            borderColor: 'rgba(75, 85, 99, 0.5)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(75, 85, 99, 0.3)'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        }

        // Entry Type Chart
        const etx = document.getElementById('entryTypeChart').getContext('2d');
        const entryLabels = @json($entryTypeData->keys());
        const entryValues = @json($entryTypeData->map(fn($d) => $d['profit_loss'])->values());

        if (entryLabels.length > 0) {
            new Chart(etx, {
                type: 'bar',
                data: {
                    labels: entryLabels,
                    datasets: [{
                        label: 'Profit/Loss ($)',
                        data: entryValues,
                        backgroundColor: entryValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 0.7)' :
                            'rgba(239, 68, 68, 0.7)'),
                        borderColor: entryValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 1)' :
                            'rgba(239, 68, 68, 1)'),
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.9)',
                            titleColor: '#f3f4f6',
                            bodyColor: '#f3f4f6',
                            borderColor: 'rgba(75, 85, 99, 0.5)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(75, 85, 99, 0.3)'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        }
    </script>

    <style>
        /* Simple scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Hover effects for tables */
        tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }
    </style>

    <style>
        /* Tambahkan di style section */
        .gradient-border {
            border: 2px solid transparent;
            background: linear-gradient(135deg, #1f2937, #374151) padding-box,
                linear-gradient(135deg, #3b82f6, #8b5cf6) border-box;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        /* Tambahkan di style section */
        .risk-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-width: 1px;
            border-style: solid;
        }

        .risk-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.1);
        }

        .risk-card:nth-child(1):hover {
            border-color: rgba(239, 68, 68, 0.3);
        }

        .risk-card:nth-child(2):hover {
            border-color: rgba(16, 185, 129, 0.3);
        }

        .risk-card:nth-child(3):hover {
            border-color: rgba(59, 130, 246, 0.3);
        }

        .risk-card:nth-child(4):hover {
            border-color: rgba(139, 92, 246, 0.3);
        }

        /* Progress bar animation */
        .progress-bar {
            transition: width 1.5s ease-in-out;
        }

        /* Scrollbar untuk position size */
        .max-h-32::-webkit-scrollbar {
            width: 4px;
        }

        .max-h-32::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .max-h-32::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }
    </style>

    <style>
        /* Tambahkan di style section */
        .grid-cols-25 {
            grid-template-columns: repeat(25, minmax(0, 1fr));
        }

        /* Heatmap cell styles */
        .heatmap-cell {
            transition: all 0.2s ease;
            min-width: 2rem;
            min-height: 2rem;
        }

        .heatmap-cell:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        /* Scrollbar untuk heatmap */
        #heatmapContainer.max-h-96 {
            max-height: 24rem;
        }

        #heatmapContainer::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        #heatmapContainer::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        #heatmapContainer::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* Tooltip styles */
        .group:hover .group-hover\:block {
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
