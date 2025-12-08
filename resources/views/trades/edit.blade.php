@extends('Layouts.index')
@section('title', 'Edit Trade (Exit)')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Update Exit Trade
                    </h1>
                    <p class="text-gray-500 mt-1">Step 2 - Update hasil trading Anda</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps -->
        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 mb-6">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 -->
                <div class="flex flex-col items-center relative">
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Entry Trade</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Update Exit</span>
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

        <div class="max-w-5xl mx-auto">
            <!-- Trade Summary Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 mb-6">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-primary-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-line text-primary-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">
                                Trade Summary
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">
                                Detail posisi trading saat ini
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Symbol</p>
                            <p class="text-base font-bold font-mono">{{ $trade->symbol->name }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Type</p>
                            <p class="text-base font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Entry Price</p>
                            <p class="text-base font-bold font-mono">{{ $trade->entry }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">SL Pips</p>
                            <p class="text-base font-bold text-red-400">{{ $trade->sl_pips ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Stop Loss</p>
                            <p class="text-base font-semibold font-mono text-amber-400">{{ $trade->stop_loss }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Take Profit</p>
                            <p class="text-base font-semibold font-mono text-green-400">{{ $trade->take_profit }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">R/R Ratio</p>
                            <p class="text-base font-semibold text-cyan-400">{{ $trade->rr ?? '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-gray-800 rounded-xl border border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-green-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-edit text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-green-300">
                                Update Exit Details
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">
                                Lengkapi informasi exit trading
                            </p>
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
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-amber-300">
                                    <i class="fas fa-shield-alt text-amber-400 mr-3"></i>
                                    Risk Management
                                </h3>

                                <div class="space-y-4">
                                    <!-- Risk Percent -->
                                    <div class="space-y-2">
                                        <label for="risk_percent" class="block text-sm font-semibold text-gray-300">
                                            Risk Percentage
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.1" id="risk_percent" name="risk_percent"
                                                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent"
                                                value="{{ $trade->risk_percent }}" placeholder="1.0">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-amber-400">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lot Size -->
                                    <div class="space-y-2">
                                        <label for="lot_size" class="block text-sm font-semibold text-gray-300">
                                            Lot Size
                                        </label>
                                        <input type="number" step="0.01" id="lot_size" name="lot_size"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent"
                                            value="{{ $trade->lot_size }}" placeholder="0.10">
                                    </div>

                                    <!-- Risk USD -->
                                    <div class="space-y-2">
                                        <label for="risk_usd" class="block text-sm font-semibold text-gray-300">
                                            Risk Amount (USD)
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.01" id="risk_usd" name="risk_usd"
                                                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                                value="{{ $trade->risk_usd }}" placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-green-400">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-300">
                                    <i class="fas fa-door-open text-green-400 mr-3"></i>
                                    Exit Details
                                </h3>

                                <div class="space-y-4">
                                    <!-- Exit Price -->
                                    <div class="space-y-2">
                                        <label for="exit" class="block text-sm font-semibold text-gray-300">
                                            Exit Price
                                        </label>
                                        <input type="number" step="0.00001" name="exit" id="exit"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                            value="{{ $trade->exit }}" placeholder="0.00000">
                                    </div>

                                    <!-- Calculation Preview -->
                                    <div class="bg-gray-750 rounded-lg p-4 border border-gray-600">
                                        <h4 class="font-semibold text-gray-300 mb-3 flex items-center">
                                            <i class="fas fa-calculator text-purple-400 mr-2"></i>
                                            Calculation Preview
                                        </h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="text-center">
                                                <p class="text-sm text-gray-400 mb-1">Risk Amount</p>
                                                <p class="text-base font-bold text-amber-400" id="riskAmount">-</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-400 mb-1">Potential P/L</p>
                                                <p class="text-base font-bold text-green-400" id="potentialPL">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 bg-gray-750 rounded-xl p-4 border border-gray-600">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-purple-300">
                            <i class="fas fa-bolt text-purple-400 mr-3"></i>
                            Quick Actions
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <button type="button" onclick="setExitPrice('{{ $trade->stop_loss }}')"
                                class="bg-gray-800 hover:bg-red-900/30 text-red-400 py-3 px-4 rounded-lg transition-colors border border-red-700/30 flex flex-col items-center">
                                <i class="fas fa-times text-lg mb-1"></i>
                                <span>Set to SL</span>
                                <span class="text-xs text-red-400/70 mt-1">{{ $trade->stop_loss }}</span>
                            </button>

                            <button type="button" onclick="setExitPrice('{{ $trade->take_profit }}')"
                                class="bg-gray-800 hover:bg-green-900/30 text-green-400 py-3 px-4 rounded-lg transition-colors border border-green-700/30 flex flex-col items-center">
                                <i class="fas fa-trophy text-lg mb-1"></i>
                                <span>Set to TP</span>
                                <span class="text-xs text-green-400/70 mt-1">{{ $trade->take_profit }}</span>
                            </button>

                            <button type="button" onclick="calculateBreakEven()"
                                class="bg-gray-800 hover:bg-blue-900/30 text-blue-400 py-3 px-4 rounded-lg transition-colors border border-blue-700/30 flex flex-col items-center">
                                <i class="fas fa-balance-scale text-lg mb-1"></i>
                                <span>Break Even</span>
                                <span class="text-xs text-blue-400/70 mt-1">Cover Spread</span>
                            </button>
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
                        <div class="flex flex-col md:flex-row gap-3">
                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center mb-3 md:mb-0">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Evaluasi Trade
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
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
        // Basic calculation functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Risk Percent calculation
            document.getElementById('risk_percent').addEventListener('input', function() {
                const riskPercent = parseFloat(this.value);
                const slPips = {{ $trade->sl_pips ?? 0 }};
                const balance = {{ $balance }}; // Ini sudah benar dari controller yang diperbaiki
                const pipWorth = 10;

                if (!isNaN(riskPercent) && riskPercent > 0 && slPips > 0) {
                    const riskUSD = balance * (riskPercent / 100);
                    const lotSize = riskUSD / (slPips * pipWorth);

                    document.getElementById('lot_size').value = lotSize.toFixed(2);
                    document.getElementById('risk_usd').value = riskUSD.toFixed(2);
                    document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                    calculatePotentialPL();
                }
            });

            // Risk USD calculation
            document.getElementById('risk_usd').addEventListener('input', function() {
                const riskUSD = parseFloat(this.value);
                const balance = {{ $balance }};
                const slPips = {{ $trade->sl_pips ?? 0 }};
                const pipWorth = 10;

                if (!isNaN(riskUSD) && riskUSD > 0 && balance > 0) {
                    const riskPercent = (riskUSD / balance) * 100;
                    const lotSize = slPips > 0 ? riskUSD / (slPips * pipWorth) : 0;

                    document.getElementById('risk_percent').value = riskPercent.toFixed(2);
                    if (slPips > 0) {
                        document.getElementById('lot_size').value = lotSize.toFixed(2);
                    }
                    document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                    calculatePotentialPL();
                }
            });

            // Lot Size event listener
            document.getElementById('lot_size').addEventListener('input', calculatePotentialPL);

            // Exit price event listener
            document.getElementById('exit').addEventListener('input', calculatePotentialPL);

            // Initial calculation
            if (document.getElementById('risk_percent').value) {
                document.getElementById('risk_percent').dispatchEvent(new Event('input'));
            }
        });

        // Calculate potential P/L
        function calculatePotentialPL() {
            const entry = parseFloat({{ $trade->entry }});
            const exit = parseFloat(document.getElementById('exit').value);
            const lotSize = parseFloat(document.getElementById('lot_size').value) || 0;
            const type = '{{ $trade->type }}';
            const pipValue = {{ $trade->symbol->pip_value ?? 0.0001 }};
            const pipWorth = 10;

            if (entry && exit && lotSize > 0) {
                let pips;
                if (type === 'buy') {
                    pips = (exit - entry) / pipValue;
                } else {
                    pips = (entry - exit) / pipValue;
                }

                pips = Math.round(pips * 10) / 10;
                const profitLoss = pips * lotSize * pipWorth;
                const roundedProfitLoss = Math.round(profitLoss * 100) / 100;

                const plElement = document.getElementById('potentialPL');
                plElement.textContent = `$${roundedProfitLoss.toFixed(2)}`;
                plElement.className = `text-base font-bold ${roundedProfitLoss >= 0 ? 'text-green-400' : 'text-red-400'}`;
            } else {
                document.getElementById('potentialPL').textContent = '-';
                document.getElementById('potentialPL').className = 'text-base font-bold text-gray-400';
            }
        }

        // Quick action functions
        function setExitPrice(price) {
            const exitInput = document.getElementById('exit');
            exitInput.value = price;
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
    </script>
@endsection
