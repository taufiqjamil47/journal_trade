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
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-arrow-left text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-chart-line text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Enhanced Progress Steps -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 - Completed -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold shadow-lg shadow-green-500/30 relative z-10 transition-all duration-500">
                        <i class="fas fa-check text-sm"></i>
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Entry Trade</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-green-500 to-primary-500 -ml-1">
                    </div>
                </div>

                <!-- Step 2 - Active -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/30 relative z-10 transition-all duration-500">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Update Exit</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-primary-500 to-gray-700 -ml-1">
                    </div>
                </div>

                <!-- Step 3 - Upcoming -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-gray-500 font-bold border-2 border-gray-700 shadow-lg transition-all duration-500 group hover:border-primary-500/30 hover:text-primary-400/70">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-500">Evaluasi</span>
                </div>
            </div>

            <!-- Progress Labels -->
            <div class="flex justify-between max-w-2xl mx-auto mt-4 px-2">
                <div class="text-xs text-green-400 font-medium">Selesai</div>
                <div class="text-xs text-primary-400 font-medium">Sedang Berlangsung</div>
                <div class="text-xs text-gray-500 font-medium">Selanjutnya</div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto">
            <!-- Enhanced Trade Summary Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-2xl mb-8 overflow-hidden">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-dark-900/80">
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-br from-primary-500/30 to-primary-600/20 p-4 rounded-2xl mr-5 shadow-lg shadow-primary-500/10">
                            <i class="fas fa-chart-line text-primary-400 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-primary-400 to-cyan-300 bg-clip-text">
                                Trade Summary</h2>
                            <p class="text-gray-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                                Detail posisi trading saat ini
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50 group hover:border-primary-500/30 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-chart-line text-primary-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">Symbol</p>
                            </div>
                            <p class="text-xl font-bold font-mono">{{ $trade->symbol->name }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50 group hover:border-primary-500/30 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="bg-{{ $trade->type == 'buy' ? 'green' : 'red' }}-500/20 p-2 rounded-lg mr-3">
                                    <i
                                        class="fas fa-exchange-alt text-{{ $trade->type == 'buy' ? 'green' : 'red' }}-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">Type</p>
                            </div>
                            <p class="text-xl font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50 group hover:border-primary-500/30 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-sign-in-alt text-blue-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">Entry Price</p>
                            </div>
                            <p class="text-xl font-bold font-mono">{{ $trade->entry }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50 group hover:border-primary-500/30 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-hand-paper text-red-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">SL Pips</p>
                            </div>
                            <p class="text-xl font-bold text-red-400">{{ $trade->sl_pips ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Info Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50">
                            <div class="flex items-center mb-3">
                                <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-hand-paper text-amber-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">Stop Loss</p>
                            </div>
                            <p class="text-lg font-semibold font-mono text-amber-400">{{ $trade->stop_loss }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-trophy text-green-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">Take Profit</p>
                            </div>
                            <p class="text-lg font-semibold font-mono text-green-400">{{ $trade->take_profit }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-dark-700/50 rounded-xl p-5 border border-gray-700/50">
                            <div class="flex items-center mb-3">
                                <div class="bg-cyan-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-balance-scale text-cyan-500 text-sm"></i>
                                </div>
                                <p class="text-sm text-gray-400">R/R Ratio</p>
                            </div>
                            <p class="text-lg font-semibold text-cyan-400">{{ $trade->rr_ratio ?? '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Container -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-2xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-dark-900/80">
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-br from-green-500/30 to-green-600/20 p-4 rounded-2xl mr-5 shadow-lg shadow-green-500/10">
                            <i class="fas fa-edit text-green-400 text-2xl"></i>
                        </div>
                        <div>
                            <h2
                                class="text-2xl font-bold bg-gradient-to-r from-green-400 to-emerald-300 bg-clip-text text-transparent">
                                Update Exit Details</h2>
                            <p class="text-gray-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-green-500"></i>
                                Lengkapi informasi exit trading untuk kalkulasi profit/loss
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.update', $trade->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Left Column - Risk Management -->
                        <div class="space-y-6">
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-amber-300">
                                    <div class="bg-amber-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-shield-alt text-amber-400"></i>
                                    </div>
                                    Risk Management
                                </h3>

                                <div class="space-y-6">
                                    <!-- Risk Percent -->
                                    <div class="space-y-3">
                                        <label for="risk_percent"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-percentage text-amber-500"></i>
                                            </div>
                                            <span>Risk Percentage</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.1" id="risk_percent" name="risk_percent"
                                                class="w-full bg-dark-800/80 border border-amber-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                                value="{{ $trade->risk_percent }}" placeholder="1.0">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-amber-400">%</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-amber-400 mt-2 flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Isi Risk % untuk kalkulasi Lot Size otomatis
                                        </p>
                                    </div>

                                    <!-- Lot Size -->
                                    <div class="space-y-3">
                                        <label for="lot_size"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-weight-scale text-blue-500"></i>
                                            </div>
                                            <span>Lot Size</span>
                                        </label>
                                        <input type="number" step="0.01" id="lot_size" name="lot_size"
                                            class="w-full bg-dark-800/80 border border-blue-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->lot_size }}" placeholder="0.10">
                                        <p class="text-xs text-blue-400 mt-2 flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Otomatis terisi dari Risk %, bisa diubah manual
                                        </p>
                                    </div>

                                    <!-- Risk USD -->
                                    <div class="space-y-3">
                                        <label for="risk_usd"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-dollar-sign text-green-500"></i>
                                            </div>
                                            <span>Risk Amount (USD)</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.01" id="risk_usd" name="risk_usd"
                                                class="w-full bg-dark-800/80 border border-green-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                                value="{{ $trade->risk_usd }}" placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-green-400">USD</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-green-400 mt-2 flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Otomatis terisi dari Risk %, bisa diubah manual
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Exit Details -->
                        <div class="space-y-6">
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-green-900/20 rounded-2xl p-6 border border-green-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-green-300">
                                    <div class="bg-green-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-door-open text-green-400"></i>
                                    </div>
                                    Exit Details
                                </h3>

                                <div class="space-y-6">
                                    <!-- Exit Price -->
                                    <div class="space-y-3">
                                        <label for="exit"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-sign-out-alt text-green-500"></i>
                                            </div>
                                            <span>Exit Price</span>
                                        </label>
                                        <input type="number" step="0.00001" name="exit" id="exit"
                                            class="w-full bg-dark-800/80 border border-green-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->exit }}" placeholder="0.00000">
                                    </div>

                                    <!-- Real-time Calculation Preview -->
                                    <div
                                        class="bg-gradient-to-br from-dark-800 to-purple-900/20 rounded-xl p-5 border border-purple-700/30">
                                        <h4 class="font-semibold text-gray-300 mb-4 flex items-center text-lg">
                                            <div class="bg-purple-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-calculator text-purple-500"></i>
                                            </div>
                                            <span>Calculation Preview</span>
                                        </h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="text-center">
                                                <p class="text-sm text-gray-400 mb-2">Risk Amount</p>
                                                <p class="text-xl font-bold text-amber-400" id="riskAmount">-</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-400 mb-2">Potential P/L</p>
                                                <p class="text-xl font-bold text-green-400" id="potentialPL">-</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <p class="text-xs text-purple-400 flex items-center justify-center">
                                                <i class="fas fa-sync-alt animate-spin mr-2"></i>
                                                Live calculation updates in real-time
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Quick Actions -->
                    <div
                        class="mt-8 bg-gradient-to-br from-dark-800 to-purple-900/20 rounded-2xl p-6 border border-purple-700/30 shadow-lg">
                        <h3 class="text-xl font-bold mb-6 flex items-center text-purple-300">
                            <div class="bg-purple-500/20 p-3 rounded-xl mr-4">
                                <i class="fas fa-bolt text-purple-400"></i>
                            </div>
                            Quick Actions
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button type="button" onclick="setExitPrice('{{ $trade->stop_loss }}')"
                                class="bg-gradient-to-br from-red-500/20 to-red-600/10 hover:from-red-500/30 hover:to-red-600/20 text-red-400 py-4 px-6 rounded-xl transition-all duration-300 border border-red-700/30 flex flex-col items-center justify-center group hover:scale-105">
                                <i class="fas fa-times text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                                <span>Set to SL</span>
                                <span class="text-xs text-red-400/70 mt-1">{{ $trade->stop_loss }}</span>
                            </button>

                            <button type="button" onclick="setExitPrice('{{ $trade->take_profit }}')"
                                class="bg-gradient-to-br from-green-500/20 to-green-600/10 hover:from-green-500/30 hover:to-green-600/20 text-green-400 py-4 px-6 rounded-xl transition-all duration-300 border border-green-700/30 flex flex-col items-center justify-center group hover:scale-105">
                                <i class="fas fa-trophy text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                                <span>Set to TP</span>
                                <span class="text-xs text-green-400/70 mt-1">{{ $trade->take_profit }}</span>
                            </button>

                            <button type="button" onclick="calculateBreakEven()"
                                class="bg-gradient-to-br from-blue-500/20 to-blue-600/10 hover:from-blue-500/30 hover:to-blue-600/20 text-blue-400 py-4 px-6 rounded-xl transition-all duration-300 border border-blue-700/30 flex flex-col items-center justify-center group hover:scale-105">
                                <i
                                    class="fas fa-balance-scale text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                                <span>Break Even</span>
                                <span class="text-xs text-blue-400/70 mt-1">Cover Spread</span>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-10 pt-8 border-t border-gray-700/50 space-y-6 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200 group">
                            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <div class="flex flex-col md:flex-row gap-4">
                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3.5 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center group">
                                <i class="fas fa-chart-bar mr-2 group-hover:scale-110 transition-transform"></i>
                                Evaluasi Trade
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3.5 px-10 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center group">
                                <i class="fas fa-check-circle mr-2 group-hover:scale-110 transition-transform"></i>
                                Update Exit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .risk-level-card input:checked+.risk-level-content {
            border-color: currentColor;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }
    </style>

    <script>
        // Enhanced Lot Size Calculator
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

                // Show success indicator
                showCalculationSuccess('risk_percent');
            }
        });

        // Enhanced Risk USD Calculator
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

                // Show success indicator
                showCalculationSuccess('risk_usd');
            }
        });

        // Enhanced Potential P/L Calculator
        function calculatePotentialPL() {
            const entry = parseFloat({{ $trade->entry }});
            const exit = parseFloat(document.getElementById('exit').value);
            const lotSize = parseFloat(document.getElementById('lot_size').value) || 0;
            const type = '{{ $trade->type }}';
            const pipValue = {{ $trade->symbol->pip_value ?? 0.0001 }};
            const pipWorth = 10;

            if (entry && exit && lotSize > 0) {
                let pips;

                // PERHITUNGAN PIPS
                if (type === 'buy') {
                    pips = (exit - entry) / pipValue;
                } else {
                    pips = (entry - exit) / pipValue;
                }

                // BULATKAN KE 1 DESIMAL
                pips = Math.round(pips * 10) / 10;

                // PERHITUNGAN PROFIT/LOSS
                const profitLoss = pips * lotSize * pipWorth;
                const roundedProfitLoss = Math.round(profitLoss * 100) / 100;

                // UPDATE DISPLAY DENGAN ANIMASI
                const plElement = document.getElementById('potentialPL');
                plElement.textContent = `$${roundedProfitLoss.toFixed(2)}`;
                plElement.className = `text-xl font-bold ${roundedProfitLoss >= 0 ? 'text-green-400' : 'text-red-400'}`;

                // Add animation
                plElement.classList.add('animate-pulse');
                setTimeout(() => {
                    plElement.classList.remove('animate-pulse');
                }, 500);
            } else {
                document.getElementById('potentialPL').textContent = '-';
                document.getElementById('potentialPL').className = 'text-xl font-bold text-gray-400';
            }
        }

        // Enhanced Quick Action Functions
        function setExitPrice(price) {
            const exitInput = document.getElementById('exit');
            exitInput.value = price;

            // Add visual feedback
            exitInput.classList.add('ring-2', 'ring-green-500');
            setTimeout(() => {
                exitInput.classList.remove('ring-2', 'ring-green-500');
            }, 1000);

            calculatePotentialPL();
        }

        function calculateBreakEven() {
            const entry = parseFloat({{ $trade->entry }});
            const type = '{{ $trade->type }}';
            const pipValue = {{ $trade->symbol->pip_value ?? 0.0001 }};
            const spreadInPips = 1.5;
            const spread = spreadInPips * pipValue;

            let breakEven;
            if (type === 'buy') {
                breakEven = entry + spread;
            } else {
                breakEven = entry - spread;
            }

            setExitPrice(breakEven.toFixed(5));
        }

        // Enhanced Input Validation
        function validateInputs() {
            const riskPercent = parseFloat(document.getElementById('risk_percent').value);
            const lotSize = parseFloat(document.getElementById('lot_size').value);
            const exitPrice = parseFloat(document.getElementById('exit').value);

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
                warningElement.className = 'text-xs text-red-400 mt-2 flex items-center';
                warningElement.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${message}`;
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

        function showCalculationSuccess(fieldId) {
            const input = document.getElementById(fieldId);
            input.classList.add('ring-2', 'ring-green-500');
            setTimeout(() => {
                input.classList.remove('ring-2', 'ring-green-500');
            }, 1000);
        }

        // Enhanced Event Listeners
        document.getElementById('lot_size').addEventListener('input', function() {
            calculatePotentialPL();
            showCalculationSuccess('lot_size');
        });

        document.getElementById('exit').addEventListener('input', function() {
            calculatePotentialPL();
            showCalculationSuccess('exit');
        });

        document.getElementById('risk_percent').addEventListener('input', validateInputs);
        document.getElementById('lot_size').addEventListener('input', validateInputs);
        document.getElementById('exit').addEventListener('input', validateInputs);

        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('risk_percent').value) {
                document.getElementById('risk_percent').dispatchEvent(new Event('input'));
            }

            // Add initial animation to calculation preview
            setTimeout(() => {
                document.querySelector('.bg-gradient-to-br.from-dark-800.to-purple-900\\/20').classList.add(
                    'animate-pulse');
                setTimeout(() => {
                    document.querySelector('.bg-gradient-to-br.from-dark-800.to-purple-900\\/20')
                        .classList.remove('animate-pulse');
                }, 2000);
            }, 500);
        });
    </script>
@endsection
