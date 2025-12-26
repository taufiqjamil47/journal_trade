<!-- Risk Management Metrics -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-primary-300">{{ __('analysis.risk_management.title') }}</h2>
        <div class="text-sm text-gray-500">
            <i class="fas fa-shield mr-1"></i>
            {{ __('analysis.risk_management.subtitle') }}
        </div>
    </div>

    <!-- Advanced Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
        <!-- Profit Factor -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.profit_factor') }}</p>
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
                            <span class="text-green-400">{{ __('analysis.risk_management.excellent') }}</span>
                        @elseif($profitFactor > 1.5)
                            <span class="text-yellow-400">{{ __('analysis.risk_management.good') }}</span>
                        @elseif($profitFactor > 1)
                            <span class="text-orange-400">{{ __('analysis.risk_management.marginal') }}</span>
                        @else
                            <span class="text-red-400">{{ __('analysis.risk_management.unprofitable') }}</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Average Win/Loss -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.avg_win_loss') }}</p>
                    <h3 class="text-xl font-bold mt-1">{{ number_format($averageRR, 2) }}:1</h3>
                </div>
                <div class="bg-blue-500/20 p-2 rounded-lg">
                    <i class="fas fa-arrows-left-right text-blue-500"></i>
                </div>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.avg_win') }}</p>
                    <p class="text-sm font-medium text-green-400">${{ number_format($averageWin, 2) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.avg_loss') }}</p>
                    <p class="text-sm font-medium text-red-400">${{ number_format($averageLoss, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Largest Trades -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.largest_trades') }}</p>
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
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.largest_win') }}</p>
                    <p class="text-sm font-medium text-green-400">${{ number_format($largestWin, 2) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.largest_loss') }}</p>
                    <p class="text-sm font-medium text-red-400">${{ number_format($largestLoss, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Win/Loss Streaks -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.win_loss_streaks') }}</p>
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
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.best_win_streak') }}</p>
                    <p class="text-sm font-medium text-green-400">{{ $longestWinStreak }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">{{ __('analysis.risk_management.worst_loss_streak') }}</p>
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
                        <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.max_drawdown') }}</p>
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
                        <span>{{ __('analysis.risk_management.current_dd') }}:
                            {{ number_format($currentDrawdownPercentage, 1) }}%</span>
                        <span>{{ $currentDrawdownPercentage <= 10 ? __('analysis.risk_management.low') : ($currentDrawdownPercentage <= 20 ? __('analysis.risk_management.medium') : __('analysis.risk_management.high')) }}</span>
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
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.recovery_factor') }}</p>
                    <h3 class="text-2xl font-bold mt-1">
                        @if (is_numeric($recoveryFactor))
                            {{ number_format($recoveryFactor, 2) }}
                        @else
                            {{ $recoveryFactor }}
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm">{{ __('analysis.risk_management.recovery_factor_desc') }}
                    </p>
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
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ __('analysis.risk_management.excellent_recovery') }}
                            </span>
                        @elseif($recoveryFactor > 1)
                            <span class="text-yellow-400">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ __('analysis.risk_management.moderate_recovery') }}
                            </span>
                        @else
                            <span class="text-red-400">
                                <i class="fas fa-times-circle mr-1"></i>
                                {{ __('analysis.risk_management.poor_recovery') }}
                            </span>
                        @endif
                    @else
                        <span class="text-green-400">
                            <i class="fas fa-infinity mr-1"></i> {{ __('analysis.risk_management.no_drawdown') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sharpe Ratio -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.sharpe_ratio') }}</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ number_format($sharpeRatio, 2) }}
                    </h3>
                    <p class="text-gray-500 text-sm">{{ __('analysis.risk_management.sharpe_ratio_desc') }}</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-blue-500 text-lg"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    @if ($sharpeRatio > 1.5)
                        <span class="text-green-400">
                            <i class="fas fa-star mr-1"></i> {{ __('analysis.risk_management.excellent') }}
                        </span>
                    @elseif($sharpeRatio > 1)
                        <span class="text-yellow-400">
                            <i class="fas fa-star-half-alt mr-1"></i> {{ __('analysis.risk_management.good') }}
                        </span>
                    @elseif($sharpeRatio > 0)
                        <span class="text-orange-400">
                            <i class="fas fa-chart-line mr-1"></i>
                            {{ __('analysis.risk_management.acceptable') }}
                        </span>
                    @else
                        <span class="text-red-400">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ __('analysis.risk_management.risky') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Risk Consistency -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('analysis.risk_management.consistency_score') }}</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ $consistencyScore }}%
                    </h3>
                    <p class="text-gray-500 text-sm">{{ __('analysis.risk_management.profitable_months') }}</p>
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
                    <span>{{ $monthlyReturns->filter(fn($m) => $m['profit'] > 0)->count() }}
                        {{ __('analysis.risk_management.profitable') }}</span>
                    <span>{{ $monthlyReturns->count() }}
                        {{ __('analysis.risk_management.total_months') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Risk Metrics (Expanded on click) -->
    <div class="mt-2">
        <button id="toggleRiskDetails"
            class="flex items-center justify-center w-full py-2 text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-chevron-down mr-2"></i>
            <span class="text-sm">{{ __('analysis.risk_management.show_details') }}</span>
        </button>

        <div id="riskDetails" class="hidden mt-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Risk per Trade -->
                <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                    <h4 class="font-medium text-gray-300 mb-3">
                        {{ __('analysis.risk_management.risk_per_trade') }}</h4>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-400">{{ __('analysis.risk_management.average_risk') }}</span>
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
                                <span class="text-gray-400">{{ __('analysis.risk_management.max_risk') }}</span>
                                <span class="text-red-400">{{ $maxRiskPerTrade }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-1.5">
                                <div class="bg-gradient-to-r from-red-500 to-orange-500 h-1.5 rounded-full"
                                    style="width: {{ min($maxRiskPerTrade * 5, 100) }}%"></div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            {{ __('analysis.risk_management.recommended_risk') }}
                        </div>
                    </div>
                </div>

                <!-- Risk/Reward Distribution -->
                <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                    <h4 class="font-medium text-gray-300 mb-3">
                        {{ __('analysis.risk_management.risk_reward_profile') }}</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">{{ __('analysis.risk_management.avg_rr_ratio') }}</span>
                            <span
                                class="{{ $averageRiskReward >= 2 ? 'text-green-400' : ($averageRiskReward >= 1 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $averageRiskReward }}:1
                            </span>
                        </div>
                        <div class="text-xs text-gray-500">
                            @if ($averageRiskReward >= 2)
                                <i class="fas fa-check-circle text-green-400 mr-1"></i>
                                {{ __('analysis.risk_management.good_rr_management') }}
                            @elseif($averageRiskReward >= 1)
                                <i class="fas fa-exclamation-circle text-yellow-400 mr-1"></i>
                                {{ __('analysis.risk_management.equal_rr') }}
                            @else
                                <i class="fas fa-times-circle text-red-400 mr-1"></i>
                                {{ __('analysis.risk_management.poor_rr') }}
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Position Size Analysis -->
                <div class="bg-gray-800/50 rounded-lg border border-gray-700 p-4">
                    <h4 class="font-medium text-gray-300 mb-3">
                        {{ __('analysis.risk_management.position_size_performance') }}</h4>
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
                        <p class="text-gray-500 text-sm">{{ __('analysis.risk_management.no_position_data') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
