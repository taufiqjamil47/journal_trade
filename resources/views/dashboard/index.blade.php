@extends('Layouts.index')
@section('title', __('dashboard.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('dashboard.title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('dashboard.subtitle') }}</p>
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

                            <!-- Account Link - Ditambahkan setelah Rules Link -->
                            @if (!request()->routeIs('accounts.*'))
                                <a href="{{ route('accounts.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Account" data-nav-state-save="true">
                                    <i
                                        class="fas fa-user text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.accounts') }}
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <!-- Balance Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">{{ __('dashboard.balance') }}</p>
                        <div class="flex items-center gap-2">
                            <h3 id="balanceText" class="text-2xl font-bold mt-2">******</h3>
                            <h3 id="balanceValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($balance, 2) }}
                            </h3>
                            <button id="toggleBalance" type="button"
                                class="mt-2 px-2 rounded-lg hover:bg-primary-500/30 transition-colors"
                                title="Show/Hide Balance & Equity">
                                <i id="balanceIcon" class="fas fa-eye-slash text-primary-500 text-lg"></i>
                            </button>
                        </div>
                        <div class="text-sm mt-1 text-gray-400">
                            {{ __('dashboard.initial') }}: ${{ number_format($initial_balance ?? $balance, 2) }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="bg-primary-500/20 p-3 rounded-lg">
                            <i class="fas fa-wallet text-primary-500 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-400">{{ __('dashboard.active') }}</span>
                </div>
            </div>

            <!-- Equity Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">{{ __('dashboard.equity') }}</p>
                        <div class="flex items-center gap-2">
                            <h3 id="equityText" class="text-2xl font-bold mt-2">******</h3>
                            <h3 id="equityValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($equity, 2) }}
                            </h3>
                        </div>
                        <!-- TAMBAHKAN DISPLAY PERSENTASE DI SINI -->
                        <div class="text-sm mt-1">
                            @php
                                $equityChange = $equity_change_percentage ?? 0;
                                $vsBalanceChange = $equity_vs_balance_percentage ?? 0;
                            @endphp

                            <!-- Persentase dari initial balance -->
                            <div class="flex items-center">
                                @if ($equityChange > 0)
                                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                                    <span class="text-green-400">+{{ number_format($equityChange, 2) }}%
                                        {{ __('dashboard.from_initial') }}</span>
                                @elseif($equityChange < 0)
                                    <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i>
                                    <span class="text-red-400">{{ number_format($equityChange, 2) }}%
                                        {{ __('dashboard.from_initial') }}</span>
                                @else
                                    <i class="fas fa-minus text-gray-500 text-xs mr-1"></i>
                                    <span class="text-gray-400">0% {{ __('dashboard.change') }}</span>
                                @endif
                            </div>

                            <!-- Persentase dari balance saat ini (opsional) -->
                            @if ($vsBalanceChange != 0)
                                <div class="flex items-center mt-1">
                                    @if ($vsBalanceChange > 0)
                                        <i class="fas fa-arrow-up text-blue-400 text-xs mr-1"></i>
                                        <span class="text-blue-300">+{{ number_format($vsBalanceChange, 2) }}% vs
                                            balance</span>
                                    @else
                                        <i class="fas fa-arrow-down text-yellow-500 text-xs mr-1"></i>
                                        <span class="text-yellow-400">{{ number_format($vsBalanceChange, 2) }}% vs
                                            balance</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-blue-500 text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($equity_change_percentage > 0)
                        <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                        <span class="text-green-400">{{ __('dashboard.growing') }}</span>
                    @elseif($equity_change_percentage < 0)
                        <i class="fas fa-arrow-trend-down text-red-500 mr-1"></i>
                        <span class="text-red-400">{{ __('dashboard.declining') }}</span>
                    @else
                        <i class="fas fa-minus text-gray-500 mr-1"></i>
                        <span class="text-gray-400">{{ __('dashboard.stable') }}</span>
                    @endif
                </div>
            </div>

            <!-- Win Rate Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">{{ __('dashboard.win_rate') }}</p>
                        <h3 class="text-2xl font-bold mt-2">{{ $winrate }}%</h3>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <i class="fas fa-trophy text-green-500 text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-400">{{ __('dashboard.profitable') }}</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Period Filter -->
                <div>
                    <label for="period"
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('dashboard.period') }}</label>
                    <select name="period" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                        <option value="all" {{ $period === 'all' ? 'selected' : '' }}>{{ __('dashboard.all_time') }}
                        </option>
                        <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>
                            {{ __('dashboard.last_7_days') }}</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>
                            {{ __('dashboard.last_30_days') }}</option>
                    </select>
                </div>

                <!-- Session Filter -->
                <div>
                    <label for="session"
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('dashboard.session') }}</label>
                    <select name="session" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                        <option value="all" {{ $sessionFilter === 'all' ? 'selected' : '' }}>
                            {{ __('dashboard.all_sessions') }}</option>
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
                        class="block text-sm font-medium text-gray-300 mb-1">{{ __('dashboard.entry_type') }}</label>
                    <select name="entry_type" onchange="this.form.submit()"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                        <option value="all" {{ $entryFilter === 'all' ? 'selected' : '' }}>
                            {{ __('dashboard.all_types') }}</option>
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

        <!-- Equity Curve Chart -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-primary-300">{{ __('dashboard.equity_curve') }}</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ __('dashboard.equity_subtitle') }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="period" onchange="this.form.submit()"
                            class="bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>
                                {{ __('dashboard.all_time') }}</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>
                                {{ __('dashboard.last_7_days') }}</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>
                                {{ __('dashboard.last_30_days') }}</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Range Slider -->
            <div class="mb-4 bg-gray-700 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-medium text-gray-300">{{ __('dashboard.range') }}</label>
                    <div class="flex gap-2">
                        <span class="text-xs text-gray-400">{{ __('dashboard.from') }}: <span id="rangeStartLabel"
                                class="text-primary-400">-</span></span>
                        <span class="text-xs text-gray-400">{{ __('dashboard.to') }}: <span id="rangeEndLabel"
                                class="text-primary-400">-</span></span>
                        <button id="resetRange"
                            class="ml-2 px-3 py-1 text-xs bg-primary-500/20 text-primary-400 rounded hover:bg-primary-500/30 transition-colors">
                            {{ __('dashboard.reset') }}
                        </button>
                    </div>
                </div>
                <div class="flex gap-2">
                    <input type="range" id="rangeStart" min="0" max="100" value="0"
                        class="flex-1 h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-primary-500"
                        style="z-index: 5;">
                    <input type="range" id="rangeEnd" min="0" max="100" value="100"
                        class="flex-1 h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-primary-500"
                        style="z-index: 6;">
                </div>
            </div>

            <div class="h-64 lg:h-96">
                <canvas id="equityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Equity Chart with Range Slider
        const ctx = document.getElementById('equityChart').getContext('2d');
        const equityData = @json($equityData);
        let chartInstance = null;
        let allData = {};

        // Define colors for different sessions
        const sessionColors = {
            'Asia': {
                border: '#f97316',
                background: 'rgba(249, 115, 22, 0.1)'
            },
            'London': {
                border: '#3b82f6',
                background: 'rgba(59, 130, 246, 0.1)'
            },
            'New York': {
                border: '#10b981',
                background: 'rgba(16, 185, 129, 0.1)'
            },
            'Sydney': {
                border: '#8b5cf6',
                background: 'rgba(139, 92, 246, 0.1)'
            },
            'Non-Session': {
                border: '#6b7280',
                background: 'rgba(107, 114, 128, 0.1)'
            },
            'Other': {
                border: '#eab308',
                background: 'rgba(234, 179, 8, 0.1)'
            }
        };

        const defaultColors = {
            border: '#94a3b8',
            background: 'rgba(148, 163, 184, 0.1)'
        };

        // Store original data
        allData = JSON.parse(JSON.stringify(equityData));

        // Get range slider elements
        const rangeStart = document.getElementById('rangeStart');
        const rangeEnd = document.getElementById('rangeEnd');
        const rangeStartLabel = document.getElementById('rangeStartLabel');
        const rangeEndLabel = document.getElementById('rangeEndLabel');
        const resetRange = document.getElementById('resetRange');

        function updateRangeSliders() {
            let startVal = parseInt(rangeStart.value);
            let endVal = parseInt(rangeEnd.value);

            if (startVal > endVal) {
                [startVal, endVal] = [endVal, startVal];
                rangeStart.value = startVal;
                rangeEnd.value = endVal;
            }

            rangeStart.style.zIndex = startVal > 50 ? '6' : '5';
            rangeEnd.style.zIndex = endVal > 50 ? '5' : '6';
        }

        function getFilteredData() {
            const startPercent = parseInt(rangeStart.value);
            const endPercent = parseInt(rangeEnd.value);

            const availableSessions = Object.keys(allData);
            const filteredData = {};

            availableSessions.forEach(session => {
                const sessionData = allData[session] || [];
                const startIdx = Math.floor(sessionData.length * startPercent / 100);
                const endIdx = Math.ceil(sessionData.length * endPercent / 100);
                filteredData[session] = sessionData.slice(startIdx, endIdx);
            });

            return filteredData;
        }

        function updateChart() {
            const filteredData = getFilteredData();
            const availableSessions = Object.keys(filteredData);

            // Update labels
            if (availableSessions.length > 0 && filteredData[availableSessions[0]].length > 0) {
                const sessionData = filteredData[availableSessions[0]];
                rangeStartLabel.textContent = sessionData[0]?.date || '-';
                rangeEndLabel.textContent = sessionData[sessionData.length - 1]?.date || '-';
            }

            // Create new datasets with filtered data
            const datasets = [];
            availableSessions.forEach(session => {
                const sessionData = filteredData[session] || [];
                const colors = sessionColors[session] || defaultColors;

                datasets.push({
                    label: session,
                    data: sessionData.map(d => d.balance || 0),
                    borderColor: colors.border,
                    backgroundColor: colors.background,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 4
                });
            });

            // Update chart data
            if (chartInstance) {
                chartInstance.data.labels = availableSessions.length > 0 && filteredData[availableSessions[0]] ?
                    filteredData[availableSessions[0]].map(d => d.date) : [];
                chartInstance.data.datasets = datasets;
                chartInstance.update('none'); // Update without animation for smoother interaction
            }
        }

        // Event listeners
        rangeStart.addEventListener('input', function() {
            updateRangeSliders();
            updateChart();
        });

        rangeEnd.addEventListener('input', function() {
            updateRangeSliders();
            updateChart();
        });

        resetRange.addEventListener('click', function() {
            rangeStart.value = 0;
            rangeEnd.value = 100;
            updateRangeSliders();
            updateChart();
        });

        // Create chart if data exists
        const availableSessions = Object.keys(equityData);
        if (availableSessions.length > 0) {
            const datasets = [];

            availableSessions.forEach(session => {
                const sessionData = equityData[session] || [];
                const colors = sessionColors[session] || defaultColors;

                datasets.push({
                    label: session,
                    data: sessionData.map(d => d.balance || 0),
                    borderColor: colors.border,
                    backgroundColor: colors.background,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 4
                });
            });

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: availableSessions.length > 0 ? (equityData[availableSessions[0]] || []).map(d => d
                        .date) : [],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#9ca3af',
                                usePointStyle: true,
                                padding: 15
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
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
                                color: 'rgba(75, 85, 99, 0.3)'
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

            // Initialize range labels
            updateChart();
        } else {
            // Show message if no data
            document.getElementById('equityChart').parentElement.innerHTML = `
                <div class="flex flex-col items-center justify-center h-64 text-gray-500">
                    <i class="fas fa-chart-line text-3xl mb-3"></i>
                    <p class="text-base">No equity data available</p>
                    <p class="text-sm">Start trading to see your equity curve</p>
                </div>
            `;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Button (hanya di Balance)
            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const balanceText = document.getElementById('balanceText');
            const balanceValue = document.getElementById('balanceValue');
            const balanceIcon = document.getElementById('balanceIcon');

            // Equity elements
            const equityText = document.getElementById('equityText');
            const equityValue = document.getElementById('equityValue');

            // Load state from localStorage
            const isVisible = localStorage.getItem('balanceEquityVisible') === 'true';

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

                // Show Equity
                equityText.classList.add('hidden');
                equityValue.classList.remove('hidden');

                // Save state
                localStorage.setItem('balanceEquityVisible', 'true');

                // Update tooltip
                toggleBalanceBtn.title = "Hide Balance & Equity";
            }

            function hideValues() {
                // Hide Balance
                balanceText.classList.remove('hidden');
                balanceValue.classList.add('hidden');
                balanceIcon.classList.remove('fa-eye');
                balanceIcon.classList.add('fa-eye-slash');

                // Hide Equity
                equityText.classList.remove('hidden');
                equityValue.classList.add('hidden');

                // Save state
                localStorage.setItem('balanceEquityVisible', 'false');

                // Update tooltip
                toggleBalanceBtn.title = "Show Balance & Equity";
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
@endsection
