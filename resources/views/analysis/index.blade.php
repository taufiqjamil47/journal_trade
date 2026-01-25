@extends('Layouts.index')
@section('title', __('analysis.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('analysis.title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('analysis.subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-all duration-300  active:scale-95"
                        data-nav-state-save="true">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2 nav-toggle-icon"></i>
                    </button>

                    <!-- Navigation Items Container -->
                    <div id="navItems"
                        class="hidden nav-items-container opacity-0 scale-95 transform transition-all duration-300">
                        <div class="flex items-center space-x-1 bg-gray-800 rounded-lg p-1 border border-gray-700">
                            <!-- Dashboard Link -->
                            @if (!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                                    title="Dashboard" data-nav-state-save="true">
                                    <i
                                        class="fas fa-home text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.dashboard') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Calendar Link -->
                            @if (!request()->routeIs('reports.calendar'))
                                <a href="{{ route('reports.calendar') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Calendar" data-nav-state-save="true">
                                    <i
                                        class="fas fa-calendar text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.calendar') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Analysis Link -->
                            @if (!request()->routeIs('analysis.*'))
                                <a href="{{ route('analysis.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Analysis" data-nav-state-save="true">
                                    <i
                                        class="fa-solid fa-magnifying-glass-chart text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.analysis') }}
                                    </span>
                                </a>
                            @endif

                            <div class="h-6 w-px bg-gray-600 transition-all duration-300"></div>

                            <!-- Trades Link -->
                            @if (!request()->routeIs('trades.*'))
                                <a href="{{ route('trades.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Trades" data-nav-state-save="true">
                                    <i
                                        class="fas fa-chart-line text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.trades') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Sessions Link -->
                            @if (!request()->routeIs('sessions.*'))
                                <a href="{{ route('sessions.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Sessions" data-nav-state-save="true">
                                    <i
                                        class="fas fa-clock text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.sessions') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Symbols Link -->
                            @if (!request()->routeIs('symbols.*'))
                                <a href="{{ route('symbols.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Symbols" data-nav-state-save="true">
                                    <i
                                        class="fas fa-money-bill-transfer text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.symbols') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Rules Link -->
                            @if (!request()->routeIs('trading-rules.*'))
                                <a href="{{ route('trading-rules.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Rules" data-nav-state-save="true">
                                    <i
                                        class="fas fa-list text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.rules') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trader Item dengan animasi muncul -->
                    <div
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 transition-all duration-300 hover:border-primary-500 ">
                        <i class="fas fa-user text-primary-500 mr-2 transition-transform duration-200 hover:scale-110"></i>
                        <span class="transition-all duration-200">Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Summary Alert -->
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
                            {{ $summary['trades'] }} {{ __('analysis.stats.trades') }} ·
                            {{ __('analysis.stats.winrate') }}: <span
                                class="font-semibold">{{ $summary['winrate'] }}%</span> ·
                            <span class="{{ $summary['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">
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
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">{{ __('analysis.stats.balance') }}</p>
                        <div class="flex items-center gap-2">
                            <h3 id="balanceText" class="text-2xl font-bold mt-2">******</h3>
                            <h3 id="balanceValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($balance, 2) }}
                            </h3>
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
                                    <p
                                        class="text-lg font-bold {{ $netProfit >= 0 ? 'text-green-400' : 'text-red-400' }}">
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
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
            <form method="GET" action="{{ route('analysis.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Period Filter -->
                <div>
                    <label for="period"
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.period') }}</label>
                    <select name="period" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
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
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.session') }}</label>
                    <select name="session" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
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
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.entry_type') }}</label>
                    <select name="entry_type" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
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
                                        <span
                                            class="text-gray-400">{{ __('analysis.risk_management.average_risk') }}</span>
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
                        <h3 class="text-lg font-bold text-primary-300">{{ __('analysis.time_analysis.heatmap_title') }}
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('analysis.time_analysis.heatmap_description') }}</p>
                    </div>
                    <button id="toggleHeatmap" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                {{-- <div id="heatmapContainer" class="verflow-visible relative z-0"> --}}
                <div id="heatmapContainer" class="overflow-x-auto lg:overflow-visible relative z-0">
                    <div class="min-w-max">
                        <!-- Header row with times (columns) -->
                        <div class="grid grid-cols-25 gap-1 mb-1">
                            <div class="text-xs text-gray-500 text-center py-1">{{ __('analysis.time_analysis.day') }}
                            </div>
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                    $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="text-xs text-gray-500 text-center py-1">{{ $hourStr }}:00</div>
                            @endfor
                        </div>

                        <!-- Data rows for each day -->
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayIndex => $dayName)
                            <div class="grid grid-cols-25 gap-1 mb-1">
                                <!-- Day label -->
                                <div class="text-xs text-gray-400 text-center py-1 font-medium">
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
                                        <div class="w-11 h-8 {{ $bgColor }} rounded {{ $trades > 0 ? 'cursor-pointer hover:opacity-80' : '' }} transition-all"
                                            data-day="{{ $dayIndex }}" data-hour="{{ $hourStr }}"
                                            data-profit="{{ $profit }}" data-trades="{{ $trades }}">
                                            <div class="flex items-center justify-center h-full">
                                                @if ($trades > 0)
                                                    @php
                                                        // Hitung jumlah digit (termasuk tanda minus)
                                                        $profitLength = strlen((string) $profit);
                                                        $fontSizeClass = match (true) {
                                                            $profitLength >= 6
                                                                => 'text-[9px]', // 100000+ (6 digit atau lebih)
                                                            $profitLength == 5 => 'text-[10px]', // 10000-99999
                                                            $profitLength == 4 => 'text-[11px]', // 1000-9999
                                                            $profitLength == 3 => 'text-[12px]', // 100-999
                                                            $profitLength == 2
                                                                => 'text-xs', // 10-99 (termasuk minus 1 digit: -1)
                                                            default => 'text-xs', // 0-9 atau minus 1 digit
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
                                            <div class="absolute z-50 hidden group-hover:block bg-gray-900 border border-gray-700 rounded-lg p-2 text-xs shadow-xl min-w-32"
                                                style="left: -100%; bottom: calc(100% + 8px);">
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

                    <div class="overflow-y-auto h-64">
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
                                            <span
                                                class="{{ $day['winrate'] >= 50 ? 'text-green-400' : 'text-red-400' }}">
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
        </div>

        <!-- Session Analysis with Polar Chart -->
        <div class="my-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Session Polar Chart -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-primary-300">
                                {{ __('analysis.time_analysis.session_performance') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('analysis.time_analysis.distribution') }}</p>
                        </div>
                        <div class="bg-purple-500/20 p-2 rounded-lg">
                            <i class="fas fa-chart-pie text-purple-500"></i>
                        </div>
                    </div>

                    <!-- Chart Container dengan Loading State -->
                    <div id="sessionPolarChartContainer" class="h-80 relative">
                        <div id="sessionPolarChartLoading" class="chart-loading">
                            <div class="chart-loading-spinner"></div>
                            <p class="chart-loading-text">{{ __('analysis.time_analysis.session_polar_chart') }}</p>
                        </div>
                        <canvas id="sessionPolarChart" class="chart-canvas" style="display: none;"></canvas>
                    </div>
                </div>

                <!-- Session Stats Table -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-primary-300">
                                {{ __('analysis.time_analysis.metrics.label1') }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ __('analysis.time_analysis.metrics.label2') }}</p>
                        </div>
                        <div class="bg-indigo-500/20 p-2 rounded-lg">
                            <i class="fas fa-table text-indigo-500"></i>
                        </div>
                    </div>

                    <div class="overflow-x-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-700">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0">
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.time_analysis.metrics.session') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.time_analysis.metrics.trades') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.time_analysis.metrics.winrate') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.time_analysis.metrics.avg_rr') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.time_analysis.metrics.profit_loss') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessionAnalysis as $session => $data)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                        <td class="py-3 px-2 font-medium text-white">
                                            <span
                                                class="inline-block px-3 py-1 bg-primary-500/20 text-primary-300 rounded-full text-xs">
                                                {{ $session ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center text-white font-semibold">{{ $data['trades'] }}
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <span
                                                class="inline-block px-2 py-1 rounded {{ $data['winrate'] >= 50 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} font-medium">
                                                {{ $data['winrate'] }}%
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center text-blue-400 font-medium">{{ $data['avg_rr'] }}
                                        </td>
                                        <td
                                            class="py-3 px-2 text-right font-semibold {{ $data['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                            {{ number_format($data['profit_loss'], 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500">No session data
                                            available</td>
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
                    <div id="pairChartContainer" class="h-80 mb-4 relative">
                        <div id="pairChartLoading" class="chart-loading">
                            <div class="chart-loading-spinner"></div>
                            <p class="chart-loading-text">{{ __('analysis.loading.pair_chart') }}</p>
                        </div>
                        <canvas id="pairChart" class="chart-canvas" style="display: none;"></canvas>
                    </div>

                    <div class="overflow-x-auto max-h-80">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-gray-900">
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.pair_analysis.symbol') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-400 font-medium">
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
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                        <td class="py-2 px-2 text-sm font-medium">{{ $symbol }}</td>
                                        <td
                                            class="py-2 px-2 text-right font-bold {{ $pl >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                            {{ $pl >= 0 ? '+' : '' }}${{ number_format($pl, 2) }}
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

                    <div class="overflow-x-auto max-h-80">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-gray-900">
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.pair_analysis.entry_type') }}</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        <span class="text-green-400">{{ __('analysis.stats.wins') }}</span>
                                    </th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        <span class="text-red-400">{{ __('analysis.stats.losses') }}</span>
                                    </th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.stats.winrate') }}</th>
                                    <th class="text-right py-3 px-2 text-gray-400 font-medium">
                                        <span class="text-green-400">Profit</span>
                                    </th>
                                    <th class="text-right py-3 px-2 text-gray-400 font-medium">
                                        <span class="text-red-400">Loss</span>
                                    </th>
                                    <th class="text-right py-3 px-2 text-gray-400 font-medium">
                                        {{ __('analysis.pair_analysis.pl') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryTypeData as $type => $data)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-750/50 transition-colors">
                                        <td class="py-2 px-2 text-sm font-medium">{{ $type ?? 'N/A' }}</td>
                                        <td class="py-2 px-2 text-center text-green-400 font-semibold">
                                            {{ $data['wins'] }}</td>
                                        <td class="py-2 px-2 text-center text-red-400 font-semibold">
                                            {{ $data['losses'] }}</td>
                                        <td class="py-2 px-2 text-center">
                                            <span
                                                class="inline-block px-2 py-1 rounded {{ $data['winrate'] >= 50 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} font-semibold text-xs">
                                                {{ $data['winrate'] }}%
                                            </span>
                                        </td>
                                        <td class="py-2 px-2 text-right text-green-400 font-semibold">
                                            +${{ number_format($data['total_profit_wins'], 2) }}
                                        </td>
                                        <td class="py-2 px-2 text-right text-red-400 font-semibold">
                                            -${{ number_format(abs($data['total_loss_losses']), 2) }}
                                        </td>
                                        <td
                                            class="py-2 px-2 text-right font-bold {{ $data['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
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
        <div id="sessionModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div
                class="bg-gray-800 border border-gray-700 rounded-xl w-full max-w-2xl mx-auto max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-700">
                    <h4 id="sessionModalTitle" class="text-lg font-bold text-primary-400">
                        {{ __('analysis.modal.session_details') }}</h4>
                    <button id="closeSessionModal" class="text-gray-400 hover:text-white transition-colors p-2">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div id="sessionModalContent" class="p-4 overflow-y-auto max-h-[60vh]">
                    <!-- Content will be filled by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Section -->
    <script>
        // Chart Lazy Loading Manager
        class ChartLoader {
            constructor() {
                this.charts = [];
                this.loadedCharts = new Set();
                this.isLoading = false;
                this.loadDelay = 300; // ms delay between chart loads
                this.currentIndex = 0;
                this.maxChartsToLoad = 1; // Load one chart at a time

                // Chart loading order priority
                this.chartPriority = [
                    'sessionPolarChart',
                    'hourlyChart',
                    'pairChart',
                    'entryTypeChart',
                    'dayOfWeekChart',
                    'monthlyChart'
                ];
            }

            init() {
                // Collect all chart containers
                const chartIds = this.chartPriority.filter(id => document.getElementById(id));

                chartIds.forEach(chartId => {
                    this.charts.push({
                        id: chartId,
                        loadingId: `${chartId}Loading`,
                        containerId: `${chartId}Container`,
                        chartData: null
                    });
                });

                // Start loading charts
                this.startLazyLoading();

                // Also load charts when scrolling into view
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

                // Observe each chart container
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
                // Load first chart immediately
                if (this.charts.length > 0) {
                    this.loadChart(this.charts[0].id);
                }

                // Setup scroll-based loading for the rest
                window.addEventListener('scroll', () => this.handleScroll());
            }

            handleScroll() {
                if (this.isLoading || this.currentIndex >= this.charts.length) return;

                // Check if next chart container is in viewport
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

                // Show loading state
                const loadingEl = document.getElementById(chartInfo.loadingId);
                const canvasEl = document.getElementById(chartId);
                const containerEl = document.getElementById(chartInfo.containerId);

                if (loadingEl) loadingEl.style.display = 'block';
                if (canvasEl) canvasEl.style.display = 'none';

                try {
                    // Simulate loading delay for better UX
                    await new Promise(resolve => setTimeout(resolve, this.loadDelay));

                    // Render the chart
                    this.renderChart(chartId);

                    // Mark as loaded
                    this.loadedCharts.add(chartId);

                    // Hide loading, show chart
                    if (loadingEl) loadingEl.style.display = 'none';
                    if (canvasEl) canvasEl.style.display = 'block';

                    // Load next chart after delay
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
                    // Show error state
                    if (loadingEl) {
                        loadingEl.innerHTML = `
                            <div class="text-red-400 text-center">
                                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                                <p>{{ __('analysis.loading.chart_error') }}</p>
                            </div>
                        `;
                    }
                } finally {
                    this.isLoading = false;
                }
            }

            // Render chart based on ID
            renderChart(chartId) {
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

                // Check if there's data to show
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
                                p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                            ),
                            borderWidth: 1,
                            borderRadius: 4,
                            yAxisID: 'y',
                        }, {
                            label: '{{ __('analysis.charts.trades') }}',
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
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
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
                                            label += context.parsed.y +
                                                ' {{ __('analysis.stats.trades') }}';
                                        }
                                        return label;
                                    }
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

                // Sort by value (descending)
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
                            borderColor: sortedValues.map(v => v >= 0 ? 'rgba(16, 185, 129, 1)' :
                                'rgba(239, 68, 68, 1)'),
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Horizontal bar
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
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleColor: '#f3f4f6',
                                bodyColor: '#f3f4f6',
                                borderColor: 'rgba(75, 85, 99, 0.5)',
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
                                    color: 'rgba(75, 85, 99, 0.3)'
                                },
                                ticks: {
                                    color: '#9ca3af',
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
                                    color: '#9ca3af',
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

                // Extract wins and losses for grouped bars
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
                                borderColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 1,
                                borderRadius: 4,
                                order: 2
                            },
                            {
                                label: '{{ __('analysis.stats.losses') }}',
                                data: lossesData,
                                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                                borderColor: 'rgba(239, 68, 68, 1)',
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
                                    color: '#9ca3af',
                                    font: {
                                        size: 12
                                    },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleColor: '#f3f4f6',
                                bodyColor: '#f3f4f6',
                                borderColor: 'rgba(75, 85, 99, 0.5)',
                                borderWidth: 1,
                                callbacks: {
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        const entryType = entryLabels[dataIndex];
                                        const profit = profitData[dataIndex];
                                        const profitWins = totalProfitWins[dataIndex];
                                        const lossLosses = totalLossLosses[dataIndex];

                                        let tooltip = 'Total P/L: ' + (profit >= 0 ? '+' : '') + '$' +
                                            profit.toFixed(2);
                                        tooltip += '\nProfit $: +$' + profitWins.toFixed(2);
                                        tooltip += '\nLoss $: -$' + Math.abs(lossLosses).toFixed(2);

                                        return tooltip;
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
                                    color: '#9ca3af',
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
                                p >= 0 ? 'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'
                            ),
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Ubah menjadi horizontal chart
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
                            },
                            tooltip: {
                                callbacks: {
                                    afterLabel: function(context) {
                                        const dataIndex = context.dataIndex;
                                        const winrate = dowWinrates[dataIndex];
                                        return `{{ __('analysis.stats.winrate') }}: ${winrate}%`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value
                                            .toLocaleString(); // Sesuaikan dengan mata uang Anda
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
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
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
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

                // Generate colors based on winrate
                const colors = winrates.map(wr => {
                    if (wr >= 60) return 'rgba(16, 185, 129, 0.7)'; // Green for > 60%
                    if (wr >= 50) return 'rgba(59, 130, 246, 0.7)'; // Blue for > 50%
                    return 'rgba(239, 68, 68, 0.7)'; // Red for < 50%
                });

                const borderColors = winrates.map(wr => {
                    if (wr >= 60) return 'rgba(16, 185, 129, 1)';
                    if (wr >= 50) return 'rgba(59, 130, 246, 1)';
                    return 'rgba(239, 68, 68, 1)';
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
                                    color: '#9ca3af',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleColor: '#f3f4f6',
                                bodyColor: '#f3f4f6',
                                borderColor: 'rgba(75, 85, 99, 0.5)',
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
                                    color: '#9ca3af',
                                    backdropColor: 'transparent',
                                    // Hapus stepSize untuk otomatis
                                    font: {
                                        size: 11
                                    },
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                },
                                pointLabels: {
                                    color: '#e5e7eb',
                                    font: {
                                        size: 13,
                                        weight: 'bold'
                                    },
                                    padding: 8
                                },
                                grid: {
                                    color: 'rgba(75, 85, 99, 0.3)',
                                    drawBorder: true,
                                    borderColor: 'rgba(75, 85, 99, 0.4)'
                                },
                                angleLines: {
                                    color: 'rgba(75, 85, 99, 0.2)'
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
                            toggleRiskDetails.querySelector('span').textContent =
                                '{{ __('analysis.risk_management.show_details') }}';
                        } else {
                            toggleRiskIcon.classList.remove('fa-chevron-down');
                            toggleRiskIcon.classList.add('fa-chevron-up');
                            toggleRiskDetails.querySelector('span').textContent =
                                '{{ __('analysis.risk_management.hide_details') }}';
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
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                const value = parseFloat(stat.textContent.replace(/[^0-9.-]+/g, ""));
                if (!isNaN(value)) {
                    animateCounter(stat, 0, value, 1000);
                }
            });

            // Session Heatmap Modal Functionality
            const sessionModal = document.getElementById('sessionModal');
            const sessionModalTitle = document.getElementById('sessionModalTitle');
            const sessionModalContent = document.getElementById('sessionModalContent');
            const closeSessionModalBtn = document.getElementById('closeSessionModal');

            // Function to get day name from index
            function getDayName(dayIndex) {
                const days = ['{{ __('analysis.days.Mon') }}', '{{ __('analysis.days.Tue') }}',
                    '{{ __('analysis.days.Wed') }}', '{{ __('analysis.days.Thu') }}',
                    '{{ __('analysis.days.Fri') }}', '{{ __('analysis.days.Sat') }}',
                    '{{ __('analysis.days.Sun') }}'
                ];
                return days[dayIndex] || '{{ __('analysis.unknown') }}';
            }

            // Function to format hour range
            function getHourRange(hour) {
                const startHour = hour.padStart(2, '0');
                const endHour = String((parseInt(hour) + 1) % 24).padStart(2, '0');
                return `${startHour}:00-${endHour}:00`;
            }

            // Heatmap Cell Click Handler
            document.querySelectorAll('#heatmapContainer [data-trades]').forEach(cell => {
                cell.addEventListener('click', function() {
                    const hour = this.getAttribute('data-hour');
                    const day = parseInt(this.getAttribute('data-day'));
                    const profit = parseFloat(this.getAttribute('data-profit'));
                    const trades = parseInt(this.getAttribute('data-trades'));

                    if (trades > 0) {
                        const dayName = getDayName(day);
                        const hourRange = getHourRange(hour);

                        // Set modal title
                        sessionModalTitle.textContent = `${dayName}, ${hourRange}`;

                        // Create modal content
                        let content = `
                            <div class="mb-4 p-3 rounded-lg ${profit > 0 ? 'bg-green-500/10 border border-green-500/30' : profit < 0 ? 'bg-red-500/10 border border-red-500/30' : 'bg-gray-700/50 border border-gray-600'}">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <div class="text-sm text-gray-400">${'{{ __('analysis.modal.total_performance') }}'}</div>
                                        <div class="text-2xl font-bold ${profit > 0 ? 'text-green-400' : profit < 0 ? 'text-red-400' : 'text-gray-400'}">
                                            $${profit.toFixed(2)}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-400">${'{{ __('analysis.modal.total_trades') }}'}</div>
                                        <div class="text-2xl font-bold text-gray-200">${trades}</div>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-600">
                                    <div class="text-xs text-gray-400">${'{{ __('analysis.modal.time_slot') }}'}</div>
                                    <div class="text-sm text-gray-300">${hourRange} (GMT)</div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-sm font-medium text-gray-300 mb-2">${'{{ __('analysis.modal.performance_insights') }}'}</h5>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-750 rounded-lg p-3">
                                        <div class="text-xs text-gray-400">${'{{ __('analysis.modal.avg_pl_per_trade') }}'}</div>
                                        <div class="text-lg font-bold ${(profit/trades) >= 0 ? 'text-green-400' : 'text-red-400'}">
                                            $${(profit/trades).toFixed(2)}
                                        </div>
                                    </div>
                                    <div class="bg-gray-750 rounded-lg p-3">
                                        <div class="text-xs text-gray-400">${'{{ __('analysis.modal.win_loss_ratio') }}'}</div>
                                        <div class="text-lg font-bold text-gray-200">
                                            ${profit > 0 ? '{{ __('analysis.modal.profitable') }}' : '{{ __('analysis.modal.unprofitable') }}'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="text-sm font-medium text-gray-300 mb-2">${'{{ __('analysis.modal.recommendations') }}'}</h5>
                                <div class="bg-gray-900/50 rounded-lg p-3 border border-gray-700">
                                    <div class="flex items-start gap-2">
                                        <i class="fas ${profit > 0 ? 'fa-thumbs-up text-green-500' : 'fa-thumbs-down text-red-500'} mt-0.5"></i>
                                        <div>
                                            <p class="text-sm text-gray-300">
                                                ${profit > 0 
                                                    ? '{{ __('analysis.modal.positive_recommendation') }}'
                                                    : '{{ __('analysis.modal.negative_recommendation') }}'}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                ${'{{ __('analysis.modal.based_on') }}'} ${trades} ${'{{ __('analysis.stats.trades') }}'}${trades !== 1 ? '' : ''} ${'{{ __('analysis.modal.at_this_time') }}'}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <p class="text-xs text-gray-400 text-center">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    ${'{{ __('analysis.modal.click_other_slots') }}'}
                                </p>
                            </div>
                        `;

                        sessionModalContent.innerHTML = content;
                        sessionModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });


            // Close Session Modal
            closeSessionModalBtn.addEventListener('click', function() {
                sessionModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Close modal when clicking outside
            sessionModal.addEventListener('click', function(e) {
                if (e.target === sessionModal) {
                    sessionModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sessionModal.classList.contains('hidden')) {
                    sessionModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            // Balance & Equity Toggle Script
            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const balanceText = document.getElementById('balanceText');
            const balanceValue = document.getElementById('balanceValue');
            const balanceIcon = document.getElementById('balanceIcon');

            // Load state from localStorage
            const isVisible = localStorage.getItem('balanceVisible') === 'true';

            // Apply saved state
            if (isVisible) {
                showValues();
            }

            // Toggle function untuk keduanya
            toggleBalanceBtn.addEventListener('click', function() {
                if (balanceText.classList.contains('hidden')) {
                    hideValues();
                } else {
                    showValues();
                }
            });

            // Helper functions
            function showValues() {
                // Show Balance
                balanceText.classList.add('hidden');
                balanceValue.classList.remove('hidden');
                balanceIcon.classList.remove('fa-eye-slash');
                balanceIcon.classList.add('fa-eye');

                // Save state
                localStorage.setItem('balanceVisible', 'true');

                // Update tooltip
                toggleBalanceBtn.title = "{{ __('analysis.stats.hide_balance') }}";
            }

            function hideValues() {
                // Hide Balance
                balanceText.classList.remove('hidden');
                balanceValue.classList.add('hidden');
                balanceIcon.classList.remove('fa-eye');
                balanceIcon.classList.add('fa-eye-slash');

                // Save state
                localStorage.setItem('balanceVisible', 'false');

                // Update tooltip
                toggleBalanceBtn.title = "{{ __('analysis.stats.show_balance') }}";
            }

            // Optional: Keyboard shortcut untuk toggle keduanya
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && (e.key === 'b' || e.key === 'B' || e.key === 'h' || e.key === 'H')) {
                    e.preventDefault();
                    toggleBalanceBtn.click();
                }
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
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(4px);
            z-index: 10;
            border-radius: 0.5rem;
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
            color: #9ca3af;
            font-size: 0.875rem;
            text-align: center;
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

        /* Fade in animation for charts */
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

        /* Loading progress indicator */
        .chart-loading-progress {
            width: 100%;
            height: 3px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 10px;
        }

        .chart-loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            animation: chart-progress 2s ease-in-out infinite;
        }

        @keyframes chart-progress {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>

    <!-- Stats Card Styles -->
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

    <!-- Heatmap Styles -->
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

        /* Session Heatmap Modal Styles */
        #sessionModalContent::-webkit-scrollbar {
            width: 6px;
        }

        #sessionModalContent::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        #sessionModalContent::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        /* Smooth transition for modal */
        #sessionModal {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        #sessionModal:not(.hidden) {
            opacity: 1;
        }

        /* Heatmap cell hover effects */
        #heatmapContainer [data-trades] {
            transition: all 0.2s ease;
            position: relative;
        }

        #heatmapContainer [data-trades]:hover {
            transform: scale(1.05);
            z-index: 20;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        #heatmapContainer [data-trades]:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 2px solid currentColor;
            border-radius: 4px;
            pointer-events: none;
            opacity: 0.3;
        }
    </style>
@endsection
