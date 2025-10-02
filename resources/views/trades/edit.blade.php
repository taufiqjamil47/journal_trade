@extends('Layouts.index')
@section('title', 'Edit Trade (Exit)')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Update Exit Trade</h1>
                    <p class="text-gray-400 mt-2">Step 2 - Update hasil trading Anda</p>
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
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Entry Trade</span>
                </div>
                <div class="h-1 flex-1 bg-primary-500 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold shadow-lg">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Update Exit</span>
                </div>
                <div class="h-1 flex-1 bg-gray-700 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold text-sm">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-400">Evaluasi</span>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Trade Summary Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl mb-6">
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-line text-primary-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Trade Summary</h2>
                            <p class="text-gray-400 text-sm mt-1">Detail posisi trading saat ini</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-dark-800/50 rounded-lg p-4 border border-gray-700/50">
                            <p class="text-sm text-gray-400">Symbol</p>
                            <p class="text-lg font-semibold">{{ $trade->symbol->name }}</p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-4 border border-gray-700/50">
                            <p class="text-sm text-gray-400">Type</p>
                            <p
                                class="text-lg font-semibold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-4 border border-gray-700/50">
                            <p class="text-sm text-gray-400">Entry Price</p>
                            <p class="text-lg font-semibold font-mono">{{ $trade->entry }}</p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-4 border border-gray-700/50">
                            <p class="text-sm text-gray-400">SL Pips</p>
                            <p class="text-lg font-semibold text-red-400">{{ $trade->sl_pips ?? '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-edit text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Update Exit Details</h2>
                            <p class="text-gray-400 text-sm mt-1">Lengkapi informasi exit trading</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.update', $trade->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Risk Management Section -->
                            <div class="bg-dark-800/50 rounded-xl p-4 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-amber-300">
                                    <i class="fas fa-shield-alt mr-2"></i>Risk Management
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="risk_percent" class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-percentage mr-2 text-amber-500"></i>Risk %
                                        </label>
                                        <input type="number" step="0.1" id="risk_percent" name="risk_percent"
                                            class="w-full bg-dark-800 border border-amber-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->risk_percent }}" placeholder="1.0">
                                        <p class="text-xs text-amber-400 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>Isi Risk % untuk kalkulasi Lot Size
                                            otomatis
                                        </p>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="lot_size" class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-weight-scale mr-2 text-blue-500"></i>Lot Size
                                        </label>
                                        <input type="number" step="0.01" id="lot_size" name="lot_size"
                                            class="w-full bg-dark-800 border border-blue-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->lot_size }}" placeholder="0.10">
                                        <p class="text-xs text-blue-400 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>Otomatis terisi dari Risk %, bisa
                                            diubah manual
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Exit Details Section -->
                            <div class="bg-dark-800/50 rounded-xl p-4 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-green-300">
                                    <i class="fas fa-door-open mr-2"></i>Exit Details
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="exit" class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-sign-out-alt mr-2 text-green-500"></i>Exit Price
                                        </label>
                                        <input type="number" step="0.00001" name="exit"
                                            class="w-full bg-dark-800 border border-green-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->exit }}" placeholder="0.00000">
                                    </div>

                                    <!-- Real-time Calculation Preview -->
                                    <div class="bg-dark-700/30 rounded-lg p-4 border border-gray-600/50">
                                        <h4 class="font-medium text-gray-300 mb-3 flex items-center">
                                            <i class="fas fa-calculator mr-2 text-purple-500"></i>Calculation Preview
                                        </h4>
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div>
                                                <p class="text-gray-400">Risk Amount</p>
                                                <p class="font-semibold text-amber-400" id="riskAmount">-</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-400">Potential P/L</p>
                                                <p class="font-semibold text-green-400" id="potentialPL">-</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dalam form, tambahkan input untuk risk_usd -->
                                    <div class="space-y-2">
                                        <label for="risk_usd" class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-dollar-sign mr-2 text-green-500"></i>Risk USD
                                        </label>
                                        <input type="number" step="0.01" id="risk_usd" name="risk_usd"
                                            class="w-full bg-dark-800 border border-green-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->risk_usd }}" placeholder="0.00">
                                        <p class="text-xs text-green-400 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>Otomatis terisi dari Risk %, bisa
                                            diubah manual
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 bg-dark-800/50 rounded-xl p-4 border border-gray-700/50">
                        <h3 class="text-lg font-semibold mb-3 flex items-center text-purple-300">
                            <i class="fas fa-bolt mr-2"></i>Quick Actions
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <button type="button" onclick="setExitPrice('{{ $trade->stop_loss }}')"
                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 py-2 px-4 rounded-lg transition-all duration-200 border border-red-700/30 flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>Set to SL
                            </button>
                            <button type="button" onclick="setExitPrice('{{ $trade->take_profit }}')"
                                class="bg-green-500/20 hover:bg-green-500/30 text-green-400 py-2 px-4 rounded-lg transition-all duration-200 border border-green-700/30 flex items-center justify-center">
                                <i class="fas fa-trophy mr-2"></i>Set to TP
                            </button>
                            <button type="button" onclick="calculateBreakEven()"
                                class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-2 px-4 rounded-lg transition-all duration-200 border border-blue-700/30 flex items-center justify-center">
                                <i class="fas fa-balance-scale mr-2"></i>Break Even
                            </button>
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
                        <div class="flex space-x-3">
                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Evaluasi
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Update Exit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Lot Size Calculator - UPDATE VERSION
        document.getElementById('risk_percent').addEventListener('input', function() {
            const riskPercent = parseFloat(this.value);
            const slPips = {{ $trade->sl_pips ?? 0 }};
            const balance = {{ $balance }};
            const pipWorth = 10;

            if (!isNaN(riskPercent) && riskPercent > 0 && slPips > 0) {
                const riskUSD = balance * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);

                // UPDATE LOT SIZE
                document.getElementById('lot_size').value = lotSize.toFixed(2);

                // AUTO-FILL risk_usd FIELD
                document.getElementById('risk_usd').value = riskUSD.toFixed(2);

                // UPDATE DISPLAY
                document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                calculatePotentialPL();
            }
        });

        // JIKA risk_usd DIUBAH MANUAL, HITUNG ULANG risk_percent
        document.getElementById('risk_usd').addEventListener('input', function() {
            const riskUSD = parseFloat(this.value);
            const balance = {{ $balance }};
            const slPips = {{ $trade->sl_pips ?? 0 }};
            const pipWorth = 10;

            if (!isNaN(riskUSD) && riskUSD > 0 && balance > 0) {
                // HITUNG RISK PERCENT
                const riskPercent = (riskUSD / balance) * 100;

                // HITUNG LOT SIZE
                const lotSize = slPips > 0 ? riskUSD / (slPips * pipWorth) : 0;

                // UPDATE FIELDS
                document.getElementById('risk_percent').value = riskPercent.toFixed(2);
                if (slPips > 0) {
                    document.getElementById('lot_size').value = lotSize.toFixed(2);
                }

                // UPDATE DISPLAY
                document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                calculatePotentialPL();
            }
        });

        // Calculate Potential P/L
        function calculatePotentialPL() {
            const entry = parseFloat({{ $trade->entry }});
            const exit = parseFloat(document.querySelector('input[name="exit"]').value);
            const lotSize = parseFloat(document.getElementById('lot_size').value) || 0;
            const type = '{{ $trade->type }}';
            const pipValue = {{ $trade->symbol->pip_value ?? 0.0001 }};

            // GUNAKAN PIP WORTH YANG SAMA DENGAN CONTROLLER - KONSISTEN!
            const pipWorth = 10; // Harus sama dengan $pipWorth di controller

            if (entry && exit && lotSize > 0) {
                let pips;

                // PERHITUNGAN PIPS YANG SAMA PERSIS DENGAN CONTROLLER
                if (type === 'buy') {
                    pips = (exit - entry) / pipValue;
                } else {
                    pips = (entry - exit) / pipValue;
                }

                // BULATKAN KE 1 DESIMAL SEPERTI CONTROLLER
                pips = Math.round(pips * 10) / 10;

                // PERHITUNGAN PROFIT/LOSS YANG SAMA DENGAN CONTROLLER
                const profitLoss = pips * lotSize * pipWorth;

                // BULATKAN KE 2 DESIMAL SEPERTI CONTROLLER
                const roundedProfitLoss = Math.round(profitLoss * 100) / 100;

                document.getElementById('potentialPL').textContent = `$${roundedProfitLoss.toFixed(2)}`;
                document.getElementById('potentialPL').className =
                    `font-semibold ${roundedProfitLoss >= 0 ? 'text-green-400' : 'text-red-400'}`;
            } else {
                document.getElementById('potentialPL').textContent = '-';
            }
        }

        // Quick Action Functions
        function setExitPrice(price) {
            document.querySelector('input[name="exit"]').value = price;
            calculatePotentialPL();
        }

        // GANTI function calculateBreakEven()
        function calculateBreakEven() {
            const entry = parseFloat({{ $trade->entry }});
            const type = '{{ $trade->type }}';
            const pipValue = {{ $trade->symbol->pip_value ?? 0.0001 }};

            // GUNAKAN SPREAD YANG LEBIH REALISTIS
            // Untuk major pairs, spread biasanya 1-2 pips
            const spreadInPips = 1.5; // Rata-rata spread
            const spread = spreadInPips * pipValue;

            let breakEven;
            if (type === 'buy') {
                breakEven = entry + spread;
            } else {
                breakEven = entry - spread;
            }

            document.querySelector('input[name="exit"]').value = breakEven.toFixed(5);
            calculatePotentialPL();
        }

        // TAMBAHKAN SETELAH SCRIPT YANG SUDAH ADA
        function validateInputs() {
            const riskPercent = parseFloat(document.getElementById('risk_percent').value);
            const lotSize = parseFloat(document.getElementById('lot_size').value);
            const exitPrice = parseFloat(document.querySelector('input[name="exit"]').value);

            // VALIDASI RISK PERCENT
            if (riskPercent > 0 && (riskPercent < 0.1 || riskPercent > 5)) {
                showWarning('risk_percent', 'Risk percent biasanya antara 0.1% - 5%');
            } else {
                hideWarning('risk_percent');
            }

            // VALIDASI LOT SIZE
            if (lotSize > 0 && lotSize < 0.01) {
                showWarning('lot_size', 'Lot size minimum adalah 0.01');
            } else {
                hideWarning('lot_size');
            }
        }

        function showWarning(fieldId, message) {
            let warningElement = document.getElementById(`${fieldId}-warning`);
            if (!warningElement) {
                const input = document.getElementById(fieldId);
                warningElement = document.createElement('p');
                warningElement.id = `${fieldId}-warning`;
                warningElement.className = 'text-xs text-red-400 mt-1';
                input.parentNode.appendChild(warningElement);
            }
            warningElement.textContent = message;
        }

        function hideWarning(fieldId) {
            const warningElement = document.getElementById(`${fieldId}-warning`);
            if (warningElement) {
                warningElement.remove();
            }
        }

        // TAMBAHKAN EVENT LISTENERS
        document.getElementById('risk_percent').addEventListener('input', validateInputs);
        document.getElementById('lot_size').addEventListener('input', validateInputs);
        document.querySelector('input[name="exit"]').addEventListener('input', validateInputs);

        // Event listeners for real-time calculation
        document.getElementById('lot_size').addEventListener('input', calculatePotentialPL);
        document.querySelector('input[name="exit"]').addEventListener('input', calculatePotentialPL);

        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('risk_percent').value) {
                document.getElementById('risk_percent').dispatchEvent(new Event('input'));
            }
        });
    </script>
@endsection
