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
                            <p class="text-base font-bold font-mono text-green-400">{{ format_price($trade->entry) }}</p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Exit</p>
                            <p class="text-base font-bold font-mono text-red-400">{{ format_price($trade->exit) ?? '-' }}
                            </p>
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
                            <p class="text-base font-semibold font-mono text-red-400">{{ format_price($trade->stop_loss) }}
                            </p>
                        </div>

                        <div class="bg-gray-750 rounded-lg p-3 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Take Profit</p>
                            <p class="text-base font-semibold font-mono text-green-400">
                                {{ format_price($trade->take_profit) }}</p>
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
                                        <select name="entry_type" id="entry_type"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Pilih tipe entry</option>
                                            <option value="Limit Order"
                                                {{ $trade->entry_type == 'Limit Order' ? 'selected' : '' }}>Limit Order
                                            </option>
                                            <option value="Market Order"
                                                {{ $trade->entry_type == 'Market Order' ? 'selected' : '' }}>Market Order
                                            </option>
                                            <option value="Stop Order"
                                                {{ $trade->entry_type == 'Stop Order' ? 'selected' : '' }}>Stop Order
                                            </option>
                                        </select>
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
                                        <select name="market_condition" id="market_condition"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-transparent">
                                            <option value="">Pilih kondisi market</option>
                                            <option value="Uptrend"
                                                {{ $trade->market_condition == 'Uptrend' ? 'selected' : '' }}>Uptrend
                                            </option>
                                            <option value="Downtrend"
                                                {{ $trade->market_condition == 'Downtrend' ? 'selected' : '' }}>Downtrend
                                            </option>
                                            <option value="Sideways/Range"
                                                {{ $trade->market_condition == 'Sideways/Range' ? 'selected' : '' }}>
                                                Sideways/Range</option>
                                            <option value="Breakout"
                                                {{ $trade->market_condition == 'Breakout' ? 'selected' : '' }}>Breakout
                                            </option>
                                            <option value="Pullback/Retracement"
                                                {{ $trade->market_condition == 'Pullback/Retracement' ? 'selected' : '' }}>
                                                Pullback/Retracement</option>
                                            <option value="Consolidation"
                                                {{ $trade->market_condition == 'Consolidation' ? 'selected' : '' }}>
                                                Consolidation</option>
                                            <option value="Volatile/Choppy"
                                                {{ $trade->market_condition == 'Volatile/Choppy' ? 'selected' : '' }}>
                                                Volatile/Choppy</option>
                                            <option value="Reversal"
                                                {{ $trade->market_condition == 'Reversal' ? 'selected' : '' }}>Reversal
                                            </option>
                                            <option value="Trend Continuation"
                                                {{ $trade->market_condition == 'Trend Continuation' ? 'selected' : '' }}>
                                                Trend Continuation</option>
                                        </select>
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

                            <!-- Exit Timestamp -->
                            <div class="bg-gray-750 rounded-xl p-4 border border-gray-600">
                                <h3 class="text-lg font-bold mb-4 flex items-center text-indigo-300">
                                    <i class="fas fa-clock text-indigo-400 mr-3"></i>
                                    Exit Timestamp (Tanggal & Jam Keluar)
                                </h3>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-2">
                                        <label for="exit_time" class="block text-sm font-semibold text-gray-300">Jam
                                            Keluar</label>
                                        <input type="time" name="exit_time" id="exit_time"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('H:i') }}">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="exit_date" class="block text-sm font-semibold text-gray-300">Tanggal
                                            Keluar</label>
                                        <input type="date" name="exit_date" id="exit_date"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                                            value="{{ optional($trade->exit_timestamp)->format('Y-m-d') }}">
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
                                        <select name="entry_emotion" id="entry_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">Pilih emosi saat entry</option>
                                            <option value="Confident"
                                                {{ $trade->entry_emotion == 'Confident' ? 'selected' : '' }}>Confident
                                                (Percaya diri)</option>
                                            <option value="Fearful"
                                                {{ $trade->entry_emotion == 'Fearful' ? 'selected' : '' }}>Fearful (Takut)
                                            </option>
                                            <option value="Greedy"
                                                {{ $trade->entry_emotion == 'Greedy' ? 'selected' : '' }}>Greedy (Serakah)
                                            </option>
                                            <option value="Anxious"
                                                {{ $trade->entry_emotion == 'Anxious' ? 'selected' : '' }}>Anxious (Cemas)
                                            </option>
                                            <option value="Hopeful"
                                                {{ $trade->entry_emotion == 'Hopeful' ? 'selected' : '' }}>Hopeful
                                                (Berharap)</option>
                                            <option value="Impatient"
                                                {{ $trade->entry_emotion == 'Impatient' ? 'selected' : '' }}>Impatient
                                                (Tidak sabar)</option>
                                            <option value="Calm"
                                                {{ $trade->entry_emotion == 'Calm' ? 'selected' : '' }}>Calm (Tenang)
                                            </option>
                                            <option value="FOMO"
                                                {{ $trade->entry_emotion == 'FOMO' ? 'selected' : '' }}>FOMO (Fear Of
                                                Missing Out)</option>
                                            <option value="Revenge Trading"
                                                {{ $trade->entry_emotion == 'Revenge Trading' ? 'selected' : '' }}>Revenge
                                                Trading (Balas dendam)</option>
                                            <option value="Overconfident"
                                                {{ $trade->entry_emotion == 'Overconfident' ? 'selected' : '' }}>
                                                Overconfident (Terlalu percaya diri)</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="close_emotion" class="block text-sm font-semibold text-gray-300">
                                            Close Emotion
                                        </label>
                                        <select name="close_emotion" id="close_emotion"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent">
                                            <option value="">Pilih emosi saat close</option>
                                            <option value="Satisfied"
                                                {{ $trade->close_emotion == 'Satisfied' ? 'selected' : '' }}>Satisfied
                                                (Puas)</option>
                                            <option value="Relieved"
                                                {{ $trade->close_emotion == 'Relieved' ? 'selected' : '' }}>Relieved
                                                (Legas)</option>
                                            <option value="Regretful"
                                                {{ $trade->close_emotion == 'Regretful' ? 'selected' : '' }}>Regretful
                                                (Menyesal)</option>
                                            <option value="Frustrated"
                                                {{ $trade->close_emotion == 'Frustrated' ? 'selected' : '' }}>Frustrated
                                                (Frustasi)</option>
                                            <option value="Happy"
                                                {{ $trade->close_emotion == 'Happy' ? 'selected' : '' }}>Happy (Senang)
                                            </option>
                                            <option value="Disappointed"
                                                {{ $trade->close_emotion == 'Disappointed' ? 'selected' : '' }}>
                                                Disappointed (Kecewa)</option>
                                            <option value="Neutral"
                                                {{ $trade->close_emotion == 'Neutral' ? 'selected' : '' }}>Neutral (Netral)
                                            </option>
                                            <option value="Greedy (Holding too long)"
                                                {{ $trade->close_emotion == 'Greedy (Holding too long)' ? 'selected' : '' }}>
                                                Greedy (Holding too long)</option>
                                            <option value="Fearful (Exiting too early)"
                                                {{ $trade->close_emotion == 'Fearful (Exiting too early)' ? 'selected' : '' }}>
                                                Fearful (Exiting too early)</option>
                                            <option value="Angry"
                                                {{ $trade->close_emotion == 'Angry' ? 'selected' : '' }}>Angry (Marah)
                                            </option>
                                            <option value="Learning"
                                                {{ $trade->close_emotion == 'Learning' ? 'selected' : '' }}>Learning
                                                (Mengambil pelajaran)</option>
                                        </select>
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
                                    {{-- <!-- Before Link -->
                                    <div class="space-y-2">
                                        <label for="before_link"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <i class="fas fa-image mr-2 text-primary-400"></i>
                                            Before Entry Screenshot
                                        </label>
                                        <input type="url" name="before_link" id="before_link"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                            value="{{ $trade->before_link }}"
                                            placeholder="https://www.tradingview.com/x/Ha0dhC5t/ atau https://s3.amazonaws.com/image.png">
                                        <p class="text-xs text-gray-500 mt-1">
                                            Dukung TradingView link, S3 URL, atau direct image link (PNG, JPG, GIF, WebP)
                                        </p>
                                    </div> --}}

                                    <!-- After Link -->
                                    <div class="space-y-2">
                                        <label for="after_link"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <i class="fas fa-image mr-2 text-primary-400"></i>
                                            After Entry Screenshot
                                        </label>
                                        <input type="url" name="after_link" id="after_link"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-transparent"
                                            value="{{ $trade->after_link }}"
                                            placeholder="https://www.tradingview.com/x/CHART_ID/ atau https://bucket-name.s3.amazonaws.com/image.png">
                                        <p class="text-xs text-gray-500 mt-1">
                                            Dukung TradingView link, S3 URL, atau direct image link (PNG, JPG, GIF, WebP)
                                        </p>
                                    </div>

                                    <!-- Info Box -->
                                    <div class="bg-primary-900/20 border border-primary-600/30 rounded-lg p-3 mt-3">
                                        <p class="text-xs text-primary-300 flex items-start">
                                            <i class="fas fa-info-circle mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>
                                                <strong>Tipe link yang didukung:</strong>
                                                <br>• TradingView: https://www.tradingview.com/x/CHART_ID/
                                                <br>• S3/AWS: https://fxr-snapshots-asia.s3.amazonaws.com/file.png
                                                <br>• Direct image: https://example.com/chart.png,
                                                https://imgix.example.com/image.jpg
                                                <br>• CDN images dengan berbagai format (PNG, JPG, GIF, WebP)
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
                            Additional Notes & Key Learnings
                        </h3>

                        <div class="space-y-2">
                            <label for="note" class="block text-sm font-semibold text-gray-300">
                                Catatan Tambahan & Pembelajaran
                            </label>

                            <!-- Tombol Generate -->
                            <div class="mb-3">
                                <button type="button" id="generateNoteBtn"
                                    class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center text-sm">
                                    <i class="fas fa-magic mr-2"></i>
                                    Generate Catatan Otomatis
                                </button>
                                <p class="text-xs text-gray-400 mt-1">Klik untuk membuat catatan berdasarkan inputan di
                                    atas</p>
                            </div>

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

                    // Bangun kalimat natural berdasarkan kondisi
                    let note = "";

                    // Bagian 1: Konteks Trading
                    if (entryType && marketCondition) {
                        note +=
                            `Melakukan ${entryType.toLowerCase()} pada kondisi market ${marketCondition.toLowerCase()}. `;
                    }

                    // Bagian 2: Psikologi dan Alasan Entry
                    if (entryEmotion && entryReason) {
                        if (entryEmotion.includes('Confident') || entryEmotion.includes('Calm')) {
                            note +=
                                `Dengan kondisi psikologi ${entryEmotion.toLowerCase()}, entry diambil karena ${entryReason.toLowerCase()}. `;
                        } else if (entryEmotion.includes('Fear') || entryEmotion.includes('Anxious')) {
                            note +=
                                `Meski merasa ${entryEmotion.toLowerCase()}, tetap mengambil posisi karena ${entryReason.toLowerCase()}. `;
                        } else if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            note +=
                                `Entry dilakukan dengan emosi ${entryEmotion.toLowerCase()} karena ${entryReason.toLowerCase()}. `;
                        } else {
                            note +=
                                `Emosi saat entry: ${entryEmotion.toLowerCase()}. Alasan entry: ${entryReason.toLowerCase()}. `;
                        }
                    }

                    // Bagian 3: Risk Management
                    if (whySlTp) {
                        // Potong teks jika terlalu panjang
                        const shortWhySlTp = whySlTp.length > 100 ? whySlTp.substring(0, 100) + '...' : whySlTp;
                        note += `SL/TP ditempatkan ${shortWhySlTp.toLowerCase()} `;
                    }

                    // Bagian 4: Disiplin Trading Rules
                    if (followRules === '1') {
                        note += `Trade ini mengikuti ${selectedRulesCount} trading rules dengan disiplin. `;
                    } else if (followRules === '0') {
                        note += `Trade ini tidak sepenuhnya mengikuti trading rules. `;
                    }

                    // Bagian 5: Psikologi Exit dan Pembelajaran
                    if (closeEmotion) {
                        note += `Saat close, merasa ${closeEmotion.toLowerCase()}. `;
                    }

                    // Bagian 6: Insight berdasarkan hasil (jika ada)
                    const tradeResult = "{{ $trade->hasil }}"; // Ini akan dari server

                    if (tradeResult === 'win') {
                        if (followRules === '1') {
                            note +=
                                `Hasil WIN menunjukkan bahwa mengikuti rules dengan disiplin memberikan hasil positif. `;
                        } else {
                            note += `Meski WIN, perlu evaluasi karena tidak sepenuhnya mengikuti rules. `;
                        }

                        if (entryEmotion.includes('Calm') || entryEmotion.includes('Confident')) {
                            note += `Psikologi yang baik berkontribusi pada keberhasilan trade ini. `;
                        }
                    } else if (tradeResult === 'loss') {
                        if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            note += `Loss terjadi kemungkinan karena trading dengan emosi negatif. `;
                        } else if (followRules === '0') {
                            note += `Loss mengingatkan pentingnya konsisten dengan trading rules. `;
                        } else {
                            note += `Meski loss, trade ini tetap memberikan pembelajaran berharga. `;
                        }
                    }

                    // Bagian 7: Actionable insight
                    if (note.length > 0) {
                        note += "\n\nPembelajaran: ";

                        const insights = [];

                        // Insight berdasarkan psikologi entry
                        if (entryEmotion.includes('FOMO') || entryEmotion.includes('Revenge')) {
                            insights.push("hindari trading berdasarkan emosi negatif");
                        } else if (entryEmotion.includes('Calm') || entryEmotion.includes('Confident')) {
                            insights.push("pertahankan psikologi yang stabil");
                        }

                        // Insight berdasarkan follow rules
                        if (followRules === '1' && selectedRulesCount > 3) {
                            insights.push("disiplin mengikuti rules memberikan konsistensi");
                        } else if (followRules === '0') {
                            insights.push("perlu meningkatkan kedisiplinan dalam mengikuti rules");
                        }

                        // Insight berdasarkan market condition
                        if (marketCondition.includes('Trend')) {
                            insights.push("trading dengan trend memberikan probabilitas lebih tinggi");
                        } else if (marketCondition.includes('Volatile') || marketCondition.includes('Choppy')) {
                            insights.push("perlu extra caution pada kondisi market yang volatile");
                        }

                        // Gabungkan insights
                        if (insights.length > 0) {
                            note += insights.join(", ") + ".";
                        } else {
                            note += "evaluasi lebih lanjut diperlukan untuk trade ini.";
                        }

                        // Bagian 8: Action untuk next trade
                        if (followRules === '0' || entryEmotion.includes('FOMO') || entryEmotion.includes(
                                'Revenge')) {
                            note += `\n\nAction: Fokus pada trading plan dan hindari impulsive decisions.`;
                        } else {
                            note += `\n\nAction: Pertahankan konsistensi dan terus review setup yang bekerja.`;
                        }
                    } else {
                        note = "Silakan isi beberapa field terlebih dahulu untuk generate catatan otomatis.";
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
                            button.innerHTML = '<i class="fas fa-check mr-2"></i>Catatan Digenerate!';
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
                    alert('Terjadi error saat generate catatan. Lihat console untuk detail.');
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
                            '<i class="fas fa-spinner animate-spin mr-2"></i>Menyimpan...';
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
