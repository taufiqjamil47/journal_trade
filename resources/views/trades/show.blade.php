@extends('Layouts.index')
@section('title', __('trades.trade_detail_title', ['id' => $trade->id]))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header - Improved contrast -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('trades.trade_detail') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('trades.detail_for_trade', ['id' => $trade->id]) }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @php
                        $backPage = request()->query('page', 1);
                    @endphp
                    <a href="{{ route('trades.index', ['page' => $backPage]) }}"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all shadow-sm">
                        <i class="fas fa-arrow-left text-primary-500 dark:text-primary-400 mr-2"></i>
                        <span>{{ __('trades.back_to_list') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Trade Information Cards - Improved -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Basic Info Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <div
                    class="px-6 py-4 bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-info-circle text-primary-600 dark:text-primary-400"></i>
                        </div>
                        {{ __('trades.basic_information') }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('trades.trade_id') }}</span>
                        <span
                            class="font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">#{{ $trade->id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('trades.symbol') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $trade->symbol->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('trades.type') }}</span>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800' }}">
                            {{ strtoupper($trade->type) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('trades.session') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $trade->session }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('trades.timestamp') }}</span>
                        <span
                            class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Price Levels Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <div
                    class="px-6 py-4 bg-gradient-to-r from-blue-50 to-transparent dark:from-blue-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-line text-blue-600 dark:text-blue-400"></i>
                        </div>
                        {{ __('trades.price_levels') }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                            <i class="fas fa-sign-in-alt text-blue-500 mr-2 text-sm"></i>
                            {{ __('trades.entry_price') }}
                        </span>
                        <span
                            class="font-mono font-bold text-lg text-blue-600 dark:text-blue-400">{{ format_price($trade->entry) }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                            <i class="fas fa-shield-alt text-red-500 mr-2 text-sm"></i>
                            {{ __('trades.stop_loss') }}
                        </span>
                        <span
                            class="font-mono font-bold text-lg text-red-600 dark:text-red-400">{{ format_price($trade->stop_loss) }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                            <i class="fas fa-flag-checkered text-green-500 mr-2 text-sm"></i>
                            {{ __('trades.take_profit') }}
                        </span>
                        <span
                            class="font-mono font-bold text-lg text-green-600 dark:text-green-400">{{ format_price($trade->take_profit) }}</span>
                    </div>

                    @if ($trade->exit)
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                <i class="fas fa-sign-out-alt text-orange-500 mr-2 text-sm"></i>
                                {{ __('trades.exit_price') }}
                            </span>
                            <span
                                class="font-mono font-bold text-lg text-orange-600 dark:text-orange-400">{{ format_price($trade->exit) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Result Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <div
                    class="px-6 py-4 bg-gradient-to-r from-purple-50 to-transparent dark:from-purple-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-trophy text-purple-600 dark:text-purple-400"></i>
                        </div>
                        {{ __('trades.trade_result') }}
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 text-base">{{ __('trades.status') }}</span>
                        @if ($trade->hasil)
                            <span
                                class="px-4 py-2 rounded-full text-base font-semibold {{ $trade->hasil == 'win' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800' }}">
                                {{ strtoupper($trade->hasil) }}
                            </span>
                        @else
                            <span
                                class="px-4 py-2 rounded-full text-base font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                {{ __('trades.pending') }}
                            </span>
                        @endif
                    </div>

                    <div class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <span
                            class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.profit_loss') }}</span>
                        <p
                            class="text-3xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            ${{ number_format($trade->profit_loss ?? 0, 2) }}
                        </p>
                    </div>

                    @if ($trade->rr)
                        <div class="text-center bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400 block mb-1">{{ __('trades.rr_ratio') }}</span>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $trade->rr }}:1</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Risk Management & Additional Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Risk Management Card - Improved -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <div
                    class="px-6 py-4 bg-gradient-to-r from-amber-50 to-transparent dark:from-amber-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-shield-alt text-amber-600 dark:text-amber-400"></i>
                        </div>
                        {{ __('trades.risk_management') }}
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Kelompok 1: Risk Parameters -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                            <i class="fas fa-chart-pie mr-2 text-amber-500"></i>
                            {{ __('trades.risk_parameters') }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Lot Size -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.lot_size') }}</span>
                                <span
                                    class="font-bold text-xl text-gray-900 dark:text-white">{{ $trade->lot_size ?? '-' }}</span>
                            </div>

                            <!-- Risk % -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.risk_percent') }}</span>
                                <span class="font-bold text-xl text-gray-900 dark:text-white">
                                    {{ $trade->risk_percent ? $trade->risk_percent . '%' : '-' }}
                                </span>
                            </div>

                            <!-- Risk USD -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.risk_amount_usd') }}</span>
                                <span class="font-bold text-xl text-gray-900 dark:text-white">
                                    {{ $trade->risk_usd ? '$' . number_format($trade->risk_usd, 2) : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 2: Trade Levels -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                            <i class="fas fa-ruler-combined mr-2 text-blue-500"></i>
                            {{ __('trades.trade_levels') }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pips -->
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-3">{{ __('trades.pips') }}</span>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-up text-green-600 dark:text-green-400 mr-2"></i>
                                            <span
                                                class="text-gray-600 dark:text-gray-400">{{ __('trades.take_profit') }}</span>
                                        </div>
                                        <span
                                            class="font-semibold text-green-600 dark:text-green-400">{{ $trade->tp_pips ?? '0' }}
                                            pips</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-down text-red-600 dark:text-red-400 mr-2"></i>
                                            <span
                                                class="text-gray-600 dark:text-gray-400">{{ __('trades.stop_loss') }}</span>
                                        </div>
                                        <span
                                            class="font-semibold text-red-600 dark:text-red-400">{{ $trade->sl_pips ?? '0' }}
                                            pips</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk-Reward Ratio -->
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-3">{{ __('trades.risk_reward_ratio') }}</span>
                                <div class="flex items-center justify-center">
                                    <span
                                        class="font-bold text-2xl {{ $trade->rr >= 1 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                        {{ $trade->rr ?? '-' }}:1
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 3: Time Management -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                            <i class="fas fa-clock mr-2 text-indigo-500"></i>
                            {{ __('trades.time_management') }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @php
                                $entryDt = optional($trade->timestamp)
                                    ? \Carbon\Carbon::parse($trade->timestamp)
                                    : null;
                                $exitDt = optional($trade->exit_timestamp)
                                    ? \Carbon\Carbon::parse($trade->exit_timestamp)
                                    : null;
                                $duration = null;
                                if ($entryDt && $exitDt) {
                                    $secs = $entryDt->diffInSeconds($exitDt);
                                    $duration = \Carbon\CarbonInterval::seconds($secs)->cascade()->forHumans();
                                } elseif ($entryDt && !$exitDt) {
                                    $secs = $entryDt->diffInSeconds(now());
                                    $duration = \Carbon\CarbonInterval::seconds($secs)->cascade()->forHumans();
                                }
                            @endphp

                            <!-- Entry Time -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.entry_time') }}</span>
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-lg text-gray-900 dark:text-white">
                                        {{ $entryDt ? $entryDt->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $entryDt ? $entryDt->format('H:i') : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Exit Time -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.exit_time') }}</span>
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-lg text-gray-900 dark:text-white">
                                        {{ $exitDt ? $exitDt->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $exitDt ? $exitDt->format('H:i') : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div
                                class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400 block mb-2">{{ __('trades.duration') }}</span>
                                <div class="flex flex-col items-center">
                                    <span
                                        class="font-bold text-lg text-gray-900 dark:text-white">{{ $duration ?? '-' }}</span>
                                    @if ($entryDt && !$exitDt)
                                        <span
                                            class="text-xs text-yellow-600 dark:text-yellow-400 mt-1 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-full">
                                            <i class="fas fa-sync-alt mr-1"></i> {{ __('trades.ongoing') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Notes (if exists) - Improved -->
            @if ($trade->entry_reason || $trade->note || $trade->market_condition)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                    <div
                        class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-transparent dark:from-indigo-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg mr-3">
                                <i class="fas fa-sticky-note text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            {{ __('trades.evaluation_notes') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if ($trade->market_condition)
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-2 flex items-center">
                                    <i class="fas fa-chart-line mr-2 text-indigo-500"></i>
                                    {{ __('trades.market_condition') }}
                                </span>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $trade->market_condition }}</p>
                            </div>
                        @endif

                        @if ($trade->entry_reason)
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-2 flex items-center">
                                    <i class="fas fa-pencil-alt mr-2 text-indigo-500"></i>
                                    {{ __('trades.entry_reason') }}
                                </span>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $trade->entry_reason }}</p>
                            </div>
                        @endif

                        @if ($trade->note)
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <span class="text-sm text-gray-500 dark:text-gray-400 block mb-2 flex items-center">
                                    <i class="fas fa-sticky-note mr-2 text-indigo-500"></i>
                                    {{ __('trades.additional_notes') }}
                                </span>
                                <p class="font-medium text-gray-900 dark:text-white whitespace-pre-line">
                                    {{ $trade->note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Chart Images Section - Improved -->
        @if ($trade->before_link || $trade->after_link)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden mb-6">
                <div
                    class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-transparent dark:from-cyan-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="bg-cyan-100 dark:bg-cyan-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-line text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        {{ __('trades.trading_charts') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($trade->before_link)
                            <div class="space-y-3">
                                <!-- Header dengan link -->
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-image mr-2 text-cyan-500"></i>
                                        {{ __('trades.before_entry') }}
                                    </label>
                                    <div class="flex gap-3">
                                        @if ($beforeChartImage)
                                            <button
                                                onclick="openImageModal('{{ $beforeChartImage }}', '{{ __('trades.before_entry_title', ['symbol' => $trade->symbol->name]) }}')"
                                                class="text-xs text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors flex items-center bg-cyan-50 dark:bg-cyan-900/20 px-2 py-1 rounded">
                                                <i class="fas fa-search-plus mr-1"></i>
                                                {{ __('trades.zoom') }}
                                            </button>
                                        @endif
                                        <a href="{{ $trade->before_link }}" target="_blank"
                                            class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors flex items-center bg-primary-50 dark:bg-primary-900/20 px-2 py-1 rounded">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            {{ __('trades.link') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Image Display -->
                                @if ($beforeChartImage)
                                    <div
                                        class="relative group overflow-hidden rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 hover:border-cyan-500 dark:hover:border-cyan-400 transition-all duration-300 shadow-md">
                                        <img src="{{ $beforeChartImage }}"
                                            alt="{{ __('trades.before_chart_alt', ['symbol' => $trade->symbol->name]) }}"
                                            class="w-full h-auto chart-image cursor-zoom-in hover:opacity-90 transition-opacity duration-300 max-h-96 object-cover"
                                            loading="lazy"
                                            onclick="openImageModal('{{ $beforeChartImage }}', '{{ __('trades.before_entry_title', ['symbol' => $trade->symbol->name]) }}')">
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 text-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ __('trades.click_image_to_zoom') }}
                                    </p>
                                @else
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-8 text-center">
                                        <i class="fas fa-chart-line text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                            {{ __('trades.chart_image_unavailable') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                            @if (str_contains($trade->before_link, 'tradingview'))
                                                {{ __('trades.tradingview_link_not_image') }}
                                            @else
                                                {{ __('trades.failed_load_image') }}
                                            @endif
                                        </p>
                                        <a href="{{ $trade->before_link }}" target="_blank"
                                            class="inline-block mt-2 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold py-2 px-4 rounded-lg transition-colors shadow-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            {{ __('trades.open_original_link') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if ($trade->after_link)
                            <div class="space-y-3">
                                <!-- Header dengan link -->
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <i class="fas fa-image mr-2 text-cyan-500"></i>
                                        {{ __('trades.after_entry') }}
                                    </label>
                                    <div class="flex gap-3">
                                        @if ($afterChartImage)
                                            <button
                                                onclick="openImageModal('{{ $afterChartImage }}', '{{ __('trades.after_entry_title', ['symbol' => $trade->symbol->name]) }}')"
                                                class="text-xs text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors flex items-center bg-cyan-50 dark:bg-cyan-900/20 px-2 py-1 rounded">
                                                <i class="fas fa-search-plus mr-1"></i>
                                                {{ __('trades.zoom') }}
                                            </button>
                                        @endif
                                        <a href="{{ $trade->after_link }}" target="_blank"
                                            class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors flex items-center bg-primary-50 dark:bg-primary-900/20 px-2 py-1 rounded">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            {{ __('trades.link') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Image Display -->
                                @if ($afterChartImage)
                                    <div
                                        class="relative group overflow-hidden rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 hover:border-cyan-500 dark:hover:border-cyan-400 transition-all duration-300 shadow-md">
                                        <img src="{{ $afterChartImage }}"
                                            alt="{{ __('trades.after_chart_alt', ['symbol' => $trade->symbol->name]) }}"
                                            class="w-full h-auto chart-image cursor-zoom-in hover:opacity-90 transition-opacity duration-300 max-h-96 object-cover"
                                            loading="lazy"
                                            onclick="openImageModal('{{ $afterChartImage }}', '{{ __('trades.after_entry_title', ['symbol' => $trade->symbol->name]) }}')">
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 text-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ __('trades.click_image_to_zoom') }}
                                    </p>
                                @else
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-8 text-center">
                                        <i class="fas fa-chart-line text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                            {{ __('trades.chart_image_unavailable') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                            @if (str_contains($trade->after_link, 'tradingview'))
                                                {{ __('trades.tradingview_link_not_image') }}
                                            @else
                                                {{ __('trades.failed_load_image') }}
                                            @endif
                                        </p>
                                        <a href="{{ $trade->after_link }}" target="_blank"
                                            class="inline-block mt-2 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold py-2 px-4 rounded-lg transition-colors shadow-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            {{ __('trades.open_original_link') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons - Improved -->
        <div
            class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row gap-3">
                <a href="{{ route('trades.edit', $trade->id) }}"
                    class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    {{ __('trades.update_exit') }}
                </a>
                <a href="{{ route('trades.evaluate', $trade->id) }}"
                    class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    {{ __('trades.evaluate_trade') }}
                </a>
                <a href="{{ route('trades.single.pdf', $trade->id) }}"
                    class="inline-flex items-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-file-pdf mr-2"></i>
                    {{ __('trades.download_pdf_report') }}
                </a>
            </div>
            @php
                $backPage = request()->query('page', 1);
            @endphp
            <a href="{{ route('trades.index', ['page' => $backPage]) }}"
                class="flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                {{ __('trades.back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Image Zoom Modal - Improved -->
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeImageModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div
                class="max-w-4xl max-h-full bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-2xl overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 id="modalTitle" class="text-lg font-bold text-gray-900 dark:text-white"></h3>
                    <button onclick="closeImageModal()"
                        class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 flex justify-center items-center max-h-[70vh]">
                    <div class="image-container">
                        <img id="zoomedImage" src="" alt=""
                            class="max-w-full max-h-full object-contain rounded-lg">
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('trades.zoom_instructions') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variabel global untuk zoom dan pan
        let currentScale = 1;
        let currentX = 0;
        let currentY = 0;
        let isDragging = false;
        let startX, startY;
        let isAnimating = false;

        // Step-based zoom levels
        const zoomSteps = [0.5, 0.75, 1, 1.5, 2, 2.5, 3, 4, 5];

        function applyTransform() {
            const zoomedImage = document.getElementById('zoomedImage');
            if (zoomedImage) {
                zoomedImage.style.transform = `scale(${currentScale}) translate(${currentX}px, ${currentY}px)`;
            }
        }

        function smoothZoom(targetScale, mouseX, mouseY) {
            if (isAnimating) return;

            const zoomedImage = document.getElementById('zoomedImage');
            const imageContainer = document.querySelector('.image-container');
            if (!zoomedImage || !imageContainer) return;

            isAnimating = true;

            const startScale = currentScale;
            const startX = currentX;
            const startY = currentY;

            const rect = imageContainer.getBoundingClientRect();
            const scaleChange = targetScale - startScale;

            // Hitung target position untuk zoom ke arah kursor
            const targetX = currentX - (mouseX - rect.width / 2 - currentX) * scaleChange / startScale;
            const targetY = currentY - (mouseY - rect.height / 2 - currentY) * scaleChange / startScale;

            const duration = 200; // ms
            const startTime = performance.now();

            function animate(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing function untuk smooth animation
                const easeProgress = 1 - Math.pow(1 - progress, 3);

                currentScale = startScale + (targetScale - startScale) * easeProgress;
                currentX = startX + (targetX - startX) * easeProgress;
                currentY = startY + (targetY - startY) * easeProgress;

                applyTransform();

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    isAnimating = false;

                    // Update cursor dan class setelah animasi selesai
                    if (currentScale > 1) {
                        zoomedImage.classList.add('zoomed');
                        imageContainer.style.cursor = 'grab';
                    } else {
                        zoomedImage.classList.remove('zoomed');
                        imageContainer.style.cursor = 'zoom-in';
                    }
                }
            }

            requestAnimationFrame(animate);
        }

        function getNextZoomLevel(direction, currentScale) {
            const currentIndex = zoomSteps.findIndex(step => step >= currentScale);

            if (direction === 'in') {
                // Zoom in - cari step berikutnya
                for (let i = currentIndex + 1; i < zoomSteps.length; i++) {
                    if (zoomSteps[i] > currentScale) {
                        return zoomSteps[i];
                    }
                }
                return zoomSteps[zoomSteps.length - 1]; // Kembalikan level maksimum
            } else {
                // Zoom out - cari step sebelumnya
                for (let i = currentIndex - 1; i >= 0; i--) {
                    if (zoomSteps[i] < currentScale) {
                        return zoomSteps[i];
                    }
                }
                return zoomSteps[0]; // Kembalikan level minimum
            }
        }

        function openImageModal(imageSrc, title) {
            const modal = document.getElementById('imageZoomModal');
            const zoomedImage = document.getElementById('zoomedImage');
            const modalTitle = document.getElementById('modalTitle');

            zoomedImage.src = imageSrc;
            zoomedImage.alt = title;
            modalTitle.textContent = title;

            // Reset zoom dan posisi
            currentScale = 1;
            currentX = 0;
            currentY = 0;
            isAnimating = false;
            applyTransform();
            zoomedImage.classList.remove('zoomed');

            // Reset cursor
            const imageContainer = document.querySelector('.image-container');
            if (imageContainer) {
                imageContainer.style.cursor = 'zoom-in';
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Add keyboard event listener
            document.addEventListener('keydown', handleKeyPress);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageZoomModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Remove keyboard event listener
            document.removeEventListener('keydown', handleKeyPress);
        }

        function handleKeyPress(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        }

        // Add zoom and pan functionality
        document.addEventListener('DOMContentLoaded', function() {
            const zoomedImage = document.getElementById('zoomedImage');
            const imageContainer = document.querySelector('.image-container');

            if (zoomedImage && imageContainer) {
                // Zoom dengan scroll mouse (step-based dengan smooth animation)
                imageContainer.addEventListener('wheel', function(e) {
                    e.preventDefault();

                    if (isAnimating) return;

                    const rect = imageContainer.getBoundingClientRect();
                    const mouseX = e.clientX - rect.left;
                    const mouseY = e.clientY - rect.top;

                    const direction = e.deltaY < 0 ? 'in' : 'out';
                    const targetScale = getNextZoomLevel(direction, currentScale);

                    // Jika target scale sama dengan current, skip
                    if (targetScale === currentScale) return;

                    smoothZoom(targetScale, mouseX, mouseY);
                });

                // Drag functionality
                imageContainer.addEventListener('mousedown', (e) => {
                    if (currentScale > 1 && !isAnimating) {
                        isDragging = true;
                        imageContainer.style.cursor = 'grabbing';
                        startX = e.clientX - currentX;
                        startY = e.clientY - currentY;
                    }
                });

                document.addEventListener('mouseup', () => {
                    isDragging = false;
                    if (currentScale > 1 && !isAnimating) {
                        imageContainer.style.cursor = 'grab';
                    } else if (!isAnimating) {
                        imageContainer.style.cursor = 'zoom-in';
                    }
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isDragging || currentScale <= 1 || isAnimating) return;

                    e.preventDefault();

                    // Batasi pergerakan agar gambar tidak keluar dari viewport
                    const rect = imageContainer.getBoundingClientRect();
                    const maxX = (zoomedImage.clientWidth * currentScale - rect.width) / 2;
                    const maxY = (zoomedImage.clientHeight * currentScale - rect.height) / 2;

                    currentX = e.clientX - startX;
                    currentY = e.clientY - startY;

                    // Batasi pergerakan
                    currentX = Math.max(-maxX, Math.min(maxX, currentX));
                    currentY = Math.max(-maxY, Math.min(maxY, currentY));

                    applyTransform();
                });

                // Double click to reset dengan smooth animation
                imageContainer.addEventListener('dblclick', (e) => {
                    e.preventDefault();
                    if (isAnimating) return;

                    const rect = imageContainer.getBoundingClientRect();
                    const mouseX = e.clientX - rect.left;
                    const mouseY = e.clientY - rect.top;

                    smoothZoom(1, mouseX, mouseY);
                });
            }
        });

        // Close modal when clicking on backdrop
        document.getElementById('imageZoomModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>

    <style>
        /* Update CSS untuk zoom dan drag */
        #zoomedImage {
            transition: transform 0.2s ease-out;
            cursor: zoom-in;
            transform-origin: center center;
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
        }

        #zoomedImage.zoomed {
            cursor: default;
        }

        /* Container untuk gambar dengan overflow hidden */
        .image-container {
            overflow: hidden;
            width: 100%;
            height: 100%;
            max-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: zoom-in;
        }

        .image-container.zooming {
            cursor: grabbing;
        }

        /* Modal styling improvements */
        #imageZoomModal .max-h-\[70vh\] {
            max-height: 70vh !important;
            min-height: 400px;
        }

        /* Smooth transition untuk transform */
        #zoomedImage {
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Perbaikan tata letak untuk konten yang lebih stabil */
        .container {
            max-width: 1200px;
        }

        /* Chart image styling */
        .chart-image {
            transition: all 0.3s ease;
        }

        .chart-image:hover {
            transform: scale(1.01);
        }
    </style>

    <style>
        /* Custom styles untuk show.blade.php */
        .chart-image {
            transition: all 0.3s ease;
        }

        .chart-image:hover {
            transform: scale(1.01);
        }

        /* Zoom modal styles */
        #zoomedImage {
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-origin: center center;
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
        }

        #zoomedImage.zoomed {
            cursor: default;
        }

        .image-container {
            overflow: hidden;
            width: 100%;
            height: 100%;
            max-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: zoom-in;
        }

        .image-container.zooming {
            cursor: grabbing;
        }

        /* Smooth transitions */
        button,
        a,
        .border-2,
        .bg-gradient-to-r {
            transition: all 0.2s ease-in-out;
        }

        /* Dark mode adjustments */
        .dark .bg-gray-50 {
            background-color: rgba(31, 41, 55, 0.5);
        }
    </style>
@endsection
