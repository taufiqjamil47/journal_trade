@extends('Layouts.index')
@section('title', __('trades.evaluate_trade'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header - Improved contrast -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('trades.evaluate_trade_title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('trades.step3_description') }}</p>
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
                <!-- Step 1 - Completed -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-green-600 dark:bg-green-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-green-500/20">
                        <i class="fas fa-check"></i>
                    </div>
                    <span
                        class="text-sm font-semibold mt-2 text-green-700 dark:text-green-400">{{ __('trades.step_entry') }}</span>
                </div>

                <!-- Connector Line -->
                <div class="w-16 h-0.5 bg-green-300 dark:bg-green-600"></div>

                <!-- Step 2 - Completed -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-green-600 dark:bg-green-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-green-500/20">
                        <i class="fas fa-check"></i>
                    </div>
                    <span
                        class="text-sm font-semibold mt-2 text-green-700 dark:text-green-400">{{ __('trades.step_exit') }}</span>
                </div>

                <!-- Connector Line -->
                <div class="w-16 h-0.5 bg-green-300 dark:bg-green-600"></div>

                <!-- Step 3 - Active -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-purple-600 dark:bg-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-purple-500/20">
                        3
                    </div>
                    <span
                        class="text-sm font-semibold mt-2 text-purple-700 dark:text-purple-400">{{ __('trades.step_evaluation') }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <!-- Trade Info Card - Improved -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 shadow-lg overflow-hidden">
                <!-- Header -->
                <div
                    class="px-6 py-5 bg-gradient-to-r from-purple-50 to-transparent dark:from-purple-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-xl mr-4">
                                <i class="fas fa-chart-bar text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('trades.trade_number', ['id' => $trade->id, 'symbol' => $trade->symbol->name]) }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                    {{ __('trades.evaluation_details') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            @if ($selectedAccount)
                                <span
                                    class="inline-flex items-center px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm font-medium rounded-full border border-purple-200 dark:border-purple-800">
                                    <i class="fas fa-check-circle mr-2 text-purple-500"></i>
                                    {{ __('trades.account') }}: <strong
                                        class="ml-1">{{ $selectedAccount->name }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content - Improved cards -->
                <div class="p-6">
                    <!-- First row - 5 columns -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-4">
                        <!-- Type Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i
                                    class="fas fa-exchange-alt mr-1 {{ $trade->type == 'buy' ? 'text-green-500' : 'text-red-500' }}"></i>
                                {{ __('trades.type') }}
                            </p>
                            <p
                                class="text-lg font-bold {{ $trade->type == 'buy' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <!-- Entry Price Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-sign-in-alt mr-1 text-blue-500"></i>
                                {{ __('trades.entry_price') }}
                            </p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ format_price($trade->entry) }}
                            </p>
                        </div>

                        <!-- Stop Loss Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-shield-alt mr-1 text-red-500"></i>
                                {{ __('trades.stop_loss') }}
                            </p>
                            <p class="text-lg font-semibold text-red-600 dark:text-red-400">
                                {{ format_price($trade->stop_loss) }}</p>
                        </div>

                        <!-- Take Profit Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-flag-checkered mr-1 text-green-500"></i>
                                {{ __('trades.take_profit') }}
                            </p>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-400">
                                {{ format_price($trade->take_profit) }}</p>
                        </div>

                        <!-- Exit Price Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-sign-out-alt mr-1 text-orange-500"></i>
                                {{ __('trades.exit_price') }}
                            </p>
                            <p class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                {{ format_price($trade->exit) ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Second row - 4 columns -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Session Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-clock mr-1 text-cyan-500"></i>
                                {{ __('trades.session') }}
                            </p>
                            <p class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $trade->session }}</p>
                        </div>

                        <!-- Lot Size Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-cubes mr-1 text-amber-500"></i>
                                {{ __('trades.lot_size') }}
                            </p>
                            <p class="text-lg font-bold text-amber-600 dark:text-amber-400">
                                {{ $trade->lot_size ?? '0.00' }}</p>
                        </div>

                        <!-- R:R Ratio Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-balance-scale mr-1 text-purple-500"></i>
                                {{ __('trades.rr_ratio') }}
                            </p>
                            <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $trade->rr ?? '0' }}</p>
                        </div>

                        <!-- Risk Amount Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-dollar-sign mr-1 text-blue-500"></i>
                                {{ __('trades.risk_amount_usd') }}
                            </p>
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                ${{ number_format($trade->risk_usd ?? 0, 2) }}</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm flex gap-3 items-center justify-center">
                            <div
                                class="text-2xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                ${{ number_format($trade->profit_loss ?? 0, 2) }}
                            </div>
                            <div
                                class="text-sm font-medium px-3 py-1 rounded-full inline-block mt-1
                                    {{ $trade->hasil == 'win'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                        : ($trade->hasil == 'loss'
                                            ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                            : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400') }}">
                                {{ strtoupper($trade->hasil ?? 'PENDING') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container - Improved -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <!-- Form Header -->
                <div
                    class="px-6 py-5 bg-gradient-to-r from-purple-50 to-transparent dark:from-purple-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-area text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('trades.analysis_evaluation') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('trades.record_learnings') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.saveEvaluation', $trade->id) }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Entry Setup - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-blue-700 dark:text-blue-400">
                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-sign-in-alt text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    {{ __('trades.entry_setup_strategy') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_type"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-tag mr-2 text-blue-500"></i>
                                            {{ __('trades.entry_type') }}
                                        </label>
                                        <select name="entry_type" id="entry_type"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
                                            <option value="">{{ __('trades.select_entry_type') }}</option>
                                            <option value="Limit Order"
                                                {{ $trade->entry_type == 'Limit Order' ? 'selected' : '' }}>
                                                {{ __('trades.limit_order') }}</option>
                                            <option value="Market Order"
                                                {{ $trade->entry_type == 'Market Order' ? 'selected' : '' }}>
                                                {{ __('trades.market_order') }}</option>
                                            <option value="Stop Order"
                                                {{ $trade->entry_type == 'Stop Order' ? 'selected' : '' }}>
                                                {{ __('trades.stop_order') }}</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                            {{ __('trades.follow_trading_rules') }}
                                        </label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <label class="rule-option cursor-pointer">
                                                <input type="radio" name="follow_rules" value="1"
                                                    {{ $trade->follow_rules ? 'checked' : '' }} class="hidden peer">
                                                <div
                                                    class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all">
                                                    <i class="fas fa-check-circle text-2xl text-green-500 mb-2"></i>
                                                    <div class="font-semibold text-green-700 dark:text-green-400">
                                                        {{ __('trades.yes') }}</div>
                                                </div>
                                            </label>
                                            <label class="rule-option cursor-pointer">
                                                <input type="radio" name="follow_rules" value="0"
                                                    {{ !$trade->follow_rules ? 'checked' : '' }} class="hidden peer">
                                                <div
                                                    class="border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all">
                                                    <i class="fas fa-times-circle text-2xl text-red-500 mb-2"></i>
                                                    <div class="font-semibold text-red-700 dark:text-red-400">
                                                        {{ __('trades.no') }}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Market Analysis - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-amber-700 dark:text-amber-400">
                                    <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-chart-area text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    {{ __('trades.market_analysis_context') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="market_condition"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-chart-line mr-2 text-amber-500"></i>
                                            {{ __('trades.market_condition_analysis') }}
                                        </label>
                                        <select name="market_condition" id="market_condition"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-shadow">
                                            <option value="">{{ __('trades.select_market_condition') }}</option>
                                            <option value="Uptrend"
                                                {{ $trade->market_condition == 'Uptrend' ? 'selected' : '' }}>
                                                {{ __('trades.uptrend') }}</option>
                                            <option value="Downtrend"
                                                {{ $trade->market_condition == 'Downtrend' ? 'selected' : '' }}>
                                                {{ __('trades.downtrend') }}</option>
                                            <option value="Sideways/Range"
                                                {{ $trade->market_condition == 'Sideways/Range' ? 'selected' : '' }}>
                                                {{ __('trades.sideways_range') }}</option>
                                            <option value="Breakout"
                                                {{ $trade->market_condition == 'Breakout' ? 'selected' : '' }}>
                                                {{ __('trades.breakout') }}</option>
                                            <option value="Pullback/Retracement"
                                                {{ $trade->market_condition == 'Pullback/Retracement' ? 'selected' : '' }}>
                                                {{ __('trades.pullback_retracement') }}</option>
                                            <option value="Consolidation"
                                                {{ $trade->market_condition == 'Consolidation' ? 'selected' : '' }}>
                                                {{ __('trades.consolidation') }}</option>
                                            <option value="Volatile/Choppy"
                                                {{ $trade->market_condition == 'Volatile/Choppy' ? 'selected' : '' }}>
                                                {{ __('trades.volatile_choppy') }}</option>
                                            <option value="Reversal"
                                                {{ $trade->market_condition == 'Reversal' ? 'selected' : '' }}>
                                                {{ __('trades.reversal') }}</option>
                                            <option value="Trend Continuation"
                                                {{ $trade->market_condition == 'Trend Continuation' ? 'selected' : '' }}>
                                                {{ __('trades.trend_continuation') }}</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="entry_reason"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-pencil-alt mr-2 text-amber-500"></i>
                                            {{ __('trades.entry_reasoning_conviction') }}
                                        </label>
                                        <textarea name="entry_reason" id="entry_reason" rows="3"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                                            placeholder="{{ __('trades.entry_reason_placeholder') }}">{{ $trade->entry_reason }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Management - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-red-700 dark:text-red-400">
                                    <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-shield-alt text-red-600 dark:text-red-400"></i>
                                    </div>
                                    {{ __('trades.risk_management_review') }}
                                </h3>

                                <div class="space-y-2">
                                    <label for="why_sl_tp"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-question-circle mr-2 text-red-500"></i>
                                        {{ __('trades.sl_tp_placement_reasoning') }}
                                    </label>
                                    <textarea name="why_sl_tp" id="why_sl_tp" rows="3"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                                        placeholder="{{ __('trades.sl_tp_analysis_placeholder') }}">{{ $trade->why_sl_tp }}</textarea>
                                </div>
                            </div>

                            <!-- Exit Timestamp - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-indigo-700 dark:text-indigo-400">
                                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-clock text-indigo-600 dark:text-indigo-400"></i>
                                    </div>
                                    {{ __('trades.exit_timestamp') }}
                                </h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="exit_time"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-clock mr-2 text-indigo-500"></i>
                                            {{ __('trades.exit_time') }}
                                        </label>
                                        <input type="time" name="exit_time" id="exit_time"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('H:i') }}">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="exit_date"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i>
                                            {{ __('trades.exit_date') }}
                                        </label>
                                        <input type="date" name="exit_date" id="exit_date"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Trading Rules - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-700 dark:text-green-400">
                                    <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-check-double text-green-600 dark:text-green-400"></i>
                                    </div>
                                    {{ __('trades.trading_rules_checklist') }}
                                </h3>

                                <div class="space-y-2 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                    @php
                                        $rulesList = \App\Models\TradingRule::where('is_active', true)
                                            ->orderBy('order')
                                            ->get();
                                        $selectedRules = $trade->rules->pluck('id')->toArray() ?? [];
                                    @endphp

                                    @foreach ($rulesList as $index => $rule)
                                        <label
                                            class="flex items-center p-3 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer transition-all">
                                            <input type="checkbox" name="rules[]" value="{{ $rule->id }}"
                                                {{ in_array($rule->id, $selectedRules) ? 'checked' : '' }}
                                                class="mr-3 w-5 h-5 text-green-600 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-500 rounded focus:ring-green-500 focus:ring-2">
                                            <span
                                                class="text-sm text-gray-800 dark:text-gray-200 flex-1 font-medium">{{ $rule->name }}</span>
                                            @if ($rule->description)
                                                <i class="fas fa-info-circle text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 ml-2 cursor-help transition-colors"
                                                    title="{{ $rule->description }}"></i>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Psychology - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-purple-700 dark:text-purple-400">
                                    <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-brain text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    {{ __('trades.trading_psychology') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_emotion"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-smile mr-2 text-purple-500"></i>
                                            {{ __('trades.entry_emotion') }}
                                        </label>
                                        <select name="entry_emotion" id="entry_emotion"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_entry_emotion') }}</option>
                                            <option value="Confident"
                                                {{ $trade->entry_emotion == 'Confident' ? 'selected' : '' }}>
                                                {{ __('trades.confident') }}</option>
                                            <option value="Fearful"
                                                {{ $trade->entry_emotion == 'Fearful' ? 'selected' : '' }}>
                                                {{ __('trades.fearful') }}</option>
                                            <option value="Greedy"
                                                {{ $trade->entry_emotion == 'Greedy' ? 'selected' : '' }}>
                                                {{ __('trades.greedy') }}</option>
                                            <option value="Anxious"
                                                {{ $trade->entry_emotion == 'Anxious' ? 'selected' : '' }}>
                                                {{ __('trades.anxious') }}</option>
                                            <option value="Hopeful"
                                                {{ $trade->entry_emotion == 'Hopeful' ? 'selected' : '' }}>
                                                {{ __('trades.hopeful') }}</option>
                                            <option value="Impatient"
                                                {{ $trade->entry_emotion == 'Impatient' ? 'selected' : '' }}>
                                                {{ __('trades.impatient') }}</option>
                                            <option value="Calm"
                                                {{ $trade->entry_emotion == 'Calm' ? 'selected' : '' }}>
                                                {{ __('trades.calm') }}</option>
                                            <option value="FOMO"
                                                {{ $trade->entry_emotion == 'FOMO' ? 'selected' : '' }}>
                                                {{ __('trades.fomo') }}</option>
                                            <option value="Revenge Trading"
                                                {{ $trade->entry_emotion == 'Revenge Trading' ? 'selected' : '' }}>
                                                {{ __('trades.revenge_trading') }}</option>
                                            <option value="Overconfident"
                                                {{ $trade->entry_emotion == 'Overconfident' ? 'selected' : '' }}>
                                                {{ __('trades.overconfident') }}</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="close_emotion"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-heart mr-2 text-purple-500"></i>
                                            {{ __('trades.close_emotion') }}
                                        </label>
                                        <select name="close_emotion" id="close_emotion"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_close_emotion') }}</option>
                                            <option value="Satisfied"
                                                {{ $trade->close_emotion == 'Satisfied' ? 'selected' : '' }}>
                                                {{ __('trades.satisfied') }}</option>
                                            <option value="Relieved"
                                                {{ $trade->close_emotion == 'Relieved' ? 'selected' : '' }}>
                                                {{ __('trades.relieved') }}</option>
                                            <option value="Regretful"
                                                {{ $trade->close_emotion == 'Regretful' ? 'selected' : '' }}>
                                                {{ __('trades.regretful') }}</option>
                                            <option value="Frustrated"
                                                {{ $trade->close_emotion == 'Frustrated' ? 'selected' : '' }}>
                                                {{ __('trades.frustrated') }}</option>
                                            <option value="Happy"
                                                {{ $trade->close_emotion == 'Happy' ? 'selected' : '' }}>
                                                {{ __('trades.happy') }}</option>
                                            <option value="Disappointed"
                                                {{ $trade->close_emotion == 'Disappointed' ? 'selected' : '' }}>
                                                {{ __('trades.disappointed') }}</option>
                                            <option value="Neutral"
                                                {{ $trade->close_emotion == 'Neutral' ? 'selected' : '' }}>
                                                {{ __('trades.neutral') }}</option>
                                            <option value="Greedy (Holding too long)"
                                                {{ $trade->close_emotion == 'Greedy (Holding too long)' ? 'selected' : '' }}>
                                                {{ __('trades.greedy_holding_too_long') }}</option>
                                            <option value="Fearful (Exiting too early)"
                                                {{ $trade->close_emotion == 'Fearful (Exiting too early)' ? 'selected' : '' }}>
                                                {{ __('trades.fearful_exiting_too_early') }}</option>
                                            <option value="Angry"
                                                {{ $trade->close_emotion == 'Angry' ? 'selected' : '' }}>
                                                {{ __('trades.angry') }}</option>
                                            <option value="Learning"
                                                {{ $trade->close_emotion == 'Learning' ? 'selected' : '' }}>
                                                {{ __('trades.learning') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation - Improved -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-cyan-700 dark:text-cyan-400">
                                    <div class="bg-cyan-100 dark:bg-cyan-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-camera text-cyan-600 dark:text-cyan-400"></i>
                                    </div>
                                    {{ __('trades.trade_documentation') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- After Link -->
                                    <div class="space-y-2">
                                        <label for="after_link"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-image mr-2 text-cyan-500"></i>
                                            {{ __('trades.after_screenshot') }}
                                        </label>
                                        <div class="relative">
                                            <input type="url" name="after_link" id="after_link"
                                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                value="{{ $trade->after_link }}"
                                                placeholder="{{ __('trades.after_screenshot_placeholder') }}">
                                            <span class="absolute right-3 top-2.5 text-sm text-gray-400">
                                                <i class="fas fa-link"></i>
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            {{ __('trades.screenshot_info') }}
                                        </p>
                                    </div>

                                    <!-- Info Box -->
                                    <div
                                        class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-lg p-4 border border-cyan-200 dark:border-cyan-800">
                                        <p class="text-xs text-cyan-800 dark:text-cyan-300 flex items-start">
                                            <i class="fas fa-info-circle mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span class="font-medium">{{ __('trades.supported_link_types') }}:</span>
                                        </p>
                                        <div class="grid grid-cols-2 gap-2 mt-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400"><i
                                                    class="fas fa-check-circle text-green-500 mr-1"></i> TradingView</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400"><i
                                                    class="fas fa-check-circle text-green-500 mr-1"></i> S3/AWS</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400"><i
                                                    class="fas fa-check-circle text-green-500 mr-1"></i> Direct
                                                Image</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400"><i
                                                    class="fas fa-check-circle text-green-500 mr-1"></i> CDN Images</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes - Improved -->
                    <div
                        class="mt-8 bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-gray-700 dark:text-gray-300">
                            <div class="bg-gray-200 dark:bg-gray-700 p-2 rounded-lg mr-3">
                                <i class="fas fa-sticky-note text-gray-600 dark:text-gray-400"></i>
                            </div>
                            {{ __('trades.additional_notes') }}
                        </h3>

                        <div class="space-y-3">
                            <label for="note" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ __('trades.additional_notes_learnings') }}
                            </label>

                            <!-- Tombol Generate -->
                            <div class="flex items-start gap-3">
                                <button type="button" id="generateNoteBtn"
                                    class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-medium py-2.5 px-5 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center text-sm">
                                    <i class="fas fa-magic mr-2"></i>
                                    {{ __('trades.generate_notes') }}
                                </button>
                                <p class="text-xs text-gray-500 dark:text-gray-400 self-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ __('trades.generate_notes_help') }}
                                </p>
                            </div>

                            <textarea name="note" id="note" rows="4"
                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent resize-none"
                                placeholder="{{ __('trades.learnings_insight_placeholder') }}">{{ $trade->note }}</textarea>
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
                            class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-10 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            {{ __('trades.save_evaluation') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .rule-option input:checked+div {
            border-color: currentColor;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Simple scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 5px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }
    </style>

    <style>
        /* Custom scrollbar untuk rules checklist */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Styling untuk radio buttons */
        .rule-option input:checked+div {
            border-color: currentColor;
        }

        /* Animasi untuk generate button */
        #generateNoteBtn {
            transition: all 0.3s ease;
        }

        #generateNoteBtn:hover {
            transform: translateY(-1px);
        }

        #generateNoteBtn:active {
            transform: translateY(0);
        }

        /* Dark mode untuk date/time inputs */
        .dark input[type="time"]::-webkit-calendar-picker-indicator,
        .dark input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.6;
        }

        .dark input[type="time"]::-webkit-calendar-picker-indicator:hover,
        .dark input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        /* Smooth transitions */
        input,
        select,
        textarea,
        button,
        a,
        .border-2 {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <script>
        // Basic form functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // Initial resize
                setTimeout(() => {
                    textarea.style.height = 'auto';
                    textarea.style.height = (textarea.scrollHeight) + 'px';
                }, 100);
            });

            // Simple form submission feedback
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                submitButton.innerHTML =
                    '<i class="fas fa-spinner animate-spin mr-2"></i>{{ __('trades.saving') }}';
                submitButton.disabled = true;

                // Allow normal submission
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - check generate button');

            // Cek apakah tombol ada
            const generateBtn = document.getElementById('generateNoteBtn');
            console.log('Generate button found:', generateBtn);

            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // Initial resize
                setTimeout(() => {
                    textarea.style.height = 'auto';
                    textarea.style.height = (textarea.scrollHeight) + 'px';
                }, 100);
            });

            // Fungsi untuk generate catatan otomatis yang ringkas dan natural
            function generateNote() {
                console.log('Generate button clicked!');

                try {
                    // Ambil semua nilai dari form
                    const entryType = document.getElementById('entry_type')?.value || '';
                    const marketCondition = document.getElementById('market_condition')?.value || '';
                    const entryReason = document.getElementById('entry_reason')?.value || '';
                    const whySlTp = document.getElementById('why_sl_tp')?.value || '';
                    const entryEmotion = document.getElementById('entry_emotion')?.value || '';
                    const closeEmotion = document.getElementById('close_emotion')?.value || '';

                    // Debug: lihat nilai yang diambil
                    console.log('Entry Type:', entryType);
                    console.log('Market Condition:', marketCondition);
                    console.log('Entry Emotion:', entryEmotion);

                    // Check follow rules
                    const followRulesElement = document.querySelector('input[name="follow_rules"]:checked');
                    const followRules = followRulesElement ? followRulesElement.value : '';
                    console.log('Follow Rules:', followRules);

                    // Ambil trading rules yang dipilih (hitung jumlahnya)
                    const selectedRules = document.querySelectorAll('input[name="rules[]"]:checked');
                    const selectedRulesCount = selectedRules.length;
                    console.log('Selected rules count:', selectedRulesCount);

                    // Pindahkan teks translation ke variable JavaScript
                    const translations = {
                        // Part 1: Konteks Trading
                        generated_note_part1: "{{ __('trades.generated_note_part1', ['entry_type' => ':entry_type', 'market_condition' => ':market_condition']) }}",

                        // Part 2: Psikologi Entry
                        generated_note_part2_confident: "{{ __('trades.generated_note_part2_confident', ['entry_emotion' => ':entry_emotion', 'entry_reason' => ':entry_reason']) }}",
                        generated_note_part2_fearful: "{{ __('trades.generated_note_part2_fearful', ['entry_emotion' => ':entry_emotion', 'entry_reason' => ':entry_reason']) }}",
                        generated_note_part2_fomo: "{{ __('trades.generated_note_part2_fomo', ['entry_emotion' => ':entry_emotion', 'entry_reason' => ':entry_reason']) }}",
                        generated_note_part2_generic: "{{ __('trades.generated_note_part2_generic', ['entry_emotion' => ':entry_emotion', 'entry_reason' => ':entry_reason']) }}",

                        // Part 3-8
                        generated_note_part3: "{{ __('trades.generated_note_part3') }}",
                        generated_note_part4_follow: "{{ __('trades.generated_note_part4_follow', ['count' => ':count']) }}",
                        generated_note_part4_not_follow: "{{ __('trades.generated_note_part4_not_follow') }}",
                        generated_note_part5: "{{ __('trades.generated_note_part5', ['close_emotion' => ':close_emotion']) }}",
                        generated_note_part6_win_follow: "{{ __('trades.generated_note_part6_win_follow') }}",
                        generated_note_part6_win_not_follow: "{{ __('trades.generated_note_part6_win_not_follow') }}",
                        generated_note_part6_good_psychology: "{{ __('trades.generated_note_part6_good_psychology') }}",
                        generated_note_part6_loss_negative_emotion: "{{ __('trades.generated_note_part6_loss_negative_emotion') }}",
                        generated_note_part6_loss_not_follow: "{{ __('trades.generated_note_part6_loss_not_follow') }}",
                        generated_note_part6_loss_learning: "{{ __('trades.generated_note_part6_loss_learning') }}",
                        generated_note_learnings: "{{ __('trades.generated_note_learnings') }}",
                        insight_avoid_negative_emotion: "{{ __('trades.insight_avoid_negative_emotion') }}",
                        insight_maintain_stable_psychology: "{{ __('trades.insight_maintain_stable_psychology') }}",
                        insight_discipline_consistency: "{{ __('trades.insight_discipline_consistency') }}",
                        insight_improve_discipline: "{{ __('trades.insight_improve_discipline') }}",
                        insight_trading_with_trend: "{{ __('trades.insight_trading_with_trend') }}",
                        insight_extra_caution_volatile: "{{ __('trades.insight_extra_caution_volatile') }}",
                        insight_further_evaluation: "{{ __('trades.insight_further_evaluation') }}",
                        action_focus_trading_plan: "{{ __('trades.action_focus_trading_plan') }}",
                        action_maintain_consistency: "{{ __('trades.action_maintain_consistency') }}",
                        fill_fields_to_generate: "{{ __('trades.fill_fields_to_generate') }}"
                    };

                    // Fungsi helper untuk mengganti placeholder
                    function replacePlaceholders(text, replacements) {
                        let result = text;
                        for (const [key, value] of Object.entries(replacements)) {
                            result = result.replace(`:${key}`, value);
                        }
                        return result;
                    }

                    // Bangun kalimat natural berdasarkan kondisi
                    let note = "";

                    // Bagian 1: Konteks Trading
                    if (entryType && marketCondition) {
                        note += replacePlaceholders(translations.generated_note_part1, {
                            entry_type: entryType.toLowerCase(),
                            market_condition: marketCondition.toLowerCase()
                        }) + " ";
                    }

                    // Bagian 2: Psikologi dan Alasan Entry
                    if (entryEmotion && entryReason) {
                        let entryText;
                        if (entryEmotion.includes('Confident') || entryEmotion.includes('Calm')) {
                            entryText = replacePlaceholders(translations.generated_note_part2_confident, {
                                entry_emotion: entryEmotion.toLowerCase(),
                                entry_reason: entryReason.toLowerCase()
                            });
                        } else if (entryEmotion.includes('Fear') || entryEmotion.includes('Anxious')) {
                            entryText = replacePlaceholders(translations.generated_note_part2_fearful, {
                                entry_emotion: entryEmotion.toLowerCase(),
                                entry_reason: entryReason.toLowerCase()
                            });
                        } else if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            entryText = replacePlaceholders(translations.generated_note_part2_fomo, {
                                entry_emotion: entryEmotion.toLowerCase(),
                                entry_reason: entryReason.toLowerCase()
                            });
                        } else {
                            entryText = replacePlaceholders(translations.generated_note_part2_generic, {
                                entry_emotion: entryEmotion.toLowerCase(),
                                entry_reason: entryReason.toLowerCase()
                            });
                        }
                        note += entryText + " ";
                    }

                    // Bagian 3: Risk Management
                    if (whySlTp) {
                        // Potong teks jika terlalu panjang
                        const shortWhySlTp = whySlTp.length > 100 ? whySlTp.substring(0, 100) + '...' : whySlTp;
                        note += translations.generated_note_part3 + " " + shortWhySlTp.toLowerCase() + " ";
                    }

                    // Bagian 4: Disiplin Trading Rules
                    if (followRules === '1') {
                        note += replacePlaceholders(translations.generated_note_part4_follow, {
                            count: selectedRulesCount
                        }) + " ";
                    } else if (followRules === '0') {
                        note += translations.generated_note_part4_not_follow + " ";
                    }

                    // Bagian 5: Psikologi Exit dan Pembelajaran
                    if (closeEmotion) {
                        note += replacePlaceholders(translations.generated_note_part5, {
                            close_emotion: closeEmotion.toLowerCase()
                        }) + " ";
                    }

                    // Bagian 6: Insight berdasarkan hasil (jika ada)
                    const tradeResult = "{{ $trade->hasil }}"; // Ini akan dari server

                    if (tradeResult === 'win') {
                        if (followRules === '1') {
                            note += translations.generated_note_part6_win_follow + " ";
                        } else {
                            note += translations.generated_note_part6_win_not_follow + " ";
                        }

                        if (entryEmotion.includes('Calm') || entryEmotion.includes('Confident')) {
                            note += translations.generated_note_part6_good_psychology + " ";
                        }
                    } else if (tradeResult === 'loss') {
                        if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            note += translations.generated_note_part6_loss_negative_emotion + " ";
                        } else if (followRules === '0') {
                            note += translations.generated_note_part6_loss_not_follow + " ";
                        } else {
                            note += translations.generated_note_part6_loss_learning + " ";
                        }
                    }

                    // Bagian 7: Actionable insight
                    if (note.length > 0) {
                        note += "\n\n" + translations.generated_note_learnings + " ";

                        const insights = [];

                        // Insight berdasarkan psikologi entry
                        if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            insights.push(translations.insight_avoid_negative_emotion);
                        } else if (entryEmotion.includes('Calm') || entryEmotion.includes('Confident')) {
                            insights.push(translations.insight_maintain_stable_psychology);
                        }

                        // Insight berdasarkan follow rules
                        if (followRules === '1' && selectedRulesCount > 3) {
                            insights.push(translations.insight_discipline_consistency);
                        } else if (followRules === '0') {
                            insights.push(translations.insight_improve_discipline);
                        }

                        // Insight berdasarkan market condition
                        if (marketCondition.includes('Trend')) {
                            insights.push(translations.insight_trading_with_trend);
                        } else if (marketCondition.includes('Volatile') || marketCondition.includes('Choppy')) {
                            insights.push(translations.insight_extra_caution_volatile);
                        }

                        // Gabungkan insights
                        if (insights.length > 0) {
                            note += insights.join(", ") + ".";
                        } else {
                            note += translations.insight_further_evaluation + ".";
                        }

                        // Bagian 8: Action untuk next trade
                        if (followRules === '0' || entryEmotion.includes('FOMO') || entryEmotion.includes(
                                'Revenge')) {
                            note += `\n\n${translations.action_focus_trading_plan}`;
                        } else {
                            note += `\n\n${translations.action_maintain_consistency}`;
                        }
                    } else {
                        note = translations.fill_fields_to_generate;
                    }

                    // Masukkan ke textarea
                    const noteTextarea = document.getElementById('note');
                    if (noteTextarea) {
                        noteTextarea.value = note.trim();
                        console.log('Note generated:', note);

                        // Auto-resize textarea
                        noteTextarea.style.height = 'auto';
                        noteTextarea.style.height = (noteTextarea.scrollHeight) + 'px';

                        // Show success message
                        const button = document.getElementById('generateNoteBtn');
                        if (button) {
                            const originalHTML = button.innerHTML;
                            button.innerHTML =
                                '<i class="fas fa-check mr-2"></i>{{ __('trades.notes_generated') }}';
                            button.classList.remove('bg-amber-600', 'hover:bg-amber-700');
                            button.classList.add('bg-green-600', 'hover:bg-green-700');

                            setTimeout(() => {
                                button.innerHTML = originalHTML;
                                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                                button.classList.add('bg-amber-600', 'hover:bg-amber-700');
                            }, 2000);
                        }
                    }

                } catch (error) {
                    console.error('Error generating note:', error);
                    alert('{{ __('trades.generate_error') }}');
                }
            }

            // Event listener untuk tombol generate
            if (generateBtn) {
                generateBtn.addEventListener('click', generateNote);
                console.log('Event listener attached to generate button');
            } else {
                console.error('Generate button not found!');
            }

            // Simple form submission feedback
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML =
                            '<i class="fas fa-spinner animate-spin mr-2"></i>{{ __('trades.saving') }}';
                        submitButton.disabled = true;
                    }
                });
            }
        });

        // CSS untuk animasi spinner
        const style = document.createElement('style');
        style.textContent = `
                .animate-spin {
                    animation: spin 1s linear infinite;
                }
                
                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
                
                #generateNoteBtn {
                    transition: all 0.3s ease;
                }
                
                #generateNoteBtn:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
                }
                
                #generateNoteBtn:active {
                    transform: translateY(0);
                }
            `;
        document.head.appendChild(style);
    </script>
@endsection
