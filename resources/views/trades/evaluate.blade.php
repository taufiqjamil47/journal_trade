@extends('Layouts.index')
@section('title', __('trades.evaluate_trade'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('trades.evaluate_trade_title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('trades.step3_description') }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>{{ __('trades.back_to_list') }}</span>
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
                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold relative z-10">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">{{ __('trades.step_entry') }}</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold relative z-10">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">{{ __('trades.step_exit') }}</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-purple-400">{{ __('trades.step_evaluation') }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <!-- Trade Info Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 mb-6">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-purple-900/30 p-3 rounded-xl mr-4">
                                <i class="fas fa-chart-bar text-purple-400 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-purple-300">
                                    {{ __('trades.trade_number', ['id' => $trade->id, 'symbol' => $trade->symbol->name]) }}
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">
                                    {{ __('trades.evaluation_details') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div
                                class="text-xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                ${{ number_format($trade->profit_loss ?? 0, 2) }}
                            </div>
                            <div
                                class="text-sm {{ $trade->hasil == 'win' ? 'text-green-400' : ($trade->hasil == 'loss' ? 'text-red-400' : 'text-gray-400') }} font-medium">
                                {{ strtoupper($trade->hasil ?? 'PENDING') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-4">
                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.type') }}</p>
                            <p class="text-base font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.entry_price') }}</p>
                            <p class="text-base font-bold font-mono text-green-400">{{ format_price($trade->entry) }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.exit_price') }}</p>
                            <p class="text-base font-bold font-mono text-red-400">{{ format_price($trade->exit) ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.lot_size') }}</p>
                            <p class="text-base font-bold text-amber-400">{{ $trade->lot_size ?? '0.00' }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.session') }}</p>
                            <p class="text-base font-bold text-cyan-400">{{ $trade->session }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.rr_ratio') }}</p>
                            <p class="text-base font-bold text-purple-400">{{ $trade->rr ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.stop_loss') }}</p>
                            <p class="text-base font-semibold font-mono text-red-400">{{ format_price($trade->stop_loss) }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.take_profit') }}</p>
                            <p class="text-base font-semibold font-mono text-green-400">
                                {{ format_price($trade->take_profit) }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">{{ __('trades.risk_amount_usd') }}</p>
                            <p class="text-base font-semibold text-blue-400">${{ number_format($trade->risk_usd ?? 0, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-gray-800 rounded-xl border border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-purple-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-area text-purple-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-purple-300">
                                {{ __('trades.analysis_evaluation') }}
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">
                                {{ __('trades.record_learnings') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.saveEvaluation', $trade->id) }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Entry Setup -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-blue-300">
                                    <i class="fas fa-sign-in-alt text-blue-400 mr-3"></i>
                                    {{ __('trades.entry_setup_strategy') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_type" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.entry_type') }}
                                        </label>
                                        <select name="entry_type" id="entry_type"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_entry_type') }}</option>
                                            <option value="Limit Order"
                                                {{ $trade->entry_type == 'Limit Order' ? 'selected' : '' }}>
                                                {{ __('trades.limit_order') }}
                                            </option>
                                            <option value="Market Order"
                                                {{ $trade->entry_type == 'Market Order' ? 'selected' : '' }}>
                                                {{ __('trades.market_order') }}
                                            </option>
                                            <option value="Stop Order"
                                                {{ $trade->entry_type == 'Stop Order' ? 'selected' : '' }}>
                                                {{ __('trades.stop_order') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.follow_trading_rules') }}
                                        </label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="1"
                                                    {{ $trade->follow_rules ? 'checked' : '' }} class="hidden">
                                                <div
                                                    class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-green-500">
                                                    <i class="fas fa-check-circle text-lg text-green-400 mb-1"></i>
                                                    <div class="text-green-400 font-semibold">{{ __('trades.yes') }}</div>
                                                </div>
                                            </label>
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="0"
                                                    {{ !$trade->follow_rules ? 'checked' : '' }} class="hidden">
                                                <div
                                                    class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-red-500">
                                                    <i class="fas fa-times-circle text-lg text-red-400 mb-1"></i>
                                                    <div class="text-red-400 font-semibold">{{ __('trades.no') }}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Market Analysis -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-amber-300">
                                    <i class="fas fa-chart-area text-amber-400 mr-3"></i>
                                    {{ __('trades.market_analysis_context') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="market_condition" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.market_condition_analysis') }}
                                        </label>
                                        <select name="market_condition" id="market_condition"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_market_condition') }}</option>
                                            <option value="Uptrend"
                                                {{ $trade->market_condition == 'Uptrend' ? 'selected' : '' }}>
                                                {{ __('trades.uptrend') }}
                                            </option>
                                            <option value="Downtrend"
                                                {{ $trade->market_condition == 'Downtrend' ? 'selected' : '' }}>
                                                {{ __('trades.downtrend') }}
                                            </option>
                                            <option value="Sideways/Range"
                                                {{ $trade->market_condition == 'Sideways/Range' ? 'selected' : '' }}>
                                                {{ __('trades.sideways_range') }}
                                            </option>
                                            <option value="Breakout"
                                                {{ $trade->market_condition == 'Breakout' ? 'selected' : '' }}>
                                                {{ __('trades.breakout') }}
                                            </option>
                                            <option value="Pullback/Retracement"
                                                {{ $trade->market_condition == 'Pullback/Retracement' ? 'selected' : '' }}>
                                                {{ __('trades.pullback_retracement') }}
                                            </option>
                                            <option value="Consolidation"
                                                {{ $trade->market_condition == 'Consolidation' ? 'selected' : '' }}>
                                                {{ __('trades.consolidation') }}
                                            </option>
                                            <option value="Volatile/Choppy"
                                                {{ $trade->market_condition == 'Volatile/Choppy' ? 'selected' : '' }}>
                                                {{ __('trades.volatile_choppy') }}
                                            </option>
                                            <option value="Reversal"
                                                {{ $trade->market_condition == 'Reversal' ? 'selected' : '' }}>
                                                {{ __('trades.reversal') }}
                                            </option>
                                            <option value="Trend Continuation"
                                                {{ $trade->market_condition == 'Trend Continuation' ? 'selected' : '' }}>
                                                {{ __('trades.trend_continuation') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="entry_reason" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.entry_reasoning_conviction') }}
                                        </label>
                                        <textarea name="entry_reason" id="entry_reason" rows="3"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent resize-none"
                                            placeholder="{{ __('trades.entry_reason_placeholder') }}">{{ $trade->entry_reason }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Management -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-red-300">
                                    <i class="fas fa-shield-alt text-red-400 mr-3"></i>
                                    {{ __('trades.risk_management_review') }}
                                </h3>

                                <div class="space-y-2">
                                    <label for="why_sl_tp" class="block text-sm font-semibold text-gray-300">
                                        {{ __('trades.sl_tp_placement_reasoning') }}
                                    </label>
                                    <textarea name="why_sl_tp" id="why_sl_tp" rows="3"
                                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-transparent resize-none"
                                        placeholder="{{ __('trades.sl_tp_analysis_placeholder') }}">{{ $trade->why_sl_tp }}</textarea>
                                </div>
                            </div>

                            <!-- Exit Timestamp -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-indigo-300">
                                    <i class="fas fa-clock text-indigo-400 mr-3"></i>
                                    {{ __('trades.exit_timestamp') }}
                                </h3>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-2">
                                        <label for="exit_date" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.exit_date') }}
                                        </label>
                                        <input type="date" name="exit_date" id="exit_date"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('Y-m-d') }}">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="exit_time" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.exit_time') }}
                                        </label>
                                        <input type="time" name="exit_time" id="exit_time"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('H:i') }}">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Trading Rules -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-300">
                                    <i class="fas fa-check-double text-green-400 mr-3"></i>
                                    {{ __('trades.trading_rules_checklist') }}
                                </h3>

                                <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
                                    @php
                                        $rulesList = \App\Models\TradingRule::where('is_active', true)
                                            ->orderBy('order')
                                            ->get();

                                        $selectedRules = $trade->rules->pluck('id')->toArray() ?? [];
                                    @endphp

                                    @foreach ($rulesList as $index => $rule)
                                        <label class="flex items-center p-2 hover:bg-gray-700 rounded cursor-pointer">
                                            <input type="checkbox" name="rules[]" value="{{ $rule->id }}"
                                                {{ in_array($rule->id, $selectedRules) ? 'checked' : '' }}
                                                class="mr-3 w-4 h-4 text-green-500 bg-gray-800 border-gray-600 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-300 flex-1">{{ $rule->name }}</span>
                                            @if ($rule->description)
                                                <i class="fas fa-info-circle text-gray-500 ml-2 cursor-help"
                                                    title="{{ $rule->description }}"></i>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Psychology -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-purple-300">
                                    <i class="fas fa-brain text-purple-400 mr-3"></i>
                                    {{ __('trades.trading_psychology') }}
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_emotion" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.entry_emotion') }}
                                        </label>
                                        <select name="entry_emotion" id="entry_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_entry_emotion') }}</option>
                                            <option value="Confident"
                                                {{ $trade->entry_emotion == 'Confident' ? 'selected' : '' }}>
                                                {{ __('trades.confident') }}
                                            </option>
                                            <option value="Fearful"
                                                {{ $trade->entry_emotion == 'Fearful' ? 'selected' : '' }}>
                                                {{ __('trades.fearful') }}
                                            </option>
                                            <option value="Greedy"
                                                {{ $trade->entry_emotion == 'Greedy' ? 'selected' : '' }}>
                                                {{ __('trades.greedy') }}
                                            </option>
                                            <option value="Anxious"
                                                {{ $trade->entry_emotion == 'Anxious' ? 'selected' : '' }}>
                                                {{ __('trades.anxious') }}
                                            </option>
                                            <option value="Hopeful"
                                                {{ $trade->entry_emotion == 'Hopeful' ? 'selected' : '' }}>
                                                {{ __('trades.hopeful') }}
                                            </option>
                                            <option value="Impatient"
                                                {{ $trade->entry_emotion == 'Impatient' ? 'selected' : '' }}>
                                                {{ __('trades.impatient') }}
                                            </option>
                                            <option value="Calm"
                                                {{ $trade->entry_emotion == 'Calm' ? 'selected' : '' }}>
                                                {{ __('trades.calm') }}
                                            </option>
                                            <option value="FOMO"
                                                {{ $trade->entry_emotion == 'FOMO' ? 'selected' : '' }}>
                                                {{ __('trades.fomo') }}
                                            </option>
                                            <option value="Revenge Trading"
                                                {{ $trade->entry_emotion == 'Revenge Trading' ? 'selected' : '' }}>
                                                {{ __('trades.revenge_trading') }}
                                            </option>
                                            <option value="Overconfident"
                                                {{ $trade->entry_emotion == 'Overconfident' ? 'selected' : '' }}>
                                                {{ __('trades.overconfident') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="close_emotion" class="block text-sm font-semibold text-gray-300">
                                            {{ __('trades.close_emotion') }}
                                        </label>
                                        <select name="close_emotion" id="close_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">{{ __('trades.select_close_emotion') }}</option>
                                            <option value="Satisfied"
                                                {{ $trade->close_emotion == 'Satisfied' ? 'selected' : '' }}>
                                                {{ __('trades.satisfied') }}
                                            </option>
                                            <option value="Relieved"
                                                {{ $trade->close_emotion == 'Relieved' ? 'selected' : '' }}>
                                                {{ __('trades.relieved') }}
                                            </option>
                                            <option value="Regretful"
                                                {{ $trade->close_emotion == 'Regretful' ? 'selected' : '' }}>
                                                {{ __('trades.regretful') }}
                                            </option>
                                            <option value="Frustrated"
                                                {{ $trade->close_emotion == 'Frustrated' ? 'selected' : '' }}>
                                                {{ __('trades.frustrated') }}
                                            </option>
                                            <option value="Happy"
                                                {{ $trade->close_emotion == 'Happy' ? 'selected' : '' }}>
                                                {{ __('trades.happy') }}
                                            </option>
                                            <option value="Disappointed"
                                                {{ $trade->close_emotion == 'Disappointed' ? 'selected' : '' }}>
                                                {{ __('trades.disappointed') }}
                                            </option>
                                            <option value="Neutral"
                                                {{ $trade->close_emotion == 'Neutral' ? 'selected' : '' }}>
                                                {{ __('trades.neutral') }}
                                            </option>
                                            <option value="Greedy (Holding too long)"
                                                {{ $trade->close_emotion == 'Greedy (Holding too long)' ? 'selected' : '' }}>
                                                {{ __('trades.greedy_holding_too_long') }}
                                            </option>
                                            <option value="Fearful (Exiting too early)"
                                                {{ $trade->close_emotion == 'Fearful (Exiting too early)' ? 'selected' : '' }}>
                                                {{ __('trades.fearful_exiting_too_early') }}
                                            </option>
                                            <option value="Angry"
                                                {{ $trade->close_emotion == 'Angry' ? 'selected' : '' }}>
                                                {{ __('trades.angry') }}
                                            </option>
                                            <option value="Learning"
                                                {{ $trade->close_emotion == 'Learning' ? 'selected' : '' }}>
                                                {{ __('trades.learning') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-cyan-300">
                                    <i class="fas fa-camera text-cyan-400 mr-3"></i>
                                    {{ __('trades.trade_documentation') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- After Link -->
                                    <div class="space-y-2">
                                        <label for="after_link"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <i class="fas fa-image mr-2 text-primary-400"></i>
                                            {{ __('trades.after_screenshot') }}
                                        </label>
                                        <input type="url" name="after_link" id="after_link"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                            value="{{ $trade->after_link }}"
                                            placeholder="{{ __('trades.after_screenshot_placeholder') }}">
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ __('trades.screenshot_info') }}
                                        </p>
                                    </div>

                                    <!-- Info Box -->
                                    <div class="bg-primary-900/20 border border-primary-600/30 rounded-lg p-3 mt-3">
                                        <p class="text-xs text-primary-300 flex items-start">
                                            <i class="fas fa-info-circle mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>
                                                <strong>{{ __('trades.supported_link_types') }}</strong>
                                                <br>• {{ __('trades.link_tradingview') }}
                                                <br>• {{ __('trades.link_s3_aws') }}
                                                <br>• {{ __('trades.link_direct_image') }}
                                                <br>• {{ __('trades.link_cdn_images') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mt-6 bg-gray-750 rounded-xl p-4 border border-gray-600">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-gray-300">
                            <i class="fas fa-sticky-note text-gray-400 mr-3"></i>
                            {{ __('trades.additional_notes') }}
                        </h3>

                        <div class="space-y-2">
                            <label for="note" class="block text-sm font-semibold text-gray-300">
                                {{ __('trades.additional_notes_learnings') }}
                            </label>

                            <!-- Tombol Generate -->
                            <div class="mb-3">
                                <button type="button" id="generateNoteBtn"
                                    class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center text-sm">
                                    <i class="fas fa-magic mr-2"></i>
                                    {{ __('trades.generate_notes') }}
                                </button>
                                <p class="text-xs text-gray-400 mt-1">{{ __('trades.generate_notes_help') }}</p>
                            </div>

                            <textarea name="note" id="note" rows="4"
                                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent resize-none"
                                placeholder="{{ __('trades.learnings_insight_placeholder') }}">{{ $trade->note }}</textarea>
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
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
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
