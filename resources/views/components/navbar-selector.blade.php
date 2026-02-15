<div class="flex flex-wrap gap-3 items-center">
    <!-- Toggle Button -->
    <button id="navToggle"
        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 active:scale-95"
        data-nav-state-save="true">
        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2 nav-toggle-icon"></i>
    </button>

    <!-- Navigation Items Container -->
    <div id="navItems" class="hidden nav-items-container opacity-0 scale-95 transform transition-all duration-300">
        <div
            class="flex items-center space-x-1 bg-white dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-gray-700">
            <!-- Dashboard Link -->
            @if (!request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                    title="Dashboard" data-nav-state-save="true">
                    <i class="fas fa-home text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.dashboard') }}
                    </span>
                </a>
            @endif

            <!-- Calendar Link -->
            @if (!request()->routeIs('reports.calendar'))
                <a href="{{ route('reports.calendar') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('reports.calendar') ? 'bg-gray-700' : '' }}"
                    title="Calendar" data-nav-state-save="true">
                    <i
                        class="fas fa-calendar text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.calendar') }}
                    </span>
                </a>
            @endif

            <!-- Analysis Link -->
            @if (!request()->routeIs('analysis.*'))
                <a href="{{ route('analysis.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('analisys.*') ? 'bg-gray-700' : '' }}"
                    title="Analysis" data-nav-state-save="true">
                    <i
                        class="fa-solid fa-magnifying-glass-chart text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.analysis') }}
                    </span>
                </a>
            @endif

            <div class="h-6 w-px bg-gray-600 transition-all duration-300"></div>

            <!-- Trades Link -->
            @if (!request()->routeIs('trades.*'))
                <a href="{{ route('trades.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('trades.*') ? 'bg-gray-700' : '' }}"
                    title="Trades" data-nav-state-save="true">
                    <i
                        class="fas fa-chart-line text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.trades') }}
                    </span>
                </a>
            @endif

            <!-- Sessions Link -->
            @if (!request()->routeIs('sessions.*'))
                <a href="{{ route('sessions.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('sessions.*') ? 'bg-gray-700' : '' }}"
                    title="Sessions" data-nav-state-save="true">
                    <i
                        class="fas fa-clock text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.sessions') }}
                    </span>
                </a>
            @endif

            <!-- Symbols Link -->
            @if (!request()->routeIs('symbols.*'))
                <a href="{{ route('symbols.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('simbols.*') ? 'bg-gray-700' : '' }}"
                    title="Symbols" data-nav-state-save="true">
                    <i
                        class="fas fa-money-bill-transfer text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.symbols') }}
                    </span>
                </a>
            @endif

            <!-- Rules Link -->
            @if (!request()->routeIs('trading-rules.*'))
                <a href="{{ route('trading-rules.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('trading-rules.*') ? 'bg-gray-700' : '' }}"
                    title="Rules" data-nav-state-save="true">
                    <i class="fas fa-list text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.rules') }}
                    </span>
                </a>
            @endif

            <!-- Account Link - Ditambahkan setelah Rules Link -->
            @if (!request()->routeIs('accounts.*'))
                <a href="{{ route('accounts.index') }}"
                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('accounts.*') ? 'bg-gray-700' : '' }}"
                    title="Account" data-nav-state-save="true">
                    <i class="fas fa-user text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                    <span class="tooltip">
                        {{ __('nav_header.nav.accounts') }}
                    </span>
                </a>
            @endif
        </div>
    </div>
    @include('components.account-selector')

    <!-- Trader Item dengan animasi muncul -->
    {{-- <div
        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500">
        <i class="fas fa-user text-primary-500 mr-2 transition-transform duration-200 hover:scale-110"></i>
        <span class="transition-all duration-200">Trader</span>
    </div> --}}
</div>
