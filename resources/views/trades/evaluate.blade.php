@extends('Layouts.index')
@section('title', 'Evaluate Trade')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Evaluasi Trade
                    </h1>
                    <p class="text-gray-500 mt-1">Step 3 - Analisis dan evaluasi trading Anda</p>
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
                    <div
                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold relative z-10">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Entry Trade</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold relative z-10">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Update Exit</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-purple-400">Evaluasi</span>
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
                                    Trade #{{ $trade->id }} - {{ $trade->symbol->name }}
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">
                                    Detail trading untuk evaluasi
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
                            <p class="text-xs text-gray-400 mb-1">Type</p>
                            <p class="text-base font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Entry</p>
                            <p class="text-base font-bold font-mono text-green-400">{{ $trade->entry }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Exit</p>
                            <p class="text-base font-bold font-mono text-red-400">{{ $trade->exit ?? '-' }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Lot Size</p>
                            <p class="text-base font-bold text-amber-400">{{ $trade->lot_size ?? '0.00' }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Session</p>
                            <p class="text-base font-bold text-cyan-400">{{ $trade->session }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">R/R Ratio</p>
                            <p class="text-base font-bold text-purple-400">{{ $trade->rr ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Stop Loss</p>
                            <p class="text-base font-semibold font-mono text-red-400">{{ $trade->stop_loss }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Take Profit</p>
                            <p class="text-base font-semibold font-mono text-green-400">{{ $trade->take_profit }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Risk USD</p>
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
                                Analisis & Evaluasi Trading
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">
                                Catat pembelajaran dari trading ini
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
                                    Entry Setup & Strategy
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_type" class="block text-sm font-semibold text-gray-300">
                                            Entry Type (Setup)
                                        </label>
                                        <input type="text" name="entry_type" id="entry_type"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent"
                                            value="{{ $trade->entry_type }}"
                                            placeholder="Contoh: Order Block, FVG, Breaker Block, dll">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-300">
                                            Follow Trading Rules?
                                        </label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="1"
                                                    {{ $trade->follow_rules ? 'checked' : '' }} class="hidden">
                                                <div
                                                    class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-green-500">
                                                    <i class="fas fa-check-circle text-lg text-green-400 mb-1"></i>
                                                    <div class="text-green-400 font-semibold">Yes</div>
                                                </div>
                                            </label>
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="0"
                                                    {{ !$trade->follow_rules ? 'checked' : '' }} class="hidden">
                                                <div
                                                    class="border-2 border-gray-600 rounded-lg p-3 text-center cursor-pointer hover:border-red-500">
                                                    <i class="fas fa-times-circle text-lg text-red-400 mb-1"></i>
                                                    <div class="text-red-400 font-semibold">No</div>
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
                                    Market Analysis & Context
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="market_condition" class="block text-sm font-semibold text-gray-300">
                                            Market Condition Analysis
                                        </label>
                                        <textarea name="market_condition" id="market_condition" rows="3"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent resize-none"
                                            placeholder="Deskripsikan kondisi market saat entry...">{{ $trade->market_condition }}</textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="entry_reason" class="block text-sm font-semibold text-gray-300">
                                            Entry Reasoning & Conviction
                                        </label>
                                        <textarea name="entry_reason" id="entry_reason" rows="3"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent resize-none"
                                            placeholder="Alasan mengambil posisi ini...">{{ $trade->entry_reason }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Management -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-red-300">
                                    <i class="fas fa-shield-alt text-red-400 mr-3"></i>
                                    Risk Management Review
                                </h3>

                                <div class="space-y-2">
                                    <label for="why_sl_tp" class="block text-sm font-semibold text-gray-300">
                                        SL & TP Placement Reasoning
                                    </label>
                                    <textarea name="why_sl_tp" id="why_sl_tp" rows="3"
                                        class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-transparent resize-none"
                                        placeholder="Analisis penempatan Stop Loss dan Take Profit...">{{ $trade->why_sl_tp }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Trading Rules -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-green-300">
                                    <i class="fas fa-check-double text-green-400 mr-3"></i>
                                    Trading Rules Checklist
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
                                    Trading Psychology
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_emotion" class="block text-sm font-semibold text-gray-300">
                                            Entry Emotion
                                        </label>
                                        <input type="text" name="entry_emotion" id="entry_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent"
                                            value="{{ $trade->entry_emotion }}" placeholder="Emosi saat entry">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="close_emotion" class="block text-sm font-semibold text-gray-300">
                                            Close Emotion
                                        </label>
                                        <input type="text" name="close_emotion" id="close_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent"
                                            value="{{ $trade->close_emotion }}" placeholder="Emosi saat close">
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-cyan-300">
                                    <i class="fas fa-camera text-cyan-400 mr-3"></i>
                                    Trade Documentation
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="before_link" class="block text-sm font-semibold text-gray-300">
                                            Before Screenshot (Link)
                                        </label>
                                        <input type="url" name="before_link" id="before_link"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                            value="{{ $trade->before_link }}"
                                            placeholder="https://screenshot-before-trade.com">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="after_link" class="block text-sm font-semibold text-gray-300">
                                            After Screenshot (Link)
                                        </label>
                                        <input type="url" name="after_link" id="after_link"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                            value="{{ $trade->after_link }}"
                                            placeholder="https://screenshot-after-trade.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mt-6 bg-gray-750 rounded-xl p-4 border border-gray-600">
                        <h3 class="text-lg font-bold mb-4 flex items-center text-gray-300">
                            <i class="fas fa-sticky-note text-gray-400 mr-3"></i>
                            Additional Notes & Key Learnings
                        </h3>

                        <div class="space-y-2">
                            <label for="note" class="block text-sm font-semibold text-gray-300">
                                Catatan Tambahan & Pembelajaran
                            </label>
                            <textarea name="note" id="note" rows="4"
                                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent resize-none"
                                placeholder="Pembelajaran dan insight dari trade ini...">{{ $trade->note }}</textarea>
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
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-8 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Evaluasi
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

                submitButton.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Menyimpan...';
                submitButton.disabled = true;

                // Allow normal submission
            });
        });
    </script>
@endsection
