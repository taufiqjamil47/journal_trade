@extends('Layouts.index')
@section('title', 'Trade Detail #' . $trade->id)
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Trade Detail
                    </h1>
                    <p class="text-gray-500 mt-1">Detail lengkap untuk trade #{{ $trade->id }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Trade Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Basic Info Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Dasar
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">ID Trade</span>
                        <span class="font-bold text-primary-300">#{{ $trade->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Symbol</span>
                        <span class="font-bold">{{ $trade->symbol->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Type</span>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                            {{ strtoupper($trade->type) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Session</span>
                        <span class="font-bold">{{ $trade->session }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Timestamp</span>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Price Levels Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Level Harga
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Entry Price</span>
                            <span
                                class="font-mono font-bold text-lg text-green-400">{{ format_price($trade->entry) }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Stop Loss</span>
                            <span
                                class="font-mono font-bold text-lg text-red-400">{{ format_price($trade->stop_loss) }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Take Profit</span>
                            <span
                                class="font-mono font-bold text-lg text-green-400">{{ format_price($trade->take_profit) }}</span>
                        </div>
                    </div>

                    @if ($trade->exit)
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Exit Price</span>
                                <span
                                    class="font-mono font-bold text-lg text-blue-400">{{ format_price($trade->exit) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Result Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-4 flex items-center">
                    <i class="fas fa-trophy mr-2"></i>
                    Hasil Trade
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-lg">Status</span>
                        @if ($trade->hasil)
                            <span
                                class="px-3 py-1 rounded-full text-lg font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                {{ strtoupper($trade->hasil) }}
                            </span>
                        @else
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                PENDING
                            </span>
                        @endif
                    </div>

                    <div class="text-center">
                        <span class="text-sm text-gray-400 block mb-2">Profit/Loss</span>
                        <p class="text-2xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            ${{ number_format($trade->profit_loss ?? 0, 2) }}
                        </p>
                    </div>

                    @if ($trade->rr)
                        <div class="text-center">
                            <span class="text-sm text-gray-400 block mb-1">Risk/Reward Ratio</span>
                            <p class="text-xl font-bold text-amber-400">{{ $trade->rr }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Risk Management & Additional Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Risk Management Card -->
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-6 flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Manajemen Risiko
                </h3>

                <div class="space-y-6">
                    <!-- Kelompok 1: Risk Parameters -->
                    <div>
                        <h4 class="text-md font-medium text-gray-300 mb-3 flex items-center">
                            <i class="fas fa-chart-line mr-2 text-sm"></i>
                            Risk Parameters
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Lot Size -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Lot Size</span>
                                <span class="font-bold text-xl text-white">{{ $trade->lot_size ?? '-' }}</span>
                            </div>

                            <!-- Risk % -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Risk %</span>
                                <span class="font-bold text-xl text-white">
                                    {{ $trade->risk_percent ? $trade->risk_percent . '%' : '-' }}
                                </span>
                            </div>

                            <!-- Risk USD -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Risk USD</span>
                                <span class="font-bold text-xl text-white">
                                    {{ $trade->risk_usd ? '$' . number_format($trade->risk_usd, 2) : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 2: Trade Levels -->
                    <div>
                        <h4 class="text-md font-medium text-gray-300 mb-3 flex items-center">
                            <i class="fas fa-ruler-combined mr-2 text-sm"></i>
                            Trade Levels
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pips -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-3">Pips</span>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-up text-green-400 mr-2 text-sm"></i>
                                            <span class="text-gray-400">Take Profit:</span>
                                        </div>
                                        <span class="font-semibold text-green-400">{{ $trade->tp_pips ?? '0' }} pips</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-down text-red-400 mr-2 text-sm"></i>
                                            <span class="text-gray-400">Stop Loss:</span>
                                        </div>
                                        <span class="font-semibold text-red-400">{{ $trade->sl_pips ?? '0' }} pips</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk-Reward Ratio -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-3">Risk-Reward Ratio</span>
                                <div class="flex items-center justify-center">
                                    <span
                                        class="font-bold text-2xl {{ $trade->rr >= 1 ? 'text-green-400' : 'text-yellow-400' }}">
                                        {{ $trade->rr ?? '-' }}:1
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 3: Time Management -->
                    <div>
                        <h4 class="text-md font-medium text-gray-300 mb-3 flex items-center">
                            <i class="fas fa-clock mr-2 text-sm"></i>
                            Time Management
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
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Entry Time</span>
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-lg text-white">
                                        {{ $entryDt ? $entryDt->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-sm text-gray-300 mt-1">
                                        {{ $entryDt ? $entryDt->format('H:i') : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Exit Time -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Exit Time</span>
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-lg text-white">
                                        {{ $exitDt ? $exitDt->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-sm text-gray-300 mt-1">
                                        {{ $exitDt ? $exitDt->format('H:i') : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="text-center bg-gray-750/50 rounded-xl p-4 border border-gray-700">
                                <span class="text-sm text-gray-400 block mb-2">Duration</span>
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-lg text-white">{{ $duration ?? '-' }}</span>
                                    @if ($entryDt && !$exitDt)
                                        <span class="text-xs text-yellow-400 mt-1 bg-yellow-400/10 px-2 py-1 rounded-full">
                                            <i class="fas fa-sync-alt mr-1"></i> Ongoing
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Notes (if exists) -->
            @if ($trade->entry_reason || $trade->note || $trade->market_condition)
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-primary-400 mb-4 flex items-center">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Catatan Evaluasi
                    </h3>
                    <div class="space-y-4">
                        @if ($trade->market_condition)
                            <div class="bg-gray-750 rounded-lg p-3">
                                <span class="text-sm text-gray-400 block mb-1">Kondisi Market</span>
                                <p class="font-medium">{{ $trade->market_condition }}</p>
                            </div>
                        @endif

                        @if ($trade->entry_reason)
                            <div class="bg-gray-750 rounded-lg p-3">
                                <span class="text-sm text-gray-400 block mb-1">Alasan Entry</span>
                                <p class="font-medium">{{ $trade->entry_reason }}</p>
                            </div>
                        @endif

                        @if ($trade->note)
                            <div class="bg-gray-750 rounded-lg p-3">
                                <span class="text-sm text-gray-400 block mb-1">Catatan Tambahan</span>
                                <p class="font-medium whitespace-pre-line">{{ $trade->note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Chart Images Section -->
        @if ($trade->before_link || $trade->after_link)
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Trading Charts
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if ($trade->before_link)
                        <div class="space-y-3">
                            <!-- Header dengan link -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-400 flex items-center">
                                    <i class="fas fa-image mr-2"></i>
                                    Before Entry
                                </label>
                                <div class="flex gap-2">
                                    @if ($beforeChartImage)
                                        <button
                                            onclick="openImageModal('{{ $beforeChartImage }}', 'Before Entry - {{ $trade->symbol->name }}')"
                                            class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                            <i class="fas fa-search-plus mr-1"></i>
                                            Zoom
                                        </button>
                                    @endif
                                    <a href="{{ $trade->before_link }}" target="_blank"
                                        class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Link
                                    </a>
                                </div>
                            </div>

                            <!-- Image Display -->
                            @if ($beforeChartImage)
                                <div
                                    class="relative group overflow-hidden rounded-lg border border-gray-600 bg-gray-900 hover:border-primary-500/50 transition-all duration-300">
                                    <!-- Image -->
                                    <img src="{{ $beforeChartImage }}"
                                        alt="Before Entry Chart - {{ $trade->symbol->name }}"
                                        class="w-full h-auto chart-image cursor-zoom-in hover:opacity-90 transition-opacity duration-300 max-h-96 object-cover"
                                        loading="lazy"
                                        onclick="openImageModal('{{ $beforeChartImage }}', 'Before Entry - {{ $trade->symbol->name }}')">

                                    <!-- Loading indicator fallback -->
                                    {{-- <div
                                        class="absolute inset-0 bg-gray-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-xs text-gray-400">Klik untuk zoom</span>
                                    </div> --}}
                                </div>
                                <p class="text-xs text-gray-500 text-center">
                                    Klik gambar untuk memperbesar
                                </p>
                            @else
                                <div class="bg-gray-750 border border-gray-600 rounded-lg p-8 text-center">
                                    <i class="fas fa-chart-line text-3xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400 text-sm mb-3">Gambar chart tidak tersedia</p>
                                    <p class="text-xs text-gray-500 mb-3">
                                        @if (str_contains($trade->before_link, 'tradingview'))
                                            Link TradingView tidak dapat ditampilkan sebagai gambar
                                        @else
                                            Gagal memuat gambar dari URL
                                        @endif
                                    </p>
                                    <a href="{{ $trade->before_link }}" target="_blank"
                                        class="inline-block mt-3 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold py-2 px-4 rounded transition-colors">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Buka Link Asli
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($trade->after_link)
                        <div class="space-y-3">
                            <!-- Header dengan link -->
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-400 flex items-center">
                                    <i class="fas fa-image mr-2"></i>
                                    After Entry
                                </label>
                                <div class="flex gap-2">
                                    @if ($afterChartImage)
                                        <button
                                            onclick="openImageModal('{{ $afterChartImage }}', 'After Entry - {{ $trade->symbol->name }}')"
                                            class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                            <i class="fas fa-search-plus mr-1"></i>
                                            Zoom
                                        </button>
                                    @endif
                                    <a href="{{ $trade->after_link }}" target="_blank"
                                        class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Link
                                    </a>
                                </div>
                            </div>

                            <!-- Image Display -->
                            @if ($afterChartImage)
                                <div
                                    class="relative group overflow-hidden rounded-lg border border-gray-600 bg-gray-900 hover:border-primary-500/50 transition-all duration-300">
                                    <!-- Image -->
                                    <img src="{{ $afterChartImage }}"
                                        alt="After Entry Chart - {{ $trade->symbol->name }}"
                                        class="w-full h-auto chart-image cursor-zoom-in hover:opacity-90 transition-opacity duration-300 max-h-96 object-cover"
                                        loading="lazy"
                                        onclick="openImageModal('{{ $afterChartImage }}', 'After Entry - {{ $trade->symbol->name }}')">

                                    <!-- Loading indicator fallback -->
                                    {{-- <div
                                        class="absolute inset-0 bg-gray-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-xs text-gray-400">Klik untuk zoom</span>
                                    </div> --}}
                                </div>
                                <p class="text-xs text-gray-500 text-center">
                                    Klik gambar untuk memperbesar
                                </p>
                            @else
                                <div class="bg-gray-750 border border-gray-600 rounded-lg p-8 text-center">
                                    <i class="fas fa-chart-line text-3xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400 text-sm mb-3">Gambar chart tidak tersedia</p>
                                    <p class="text-xs text-gray-500 mb-3">
                                        @if (str_contains($trade->after_link, 'tradingview'))
                                            Link TradingView tidak dapat ditampilkan sebagai gambar
                                        @else
                                            Gagal memuat gambar dari URL
                                        @endif
                                    </p>
                                    <a href="{{ $trade->after_link }}" target="_blank"
                                        class="inline-block mt-3 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold py-2 px-4 rounded transition-colors">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Buka Link Asli
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div
            class="flex flex-col md:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-700 space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row gap-3">
                <a href="{{ route('trades.edit', $trade->id) }}"
                    class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Update Exit
                </a>
                <a href="{{ route('trades.evaluate', $trade->id) }}"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Evaluasi Trade
                </a>
            </div>
            <a href="{{ route('trades.index') }}"
                class="flex items-center text-gray-400 hover:text-gray-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Trade
            </a>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeImageModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div class="max-w-4xl max-h-full bg-gray-800 rounded-xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-700">
                    <h3 id="modalTitle" class="text-lg font-semibold text-primary-400"></h3>
                    <button onclick="closeImageModal()"
                        class="text-gray-400 hover:text-white transition-colors p-2 rounded-lg hover:bg-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 flex justify-center items-center max-h-[70vh]">
                    <div class="image-container">
                        <img id="zoomedImage" src="" alt=""
                            class="max-w-full max-h-full object-contain rounded-lg">
                    </div>
                </div>
                <div class="p-4 border-t border-gray-700 text-center">
                    <p class="text-sm text-gray-400">Gunakan scroll untuk zoom in/out • Klik di luar gambar untuk menutup
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
@endsection
