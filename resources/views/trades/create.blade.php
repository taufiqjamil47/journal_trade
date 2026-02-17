@extends('Layouts.index')
@section('title', __('trades.new_trade'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header - Improved contrast -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('trades.add_new_trade') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('trades.step1_description') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all shadow-sm">
                        <i class="fas fa-arrow-left text-primary-500 dark:text-primary-400 mr-2"></i>
                        <span>{{ __('trades.back_to_list') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps - Improved -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6 shadow-sm">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 - Active -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-600 dark:bg-primary-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-primary-500/20">
                        1
                    </div>
                    <span
                        class="text-sm font-semibold mt-2 text-primary-700 dark:text-primary-400">{{ __('trades.step_entry') }}</span>
                </div>

                <!-- Connector Line -->
                <div class="w-16 h-0.5 bg-gray-300 dark:bg-gray-600"></div>

                <!-- Step 2 - Upcoming -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-lg border-2 border-gray-300 dark:border-gray-600">
                        2
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-gray-500 dark:text-gray-400">{{ __('trades.step_exit') }}</span>
                </div>

                <!-- Connector Line -->
                <div class="w-16 h-0.5 bg-gray-300 dark:bg-gray-600"></div>

                <!-- Step 3 - Upcoming -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-lg border-2 border-gray-300 dark:border-gray-600">
                        3
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-gray-500 dark:text-gray-400">{{ __('trades.step_evaluation') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <!-- Form Header - Improved -->
                <div
                    class="px-6 py-5 bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-xl mr-4">
                                <i class="fas fa-plus-circle text-primary-600 dark:text-primary-400 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('trades.trade_details') }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                    {{ __('trades.fill_info_correctly') }}
                                </p>
                            </div>
                        </div>
                        @if ($selectedAccount)
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm font-medium rounded-full border border-primary-200 dark:border-primary-800">
                                <i class="fas fa-check-circle mr-2 text-primary-500"></i>
                                {{ __('trades.account') }}: <strong class="ml-1">{{ $selectedAccount->name }}</strong>
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-full border border-red-200 dark:border-red-800">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ __('trades.no_account_selected') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Symbol Selection -->
                            <div class="space-y-2">
                                <label for="symbol_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-chart-line mr-2 text-primary-500"></i>
                                    {{ __('trades.symbol_pair') }}
                                </label>
                                <select name="symbol_id"
                                    class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                                    @foreach ($symbols as $symbol)
                                        <option value="{{ $symbol->id }}"
                                            data-pip-value="{{ $symbol->formatted_pip_value }}"
                                            data-pip-worth="{{ $symbol->formatted_pip_worth }}"
                                            data-pip-position="{{ $symbol->pip_position ?? '' }}"
                                            class="bg-white dark:bg-gray-700">
                                            {{ $symbol->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trade Type -->
                            <div class="space-y-2">
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-exchange-alt mr-2 text-primary-500"></i>
                                    {{ __('trades.trade_type') }}
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="relative">
                                        <input type="radio" name="type" value="buy" id="tradeTypeBuy"
                                            class="hidden peer" checked>
                                        <div
                                            class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all">
                                            <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                                            <span
                                                class="font-medium text-gray-900 dark:text-white">{{ __('trades.type_buy') }}</span>
                                        </div>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="type" value="sell" id="tradeTypeSell"
                                            class="hidden peer">
                                        <div
                                            class="flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all">
                                            <i class="fas fa-arrow-down text-red-500 mr-2"></i>
                                            <span
                                                class="font-medium text-gray-900 dark:text-white">{{ __('trades.type_sell') }}</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Timestamp & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="timestamp"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-clock mr-2 text-primary-500"></i>
                                        {{ __('trades.entry_time') }}
                                    </label>
                                    <input type="time" name="timestamp"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>

                                <div class="space-y-2">
                                    <label for="date"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-calendar-alt mr-2 text-primary-500"></i>
                                        {{ __('trades.trade_date') }}
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Entry Price -->
                            <div class="space-y-2">
                                <label for="entry" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i>
                                    {{ __('trades.entry_price') }}
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.00001" name="entry" id="entryPrice"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="0.00000" required>
                                    <span class="absolute right-3 top-2.5 text-sm text-gray-400">USD</span>
                                </div>
                            </div>

                            <!-- Stop Loss & Take Profit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="stop_loss"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-shield-alt mr-2 text-red-500"></i>
                                        {{ __('trades.stop_loss') }}
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="0.00001" name="stop_loss" id="stopLoss"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                            placeholder="0.00000" required>
                                        <span class="absolute right-3 top-2.5 text-sm text-gray-400">USD</span>
                                    </div>
                                    <input type="hidden" name="rr_ratio" id="rr_ratio" value="0">
                                </div>

                                <div class="space-y-2">
                                    <label for="take_profit"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-flag-checkered mr-2 text-green-500"></i>
                                        {{ __('trades.take_profit') }}
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="0.00001" name="take_profit"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                            placeholder="0.00000" required>
                                        <span class="absolute right-3 top-2.5 text-sm text-gray-400">USD</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Before Screenshot -->
                            <div class="space-y-2">
                                <label for="before_link"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-camera mr-2 text-purple-500"></i>
                                    {{ __('trades.before_screenshot') }}
                                </label>
                                <div class="relative">
                                    <input type="url" name="before_link" id="before_link"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        placeholder="https://example.com/screenshot.jpg">
                                    <span class="absolute right-3 top-2.5 text-sm text-gray-400">
                                        <i class="fas fa-link"></i>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ __('trades.screenshot_info') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Calculator - Improved -->
                    <div class="mt-8">
                        <div
                            class="rounded-xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-lg mr-4">
                                        <i class="fas fa-calculator text-amber-600 dark:text-amber-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ __('trades.risk_calculator') }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ __('trades.live_calculation') }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="text-right bg-white dark:bg-gray-700 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('trades.equity') }}:</span>
                                        <h3 id="currentEquityText"
                                            class="text-lg font-bold text-amber-600 dark:text-amber-400">******</h3>
                                        <h3 id="currentEquity"
                                            class="text-lg font-bold text-amber-600 dark:text-amber-400 hidden">
                                            ${{ number_format($currentEquity, 2) }}
                                        </h3>
                                        <button id="toggleBalance" type="button"
                                            class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                            title="{{ __('trades.show_hide_balance') }}">
                                            <i id="currentEquityIcon"
                                                class="fas fa-eye-slash text-amber-600 dark:text-amber-400 text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Metrics Grid -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <!-- Risk/Reward Card -->
                                <div
                                    class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                        <i class="fas fa-balance-scale mr-1 text-amber-500"></i>
                                        {{ __('trades.rr_ratio') }}
                                    </p>
                                    <p class="text-xl font-bold text-amber-600 dark:text-amber-400" id="riskRewardRatio">-
                                    </p>
                                </div>

                                <!-- SL Distance Card -->
                                <div
                                    class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                        <i class="fas fa-arrow-down mr-1 text-red-500"></i>
                                        {{ __('trades.sl_distance') }}
                                    </p>
                                    <p class="text-xl font-bold text-red-600 dark:text-red-400" id="slPips">-</p>
                                </div>

                                <!-- TP Distance Card -->
                                <div
                                    class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                        <i class="fas fa-arrow-up mr-1 text-green-500"></i>
                                        {{ __('trades.tp_distance') }}
                                    </p>
                                    <p class="text-xl font-bold text-green-600 dark:text-green-400" id="tpPips">-</p>
                                </div>

                                <!-- Lot Size Card -->
                                <div
                                    class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                        <i class="fas fa-chart-pie mr-1 text-cyan-500"></i>
                                        {{ __('trades.recommended_lot') }}
                                    </p>
                                    <p class="text-xl font-bold text-cyan-600 dark:text-cyan-400" id="positionSize">-</p>
                                </div>
                            </div>

                            <!-- Risk Level Selector -->
                            <div
                                class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                                    <i class="fas fa-shield-alt mr-2 text-amber-500"></i>
                                    {{ __('trades.risk_management_level') }}
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <!-- Conservative -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="risk_percent" value="1" class="hidden peer"
                                            checked>
                                        <div
                                            class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 group-hover:border-green-400 transition-all">
                                            <div class="text-lg font-bold text-green-600 dark:text-green-400">1%</div>
                                            <div class="text-xs text-green-600 dark:text-green-500 mt-1">
                                                {{ __('trades.risk_conservative') }}</div>
                                        </div>
                                    </label>

                                    <!-- Moderate -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="risk_percent" value="2" class="hidden peer">
                                        <div
                                            class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 group-hover:border-blue-400 transition-all">
                                            <div class="text-lg font-bold text-blue-600 dark:text-blue-400">2%</div>
                                            <div class="text-xs text-blue-600 dark:text-blue-500 mt-1">
                                                {{ __('trades.risk_moderate') }}</div>
                                        </div>
                                    </label>

                                    <!-- Aggressive -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="risk_percent" value="3" class="hidden peer">
                                        <div
                                            class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/20 group-hover:border-orange-400 transition-all">
                                            <div class="text-lg font-bold text-orange-600 dark:text-orange-400">3%</div>
                                            <div class="text-xs text-orange-600 dark:text-orange-500 mt-1">
                                                {{ __('trades.risk_aggressive') }}</div>
                                        </div>
                                    </label>

                                    <!-- High Risk -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="risk_percent" value="5" class="hidden peer">
                                        <div
                                            class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 group-hover:border-red-400 transition-all">
                                            <div class="text-lg font-bold text-red-600 dark:text-red-400">5%</div>
                                            <div class="text-xs text-red-600 dark:text-red-500 mt-1">
                                                {{ __('trades.risk_high') }}</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions - Improved -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-4 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
                            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                            <span>{{ __('trades.back_to_list') }}</span>
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-10 rounded-lg transition-all shadow-lg hover:shadow-xl flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            {{ __('trades.save_trade') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Section - Improved -->
            <div
                class="mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800/80 rounded-xl p-6 border border-blue-200 dark:border-blue-900/30 shadow-sm">
                <div class="flex items-start">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg mr-4">
                        <i class="fas fa-lightbulb text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <span
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ __('trades.risk_tips_title') }}</span>
                        </h3>
                        <ul class="space-y-2 text-gray-700 dark:text-gray-300 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-blue-500"></i>
                                <span>{{ __('trades.tip_equity', ['equity' => number_format($currentEquity, 2)]) }}</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-blue-500"></i>
                                <span>{{ __('trades.tip_risk_levels') }}</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-blue-500"></i>
                                <span>{{ __('trades.tip_rr_ratio') }}</span>
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

            // Get selected trade type from radio buttons
            const type = document.querySelector('input[name="type"]:checked')?.value || 'buy';

            const symbolSelect = document.querySelector('select[name="symbol_id"]');
            const selectedOption = symbolSelect ? symbolSelect.options[symbolSelect.selectedIndex] : null;

            // Read data attributes using kebab-case -> dataset camelCase mapping
            const pipValue = selectedOption && (selectedOption.dataset.pipValue || selectedOption.dataset.pip_value) ?
                parseFloat(selectedOption.dataset.pipValue || selectedOption.dataset.pip_value) : 0.0001;
            const pipWorth = selectedOption && (selectedOption.dataset.pipWorth || selectedOption.dataset.pip_worth) ?
                parseFloat(selectedOption.dataset.pipWorth || selectedOption.dataset.pip_worth) : 10;

            if (entry && stopLoss && takeProfit) {
                let slDistance, tpDistance;

                if (type === 'buy') {
                    slDistance = Math.abs(parseFloat((entry - stopLoss).toFixed(5)));
                    tpDistance = Math.abs(parseFloat((takeProfit - entry).toFixed(5)));
                } else {
                    slDistance = Math.abs(parseFloat((stopLoss - entry).toFixed(5)));
                    tpDistance = Math.abs(parseFloat((entry - takeProfit).toFixed(5)));
                }

                const slPipsRaw = pipValue > 0 ? slDistance / pipValue : 0;
                const tpPipsRaw = pipValue > 0 ? tpDistance / pipValue : 0;

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

            if (slPips > 0 && currentEquity > 0 && pipWorth > 0) {
                const riskUSD = currentEquity * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);
                const finalLotSize = Math.max(lotSize, 0.01);

                const positionSizeElement = document.getElementById('positionSize');
                positionSizeElement.textContent = `${finalLotSize.toFixed(2)} lots`;
                positionSizeElement.title =
                    `$${riskUSD.toFixed(2)} / (${slPips.toFixed(1)} × $${pipWorth}) = ${finalLotSize.toFixed(2)} lots`;
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

        // Auto determine trade type based on entry and stop loss
        function autoDetermineTradeType() {
            const entry = parseFloat(document.getElementById('entryPrice').value) || 0;
            const stopLoss = parseFloat(document.getElementById('stopLoss').value) || 0;

            if (entry > 0 && stopLoss > 0) {
                if (entry < stopLoss) {
                    document.querySelector('input[name="type"][value="sell"]').checked = true;
                } else if (entry > stopLoss) {
                    document.querySelector('input[name="type"][value="buy"]').checked = true;
                }
                calculateRisk();
            }
        }

        // Add event listeners
        document.getElementById('entryPrice')?.addEventListener('input', autoDetermineTradeType);
        document.getElementById('stopLoss')?.addEventListener('input', autoDetermineTradeType);

        document.querySelector('input[name="take_profit"]')?.addEventListener('input', calculateRisk);

        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', calculateRisk);
        });

        // Symbol change listener
        const symbolSelectEl = document.querySelector('select[name="symbol_id"]');
        if (symbolSelectEl) {
            symbolSelectEl.addEventListener('change', calculateRisk);
        }

        // Risk percent change listener
        document.querySelectorAll('input[name="risk_percent"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const slPipsText = document.getElementById('slPips').textContent;
                if (slPipsText !== '-') {
                    const slPips = parseFloat(slPipsText);
                    const symbolSelect = document.querySelector('select[name="symbol_id"]');
                    const selOpt = symbolSelect ? symbolSelect.options[symbolSelect.selectedIndex] : null;
                    const pipWorth = selOpt && (selOpt.dataset.pipWorth || selOpt.dataset.pip_worth) ?
                        parseFloat(selOpt.dataset.pipWorth || selOpt.dataset.pip_worth) : 10;
                    calculatePositionSize(slPips, pipWorth);
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

        // Balance toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const currentEquityText = document.getElementById('currentEquityText');
            const currentEquity = document.getElementById('currentEquity');
            const currentEquityIcon = document.getElementById('currentEquityIcon');

            const isVisible = localStorage.getItem('balanceVisible') === 'true';

            if (isVisible) {
                showValues();
            }

            toggleBalanceBtn.addEventListener('click', function() {
                if (currentEquityText.classList.contains('hidden')) {
                    hideValues();
                } else {
                    showValues();
                }
            });

            function showValues() {
                currentEquityText.classList.add('hidden');
                currentEquity.classList.remove('hidden');
                currentEquityIcon.classList.remove('fa-eye-slash');
                currentEquityIcon.classList.add('fa-eye');
                localStorage.setItem('balanceVisible', 'true');
                toggleBalanceBtn.title = "{{ __('trades.hide_balance') }}";
            }

            function hideValues() {
                currentEquityText.classList.remove('hidden');
                currentEquity.classList.add('hidden');
                currentEquityIcon.classList.remove('fa-eye');
                currentEquityIcon.classList.add('fa-eye-slash');
                localStorage.setItem('balanceVisible', 'false');
                toggleBalanceBtn.title = "{{ __('trades.show_balance') }}";
            }
        });
    </script>

    <style>
        /* Custom styles for better contrast */
        .dark input[type="date"]::-webkit-calendar-picker-indicator,
        .dark input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.6;
        }

        .dark input[type="date"]::-webkit-calendar-picker-indicator:hover,
        .dark input[type="time"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        /* Smooth transitions */
        input,
        select,
        button,
        a {
            transition: all 0.2s ease-in-out;
        }

        /* Custom scrollbar for selects */
        select option {
            padding: 8px;
        }
    </style>
@endsection
