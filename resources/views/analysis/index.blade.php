@extends('Layouts.index')
@section('title', __('analysis.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('analysis.title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('analysis.subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                @include('components.navbar-selector')
            </div>
        </header>

        <!-- Summary Alert -->
        @if ($summary)
            <div
                class="bg-indigo-50 dark:bg-indigo-900/30 rounded-xl p-4 border border-indigo-200 dark:border-indigo-800/30 mb-6 shadow-sm">
                <div class="flex items-center">
                    <div class="bg-indigo-200 dark:bg-indigo-800/50 p-2 rounded-lg mr-3">
                        <i class="fas fa-chart-pie text-indigo-700 dark:text-indigo-300"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $summary['entry_type'] }}
                            <span class="text-gray-600 dark:text-gray-400 font-normal">({{ $summary['session'] }})</span>
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mt-1">
                            {{ $summary['trades'] }} trades ·
                            Winrate: <span class="font-semibold">{{ $summary['winrate'] }}%</span> ·
                            <span
                                class="{{ $summary['profit_loss'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-bold">
                                ${{ number_format($summary['profit_loss'], 2) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Basic Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-3">
            <!-- Balance -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('analysis.stats.balance') }}
                        </p>
                        <div class="flex items-center gap-2">
                            <h3 id="balanceText" class="text-2xl font-bold text-gray-900 dark:text-white mt-2">******</h3>
                            <h3 id="balanceValue" class="text-2xl font-bold text-gray-900 dark:text-white mt-2 hidden">
                                ${{ number_format($balance, 2) }}
                            </h3>
                            <button id="toggleBalance" type="button"
                                class="mt-2 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                title="{{ __('analysis.stats.toggle_balance') }}">
                                <i id="balanceIcon" class="fas fa-eye-slash text-gray-500 dark:text-gray-400 text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                        <i class="fas fa-wallet text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                </div>
            </div>

            <!-- Win Rate -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('analysis.stats.win_rate') }}
                        </p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $winrate }}%</h3>
                    </div>
                    <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-lg">
                        <i class="fas fa-trophy text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('analysis.stats.net_profit') }}</p>
                        <h3
                            class="text-2xl font-bold mt-2 {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            ${{ number_format($netProfit, 2) }}
                        </h3>
                    </div>
                    <div class="bg-sky-100 dark:bg-sky-900/30 p-2 rounded-lg">
                        <i class="fas fa-chart-line text-sky-600 dark:text-sky-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expectancy Card (Full Width) -->
        <div class="mb-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('analysis.stats.expectancy') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            ${{ number_format($expectancy, 2) }}
                            <span
                                class="text-lg font-normal text-gray-600 dark:text-gray-400">{{ __('analysis.stats.per_trade') }}</span>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-500 text-sm mt-2">
                            {{ __('analysis.stats.expectancy_description') }}
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div
                            class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 lg:gap-8 text-center">
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ __('analysis.stats.total_profit') }}</p>
                                    <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                        ${{ number_format($totalProfit, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ __('analysis.stats.total_loss') }}</p>
                                    <p class="text-lg font-bold text-rose-600 dark:text-rose-400">
                                        ${{ number_format($totalLoss, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ __('analysis.stats.net_profit') }}</p>
                                    <p
                                        class="text-lg font-bold {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        ${{ number_format($netProfit, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mb-6">
            <form method="GET" action="{{ route('analysis.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Period Filter -->
                <div>
                    <label for="period"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('analysis.filters.period') }}</label>
                    <select name="period" onchange="this.form.submit()"
                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow duration-200">
                        <option value="all" {{ $period === 'all' ? 'selected' : '' }}>
                            {{ __('analysis.filters.all_time') }}</option>
                        <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>
                            {{ __('analysis.filters.weekly') }}</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>
                            {{ __('analysis.filters.monthly') }}</option>
                    </select>
                </div>

                <!-- Session Filter -->
                <div>
                    <label for="session"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('analysis.filters.session') }}</label>
                    <select name="session" onchange="this.form.submit()"
                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow duration-200">
                        <option value="all" {{ $sessionFilter === 'all' ? 'selected' : '' }}>
                            {{ __('analysis.filters.all_sessions') }}</option>
                        @foreach ($availableSessions as $sessionName)
                            <option value="{{ $sessionName }}" {{ $sessionFilter === $sessionName ? 'selected' : '' }}>
                                {{ $sessionName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Entry Type Filter -->
                <div>
                    <label for="entry_type"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('analysis.filters.entry_type') }}</label>
                    <select name="entry_type" onchange="this.form.submit()"
                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow duration-200">
                        <option value="all" {{ $entryFilter === 'all' ? 'selected' : '' }}>
                            {{ __('analysis.filters.all_types') }}</option>
                        @foreach ($availableEntryTypes as $entryType)
                            <option value="{{ $entryType }}" {{ $entryFilter === $entryType ? 'selected' : '' }}>
                                {{ $entryType }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Risk Management Metrics -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('analysis.risk_management.title') }}</h2>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-shield mr-1 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('analysis.risk_management.subtitle') }}
                </div>
            </div>

            <!-- Advanced Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
                <!-- Profit Factor -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.profit_factor') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                @if (is_numeric($profitFactor))
                                    {{ number_format($profitFactor, 2) }}
                                @else
                                    {{ $profitFactor }}
                                @endif
                            </h3>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                            <i class="fas fa-scale-balanced text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-xs">
                            @if (is_numeric($profitFactor))
                                @if ($profitFactor > 2)
                                    <span
                                        class="text-emerald-600 dark:text-emerald-400 font-medium">{{ __('analysis.risk_management.excellent') }}</span>
                                @elseif($profitFactor > 1.5)
                                    <span
                                        class="text-amber-600 dark:text-amber-400 font-medium">{{ __('analysis.risk_management.good') }}</span>
                                @elseif($profitFactor > 1)
                                    <span
                                        class="text-orange-600 dark:text-orange-400 font-medium">{{ __('analysis.risk_management.marginal') }}</span>
                                @else
                                    <span
                                        class="text-rose-600 dark:text-rose-400 font-medium">{{ __('analysis.risk_management.unprofitable') }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Average Win/Loss -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.avg_win_loss') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ number_format($averageRR, 2) }}:1</h3>
                        </div>
                        <div class="bg-sky-100 dark:bg-sky-900/30 p-2 rounded-lg">
                            <i class="fas fa-arrows-left-right text-sky-600 dark:text-sky-400"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.avg_win') }}</p>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                ${{ number_format($averageWin, 2) }}</p>
                        </div>
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.avg_loss') }}</p>
                            <p class="text-sm font-medium text-rose-600 dark:text-rose-400">
                                ${{ number_format($averageLoss, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Largest Trades -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.largest_trades') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                ${{ number_format(abs($largestWin) + abs($largestLoss), 2) }}
                            </h3>
                        </div>
                        <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg">
                            <i class="fas fa-chart-simple text-amber-600 dark:text-amber-400"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.largest_win') }}</p>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                ${{ number_format($largestWin, 2) }}</p>
                        </div>
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.largest_loss') }}</p>
                            <p class="text-sm font-medium text-rose-600 dark:text-rose-400">
                                ${{ number_format($largestLoss, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Win/Loss Streaks -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.win_loss_streaks') }}</p>
                            <h3 class="text-2xl font-bold mt-1">
                                @if ($currentStreakType == 'win')
                                    <span class="text-emerald-600 dark:text-emerald-400">{{ $currentStreak }}W</span>
                                @elseif($currentStreakType == 'loss')
                                    <span class="text-rose-600 dark:text-rose-400">{{ $currentStreak }}L</span>
                                @else
                                    <span class="text-gray-600 dark:text-gray-400">-</span>
                                @endif
                            </h3>
                        </div>
                        <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                            <i class="fas fa-fire-flame-curved text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.best_win_streak') }}</p>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">{{ $longestWinStreak }}
                            </p>
                        </div>
                        <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.worst_loss_streak') }}</p>
                            <p class="text-sm font-medium text-rose-600 dark:text-rose-400">{{ $longestLossStreak }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Max Drawdown -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.max_drawdown') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ number_format($maxDrawdownPercentage, 1) }}%
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">${{ number_format($maxDrawdown, 2) }}</p>
                        </div>
                        <div class="bg-rose-100 dark:bg-rose-900/30 p-3 rounded-lg">
                            <i class="fas fa-arrow-down text-rose-600 dark:text-rose-400 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                            <span>{{ __('analysis.risk_management.current_dd') }}:
                                {{ number_format($currentDrawdownPercentage, 1) }}%</span>
                            <span
                                class="{{ $currentDrawdownPercentage <= 10 ? 'text-emerald-600 dark:text-emerald-400' : ($currentDrawdownPercentage <= 20 ? 'text-amber-600 dark:text-amber-400' : 'text-rose-600 dark:text-rose-400') }}">
                                {{ $currentDrawdownPercentage <= 10 ? __('analysis.risk_management.low') : ($currentDrawdownPercentage <= 20 ? __('analysis.risk_management.medium') : __('analysis.risk_management.high')) }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-rose-500 to-orange-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ min($currentDrawdownPercentage, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Recovery Factor -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.recovery_factor') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                @if (is_numeric($recoveryFactor))
                                    {{ number_format($recoveryFactor, 2) }}
                                @else
                                    {{ $recoveryFactor }}
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ __('analysis.risk_management.recovery_factor_desc') }}
                            </p>
                        </div>
                        <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                            <i class="fas fa-arrow-up-from-bracket text-emerald-600 dark:text-emerald-400 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            @if (is_numeric($recoveryFactor))
                                @if ($recoveryFactor > 2)
                                    <span class="text-emerald-600 dark:text-emerald-400">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ __('analysis.risk_management.excellent_recovery') }}
                                    </span>
                                @elseif($recoveryFactor > 1)
                                    <span class="text-amber-600 dark:text-amber-400">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ __('analysis.risk_management.moderate_recovery') }}
                                    </span>
                                @else
                                    <span class="text-rose-600 dark:text-rose-400">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        {{ __('analysis.risk_management.poor_recovery') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-emerald-600 dark:text-emerald-400">
                                    <i class="fas fa-infinity mr-1"></i> {{ __('analysis.risk_management.no_drawdown') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sharpe Ratio -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.sharpe_ratio') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ number_format($sharpeRatio, 2) }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ __('analysis.risk_management.sharpe_ratio_desc') }}</p>
                        </div>
                        <div class="bg-sky-100 dark:bg-sky-900/30 p-3 rounded-lg">
                            <i class="fas fa-chart-line text-sky-600 dark:text-sky-400 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            @if ($sharpeRatio > 1.5)
                                <span class="text-emerald-600 dark:text-emerald-400">
                                    <i class="fas fa-star mr-1"></i> {{ __('analysis.risk_management.excellent') }}
                                </span>
                            @elseif($sharpeRatio > 1)
                                <span class="text-amber-600 dark:text-amber-400">
                                    <i class="fas fa-star-half-alt mr-1"></i> {{ __('analysis.risk_management.good') }}
                                </span>
                            @elseif($sharpeRatio > 0)
                                <span class="text-orange-600 dark:text-orange-400">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    {{ __('analysis.risk_management.acceptable') }}
                                </span>
                            @else
                                <span class="text-rose-600 dark:text-rose-400">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ __('analysis.risk_management.risky') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Risk Consistency -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.risk_management.consistency_score') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $consistencyScore }}%
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ __('analysis.risk_management.profitable_months') }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                            <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-2">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $consistencyScore }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
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
                    class="flex items-center justify-center w-full py-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                    <i class="fas fa-chevron-down mr-2 transition-transform duration-300" id="riskToggleIcon"></i>
                    <span class="text-sm" id="riskToggleText">{{ __('analysis.risk_management.show_details') }}</span>
                </button>

                <div id="riskDetails" class="hidden mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Risk per Trade -->
                        <div
                            class="bg-gray-100 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">
                                {{ __('analysis.risk_management.risk_per_trade') }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('analysis.risk_management.average_risk') }}</span>
                                        <span
                                            class="{{ $averageRiskPerTrade <= 2 ? 'text-emerald-600 dark:text-emerald-400' : ($averageRiskPerTrade <= 5 ? 'text-amber-600 dark:text-amber-400' : 'text-rose-600 dark:text-rose-400') }}">
                                            {{ $averageRiskPerTrade }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-300 dark:bg-gray-600 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-sky-500 to-cyan-500 h-1.5 rounded-full transition-all duration-500"
                                            style="width: {{ min($averageRiskPerTrade * 10, 100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('analysis.risk_management.max_risk') }}</span>
                                        <span class="text-rose-600 dark:text-rose-400">{{ $maxRiskPerTrade }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-300 dark:bg-gray-600 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-rose-500 to-orange-500 h-1.5 rounded-full transition-all duration-500"
                                            style="width: {{ min($maxRiskPerTrade * 5, 100) }}%"></div>
                                    </div>
                                </div>
                                <div
                                    class="text-xs text-gray-600 dark:text-gray-400 mt-2 bg-gray-200 dark:bg-gray-600 p-2 rounded">
                                    <i class="fas fa-info-circle mr-1 text-indigo-500"></i>
                                    {{ __('analysis.risk_management.recommended_risk') }}
                                </div>
                            </div>
                        </div>

                        <!-- Risk/Reward Distribution -->
                        <div
                            class="bg-gray-100 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">
                                {{ __('analysis.risk_management.risk_reward_profile') }}</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ __('analysis.risk_management.avg_rr_ratio') }}</span>
                                    <span
                                        class="text-lg font-bold {{ $averageRiskReward >= 2 ? 'text-emerald-600 dark:text-emerald-400' : ($averageRiskReward >= 1 ? 'text-amber-600 dark:text-amber-400' : 'text-rose-600 dark:text-rose-400') }}">
                                        {{ $averageRiskReward }}:1
                                    </span>
                                </div>
                                <div
                                    class="text-xs text-gray-600 dark:text-gray-400 mt-2 bg-gray-200 dark:bg-gray-600 p-2 rounded">
                                    @if ($averageRiskReward >= 2)
                                        <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 mr-1"></i>
                                        {{ __('analysis.risk_management.good_rr_management') }}
                                    @elseif($averageRiskReward >= 1)
                                        <i class="fas fa-exclamation-circle text-amber-600 dark:text-amber-400 mr-1"></i>
                                        {{ __('analysis.risk_management.equal_rr') }}
                                    @else
                                        <i class="fas fa-times-circle text-rose-600 dark:text-rose-400 mr-1"></i>
                                        {{ __('analysis.risk_management.poor_rr') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Position Size Analysis -->
                        <div
                            class="bg-gray-100 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">
                                {{ __('analysis.risk_management.position_size_performance') }}</h4>
                            @if ($positionSizes->count() > 0)
                                <div
                                    class="space-y-2 max-h-32 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                                    @foreach ($positionSizes as $size => $data)
                                        <div
                                            class="flex justify-between items-center text-sm p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded transition-colors duration-150">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $size }}</span>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="{{ $data['profit'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                    ${{ number_format($data['profit'], 2) }}
                                                </span>
                                                <span
                                                    class="text-xs px-1.5 py-0.5 rounded {{ $data['winrate'] >= 50 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' }}">
                                                    {{ $data['winrate'] }}%
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600 dark:text-gray-400 text-sm text-center py-4">
                                    {{ __('analysis.risk_management.no_position_data') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time-Based Analysis -->
        <div class="my-4">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('analysis.time_analysis.title') }}</h2>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-clock mr-1 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('analysis.time_analysis.subtitle') }}
                </div>
            </div>

            <!-- Time Performance Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Best Trading Hour -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.time_analysis.best_hour') }}</p>
                            <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                                @if ($bestHour && $bestHour['hour'] !== 'Unknown')
                                    {{ str_pad($bestHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $bestHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                @if ($bestHour && $bestHour['hour'] !== 'Unknown')
                                    ${{ number_format($bestHour['profit'] ?? 0, 2) }} · <span
                                        class="text-emerald-600 dark:text-emerald-400">{{ $bestHour['winrate'] ?? 0 }}%</span>
                                    {{ __('analysis.stats.winrate_short') }}
                                @else
                                    {{ __('analysis.time_analysis.no_data') }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-lg">
                            <i class="fas fa-crown text-emerald-600 dark:text-emerald-400 text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Worst Trading Hour -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.time_analysis.worst_hour') }}</p>
                            <h3 class="text-2xl font-bold text-rose-600 dark:text-rose-400 mt-1">
                                @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                                    {{ str_pad($worstHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $worstHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                @if ($worstHour && $worstHour['hour'] !== 'Unknown')
                                    ${{ number_format($worstHour['profit'] ?? 0, 2) }} · <span
                                        class="text-rose-600 dark:text-rose-400">{{ $worstHour['winrate'] ?? 0 }}%</span>
                                    {{ __('analysis.stats.winrate_short') }}
                                @else
                                    {{ __('analysis.time_analysis.no_data') }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-rose-100 dark:bg-rose-900/30 p-3 rounded-lg">
                            <i class="fas fa-skull-crossbones text-rose-600 dark:text-rose-400 text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Busiest Trading Hour -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ __('analysis.time_analysis.busiest_hour') }}</p>
                            <h3 class="text-2xl font-bold text-sky-600 dark:text-sky-400 mt-1">
                                @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                                    {{ str_pad($busiestHour['hour'], 2, '0', STR_PAD_LEFT) }}:00-{{ str_pad((int) $busiestHour['hour'] + 1, 2, '0', STR_PAD_LEFT) }}:00
                                @else
                                    N/A
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                @if ($busiestHour && $busiestHour['hour'] !== 'Unknown')
                                    {{ $busiestHour['trades'] ?? 0 }} {{ __('analysis.stats.trades') }} ·
                                    ${{ number_format($busiestHour['profit'] ?? 0, 2) }}
                                @else
                                    {{ __('analysis.time_analysis.no_data') }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-sky-100 dark:bg-sky-900/30 p-3 rounded-lg">
                            <i class="fas fa-bullseye text-sky-600 dark:text-sky-400 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hourly Performance Chart dengan Loading -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ __('analysis.time_analysis.hourly_performance') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            {{ __('analysis.time_analysis.hourly_description') }}</p>
                    </div>
                    <div
                        class="text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                        <i class="fas fa-chart-bar mr-1 text-indigo-500"></i>
                        {{ $tradingTimeStats['trading_frequency'] ?? __('analysis.time_analysis.low') }}
                        {{ __('analysis.time_analysis.frequency') }}
                    </div>
                </div>

                <!-- Chart Container dengan Loading State -->
                <div id="hourlyChartContainer" class="h-64 relative">
                    <div id="hourlyChartLoading" class="chart-loading" style="display: none;">
                        <div class="chart-loading-spinner"></div>
                        <p class="chart-loading-text">{{ __('analysis.loading.hourly_performance') }}</p>
                    </div>
                    <div id="hourlyChartNoData" class="chart-no-data" style="display: none;">
                        <div class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clock text-3xl mb-3 opacity-50"></i>
                            <p class="text-base font-medium text-gray-700 dark:text-gray-300">
                                {{ __('analysis.time_analysis.no_hourly_data') }}</p>
                            <p class="text-sm">{{ __('analysis.time_analysis.start_trading') }}</p>
                        </div>
                    </div>
                    <canvas id="hourlyChart" class="chart-canvas" style="display: none;"></canvas>
                </div>
            </div>

            <!-- Session-Time Heatmap -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ __('analysis.time_analysis.heatmap_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            {{ __('analysis.time_analysis.heatmap_description') }}</p>
                    </div>
                </div>

                <div id="heatmapContainer" class="overflow-x-auto lg:overflow-visible relative z-0">
                    <div class="min-w-max">
                        <!-- Header row with times (columns) -->
                        <div class="grid grid-cols-25 gap-1 mb-1">
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300 text-center py-1">
                                {{ __('analysis.time_analysis.day') }}
                            </div>
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                    $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="text-xs text-gray-600 dark:text-gray-400 text-center py-1">
                                    {{ $hourStr }}:00</div>
                            @endfor
                        </div>

                        <!-- Data rows for each day -->
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayIndex => $dayName)
                            <div class="grid grid-cols-25 gap-1 mb-1">
                                <!-- Day label -->
                                <div
                                    class="text-xs text-gray-700 dark:text-gray-300 text-center py-1 font-medium bg-gray-100 dark:bg-gray-700 rounded">
                                    {{ __("analysis.days_short.$dayName") }}
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
                                            $bgColor = 'bg-gray-200 dark:bg-gray-700';
                                            $textColor = 'text-gray-500 dark:text-gray-400';
                                            $borderColor = 'border-gray-300 dark:border-gray-600';
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
                                                $bgColor = 'bg-emerald-200 dark:bg-emerald-900/50';
                                                $textColor = 'text-emerald-700 dark:text-emerald-400';
                                                $borderColor = 'border-emerald-500 dark:border-emerald-600';
                                            } elseif ($profit < 0) {
                                                $bgColor = 'bg-rose-200 dark:bg-rose-900/50';
                                                $textColor = 'text-rose-700 dark:text-rose-400';
                                                $borderColor = 'border-rose-500 dark:border-rose-600';
                                            } else {
                                                $bgColor = 'bg-gray-200 dark:bg-gray-700';
                                                $textColor = 'text-gray-600 dark:text-gray-400';
                                                $borderColor = 'border-gray-300 dark:border-gray-600';
                                            }
                                        }
                                    @endphp

                                    <div class="relative group">
                                        <div class="w-11 h-8 {{ $bgColor }} rounded border {{ $borderColor }} {{ $trades > 0 ? 'cursor-pointer hover:opacity-80 hover:scale-105 transition-transform duration-200' : '' }}"
                                            data-day="{{ $dayIndex }}" data-hour="{{ $hourStr }}"
                                            data-profit="{{ $profit }}" data-trades="{{ $trades }}">
                                            <div class="flex items-center justify-center h-full">
                                                @if ($trades > 0)
                                                    @php
                                                        // Hitung jumlah digit (termasuk tanda minus)
                                                        $profitLength = strlen((string) $profit);
                                                        $fontSizeClass = match (true) {
                                                            $profitLength >= 6 => 'text-[9px]',
                                                            $profitLength == 5 => 'text-[10px]',
                                                            $profitLength == 4 => 'text-[11px]',
                                                            $profitLength == 3 => 'text-[12px]',
                                                            $profitLength == 2 => 'text-xs',
                                                            default => 'text-xs',
                                                        };
                                                    @endphp

                                                    <span
                                                        class="{{ $fontSizeClass }} {{ $textColor }} font-medium leading-none">
                                                        {{ $profit >= 0 ? '+' : '' }}{{ number_format($profit, 0) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($trades > 0)
                                            <div class="absolute z-50 hidden group-hover:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-2 text-xs shadow-xl min-w-32"
                                                style="left: -100%; bottom: calc(100% + 8px);">
                                                <div class="font-medium {{ $textColor }}">
                                                    {{ $hourStr }}:00-{{ $nextHour }}:00
                                                </div>
                                                <div class="text-gray-600 dark:text-gray-400 mt-1">
                                                    {{ __('analysis.time_analysis.day_label') }}:
                                                    {{ __("analysis.days.$dayName") }}
                                                </div>
                                                <div class="text-gray-600 dark:text-gray-400">
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
                        @endforeach
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex justify-center items-center mt-4 text-xs">
                    <div class="flex items-center mr-4">
                        <div
                            class="w-4 h-4 bg-emerald-200 dark:bg-emerald-900/50 rounded border border-emerald-500 dark:border-emerald-600 mr-1">
                        </div>
                        <span
                            class="text-gray-700 dark:text-gray-300">{{ __('analysis.time_analysis.profitable') }}</span>
                    </div>
                    <div class="flex items-center mr-4">
                        <div
                            class="w-4 h-4 bg-rose-200 dark:bg-rose-900/50 rounded border border-rose-500 dark:border-rose-600 mr-1">
                        </div>
                        <span
                            class="text-gray-700 dark:text-gray-300">{{ __('analysis.time_analysis.unprofitable') }}</span>
                    </div>
                    <div class="flex items-center">
                        <div
                            class="w-4 h-4 bg-gray-200 dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600 mr-1">
                        </div>
                        <span
                            class="text-gray-700 dark:text-gray-300">{{ __('analysis.time_analysis.no_trades') }}</span>
                    </div>
                </div>
            </div>

            <!-- Day of Week & Monthly Performance - Vertical Layout -->
            <div class="space-y-6">
                <!-- Row 1: Day of Week Chart + Table -->
                <div class="grid grid-cols-1 lg:grid-cols-2 mb-0">
                    <!-- Day of Week Chart (Left) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-t-xl lg:rounded-tr-none lg:rounded-bl-xl border-r lg:border-r-0 border-t border-l border-b-0 lg:border-b p-5 min-h-80 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            {{ __('analysis.time_analysis.day_of_week_performance') }}</h3>

                        <!-- Chart Container dengan Loading State -->
                        <div id="dayOfWeekChartContainer" class="h-56 relative">
                            <div id="dayOfWeekChartLoading" class="chart-loading" style="display: none;">
                                <div class="chart-loading-spinner"></div>
                                <p class="chart-loading-text">{{ __('analysis.loading.day_of_week_chart') }}</p>
                            </div>
                            <canvas id="dayOfWeekChart" class="chart-canvas" style="display: none;"></canvas>
                        </div>
                    </div>

                    <!-- Day of Week Table (Right) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-b-xl lg:rounded-bl-none lg:rounded-tr-xl border-r border-l lg:border-l-0 border-t-0 lg:border-t border-b p-5 min-h-80 overflow-hidden shadow-sm">
                        <div
                            class="overflow-y-auto h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                            <table class="w-full text-sm">
                                <thead class="sticky top-0 bg-white dark:bg-gray-800">
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.time_analysis.day') }}</th>
                                        <th class="text-center py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.stats.trades') }}</th>
                                        <th class="text-center py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.stats.winrate') }}</th>
                                        <th class="text-right py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.time_analysis.pl') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dayOfWeekPerformance->sortBy('day_number') as $day)
                                        <tr
                                            class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                            <td class="py-2 px-2 text-sm text-gray-900 dark:text-gray-300">
                                                {{ __("analysis.days_short.{$day['short_name']}") }}</td>
                                            <td class="py-2 px-2 text-center text-sm text-gray-900 dark:text-gray-300">
                                                {{ $day['trades'] }}</td>
                                            <td class="py-2 px-2 text-center text-sm">
                                                <span
                                                    class="{{ $day['winrate'] >= 50 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                    {{ $day['winrate'] }}%
                                                </span>
                                            </td>
                                            <td
                                                class="py-2 px-2 text-right font-medium {{ $day['profit'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} text-sm">
                                                ${{ number_format($day['profit'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Quarterly Chart + Table -->
                <div class="grid grid-cols-1 lg:grid-cols-2 mb-0">
                    <!-- Quarterly Chart (Left) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-t-xl lg:rounded-tr-none lg:rounded-bl-xl border-r lg:border-r-0 border-t border-l border-b-0 lg:border-b p-5 min-h-80 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ __('analysis.time_analysis.quarterly_trends') }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                    {{ __('analysis.time_analysis.quarterly_description') }}</p>
                            </div>
                            <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg">
                                <i class="fas fa-chart-line text-amber-600 dark:text-amber-400"></i>
                            </div>
                        </div>

                        <!-- Chart Container dengan Loading State -->
                        <div id="quarterlyChartContainer" class="h-56 relative">
                            <div id="quarterlyChartLoading" class="chart-loading" style="display: none;">
                                <div class="chart-loading-spinner"></div>
                                <p class="chart-loading-text">{{ __('analysis.loading.quarterly_trends') }}</p>
                            </div>
                            <canvas id="quarterlyChart" class="chart-canvas" style="display: none;"></canvas>
                        </div>
                    </div>

                    <!-- Quarterly Table (Right) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-b-xl lg:rounded-bl-none lg:rounded-tr-xl border-r border-l lg:border-l-0 border-t-0 lg:border-t border-b p-5 min-h-80 overflow-hidden shadow-sm">
                        <div
                            class="overflow-y-auto h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                            <table class="w-full text-sm">
                                <thead class="sticky top-0 bg-white dark:bg-gray-800">
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.time_analysis.quarter') }}</th>
                                        <th class="text-center py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.stats.trades') }}</th>
                                        <th class="text-center py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.stats.winrate') }}</th>
                                        <th class="text-right py-2 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                            {{ __('analysis.time_analysis.pl') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quarterlyPerformance->sortDesc() as $quarter)
                                        <tr
                                            class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                            <td class="py-2 px-2 text-sm text-gray-900 dark:text-gray-300">
                                                {{ $quarter['quarter_name'] }}</td>
                                            <td class="py-2 px-2 text-center text-sm text-gray-900 dark:text-gray-300">
                                                {{ $quarter['trades'] }}</td>
                                            <td class="py-2 px-2 text-center text-sm">
                                                <span
                                                    class="{{ $quarter['winrate'] >= 50 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                    {{ $quarter['winrate'] }}%
                                                </span>
                                            </td>
                                            <td
                                                class="py-2 px-2 text-right font-medium {{ $quarter['profit'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} text-sm">
                                                ${{ number_format($quarter['profit'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Monthly Chart + Table -->
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Monthly Chart (Left) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-t-xl lg:rounded-tr-none lg:rounded-bl-xl border-r lg:border-r-0 border-t border-l border-b-0 lg:border-b p-5 min-h-80 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            {{ __('analysis.time_analysis.monthly_trends') }}</h3>

                        <!-- Chart Container dengan Loading State -->
                        <div id="monthlyChartContainer" class="h-56 relative">
                            <div id="monthlyChartLoading" class="chart-loading" style="display: none;">
                                <div class="chart-loading-spinner"></div>
                                <p class="chart-loading-text">{{ __('analysis.loading.monthly_trends') }}</p>
                            </div>
                            <canvas id="monthlyChart" class="chart-canvas" style="display: none;"></canvas>
                        </div>
                    </div>

                    <!-- Monthly Table (Right) -->
                    <div
                        class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-b-xl lg:rounded-bl-none lg:rounded-tr-xl border-r border-l lg:border-l-0 border-t-0 lg:border-t border-b p-5 min-h-80 overflow-hidden shadow-sm">
                        <!-- Grouped by Year with Collapsible Months -->
                        <div
                            class="space-y-1 overflow-y-auto h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                            @php
                                $monthsByYear = $monthlyPerformance
                                    ->groupBy(function ($month) {
                                        return \Carbon\Carbon::parse($month['month'])->format('Y');
                                    })
                                    ->sortDesc();
                            @endphp

                            @foreach ($monthsByYear as $year => $months)
                                <div
                                    class="year-group bg-gray-100 dark:bg-gray-700/30 rounded border border-gray-200 dark:border-gray-600">
                                    <!-- Year Header (Expandable) -->
                                    <button
                                        class="year-toggle w-full flex items-center justify-between p-2 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200"
                                        data-year="{{ $year }}">
                                        <div class="flex items-center gap-2">
                                            <i
                                                class="fas fa-chevron-down text-indigo-500 dark:text-indigo-400 year-toggle-icon transition-transform duration-300 text-sm"></i>
                                            <span
                                                class="font-bold text-gray-900 dark:text-white text-sm">{{ $year }}</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                                ({{ $months->sum('trades') }} trades,
                                                <span
                                                    class="{{ $months->sum('profit') >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                    ${{ number_format($months->sum('profit'), 2) }}
                                                </span>)
                                            </span>
                                        </div>
                                        <div
                                            class="text-xs bg-indigo-100 dark:bg-indigo-900/30 px-1.5 py-0.5 rounded text-indigo-700 dark:text-indigo-400">
                                            {{ round(($months->sum('wins') / $months->sum('trades')) * 100, 1) }}%
                                        </div>
                                    </button>

                                    <!-- Month Details (Collapsible) -->
                                    <div
                                        class="year-content border-t border-gray-200 dark:border-gray-600 max-h-0 overflow-hidden transition-all duration-300">
                                        <div class="p-2">
                                            @foreach ($months->sortDesc() as $month)
                                                <div
                                                    class="flex items-center justify-between py-1.5 px-1.5 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-xs border-b border-gray-200 dark:border-gray-600 last:border-0 transition-colors duration-150">
                                                    <span
                                                        class="text-gray-700 dark:text-gray-300">{{ $month['month_name'] }}</span>
                                                    <div class="flex items-center gap-3">
                                                        <span
                                                            class="text-gray-600 dark:text-gray-400 w-10 text-center">{{ $month['trades'] }}</span>
                                                        <span class="w-10 text-center">
                                                            <span
                                                                class="{{ $month['winrate'] >= 50 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                                {{ $month['winrate'] }}%
                                                            </span>
                                                        </span>
                                                        <span
                                                            class="font-medium {{ $month['profit'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} w-16 text-right">
                                                            ${{ number_format($month['profit'], 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Analysis with Polar Chart -->
        <div class="my-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Session Polar Chart -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('analysis.time_analysis.session_performance') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('analysis.time_analysis.distribution') }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                            <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>

                    <!-- Chart Container dengan Loading State -->
                    <div id="sessionPolarChartContainer" class="h-80 relative">
                        <div id="sessionPolarChartLoading" class="chart-loading" style="display: none;">
                            <div class="chart-loading-spinner"></div>
                            <p class="chart-loading-text">{{ __('analysis.time_analysis.session_polar_chart') }}</p>
                        </div>
                        <canvas id="sessionPolarChart" class="chart-canvas" style="display: none;"></canvas>
                    </div>
                </div>

                <!-- Session Stats Table -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ __('analysis.time_analysis.metrics.label1') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('analysis.time_analysis.metrics.label2') }}</p>
                        </div>
                        <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                            <i class="fas fa-table text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                    </div>

                    <div
                        class="overflow-x-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-white dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.time_analysis.metrics.session') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.time_analysis.metrics.trades') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.time_analysis.metrics.winrate') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.time_analysis.metrics.avg_rr') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.time_analysis.metrics.profit_loss') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessionAnalysis as $session => $data)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="py-3 px-2">
                                            <span
                                                class="inline-block px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-full text-xs font-medium">
                                                {{ $session ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center text-gray-900 dark:text-gray-300 font-semibold">
                                            {{ $data['trades'] }}
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <span
                                                class="inline-block px-2 py-1 rounded {{ $data['winrate'] >= 50 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' }} font-medium">
                                                {{ $data['winrate'] }}%
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center text-sky-600 dark:text-sky-400 font-medium">
                                            {{ $data['avg_rr'] }}
                                        </td>
                                        <td
                                            class="py-3 px-2 text-right font-semibold {{ $data['profit_loss'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            ${{ number_format($data['profit_loss'], 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">No
                                            session data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Charts -->
        <div class="my-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('analysis.pair_analysis.title') }}</h2>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-dollar mr-1 text-indigo-600 dark:text-indigo-400"></i>
                    {{ __('analysis.pair_analysis.subtitle') }}
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Profit/Loss per Symbol dengan Loading -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('analysis.pair_analysis.profit_loss_symbol') }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('analysis.pair_analysis.profit_loss_description') }}</p>
                        </div>
                        <div class="bg-sky-100 dark:bg-sky-900/30 p-2 rounded-lg">
                            <i class="fas fa-coins text-sky-600 dark:text-sky-400"></i>
                        </div>
                    </div>

                    <!-- Chart Container dengan Loading State -->
                    <div id="pairChartContainer" class="h-80 mb-4 relative">
                        <div id="pairChartLoading" class="chart-loading" style="display: none;">
                            <div class="chart-loading-spinner"></div>
                            <p class="chart-loading-text">{{ __('analysis.loading.pair_chart') }}</p>
                        </div>
                        <canvas id="pairChart" class="chart-canvas" style="display: none;"></canvas>
                    </div>

                    <div
                        class="overflow-x-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-white dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.pair_analysis.symbol') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.pair_analysis.total_pl') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sortedPairs = $pairData->sortByDesc(function ($value) {
                                        return abs($value);
                                    });
                                @endphp
                                @foreach ($sortedPairs as $symbol => $pl)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="py-2 px-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ $symbol }}</td>
                                        <td
                                            class="py-2 px-2 text-right font-bold {{ $pl >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} text-sm">
                                            {{ $pl >= 0 ? '+' : '' }}${{ number_format($pl, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Performance per Entry Type dengan Loading -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('analysis.pair_analysis.performance_entry_type') }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('analysis.pair_analysis.performance_description') }}</p>
                        </div>
                        <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-lg">
                            <i class="fas fa-chart-bar text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>

                    <!-- Chart Container dengan Loading State -->
                    <div id="entryTypeChartContainer" class="h-56 mb-4 relative">
                        <div id="entryTypeChartLoading" class="chart-loading" style="display: none;">
                            <div class="chart-loading-spinner"></div>
                            <p class="chart-loading-text">{{ __('analysis.loading.entry_type_chart') }}</p>
                        </div>
                        <canvas id="entryTypeChart" class="chart-canvas" style="display: none;"></canvas>
                    </div>

                    <div
                        class="overflow-x-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-white dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.pair_analysis.entry_type') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        <span
                                            class="text-emerald-600 dark:text-emerald-400">{{ __('analysis.stats.wins') }}</span>
                                    </th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        <span
                                            class="text-rose-600 dark:text-rose-400">{{ __('analysis.stats.losses') }}</span>
                                    </th>
                                    <th class="text-center py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.stats.winrate') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ __('analysis.pair_analysis.pl') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryTypeData as $type => $data)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="py-2 px-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ $type ?? 'N/A' }}</td>
                                        <td
                                            class="py-2 px-2 text-center text-emerald-600 dark:text-emerald-400 font-semibold">
                                            {{ $data['wins'] }}</td>
                                        <td class="py-2 px-2 text-center text-rose-600 dark:text-rose-400 font-semibold">
                                            {{ $data['losses'] }}</td>
                                        <td class="py-2 px-2 text-center">
                                            <span
                                                class="inline-block px-2 py-1 rounded {{ $data['winrate'] >= 50 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' }} font-semibold text-xs">
                                                {{ $data['winrate'] }}%
                                            </span>
                                        </td>
                                        <td
                                            class="py-2 px-2 text-right font-bold {{ $data['profit_loss'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} text-sm">
                                            {{ $data['profit_loss'] >= 0 ? '+' : '' }}${{ number_format($data['profit_loss'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session-Time Heatmap Modal -->
        <div id="sessionModal"
            class="hidden fixed inset-0 bg-black/50 dark:bg-black/80 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 id="sessionModalTitle" class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ __('analysis.modal.session_details') }}</h4>
                    <button id="closeSessionModal"
                        class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div id="sessionModalContent"
                    class="p-4 overflow-y-auto max-h-[60vh] scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600">
                    <!-- Content will be filled by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Section -->
    <script>
        // Chart Lazy Loading Manager (same as before but with updated color classes)
        class ChartLoader {
            constructor() {
                this.charts = [];
                this.loadedCharts = new Set();
                this.isLoading = false;
                this.loadDelay = 300;
                this.currentIndex = 0;
                this.maxChartsToLoad = 1;

                this.chartPriority = [
                    'sessionPolarChart',
                    'hourlyChart',
                    'pairChart',
                    'entryTypeChart',
                    'dayOfWeekChart',
                    'quarterlyChart',
                    'monthlyChart'
                ];
            }

            init() {
                const chartIds = this.chartPriority.filter(id => document.getElementById(id));

                chartIds.forEach(chartId => {
                    this.charts.push({
                        id: chartId,
                        loadingId: `${chartId}Loading`,
                        containerId: `${chartId}Container`,
                        chartData: null
                    });
                });

                this.startLazyLoading();
                this.setupIntersectionObserver();
            }

            setupIntersectionObserver() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const chartId = entry.target.id.replace('Container', '');
                            if (!this.loadedCharts.has(chartId) && !this.isChartLoading(chartId)) {
                                this.loadChart(chartId);
                            }
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '50px'
                });

                this.charts.forEach(chart => {
                    const container = document.getElementById(chart.containerId);
                    if (container) {
                        observer.observe(container);
                    }
                });
            }

            isChartLoading(chartId) {
                return Array.from(this.charts).some(chart =>
                    chart.id === chartId && chart.loading === true
                );
            }

            startLazyLoading() {
                if (this.charts.length > 0) {
                    this.loadChart(this.charts[0].id);
                }

                window.addEventListener('scroll', () => this.handleScroll());
            }

            handleScroll() {
                if (this.isLoading || this.currentIndex >= this.charts.length) return;

                const nextChart = this.charts[this.currentIndex];
                const container = document.getElementById(nextChart.containerId);

                if (container && this.isElementInViewport(container)) {
                    this.loadChart(nextChart.id);
                }
            }

            isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                    rect.bottom >= 0
                );
            }

            async loadChart(chartId) {
                if (this.loadedCharts.has(chartId)) return;

                const chartInfo = this.charts.find(c => c.id === chartId);
                if (!chartInfo) return;

                this.isLoading = true;

                const loadingEl = document.getElementById(chartInfo.loadingId);
                const canvasEl = document.getElementById(chartId);
                const containerEl = document.getElementById(chartInfo.containerId);

                if (loadingEl) loadingEl.style.display = 'block';
                if (canvasEl) canvasEl.style.display = 'none';

                try {
                    await new Promise(resolve => setTimeout(resolve, this.loadDelay));

                    this.renderChart(chartId);

                    this.loadedCharts.add(chartId);

                    if (loadingEl) loadingEl.style.display = 'none';
                    if (canvasEl) canvasEl.style.display = 'block';

                    this.currentIndex++;
                    if (this.currentIndex < this.charts.length) {
                        setTimeout(() => {
                            const nextChartId = this.charts[this.currentIndex].id;
                            if (!this.loadedCharts.has(nextChartId)) {
                                this.loadChart(nextChartId);
                            }
                        }, this.loadDelay);
                    }

                } catch (error) {
                    console.error(`Error loading chart ${chartId}:`, error);
                    if (loadingEl) {
                        loadingEl.innerHTML = `
                            <div class="text-rose-600 dark:text-rose-400 text-center">
                                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                                <p>{{ __('analysis.loading.chart_error') }}</p>
                            </div>
                        `;
                    }
                } finally {
                    this.isLoading = false;
                }
            }

            renderChart(chartId) {
                // These methods remain the same as in your original code
                switch (chartId) {
                    case 'hourlyChart':
                        this.renderHourlyChart();
                        break;
                    case 'pairChart':
                        this.renderPairChart();
                        break;
                    case 'entryTypeChart':
                        this.renderEntryTypeChart();
                        break;
                    case 'dayOfWeekChart':
                        this.renderDayOfWeekChart();
                        break;
                    case 'quarterlyChart':
                        this.renderQuarterlyChart();
                        break;
                    case 'monthlyChart':
                        this.renderMonthlyChart();
                        break;
                    case 'sessionPolarChart':
                        this.renderSessionPolarChart();
                        break;
                }
            }

            // hourly chart function
            renderHourlyChart() {
                const hourlyCtx = document.getElementById('hourlyChart');
                if (!hourlyCtx) return;

                const hourlyData = @json($hourlyPerformance->sortKeys());
                const hourlyLabels = Object.keys(hourlyData).map(hour => {
                    const nextHour = (parseInt(hour) + 1) % 24;
                    return hour.padStart(2, '0') + ':00-' + nextHour.toString().padStart(2, '0') + ':00';
                });
                const hourlyProfits = Object.values(hourlyData).map(data => data.profit);
                const hourlyTrades = Object.values(hourlyData).map(data => data.trades);

                if (hourlyProfits.length === 0 || hourlyProfits.every(p => p === 0)) {
                    document.getElementById('hourlyChartNoData').style.display = 'block';
                    document.getElementById('hourlyChartLoading').style.display = 'none';
                    return;
                }

                new Chart(hourlyCtx, {
                    type: 'bar',
                    data: {
                        labels: hourlyLabels,
                        datasets: [{
                            label: '{{ __('analysis.charts.profit') }}',
                            data: hourlyProfits,
                            backgroundColor: hourlyProfits.map(p =>
                                p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                            ),
                            borderColor: hourlyProfits.map(p =>
                                p >= 0 ? 'rgb(16, 185, 129)' : 'rgb(239, 68, 68)'
                            ),
                            borderWidth: 1,
                            borderRadius: 4,
                            yAxisID: 'y',
                        }, {
                            label: '{{ __('analysis.charts.trades') }}',
                            data: hourlyTrades,
                            type: 'line',
                            borderColor: 'rgb(59, 130, 246)',
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
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151'
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb',
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
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    maxRotation: 45
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
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
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280'
                                }
                            }
                        }
                    }
                });
            }

            // pair chart function
            renderPairChart() {
                const pairCtx = document.getElementById('pairChart').getContext('2d');
                const pairData = @json($pairData);
                const pairLabels = Object.keys(pairData);
                const pairValues = Object.values(pairData);

                if (pairLabels.length === 0) return;

                const sortedPairs = pairLabels
                    .map((label, idx) => ({
                        label,
                        value: pairValues[idx]
                    }))
                    .sort((a, b) => b.value - a.value);

                const sortedLabels = sortedPairs.map(p => p.label);
                const sortedValues = sortedPairs.map(p => p.value);

                new Chart(pairCtx, {
                    type: 'bar',
                    data: {
                        labels: sortedLabels,
                        datasets: [{
                            label: '{{ __('analysis.charts.profit_loss') }}',
                            data: sortedValues,
                            backgroundColor: sortedValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 0.7)' :
                                'rgba(239, 68, 68, 0.7)'),
                            borderColor: sortedValues.map(v => v >= 0 ? 'rgb(16, 185, 129)' :
                                'rgb(239, 68, 68)'),
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.x;
                                        return (value >= 0 ? '+' : '') + '$' + value.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // entry type chart function
            renderEntryTypeChart() {
                const etx = document.getElementById('entryTypeChart').getContext('2d');
                const entryData = @json($entryTypeData);
                const entryLabels = Object.keys(entryData);

                if (entryLabels.length === 0) return;

                const winsData = entryLabels.map(label => entryData[label].wins);
                const lossesData = entryLabels.map(label => entryData[label].losses);
                const profitData = entryLabels.map(label => entryData[label].profit_loss);
                const totalProfitWins = entryLabels.map(label => entryData[label].total_profit_wins);
                const totalLossLosses = entryLabels.map(label => entryData[label].total_loss_losses);

                new Chart(etx, {
                    type: 'bar',
                    data: {
                        labels: entryLabels,
                        datasets: [{
                                label: '{{ __('analysis.stats.wins') }}',
                                data: winsData,
                                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                borderColor: 'rgb(16, 185, 129)',
                                borderWidth: 1,
                                borderRadius: 4,
                                order: 2
                            },
                            {
                                label: '{{ __('analysis.stats.losses') }}',
                                data: lossesData,
                                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                                borderColor: 'rgb(239, 68, 68)',
                                borderWidth: 1,
                                borderRadius: 4,
                                order: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151',
                                    font: {
                                        size: 12
                                    },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb',
                                borderWidth: 1,
                                callbacks: {
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        const entryType = entryLabels[dataIndex];
                                        const profit = profitData[dataIndex];
                                        const profitWins = totalProfitWins[dataIndex];
                                        const lossLosses = totalLossLosses[dataIndex];

                                        return [
                                            'Total P/L: ' + (profit >= 0 ? '+' : '') + '$' + profit
                                            .toFixed(2),
                                            'Profit $: +$' + profitWins.toFixed(2),
                                            'Loss $: -$' + Math.abs(lossLosses).toFixed(2)
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            },
                            y: {
                                stacked: false,
                                beginAtZero: true,
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280'
                                }
                            }
                        }
                    }
                });
            }

            // day of week chart function
            renderDayOfWeekChart() {
                const dowCtx = document.getElementById('dayOfWeekChart');
                if (!dowCtx) return;

                const dowData = @json($dayOfWeekPerformance->sortBy('day_number'));
                const dowLabels = Object.values(dowData).map(d => d.short_name);
                const dowProfits = Object.values(dowData).map(d => d.profit);
                const dowWinrates = Object.values(dowData).map(d => d.winrate);

                new Chart(dowCtx, {
                    type: 'bar',
                    data: {
                        labels: dowLabels,
                        datasets: [{
                            label: '{{ __('analysis.charts.profit') }}',
                            data: dowProfits,
                            backgroundColor: dowProfits.map(p =>
                                p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                            ),
                            borderColor: dowProfits.map(p =>
                                p >= 0 ? 'rgb(16, 185, 129)' : 'rgb(239, 68, 68)'
                            ),
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151'
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb',
                                callbacks: {
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        const winrate = dowWinrates[dataIndex];
                                        return `Winrate: ${winrate}%`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // quarterly chart function
            renderQuarterlyChart() {
                const quarterlyCtx = document.getElementById('quarterlyChart');
                if (!quarterlyCtx) return;

                const quarterlyData = @json($quarterlyPerformance->sortDesc());
                const quarterlyLabels = Object.values(quarterlyData).map(q => q.quarter_name);
                const quarterlyProfits = Object.values(quarterlyData).map(q => q.profit);
                const quarterlyWinrates = Object.values(quarterlyData).map(q => q.winrate);

                new Chart(quarterlyCtx, {
                    type: 'bar',
                    data: {
                        labels: quarterlyLabels,
                        datasets: [{
                            label: '{{ __('analysis.charts.profit') }}',
                            data: quarterlyProfits,
                            backgroundColor: quarterlyProfits.map(p =>
                                p >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'
                            ),
                            borderColor: quarterlyProfits.map(p =>
                                p >= 0 ? 'rgb(16, 185, 129)' : 'rgb(239, 68, 68)'
                            ),
                            borderRadius: 4,
                            yAxisID: 'y',
                        }, {
                            label: '{{ __('analysis.stats.winrate') }} (%)',
                            data: quarterlyWinrates,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            yAxisID: 'y1',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151'
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280'
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // monthly chart function
            renderMonthlyChart() {
                const monthlyCtx = document.getElementById('monthlyChart');
                if (!monthlyCtx) return;

                const monthlyData = @json($monthlyPerformance->sortKeys()->take(12));
                const monthlyLabels = Object.values(monthlyData).map(m => m.month_name);
                const monthlyProfits = Object.values(monthlyData).map(m => m.profit);

                new Chart(monthlyCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: '{{ __('analysis.charts.monthly_profit') }}',
                            data: monthlyProfits,
                            borderColor: 'rgb(139, 92, 246)',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151'
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280'
                                }
                            },
                            y: {
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                                },
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // session polar chart function
            renderSessionPolarChart() {
                const sessionCtx = document.getElementById('sessionPolarChart');
                if (!sessionCtx) return;

                const sessionData = @json($sessionAnalysis);
                const sessionLabels = Object.keys(sessionData);
                const winrates = Object.values(sessionData).map(d => d.winrate);
                const trades = Object.values(sessionData).map(d => d.trades);
                const profits = Object.values(sessionData).map(d => d.profit_loss);
                const avgRR = Object.values(sessionData).map(d => d.avg_rr);

                const valueGroups = {};
                winrates.forEach((wr, index) => {
                    const key = wr.toString();
                    if (!valueGroups[key]) {
                        valueGroups[key] = [];
                    }
                    valueGroups[key].push(index);
                });

                const getShadedColor = (baseColor, index, duplicateCount) => {
                    if (duplicateCount <= 1) return baseColor;
                    const shadeFactor = 0.8 + (index / duplicateCount) * 0.4;
                    const rgba = baseColor.match(/[\d.]+/g);
                    if (!rgba) return baseColor;
                    const r = Math.min(255, Math.round(parseInt(rgba[0]) * shadeFactor));
                    const g = Math.min(255, Math.round(parseInt(rgba[1]) * shadeFactor));
                    const b = Math.min(255, Math.round(parseInt(rgba[2]) * shadeFactor));
                    const a = parseFloat(rgba[3]);
                    return `rgba(${r}, ${g}, ${b}, ${a})`;
                };

                const colors = winrates.map((wr, index) => {
                    let baseColor;
                    if (wr >= 60) baseColor = 'rgba(16, 185, 129, 0.7)';
                    else if (wr >= 50) baseColor = 'rgba(59, 130, 246, 0.7)';
                    else baseColor = 'rgba(239, 68, 68, 0.7)';

                    const key = wr.toString();
                    const duplicateIndices = valueGroups[key];

                    if (duplicateIndices.length > 1) {
                        const positionInDuplicates = duplicateIndices.indexOf(index);
                        return getShadedColor(baseColor, positionInDuplicates, duplicateIndices.length);
                    }

                    return baseColor;
                });

                const borderColors = winrates.map((wr, index) => {
                    let baseColor;
                    if (wr >= 60) baseColor = 'rgb(16, 185, 129)';
                    else if (wr >= 50) baseColor = 'rgb(59, 130, 246)';
                    else baseColor = 'rgb(239, 68, 68)';

                    const key = wr.toString();
                    const duplicateIndices = valueGroups[key];

                    if (duplicateIndices.length > 1) {
                        const positionInDuplicates = duplicateIndices.indexOf(index);
                        return getShadedColor(baseColor, positionInDuplicates, duplicateIndices.length);
                    }

                    return baseColor;
                });

                new Chart(sessionCtx, {
                    type: 'polarArea',
                    data: {
                        labels: sessionLabels,
                        datasets: [{
                            label: 'Win Rate (%)',
                            data: winrates,
                            backgroundColor: colors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                    '#111827',
                                borderColor: document.documentElement.classList.contains('dark') ? '#374151' :
                                    '#e5e7eb',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const label = context.label;
                                        const winrate = winrates[index];
                                        const tradeCount = trades[index];
                                        const profit = profits[index];
                                        const rr = avgRR[index];

                                        return [
                                            `${label}`,
                                            `Win Rate: ${winrate}%`,
                                            `Trades: ${tradeCount}`,
                                            `Avg RR: ${rr}`,
                                            `Profit: $${profit.toFixed(2)}`
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                        '#6b7280',
                                    backdropColor: 'transparent',
                                    font: {
                                        size: 11
                                    },
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                },
                                pointLabels: {
                                    color: document.documentElement.classList.contains('dark') ? '#e5e7eb' :
                                        '#374151',
                                    font: {
                                        size: 13,
                                        weight: 'bold'
                                    },
                                    padding: 8
                                },
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)',
                                    drawBorder: true,
                                    borderColor: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.4)' : 'rgba(209, 213, 219, 0.6)'
                                },
                                angleLines: {
                                    color: document.documentElement.classList.contains('dark') ?
                                        'rgba(75, 85, 99, 0.2)' : 'rgba(209, 213, 219, 0.3)'
                                }
                            }
                        }
                    }
                });
            }
        }

        // Initialize chart loader when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize chart loader
            const chartLoader = new ChartLoader();
            chartLoader.init();

            // Year Group Toggle Handler
            document.querySelectorAll('.year-toggle').forEach(btn => {
                btn.addEventListener('click', function() {
                    const yearGroup = this.closest('.year-group');
                    const yearContent = yearGroup.querySelector('.year-content');
                    const icon = this.querySelector('.year-toggle-icon');

                    yearContent.classList.toggle('max-h-0');
                    yearContent.classList.toggle('max-h-96');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Risk Metrics Toggle
            const toggleRiskDetails = document.getElementById('toggleRiskDetails');
            const riskDetails = document.getElementById('riskDetails');
            const toggleRiskIcon = document.getElementById('riskToggleIcon');
            const toggleRiskText = document.getElementById('riskToggleText');

            if (toggleRiskDetails && riskDetails) {
                toggleRiskDetails.addEventListener('click', function() {
                    riskDetails.classList.toggle('hidden');
                    if (toggleRiskIcon) {
                        if (riskDetails.classList.contains('hidden')) {
                            toggleRiskIcon.classList.remove('fa-chevron-up');
                            toggleRiskIcon.classList.add('fa-chevron-down');
                            toggleRiskText.textContent =
                                '{{ __('analysis.risk_management.show_details') }}';
                        } else {
                            toggleRiskIcon.classList.remove('fa-chevron-down');
                            toggleRiskIcon.classList.add('fa-chevron-up');
                            toggleRiskText.textContent =
                                '{{ __('analysis.risk_management.hide_details') }}';
                        }
                    }
                });
            }

            // Session Heatmap Modal Functionality
            const sessionModal = document.getElementById('sessionModal');
            const sessionModalTitle = document.getElementById('sessionModalTitle');
            const sessionModalContent = document.getElementById('sessionModalContent');
            const closeSessionModalBtn = document.getElementById('closeSessionModal');

            function getDayName(dayIndex) {
                const days = ['{{ __('analysis.days.Mon') }}', '{{ __('analysis.days.Tue') }}',
                    '{{ __('analysis.days.Wed') }}', '{{ __('analysis.days.Thu') }}',
                    '{{ __('analysis.days.Fri') }}', '{{ __('analysis.days.Sat') }}',
                    '{{ __('analysis.days.Sun') }}'
                ];
                return days[dayIndex] || 'Unknown';
            }

            function getHourRange(hour) {
                const startHour = hour.padStart(2, '0');
                const endHour = String((parseInt(hour) + 1) % 24).padStart(2, '0');
                return `${startHour}:00-${endHour}:00`;
            }

            document.querySelectorAll('#heatmapContainer [data-trades]').forEach(cell => {
                cell.addEventListener('click', function() {
                    const hour = this.getAttribute('data-hour');
                    const day = parseInt(this.getAttribute('data-day'));
                    const profit = parseFloat(this.getAttribute('data-profit'));
                    const trades = parseInt(this.getAttribute('data-trades'));

                    if (trades > 0) {
                        const dayName = getDayName(day);
                        const hourRange = getHourRange(hour);

                        sessionModalTitle.textContent = `${dayName}, ${hourRange}`;

                        let content = `
                            <div class="mb-4 p-3 rounded-lg ${profit > 0 ? 'bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-600/30 dark:border-emerald-500/30' : profit < 0 ? 'bg-rose-100 dark:bg-rose-900/30 border border-rose-600/30 dark:border-rose-500/30' : 'bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600'}">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('analysis.modal.total_performance') }}</div>
                                        <div class="text-2xl font-bold ${profit > 0 ? 'text-emerald-600 dark:text-emerald-400' : profit < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-gray-600 dark:text-gray-400'}">
                                            $${profit.toFixed(2)}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('analysis.modal.total_trades') }}</div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${trades}</div>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('analysis.modal.time_slot') }}</div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">${hourRange} (GMT)</div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('analysis.modal.performance_insights') }}</h5>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('analysis.modal.avg_pl_per_trade') }}</div>
                                        <div class="text-lg font-bold ${(profit/trades) >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'}">
                                            $${(profit/trades).toFixed(2)}
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('analysis.modal.win_loss_ratio') }}</div>
                                        <div class="text-lg font-bold ${profit > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'}">
                                            ${profit > 0 ? '{{ __('analysis.modal.profitable') }}' : '{{ __('analysis.modal.unprofitable') }}'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('analysis.modal.recommendations') }}</h5>
                                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-start gap-2">
                                        <i class="fas ${profit > 0 ? 'fa-thumbs-up text-emerald-600' : 'fa-thumbs-down text-rose-600'} mt-0.5"></i>
                                        <div>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                                ${profit > 0 
                                                    ? '{{ __('analysis.modal.positive_recommendation') }}'
                                                    : '{{ __('analysis.modal.negative_recommendation') }}'}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ __('analysis.modal.based_on') }} ${trades} {{ __('analysis.modal.at_this_time') }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-xs text-gray-600 dark:text-gray-400 text-center">
                                    <i class="fas fa-lightbulb mr-1 text-amber-500"></i>
                                    {{ __('analysis.modal.click_other_slots') }}
                                </p>
                            </div>
                        `;

                        sessionModalContent.innerHTML = content;
                        sessionModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });

            closeSessionModalBtn.addEventListener('click', function() {
                sessionModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            sessionModal.addEventListener('click', function(e) {
                if (e.target === sessionModal) {
                    sessionModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sessionModal.classList.contains('hidden')) {
                    sessionModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            // Balance Toggle Script
            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const balanceText = document.getElementById('balanceText');
            const balanceValue = document.getElementById('balanceValue');
            const balanceIcon = document.getElementById('balanceIcon');

            const isVisible = localStorage.getItem('balanceVisible') === 'true';

            if (isVisible) {
                showValues();
            }

            toggleBalanceBtn.addEventListener('click', function() {
                if (balanceText.classList.contains('hidden')) {
                    hideValues();
                } else {
                    showValues();
                }
            });

            function showValues() {
                balanceText.classList.add('hidden');
                balanceValue.classList.remove('hidden');
                balanceIcon.classList.remove('fa-eye-slash');
                balanceIcon.classList.add('fa-eye');
                localStorage.setItem('balanceVisible', 'true');
                toggleBalanceBtn.title = "{{ __('analysis.stats.hide_balance') }}";
            }

            function hideValues() {
                balanceText.classList.remove('hidden');
                balanceValue.classList.add('hidden');
                balanceIcon.classList.remove('fa-eye');
                balanceIcon.classList.add('fa-eye-slash');
                localStorage.setItem('balanceVisible', 'false');
                toggleBalanceBtn.title = "{{ __('analysis.stats.show_balance') }}";
            }

            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && (e.key === 'b' || e.key === 'B' || e.key === 'h' || e.key === 'H')) {
                    e.preventDefault();
                    toggleBalanceBtn.click();
                }
            });

            // Listen for theme changes to update chart colors
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        // Reload charts with new theme colors if needed
                        // This is handled by the chart renderers checking dark mode on each render
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true
            });
        });
    </script>

    <!-- Chart Loading Styles -->
    <style>
        /* Loading animation for charts */
        .chart-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            z-index: 10;
            border-radius: 0.5rem;
        }

        .dark .chart-loading {
            background: rgba(17, 24, 39, 0.8);
        }

        .chart-loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(59, 130, 246, 0.3);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: chart-spin 1s linear infinite;
            margin-bottom: 12px;
        }

        .chart-loading-text {
            color: #4b5563;
            font-size: 0.875rem;
            text-align: center;
        }

        .dark .chart-loading-text {
            color: #9ca3af;
        }

        .chart-canvas {
            transition: opacity 0.3s ease;
        }

        .chart-no-data {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @keyframes chart-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .chart-canvas {
            animation: chart-fade-in 0.5s ease-out;
        }

        @keyframes chart-fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar styles */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Grid layout for heatmap */
        .grid-cols-25 {
            grid-template-columns: repeat(25, minmax(0, 1fr));
        }

        /* Year group transitions */
        .year-content {
            transition: max-height 0.3s ease-in-out;
        }

        .year-toggle-icon {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Card hover effects */
        .hover\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dark .hover\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        /* Modal backdrop */
        #sessionModal {
            transition: opacity 0.2s ease;
            opacity: 0;
        }

        #sessionModal:not(.hidden) {
            opacity: 1;
        }

        #sessionModalContent {
            scrollbar-width: thin;
        }
    </style>
@endsection
