@extends('Layouts.index')
@section('title', 'New Trade')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Tambah Trade Baru</h1>
                    <p class="text-gray-400 mt-2">Step 1 - Masukkan detail entry trading Anda</p>
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
                <!-- Step 1 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/30 relative z-10 transition-all duration-500">
                        1
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Entry Trade</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-primary-500 to-gray-700 -ml-1">
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-400/30 to-primary-500/30 flex items-center justify-center text-primary-300 font-bold border-2 border-primary-500/50 shadow-lg shadow-primary-500/10 relative z-10 transition-all duration-500 group hover:scale-110 hover:bg-primary-500/40">
                        2
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-300">Update Exit</span>
                    <div class="absolute top-6 left-full w-full h-0.5 bg-gradient-to-r from-gray-700 to-gray-700 -ml-1">
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-gray-500 font-bold border-2 border-gray-700 shadow-lg transition-all duration-500 group hover:border-primary-500/30 hover:text-primary-400/70">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-gray-500">Evaluasi</span>
                </div>
            </div>

            <!-- Progress Labels -->
            <div class="flex justify-between max-w-2xl mx-auto mt-4 px-2">
                <div class="text-xs text-primary-400 font-medium">Isi Detail Entry</div>
                <div class="text-xs text-gray-500 font-medium">Update Exit Nanti</div>
                <div class="text-xs text-gray-500 font-medium">Evaluasi Hasil</div>
            </div>
        </div>

        <!-- Enhanced Form Container -->
        <div class="max-w-5xl mx-auto">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-2xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-dark-900/80">
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-br from-primary-500/30 to-primary-600/20 p-4 rounded-2xl mr-5 shadow-lg shadow-primary-500/10">
                            <i class="fas fa-plus-circle text-primary-400 text-2xl"></i>
                        </div>
                        <div>
                            <h2
                                class="text-2xl font-bold bg-gradient-to-r from-primary-400 to-cyan-300 bg-clip-text text-transparent">
                                Detail Entry Trade</h2>
                            <p class="text-gray-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                                Isi informasi trading dengan benar untuk perhitungan risk yang optimal
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Symbol Selection -->
                            <div class="space-y-3">
                                <label for="symbol_id" class="block text-sm font-semibold text-gray-300 flex items-center">
                                    <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-chart-line text-primary-500"></i>
                                    </div>
                                    <span>Symbol / Pair Trading</span>
                                </label>
                                <select name="symbol_id"
                                    class="w-full bg-dark-800/80 border border-gray-700 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 shadow-inner">
                                    @foreach ($symbols as $symbol)
                                        <option value="{{ $symbol->id }}" class="bg-dark-800">{{ $symbol->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trade Type -->
                            <div class="space-y-3">
                                <label for="type" class="block text-sm font-semibold text-gray-300 flex items-center">
                                    <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-exchange-alt text-primary-500"></i>
                                    </div>
                                    <span>Jenis Trade</span>
                                </label>
                                <select name="type"
                                    class="w-full bg-dark-800/80 border border-gray-700 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                    required>
                                    <option value="buy" class="bg-dark-800">Buy / Long</option>
                                    <option value="sell" class="bg-dark-800">Sell / Short</option>
                                </select>
                            </div>

                            <!-- Timestamp & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="timestamp"
                                        class="block text-sm font-semibold text-gray-300 flex items-center">
                                        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                            <i class="fas fa-clock text-primary-500"></i>
                                        </div>
                                        <span>Waktu Entry</span>
                                    </label>
                                    <input type="datetime-local" name="timestamp"
                                        class="w-full bg-dark-800/80 border border-gray-700 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                        required>
                                </div>

                                <div class="space-y-3">
                                    <label for="date"
                                        class="block text-sm font-semibold text-gray-300 flex items-center">
                                        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                            <i class="fas fa-calendar text-primary-500"></i>
                                        </div>
                                        <span>Tanggal Trade</span>
                                    </label>
                                    <input type="date" name="date"
                                        class="w-full bg-dark-800/80 border border-gray-700 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Entry Price -->
                            <div class="space-y-3">
                                <label for="entry" class="block text-sm font-semibold text-gray-300 flex items-center">
                                    <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-sign-in-alt text-primary-500"></i>
                                    </div>
                                    <span>Harga Entry</span>
                                </label>
                                <input type="number" step="0.00001" name="entry"
                                    class="w-full bg-dark-800/80 border border-gray-700 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                    placeholder="0.00000" required>
                            </div>

                            <!-- Stop Loss & Take Profit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="stop_loss"
                                        class="block text-sm font-semibold text-gray-300 flex items-center">
                                        <div class="bg-red-500/20 p-2 rounded-lg mr-3">
                                            <i class="fas fa-hand-paper text-red-500"></i>
                                        </div>
                                        <span>Stop Loss</span>
                                    </label>
                                    <input type="number" step="0.00001" name="stop_loss"
                                        class="w-full bg-dark-800/80 border border-red-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                        placeholder="0.00000" required>
                                    <!-- HIDDEN INPUT UNTUK RR RATIO -->
                                    <input type="hidden" name="rr_ratio" id="rr_ratio" value="0">
                                </div>

                                <div class="space-y-3">
                                    <label for="take_profit"
                                        class="block text-sm font-semibold text-gray-300 flex items-center">
                                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                            <i class="fas fa-trophy text-green-500"></i>
                                        </div>
                                        <span>Take Profit</span>
                                    </label>
                                    <input type="number" step="0.00001" name="take_profit"
                                        class="w-full bg-dark-800/80 border border-green-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                        placeholder="0.00000" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Risk Calculator -->
                    <div class="mt-10">
                        <div
                            class="bg-gradient-to-br from-dark-800 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30 shadow-lg relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div
                                class="absolute top-0 right-0 w-40 h-40 bg-amber-500/5 rounded-full -translate-y-20 translate-x-20">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-32 h-32 bg-amber-500/5 rounded-full translate-y-16 -translate-x-16">
                            </div>

                            <!-- Header dengan Icon Animasi -->
                            <div class="flex items-center justify-between mb-6 relative z-10">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="bg-amber-500/20 p-3 rounded-xl mr-4 shadow-lg shadow-amber-500/10">
                                            <i class="fas fa-calculator text-amber-400 text-xl"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-amber-300">Smart Risk Calculator</h3>
                                        <p class="text-amber-200/70 text-sm mt-1">Live calculation based on current equity
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-amber-400">$<span
                                            id="currentEquity">{{ number_format($currentEquity, 2) }}</span></div>
                                    <div class="text-xs text-amber-300/70">Current Equity</div>
                                </div>
                            </div>

                            <!-- Risk Metrics Grid -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 relative z-10">
                                <!-- Risk/Reward Card -->
                                <div
                                    class="bg-gradient-to-br from-amber-900/30 to-amber-800/20 rounded-xl p-4 border border-amber-600/30 group hover:border-amber-500/50 transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-amber-500/20 p-2 rounded-lg">
                                            <i class="fas fa-balance-scale text-amber-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-amber-400 text-xs font-semibold bg-amber-500/10 px-2 py-1 rounded-full">
                                            R:R</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Risk/Reward Ratio</p>
                                    <p class="text-2xl font-bold text-amber-300" id="riskRewardRatio">-</p>
                                    <div class="h-1 bg-amber-500/20 rounded-full mt-2">
                                        <div id="ratioBar"
                                            class="h-1 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full transition-all duration-500"
                                            style="width: 0%"></div>
                                    </div>
                                </div>

                                <!-- SL Distance Card -->
                                <div
                                    class="bg-gradient-to-br from-red-900/30 to-red-800/20 rounded-xl p-4 border border-red-600/30 group hover:border-red-500/50 transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-red-500/20 p-2 rounded-lg">
                                            <i class="fas fa-hand-paper text-red-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-red-400 text-xs font-semibold bg-red-500/10 px-2 py-1 rounded-full">
                                            SL</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Stop Loss Distance</p>
                                    <p class="text-2xl font-bold text-red-300" id="slPips">-</p>
                                    <p class="text-xs text-red-400/70 mt-1">pips</p>
                                </div>

                                <!-- TP Distance Card -->
                                <div
                                    class="bg-gradient-to-br from-green-900/30 to-green-800/20 rounded-xl p-4 border border-green-600/30 group hover:border-green-500/50 transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-green-500/20 p-2 rounded-lg">
                                            <i class="fas fa-trophy text-green-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-green-400 text-xs font-semibold bg-green-500/10 px-2 py-1 rounded-full">
                                            TP</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Take Profit Distance</p>
                                    <p class="text-2xl font-bold text-green-300" id="tpPips">-</p>
                                    <p class="text-xs text-green-400/70 mt-1">pips</p>
                                </div>

                                <!-- Lot Size Card -->
                                <div
                                    class="bg-gradient-to-br from-cyan-900/30 to-cyan-800/20 rounded-xl p-4 border border-cyan-600/30 group hover:border-cyan-500/50 transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="bg-cyan-500/20 p-2 rounded-lg">
                                            <i class="fas fa-weight-scale text-cyan-400 text-sm"></i>
                                        </div>
                                        <div
                                            class="text-cyan-400 text-xs font-semibold bg-cyan-500/10 px-2 py-1 rounded-full">
                                            LOT</div>
                                    </div>
                                    <p class="text-gray-400 text-xs mb-1">Recommended Lot Size</p>
                                    <p class="text-2xl font-bold text-cyan-300" id="positionSize">-</p>
                                    <p class="text-xs text-cyan-400/70 mt-1" id="riskAmountDisplay">-</p>
                                </div>
                            </div>

                            <!-- Risk Level Selector -->
                            <div class="bg-dark-800/50 rounded-xl p-4 border border-gray-700/50 relative z-10">
                                <h4 class="text-sm font-semibold text-amber-300 mb-3 flex items-center">
                                    <i class="fas fa-sliders-h mr-2 text-amber-400"></i>
                                    Risk Management Level
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                                    <!-- Conservative -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="1"
                                            class="risk-percent-radio hidden" checked>
                                        <div
                                            class="risk-level-content bg-green-900/20 border-2 border-green-600/30 rounded-xl p-4 transition-all duration-300 hover:border-green-500 hover:scale-105 cursor-pointer">
                                            <div class="text-center">
                                                <div class="text-green-400 text-lg font-bold">1%</div>
                                                <div class="text-green-300 text-xs mt-1">Conservative</div>
                                                <div class="text-green-400/60 text-xs mt-2">Safe</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Moderate -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="2"
                                            class="risk-percent-radio hidden">
                                        <div
                                            class="risk-level-content bg-blue-900/20 border-2 border-blue-600/30 rounded-xl p-4 transition-all duration-300 hover:border-blue-500 hover:scale-105 cursor-pointer">
                                            <div class="text-center">
                                                <div class="text-blue-400 text-lg font-bold">2%</div>
                                                <div class="text-blue-300 text-xs mt-1">Moderate</div>
                                                <div class="text-blue-400/60 text-xs mt-2">Balanced</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Aggressive -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="3"
                                            class="risk-percent-radio hidden">
                                        <div
                                            class="risk-level-content bg-orange-900/20 border-2 border-orange-600/30 rounded-xl p-4 transition-all duration-300 hover:border-orange-500 hover:scale-105 cursor-pointer">
                                            <div class="text-center">
                                                <div class="text-orange-400 text-lg font-bold">3%</div>
                                                <div class="text-orange-300 text-xs mt-1">Aggressive</div>
                                                <div class="text-orange-400/60 text-xs mt-2">Growth</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- High Risk -->
                                    <label class="risk-level-card">
                                        <input type="radio" name="risk_percent" value="5"
                                            class="risk-percent-radio hidden">
                                        <div
                                            class="risk-level-content bg-red-900/20 border-2 border-red-600/30 rounded-xl p-4 transition-all duration-300 hover:border-red-500 hover:scale-105 cursor-pointer">
                                            <div class="text-center">
                                                <div class="text-red-400 text-lg font-bold">5%</div>
                                                <div class="text-red-300 text-xs mt-1">High Risk</div>
                                                <div class="text-red-400/60 text-xs mt-2">Expert</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Quick Status Bar -->
                            <div class="mt-4 bg-dark-800/30 rounded-lg p-3 border border-gray-600/30 relative z-10">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-info-circle mr-2 text-amber-400"></i>
                                        <span>Risk management aktif berdasarkan equity real-time</span>
                                    </div>
                                    <div id="calculationStatus" class="text-amber-400 font-semibold">
                                        <i class="fas fa-sync-alt animate-spin mr-1"></i>
                                        Ready
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-10 pt-8 border-t border-gray-700/50 space-y-4 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200 group">
                            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-semibold py-3.5 px-10 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            Simpan Trade
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div
                class="mt-8 bg-gradient-to-br from-amber-900/20 to-amber-800/10 backdrop-blur-sm rounded-2xl p-6 border border-amber-700/30">
                <div class="flex items-start">
                    <div class="bg-amber-500/20 p-3 rounded-xl mr-4">
                        <i class="fas fa-lightbulb text-amber-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-amber-300">Risk Management Tips</h3>
                        <ul class="mt-2 space-y-2 text-amber-100/80 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                <strong>Equity Aktual: ${{ number_format($currentEquity, 2) }}</strong> - Lot size
                                disesuaikan secara otomatis
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk 1-2% untuk konservatif, 3-5% untuk agresif (sesuaikan dengan style trading)
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Risk/Reward ratio minimal 1:1.5 untuk trading yang profitable
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1 text-amber-500 text-xs"></i>
                                Lot size akan dihitung ulang saat update exit berdasarkan equity terbaru
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .risk-level-card input:checked+.risk-level-content {
            border-color: currentColor;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        .risk-level-card:nth-child(1) input:checked+.risk-level-content {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }

        .risk-level-card:nth-child(2) input:checked+.risk-level-content {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .risk-level-card:nth-child(3) input:checked+.risk-level-content {
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
        }

        .risk-level-card:nth-child(4) input:checked+.risk-level-content {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }
    </style>

    <script>
        // Enhanced Risk Calculator dengan EQUITY DINAMIS
        function calculateRisk() {
            const entry = parseFloat(document.querySelector('input[name="entry"]').value) || 0;
            const stopLoss = parseFloat(document.querySelector('input[name="stop_loss"]').value) || 0;
            const takeProfit = parseFloat(document.querySelector('input[name="take_profit"]').value) || 0;
            const type = document.querySelector('select[name="type"]').value;

            if (entry && stopLoss && takeProfit) {
                let slDistance, tpDistance;

                // Hitung distance - SAMA DENGAN CONTROLLER
                if (type === 'buy') {
                    slDistance = Math.abs(entry - stopLoss);
                    tpDistance = Math.abs(takeProfit - entry);
                } else {
                    slDistance = Math.abs(stopLoss - entry);
                    tpDistance = Math.abs(entry - takeProfit);
                }

                // GUNAKAN PIP VALUE YANG REALISTIS
                const pipValue = 0.00010;

                // Hitung pips - SAMA DENGAN CONTROLLER
                const slPips = slDistance / pipValue;
                const tpPips = tpDistance / pipValue;

                // Update SL & TP Pips display
                document.getElementById('slPips').textContent = `${slPips.toFixed(1)} pips`;
                document.getElementById('tpPips').textContent = `${tpPips.toFixed(1)} pips`;

                // Calculate Risk/Reward Ratio
                const ratio = slPips > 0 ? (tpPips / slPips) : 0;
                const ratioDisplay = ratio > 0 ? `1:${ratio.toFixed(2)}` : '-';
                document.getElementById('riskRewardRatio').textContent = ratioDisplay;
                document.getElementById('rr_ratio').value = ratio.toFixed(2);

                // Update ratio bar
                const ratioBar = document.getElementById('ratioBar');
                const ratioPercent = Math.min(ratio * 10, 100);
                ratioBar.style.width = `${ratioPercent}%`;

                // Calculate Position Size dengan EQUITY DINAMIS
                calculatePositionSize(slPips);

                // Update status
                document.getElementById('calculationStatus').innerHTML =
                    '<i class="fas fa-check-circle mr-1"></i> Calculated';

            } else {
                resetRiskCalculator();
            }
        }

        // Function untuk menghitung position size dengan EQUITY DINAMIS
        function calculatePositionSize(slPips) {
            const pipWorth = 10; // $10 per pip per 1 lot
            const currentEquity = parseFloat({{ $currentEquity }}); // EQUITY DINAMIS dari controller

            // Dapatkan risk percent yang dipilih user
            const selectedRisk = document.querySelector('input[name="risk_percent"]:checked');
            const riskPercent = selectedRisk ? parseFloat(selectedRisk.value) : 2; // Default 2%

            if (slPips > 0 && currentEquity > 0) {
                const riskUSD = currentEquity * (riskPercent / 100);
                const lotSize = riskUSD / (slPips * pipWorth);

                // Tampilkan position size dengan batasan minimal 0.01
                const finalLotSize = Math.max(lotSize, 0.01).toFixed(2);
                document.getElementById('positionSize').textContent = `${finalLotSize} lots`;
                document.getElementById('riskAmountDisplay').textContent = `Risk: $${riskUSD.toFixed(2)} (${riskPercent}%)`;

            } else {
                document.getElementById('positionSize').textContent = '-';
                document.getElementById('riskAmountDisplay').textContent = '-';
            }
        }

        // Function untuk reset calculator
        function resetRiskCalculator() {
            document.getElementById('riskRewardRatio').textContent = '-';
            document.getElementById('slPips').textContent = '-';
            document.getElementById('tpPips').textContent = '-';
            document.getElementById('positionSize').textContent = '-';
            document.getElementById('riskAmountDisplay').textContent = '-';
            document.getElementById('rr_ratio').value = '0';
            document.getElementById('ratioBar').style.width = '0%';
            document.getElementById('calculationStatus').innerHTML =
                '<i class="fas fa-sync-alt animate-spin mr-1"></i> Ready';
        }

        // Add event listeners for real-time calculation
        document.querySelector('input[name="entry"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="stop_loss"]').addEventListener('input', calculateRisk);
        document.querySelector('input[name="take_profit"]').addEventListener('input', calculateRisk);
        document.querySelector('select[name="type"]').addEventListener('change', calculateRisk);

        // Set current datetime as default for timestamp
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const timestamp = now.toISOString().slice(0, 16);
            document.querySelector('input[name="timestamp"]').value = timestamp;

            const today = now.toISOString().slice(0, 10);
            document.querySelector('input[name="date"]').value = today;

            // Trigger initial calculation jika ada nilai
            calculateRisk();
        });

        // Add event listeners untuk risk percent selector
        document.querySelectorAll('.risk-percent-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Update visual selection
                document.querySelectorAll('.risk-level-content').forEach(content => {
                    content.classList.remove('selected');
                });
                this.closest('.risk-level-card').querySelector('.risk-level-content').classList.add(
                    'selected');

                // Trigger ulang perhitungan ketika risk percent berubah
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

                    const pipValue = 0.00010;
                    const slPips = slDistance / pipValue;
                    calculatePositionSize(slPips);
                }
            });
        });
    </script>
@endsection
