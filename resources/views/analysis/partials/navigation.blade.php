<div class="flex items-center space-x-1 bg-gray-800 rounded-lg p-1 border border-gray-700">
    <!-- Dashboard Link -->
    @if (!request()->routeIs('dashboard'))
        <a href="{{ route('dashboard') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
            title="{{ __('analysis.nav.dashboard') }}">
            <i class="fas fa-home text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.dashboard') }}
            </span>
        </a>
    @endif

    <!-- Calendar Link -->
    @if (!request()->routeIs('reports.calendar'))
        <a href="{{ route('reports.calendar') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.calendar') }}">
            <i class="fas fa-calendar text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.calendar') }}
            </span>
        </a>
    @endif

    <!-- Analysis Link -->
    @if (!request()->routeIs('analysis.*'))
        <a href="{{ route('analysis.index') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.analysis') }}">
            <i class="fa-solid fa-magnifying-glass-chart text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.analysis') }}
            </span>
        </a>
    @endif

    <div class="h-6 w-px bg-gray-600"></div>

    <!-- Trades Link -->
    @if (!request()->routeIs('trades.*'))
        <a href="{{ route('trades.index') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.trades') }}">
            <i class="fas fa-chart-line text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.trades') }}
            </span>
        </a>
    @endif

    <!-- Sessions Link -->
    @if (!request()->routeIs('sessions.*'))
        <a href="{{ route('sessions.index') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.sessions') }}">
            <i class="fas fa-clock text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.sessions') }}
            </span>
        </a>
    @endif

    <!-- Symbols Link -->
    @if (!request()->routeIs('symbols.*'))
        <a href="{{ route('symbols.index') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.symbols') }}">
            <i class="fas fa-money-bill-transfer text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.symbols') }}
            </span>
        </a>
    @endif

    <!-- Rules Link -->
    @if (!request()->routeIs('trading-rules.*'))
        <a href="{{ route('trading-rules.index') }}"
            class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
            title="{{ __('analysis.nav.rules') }}">
            <i class="fas fa-list text-primary-500"></i>
            <span
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                {{ __('nav_header.nav.rules') }}
            </span>
        </a>
    @endif
</div>
