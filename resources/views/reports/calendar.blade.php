@extends('Layouts.index')
@section('title', 'PnL Calender')
@section('content')
    <div class="container mx-auto p-4">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Calendar Report
                    </h1>
                    <p class="text-gray-300 mt-2">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-dark-800/70 backdrop-blur-sm rounded-lg p-3 border border-gray-600 hover:border-primary-500/70 hover:shadow-lg hover:shadow-primary-500/20 transition-all duration-300 group">
                        <i class="fas fa-home text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-dark-800/70 backdrop-blur-sm rounded-lg p-3 border border-gray-600 hover:border-primary-500/70 hover:shadow-lg hover:shadow-primary-500/20 transition-all duration-300 group">
                        <i class="fas fa-chart-line text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Trades</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Month/Year Navigation -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-600/30 shadow-xl mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex space-x-2">
                    <a href="{{ route('reports.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                        class="flex items-center bg-dark-800/70 backdrop-blur-sm rounded-xl p-3 border border-gray-600 hover:border-primary-500/70 hover:shadow-lg hover:shadow-primary-500/20 transition-all duration-300 group">
                        <i class="fas fa-chevron-left text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Previous Month</span>
                    </a>
                    <a href="{{ route('reports.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                        class="flex items-center bg-dark-800/70 backdrop-blur-sm rounded-xl p-3 border border-gray-600 hover:border-primary-500/70 hover:shadow-lg hover:shadow-primary-500/20 transition-all duration-300 group">
                        <span>Next Month</span>
                        <i
                            class="fas fa-chevron-right text-primary-500 ml-2 group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>

                <!-- Month/Year Selector -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <label for="monthSelect" class="text-gray-300">Month:</label>
                        <select id="monthSelect"
                            class="bg-dark-700 border border-gray-600 rounded-lg p-2 text-black focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <label for="yearSelect" class="text-gray-300">Year:</label>
                        <select id="yearSelect"
                            class="bg-dark-700 border border-gray-600 rounded-lg p-2 text-black focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button id="goToDate"
                        class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-4 py-2 transition-colors duration-300">
                        Go
                    </button>

                    <a href="{{ route('reports.calendar', ['month' => date('m'), 'year' => date('Y')]) }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white rounded-lg px-4 py-2 transition-colors duration-300">
                        Today
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-600/30 shadow-xl mb-8">
            <h3 class="text-xl font-bold mb-4 text-gray-200">Monthly Calendar</h3>

            <!-- Day headers -->
            <div class="grid grid-cols-7 gap-2 mb-2">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="text-center font-medium text-gray-300 py-2 bg-dark-700/50 rounded-lg">{{ $day }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar days -->
            <div class="grid grid-cols-7 gap-2">
                @foreach ($period as $day)
                    @php
                        $date = $day->format('Y-m-d');
                        $info = $daily[$date] ?? null;
                        $profit = $info->total_profit ?? 0;
                        $dayTrades = $trades[$date] ?? collect();
                        $isCurrentMonth = $day->month == $month;
                        $opacityClass = $isCurrentMonth ? 'opacity-100' : 'opacity-40';
                        $isToday = $date == date('Y-m-d');

                        // Determine colors based on profit
                        if ($profit > 0) {
                            $bgColor = 'bg-green-500/20';
                            $borderColor = 'border-green-500/40';
                            $textColor = 'text-green-400';
                        } elseif ($profit < 0) {
                            $bgColor = 'bg-red-500/20';
                            $borderColor = 'border-red-500/40';
                            $textColor = 'text-red-400';
                        } else {
                            $bgColor = 'bg-gray-700/30';
                            $borderColor = 'border-gray-600/30';
                            $textColor = 'text-gray-400';
                        }

                        // Today's date highlight
if ($isToday) {
    $borderColor = 'border-primary-500/70';
    $bgColor = $bgColor . ' bg-primary-500/10';
                        }
                    @endphp

                    <div class="p-2 rounded-xl border {{ $borderColor }} {{ $bgColor }} {{ $opacityClass }} cursor-pointer day-cell transition-all duration-300 hover:scale-105 hover:shadow-lg"
                        data-date="{{ $date }}" data-trades='@json($dayTrades)'
                        data-profit="{{ $profit }}">
                        <div class="flex justify-between items-start">
                            <strong
                                class="text-sm {{ $isToday ? 'text-primary-400' : 'text-gray-200' }}">{{ $day->format('d') }}</strong>
                            @if (count($dayTrades) > 0)
                                <span class="text-xs bg-primary-500/30 text-primary-300 rounded-full px-1.5 py-0.5">
                                    {{ count($dayTrades) }}
                                </span>
                            @endif
                        </div>
                        <div class="mt-1 text-xs {{ $textColor }} font-medium">
                            ${{ number_format($profit, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Weekly Summary -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-600/30 shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-200">📅 Weekly Summary</h3>
                    <div class="bg-blue-500/30 p-2 rounded-lg">
                        <i class="fas fa-calendar-week text-blue-400"></i>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left py-3 text-gray-300 font-medium">Week</th>
                                <th class="text-center py-3 text-gray-300 font-medium">Total Trades</th>
                                <th class="text-right py-3 text-gray-300 font-medium">Total Profit/Loss ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weekly as $w)
                                @php
                                    $color =
                                        $w->total_profit > 0
                                            ? 'text-green-400'
                                            : ($w->total_profit < 0
                                                ? 'text-red-400'
                                                : 'text-gray-400');
                                @endphp
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/20 transition-colors">
                                    <td class="py-3 text-gray-300">Week {{ $w->week }}</td>
                                    <td class="py-3 text-center text-gray-300">{{ $w->total_trades }}</td>
                                    <td class="py-3 text-right font-medium {{ $color }}">
                                        ${{ number_format($w->total_profit, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-600/30 shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-200">📈 Monthly Summary ({{ $year }})</h3>
                    <div class="bg-green-500/30 p-2 rounded-lg">
                        <i class="fas fa-chart-line text-green-400"></i>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <div class="scroll-container h-[25rem] px-5" style="overflow-y: auto;">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="text-left py-3 text-gray-300 font-medium">Month</th>
                                    <th class="text-center py-3 text-gray-300 font-medium">Total Trades</th>
                                    <th class="text-right py-3 text-gray-300 font-medium">Total Profit/Loss ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthly as $m)
                                    @php
                                        $monthName = \Carbon\Carbon::create()->month($m->month)->format('F');
                                        $color =
                                            $m->total_profit > 0
                                                ? 'text-green-400'
                                                : ($m->total_profit < 0
                                                    ? 'text-red-400'
                                                    : 'text-gray-400');
                                        $isCurrentMonth = $m->month == $month && $m->year == $year;
                                        $rowClass = $isCurrentMonth ? 'bg-primary-500/10' : '';
                                    @endphp
                                    <tr
                                        class="border-b border-gray-700/50 hover:bg-gray-700/20 transition-colors {{ $rowClass }}">
                                        <td class="py-3 text-gray-300">{{ $monthName }}</td>
                                        <td class="py-3 text-center text-gray-300">{{ $m->total_trades }}</td>
                                        <td class="py-3 text-right font-medium {{ $color }}">
                                            ${{ number_format($m->total_profit, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trade Details Modal -->
    <div id="tradeModal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
        <div class="bg-gradient-to-br from-dark-800 to-dark-800/90 border border-gray-600/50 rounded-2xl w-full max-w-md mx-auto shadow-2xl transform transition-transform duration-300 scale-95"
            id="modalContentContainer">
            <div class="flex justify-between items-center p-6 border-b border-gray-600/50">
                <h4 id="modalTitle" class="text-xl font-bold text-gray-200">📅 Trade Details</h4>
                <button id="closeModal" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="modalContent" class="p-6 max-h-[70vh] overflow-y-auto">
                <!-- Content will be filled by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('tradeModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const modalContentContainer = document.getElementById('modalContentContainer');
            const closeModalBtn = document.getElementById('closeModal');
            const monthSelect = document.getElementById('monthSelect');
            const yearSelect = document.getElementById('yearSelect');
            const goToDateBtn = document.getElementById('goToDate');

            // Navigate to selected month/year
            goToDateBtn.addEventListener('click', function() {
                const month = monthSelect.value;
                const year = yearSelect.value;
                window.location.href = `{{ route('reports.calendar') }}?month=${month}&year=${year}`;
            });

            // Event listener untuk setiap sel hari
            document.querySelectorAll('.day-cell').forEach(cell => {
                cell.addEventListener('click', function() {
                    const date = this.getAttribute('data-date');
                    const trades = JSON.parse(this.getAttribute('data-trades'));
                    const profit = parseFloat(this.getAttribute('data-profit'));

                    // Format tanggal untuk judul modal
                    const dateObj = new Date(date);
                    const options = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };
                    const formattedDate = dateObj.toLocaleDateString('en-US', options);

                    // Set judul modal
                    modalTitle.textContent = `📅 ${formattedDate}`;

                    // Buat konten modal
                    let content = '';

                    if (trades.length > 0) {
                        let totalProfit = 0;
                        let winningTrades = 0;
                        let losingTrades = 0;

                        trades.forEach(trade => {
                            totalProfit += parseFloat(trade.profit_loss);
                            if (trade.profit_loss > 0) winningTrades++;
                            else if (trade.profit_loss < 0) losingTrades++;
                        });

                        content += `
                        <div class="mb-6 p-4 rounded-xl ${profit > 0 ? 'bg-green-500/10 border border-green-500/30' : 'bg-red-500/10 border border-red-500/30'}">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-medium text-gray-300">Total Profit/Loss:</p>
                                <span class="${profit > 0 ? 'text-green-400' : 'text-red-400'} font-bold">$${profit.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-400">
                                <span>Winning: <span class="text-green-400">${winningTrades}</span></span>
                                <span>Losing: <span class="text-red-400">${losingTrades}</span></span>
                                <span>Total: <span class="text-gray-300">${trades.length}</span></span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-600">
                                        <th class="text-left py-3 text-gray-300 font-medium">Symbol</th>
                                        <th class="text-left py-3 text-gray-300 font-medium">Type</th>
                                        <th class="text-right py-3 text-gray-300 font-medium">P/L ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        trades.forEach(trade => {
                            content += `
                            <tr class="border-b border-gray-700/50 hover:bg-gray-700/20 transition-colors">
                                <td class="py-3 text-gray-300">${trade.symbol_name}</td>
                                <td class="py-3"><span class="px-2 py-1 rounded text-xs ${trade.type === 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'}">${trade.type.toUpperCase()}</span></td>
                                <td class="py-3 text-right font-medium ${trade.profit_loss > 0 ? 'text-green-400' : 'text-red-400'}">
                                    $${parseFloat(trade.profit_loss).toFixed(2)}
                                </td>
                            </tr>
                        `;
                        });

                        content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    } else {
                        content = `
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                            <i class="fas fa-chart-bar text-4xl mb-4 opacity-50"></i>
                            <p class="text-lg text-gray-300">No trades for this day</p>
                            <p class="text-sm mt-1">Start trading to see your performance</p>
                        </div>
                    `;
                    }

                    modalContent.innerHTML = content;
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContentContainer.classList.remove('scale-95');
                        modalContentContainer.classList.add('scale-100');
                    }, 10);
                    document.body.style.overflow = 'hidden';
                });
            });

            // Event listener untuk tombol tutup modal
            closeModalBtn.addEventListener('click', function() {
                modalContentContainer.classList.remove('scale-100');
                modalContentContainer.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            });

            // Tutup modal ketika klik di luar konten modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modalContentContainer.classList.remove('scale-100');
                    modalContentContainer.classList.add('scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                    document.body.style.overflow = 'auto';
                }
            });

            // Tutup modal dengan tombol Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    modalContentContainer.classList.remove('scale-100');
                    modalContentContainer.classList.add('scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.8);
        }

        /* Custom scrollbar styling */
        .scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-container::-webkit-scrollbar-track {
            background: rgba(75, 85, 99, 0.2);
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.5);
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.7);
        }

        /* Smooth transitions */
        .day-cell {
            transition: all 0.3s ease;
        }

        #modalContentContainer {
            transition: transform 0.3s ease;
        }
    </style>
@endsection
