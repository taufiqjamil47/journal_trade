@extends('Layouts.index')
@section('title', __('trades.new_trade'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('trades.add_new_trade') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-500 mt-1">
                        {{ __('trades.step1_description') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>{{ __('trades.back_to_list') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 mb-6">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">{{ __('trades.step_entry') }}</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-300 dark:text-gray-500 font-bold border border-none dark:border-gray-600">
                        2
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-gray-300 dark:text-gray-500">{{ __('trades.step_exit') }}</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-300 dark:text-gray-500 font-bold border border-none dark:border-gray-600">
                        3
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-gray-300 dark:text-gray-500">{{ __('trades.step_evaluation') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="bg-primary-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-plus-circle text-primary-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">
                                {{ __('trades.trade_details') }}
                            </h2>
                            <p class="text-gray-500 text-sm mt-1 gap-3 flex items-center justify-between">
                                <span>{{ __('trades.fill_info_correctly') }}</span>
                                <span
                                    class="inline-block px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm rounded-full">
                                    @if ($selectedAccount)
                                        <i class="fas fa-check-circle mr-1"></i>Account: {{ $selectedAccount->name }}
                                    @else
                                        <i class="fas fa-exclamation-circle mr-1"></i>No account selected
                                    @endif
                                </span>
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
                                <label for="symbol_id" class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    {{ __('trades.symbol_pair') }}
                                </label>
                                <select name="symbol_id"
                                    class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                                    @foreach ($symbols as $symbol)
                                        <option value="{{ $symbol->id }}"
                                            data-pip-value="{{ $symbol->formatted_pip_value }}"
                                            data-pip-worth="{{ $symbol->formatted_pip_worth }}"
                                            data-pip-position="{{ $symbol->pip_position ?? '' }}">
                                            {{ $symbol->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trade Type -->
                            <div class="space-y-2">
                                <label for="type" class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    {{ __('trades.trade_type') }}
                                </label>
                                <select name="type" id="tradeType"
                                    class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                    required>
                                    <option value="buy" class="bg-gray-800">{{ __('trades.type_buy') }}</option>
                                    <option value="sell" class="bg-gray-800">{{ __('trades.type_sell') }}</option>
                                </select>
                            </div>

                            <!-- Timestamp & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="timestamp"
                                        class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('trades.entry_time') }}
                                    </label>
                                    <input type="time" name="timestamp"
                                        class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>

                                <div class="space-y-2">
                                    <label for="date"
                                        class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('trades.trade_date') }}
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Entry Price -->
                            <div class="space-y-2">
                                <label for="entry" class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    {{ __('trades.entry_price') }}
                                </label>
                                <input type="number" step="0.00001" name="entry" id="entryPrice"
                                    class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="0.00000" required>
                            </div>

                            <!-- Stop Loss & Take Profit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="stop_loss"
                                        class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('trades.stop_loss') }}
                                    </label>
                                    <input type="number" step="0.00001" name="stop_loss" id="stopLoss"
                                        class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-transparent"
                                        placeholder="0.00000" required>
                                    <!-- HIDDEN INPUT UNTUK RR RATIO -->
                                    <input type="hidden" name="rr_ratio" id="rr_ratio" value="0">
                                </div>

                                <div class="space-y-2">
                                    <label for="take_profit"
                                        class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('trades.take_profit') }}
                                    </label>
                                    <input type="number" step="0.00001" name="take_profit"
                                        class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                        placeholder="0.00000" required>
                                </div>
                            </div>
                            <!-- Before Link -->
                            <div class="space-y-2">
                                <label for="before_link"
                                    class="block text-sm font-semibold text-gray-600 dark:text-gray-300 flex items-center">
                                    <i class="fas fa-image mr-2 text-primary-400"></i>
                                    {{ __('trades.before_screenshot') }}
                                </label>
                                <input type="url" name="before_link" id="before_link"
                                    class="w-full bg-gray-200/40 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                    placeholder="{{ __('trades.screenshot_placeholder') }}">
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ __('trades.screenshot_info') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Calculator -->
                    <div class="mt-6">
                        <div class="rounded-xl p-4 border border-gray-300 dark:border-gray-600">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-calculator text-amber-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-amber-400 dark:text-amber-300">
                                            {{ __('trades.risk_calculator') }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ __('trades.live_calculation') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2">
                                        <h3 id="currentEquityText"
                                            class="text-base font-bold text-amber-400 dark:text-amber-300 mt-2">******
                                        </h3>
                                        <h3 id="currentEquity"
                                            class="text-base font-bold text-amber-400 dark:text-amber-300 mt-2 hidden">
                                            ${{ number_format($currentEquity, 2) }}
                                        </h3>
                                        <button id="toggleBalance" type="button"
                                            class="mt-2 px-2 rounded-lg hover:bg-primary-500/30 transition-colors"
                                            title="{{ __('trades.show_hide_balance') }}">
                                            <i id="currentEquityIcon"
                                                class="fas fa-eye-slash text-amber-400 dark:text-amber-300 text-md"></i>
                                        </button>
                                    </div>
                                    <p class="text-gray-400 text-xs">{{ __('trades.current_equity') }}</p>
                                </div>
                            </div>

                            <!-- Risk Metrics Grid -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                                <!-- Risk/Reward Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.rr_ratio') }}
                                    </p>
                                    <p class="text-base font-bold text-amber-400 dark:text-amber-300"
                                        id="riskRewardRatio">-</p>
                                </div>

                                <!-- SL Distance Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                        {{ __('trades.sl_distance') }}</p>
                                    <p class="text-base font-bold text-red-400 dark:text-red-300" id="slPips">-</p>
                                </div>

                                <!-- TP Distance Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                        {{ __('trades.tp_distance') }}</p>
                                    <p class="text-base font-bold text-green-400 dark:text-green-300" id="tpPips">-</p>
                                </div>

                                <!-- Lot Size Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                        {{ __('trades.recommended_lot') }}</p>
                                    <p class="text-base font-bold text-cyan-300" id="positionSize">-</p>
                                </div>
                            </div>

                            <!-- Risk Level Selector -->
                            <div
                                class="bg-gray-200/20 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600 mb-3">
                                <h4 class="text-sm font-semibold text-amber-500 dark:text-amber-300 mb-3">
                                    {{ __('trades.risk_management_level') }}
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <!-- Conservative -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="1" class="hidden" checked>
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-green-500">
                                            <div class="text-green-400 text-base font-bold">1%</div>
                                            <div class="text-green-300 text-xs">{{ __('trades.risk_conservative') }}</div>
                                        </div>
                                    </label>

                                    <!-- Moderate -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="2" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-blue-500">
                                            <div class="text-blue-400 text-base font-bold">2%</div>
                                            <div class="text-blue-300 text-xs">{{ __('trades.risk_moderate') }}</div>
                                        </div>
                                    </label>

                                    <!-- Aggressive -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="3" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-orange-500">
                                            <div class="text-orange-400 text-base font-bold">3%</div>
                                            <div class="text-orange-300 text-xs">{{ __('trades.risk_aggressive') }}</div>
                                        </div>
                                    </label>

                                    <!-- High Risk -->
                                    <label class="block">
                                        <input type="radio" name="risk_percent" value="5" class="hidden">
                                        <div
                                            class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-red-500">
                                            <div class="text-red-400 text-base font-bold">5%</div>
                                            <div class="text-red-300 text-xs">{{ __('trades.risk_high') }}</div>
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
                            {{ __('trades.back_to_list') }}
                        </a>
                        <button type="submit"
                            class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            {{ __('trades.save_trade') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div
                class="mt-6 bg-gradient-to-r from-yellow-50 via-yellow-100 to-yellow-300 dark:bg-gray-800 dark:from-gray-800 dark:to-gray-900 rounded-xl p-4 border border-none dark:border-gray-600">
                <div class="flex items-start">
                    <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-lightbulb text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-amber-600 dark:text-amber-300">
                            {{ __('trades.risk_tips_title') }}</h3>
                        <ul class="mt-2 space-y-1 tex-gray-600 dark:text-gray-400 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                {{ __('trades.tip_equity', ['equity' => number_format($currentEquity, 2)]) }}
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                {{ __('trades.tip_risk_levels') }}
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                {{ __('trades.tip_rr_ratio') }}
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

            const symbolSelect = document.querySelector('select[name="symbol_id"]');
            const selectedOption = symbolSelect ? symbolSelect.options[symbolSelect.selectedIndex] : null;

            // Read data attributes using kebab-case -> dataset camelCase mapping
            const pipValue = selectedOption && (selectedOption.dataset.pipValue || selectedOption.dataset.pip_value) ?
                parseFloat(selectedOption.dataset.pipValue || selectedOption.dataset.pip_value) : 0.0001;
            const pipWorth = selectedOption && (selectedOption.dataset.pipWorth || selectedOption.dataset.pip_worth) ?
                parseFloat(selectedOption.dataset.pipWorth || selectedOption.dataset.pip_worth) : 10;

            if (entry && stopLoss && takeProfit) {
                // FIX: Hindari floating point error dengan pembulatan
                let slDistance, tpDistance;

                if (type === 'buy') {
                    slDistance = Math.abs(parseFloat((entry - stopLoss).toFixed(5)));
                    tpDistance = Math.abs(parseFloat((takeProfit - entry).toFixed(5)));
                } else {
                    slDistance = Math.abs(parseFloat((stopLoss - entry).toFixed(5)));
                    tpDistance = Math.abs(parseFloat((entry - takeProfit).toFixed(5)));
                }

                // FIX: Pembulatan SAMA dengan PHP (1 desimal)
                const slPipsRaw = pipValue > 0 ? slDistance / pipValue : 0;
                const tpPipsRaw = pipValue > 0 ? tpDistance / pipValue : 0;

                // Pembulatan ke 1 desimal seperti di PHP
                const slPips = Math.round(slPipsRaw * 10) / 10;
                const tpPips = Math.round(tpPipsRaw * 10) / 10;

                // Update display
                document.getElementById('slPips').textContent = `${slPips.toFixed(1)} pips`;
                document.getElementById('tpPips').textContent = `${tpPips.toFixed(1)} pips`;

                // Calculate Risk/Reward Ratio
                const ratio = slPips > 0 ? (tpPips / slPips) : 0;
                const ratioDisplay = ratio > 0 ? `1:${ratio.toFixed(2)}` : '-';
                document.getElementById('riskRewardRatio').textContent = ratioDisplay;
                document.getElementById('rr_ratio').value = ratio.toFixed(2);

                // Calculate Position Size
                calculatePositionSize(slPips, pipWorth);

                // DEBUG: Tampilkan nilai aktual
                console.log('FIXED CALCULATION:', {
                    slDistance: slDistance,
                    tpDistance: tpDistance,
                    slPipsRaw: slPipsRaw,
                    slPipsRounded: slPips,
                    pipValue: pipValue,
                    pipWorth: pipWorth
                });

            } else {
                resetRiskCalculator();
            }
        }

        // Calculate Position Size
        function calculatePositionSize(slPips, pipWorth) {
            pipWorth = pipWorth || 10;
            const currentEquity = parseFloat({{ $currentEquity }});
            const selectedRisk = document.querySelector('input[name="risk_percent"]:checked');
            const riskPercent = selectedRisk ? parseFloat(selectedRisk.value) : 2;

            console.log('POSITION SIZE INPUT:', {
                slPips: slPips,
                pipWorth: pipWorth,
                currentEquity: currentEquity,
                riskPercent: riskPercent
            });

            if (slPips > 0 && currentEquity > 0 && pipWorth > 0) {
                const riskUSD = currentEquity * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);

                console.log('LOT SIZE CALCULATION:', {
                    riskUSD: riskUSD,
                    denominator: slPips * pipWorth,
                    rawLotSize: lotSize
                });

                // Minimum lot size 0.01, bulatkan 2 desimal
                const finalLotSize = Math.max(lotSize, 0.01);

                // Tampilkan dengan detail formula
                const positionSizeElement = document.getElementById('positionSize');
                positionSizeElement.textContent = `${finalLotSize.toFixed(2)} lots`;
                positionSizeElement.title =
                    `$${riskUSD.toFixed(2)} / (${slPips.toFixed(1)} × $${pipWorth}) = ${finalLotSize.toFixed(2)} lots`;

                // DEBUG: Tampilkan di console
                console.log('FINAL LOT SIZE:', finalLotSize);

            } else {
                document.getElementById('positionSize').textContent = '-';
                console.log('Position size calculation skipped - missing data');
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

                    // Use currently selected symbol pip value / pip worth instead of hardcoded 0.00010
                    const symbolSelect = document.querySelector('select[name="symbol_id"]');
                    const selOpt = symbolSelect ? symbolSelect.options[symbolSelect.selectedIndex] : null;
                    const pipValueRp = selOpt && (selOpt.dataset.pipValue || selOpt.dataset.pip_value) ?
                        parseFloat(selOpt.dataset.pipValue || selOpt.dataset.pip_value) : 0.0001;
                    const pipWorthRp = selOpt && (selOpt.dataset.pipWorth || selOpt.dataset.pip_worth) ?
                        parseFloat(selOpt.dataset.pipWorth || selOpt.dataset.pip_worth) : 10;

                    const slPips = pipValueRp > 0 ? (slDistance / pipValueRp) : 0;
                    calculatePositionSize(slPips, pipWorthRp);
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

        // Di bagian akhir script create.blade.php, tambahkan:
        document.addEventListener('DOMContentLoaded', function() {
            // Validasi bahwa pipWorth tidak 0
            const symbolSelect = document.querySelector('select[name="symbol_id"]');
            if (symbolSelect) {
                symbolSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const pipWorth = parseFloat(selectedOption.dataset.pipWorth || selectedOption.dataset
                        .pip_worth || 10);

                    if (pipWorth <= 0) {
                        console.warn('Warning: pip_worth is 0 or negative for symbol:', selectedOption
                            .text);
                        // Optionally show user warning
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Button (hanya di Balance)
            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const currentEquityText = document.getElementById('currentEquityText');
            const currentEquity = document.getElementById('currentEquity');
            const currentEquityIcon = document.getElementById('currentEquityIcon');

            // Load state from localStorage
            const isVisible = localStorage.getItem('balanceVisible') === 'true';

            // Apply saved state
            if (isVisible) {
                showValues();
            }

            // Toggle function untuk keduanya
            toggleBalanceBtn.addEventListener('click', function() {
                if (currentEquityText.classList.contains('hidden')) {
                    hideValues();
                } else {
                    showValues();
                }
            });

            // Helper functions
            function showValues() {
                // Show Balance
                currentEquityText.classList.add('hidden');
                currentEquity.classList.remove('hidden');
                currentEquityIcon.classList.remove('fa-eye-slash');
                currentEquityIcon.classList.add('fa-eye');

                // Save state
                localStorage.setItem('balanceVisible', 'true');

                // Update tooltip
                toggleBalanceBtn.title = "{{ __('trades.hide_balance') }}";
            }

            function hideValues() {
                // Hide Balance
                currentEquityText.classList.remove('hidden');
                currentEquity.classList.add('hidden');
                currentEquityIcon.classList.remove('fa-eye');
                currentEquityIcon.classList.add('fa-eye-slash');

                // Save state
                localStorage.setItem('balanceVisible', 'false');

                // Update tooltip
                toggleBalanceBtn.title = "{{ __('trades.show_balance') }}";
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
