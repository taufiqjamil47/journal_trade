<div class="flex flex-wrap gap-3 items-center">
    <!-- Toggle Button - Menu Icon -->
    <button id="navToggle"
        class="flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg w-10 h-10 border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 active:scale-95 focus:outline-none"
        data-nav-state-save="true">
        <i id="navToggleIcon" class="fas fa-bars text-primary-500 text-lg"></i>
    </button>

    <!-- Navigation Items Container -->
    <div id="navItems" class="hidden nav-items-container opacity-0 scale-95 transform transition-all duration-300">
        <div
            class="flex items-center space-x-1 bg-white dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-gray-700 shadow-lg dark:shadow-none">
            <!-- Dashboard Link -->
            @if (!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                    title="Dashboard" data-nav-state-save="true">
                    <i
                        class="fas fa-home group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.dashboard') }}
                    </span>
                </a>
            @endif

            <!-- Calendar Link -->
            @if (!request()->routeIs('reports.calendar'))
                <a href="{{ route('reports.calendar') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('reports.calendar') ? 'bg-gray-700' : '' }}"
                    title="Calendar" data-nav-state-save="true">
                    <i
                        class="fas fa-calendar group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.calendar') }}
                    </span>
                </a>
            @endif

            <!-- Analysis Link -->
            @if (!request()->routeIs('analysis.*'))
                <a href="{{ route('analysis.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('analisys.*') ? 'bg-gray-700' : '' }}"
                    title="Analysis" data-nav-state-save="true">
                    <i
                        class="fa-solid fa-magnifying-glass-chart group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.analysis') }}
                    </span>
                </a>
            @endif

            <div class="h-6 w-px bg-gray-600 transition-all duration-300"></div>

            <!-- Trades Link -->
            @if (!request()->routeIs('trades.*'))
                <a href="{{ route('trades.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('trades.*') ? 'bg-gray-700' : '' }}"
                    title="Trades" data-nav-state-save="true">
                    <i
                        class="fas fa-chart-line group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.trades') }}
                    </span>
                </a>
            @endif

            <!-- Sessions Link -->
            @if (!request()->routeIs('sessions.*'))
                <a href="{{ route('sessions.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('sessions.*') ? 'bg-gray-700' : '' }}"
                    title="Sessions" data-nav-state-save="true">
                    <i
                        class="fas fa-clock group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.sessions') }}
                    </span>
                </a>
            @endif

            <!-- Symbols Link -->
            @if (!request()->routeIs('symbols.*'))
                <a href="{{ route('symbols.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('simbols.*') ? 'bg-gray-700' : '' }}"
                    title="Symbols" data-nav-state-save="true">
                    <i
                        class="fas fa-money-bill-transfer group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.symbols') }}
                    </span>
                </a>
            @endif

            <!-- Rules Link -->
            @if (!request()->routeIs('trading-rules.*'))
                <a href="{{ route('trading-rules.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('trading-rules.*') ? 'bg-gray-700' : '' }}"
                    title="Rules" data-nav-state-save="true">
                    <i
                        class="fas fa-list group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.rules') }}
                    </span>
                </a>
            @endif

            <!-- Account Link - Ditambahkan setelah Rules Link -->
            @if (!request()->routeIs('accounts.*'))
                <a href="{{ route('accounts.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-blue-500 dark:hover:bg-gray-700 duration-100 group relative {{ request()->routeIs('accounts.*') ? 'bg-gray-700' : '' }}"
                    title="Account" data-nav-state-save="true">
                    <i
                        class="fas fa-user group-hover:text-white dark:group-hover:text-primary-500 text-primary-500 duration-100"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.accounts') }}
                    </span>
                </a>
            @endif
        </div>
    </div>
    @include('components.account-selector')

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
                updateNavVisibility(isNavVisible, false);
            }, 100);

            // Toggle event dengan animasi
            navToggle.addEventListener('click', function() {
                isNavVisible = !isNavVisible;
                updateNavVisibility(isNavVisible, true);
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
                    sessionStorage.setItem('navVisibleBeforeNavigate', isNavVisible);
                }
            });

            // Handle browser back/forward
            window.addEventListener('pageshow', function(event) {
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

                    if (fromToggle) {
                        navItems.classList.remove('opacity-0', 'scale-95');
                        navItems.classList.add('opacity-100', 'scale-100');
                    } else {
                        navItems.classList.remove('opacity-0', 'scale-95');
                        navItems.classList.add('opacity-100', 'scale-100');
                    }

                    // Ubah icon menu menjadi 'X' (close)
                    navToggleIcon.classList.remove('fa-bars');
                    navToggleIcon.classList.add('fa-times');

                    // Add glow effect to toggle button
                    navToggle.classList.add('border-primary-500', 'dark:border-primary-500', 'bg-primary-50',
                        'dark:bg-primary-900/20');
                } else {
                    // Animate out
                    if (fromToggle) {
                        navItems.classList.remove('opacity-100', 'scale-100');
                        navItems.classList.add('opacity-0', 'scale-95');

                        setTimeout(() => {
                            if (!isNavVisible) {
                                navItems.classList.add('hidden');
                                navItems.classList.remove('flex');
                            }
                        }, 300);
                    } else {
                        navItems.classList.add('hidden');
                        navItems.classList.remove('flex', 'opacity-100', 'scale-100');
                        navItems.classList.add('opacity-0', 'scale-95');
                    }

                    // Ubah icon 'X' kembali menjadi menu (hamburger)
                    navToggleIcon.classList.remove('fa-times');
                    navToggleIcon.classList.add('fa-bars');

                    // Remove glow effect
                    navToggle.classList.remove('border-primary-500', 'dark:border-primary-500', 'bg-primary-50',
                        'dark:bg-primary-900/20');
                }
            }

            window.addEventListener('beforeunload', function() {
                localStorage.setItem('navVisible', isNavVisible);
            });
        });
    </script>

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
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth icon rotation */
        .nav-toggle-icon {
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
    </style>
</div>
