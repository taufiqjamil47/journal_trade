@extends('Layouts.index')
@section('title', __('trades.edit_trade_exit'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header - Improved contrast -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('trades.update_exit_trade') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('trades.step2_description') }}
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

                <!-- Step 2 - Active -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-amber-600 dark:bg-amber-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-amber-500/20">
                        2
                    </div>
                    <span
                        class="text-sm font-semibold mt-2 text-amber-700 dark:text-amber-400">{{ __('trades.step_exit') }}</span>
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

        <div class="max-w-5xl mx-auto">
            <!-- Trade Summary Card - Improved -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 shadow-lg overflow-hidden">
                <!-- Header -->
                <div
                    class="px-6 py-5 bg-gradient-to-r from-primary-50 to-transparent dark:from-primary-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-xl mr-4">
                                <i class="fas fa-chart-line text-primary-600 dark:text-primary-400 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('trades.trade_summary') }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                    {{ __('trades.current_position_details') }}
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

                <!-- Content - Improved cards -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Symbol Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-chart-line mr-1 text-primary-500"></i>
                                {{ __('trades.symbol') }}
                            </p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $trade->symbol->name }}</p>
                        </div>

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

                        <!-- SL Pips Card -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-arrow-down mr-1 text-red-500"></i>
                                {{ __('trades.sl_pips') }}
                            </p>
                            <p class="text-lg font-bold text-red-600 dark:text-red-400">{{ $trade->sl_pips ?? '0' }} pips
                            </p>
                        </div>
                    </div>

                    <!-- Additional Info - Grid with 4 columns -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Stop Loss -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-shield-alt mr-1 text-red-500"></i>
                                {{ __('trades.stop_loss') }}
                            </p>
                            <p class="text-lg font-semibold text-red-600 dark:text-red-400">
                                {{ format_price($trade->stop_loss) }}</p>
                        </div>

                        <!-- Take Profit -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-flag-checkered mr-1 text-green-500"></i>
                                {{ __('trades.take_profit') }}
                            </p>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-400">
                                {{ format_price($trade->take_profit) }}</p>
                        </div>

                        <!-- R:R Ratio -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-balance-scale mr-1 text-cyan-500"></i>
                                {{ __('trades.rr_ratio') }}
                            </p>
                            <p class="text-lg font-semibold text-cyan-600 dark:text-cyan-400">{{ $trade->rr ?? '0' }}</p>
                        </div>

                        <!-- Commission -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                                <i class="fas fa-coins mr-1 text-orange-500"></i>
                                {{ __('trades.commission_per_lot') }}
                            </p>
                            <p class="text-lg font-semibold text-orange-600 dark:text-orange-400">
                                ${{ number_format($account->commission_per_lot, 2) }}</p>
                        </div>
                    </div>

                    <!-- Account Info - Improved -->
                    <div
                        class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-wallet mr-2 text-blue-500"></i>
                                    {{ __('trades.account') }}
                                </p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $account->currency }}
                                    Account (ID: {{ $account->id }})</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-end">
                                    {{ __('trades.current_balance') }}
                                    <i class="fas fa-info-circle ml-2 text-gray-400"></i>
                                </p>
                                <p class="text-xl font-bold text-green-600 dark:text-green-400">
                                    ${{ number_format($balance, 2) }}
                                </p>
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
                    class="px-6 py-5 bg-gradient-to-r from-green-50 to-transparent dark:from-green-900/20 dark:to-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-edit text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('trades.update_exit_details') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                {{ __('trades.complete_exit_info') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.update', $trade->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Risk Management -->
                        <div class="space-y-6">
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-amber-700 dark:text-amber-400">
                                    <div class="bg-amber-100 dark:bg-amber-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-shield-alt text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    {{ __('trades.risk_management') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- Risk Percent -->
                                    <div class="space-y-2">
                                        <label for="risk_percent"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-percent mr-2 text-amber-500"></i>
                                            {{ __('trades.risk_percentage') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.1" id="risk_percent" name="risk_percent"
                                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-shadow"
                                                value="{{ $trade->risk_percent }}" placeholder="1.0">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                <span class="text-amber-600 dark:text-amber-400 font-medium">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lot Size -->
                                    <div class="space-y-2">
                                        <label for="lot_size"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-cubes mr-2 text-blue-500"></i>
                                            {{ __('trades.lot_size') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.01" id="lot_size" name="lot_size"
                                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                                                value="{{ $trade->lot_size }}" placeholder="0.10">
                                        </div>
                                    </div>

                                    <!-- Risk USD -->
                                    <div class="space-y-2">
                                        <label for="risk_usd"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-dollar-sign mr-2 text-green-500"></i>
                                            {{ __('trades.risk_amount_usd') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.01" id="risk_usd" name="risk_usd"
                                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-shadow"
                                                value="{{ $trade->risk_usd }}" placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                                <span class="text-green-600 dark:text-green-400 font-medium">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Exit Details -->
                        <div class="space-y-6">
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-700 dark:text-green-400">
                                    <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg mr-3">
                                        <i class="fas fa-door-open text-green-600 dark:text-green-400"></i>
                                    </div>
                                    {{ __('trades.exit_details') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- Exit Price -->
                                    <div class="space-y-2">
                                        <label for="exit"
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-sign-out-alt mr-2 text-green-500"></i>
                                            {{ __('trades.exit_price') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.00001" name="exit" id="exit"
                                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-shadow"
                                                value="{{ format_price($trade->exit) }}" placeholder="0.00000">
                                            <span class="absolute right-3 top-2.5 text-sm text-gray-400">USD</span>
                                        </div>
                                    </div>

                                    <!-- Calculation Preview - Improved -->
                                    <div
                                        class="bg-white dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600 shadow-sm">
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                                            <div class="bg-purple-100 dark:bg-purple-900/30 p-1.5 rounded mr-2">
                                                <i
                                                    class="fas fa-calculator text-purple-600 dark:text-purple-400 text-sm"></i>
                                            </div>
                                            {{ __('trades.calculation_preview') }}
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <!-- Risk Amount -->
                                            <div class="text-center">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ __('trades.risk_amount') }}</p>
                                                <p class="text-lg font-bold text-amber-600 dark:text-amber-400"
                                                    id="riskAmount">-</p>
                                            </div>
                                            <!-- Gross P/L -->
                                            <div class="text-center">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ __('trades.gross_pl') }}</p>
                                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400"
                                                    id="grossPL">-</p>
                                            </div>
                                            <!-- Commission -->
                                            <div class="text-center">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ __('trades.commission') }}</p>
                                                <p class="text-lg font-bold text-orange-600 dark:text-orange-400"
                                                    id="commissionAmount">
                                                    -${{ number_format($account->commission_per_lot * $trade->lot_size, 2) }}
                                                </p>
                                            </div>
                                            <!-- Net P/L -->
                                            <div class="text-center">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ __('trades.net_pl') }}</p>
                                                <p class="text-lg font-bold text-green-600 dark:text-green-400"
                                                    id="netPL">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions - Improved -->
                    <div
                        class="mt-8 bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-purple-700 dark:text-purple-400">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                                <i class="fas fa-bolt text-purple-600 dark:text-purple-400"></i>
                            </div>
                            {{ __('trades.quick_actions') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button type="button" onclick="setExitPrice('{{ $trade->stop_loss }}')"
                                class="bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-700 dark:text-red-400 py-3 px-4 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-red-500 transition-all flex flex-col items-center shadow-sm">
                                <i class="fas fa-times text-lg mb-1"></i>
                                <span class="font-medium">{{ __('trades.set_to_sl') }}</span>
                                <span
                                    class="text-xs text-red-500 dark:text-red-500/70 mt-1">{{ format_price($trade->stop_loss) }}</span>
                            </button>

                            <button type="button" onclick="setExitPrice('{{ $trade->take_profit }}')"
                                class="bg-white dark:bg-gray-700 hover:bg-green-50 dark:hover:bg-green-900/20 text-green-700 dark:text-green-400 py-3 px-4 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-green-500 transition-all flex flex-col items-center shadow-sm">
                                <i class="fas fa-trophy text-lg mb-1"></i>
                                <span class="font-medium">{{ __('trades.set_to_tp') }}</span>
                                <span
                                    class="text-xs text-green-500 dark:text-green-500/70 mt-1">{{ format_price($trade->take_profit) }}</span>
                            </button>

                            <button type="button" onclick="calculateBreakEven()"
                                class="bg-white dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-blue-700 dark:text-blue-400 py-3 px-4 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-blue-500 transition-all flex flex-col items-center shadow-sm">
                                <i class="fas fa-balance-scale text-lg mb-1"></i>
                                <span class="font-medium">{{ __('trades.break_even') }}</span>
                                <span
                                    class="text-xs text-blue-500 dark:text-blue-500/70 mt-1">{{ __('trades.cover_spread') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Partial Close Section - Improved -->
                    <div
                        class="mt-8 bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-inner">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-indigo-700 dark:text-indigo-400">
                            <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg mr-3">
                                <i class="fas fa-layer-group text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            {{ __('trades.partial_close') }}
                        </h3>

                        <!-- Toggle Switch -->
                        <div
                            class="flex items-center justify-between mb-6 p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ __('trades.enable_partial_close') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('trades.close_portion_position') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="use_partial_close" name="use_partial_close"
                                    class="sr-only peer" value="1">
                                <div
                                    class="w-14 h-7 bg-gray-300 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500">
                                </div>
                            </label>
                        </div>

                        <!-- Partial Close Options (Hidden by default) -->
                        <div id="partialCloseOptions" class="hidden space-y-6 mt-4">
                            <!-- Fixed Percentages -->
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('trades.fixed_percentages') }}</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ([20, 50, 75, 100] as $percent)
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="partial_close_percent"
                                                value="{{ $percent }}" class="peer hidden partial-percent-radio"
                                                onclick="document.getElementById('partial_close_custom').value = ''">
                                            <div
                                                class="bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center cursor-pointer transition-all group-hover:border-indigo-400 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20">
                                                <span
                                                    class="block text-xl font-bold {{ $percent == 100 ? 'text-green-600 dark:text-green-400' : 'text-indigo-600 dark:text-indigo-400' }}">
                                                    {{ $percent }}%
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    @if ($percent == 100)
                                                        {{ __('trades.full_close') }}
                                                    @else
                                                        {{ __('trades.partial_position') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Custom Percentage -->
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('trades.custom_percentage') }}</p>
                                <div class="relative">
                                    <input type="number" step="0.1" min="0" max="100"
                                        id="partial_close_custom" name="partial_close_custom"
                                        class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="0.0"
                                        oninput="document.querySelectorAll('.partial-percent-radio').forEach(radio => radio.checked = false)">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-medium">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ __('trades.enter_any_percentage') }}
                                </p>
                            </div>

                            <!-- Preview - Improved -->
                            <div
                                class="bg-white dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600 shadow-sm mt-4">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                                    <div class="bg-cyan-100 dark:bg-cyan-900/30 p-1.5 rounded mr-2">
                                        <i class="fas fa-eye text-cyan-600 dark:text-cyan-400 text-sm"></i>
                                    </div>
                                    {{ __('trades.partial_close_preview') }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            {{ __('trades.original_lot_size') }}</p>
                                        <p class="text-xl font-bold text-gray-900 dark:text-white" id="originalLotSize">
                                            {{ number_format($trade->lot_size ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-center p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            {{ __('trades.after_partial_close') }}</p>
                                        <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400"
                                            id="partialLotSize">
                                            {{ number_format($trade->lot_size ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-center p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            {{ __('trades.remaining_position') }}</p>
                                        <p class="text-xl font-bold text-amber-600 dark:text-amber-400"
                                            id="remainingPosition">
                                            {{ number_format(0, 2) }}
                                        </p>
                                    </div>
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
                        <div class="flex flex-col md:flex-row gap-3">
                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                {{ __('trades.evaluate_trade') }}
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2.5 px-8 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ __('trades.update_exit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Use raw JSON-encoded numeric values from server to avoid locale/format mismatch
        const tradeData = {
            entry: Number(@json($trade->entry)),
            type: @json($trade->type),
            balance: Number(@json($balance ?? 0)),
            slPips: Number(@json($trade->sl_pips ?? 0)),
            pipValue: Number(@json($trade->symbol->pip_value ?? 0.0001)),
            pipWorth: Number(@json($trade->symbol->pip_worth ?? 10)),
            commissionPerLot: Number(@json($account->commission_per_lot ?? 0))
        };

        // Ensure the exit input contains raw numeric value (not formatted) so parseFloat works
        // If the view previously displayed a formatted exit, replace it with raw value for calculations
        document.addEventListener('DOMContentLoaded', function() {
            const exitInput = document.getElementById('exit');
            if (exitInput && exitInput.value !== undefined) {
                // If value contains commas or non-numeric chars, normalize it
                const rawExit = String(exitInput.value).replace(/,/g, '');
                if (!isNaN(Number(rawExit))) {
                    exitInput.value = Number(rawExit);
                }
            }

            // Wire up event handlers
            const riskPercentEl = document.getElementById('risk_percent');
            const riskUsdEl = document.getElementById('risk_usd');
            const lotSizeEl = document.getElementById('lot_size');

            if (riskPercentEl) {
                riskPercentEl.addEventListener('input', function() {
                    const riskPercent = parseFloat(this.value);
                    const slPips = tradeData.slPips;
                    const balance = tradeData.balance;
                    const pipWorth = tradeData.pipWorth || 10;

                    if (!isNaN(riskPercent) && riskPercent > 0 && slPips > 0) {
                        const riskUSD = balance * (riskPercent / 100);
                        const lotSize = riskUSD / (slPips * pipWorth);

                        lotSizeEl.value = lotSize.toFixed(2);
                        riskUsdEl.value = riskUSD.toFixed(2);
                        document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                        calculatePotentialPL();
                    }
                });
            }

            if (riskUsdEl) {
                riskUsdEl.addEventListener('input', function() {
                    const riskUSD = parseFloat(this.value.replace(/,/g, ''));
                    const balance = tradeData.balance;
                    const slPips = tradeData.slPips;
                    const pipWorth = tradeData.pipWorth || 10;

                    if (!isNaN(riskUSD) && riskUSD > 0 && balance > 0) {
                        const riskPercent = (riskUSD / balance) * 100;
                        const lotSize = slPips > 0 ? riskUSD / (slPips * pipWorth) : 0;

                        document.getElementById('risk_percent').value = riskPercent.toFixed(2);
                        if (slPips > 0) {
                            lotSizeEl.value = lotSize.toFixed(2);
                        }
                        document.getElementById('riskAmount').textContent = `$${riskUSD.toFixed(2)}`;
                        calculatePotentialPL();
                    }
                });
            }

            if (lotSizeEl) {
                lotSizeEl.addEventListener('input', function() {
                    calculatePotentialPL();
                    updateCommissionAmount();
                });
            }

            if (exitInput) {
                exitInput.addEventListener('input', calculatePotentialPL);
            }

            // Trigger initial calculation if values exist
            if (riskPercentEl && riskPercentEl.value) {
                riskPercentEl.dispatchEvent(new Event('input'));
            } else {
                calculatePotentialPL();
            }

            // Update commission amount initially
            updateCommissionAmount();
        });

        // Calculate potential P/L using the same logic as server
        function calculatePotentialPL() {
            const entry = Number(tradeData.entry);
            const exitRaw = document.getElementById('exit')?.value ?? '';
            const exit = parseFloat(String(exitRaw).replace(/,/g, ''));
            const lotSize = parseFloat(document.getElementById('lot_size')?.value) || 0;
            const type = String(tradeData.type);
            const pipValue = Number(tradeData.pipValue) || 0.0001;
            const pipWorth = Number(tradeData.pipWorth) || 10;
            const commissionPerLot = Number(tradeData.commissionPerLot) || 0;

            if (!isNaN(entry) && !isNaN(exit) && lotSize > 0) {
                let pips;
                if (type === 'buy') {
                    pips = (exit - entry) / pipValue;
                } else {
                    pips = (entry - exit) / pipValue;
                }

                pips = Math.round(pips * 10) / 10;
                const grossProfitLoss = pips * lotSize * pipWorth;
                const commission = commissionPerLot * lotSize;
                const netProfitLoss = grossProfitLoss - commission;

                const roundedGrossPL = Math.round(grossProfitLoss * 100) / 100;
                const roundedCommission = Math.round(commission * 100) / 100;
                const roundedNetPL = Math.round(netProfitLoss * 100) / 100;

                // Update gross P/L
                const grossPLElement = document.getElementById('grossPL');
                grossPLElement.textContent = `$${roundedGrossPL.toFixed(2)}`;
                grossPLElement.className = `text-base font-bold ${roundedGrossPL >= 0 ? 'text-blue-400' : 'text-red-400'}`;

                // Update commission
                const commissionElement = document.getElementById('commissionAmount');
                commissionElement.textContent = `-$${roundedCommission.toFixed(2)}`;

                // Update net P/L
                const netPLElement = document.getElementById('netPL');
                netPLElement.textContent = `$${roundedNetPL.toFixed(2)}`;
                netPLElement.className = `text-base font-bold ${roundedNetPL >= 0 ? 'text-green-400' : 'text-red-400'}`;
            } else {
                document.getElementById('grossPL').textContent = '-';
                document.getElementById('grossPL').className = 'text-base font-bold text-gray-400';
                document.getElementById('commissionAmount').textContent = '-';
                document.getElementById('netPL').textContent = '-';
                document.getElementById('netPL').className = 'text-base font-bold text-gray-400';
            }
        }

        // Update commission amount display
        function updateCommissionAmount() {
            const lotSize = parseFloat(document.getElementById('lot_size')?.value) || 0;
            const commissionPerLot = Number(tradeData.commissionPerLot) || 0;
            const commission = commissionPerLot * lotSize;
            const roundedCommission = Math.round(commission * 100) / 100;

            const commissionElement = document.getElementById('commissionAmount');
            commissionElement.textContent = `-$${roundedCommission.toFixed(2)}`;
        }

        // Quick action functions
        function formatPrice(price) {
            if (price === null || price === undefined || price === '') return '';

            // Normalize strings (remove commas) and convert to Number
            const num = Number(typeof price === 'string' ? price.replace(/,/g, '') : price);
            if (isNaN(num)) return String(price);

            const abs = Math.abs(num);
            const intPart = Math.floor(abs);

            // If integer part has 2+ digits (>=10) -> 3 decimals, otherwise -> 5 decimals
            const decimals = intPart >= 10 ? 3 : 5;

            // Use toFixed to round to required decimals and preserve sign
            return num.toFixed(decimals);
        }

        function setExitPrice(price) {
            const exitInput = document.getElementById('exit');
            const formatted = formatPrice(price);
            exitInput.value = formatted;
            calculatePotentialPL();
        }

        function calculateBreakEven() {
            const entry = Number(tradeData.entry);
            const type = String(tradeData.type);
            const pipValue = Number(tradeData.pipValue) || 0.0001;
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

    <script>
        // Partial Close Logic
        document.addEventListener('DOMContentLoaded', function() {
            const partialCloseToggle = document.getElementById('use_partial_close');
            const partialCloseOptions = document.getElementById('partialCloseOptions');
            const partialPercentRadios = document.querySelectorAll('.partial-percent-radio');
            const partialCustomInput = document.getElementById('partial_close_custom');
            const originalLotSize = parseFloat(@json($trade->lot_size ?? 0));

            // Initialize original lot size display
            document.getElementById('originalLotSize').textContent = originalLotSize.toFixed(2);
            updatePartialPreview();

            // Toggle partial close options
            if (partialCloseToggle) {
                partialCloseToggle.addEventListener('change', function() {
                    if (this.checked) {
                        partialCloseOptions.classList.remove('hidden');
                        partialCloseOptions.classList.add('block');
                        updatePartialPreview();
                    } else {
                        partialCloseOptions.classList.remove('block');
                        partialCloseOptions.classList.add('hidden');
                        // Reset to full close
                        document.getElementById('partialLotSize').textContent = originalLotSize.toFixed(2);
                        document.getElementById('remainingPosition').textContent = '0.00';
                    }
                });
            }

            // Handle radio button changes
            partialPercentRadios.forEach(radio => {
                radio.addEventListener('change', updatePartialPreview);
            });

            // Handle custom input changes
            if (partialCustomInput) {
                partialCustomInput.addEventListener('input', updatePartialPreview);
            }

            // Update lot size input when partial close changes
            function updatePartialPreview() {
                if (!partialCloseToggle || !partialCloseToggle.checked) {
                    return;
                }

                let percent = 100;

                // Check if custom input is used
                if (partialCustomInput && partialCustomInput.value) {
                    percent = parseFloat(partialCustomInput.value);
                } else {
                    // Check which radio is selected
                    partialPercentRadios.forEach(radio => {
                        if (radio.checked) {
                            percent = parseFloat(radio.value);
                        }
                    });
                }

                // Validate percent
                if (isNaN(percent) || percent < 0) percent = 100;
                if (percent > 100) percent = 100;

                const partialLotSize = originalLotSize * (percent / 100);
                const remainingPosition = originalLotSize - partialLotSize;

                // Update display
                document.getElementById('partialLotSize').textContent = partialLotSize.toFixed(2);
                document.getElementById('remainingPosition').textContent = remainingPosition.toFixed(2);

                // Update the actual lot size input field
                const lotSizeInput = document.getElementById('lot_size');
                if (lotSizeInput) {
                    lotSizeInput.value = partialLotSize.toFixed(2);
                    calculatePotentialPL(); // Recalculate P/L with new lot size
                }
            }

            // Update preview when risk management fields change
            const riskPercentEl = document.getElementById('risk_percent');
            const riskUsdEl = document.getElementById('risk_usd');
            const lotSizeEl = document.getElementById('lot_size');

            if (riskPercentEl) {
                riskPercentEl.addEventListener('input', function() {
                    setTimeout(updatePartialPreview, 100);
                });
            }

            if (riskUsdEl) {
                riskUsdEl.addEventListener('input', function() {
                    setTimeout(updatePartialPreview, 100);
                });
            }

            if (lotSizeEl) {
                lotSizeEl.addEventListener('input', function() {
                    // Update original lot size when user manually changes it
                    if (partialCloseToggle && !partialCloseToggle.checked) {
                        originalLotSize = parseFloat(this.value) || 0;
                        document.getElementById('originalLotSize').textContent = originalLotSize.toFixed(2);
                    }
                });
            }
        });
    </script>

    <style>
        /* Custom styles for better contrast */
        .dark input[type="number"]::-webkit-inner-spin-button,
        .dark input[type="number"]::-webkit-outer-spin-button {
            opacity: 0.6;
            filter: invert(1);
        }

        .dark input[type="number"]::-webkit-inner-spin-button:hover,
        .dark input[type="number"]::-webkit-outer-spin-button:hover {
            opacity: 1;
        }

        /* Smooth transitions */
        input,
        select,
        button,
        a,
        .border-2 {
            transition: all 0.2s ease-in-out;
        }

        /* Custom styles for toggle switch */
        .peer:checked~.peer-checked\:bg-indigo-600 {
            background-color: #4f46e5;
        }

        .dark .peer:checked~.dark\:peer-checked\:bg-indigo-500 {
            background-color: #6366f1;
        }
    </style>
@endsection
