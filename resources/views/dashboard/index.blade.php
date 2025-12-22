@extends('Layouts.index')
@section('title', 'Dashboard')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Trading Dashboard
                    </h1>
                    <p class="text-gray-500 mt-1">Pantau kinerja dan analitik perdagangan Anda</p>
                </div>

                <!-- Navigation and Trader Info -->
                <div class="flex flex-wrap gap-3">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2"></i>
                    </button>

                    <!-- Navigation Items (hidden by default) -->
                    <div id="navItems" class="hidden">
                        <div class="flex items-center space-x-1 bg-gray-800 rounded-lg p-1 border border-gray-700">
                            <!-- Dashboard Link -->
                            @if (!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                                    title="Dashboard">
                                    <i class="fas fa-home text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Trade Dashboard
                                    </span>
                                </a>
                            @endif

                            <!-- Calendar Link - hanya tampil jika BUKAN di route calendar -->
                            @if (!request()->routeIs('reports.calendar'))
                                <a href="{{ route('reports.calendar') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Calendar">
                                    <i class="fas fa-calendar text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        PnL Calendar
                                    </span>
                                </a>
                            @endif

                            <!-- Analysis Link - hanya tampil jika BUKAN di route analysis -->
                            @if (!request()->routeIs('analysis.*'))
                                <a href="{{ route('analysis.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Analysis">
                                    <i class="fa-solid fa-magnifying-glass-chart text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Trade Analysis
                                    </span>
                                </a>
                            @endif

                            <div class="h-6 w-px bg-gray-600"></div>

                            <!-- Trades Link - hanya tampil jika BUKAN di route trades -->
                            @if (!request()->routeIs('trades.*'))
                                <a href="{{ route('trades.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Trades">
                                    <i class="fas fa-chart-line text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Journal Trades
                                    </span>
                                </a>
                            @endif

                            <!-- Sessions Link - hanya tampil jika BUKAN di route sessions -->
                            @if (!request()->routeIs('sessions.*'))
                                <a href="{{ route('sessions.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Sessions">
                                    <i class="fas fa-clock text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Sessions
                                    </span>
                                </a>
                            @endif

                            <!-- Symbols Link - hanya tampil jika BUKAN di route symbols -->
                            @if (!request()->routeIs('symbols.*'))
                                <a href="{{ route('symbols.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Symbols">
                                    <i class="fas fa-money-bill-transfer text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Symbols
                                    </span>
                                </a>
                            @endif

                            <!-- Rules Link - hanya tampil jika BUKAN di route trading-rules -->
                            @if (!request()->routeIs('trading-rules.*'))
                                <a href="{{ route('trading-rules.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Rules">
                                    <i class="fas fa-list text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        Rules
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trader Item -->
                    <div class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
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
                        <p class="text-gray-400 text-sm">Balance</p>
                        <div class="flex items-center gap-2">
                            <h3 id="balanceText" class="text-2xl font-bold mt-2">******</h3>
                            <h3 id="balanceValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($balance, 2) }}
                            </h3>
                            <button id="toggleBalance"
                                class="mt-2 px-2 rounded-lg hover:bg-primary-500/30 transition-colors"
                                title="Show/Hide Balance & Equity">
                                <i id="balanceIcon" class="fas fa-eye-slash text-primary-500 text-lg"></i>
                            </button>
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
                    <span class="text-green-400">Active</span>
                </div>
            </div>

            <!-- Equity Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">Equity</p>
                        <h3 id="equityText" class="text-2xl font-bold mt-2">******</h3>
                        <h3 id="equityValue" class="text-2xl font-bold mt-2 hidden">${{ number_format($equity, 2) }}</h3>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-blue-500 text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-400">Growing</span>
                </div>
            </div>

            <!-- Win Rate Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm">Win Rate</p>
                        <h3 class="text-2xl font-bold mt-2">{{ $winrate }}%</h3>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <i class="fas fa-trophy text-green-500 text-lg"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-400">Profitable</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            <option value="{{ $sessionName }}" {{ $sessionFilter === $sessionName ? 'selected' : '' }}>
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

        <!-- Equity Curve Chart -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-primary-300">Equity Curve per Session</h2>
                    <p class="text-gray-500 text-sm mt-1">Performa di berbagai sesi perdagangan</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="period" onchange="this.form.submit()"
                            class="bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 30 Days</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="h-64">
                <canvas id="equityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Equity Chart
        const ctx = document.getElementById('equityChart').getContext('2d');
        const equityData = @json($equityData);

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

        // Create datasets dynamically
        const datasets = [];
        const availableSessions = Object.keys(equityData);

        if (availableSessions.length > 0) {
            const firstSession = availableSessions[0];
            const dates = equityData[firstSession] ? equityData[firstSession].map(d => d.date) : [];

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
        }

        // Create chart if data exists
        if (datasets.length > 0) {
            new Chart(ctx, {
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
