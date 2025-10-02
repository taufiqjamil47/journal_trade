@extends('Layouts.index')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Trading Dashboard</h1>
                    <p class="text-gray-400 mt-2">Monitor your trading performance and analytics</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trades.index') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Trades</span>
                    </a>
                    <a href="{{ route('sessions.index') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-clock text-primary-500 mr-2"></i>
                        <span>Sessions</span>
                    </a>
                    <div class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Balance</p>
                        <h3 class="text-2xl font-bold mt-2">${{ number_format($balance, 2) }}</h3>
                    </div>
                    <div class="bg-primary-500/20 p-3 rounded-xl">
                        <i class="fas fa-wallet text-primary-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-500">Active</span>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Equity</p>
                        <h3 class="text-2xl font-bold mt-2">${{ number_format($equity, 2) }}</h3>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-xl">
                        <i class="fas fa-chart-line text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-500">Growing</span>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Win Rate</p>
                        <h3 class="text-2xl font-bold mt-2">{{ $winrate }}%</h3>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-xl">
                        <i class="fas fa-trophy text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <i class="fas fa-arrow-trend-up text-green-500 mr-1"></i>
                    <span class="text-green-500">Profitable</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-4 md:space-y-0">
                <div class="flex-1">
                    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="period" class="block text-sm font-medium text-gray-300 mb-1">Period</label>
                            <select name="period" onchange="this.form.submit()"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 30 Days
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="session" class="block text-sm font-medium text-gray-300 mb-1">Session</label>
                            <select name="session" onchange="this.form.submit()"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="all" {{ $sessionFilter === 'all' ? 'selected' : '' }}>All Sessions
                                </option>
                                @foreach ($availableSessions as $sessionName)
                                    <option value="{{ $sessionName }}"
                                        {{ $sessionFilter === $sessionName ? 'selected' : '' }}>
                                        {{ $sessionName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="entry_type" class="block text-sm font-medium text-gray-300 mb-1">Entry
                                Type</label>
                            <select name="entry_type" onchange="this.form.submit()"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="all" {{ $entryFilter === 'all' ? 'selected' : '' }}>All Types
                                </option>
                                <option value="OB" {{ $entryFilter === 'OB' ? 'selected' : '' }}>Order Block (OB)
                                </option>
                                <option value="FVG" {{ $entryFilter === 'FVG' ? 'selected' : '' }}>FVG</option>
                                <option value="Liquidity Sweep" {{ $entryFilter === 'Liquidity Sweep' ? 'selected' : '' }}>
                                    Liquidity Sweep</option>
                                <option value="Breaker Block" {{ $entryFilter === 'Breaker Block' ? 'selected' : '' }}>
                                    Breaker Block</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($summary)
            <!-- Summary Alert -->
            <div
                class="bg-gradient-to-r from-primary-900/30 to-blue-900/30 backdrop-blur-sm rounded-2xl p-5 border border-primary-700/30 shadow-lg mb-8">
                <div class="flex items-center">
                    <div class="bg-primary-500/20 p-3 rounded-xl mr-4">
                        <i class="fas fa-chart-pie text-primary-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">{{ $summary['entry_type'] }} <span
                                class="text-gray-400 font-normal">({{ $summary['session'] }})</span></h3>
                        <p class="text-gray-300 mt-1">
                            {{ $summary['trades'] }} trades ·
                            Winrate: <span class="font-semibold">{{ $summary['winrate'] }}%</span> ·
                            <span class="{{ $summary['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-bold">
                                ${{ number_format($summary['profit_loss'], 2) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Equity Curve Chart -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold">Equity Curve per Session</h2>
                    <p class="text-gray-400 text-sm mt-1">Performance across different trading sessions</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="period" id="period" onchange="this.form.submit()"
                            class="bg-dark-800 border border-gray-700 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 30 Days
                            </option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="h-80">
                <canvas id="equityChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Profit/Loss per Symbol -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold">Profit/Loss per Symbol</h2>
                        <p class="text-gray-400 text-sm mt-1">Performance by trading pair</p>
                    </div>
                    <div class="bg-blue-500/20 p-2 rounded-lg">
                        <i class="fas fa-coins text-blue-500"></i>
                    </div>
                </div>
                <div class="h-64 mb-6">
                    <canvas id="pairChart"></canvas>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-3 text-gray-400 font-medium">Symbol</th>
                                <th class="text-right py-3 text-gray-400 font-medium">Total P/L ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pairData as $symbol => $pl)
                                <tr class="border-b border-gray-800/50">
                                    <td class="py-3">{{ $symbol }}</td>
                                    <td
                                        class="py-3 text-right font-medium {{ $pl >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($pl, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Performance per Entry Type -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold">Performance per Entry Type</h2>
                        <p class="text-gray-400 text-sm mt-1">Strategy effectiveness analysis</p>
                    </div>
                    <div class="bg-green-500/20 p-2 rounded-lg">
                        <i class="fas fa-chart-bar text-green-500"></i>
                    </div>
                </div>
                <div class="h-64 mb-6">
                    <canvas id="entryTypeChart"></canvas>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-3 text-gray-400 font-medium">Entry Type</th>
                                <th class="text-center py-3 text-gray-400 font-medium">Trades</th>
                                <th class="text-center py-3 text-gray-400 font-medium">Winrate</th>
                                <th class="text-right py-3 text-gray-400 font-medium">Profit/Loss ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entryTypeData as $type => $data)
                                <tr class="border-b border-gray-800/50">
                                    <td class="py-3">{{ $type ?? 'N/A' }}</td>
                                    <td class="py-3 text-center">{{ $data['trades'] }}</td>
                                    <td class="py-3 text-center">{{ $data['winrate'] }}%</td>
                                    <td
                                        class="py-3 text-right font-medium {{ $data['profit_loss'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
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

    <script>
        // Equity Chart - Dynamic session handling
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

        // Default color for unknown sessions
        const defaultColors = {
            border: '#94a3b8',
            background: 'rgba(148, 163, 184, 0.1)'
        };

        // Create datasets dynamically based on available sessions
        const datasets = [];
        const availableSessions = Object.keys(equityData);

        if (availableSessions.length > 0) {
            // Use the first session to get dates
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

        // Create the chart only if we have data
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
                                color: '#e2e8f0',
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            titleColor: '#e2e8f0',
                            bodyColor: '#e2e8f0',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });
        } else {
            // Show message if no data
            document.getElementById('equityChart').parentElement.innerHTML = `
                <div class="flex flex-col items-center justify-center h-80 text-gray-400">
                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                    <p class="text-lg">No equity data available</p>
                    <p class="text-sm">Start trading to see your equity curve</p>
                </div>
            `;
        }

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
                        backgroundColor: pairValues.map(v => v >= 0 ?
                            'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'),
                        borderColor: pairValues.map(v => v >= 0 ?
                            'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'),
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
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            titleColor: '#e2e8f0',
                            bodyColor: '#e2e8f0',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#94a3b8'
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
                        backgroundColor: entryValues.map(v => v >= 0 ?
                            'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)'),
                        borderColor: entryValues.map(v => v >= 0 ?
                            'rgba(16, 185, 129, 1)' : 'rgba(239, 68, 68, 1)'),
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
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            titleColor: '#e2e8f0',
                            bodyColor: '#e2e8f0',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
