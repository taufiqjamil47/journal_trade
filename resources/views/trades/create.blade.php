@extends('Layouts.index')
@section('content')
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

                        <!-- Updated Risk Calculator dengan Design Lebih Menarik -->
                        <div
                            class="md:col-span-2 bg-gradient-to-br from-dark-800 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30 shadow-lg">
                            <!-- Header dengan Icon Animasi -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="bg-amber-500/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-calculator text-amber-400 text-xl"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-amber-300">Smart Risk Calculator</h3>
                                        <p class="text-amber-200/70 text-sm mt-1">Live calculation based on current
                                            equity</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-amber-400">$<span
                                            id="currentEquity">{{ number_format($currentEquity, 2) }}</span></div>
                                    <div class="text-xs text-amber-300/70">Current Equity</div>
                                </div>
                            </div>

                            <!-- Risk Metrics Grid -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <!-- Risk/Reward Card -->
                                <div
                                    class="bg-gradient-to-br from-amber-900/30 to-amber-800/20 rounded-xl p-4 border border-amber-600/30 group hover:border-amber-500/50 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-amber-500/20 p-2 rounded-lg">
                                            <i class="fas fa-balance-scale text-amber-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-amber-400 text-xs font-semibold bg-amber-500/10 px-2 py-1 rounded-full">
                                            R:R</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Risk/Reward Ratio</p>
                                    <p class="text-2xl font-bold text-amber-300" id="riskRewardRatio">-</p>
                                    <div class="h-1 bg-amber-500/20 rounded-full mt-2">
                                        <div id="ratioBar"
                                            class="h-1 bg-amber-400 rounded-full transition-all duration-500"
                                            style="width: 0%"></div>
                                    </div>
                                </div>

                                <!-- SL Distance Card -->
                                <div
                                    class="bg-gradient-to-br from-red-900/30 to-red-800/20 rounded-xl p-4 border border-red-600/30 group hover:border-red-500/50 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-red-500/20 p-2 rounded-lg">
                                            <i class="fas fa-hand-paper text-red-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-red-400 text-xs font-semibold bg-red-500/10 px-2 py-1 rounded-full">
                                            SL</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Stop Loss Distance</p>
                                    <p class="text-2xl font-bold text-red-300" id="slPips">-</p>
                                    <p class="text-xs text-red-400/70 mt-1">pips</p>
                                </div>

                                <!-- TP Distance Card -->
                                <div
                                    class="bg-gradient-to-br from-green-900/30 to-green-800/20 rounded-xl p-4 border border-green-600/30 group hover:border-green-500/50 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-green-500/20 p-2 rounded-lg">
                                            <i class="fas fa-trophy text-green-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-green-400 text-xs font-semibold bg-green-500/10 px-2 py-1 rounded-full">
                                            TP</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Take Profit Distance</p>
                                    <p class="text-2xl font-bold text-green-300" id="tpPips">-</p>
                                    <p class="text-xs text-green-400/70 mt-1">pips</p>
                                </div>

                                <!-- Lot Size Card -->
                                <div
                                    class="bg-gradient-to-br from-cyan-900/30 to-cyan-800/20 rounded-xl p-4 border border-cyan-600/30 group hover:border-cyan-500/50 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-cyan-500/20 p-2 rounded-lg">
                                            <i class="fas fa-weight-scale text-cyan-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-cyan-400 text-xs font-semibold bg-cyan-500/10 px-2 py-1 rounded-full">
                                            LOT</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Recommended Lot Size</p>
                                    <p class="text-2xl font-bold text-cyan-300" id="positionSize">-</p>
                                    <p class="text-xs text-cyan-400/70 mt-1" id="riskAmountDisplay">-</p>
                                </div>
                            </div>

                            <!-- Risk Level Selector -->
                            <div class="bg-dark-800/50 rounded-xl p-4 border border-gray-700/50">
                                <h4 class="text-sm font-semibold text-amber-300 mb-3 flex items-center">
                                    <i class="fas fa-sliders-h mr-2 text-amber-400"></i>
                                    Risk Management Level
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <!-- Conservative -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="1"
                                            class="risk-percent-radio hidden" checked>
                                        <div class="risk-level-content bg-green-900/20 border-2 border-green-600/30">
                                            <div class="text-center">
                                                <div class="text-green-400 text-lg font-bold">1%</div>
                                                <div class="text-green-300 text-xs mt-1">Conservative</div>
                                                <div class="text-green-400/60 text-xs mt-2">Safe</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Moderate -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="2"
                                            class="risk-percent-radio hidden">
                                        <div class="risk-level-content bg-blue-900/20 border-2 border-blue-600/30">
                                            <div class="text-center">
                                                <div class="text-blue-400 text-lg font-bold">2%</div>
                                                <div class="text-blue-300 text-xs mt-1">Moderate</div>
                                                <div class="text-blue-400/60 text-xs mt-2">Balanced</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Aggressive -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="3"
                                            class="risk-percent-radio hidden">
                                        <div class="risk-level-content bg-orange-900/20 border-2 border-orange-600/30">
                                            <div class="text-center">
                                                <div class="text-orange-400 text-lg font-bold">3%</div>
                                                <div class="text-orange-300 text-xs mt-1">Aggressive</div>
                                                <div class="text-orange-400/60 text-xs mt-2">Growth</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- High Risk -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="5"
                                            class="risk-percent-radio hidden">
                                        <div class="risk-level-content bg-red-900/20 border-2 border-red-600/30">
                                            <div class="text-center">
                                                <div class="text-red-400 text-lg font-bold">5%</div>
                                                <div class="text-red-300 text-xs mt-1">High Risk</div>
                                                <div class="text-red-400/60 text-xs mt-2">Expert</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Quick Status Bar -->
                            <div class="mt-4 bg-dark-800/30 rounded-lg p-3 border border-gray-600/30">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-info-circle mr-2 text-amber-400"></i>
                                        <span>Risk management aktif berdasarkan equity real-time</span>
                                    </div>
                                    <div id="calculationStatus" class="text-amber-400 font-semibold">
                                        <i class="fas fa-sync-alt animate-spin mr-1"></i>
                                        Ready
                                    </div>
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
                        <h3 class="text-lg font-semibold text-amber-300">Risk Management Tips</h3>
                        <ul class="mt-2 space-y-2 text-amber-100/80 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                <strong>Equity Aktual: ${{ number_format($currentEquity, 2) }}</strong> - Lot size
                                disesuaikan secara otomatis
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk 1-2% untuk konservatif, 3-5% untuk agresif (sesuaikan dengan style trading)
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk/Reward ratio minimal 1:1.5 untuk trading yang profitable
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Lot size akan dihitung ulang saat update exit berdasarkan equity terbaru
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Risk Calculator dengan EQUITY DINAMIS
        function calculateRisk() {
            const entry = parseFloat(document.querySelector('input[name="entry"]').value) || 0;
            const stopLoss = parseFloat(document.querySelector('input[name="stop_loss"]').value) || 0;
            const takeProfit = parseFloat(document.querySelector('input[name="take_profit"]').value) || 0;
            const type = document.querySelector('select[name="type"]').value;

            if (entry && stopLoss && takeProfit) {
                let slDistance, tpDistance;

                // Hitung distance - SAMA DENGAN CONTROLLER
                if (type === 'buy') {
                    slDistance = Math.abs(entry - stopLoss);
                    tpDistance = Math.abs(takeProfit - entry);
                } else {
                    slDistance = Math.abs(stopLoss - entry);
                    tpDistance = Math.abs(entry - takeProfit);
                }

                // GUNAKAN PIP VALUE YANG REALISTIS
                const pipValue = 0.00010;

                // Hitung pips - SAMA DENGAN CONTROLLER
                const slPips = slDistance / pipValue;
                const tpPips = tpDistance / pipValue;

                // Update SL & TP Pips display
                document.getElementById('slPips').textContent = `${slPips.toFixed(1)} pips`;
                document.getElementById('tpPips').textContent = `${tpPips.toFixed(1)} pips`;

                // Calculate Risk/Reward Ratio
                const ratio = slPips > 0 ? (tpPips / slPips) : 0;
                const ratioDisplay = ratio > 0 ? `1:${ratio.toFixed(2)}` : '-';
                document.getElementById('riskRewardRatio').textContent = ratioDisplay;
                document.getElementById('rr_ratio').value = ratio.toFixed(2);

                // Calculate Position Size dengan EQUITY DINAMIS
                calculatePositionSize(slPips);

            } else {
                resetRiskCalculator();
            }
        }

        // Function untuk menghitung position size dengan EQUITY DINAMIS
        function calculatePositionSize(slPips) {
            const pipWorth = 10; // $10 per pip per 1 lot
            const currentEquity = parseFloat({{ $currentEquity }}); // EQUITY DINAMIS dari controller

            // Dapatkan risk percent yang dipilih user
            const selectedRisk = document.querySelector('input[name="risk_percent"]:checked');
            const riskPercent = selectedRisk ? parseFloat(selectedRisk.value) : 2; // Default 2%

            if (slPips > 0 && currentEquity > 0) {
                const riskUSD = currentEquity * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);

                // Tampilkan position size dengan batasan minimal 0.01
                const finalLotSize = Math.max(lotSize, 0.01).toFixed(2);
                document.getElementById('positionSize').textContent = `${finalLotSize} lots`;
                document.getElementById('riskAmountDisplay').textContent = `Risk: $${riskUSD.toFixed(2)} (${riskPercent}%)`;

            } else {
                document.getElementById('positionSize').textContent = '-';
                document.getElementById('riskAmountDisplay').textContent = '-';
            }
        }

        // Function untuk reset calculator
        function resetRiskCalculator() {
            document.getElementById('riskRewardRatio').textContent = '-';
            document.getElementById('slPips').textContent = '-';
            document.getElementById('tpPips').textContent = '-';
            document.getElementById('positionSize').textContent = '-';
            document.getElementById('riskAmountDisplay').textContent = '-';
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

        // Add event listeners untuk risk percent selector
        document.querySelectorAll('.risk-percent-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Trigger ulang perhitungan ketika risk percent berubah
                const entry = parseFloat(document.querySelector('input[name="entry"]').value) || 0;
                const stopLoss = parseFloat(document.querySelector('input[name="stop_loss"]').value) || 0;

                if (entry && stopLoss) {
                    let slDistance;
                    const type = document.querySelector('select[name="type"]').value;

                    if (type === 'buy') {
                        slDistance = Math.abs(entry - stopLoss);
                    } else {
                        slDistance = Math.abs(stopLoss - entry);
                    }

                    const pipValue = 0.00010;
                    const slPips = slDistance / pipValue;
                    calculatePositionSize(slPips);
                }
            });
        });
    </script>
@endsection
