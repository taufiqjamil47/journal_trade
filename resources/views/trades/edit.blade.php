@extends('Layouts.index')
@section('title', __('trades.edit_trade_exit'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('trades.update_exit_trade') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-500 mt-1">
                        {{ __('trades.step2_description') }}
                        @if ($account)
                            <span
                                class="ml-2 inline-block px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Account: {{ $account->name }}
                            </span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Account Selector Component -->
                    @include('components.account-selector')

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
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-green-500 dark:text-green-400">{{ __('trades.step_entry') }}</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <span
                        class="text-sm font-medium mt-2 text-amber-500 dark:text-amber-400">{{ __('trades.step_exit') }}</span>
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

        <div class="max-w-5xl mx-auto">
            <!-- Trade Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-primary-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-line text-primary-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-primary-300">
                                {{ __('trades.trade_summary') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-500 text-sm mt-1">
                                {{ __('trades.current_position_details') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.symbol') }}</p>
                            <p class="text-base font-bold font-mono">{{ $trade->symbol->name }}</p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.type') }}</p>
                            <p class="text-base font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.entry_price') }}</p>
                            <p class="text-base font-bold font-mono">{{ format_price($trade->entry) }}</p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.sl_pips') }}</p>
                            <p class="text-base font-bold text-red-400">{{ $trade->sl_pips ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.stop_loss') }}</p>
                            <p class="text-base font-semibold font-mono text-amber-400">
                                {{ format_price($trade->stop_loss) }}</p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.take_profit') }}</p>
                            <p class="text-base font-semibold font-mono text-green-400">
                                {{ format_price($trade->take_profit) }}</p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.rr_ratio') }}</p>
                            <p class="text-base font-semibold text-cyan-400">{{ $trade->rr ?? '0' }}</p>
                        </div>

                        <div class="rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('trades.commission_per_lot') }}
                            </p>
                            <p class="text-base font-semibold text-orange-400">
                                ${{ number_format($account->commission_per_lot, 2) }}</p>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div
                        class="mt-4 p-3 bg-blue-100/40 dark:bg-gray-750 rounded-lg border border-none dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('trades.account') }}</p>
                                <p class="text-base font-semibold text-primary-400">{{ $account->currency }} Account (ID:
                                    {{ $account->id }})</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('trades.current_balance') }}</p>
                                <p class="text-base font-semibold text-green-500 dark:text-green-400">
                                    ${{ number_format($balance, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700 bg-gray-850">
                    <div class="flex items-center">
                        <div class="bg-green-200 dark:bg-green-900/30 p-3 rounded-xl mr-4">
                            <i class="fas fa-edit text-green-500 dark:text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-green-500 dark:text-green-300">
                                {{ __('trades.update_exit_details') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-500 text-sm mt-1">
                                {{ __('trades.complete_exit_info') }}
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
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-amber-500 dark:text-amber-300">
                                    <i class="fas fa-shield-alt text-amber-500 dark:text-amber-400 mr-3"></i>
                                    {{ __('trades.risk_management') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- Risk Percent -->
                                    <div class="space-y-2">
                                        <label for="risk_percent"
                                            class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                            {{ __('trades.risk_percentage') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.1" id="risk_percent" name="risk_percent"
                                                class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent"
                                                value="{{ $trade->risk_percent }}" placeholder="1.0">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-amber-600 dark:text-amber-400">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lot Size -->
                                    <div class="space-y-2">
                                        <label for="lot_size"
                                            class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                            {{ __('trades.lot_size') }}
                                        </label>
                                        <input type="number" step="0.01" id="lot_size" name="lot_size"
                                            class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent"
                                            value="{{ $trade->lot_size }}" placeholder="0.10">
                                    </div>

                                    <!-- Risk USD -->
                                    <div class="space-y-2">
                                        <label for="risk_usd"
                                            class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                            {{ __('trades.risk_amount_usd') }}
                                        </label>
                                        <div class="relative">
                                            <input type="number" step="0.01" id="risk_usd" name="risk_usd"
                                                class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                                value="{{ $trade->risk_usd }}" placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-green-600 dark:text-green-400">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-600 dark:text-green-300">
                                    <i class="fas fa-door-open text-green-600 dark:text-green-400 mr-3"></i>
                                    {{ __('trades.exit_details') }}
                                </h3>

                                <div class="space-y-4">
                                    <!-- Exit Price -->
                                    <div class="space-y-2">
                                        <label for="exit"
                                            class="block text-sm font-semibold text-gray-600 dark:text-gray-300">
                                            {{ __('trades.exit_price') }}
                                        </label>
                                        <input type="number" step="0.00001" name="exit" id="exit"
                                            class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-transparent"
                                            value="{{ format_price($trade->exit) }}" placeholder="0.00000">
                                    </div>

                                    <!-- Calculation Preview -->
                                    <div class="bg-gray-750 rounded-lg p-4 border border-gray-600">
                                        <h4 class="font-semibold text-gray-600 dark:text-gray-300 mb-3 flex items-center">
                                            <i class="fas fa-calculator text-purple-600 dark:text-purple-400 mr-2"></i>
                                            {{ __('trades.calculation_preview') }}
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ __('trades.risk_amount') }}</p>
                                                <p class="text-base font-bold text-amber-600 dark:text-amber-400"
                                                    id="riskAmount">-</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ __('trades.gross_pl') }}</p>
                                                <p class="text-base font-bold text-blue-600 dark:text-blue-400"
                                                    id="grossPL">-</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ __('trades.commission') }}</p>
                                                <p class="text-base font-bold text-orange-600 dark:text-orange-400"
                                                    id="commissionAmount">
                                                    -${{ number_format($account->commission_per_lot * $trade->lot_size, 2) }}
                                                </p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-400 mb-1">{{ __('trades.net_pl') }}</p>
                                                <p class="text-base font-bold text-green-400" id="netPL">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 bg-gray-750 rounded-xl p-4 border border-gray-600">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-purple-600 dark:text-purple-300">
                            <i class="fas fa-bolt text-purple-600 dark:text-purple-400 mr-3"></i>
                            {{ __('trades.quick_actions') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <button type="button" onclick="setExitPrice('{{ $trade->stop_loss }}')"
                                class="bg-red-200/30 dark:bg-gray-800 hover:bg-red-300/40 dark:hover:bg-red-900/30 text-red-500 dark:text-red-400 py-3 px-4 rounded-lg border border-red-700/30 flex flex-col items-center">
                                <i class="fas fa-times text-lg mb-1"></i>
                                <span>{{ __('trades.set_to_sl') }}</span>
                                <span class="text-xs text-red-400/70 mt-1">{{ format_price($trade->stop_loss) }}</span>
                            </button>

                            <button type="button" onclick="setExitPrice('{{ $trade->take_profit }}')"
                                class="bg-green-200/30 dark:bg-gray-800 hover:bg-green-300/40 dark:hover:bg-green-900/30 text-green-500 dark:text-green-400 py-3 px-4 rounded-lg border border-green-700/30 flex flex-col items-center">
                                <i class="fas fa-trophy text-lg mb-1"></i>
                                <span>{{ __('trades.set_to_tp') }}</span>
                                <span
                                    class="text-xs text-green-400/70 mt-1">{{ format_price($trade->take_profit) }}</span>
                            </button>

                            <button type="button" onclick="calculateBreakEven()"
                                class="bg-blue-200/30 dark:bg-gray-800 hover:bg-blue-300/40 dark:hover:bg-blue-900/30 text-blue-500 dark:text-blue-400 py-3 px-4 rounded-lg border border-blue-700/30 flex flex-col items-center">
                                <i class="fas fa-balance-scale text-lg mb-1"></i>
                                <span>{{ __('trades.break_even') }}</span>
                                <span class="text-xs text-blue-400/70 mt-1">{{ __('trades.cover_spread') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Partial Close Section -->
                    <div class="mt-6 bg-gray-750 rounded-xl p-4 border border-gray-600">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-purple-600 dark:text-purple-300">
                            <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 mr-3"></i>
                            {{ __('trades.partial_close') }}
                        </h3>

                        <!-- Toggle Switch -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="font-medium text-gray-600 dark:text-gray-300">
                                    {{ __('trades.enable_partial_close') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-500">
                                    {{ __('trades.close_portion_position') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="use_partial_close" name="use_partial_close"
                                    class="sr-only peer" value="1">
                                <div
                                    class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                                </div>
                            </label>
                        </div>

                        <!-- Partial Close Options (Hidden by default) -->
                        <div id="partialCloseOptions" class="hidden space-y-4">
                            <!-- Fixed Percentages -->
                            <div>
                                <p class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">
                                    {{ __('trades.fixed_percentages') }}
                                </p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach ([20, 50, 75, 100] as $percent)
                                        <label class="relative">
                                            <input type="radio" name="partial_close_percent"
                                                value="{{ $percent }}" class="peer hidden partial-percent-radio"
                                                onclick="document.getElementById('partial_close_custom').value = ''">
                                            <div
                                                class="bg-gray-100 dark:bg-gray-800 border border-gray-600 rounded-lg p-3 text-center cursor-pointer transition-all hover:border-purple-500 peer-checked:border-purple-500 peer-checked:bg-purple-900/10 dark:peer-checked:bg-purple-900/20">
                                                <span
                                                    class="block text-lg font-bold {{ $percent == 100 ? 'text-green-400' : 'text-purple-400' }}">
                                                    {{ $percent }}%
                                                </span>
                                                <span class="text-xs text-gray-500 mt-1">
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
                                <p class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">
                                    {{ __('trades.custom_percentage') }}
                                </p>
                                <div class="relative">
                                    <input type="number" step="0.1" min="0" max="100"
                                        id="partial_close_custom" name="partial_close_custom"
                                        class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent"
                                        placeholder="0.0"
                                        oninput="document.querySelectorAll('.partial-percent-radio').forEach(radio => radio.checked = false)">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-purple-600 dark:text-purple-400">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ __('trades.enter_any_percentage') }}</p>
                            </div>

                            <!-- Preview -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-600">
                                <h4 class="font-semibold text-cyan-600 dark:text-gray-300 mb-3 flex items-center">
                                    <i class="fas fa-eye text-cyan-600 dark:text-cyan-400 mr-2"></i>
                                    {{ __('trades.partial_close_preview') }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            {{ __('trades.original_lot_size') }}</p>
                                        <p class="text-base font-bold text-gray-600 dark:text-gray-300"
                                            id="originalLotSize">
                                            {{ number_format($trade->lot_size ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            {{ __('trades.after_partial_close') }}</p>
                                        <p class="text-base font-bold text-purple-600 dark:text-purple-400"
                                            id="partialLotSize">
                                            {{ number_format($trade->lot_size ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            {{ __('trades.remaining_position') }}</p>
                                        <p class="text-base font-bold text-amber-600 dark:text-amber-400"
                                            id="remainingPosition">
                                            {{ number_format(0, 2) }}
                                        </p>
                                    </div>
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
                        <div class="flex flex-col md:flex-row gap-3">
                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center mb-3 md:mb-0">
                                <i class="fas fa-chart-bar mr-2"></i>
                                {{ __('trades.evaluate_trade') }}
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
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
@endsection
