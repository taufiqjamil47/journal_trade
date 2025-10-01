<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Trade - Trading Journal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-dark-900 to-primary-900 font-sans text-gray-200 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Tambah Trade Baru</h1>
                    <p class="text-gray-400 mt-2">Step 1 - Masukkan detail entry trading Anda</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trades.index') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold shadow-lg">
                        1
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Entry Trade</span>
                </div>
                <div class="h-1 flex-1 bg-gray-700 mx-4">
                    <div class="h-1 bg-gray-500 w-0"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-400">Update Exit</span>
                </div>
                <div class="h-1 flex-1 bg-gray-700 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-400">Evaluasi</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-plus-circle text-primary-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Detail Entry Trade</h2>
                            <p class="text-gray-400 text-sm mt-1">Isi informasi trading dengan benar</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Symbol Selection -->
                        <div class="space-y-2">
                            <label for="symbol_id" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-chart-line mr-2 text-primary-500"></i>Symbol
                            </label>
                            <select name="symbol_id"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                                @foreach ($symbols as $symbol)
                                    <option value="{{ $symbol->id }}" class="bg-dark-800">{{ $symbol->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trade Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-exchange-alt mr-2 text-primary-500"></i>Type
                            </label>
                            <select name="type"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                required>
                                <option value="buy" class="bg-dark-800">Buy</option>
                                <option value="sell" class="bg-dark-800">Sell</option>
                            </select>
                        </div>

                        <!-- Timestamp -->
                        <div class="space-y-2">
                            <label for="timestamp" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-clock mr-2 text-primary-500"></i>Timestamp
                            </label>
                            <input type="datetime-local" name="timestamp"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                required>
                        </div>

                        <!-- Date -->
                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-calendar mr-2 text-primary-500"></i>Date
                            </label>
                            <input type="date" name="date"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                required>
                        </div>

                        <!-- Entry Price -->
                        <div class="space-y-2">
                            <label for="entry" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-sign-in-alt mr-2 text-primary-500"></i>Entry Price
                            </label>
                            <input type="number" step="0.00001" name="entry"
                                class="w-full bg-dark-800 border border-gray-700 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                placeholder="0.00000" required>
                        </div>

                        <!-- Stop Loss -->
                        <div class="space-y-2">
                            <label for="stop_loss" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-hand-paper mr-2 text-red-500"></i>Stop Loss
                            </label>
                            <input type="number" step="0.00001" name="stop_loss"
                                class="w-full bg-dark-800 border border-red-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                placeholder="0.00000" required>
                            <!-- HIDDEN INPUT UNTUK RR RATIO - TAMBAHKAN INI -->
                            <input type="hidden" name="rr_ratio" id="rr_ratio" value="0">
                        </div>


                        <!-- Take Profit -->
                        <div class="space-y-2">
                            <label for="take_profit" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-trophy mr-2 text-green-500"></i>Take Profit
                            </label>
                            <input type="number" step="0.00001" name="take_profit"
                                class="w-full bg-dark-800 border border-green-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                placeholder="0.00000" required>
                        </div>

                        <!-- Risk Calculator -->
                        <div class="md:col-span-2 bg-dark-800/50 rounded-xl p-4 border border-gray-700/50">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-calculator mr-2 text-amber-500"></i>Risk Calculator
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-dark-700/30 rounded-lg">
                                    <p class="text-gray-400">Risk/Reward Ratio</p>
                                    <p class="text-lg font-semibold text-amber-400" id="riskRewardRatio">-</p>
                                </div>
                                <div class="text-center p-3 bg-dark-700/30 rounded-lg">
                                    <p class="text-gray-400">SL Distance (Pips)</p>
                                    <p class="text-lg font-semibold text-red-400" id="slPips">-</p>
                                </div>
                                <div class="text-center p-3 bg-dark-700/30 rounded-lg">
                                    <p class="text-gray-400">TP Distance (Pips)</p>
                                    <p class="text-lg font-semibold text-green-400" id="tpPips">-</p>
                                </div>
                                <div class="text-center p-3 bg-dark-700/30 rounded-lg">
                                    <p class="text-gray-400">Position Size</p>
                                    <p class="text-lg font-semibold text-cyan-400" id="positionSize">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-700/50 space-y-4 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Trade
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div
                class="mt-6 bg-gradient-to-br from-amber-900/20 to-amber-800/10 backdrop-blur-sm rounded-2xl p-6 border border-amber-700/30">
                <div class="flex items-start">
                    <div class="bg-amber-500/20 p-3 rounded-xl mr-4">
                        <i class="fas fa-lightbulb text-amber-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-amber-300">Tips Trading</h3>
                        <ul class="mt-2 space-y-2 text-amber-100/80 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Pastikan risk/reward ratio minimal 1:1.5 untuk trading yang sehat
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Gunakan stop loss yang sesuai dengan risk management Anda
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Catat semua detail trading untuk analisis di masa depan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Risk Calculator
        function calculateRisk() {
            const entry = parseFloat(document.querySelector('input[name="entry"]').value) || 0;
            const stopLoss = parseFloat(document.querySelector('input[name="stop_loss"]').value) || 0;
            const takeProfit = parseFloat(document.querySelector('input[name="take_profit"]').value) || 0;
            const type = document.querySelector('select[name="type"]').value;

            if (entry && stopLoss && takeProfit) {
                let slDistance, tpDistance;

                // Hitung distance dalam price
                if (type === 'buy') {
                    slDistance = entry - stopLoss;
                    tpDistance = takeProfit - entry;
                } else {
                    slDistance = stopLoss - entry;
                    tpDistance = entry - takeProfit;
                }

                // Hitung pips (asumsi untuk forex pairs)
                // Untuk pairs dengan 5 decimal places, 1 pip = 0.00010
                // Untuk pairs dengan 3 decimal places (seperti USD/JPY), 1 pip = 0.010
                const pipValue = 0.00010; // Default untuk EUR/USD, GBP/USD, dll

                const slPips = Math.abs(slDistance) / pipValue;
                const tpPips = Math.abs(tpDistance) / pipValue;

                // Update SL & TP Pips display
                document.getElementById('slPips').textContent = `${slPips.toFixed(1)} pips`;
                document.getElementById('tpPips').textContent = `${tpPips.toFixed(1)} pips`;

                // Calculate Risk/Reward Ratio
                const ratio = slPips > 0 ? (tpPips / slPips) : 0;
                document.getElementById('riskRewardRatio').textContent = ratio > 0 ? `1:${ratio.toFixed(2)}` : '-';
                document.getElementById('rr_ratio').value = ratio.toFixed(2);

                // Calculate Position Size (Lot Size) berdasarkan risk management
                calculatePositionSize(slPips);

            } else {
                // Reset jika data tidak lengkap
                resetRiskCalculator();
            }
        }

        // Function untuk menghitung position size (lot size)
        function calculatePositionSize(slPips) {
            // Asumsi:
            const accountBalance = 1000; // Balance akun dalam USD (bisa disesuaikan)
            const riskPercent = 2; // Risk 2% per trade (bisa disesuaikan)
            const pipWorth = 10; // $10 per pip per 1 lot (standard lot)

            if (slPips > 0) {
                const riskUSD = accountBalance * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);

                // Tampilkan position size
                document.getElementById('positionSize').textContent = `${lotSize.toFixed(2)} lots`;
            } else {
                document.getElementById('positionSize').textContent = '-';
            }
        }

        // Function untuk reset calculator
        function resetRiskCalculator() {
            document.getElementById('riskRewardRatio').textContent = '-';
            document.getElementById('slPips').textContent = '-';
            document.getElementById('tpPips').textContent = '-';
            document.getElementById('positionSize').textContent = '-';
            document.getElementById('rr_ratio').value = '0';
        }

        // Add event listeners for real-time calculation
        document.querySelector('input[name="entry"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="stop_loss"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="take_profit"]').addEventListener('input', calculateRisk);
        document.querySelector('select[name="type"]').addEventListener('change', calculateRisk);

        // Set current datetime as default for timestamp
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const timestamp = now.toISOString().slice(0, 16);
            document.querySelector('input[name="timestamp"]').value = timestamp;

            const today = now.toISOString().slice(0, 10);
            document.querySelector('input[name="date"]').value = today;

            // Trigger initial calculation jika ada nilai
            calculateRisk();
        });
    </script>
</body>

</html>
