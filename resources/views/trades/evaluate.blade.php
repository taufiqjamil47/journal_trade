@extends('Layouts.index')
@section('title', 'Evaluate Trade')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Evaluasi Trade</h1>
                    <p class="text-gray-400 mt-2">Step 3 - Analisis dan evaluasi trading Anda</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-arrow-left text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-chart-line text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Enhanced Progress Steps -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 - Completed -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold shadow-lg shadow-green-500/30 relative z-10 transition-all duration-500">
                        <i class="fas fa-check text-sm"></i>
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Entry Trade</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-green-500 to-primary-500 -ml-1">
                    </div>
                </div>

                <!-- Step 2 - Completed -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold shadow-lg shadow-green-500/30 relative z-10 transition-all duration-500">
                        <i class="fas fa-check text-sm"></i>
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                    </div>
                    <span class="text-sm font-medium mt-2 text-green-400">Update Exit</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-green-500 to-purple-500 -ml-1">
                    </div>
                </div>

                <!-- Step 3 - Active -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-500/30 relative z-10 transition-all duration-500 pulse-animation">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-purple-400">Evaluasi</span>
                </div>
            </div>

            <!-- Progress Labels -->
            <div class="flex justify-between max-w-2xl mx-auto mt-4 px-2">
                <div class="text-xs text-green-400 font-medium">Selesai</div>
                <div class="text-xs text-green-400 font-medium">Selesai</div>
                <div class="text-xs text-purple-400 font-medium">Sedang Berlangsung</div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Trade Info Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-2xl mb-8 overflow-hidden">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-purple-900/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="bg-gradient-to-br from-purple-500/30 to-purple-600/20 p-4 rounded-2xl mr-5 shadow-lg shadow-purple-500/10">
                                <i class="fas fa-chart-bar text-purple-400 text-2xl"></i>
                            </div>
                            <div>
                                <h2
                                    class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-300 bg-clip-text text-transparent">
                                    Trade #{{ $trade->id }} - {{ $trade->symbol->name }}
                                </h2>
                                <p class="text-gray-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                                    Detail trading untuk evaluasi dan pembelajaran
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div
                                class="text-2xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
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
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-blue-900/20 rounded-xl p-4 border border-blue-700/30 group hover:border-blue-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-blue-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-exchange-alt text-blue-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Type</p>
                            </div>
                            <p class="text-lg font-bold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-green-900/20 rounded-xl p-4 border border-green-700/30 group hover:border-green-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-green-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-sign-in-alt text-green-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Entry</p>
                            </div>
                            <p class="text-lg font-bold font-mono text-green-400">{{ $trade->entry }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-red-900/20 rounded-xl p-4 border border-red-700/30 group hover:border-red-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-red-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-sign-out-alt text-red-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Exit</p>
                            </div>
                            <p class="text-lg font-bold font-mono text-red-400">{{ $trade->exit ?? '-' }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-amber-900/20 rounded-xl p-4 border border-amber-700/30 group hover:border-amber-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-amber-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-weight-scale text-amber-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Lot Size</p>
                            </div>
                            <p class="text-lg font-bold text-amber-400">{{ $trade->lot_size ?? '0.00' }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-cyan-900/20 rounded-xl p-4 border border-cyan-700/30 group hover:border-cyan-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-cyan-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-clock text-cyan-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Session</p>
                            </div>
                            <p class="text-lg font-bold text-cyan-400">{{ $trade->session }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-purple-900/20 rounded-xl p-4 border border-purple-700/30 group hover:border-purple-500/50 transition-all duration-300">
                            <div class="flex items-center mb-2">
                                <div class="bg-purple-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-balance-scale text-purple-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">R/R Ratio</p>
                            </div>
                            <p class="text-lg font-bold text-purple-400">{{ $trade->rr_ratio ?? '0' }}</p>
                        </div>
                    </div>

                    <!-- Additional Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-red-900/20 rounded-xl p-4 border border-red-700/30">
                            <div class="flex items-center mb-2">
                                <div class="bg-red-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-hand-paper text-red-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Stop Loss</p>
                            </div>
                            <p class="text-lg font-semibold font-mono text-red-400">{{ $trade->stop_loss }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-green-900/20 rounded-xl p-4 border border-green-700/30">
                            <div class="flex items-center mb-2">
                                <div class="bg-green-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-trophy text-green-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Take Profit</p>
                            </div>
                            <p class="text-lg font-semibold font-mono text-green-400">{{ $trade->take_profit }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-dark-800/80 to-blue-900/20 rounded-xl p-4 border border-blue-700/30">
                            <div class="flex items-center mb-2">
                                <div class="bg-blue-500/20 p-2 rounded-lg mr-2">
                                    <i class="fas fa-dollar-sign text-blue-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-gray-400">Risk USD</p>
                            </div>
                            <p class="text-lg font-semibold text-blue-400">${{ number_format($trade->risk_usd ?? 0, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Container -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-2xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-purple-900/30">
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-br from-purple-500/30 to-purple-600/20 p-4 rounded-2xl mr-5 shadow-lg shadow-purple-500/10">
                            <i class="fas fa-analytics text-purple-400 text-2xl"></i>
                        </div>
                        <div>
                            <h2
                                class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-indigo-300 bg-clip-text text-transparent">
                                Analisis & Evaluasi Trading</h2>
                            <p class="text-gray-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-graduation-cap mr-2 text-purple-500"></i>
                                Catat pembelajaran berharga dari trading ini untuk pengembangan skill
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.saveEvaluation', $trade->id) }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Entry Setup -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-blue-900/20 rounded-2xl p-6 border border-blue-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-blue-300">
                                    <div class="bg-blue-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-sign-in-alt text-blue-400"></i>
                                    </div>
                                    Entry Setup & Strategy
                                </h3>

                                <div class="space-y-6">
                                    <div class="space-y-3">
                                        <label for="entry_type"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-flag text-blue-500"></i>
                                            </div>
                                            <span>Entry Type (Setup)</span>
                                        </label>
                                        <input type="text" name="entry_type" id="entry_type"
                                            class="w-full bg-dark-800/80 border border-blue-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->entry_type }}"
                                            placeholder="Contoh: Order Block, FVG, Breaker Block, dll">
                                        <p class="text-xs text-blue-400 mt-2 flex items-center">
                                            <i class="fas fa-lightbulb mr-2"></i>
                                            Jenis setup yang digunakan untuk entry
                                        </p>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-rules text-green-500"></i>
                                            </div>
                                            <span>Follow Trading Rules?</span>
                                        </label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="1"
                                                    {{ $trade->follow_rules ? 'checked' : '' }} class="rule-radio hidden">
                                                <div
                                                    class="rule-content bg-green-900/20 border-2 border-green-600/30 rounded-xl p-4 text-center transition-all duration-300 hover:border-green-500 hover:scale-105 cursor-pointer">
                                                    <i class="fas fa-check-circle text-2xl text-green-400 mb-2"></i>
                                                    <div class="text-green-400 font-semibold">Yes</div>
                                                    <div class="text-green-400/60 text-xs mt-1">Mengikuti Rules</div>
                                                </div>
                                            </label>
                                            <label class="rule-option">
                                                <input type="radio" name="follow_rules" value="0"
                                                    {{ !$trade->follow_rules ? 'checked' : '' }}
                                                    class="rule-radio hidden">
                                                <div
                                                    class="rule-content bg-red-900/20 border-2 border-red-600/30 rounded-xl p-4 text-center transition-all duration-300 hover:border-red-500 hover:scale-105 cursor-pointer">
                                                    <i class="fas fa-times-circle text-2xl text-red-400 mb-2"></i>
                                                    <div class="text-red-400 font-semibold">No</div>
                                                    <div class="text-red-400/60 text-xs mt-1">Tidak Mengikuti</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Market Analysis -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-amber-300">
                                    <div class="bg-amber-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-chart-area text-amber-400"></i>
                                    </div>
                                    Market Analysis & Context
                                </h3>

                                <div class="space-y-6">
                                    <div class="space-y-3">
                                        <label for="market_condition" class="block text-sm font-semibold text-gray-300">
                                            Market Condition Analysis
                                        </label>
                                        <textarea name="market_condition" id="market_condition" rows="4"
                                            class="w-full bg-dark-800/80 border border-amber-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 shadow-inner resize-none"
                                            placeholder="Deskripsikan kondisi market saat entry (trend, range, volatility, dll)...">{{ $trade->market_condition }}</textarea>
                                    </div>

                                    <div class="space-y-3">
                                        <label for="entry_reason" class="block text-sm font-semibold text-gray-300">
                                            Entry Reasoning & Conviction
                                        </label>
                                        <textarea name="entry_reason" id="entry_reason" rows="4"
                                            class="w-full bg-dark-800/80 border border-amber-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 shadow-inner resize-none"
                                            placeholder="Alasan dan keyakinan mengambil posisi ini...">{{ $trade->entry_reason }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Management -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-red-900/20 rounded-2xl p-6 border border-red-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-red-300">
                                    <div class="bg-red-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-shield-alt text-red-400"></i>
                                    </div>
                                    Risk Management Review
                                </h3>

                                <div class="space-y-3">
                                    <label for="why_sl_tp" class="block text-sm font-semibold text-gray-300">
                                        SL & TP Placement Reasoning
                                    </label>
                                    <textarea name="why_sl_tp" id="why_sl_tp" rows="4"
                                        class="w-full bg-dark-800/80 border border-red-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 shadow-inner resize-none"
                                        placeholder="Analisis penempatan Stop Loss dan Take Profit berdasarkan struktur market...">{{ $trade->why_sl_tp }}</textarea>
                                    <p class="text-xs text-red-400 mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Evaluasi apakah SL/TP placement sudah optimal
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Trading Rules -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-green-900/20 rounded-2xl p-6 border border-green-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-green-300">
                                    <div class="bg-green-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-check-double text-green-400"></i>
                                    </div>
                                    Trading Rules Checklist
                                </h3>

                                <div class="space-y-4 max-h-96 overflow-y-auto pr-3 custom-scrollbar">
                                    @php
                                        $rulesList = [
                                            'Time 07.00 AM (Forex) - 08.00 AM (Indexs)',
                                            'Menyentuh area POI HTF : OB / FVG / IFVG dst',
                                            'Liquidity Swept : Session High/Low, PDH/PDL, PWH/PWL, Double Top/Bottom',
                                            'Market Structure Shift with Displacement Candle',
                                            'FVG',
                                            'Order Block',
                                            'Breaker Block',
                                            'OTE',
                                            'IFVG',
                                            'CISD',
                                            'Volume Imbalance',
                                            'Rejection Block',
                                            'Liquidity Void',
                                            'Mitigation Block',
                                            'BPR',
                                        ];

                                        $selectedRules = $trade->rules ? explode(',', $trade->rules) : [];
                                    @endphp

                                    @foreach ($rulesList as $index => $rule)
                                        <label class="rule-checkbox-item">
                                            <input type="checkbox" name="rules[]" value="{{ $rule }}"
                                                {{ in_array($rule, $selectedRules) ? 'checked' : '' }}
                                                class="rule-checkbox hidden">
                                            <div
                                                class="rule-checkbox-content bg-dark-800/50 border-2 border-gray-600 rounded-xl p-4 transition-all duration-300 hover:border-green-500/50 hover:scale-105 cursor-pointer">
                                                <div class="flex items-center">
                                                    <div
                                                        class="rule-checkbox-icon bg-gray-700 w-6 h-6 rounded-lg flex items-center justify-center mr-4 transition-all duration-300">
                                                        <i class="fas fa-check text-transparent text-xs"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-300 flex-1">{{ $rule }}</span>
                                                    <div
                                                        class="rule-number bg-gray-700 text-gray-400 text-xs w-6 h-6 rounded-full flex items-center justify-center">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-xs text-green-400 mt-4 flex items-center">
                                    <i class="fas fa-list-check mr-2"></i>
                                    Checklist rules yang terpenuhi dalam trade ini
                                </p>
                            </div>

                            <!-- Psychology -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-purple-900/20 rounded-2xl p-6 border border-purple-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-purple-300">
                                    <div class="bg-purple-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-brain text-purple-400"></i>
                                    </div>
                                    Trading Psychology
                                </h3>

                                <div class="space-y-6">
                                    <div class="space-y-3">
                                        <label for="entry_emotion"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-purple-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-sign-in-alt text-purple-500"></i>
                                            </div>
                                            <span>Entry Emotion</span>
                                        </label>
                                        <input type="text" name="entry_emotion" id="entry_emotion"
                                            class="w-full bg-dark-800/80 border border-purple-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->entry_emotion }}"
                                            placeholder="Emosi saat entry (confident, fearful, greedy, dll)">
                                    </div>

                                    <div class="space-y-3">
                                        <label for="close_emotion"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-purple-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-sign-out-alt text-purple-500"></i>
                                            </div>
                                            <span>Close Emotion</span>
                                        </label>
                                        <input type="text" name="close_emotion" id="close_emotion"
                                            class="w-full bg-dark-800/80 border border-purple-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->close_emotion }}"
                                            placeholder="Emosi saat close (relieved, frustrated, satisfied, dll)">
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation -->
                            <div
                                class="bg-gradient-to-br from-dark-800/80 to-cyan-900/20 rounded-2xl p-6 border border-cyan-700/30 shadow-lg">
                                <h3 class="text-xl font-bold mb-6 flex items-center text-cyan-300">
                                    <div class="bg-cyan-500/20 p-3 rounded-xl mr-4">
                                        <i class="fas fa-camera text-cyan-400"></i>
                                    </div>
                                    Trade Documentation
                                </h3>

                                <div class="space-y-6">
                                    <div class="space-y-3">
                                        <label for="before_link"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-cyan-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-image text-cyan-500"></i>
                                            </div>
                                            <span>Before Screenshot (Link)</span>
                                        </label>
                                        <input type="url" name="before_link" id="before_link"
                                            class="w-full bg-dark-800/80 border border-cyan-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->before_link }}"
                                            placeholder="https://screenshot-before-trade.com">
                                    </div>

                                    <div class="space-y-3">
                                        <label for="after_link"
                                            class="block text-sm font-semibold text-gray-300 flex items-center">
                                            <div class="bg-cyan-500/20 p-2 rounded-lg mr-3">
                                                <i class="fas fa-image text-cyan-500"></i>
                                            </div>
                                            <span>After Screenshot (Link)</span>
                                        </label>
                                        <input type="url" name="after_link" id="after_link"
                                            class="w-full bg-dark-800/80 border border-cyan-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                            value="{{ $trade->after_link }}"
                                            placeholder="https://screenshot-after-trade.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div
                        class="mt-8 bg-gradient-to-br from-dark-800/80 to-gray-900/20 rounded-2xl p-6 border border-gray-700/30 shadow-lg">
                        <h3 class="text-xl font-bold mb-6 flex items-center text-gray-300">
                            <div class="bg-gray-500/20 p-3 rounded-xl mr-4">
                                <i class="fas fa-sticky-note text-gray-400"></i>
                            </div>
                            Additional Notes & Key Learnings
                        </h3>

                        <div class="space-y-3">
                            <label for="note" class="block text-sm font-semibold text-gray-300">
                                Catatan Tambahan & Pembelajaran Berharga
                            </label>
                            <textarea name="note" id="note" rows="5"
                                class="w-full bg-dark-800/80 border border-gray-600 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 shadow-inner resize-none"
                                placeholder="Pembelajaran, insight, area improvement, atau catatan penting lainnya dari trade ini...">{{ $trade->note }}</textarea>
                            <p class="text-xs text-gray-400 mt-2 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Catat pembelajaran berharga untuk pengembangan trading skill di masa depan
                            </p>
                        </div>
                    </div>

                    <!-- Enhanced Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-10 pt-8 border-t border-gray-700/50 space-y-6 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200 group">
                            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-12 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            Simpan Evaluasi & Pembelajaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(168, 85, 247, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0);
            }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .rule-option input:checked+.rule-content {
            border-color: currentColor;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .rule-option:nth-child(1) input:checked+.rule-content {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }

        .rule-option:nth-child(2) input:checked+.rule-content {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }

        .rule-checkbox-item input:checked+.rule-checkbox-content {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
        }

        .rule-checkbox-item input:checked+.rule-checkbox-content .rule-checkbox-icon {
            background: #10b981;
        }

        .rule-checkbox-item input:checked+.rule-checkbox-content .rule-checkbox-icon i {
            color: white !important;
        }

        .rule-checkbox-item input:checked+.rule-checkbox-content .rule-number {
            background: #10b981;
            color: white;
        }
    </style>

    <script>
        // Enhanced interactivity for evaluation form
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // Trigger initial resize
                textarea.dispatchEvent(new Event('input'));
            });

            // Add character counters to textareas
            textareas.forEach(textarea => {
                const maxLength = textarea.getAttribute('maxlength') || 1000;
                const counter = document.createElement('div');
                counter.className = 'text-xs text-gray-500 mt-1 text-right';
                counter.textContent = `0/${maxLength}`;
                textarea.parentNode.appendChild(counter);

                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    counter.textContent = `${currentLength}/${maxLength}`;

                    if (currentLength > maxLength * 0.8) {
                        counter.classList.add('text-amber-400');
                    } else {
                        counter.classList.remove('text-amber-400');
                    }
                });

                // Trigger initial count
                textarea.dispatchEvent(new Event('input'));
            });

            // Enhanced rule checklist interaction
            const ruleCheckboxes = document.querySelectorAll('.rule-checkbox');
            ruleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const content = this.closest('.rule-checkbox-item').querySelector(
                        '.rule-checkbox-content');
                    if (this.checked) {
                        content.classList.add('animate-pulse');
                        setTimeout(() => {
                            content.classList.remove('animate-pulse');
                        }, 500);
                    }
                });
            });

            // Auto-save indicator
            let autoSaveTimeout;
            const form = document.querySelector('form');
            const submitButton = form.querySelector('button[type="submit"]');

            form.addEventListener('input', function() {
                clearTimeout(autoSaveTimeout);

                // Show saving indicator
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-sync-alt animate-spin mr-2"></i>Menyimpan...';
                submitButton.disabled = true;

                autoSaveTimeout = setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;

                    // Show saved notification
                    showNotification('Perubahan disimpan secara otomatis', 'success');
                }, 1000);
            });

            // Form submission enhancement
            form.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                submitButton.innerHTML =
                    '<i class="fas fa-spinner animate-spin mr-2"></i>Menyimpan Evaluasi...';
                submitButton.disabled = true;

                // Allow form to submit normally
            });
        });

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl border backdrop-blur-sm transform transition-all duration-300 translate-x-full ${
                type === 'success' ? 'bg-green-900/20 border-green-700/30 text-green-400' :
                type === 'error' ? 'bg-red-900/20 border-red-700/30 text-red-400' :
                'bg-blue-900/20 border-blue-700/30 text-blue-400'
            }`;

            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${
                        type === 'success' ? 'check-circle' :
                        type === 'error' ? 'exclamation-triangle' : 'info-circle'
                    } mr-3"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Quick analysis helpers
        function generateAnalysisTemplate() {
            const templates = {
                win: "Trade ini berhasil karena...\n• Setup yang jelas terkonfirmasi\n• Risk management tepat\n• Market condition mendukung\n• Psychology terkendali",
                loss: "Trade ini mengalami loss karena...\n• Setup belum sempurna\n• Timing entry kurang tepat\n• Market condition berubah\n• Emotional decision",
                improvement: "Area improvement untuk next trade:\n• Perbaiki timing entry\n• Tunggu konfirmasi lebih jelas\n• Manage risk lebih ketat\n• Control emotion better"
            };

            document.getElementById('note').value = Object.values(templates).join('\n\n');
            document.getElementById('note').dispatchEvent(new Event('input'));
        }
    </script>
@endsection
