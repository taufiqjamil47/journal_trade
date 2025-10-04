@extends('Layouts.index')
@section('title', 'Trade Detail #' . $trade->id)
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex-1">
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Trade Detail
                    </h1>
                    <p class="text-gray-400 mt-3">Detail lengkap untuk trade #{{ $trade->id }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i
                            class="fas fa-arrow-left text-primary-500 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        <span>Kembali ke Daftar Trade</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-chart-line text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Trade Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Basic Info Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6 flex flex-col">
                <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Dasar
                </h3>
                <div class="space-y-4 flex-1">
                    <div class="flex justify-between items-center py-1">
                        <span class="text-gray-400">ID Trade</span>
                        <span class="font-semibold">#{{ $trade->id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-gray-400">Symbol</span>
                        <span class="font-semibold">{{ $trade->symbol->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-gray-400">Type</span>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                            {{ strtoupper($trade->type) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-gray-400">Session</span>
                        <span class="font-semibold">{{ $trade->session }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-gray-400">Timestamp</span>
                        <span
                            class="font-semibold">{{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Price Levels Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6 flex flex-col">
                <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Level Harga
                </h3>
                <div class="space-y-5 flex-1">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-400">Entry Price</span>
                            <span class="font-mono text-lg">{{ $trade->entry }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-400">Stop Loss</span>
                            <span class="font-mono text-lg">{{ $trade->stop_loss }}</span>
                        </div>
                        {{-- <div class="text-right">
                            <span class="text-xs text-red-400">({{ $trade->sl_pips }} pips)</span>
                        </div> --}}
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-400">Take Profit</span>
                            <span class="font-mono text-lg">{{ $trade->take_profit }}</span>
                        </div>
                        {{-- <div class="text-right">
                            <span class="text-xs text-green-400">({{ $trade->tp_pips }} pips)</span>
                        </div> --}}
                    </div>

                    @if ($trade->exit)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-400">Exit Price</span>
                                <span class="font-mono text-lg">{{ $trade->exit }}</span>
                            </div>
                            {{-- <div class="text-right">
                                <span class="text-xs text-blue-400">({{ $trade->exit_pips }} pips)</span>
                            </div> --}}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Result Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6 flex flex-col">
                <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                    <i class="fas fa-trophy mr-2"></i>
                    Hasil Trade
                </h3>
                <div class="space-y-5 flex-1">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Status</span>
                        @if ($trade->hasil)
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                {{ strtoupper($trade->hasil) }}
                            </span>
                        @else
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                PENDING
                            </span>
                        @endif
                    </div>

                    <div
                        class="bg-gradient-to-r {{ $trade->profit_loss >= 0 ? 'from-green-900/20 to-green-800/10' : 'from-red-900/20 to-red-800/10' }} rounded-xl p-4 border {{ $trade->profit_loss >= 0 ? 'border-green-500/30' : 'border-red-500/30' }} flex-1 flex items-center justify-center">
                        <div class="text-center">
                            <span class="text-sm text-gray-400 block mb-2">Profit/Loss</span>
                            <p
                                class="text-2xl font-bold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                ${{ $trade->profit_loss ?? '0' }}
                            </p>
                        </div>
                    </div>

                    @if ($trade->rr)
                        <div class="text-center pt-2">
                            <span class="text-sm text-gray-400 block mb-1">Risk/Reward Ratio</span>
                            <p class="text-xl font-bold text-amber-400">{{ $trade->rr }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Risk Management & Additional Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Risk Management Card -->
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6">
                <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Manajemen Risiko
                </h3>
                <div class="grid grid-cols-2 gap-5">
                    <div class="text-center bg-dark-700/30 rounded-lg p-3">
                        <span class="text-sm text-gray-400 block mb-1">Lot Size</span>
                        <span class="font-semibold text-lg">{{ $trade->lot_size ?? '-' }}</span>
                    </div>
                    <div class="text-center bg-dark-700/30 rounded-lg p-3">
                        <span class="text-sm text-gray-400 block mb-1">Risk %</span>
                        <span
                            class="font-semibold text-lg">{{ $trade->risk_percent ? $trade->risk_percent . '%' : '-' }}</span>
                    </div>
                    <div class="text-center bg-dark-700/30 rounded-lg p-3">
                        <span class="text-sm text-gray-400 block mb-1">Risk USD</span>
                        <span class="font-semibold text-lg">{{ $trade->risk_usd ? '$' . $trade->risk_usd : '-' }}</span>
                    </div>
                    <div class="text-center bg-dark-700/30 rounded-lg p-3">
                        <span class="text-sm text-gray-400 block mb-1">Pips Calc</span>
                        <div class="flex flex-col space-y-2 mt-2">
                            <span class="text-green-400 text-sm">TP: {{ $trade->tp_pips }} pips</span>
                            <span class="text-red-400 text-sm">SL: {{ $trade->sl_pips }} pips</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Notes (if exists) -->
            @if ($trade->entry_reason || $trade->note || $trade->market_condition)
                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Catatan Evaluasi
                    </h3>
                    <div class="space-y-5">
                        @if ($trade->market_condition)
                            <div class="bg-dark-700/30 rounded-lg p-4">
                                <span class="text-sm text-gray-400 block mb-2">Kondisi Market</span>
                                <p class="font-medium">{{ $trade->market_condition }}</p>
                            </div>
                        @endif

                        @if ($trade->entry_reason)
                            <div class="bg-dark-700/30 rounded-lg p-4">
                                <span class="text-sm text-gray-400 block mb-2">Alasan Entry</span>
                                <p class="font-medium">{{ $trade->entry_reason }}</p>
                            </div>
                        @endif

                        @if ($trade->note)
                            <div class="bg-dark-700/30 rounded-lg p-4">
                                <span class="text-sm text-gray-400 block mb-2">Catatan Tambahan</span>
                                <p class="font-medium whitespace-pre-line">{{ $trade->note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Chart Images Section -->
        @if ($trade->before_link || $trade->after_link)
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-primary-400 mb-5 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Trading Charts
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if ($trade->before_link)
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-400 flex items-center">
                                    <i class="fas fa-chart-line mr-2"></i>
                                    Before Entry
                                </label>
                                <a href="{{ $trade->before_link }}" target="_blank"
                                    class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Open in TradingView
                                </a>
                            </div>

                            @if ($beforeChartImage)
                                <div class="relative group">
                                    <img src="{{ $beforeChartImage }}"
                                        alt="Before Entry Chart - {{ $trade->symbol->name }}"
                                        class="w-full h-full object-cover rounded-lg border border-gray-600/50 shadow-lg chart-image cursor-zoom-in transition-all duration-300 group-hover:shadow-xl group-hover:border-primary-500/30"
                                        loading="lazy"
                                        onclick="openImageModal('{{ $beforeChartImage }}', 'Before Entry - {{ $trade->symbol->name }}')">
                                </div>
                            @else
                                <div class="bg-dark-700/50 border border-gray-600/50 rounded-lg p-8 text-center">
                                    <i class="fas fa-chart-line text-3xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400 text-sm">Gambar chart tidak tersedia</p>
                                    <a href="{{ $trade->before_link }}" target="_blank"
                                        class="inline-block mt-2 text-primary-400 hover:text-primary-300 text-xs">
                                        Buka di TradingView
                                    </a>
                                </div>
                            @endif

                            <p class="text-xs text-gray-500 text-center">
                                Klik gambar untuk memperbesar
                            </p>
                        </div>
                    @endif

                    @if ($trade->after_link)
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-sm text-gray-400 flex items-center">
                                    <i class="fas fa-chart-line mr-2"></i>
                                    After Entry
                                </label>
                                <a href="{{ $trade->after_link }}" target="_blank"
                                    class="text-xs text-primary-400 hover:text-primary-300 transition-colors flex items-center">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Open in TradingView
                                </a>
                            </div>

                            @if ($afterChartImage)
                                <div class="relative group">
                                    <img src="{{ $afterChartImage }}"
                                        alt="After Entry Chart - {{ $trade->symbol->name }}"
                                        class="w-full h-full object-cover rounded-lg border border-gray-600/50 shadow-lg chart-image cursor-zoom-in transition-all duration-300 group-hover:shadow-xl group-hover:border-primary-500/30"
                                        loading="lazy"
                                        onclick="openImageModal('{{ $afterChartImage }}', 'After Entry - {{ $trade->symbol->name }}')">
                                </div>
                            @else
                                <div class="bg-dark-700/50 border border-gray-600/50 rounded-lg p-8 text-center">
                                    <i class="fas fa-chart-line text-3xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400 text-sm">Gambar chart tidak tersedia</p>
                                    <a href="{{ $trade->after_link }}" target="_blank"
                                        class="inline-block mt-2 text-primary-400 hover:text-primary-300 text-xs">
                                        Buka di TradingView
                                    </a>
                                </div>
                            @endif

                            <p class="text-xs text-gray-500 text-center">
                                Klik gambar untuk memperbesar
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Image Zoom Modal -->
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeImageModal()"></div>
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div class="max-w-4xl max-h-full bg-dark-800 rounded-2xl border border-gray-700/50 shadow-2xl overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-700/50">
                    <h3 id="modalTitle" class="text-lg font-semibold text-primary-400"></h3>
                    <button onclick="closeImageModal()"
                        class="text-gray-400 hover:text-white transition-colors p-2 rounded-lg hover:bg-gray-700/50">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 flex justify-center items-center max-h-[70vh]">
                    <div class="image-container">
                        <img id="zoomedImage" src="" alt=""
                            class="max-w-full max-h-full object-contain rounded-lg">
                    </div>
                </div>
                <div class="p-4 border-t border-gray-700/50 text-center">
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

        // Pindahkan fungsi applyTransform ke global scope
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

                // Zoom in/out dengan klik (opsional - untuk testing)
                imageContainer.addEventListener('click', (e) => {
                    // Jika sedang animasi atau drag, skip
                    if (isAnimating || isDragging) return;

                    // Zoom in dengan shift+click, zoom out dengan ctrl+click
                    if (e.shiftKey && currentScale < 5) {
                        const rect = imageContainer.getBoundingClientRect();
                        const mouseX = e.clientX - rect.left;
                        const mouseY = e.clientY - rect.top;
                        const targetScale = getNextZoomLevel('in', currentScale);
                        smoothZoom(targetScale, mouseX, mouseY);
                    } else if (e.ctrlKey && currentScale > 0.5) {
                        const rect = imageContainer.getBoundingClientRect();
                        const mouseX = e.clientX - rect.left;
                        const mouseY = e.clientY - rect.top;
                        const targetScale = getNextZoomLevel('out', currentScale);
                        smoothZoom(targetScale, mouseX, mouseY);
                    }
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

        /* Konsistensi spacing */
        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .space-y-5>*+* {
            margin-top: 1.25rem;
        }

        /* Perbaikan kontras untuk keterbacaan */
        .text-gray-400 {
            color: #9ca3af;
        }

        .bg-dark-700\/30 {
            background-color: rgba(55, 65, 81, 0.3);
        }
    </style>
@endsection
