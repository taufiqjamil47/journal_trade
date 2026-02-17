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
            darkMode: 'class',
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

        @keyframes scrollText {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
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

        .dark .tooltip {
            background-color: rgba(255, 255, 255, 0.95);
            color: black;
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

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
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

        .dark .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Hover effects for tables */
        tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }

        .dark tr:hover {
            background-color: rgba(200, 200, 200, 0.3);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Inline script to prevent theme flash -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body
    class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-200 text-gray-900 dark:from-dark-900 dark:to-primary-900 dark:text-gray-200 font-sans min-h-screen">
    <!-- running text -->
    @include('components.running-text')

    <!-- Content placeholder -->
    <div class="container mx-auto py-1">
        @yield('content')

        @include('components.floating-note-form')
        @include('components.language-switcher')
    </div>

    <!-- Theme Switch Script -->
    <script>
        // Theme Switch Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeSwitch = document.getElementById('themeSwitch');
            const themeIcon = document.getElementById('themeIcon');
            const html = document.documentElement;

            // Set initial icon based on current theme
            const currentTheme = localStorage.getItem('theme') || 'dark';
            themeIcon.className = currentTheme === 'dark' ? 'fas fa-moon text-lg' : 'fas fa-sun text-lg';

            // Toggle theme on button click
            themeSwitch.addEventListener('click', function() {
                if (html.classList.contains('dark')) {
                    // Currently dark, switch to light
                    html.classList.remove('dark');
                    themeIcon.className = 'fas fa-sun text-lg';
                    localStorage.setItem('theme', 'light');
                } else {
                    // Currently light, switch to dark
                    html.classList.add('dark');
                    themeIcon.className = 'fas fa-moon text-lg';
                    localStorage.setItem('theme', 'dark');
                }
            });
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
                    navToggle.classList.add('border-primary-500', 'dark:border-primary-500');
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
                    navToggle.classList.remove('border-primary-500', 'dark:border-primary-500');
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

    <!-- Theme Switch Button -->
    <button id="themeSwitch"
        class="fixed bottom-6 right-6 z-50 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 w-10 h-10 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
        <i id="themeIcon" class="fas fa-moon text-lg"></i>
    </button>

    <!-- Page Specific Scripts -->
    @stack('scripts')

    <!-- Include Analysis Scripts -->
    @yield('scripts')
</body>

</html>
