<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluasi Trade - Trading Journal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-dark-900 to-primary-900 font-sans text-gray-200 min-h-screen">
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
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Progress Steps -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/30 shadow-xl mb-8">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Entry Trade</span>
                </div>
                <div class="h-1 flex-1 bg-primary-500 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Update Exit</span>
                </div>
                <div class="h-1 flex-1 bg-primary-500 mx-4"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold shadow-lg">
                        3
                    </div>
                    <span class="text-sm font-medium mt-2 text-primary-400">Evaluasi</span>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto">
            <!-- Trade Info Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl mb-6">
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-purple-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-chart-bar text-purple-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Trade #{{ $trade->id }} - {{ $trade->symbol->name }}
                            </h2>
                            <p class="text-gray-400 text-sm mt-1">Detail trading untuk evaluasi</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">Type</p>
                            <p class="font-semibold {{ $trade->type == 'buy' ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($trade->type) }}
                            </p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">Entry</p>
                            <p class="font-semibold font-mono">{{ $trade->entry }}</p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">Exit</p>
                            <p class="font-semibold font-mono">{{ $trade->exit ?? '-' }}</p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">P/L</p>
                            <p class="font-semibold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                ${{ $trade->profit_loss ?? '0' }}
                            </p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">Session</p>
                            <p class="font-semibold">{{ $trade->session }}</p>
                        </div>
                        <div class="bg-dark-800/50 rounded-lg p-3 border border-gray-700/50">
                            <p class="text-xs text-gray-400">Hasil</p>
                            <p
                                class="font-semibold {{ $trade->hasil == 'win' ? 'text-green-400' : ($trade->hasil == 'loss' ? 'text-red-400' : 'text-gray-400') }}">
                                {{ strtoupper($trade->hasil ?? 'PENDING') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-purple-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-analytics text-purple-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Analisis & Evaluasi Trading</h2>
                            <p class="text-gray-400 text-sm mt-1">Catat pembelajaran dari trading ini</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('trades.saveEvaluation', $trade->id) }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Entry Setup -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-blue-300">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Entry Setup
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_type" class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-flag mr-2 text-blue-500"></i>Entry Type (Setup)
                                        </label>
                                        <input type="text" name="entry_type"
                                            class="w-full bg-dark-800 border border-blue-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->entry_type }}"
                                            placeholder="Contoh: Order Block, FVG, dll">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-300">
                                            <i class="fas fa-rules mr-2 text-green-500"></i>Follow Rules?
                                        </label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center">
                                                <input type="radio" name="follow_rules" value="1"
                                                    {{ $trade->follow_rules ? 'checked' : '' }}
                                                    class="text-green-500 focus:ring-green-500 bg-dark-800 border-gray-600">
                                                <span class="ml-2 text-green-400">Yes</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="follow_rules" value="0"
                                                    {{ !$trade->follow_rules ? 'checked' : '' }}
                                                    class="text-red-500 focus:ring-red-500 bg-dark-800 border-gray-600">
                                                <span class="ml-2 text-red-400">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Market Analysis -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-amber-300">
                                    <i class="fas fa-chart-area mr-2"></i>Market Analysis
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="market_condition" class="block text-sm font-medium text-gray-300">
                                            Market Condition
                                        </label>
                                        <textarea name="market_condition" rows="3"
                                            class="w-full bg-dark-800 border border-amber-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Deskripsikan kondisi market saat entry...">{{ $trade->market_condition }}</textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="entry_reason" class="block text-sm font-medium text-gray-300">
                                            Entry Reason
                                        </label>
                                        <textarea name="entry_reason" rows="3"
                                            class="w-full bg-dark-800 border border-amber-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Alasan mengambil posisi ini...">{{ $trade->entry_reason }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Management -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-red-300">
                                    <i class="fas fa-shield-alt mr-2"></i>Risk Management
                                </h3>

                                <div class="space-y-2">
                                    <label for="why_sl_tp" class="block text-sm font-medium text-gray-300">
                                        Why SL & TP
                                    </label>
                                    <textarea name="why_sl_tp" rows="3"
                                        class="w-full bg-dark-800 border border-red-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Alasan penempatan SL dan TP...">{{ $trade->why_sl_tp }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Trading Rules -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-green-300">
                                    <i class="fas fa-check-double mr-2"></i>Trading Rules
                                </h3>

                                <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
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

                                    @foreach ($rulesList as $rule)
                                        <label
                                            class="flex items-start p-2 rounded-lg hover:bg-dark-700/30 transition-colors duration-200">
                                            <input type="checkbox" name="rules[]" value="{{ $rule }}"
                                                {{ in_array($rule, $selectedRules) ? 'checked' : '' }}
                                                class="mt-1 text-green-500 focus:ring-green-500 bg-dark-800 border-gray-600 rounded">
                                            <span class="ml-3 text-sm text-gray-300">{{ $rule }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Psychology -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-purple-300">
                                    <i class="fas fa-brain mr-2"></i>Trading Psychology
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="entry_emotion" class="block text-sm font-medium text-gray-300">
                                            Entry Emotion
                                        </label>
                                        <input type="text" name="entry_emotion"
                                            class="w-full bg-dark-800 border border-purple-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->entry_emotion }}"
                                            placeholder="Emosi saat entry (confident, fearful, dll)">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="close_emotion" class="block text-sm font-medium text-gray-300">
                                            Close Emotion
                                        </label>
                                        <input type="text" name="close_emotion"
                                            class="w-full bg-dark-800 border border-purple-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->close_emotion }}"
                                            placeholder="Emosi saat close (relieved, frustrated, dll)">
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation -->
                            <div class="bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-cyan-300">
                                    <i class="fas fa-camera mr-2"></i>Documentation
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="before_link" class="block text-sm font-medium text-gray-300">
                                            Before Screenshot (Link)
                                        </label>
                                        <input type="url" name="before_link"
                                            class="w-full bg-dark-800 border border-cyan-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->before_link }}" placeholder="https://...">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="after_link" class="block text-sm font-medium text-gray-300">
                                            After Screenshot (Link)
                                        </label>
                                        <input type="url" name="after_link"
                                            class="w-full bg-dark-800 border border-cyan-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200"
                                            value="{{ $trade->after_link }}" placeholder="https://...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mt-6 bg-dark-800/50 rounded-xl p-5 border border-gray-700/50">
                        <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-300">
                            <i class="fas fa-sticky-note mr-2"></i>Additional Notes
                        </h3>

                        <div class="space-y-2">
                            <label for="note" class="block text-sm font-medium text-gray-300">
                                Catatan Tambahan & Pembelajaran
                            </label>
                            <textarea name="note" rows="4"
                                class="w-full bg-dark-800 border border-gray-600 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                                placeholder="Pembelajaran, insight, atau catatan penting lainnya...">{{ $trade->note }}</textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-700/50 space-y-4 md:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar Trade
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Evaluasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar for rules list */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Custom radio and checkbox styles */
        input[type="radio"],
        input[type="checkbox"] {
            background-color: #1e293b;
            border-color: #475569;
        }

        input[type="radio"]:checked,
        input[type="checkbox"]:checked {
            background-color: #10b981;
            border-color: #10b981;
        }
    </style>
</body>

</html>
