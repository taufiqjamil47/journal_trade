<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <style>
        .risk-level-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .risk-level-card:hover .risk-level-content {
            transform: translateY(-2px);
            border-color: currentColor;
        }

        .risk-level-content {
            border-radius: 12px;
            padding: 12px 8px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .risk-percent-radio:checked+.risk-level-content {
            border-width: 3px;
            border-color: currentColor;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Animasi untuk card metrics */
        .group:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Styling untuk running text */
        .running-text-container {
            background: rgba(13, 22, 39, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(14, 165, 233, 0.3);
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .running-text-wrapper {
            display: flex;
            width: max-content;
        }

        .running-text {
            display: flex;
            animation: scrollText 60s linear infinite;
            white-space: nowrap;
        }

        .running-text:hover {
            animation-play-state: paused;
        }

        .currency-pair {
            display: flex;
            align-items: center;
            margin: 0 2px;
            padding: 2px 16px;
            background: rgba(14, 165, 233, 0.1);
            /* border: 1px solid rgba(14, 165, 233, 0.3); */
            transition: all 0.3s ease;
            flex-shrink: 01;
        }

        .currency-pair.up {
            border-color: rgba(16, 185, 129, 0.5);
            background: rgba(16, 185, 129, 0.1);
        }

        .currency-pair.down {
            border-color: rgba(239, 68, 68, 0.5);
            background: rgba(239, 68, 68, 0.1);
        }

        .up {
            color: #10b981;
        }

        .down {
            color: #ef4444;
        }

        .price-change {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .price-up {
            animation: priceUp 0.5s ease;
        }

        .price-down {
            animation: priceDown 0.5s ease;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes priceUp {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(16, 185, 129, 0.3);
            }

            100% {
                background-color: transparent;
            }
        }

        @keyframes priceDown {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(239, 68, 68, 0.3);
            }

            100% {
                background-color: transparent;
            }
        }
    </style>

    <style>
        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 8px;
            padding: 4px 8px;
            background-color: rgba(17, 24, 39, 0.95);
            color: white;
            font-size: 0.75rem;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
            z-index: 10;
        }

        .group:hover .tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(-2px);
        }

        .nav-items-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth scaling for toggle button */
        button {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth icon rotation */
        .nav-toggle-icon {
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
    </style>

    <style>
        /* Simple scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Hover effects for tables */
        tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-dark-900 to-primary-900 font-sans text-gray-200 min-h-screen">
    <!-- Running Text Section -->
    <div class="running-text-container py-2" id="runningTextContainer">
        <div class="running-text-wrapper">
            <div class="running-text" id="runningText">
                <!-- Data pair akan di-generate oleh JavaScript -->
            </div>
        </div>
    </div>

    <!-- Content placeholder -->
    <div class="container mx-auto py-1">
        @yield('content')

        @include('components.floating-note-form')
        @include('components.language-switcher')
    </div>

    <script>
        // Data pair forex dengan format yang lebih detail
        const forexPairs = [{
                pair: "XAUUSD",
                price: 1985.42,
                change: 12.35,
                direction: "up",
                decimal: 2
            },
            {
                pair: "GBPUSD",
                price: 1.2650,
                change: 0.0032,
                direction: "up",
                decimal: 4
            },
            {
                pair: "EURUSD",
                price: 1.0925,
                change: -0.0015,
                direction: "down",
                decimal: 4
            },
            {
                pair: "USDJPY",
                price: 147.85,
                change: 0.45,
                direction: "up",
                decimal: 2
            },
            {
                pair: "AUDUSD",
                price: 0.6580,
                change: -0.0021,
                direction: "down",
                decimal: 4
            },
            {
                pair: "USDCAD",
                price: 1.3520,
                change: 0.0018,
                direction: "up",
                decimal: 4
            },
            {
                pair: "NZDUSD",
                price: 0.6125,
                change: -0.0010,
                direction: "down",
                decimal: 4
            },
            {
                pair: "USDCHF",
                price: 0.8820,
                change: 0.0005,
                direction: "up",
                decimal: 4
            },
            {
                pair: "EURGBP",
                price: 0.8630,
                change: -0.0008,
                direction: "down",
                decimal: 4
            },
            {
                pair: "XAGUSD",
                price: 23.15,
                change: 0.42,
                direction: "up",
                decimal: 2
            }
        ];

        // Data real-time untuk setiap pair
        const realTimeData = {};

        // Inisialisasi data real-time
        forexPairs.forEach(pair => {
            realTimeData[pair.pair] = {
                ...pair
            };
        });

        // Fungsi untuk generate perubahan harga random
        function generateRandomChange(currentPrice, decimalPlaces) {
            const volatility = decimalPlaces === 2 ? 0.5 : 0.0005;
            const change = (Math.random() - 0.5) * volatility * 2;

            const newPrice = currentPrice + change;
            const roundedPrice = Math.round(newPrice * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces);

            return {
                price: roundedPrice,
                change: Math.abs(change),
                direction: change >= 0 ? "up" : "down"
            };
        }

        // Fungsi untuk membuat elemen pair
        function createPairElement(pairData, index) {
            const pairDiv = document.createElement('div');
            pairDiv.className = `currency-pair ${pairData.direction}`;
            pairDiv.setAttribute('data-pair', pairData.pair);
            pairDiv.setAttribute('data-index', index);

            const directionIcon = pairData.direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
            const changeClass = pairData.direction === 'up' ? 'up' : 'down';

            pairDiv.innerHTML = `
                <span class="font-semibold text-white mr-3">${pairData.pair}</span>
                <span class="text-sm ${changeClass} mr-3 flex items-center change-value">
                    <i class="fas ${directionIcon} mr-1"></i>
                    ${pairData.change.toFixed(pairData.decimal)}
                </span>
                <span class="font-bold text-lg price-value">${pairData.price.toFixed(pairData.decimal)}</span>
            `;

            return pairDiv;
        }

        // Fungsi untuk update harga secara real-time
        function updatePrices() {
            Object.keys(realTimeData).forEach(pairName => {
                const pair = realTimeData[pairName];
                const newData = generateRandomChange(pair.price, pair.decimal);

                // Update data real-time
                realTimeData[pairName].price = newData.price;
                realTimeData[pairName].change = newData.change;
                realTimeData[pairName].direction = newData.direction;

                // Update semua elemen dengan pair yang sama
                const pairElements = document.querySelectorAll(`[data-pair="${pairName}"]`);

                pairElements.forEach(pairElement => {
                    // Update class untuk warna background
                    pairElement.className = `currency-pair ${newData.direction}`;

                    // Update icon dan perubahan
                    const directionIcon = newData.direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
                    const changeClass = newData.direction === 'up' ? 'up' : 'down';

                    const changeElement = pairElement.querySelector('.change-value');
                    changeElement.className = `text-sm ${changeClass} mr-3 flex items-center change-value`;
                    changeElement.innerHTML = `
                        <i class="fas ${directionIcon} mr-1"></i>
                        ${newData.change.toFixed(pair.decimal)}
                    `;

                    // Update harga dengan animasi
                    const priceElement = pairElement.querySelector('.price-value');
                    priceElement.classList.remove('price-up', 'price-down');
                    void priceElement.offsetWidth; // Trigger reflow
                    priceElement.classList.add(newData.direction === 'up' ? 'price-up' : 'price-down');

                    // Update harga
                    priceElement.textContent = newData.price.toFixed(pair.decimal);
                });
            });
        }

        // Fungsi untuk mengisi running text
        function populateRunningText() {
            const runningText = document.getElementById('runningText');

            // Duplikasi data untuk efek scroll yang smooth (4 set agar infinite)
            const duplicatedPairs = [];
            for (let i = 0; i < 4; i++) {
                forexPairs.forEach(pair => {
                    duplicatedPairs.push({
                        ...pair
                    });
                });
            }

            duplicatedPairs.forEach((pair, index) => {
                const pairElement = createPairElement(pair, index);
                runningText.appendChild(pairElement);
            });
        }

        // Panggil fungsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            populateRunningText();

            // Update harga setiap 2 detik
            setInterval(updatePrices, 2000);
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Untuk menampilkan success/error message dari session
        @if (session('success'))
            Swal.fire({
                icon: '{{ session('icon') ?? 'success' }}',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                position: 'top-end',
                toast: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('navToggle');
            const navToggleIcon = document.getElementById('navToggleIcon');
            const navItems = document.getElementById('navItems');
            const navContainer = document.querySelector('.nav-container');

            // Ambil state dari localStorage (jika ada)
            let isNavVisible = localStorage.getItem('navVisible') === 'true';

            // Jika belum ada di localStorage, set default ke false
            if (localStorage.getItem('navVisible') === null) {
                isNavVisible = false;
                localStorage.setItem('navVisible', 'false');
            }

            // Set initial state dengan delay untuk animasi masuk
            setTimeout(() => {
                updateNavVisibility(isNavVisible, false); // false = bukan dari toggle
            }, 100);

            // Toggle event dengan animasi
            navToggle.addEventListener('click', function() {
                isNavVisible = !isNavVisible;
                updateNavVisibility(isNavVisible, true); // true = dari toggle
                localStorage.setItem('navVisible', isNavVisible);

                // Tambahkan efek klik
                navToggle.classList.add('scale-95');
                setTimeout(() => {
                    navToggle.classList.remove('scale-95');
                }, 150);
            });

            // Simpan state sebelum pindah halaman
            document.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' && e.target.href) {
                    // Simpan state saat ini ke sessionStorage sebagai backup
                    sessionStorage.setItem('navVisibleBeforeNavigate', isNavVisible);
                }
            });

            // Handle browser back/forward
            window.addEventListener('pageshow', function(event) {
                // Jika halaman dimuat dari cache (bukan fresh load)
                if (event.persisted) {
                    const savedState = localStorage.getItem('navVisible') === 'true';
                    if (savedState !== isNavVisible) {
                        isNavVisible = savedState;
                        updateNavVisibility(isNavVisible, false);
                    }
                }
            });

            function updateNavVisibility(visible, fromToggle = true) {
                if (visible) {
                    // Animate in
                    navItems.classList.remove('hidden');
                    navItems.classList.add('flex');

                    // Trigger reflow untuk memulai animasi
                    void navItems.offsetWidth;

                    // Animate opacity and scale
                    if (fromToggle) {
                        navItems.classList.remove('opacity-0', 'scale-95');
                        navItems.classList.add('opacity-100', 'scale-100');
                    } else {
                        // Jika dari page load, langsung tampilkan tanpa animasi awal
                        navItems.classList.remove('opacity-0', 'scale-95');
                        navItems.classList.add('opacity-100', 'scale-100');
                    }

                    // Rotate icon smoothly
                    navToggleIcon.classList.remove('rotate-180');
                    navToggleIcon.classList.add('rotate-0');

                    // Add glow effect to toggle button
                    navToggle.classList.add('border-primary-500');
                } else {
                    // Animate out
                    if (fromToggle) {
                        navItems.classList.remove('opacity-100', 'scale-100');
                        navItems.classList.add('opacity-0', 'scale-95');

                        // Hide after animation completes
                        setTimeout(() => {
                            if (!isNavVisible) {
                                navItems.classList.add('hidden');
                                navItems.classList.remove('flex');
                            }
                        }, 300);
                    } else {
                        // Jika dari page load, langsung sembunyikan tanpa animasi
                        navItems.classList.add('hidden');
                        navItems.classList.remove('flex', 'opacity-100', 'scale-100');
                        navItems.classList.add('opacity-0', 'scale-95');
                    }

                    // Rotate icon back
                    navToggleIcon.classList.remove('rotate-0');
                    navToggleIcon.classList.add('rotate-180');

                    // Remove glow effect
                    navToggle.classList.remove('border-primary-500');
                }
            }

            // Tambahkan event listener untuk sebelum unload (opsional)
            window.addEventListener('beforeunload', function() {
                // Pastikan state terakhir tersimpan
                localStorage.setItem('navVisible', isNavVisible);
            });
        });
    </script>

    <script>
        // Script ini berjalan sebelum halaman berpindah
        (function() {
            // Simpan state nav ke sessionStorage saat link diklik
            document.addEventListener('DOMContentLoaded', function() {
                const links = document.querySelectorAll('a[href]');

                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Hanya untuk link internal (tidak eksternal atau anchor)
                        if (this.href && !this.target && this.href.startsWith(window.location
                                .origin)) {
                            const navState = localStorage.getItem('navVisible');
                            sessionStorage.setItem('navVisibleTemp', navState);
                        }
                    });
                });
            });

            // Restore state dari sessionStorage saat halaman dimuat
            window.addEventListener('load', function() {
                const tempState = sessionStorage.getItem('navVisibleTemp');

                if (tempState !== null) {
                    localStorage.setItem('navVisible', tempState);
                    // Hapus temp storage
                    sessionStorage.removeItem('navVisibleTemp');
                }
            });
        })();
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')

    <!-- Include Analysis Scripts -->
    @yield('scripts')
</body>

</html>
