@extends('Layouts.index')
@section('title', 'New Trade')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Tambah Trade Baru
                    </h1>
                    <p class="text-gray-500 mt-1">Step 1 - Masukkan detail entry trading Anda</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps -->
        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 mb-6">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Entry Trade</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 font-bold border border-gray-600">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-500">Update Exit</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 font-bold border border-gray-600">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-500">Evaluasi</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto">
            <div class="bg-gray-800 rounded-xl border border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-primary-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-plus-circle text-primary-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">
                                Detail Entry Trade
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">
                                Isi informasi trading dengan benar
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Symbol Selection -->
                            <div class="space-y-2">
                                <label for="symbol_id" class="block text-sm font-semibold text-gray-300">
                                    Symbol / Pair Trading
                                </label>
                                <select name="symbol_id"
                                    class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                                    @foreach ($symbols as $symbol)
                                        <option value="{{ $symbol->id }}" data-pip_value="{{ $symbol->pip_value }}"
                                            data-pip_worth="{{ $symbol->pip_worth ?? 10 }}"
                                            data-pip_position="{{ $symbol->pip_position ?? '' }}" class="bg-gray-800">
                                            {{ $symbol->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trade Type -->
                            <div class="space-y-2">
                                <label for="type" class="block text-sm font-semibold text-gray-300">
                                    Jenis Trade
                                </label>
                                <select name="type" id="tradeType"
                                    class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                    required>
                                    <option value="buy" class="bg-gray-800">Buy / Long</option>
                                    <option value="sell" class="bg-gray-800">Sell / Short</option>
                                </select>
                            </div>

                            <!-- Timestamp & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="timestamp" class="block text-sm font-semibold text-gray-300">
                                        Waktu Entry
                                    </label>
                                    <input type="time" name="timestamp"
                                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>

                                <div class="space-y-2">
                                    <label for="date" class="block text-sm font-semibold text-gray-300">
                                        Tanggal Trade
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Entry Price -->
                            <div class="space-y-2">
                                <label for="entry" class="block text-sm font-semibold text-gray-300">
                                    Harga Entry
                                </label>
                                <input type="number" step="0.00001" name="entry" id="entryPrice"
                                    class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="0.00000" required>
                            </div>

                            <!-- Stop Loss & Take Profit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="stop_loss" class="block text-sm font-semibold text-gray-300">
                                        Stop Loss
                                    </label>
                                    <input type="number" step="0.00001" name="stop_loss" id="stopLoss"
                                        class="w-full bg-gray-800 border border-red-700/40 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-transparent"
                                        placeholder="0.00000" required>
                                    <!-- HIDDEN INPUT UNTUK RR RATIO -->
                                    <input type="hidden" name="rr_ratio" id="rr_ratio" value="0">
                                </div>

                                <div class="space-y-2">
                                    <label for="take_profit" class="block text-sm font-semibold text-gray-300">
                                        Take Profit
                                    </label>
                                    <input type="number" step="0.00001" name="take_profit"
                                        class="w-full bg-gray-800 border border-green-700/40 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                        placeholder="0.00000" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Calculator -->
                    <div class="mt-6">
                        <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-calculator text-amber-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-amber-300">Risk Calculator</h3>
                                        <p class="text-gray-400 text-sm">Live calculation based on current equity</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-bold text-amber-400">$<span
                                            id="currentEquity">{{ number_format($currentEquity, 2) }}</span></div>
                                    <div class="text-xs text-gray-400">Current Equity</div>
                                </div>
                            </div>

                            <!-- Risk Metrics Grid -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                                <!-- Risk/Reward Card -->
                                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                                    <p class="text-xs text-gray-400 mb-1">Risk/Reward Ratio</p>
                                    <p class="text-base font-bold text-amber-300" id="riskRewardRatio">-</p>
                                </div>

                                <!-- SL Distance Card -->
                                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                                    <p class="text-xs text-gray-400 mb-1">Stop Loss Distance</p>
                                    <p class="text-base font-bold text-red-300" id="slPips">-</p>
                                </div>

                                <!-- TP Distance Card -->
                                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                                    <p class="text-xs text-gray-400 mb-1">Take Profit Distance</p>
                                    <p class="text-base font-bold text-green-300" id="tpPips">-</p>
                                </div>

                                <!-- Lot Size Card -->
                                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                                    <p class="text-xs text-gray-400 mb-1">Recommended Lot Size</p>
                                    <p class="text-base font-bold text-cyan-300" id="positionSize">-</p>
                                </div>
                            </div>

                            <!-- Risk Level Selector -->
                            <div class="bg-gray-800 rounded-lg p-3 border border-gray-600 mb-3">
                                <h4 class="text-sm font-semibold text-amber-300 mb-3">
                                    Risk Management Level
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <!-- Conservative -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="1" class="hidden" checked>
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-green-500">
                                            <div class="text-green-400 text-base font-bold">1%</div>
                                            <div class="text-green-300 text-xs">Conservative</div>
                                        </div>
                                    </label>

                                    <!-- Moderate -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="2" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500">
                                            <div class="text-blue-400 text-base font-bold">2%</div>
                                            <div class="text-blue-300 text-xs">Moderate</div>
                                        </div>
                                    </label>

                                    <!-- Aggressive -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="3" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-orange-500">
                                            <div class="text-orange-400 text-base font-bold">3%</div>
                                            <div class="text-orange-300 text-xs">Aggressive</div>
                                        </div>
                                    </label>

                                    <!-- High Risk -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="5" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-red-500">
                                            <div class="text-red-400 text-base font-bold">5%</div>
                                            <div class="text-red-300 text-xs">High Risk</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-700 space-y-4 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <button type="submit"
                            class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Trade
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div class="mt-6 bg-gray-800 rounded-xl p-4 border border-gray-600">
                <div class="flex items-start">
                    <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-lightbulb text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-amber-300">Risk Management Tips</h3>
                        <ul class="mt-2 space-y-1 text-gray-400 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Equity Aktual: ${{ number_format($currentEquity, 2) }} - Lot size disesuaikan otomatis
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk 1-2% untuk konservatif, 3-5% untuk agresif
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk/Reward ratio minimal 1:1.5 untuk trading profitable
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Basic Risk Calculator (per-symbol aware)
        function calculateRisk() {
            const entry = parseFloat(document.querySelector('input[name="entry"]').value) || 0;
            const stopLoss = parseFloat(document.querySelector('input[name="stop_loss"]').value) || 0;
            const takeProfit = parseFloat(document.querySelector('input[name="take_profit"]').value) || 0;
            const type = document.querySelector('select[name="type"]').value;

            // Read pip settings from selected symbol option
            const symbolSelect = document.querySelector('select[name="symbol_id"]');
            const selectedOption = symbolSelect ? symbolSelect.options[symbolSelect.selectedIndex] : null;
            const pipValue = selectedOption && selectedOption.dataset.pip_value ? parseFloat(selectedOption.dataset
                .pip_value) : 0.00010;
            const pipWorth = selectedOption && selectedOption.dataset.pip_worth ? parseFloat(selectedOption.dataset
                .pip_worth) : 10;

            // autoDetermineTradeType();

            if (entry && stopLoss && takeProfit) {
                let slDistance, tpDistance;

                // Hitung distance
                if (type === 'buy') {
                    slDistance = Math.abs(entry - stopLoss);
                    tpDistance = Math.abs(takeProfit - entry);
                } else {
                    slDistance = Math.abs(stopLoss - entry);
                    tpDistance = Math.abs(entry - takeProfit);
                }

                const slPips = pipValue > 0 ? slDistance / pipValue : 0;
                const tpPips = pipValue > 0 ? tpDistance / pipValue : 0;

                // Update display
                document.getElementById('slPips').textContent = `${slPips.toFixed(1)} pips`;
                document.getElementById('tpPips').textContent = `${tpPips.toFixed(1)} pips`;

                // Calculate Risk/Reward Ratio
                const ratio = slPips > 0 ? (tpPips / slPips) : 0;
                const ratioDisplay = ratio > 0 ? `1:${ratio.toFixed(2)}` : '-';
                document.getElementById('riskRewardRatio').textContent = ratioDisplay;
                document.getElementById('rr_ratio').value = ratio.toFixed(2);

                // Calculate Position Size (use pipWorth per-symbol)
                calculatePositionSize(slPips, pipWorth);

            } else {
                resetRiskCalculator();
            }
        }

        // Calculate Position Size
        function calculatePositionSize(slPips, pipWorth) {
            pipWorth = typeof pipWorth !== 'undefined' ? pipWorth : 10;
            const currentEquity = parseFloat({{ $currentEquity }});

            // Get selected risk percent
            const selectedRisk = document.querySelector('input[name="risk_percent"]:checked');
            const riskPercent = selectedRisk ? parseFloat(selectedRisk.value) : 2;

            if (slPips > 0 && currentEquity > 0) {
                const riskUSD = currentEquity * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);
                const finalLotSize = Math.max(lotSize, 0.01).toFixed(2);
                document.getElementById('positionSize').textContent = `${finalLotSize} lots`;
            } else {
                document.getElementById('positionSize').textContent = '-';
            }
        }

        // Reset calculator
        function resetRiskCalculator() {
            document.getElementById('riskRewardRatio').textContent = '-';
            document.getElementById('slPips').textContent = '-';
            document.getElementById('tpPips').textContent = '-';
            document.getElementById('positionSize').textContent = '-';
            document.getElementById('rr_ratio').value = '0';
        }

        function autoDetermineTradeType() {
            const entry = parseFloat(document.getElementById('entryPrice').value) || 0;
            const stopLoss = parseFloat(document.getElementById('stopLoss').value) || 0;
            const tradeTypeSelect = document.getElementById('tradeType');

            if (entry > 0 && stopLoss > 0) {
                if (entry < stopLoss) {
                    // Entry < SL → Sell/Short
                    tradeTypeSelect.value = 'sell';
                    tradeTypeSelect.classList.add('border-red-700/40');
                    tradeTypeSelect.classList.remove('border-green-700/40', 'border-gray-600');
                } else if (entry > stopLoss) {
                    // Entry > SL → Buy/Long
                    tradeTypeSelect.value = 'buy';
                    tradeTypeSelect.classList.add('border-green-700/40');
                    tradeTypeSelect.classList.remove('border-red-700/40', 'border-gray-600');
                } else {
                    // Entry == SL → Reset
                    tradeTypeSelect.value = 'buy';
                    tradeTypeSelect.classList.remove('border-red-700/40', 'border-green-700/40');
                    tradeTypeSelect.classList.add('border-gray-600');
                }

                // Trigger recalculation after changing trade type
                calculateRisk();
            }
        }

        // Add event listeners
        document.querySelector('input[name="entry"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="stop_loss"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="take_profit"]').addEventListener('input', calculateRisk);
        document.querySelector('select[name="type"]').addEventListener('change', calculateRisk);

        // Add event listeners for auto trade type determination
        document.getElementById('entryPrice').addEventListener('input', autoDetermineTradeType);
        document.getElementById('stopLoss').addEventListener('input', autoDetermineTradeType);

        // Recalculate when symbol changes since pip settings differ per symbol
        const symbolSelectEl = document.querySelector('select[name="symbol_id"]');
        if (symbolSelectEl) {
            symbolSelectEl.addEventListener('change', calculateRisk);
        }

        // Risk percent change listener
        document.querySelectorAll('input[name="risk_percent"]').forEach(radio => {
            radio.addEventListener('change', function() {
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

        // Set current datetime as default
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeOnly = `${hours}:${minutes}`;
            document.querySelector('input[name="timestamp"]').value = timeOnly;

            const today = now.toISOString().slice(0, 10);
            document.querySelector('input[name="date"]').value = today;

            // Initial calculation
            calculateRisk();
        });
    </script>
@endsection
