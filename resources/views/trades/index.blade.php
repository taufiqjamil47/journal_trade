@extends('Layouts.index')
@section('title', __('trades.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('trades.header_title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('trades.header_subtitle') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2"></i>
                    </button>

                    <!-- Navigation Items (hidden by default) -->
                    <div id="navItems" class="hidden">
                        <div class="flex items-center space-x-1 bg-gray-800 rounded-lg p-1 border border-gray-700">
                            <!-- Dashboard Link -->
                            @if (!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                                    title="Dashboard">
                                    <i class="fas fa-home text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.dashboard') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Calendar Link - hanya tampil jika BUKAN di route calendar -->
                            @if (!request()->routeIs('reports.calendar'))
                                <a href="{{ route('reports.calendar') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Calendar">
                                    <i class="fas fa-calendar text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.calendar') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Analysis Link - hanya tampil jika BUKAN di route analysis -->
                            @if (!request()->routeIs('analysis.*'))
                                <a href="{{ route('analysis.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Analysis">
                                    <i class="fa-solid fa-magnifying-glass-chart text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.analysis') }}
                                    </span>
                                </a>
                            @endif

                            <div class="h-6 w-px bg-gray-600"></div>

                            <!-- Trades Link - hanya tampil jika BUKAN di route trades -->
                            @if (!request()->routeIs('trades.*'))
                                <a href="{{ route('trades.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Trades">
                                    <i class="fas fa-chart-line text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.trades') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Sessions Link - hanya tampil jika BUKAN di route sessions -->
                            @if (!request()->routeIs('sessions.*'))
                                <a href="{{ route('sessions.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Sessions">
                                    <i class="fas fa-clock text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.sessions') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Symbols Link - hanya tampil jika BUKAN di route symbols -->
                            @if (!request()->routeIs('symbols.*'))
                                <a href="{{ route('symbols.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Symbols">
                                    <i class="fas fa-money-bill-transfer text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.symbols') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Rules Link - hanya tampil jika BUKAN di route trading-rules -->
                            @if (!request()->routeIs('trading-rules.*'))
                                <a href="{{ route('trading-rules.index') }}"
                                    class="flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-colors group relative"
                                    title="Rules">
                                    <i class="fas fa-list text-primary-500"></i>
                                    <span
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ __('nav_header.nav.rules') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trader Item -->
                    <div class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="bg-green-900/30 rounded-lg p-4 border border-green-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <span class="text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Quick Stats -->
        @if ($trades->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-trophy text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">{{ __('trades.win_rate') }}</p>
                            <p class="text-base font-semibold">{{ $winrate }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-line text-primary-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">{{ __('trades.total_trades') }}</p>
                            <p class="text-base font-semibold">{{ $trades->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-coins text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">{{ __('trades.active_trades') }}</p>
                            <p class="text-base font-semibold">{{ $trades->where('exit', null)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-clock text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">{{ __('trades.pending_trades') }}</p>
                            <p class="text-lg font-semibold">
                                {{ $trades->where('hasil', null)->where('exit', '==', null)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table Container -->
        <div class="bg-gray-800 rounded-xl border border-gray-700">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">{{ __('trades.trade_list') }}</h2>
                        <p class="text-gray-500 text-sm mt-1">
                            {{ __('trades.total_trades_count', ['count' => $trades->total()]) }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <!-- Sorting Dropdown -->
                        <div class="relative group flex-1 sm:flex-none min-w-[120px]">
                            <button
                                class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center sm:justify-start group text-sm sm:text-base">
                                <i class="fas fa-sort mr-1 sm:mr-2"></i>
                                <span>{{ __('trades.sort') }}</span>
                                <i
                                    class="fas fa-chevron-down ml-1 sm:ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown -->
                            <div
                                class="absolute left-0 sm:left-auto sm:right-0 top-[14vh] lg:top-full mt-1 w-full sm:w-[12rem] bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'desc']) }}"
                                        class="block px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i
                                            class="fas fa-calendar-alt mr-2 sm:mr-3 text-primary-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.date') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.newest_first') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'asc']) }}"
                                        class="block px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i
                                            class="fas fa-calendar mr-2 sm:mr-3 text-primary-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.date') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.lowest_first') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'desc']) }}"
                                        class="block px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i class="fas fa-hashtag mr-2 sm:mr-3 text-primary-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.id') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.highest_first') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'asc']) }}"
                                        class="block px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center">
                                        <i class="fas fa-hashtag mr-2 sm:mr-3 text-primary-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.id') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.lowest_first') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Import/Export Group -->
                        <div class="relative group flex-1 sm:flex-none min-w-[120px]">
                            <button
                                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center sm:justify-start group text-sm sm:text-base">
                                <i class="fas fa-exchange-alt mr-1 sm:mr-2"></i>
                                <span>{{ __('trades.data') }}</span>
                                <i
                                    class="fas fa-chevron-down ml-1 sm:ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown -->
                            <div
                                class="absolute left-0 sm:left-auto sm:right-0 top-[14vh] lg:top-full mt-1 w-full sm:w-64 bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 overflow-y-auto max-h-[80vh]">
                                <div class="p-2 sm:p-3 space-y-3 sm:space-y-4">
                                    <!-- Import Section -->
                                    <div>
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-file-import mr-2 text-purple-400 text-sm"></i>
                                            {{ __('trades.import_data') }}
                                        </div>
                                        <form action="{{ route('trades.import.excel') }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-2">
                                            @csrf
                                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-purple-500 file:bg-purple-600 file:border-0 file:text-white file:rounded file:px-2 sm:file:px-3 file:py-1 file:text-xs sm:file:text-sm file:hover:bg-purple-700">
                                            <button type="submit"
                                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-upload mr-2"></i>
                                                {{ __('trades.upload_file') }}
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Export Section -->
                                    <div class="pt-2 sm:pt-3 border-t border-gray-700">
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-file-export mr-2 text-green-400 text-sm"></i>
                                            {{ __('trades.export_data') }}
                                        </div>
                                        <div class="space-y-2">
                                            <a href="{{ route('trades.export.excel') }}"
                                                class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-file-excel mr-2"></i>
                                                {{ __('trades.export_to_excel') }}
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PDF Reports Section -->
                                    <div class="pt-2 sm:pt-3 border-t border-gray-700">
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-file-pdf mr-2 text-red-400 text-sm"></i>
                                            {{ __('trades.pdf_reports') }}
                                        </div>
                                        <div class="space-y-2">
                                            <a href="{{ route('trades.generate.pdf', ['type' => 'cover']) }}"
                                                class="block w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-file-alt mr-2"></i>
                                                {{ __('trades.cover_report') }}
                                            </a>
                                            <a href="{{ route('trades.generate.pdf', ['type' => 'complete']) }}"
                                                class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-book mr-2"></i>
                                                {{ __('trades.complete_report') }}
                                            </a>
                                            <a href="{{ route('trades.preview.pdf') }}" target="_blank"
                                                class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-eye mr-2"></i>
                                                {{ __('trades.preview_report') }}
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Date Range Report Section -->
                                    <div class="pt-2 sm:pt-3 border-t border-gray-700">
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-calendar-alt mr-2 text-green-400 text-sm"></i>
                                            {{ __('trades.date_range_report') }}
                                        </div>
                                        <form action="{{ route('trades.generate.pdf') }}" method="GET"
                                            class="space-y-2 sm:space-y-3">
                                            <input type="hidden" name="type" value="range">
                                            <div class="space-y-1">
                                                <label
                                                    class="block text-xs text-gray-400">{{ __('trades.start_date') }}</label>
                                                <input type="date" name="start_date" required
                                                    class="w-full bg-gray-700 border border-gray-600 rounded px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-green-500">
                                            </div>
                                            <div class="space-y-1">
                                                <label
                                                    class="block text-xs text-gray-400">{{ __('trades.end_date') }}</label>
                                                <input type="date" name="end_date" required
                                                    class="w-full bg-gray-700 border border-gray-600 rounded px-2 sm:px-3 py-1 sm:py-2 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-green-500">
                                            </div>
                                            <button type="submit"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center transition-colors text-sm">
                                                <i class="fas fa-file-pdf mr-2"></i>
                                                {{ __('trades.generate_report') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Management Actions -->
                        <div class="relative group flex-1 sm:flex-none min-w-[120px] z-50">
                            <button
                                class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg flex items-center justify-center sm:justify-start group text-sm sm:text-base">
                                <i class="fas fa-tools mr-1 sm:mr-2"></i>
                                <span>{{ __('trades.manage') }}</span>
                                <i
                                    class="fas fa-chevron-down ml-1 sm:ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown -->
                            <div
                                class="absolute left-0 sm:left-auto sm:right-0 top-full mt-1 w-full sm:w-[12rem] bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                                <div class="py-2">
                                    <a href="{{ route('trades.create') }}"
                                        class="block px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-blue-500/20 hover:text-blue-300 flex items-center border-b border-gray-700/50">
                                        <i
                                            class="fas fa-plus-circle mr-2 sm:mr-3 text-blue-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.add_new_trade') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.create_new_entry') }}</div>
                                        </div>
                                    </a>
                                    <button onclick="quickClearAll()"
                                        class="w-full text-left px-3 sm:px-4 py-2 sm:py-3 text-sm hover:bg-red-500/20 hover:text-red-300 flex items-center">
                                        <i class="fas fa-trash-alt mr-2 sm:mr-3 text-red-400 w-4 sm:w-5 text-center"></i>
                                        <div class="flex-1">
                                            <div class="font-medium">{{ __('trades.clear_all_trades') }}</div>
                                            <div class="text-xs text-gray-400">{{ __('trades.remove_all_data') }}</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-750 border-b border-gray-600">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">#</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.symbol') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.type') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.entry') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">SL</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">TP</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.timestamp') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.exit') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">P/L ($)</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.session') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.result') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">{{ __('trades.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($trades as $trade)
                            <tr class="hover:bg-gray-750 cursor-pointer"
                                onclick="window.location.href='{{ route('trades.show', $trade->id) }}'">
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-700 text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ ($trades->currentPage() - 1) * $trades->perPage() + $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-xs">{{ $trade->symbol->name }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        {{ strtoupper($trade->type) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-mono text-sm">{{ format_price($trade->entry) }}</td>
                                <td class="py-3 px-4 font-mono">
                                    <div class="text-sm text-red-400">{{ format_price($trade->stop_loss) }}</div>
                                    <div class="text-xs text-red-400">({{ $trade->sl_pips }} pips)</div>
                                </td>
                                <td class="py-3 px-4 font-mono">
                                    <div class="text-sm text-green-400">{{ format_price($trade->take_profit) }}</div>
                                    <div class="text-xs text-green-400">({{ $trade->tp_pips }} pips)</div>
                                </td>
                                <td class="py-3 px-4 text-sm">
                                    {{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4 font-mono">
                                    @if ($trade->exit)
                                        <div class="text-sm">{{ format_price($trade->exit) }}</div>
                                        <div class="text-xs">({{ $trade->exit_pips }} pips)</div>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="font-mono font-semibold px-2 py-1 rounded-lg text-sm {{ $trade->profit_loss >= 0 ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        {{ $trade->profit_loss ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-xs font-medium bg-primary-500/20 text-primary-300 border border-primary-500/30">
                                        {{ $trade->session }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($trade->hasil)
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                            {{ strtoupper($trade->hasil) }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-lg text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                            {{ __('trades.pending') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 w-auto">
                                    <div class="relative">
                                        <!-- Container utama dengan grid -->
                                        <div class="grid grid-cols-3 gap-2 relative z-10">
                                            <!-- Edit Button -->
                                            <a href="{{ route('trades.edit', $trade->id) }}"
                                                class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 p-1 rounded-lg flex items-center justify-center transition-all duration-200"
                                                title="{{ __('trades.update_exit') }}">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>

                                            <!-- Evaluate Button -->
                                            <a href="{{ route('trades.evaluate', $trade->id) }}"
                                                class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 p-1 rounded-lg flex items-center justify-center transition-all duration-200"
                                                title="{{ __('trades.evaluate') }}">
                                                <i class="fas fa-chart-bar text-sm"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <button
                                                onclick="confirmDeleteTrade(event, '{{ $trade->id }}', '{{ $trade->symbol->name }}', '{{ $trade->type }}')"
                                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 p-1 rounded-lg flex items-center justify-center transition-all duration-200"
                                                title="{{ __('trades.delete_trade') }}">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                            <!-- Duplicate Button (Overlay di kiri) -->
                                            <button onclick="duplicateTrade(event, {{ $trade->id }})"
                                                class="duplicate-btn absolute -left-9 top-0 bottom-0 bg-gray-500/90 hover:bg-gray-600 text-white px-2 rounded-lg flex items-center justify-center transition-all duration-300 opacity-0 transform -translate-x-2 w-auto h-auto z-20 shadow-lg"
                                                title="{{ __('trades.duplicate_trade') }}">
                                                <i class="fas fa-copy text-sm"></i>
                                            </button>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400 space-y-3">
                                        <div class="bg-gray-700 rounded-full p-4">
                                            <i class="fas fa-chart-line text-2xl opacity-50"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium">{{ __('trades.no_trades_yet') }}</p>
                                            <p class="text-sm">{{ __('trades.start_by_adding_first_trade') }}</p>
                                        </div>
                                        <a href="{{ route('trades.create') }}"
                                            class="mt-2 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-5 rounded-lg flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
                                            {{ __('trades.add_first_trade') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($trades->hasPages())
                <div class="px-6 py-4 border-t border-gray-700 bg-gray-750">
                    {{ $trades->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Translations for JavaScript -->
    <script>
        const translations = {
            clear_all_trades: "{{ __('trades.clear_all_trades') }}",
            clear_all_warning: "{{ __('trades.clear_all_warning') }}",
            cannot_be_undone: "{{ __('trades.cannot_be_undone') }}",
            will_be_deleted: "{{ __('trades.will_be_deleted') }}",
            trading_records: "{{ __('trades.trading_records') }}",
            all_performance_stats: "{{ __('trades.all_performance_stats') }}",
            all_rule_associations: "{{ __('trades.all_rule_associations') }}",
            complete_trading_history: "{{ __('trades.complete_trading_history') }}",
            to_confirm_type: "{{ __('trades.to_confirm_type') }}",
            please_type_confirmation: "{{ __('trades.please_type_confirmation') }}",
            clear_all_trades_btn: "{{ __('trades.clear_all_trades_btn') }}",
            cancel_btn: "{{ __('trades.cancel_btn') }}",
            cleaning_trades: "{{ __('trades.cleaning_trades') }}",
            deleting_records: "{{ __('trades.deleting_records') }}",
            please_dont_close: "{{ __('trades.please_dont_close') }}",
            success: "{{ __('trades.success') }}",
            all_trades_deleted: "{{ __('trades.all_trades_deleted') }}",
            page_will_reload: "{{ __('trades.page_will_reload') }}",
            reload_now: "{{ __('trades.reload_now') }}",
            no_data: "{{ __('trades.no_data') }}",
            no_trades_to_clear: "{{ __('trades.no_trades_to_clear') }}",
            connection_error: "{{ __('trades.connection_error') }}",
            please_check_connection: "{{ __('trades.please_check_connection') }}"
        };

        const deleteTranslations = {
            delete_trade: "{{ __('trades.delete_trade') }}",
            action_cannot_undone: "{{ __('trades.action_cannot_undone') }}",
            trade_to_be_deleted: "{{ __('trades.trade_to_be_deleted') }}",
            to_confirm_type_exact: "{{ __('trades.to_confirm_type_exact') }}",
            please_type_confirmation_exact: "{{ __('trades.please_type_confirmation_exact') }}",
            delete_trade_btn: "{{ __('trades.delete_trade_btn') }}",
            deleting_trade: "{{ __('trades.deleting_trade') }}",
            trade_deleted_success: "{{ __('trades.trade_deleted_success') }}",
            page_will_reload_shortly: "{{ __('trades.page_will_reload_shortly') }}",
            failed_delete_trade: "{{ __('trades.failed_delete_trade') }}",
            please_try_again: "{{ __('trades.please_try_again') }}"
        };
    </script>

    <script>
        // Basic Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Sort dropdown
            const sortDropdownButton = document.getElementById('sortDropdownButton');
            const sortDropdown = document.getElementById('sortDropdown');

            // Import dropdown
            const importDropdownButton = document.getElementById('importDropdownButton');
            const importDropdown = document.getElementById('importDropdown');

            // Toggle sort dropdown
            sortDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.classList.toggle('hidden');
                importDropdown.classList.add('hidden');
            });

            // Toggle import dropdown
            importDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                importDropdown.classList.toggle('hidden');
                sortDropdown.classList.add('hidden');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!sortDropdownButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                    sortDropdown.classList.add('hidden');
                }

                if (!importDropdownButton.contains(event.target) && !importDropdown.contains(event
                        .target)) {
                    importDropdown.classList.add('hidden');
                }
            });

            // Prevent dropdown close when clicking inside
            [sortDropdown, importDropdown].forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
    </script>

    <script>
        function quickClearAll() {
            // Get current trade count for display
            const tradeCount = {{ \App\Models\Trade::count() }};

            if (tradeCount === 0) {
                Swal.fire({
                    icon: 'info',
                    title: translations.no_data,
                    text: translations.no_trades_to_clear,
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                title: '🚨 ' + translations.clear_all_trades + '?',
                html: `
                        <div class="text-left text-sm">
                            <p class="text-red-400 mb-3 font-bold">${translations.cannot_be_undone}!</p>
                            <div class="bg-red-900/20 p-4 rounded-lg mb-4 border border-red-700/30">
                                <p class="font-bold mb-2 text-red-300">${translations.will_be_deleted}:</p>
                                <ul class="space-y-1 text-gray-300">
                                    <li class="flex items-center">
                                        <i class="fas fa-trash text-red-500 mr-2 text-xs"></i>
                                        <span><strong>${tradeCount}</strong> ${translations.trading_records}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-chart-bar text-red-500 mr-2 text-xs"></i>
                                        <span>${translations.all_performance_stats}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-link text-red-500 mr-2 text-xs"></i>
                                        <span>${translations.all_rule_associations}</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-history text-red-500 mr-2 text-xs"></i>
                                        <span>${translations.complete_trading_history}</span>
                                    </li>
                                </ul>
                            </div>
                            <p class="text-gray-300 mb-2">${translations.to_confirm_type}:</p>
                            <div class="bg-dark-800/50 p-3 rounded-lg mb-3">
                                <code class="text-red-400 font-mono font-bold">DELETE_ALL_TRADES</code>
                            </div>
                            <input type="text" 
                                id="quickConfirm" 
                                class="swal2-input w-full" 
                                placeholder="${translations.please_type_confirmation}..."
                                autocomplete="off">
                        </div>
                    `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-broom mr-2"></i>' + translations.clear_all_trades_btn,
                cancelButtonText: '<i class="fas fa-times mr-2"></i>' + translations.cancel_btn,
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-gray-800 border border-red-700/30',
                    title: 'text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:bg-red-700',
                    cancelButton: 'hover:bg-gray-700'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById('quickConfirm');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== 'DELETE_ALL_TRADES') {
                        Swal.showValidationMessage(
                            `<div class="text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    ${translations.please_type_confirmation} <code class="bg-red-900/30 px-1 py-0.5 rounded">DELETE_ALL_TRADES</code>
                </div>`
                        );
                        return false;
                    }
                    return {
                        confirmation: typedValue
                    };
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // Show loading with custom message
                    Swal.fire({
                        title: translations.cleaning_trades + '...',
                        html: `
                <div class="text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                    <p class="text-gray-400">${translations.deleting_records.replace(':count', tradeCount)}</p>
                    <p class="text-xs text-gray-500 mt-2">${translations.please_dont_close}</p>
                </div>
            `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // Submit via AJAX
                    fetch('{{ route('trades.clear-all') }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(async response => {
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            }

                            const text = await response.text();
                            throw new Error(`Server returned: ${text.substring(0, 100)}...`);
                        })
                        .then(data => {
                            if (data.success) {
                                // SUCCESS - Show success message
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: '#10b981',
                                    title: translations.success + '!',
                                    html: `
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/20 rounded-full mb-4">
                                <i class="fas fa-check text-green-500 text-2xl"></i>
                            </div>
                            <p class="text-green-400 font-bold text-lg mb-2">${data.message}</p>
                            <p class="text-gray-400 text-sm">${translations.all_trades_deleted}</p>
                            <p class="text-gray-500 text-xs mt-2">${translations.page_will_reload}</p>
                        </div>
                    `,
                                    showConfirmButton: true,
                                    confirmButtonText: '<i class="fas fa-sync-alt mr-2"></i>' +
                                        translations.reload_now,
                                    confirmButtonColor: '#10b981',
                                    timer: 5000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        location.reload();
                                    }
                                }).then((reloadResult) => {
                                    if (reloadResult.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                // SERVER RETURNED ERROR
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    html: `
                        <div class="text-left">
                            <p class="text-red-400 mb-3">${data.message}</p>
                            ${data.error ? `<p class="text-gray-500 text-xs mb-2">${data.error}</p>` : ''}
                            <p class="text-gray-400 text-sm mt-3">${translations.please_check_connection}</p>
                        </div>
                    `,
                                    confirmButtonColor: '#d33'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Clear All Error:', error);

                            Swal.fire({
                                icon: 'error',
                                title: translations.connection_error,
                                html: `
                    <div class="text-left">
                        <p class="text-red-400 mb-3">${translations.connection_error}</p>
                        <p class="text-gray-500 text-xs mb-2">${error.message}</p>
                        <p class="text-gray-400 text-sm mt-3">${translations.please_check_connection}</p>
                    </div>
                `,
                                confirmButtonColor: '#d33'
                            });
                        });
                }
            });
        }

        // Add real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.id === 'quickConfirm' && e.target.value.trim() === 'DELETE_ALL_TRADES') {
                    e.target.style.borderColor = '#10b981';
                    e.target.style.boxShadow = '0 0 0 1px rgba(16, 185, 129, 0.2)';
                } else if (e.target.id === 'quickConfirm') {
                    e.target.style.borderColor = '#ef4444';
                    e.target.style.boxShadow = '0 0 0 1px rgba(239, 68, 68, 0.2)';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actionsDropdownButton = document.getElementById('actionsDropdownButton');
            const actionsDropdown = document.getElementById('actionsDropdown');

            if (actionsDropdownButton && actionsDropdown) {
                actionsDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    actionsDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!actionsDropdown.contains(e.target) && !actionsDropdownButton.contains(e.target)) {
                        actionsDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <script>
        function confirmDeleteTrade(event, tradeId, symbol, type) {
            // Hentikan event bubbling
            event.stopPropagation();
            event.preventDefault();

            const tradeType = type === 'buy' ? 'BUY' : 'SELL';

            Swal.fire({
                title: deleteTranslations.delete_trade + '?',
                html: `
                    <div class="text-left text-sm">
                        <p class="text-red-400 mb-3 font-bold">${deleteTranslations.action_cannot_undone}!</p>
                        <div class="bg-red-900/20 p-4 rounded-lg mb-4 border border-red-700/30">
                            <p class="font-bold mb-2 text-red-300">${deleteTranslations.trade_to_be_deleted}:</p>
                            <ul class="space-y-2 text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-hashtag text-red-500 mr-2 text-xs"></i>
                                    <span>ID: <strong>${tradeId}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-chart-simple text-red-500 mr-2 text-xs"></i>
                                    <span>Symbol: <strong>${symbol}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-exchange-alt text-red-500 mr-2 text-xs"></i>
                                    <span>Type: <span class="font-bold ${type === 'buy' ? 'text-green-400' : 'text-red-400'}">${tradeType}</span></span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-300 mb-2">${deleteTranslations.to_confirm_type_exact}:</p>
                        <div class="bg-dark-800/50 p-3 rounded-lg mb-3">
                            <code class="text-red-400 font-mono font-bold">DELETE_TRADE_${tradeId}</code>
                        </div>
                        <input type="text" 
                            id="deleteConfirm_${tradeId}" 
                            class="swal2-input w-full" 
                            placeholder="${deleteTranslations.please_type_confirmation_exact}..."
                            autocomplete="off">
                    </div>
                `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>' + deleteTranslations.delete_trade_btn,
                cancelButtonText: '<i class="fas fa-times mr-2"></i>' + translations.cancel_btn,
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-gray-800 border border-red-700/30',
                    title: 'text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:bg-red-700',
                    cancelButton: 'hover:bg-gray-700'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById(`deleteConfirm_${tradeId}`);
                    const typedValue = confirmInput.value.trim();
                    const expectedText = `DELETE_TRADE_${tradeId}`;

                    if (typedValue !== expectedText) {
                        Swal.showValidationMessage(
                            `<div class="text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    ${deleteTranslations.please_type_confirmation_exact} <code class="bg-red-900/30 px-1 py-0.5 rounded">${expectedText}</code>
                </div>`
                        );
                        return false;
                    }
                    return {
                        trade_id: tradeId,
                        confirmation: typedValue
                    };
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // Show loading
                    Swal.fire({
                        title: deleteTranslations.deleting_trade + '...',
                        html: `
                <div class="text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                    <p class="text-gray-400">${deleteTranslations.deleting_trade.replace(':symbol', symbol)}</p>
                </div>
            `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // AJAX request to delete
                    fetch(`/trades/${tradeId}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(async response => {
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            }
                            return response.text();
                        })
                        .then(data => {
                            if (data && data.success) {
                                // SUCCESS
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: '#10b981',
                                    title: deleteTranslations.success + '!',
                                    html: `
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/20 rounded-full mb-4">
                                <i class="fas fa-check text-green-500 text-2xl"></i>
                            </div>
                            <p class="text-green-400 font-bold text-lg mb-2">${deleteTranslations.trade_deleted_success}</p>
                            <p class="text-gray-400 text-sm">${deleteTranslations.page_will_reload_shortly}</p>
                        </div>
                    `,
                                    showConfirmButton: true,
                                    confirmButtonText: '<i class="fas fa-sync-alt mr-2"></i>' +
                                        translations.reload_now,
                                    confirmButtonColor: '#10b981',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        location.reload();
                                    }
                                }).then((reloadResult) => {
                                    if (reloadResult.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                // ERROR
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    html: `
                        <div class="text-left">
                            <p class="text-red-400 mb-3">${data.message || deleteTranslations.failed_delete_trade}</p>
                            <p class="text-gray-400 text-sm mt-3">${deleteTranslations.please_try_again}</p>
                        </div>
                    `,
                                    confirmButtonColor: '#d33'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Delete Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: translations.connection_error,
                                html: `
                    <div class="text-left">
                        <p class="text-red-400 mb-3">${translations.connection_error}</p>
                        <p class="text-gray-400 text-sm mt-3">${translations.please_check_connection}</p>
                    </div>
                `,
                                confirmButtonColor: '#d33'
                            });
                        });
                }
            });
        }

        // Real-time validation for delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.id && e.target.id.startsWith('deleteConfirm_')) {
                    const tradeId = e.target.id.replace('deleteConfirm_', '');
                    const expectedText = `DELETE_TRADE_${tradeId}`;

                    if (e.target.value.trim() === expectedText) {
                        e.target.style.borderColor = '#10b981';
                        e.target.style.boxShadow = '0 0 0 1px rgba(16, 185, 129, 0.2)';
                    } else {
                        e.target.style.borderColor = '#ef4444';
                        e.target.style.boxShadow = '0 0 0 1px rgba(239, 68, 68, 0.2)';
                    }
                }
            });
        });
    </script>

    <script>
        // Fungsi untuk duplicate trade
        function duplicateTrade(event, tradeId) {
            event.stopPropagation();
            event.preventDefault();

            Swal.fire({
                title: '{{ __('trades.duplicate_trade') }}?',
                text: '{{ __('trades.duplicate_confirmation') }}',
                icon: 'question',
                iconColor: '#8b5cf6',
                showCancelButton: true,
                confirmButtonColor: '#8b5cf6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-copy mr-2"></i>{{ __('trades.duplicate') }}',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __('trades.cancel_btn') }}',
                showLoaderOnConfirm: true,
                customClass: {
                    popup: 'bg-gray-800 border border-purple-700/30',
                    title: 'text-purple-300',
                },
                preConfirm: () => {
                    return fetch(`/trades/${tradeId}/duplicate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Gagal menduplikasi trade');
                            }
                            return data;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Error: ${error.message}`
                            );
                        });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const data = result.value;

                    Swal.fire({
                        icon: 'success',
                        iconColor: '#10b981',
                        title: '{{ __('trades.success') }}!',
                        html: `
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/20 rounded-full mb-4">
                                        <i class="fas fa-copy text-green-500 text-2xl"></i>
                                    </div>
                                    <p class="text-green-400 font-bold text-lg mb-2">${data.message}</p>
                                    <p class="text-gray-400 text-sm mb-4">{{ __('trades.trade_duplicated_success') }}</p>
                                    <div class="flex justify-center space-x-3">
                                        <a href="${data.data.edit_url}" 
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                                            <i class="fas fa-edit mr-2"></i>
                                            {{ __('trades.edit_new_trade') }}
                                        </a>
                                        <button onclick="location.reload()" 
                                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                            <i class="fas fa-sync-alt mr-2"></i>
                                            {{ __('trades.refresh_page') }}
                                        </button>
                                    </div>
                                </div>
                            `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            });
        }

        // Perbarui event handling
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr[onclick]');

            rows.forEach(row => {
                const duplicateBtn = row.querySelector('.duplicate-btn');
                const actionsContainer = row.querySelector('td .relative');

                if (duplicateBtn && actionsContainer) {
                    // Hover pada row
                    row.addEventListener('mouseenter', function() {
                        duplicateBtn.classList.remove('opacity-0', '-translate-x-2');
                        duplicateBtn.classList.add('opacity-100', 'translate-x-0');
                    });

                    row.addEventListener('mouseleave', function() {
                        duplicateBtn.classList.remove('opacity-100', 'translate-x-0');
                        duplicateBtn.classList.add('opacity-0', '-translate-x-2');
                    });

                    // Hover pada tombol duplicate
                    duplicateBtn.addEventListener('mouseenter', function(e) {
                        e.stopPropagation();
                    });

                    duplicateBtn.addEventListener('mouseleave', function(e) {
                        e.stopPropagation();
                        // Delay untuk cek apakah masih di row
                        setTimeout(() => {
                            if (!row.matches(':hover')) {
                                duplicateBtn.classList.remove('opacity-100',
                                    'translate-x-0');
                                duplicateBtn.classList.add('opacity-0', '-translate-x-2');
                            }
                        }, 100);
                    });
                }
            });
        });
    </script>

    <style>
        /* SweetAlert Custom Styles */
        .swal2-popup {
            background: #1f2937 !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 0.75rem !important;
        }

        .swal2-title {
            color: #fca5a5 !important;
            font-weight: 600 !important;
        }

        .swal2-html-container {
            color: #d1d5db !important;
        }

        .swal2-input {
            background-color: rgba(31, 41, 55, 0.8) !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: #f3f4f6 !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0 !important;
        }

        .swal2-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-confirm {
            background: #ef4444 !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            /* border: 1px solid rgba(239, 68, 68, 0.3) !important; */
            color: #fca5a5 !important;
            /* border-radius: 0.25rem !important; */
        }
    </style>

    <style>
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }

        .relative>div {
            transition: all 0.2s ease-in-out;
            transform: translateY(-5px);
        }

        .group:hover>div {
            transform: translateY(0);
        }
    </style>

    <style>
        /* Hover effect untuk tombol duplicate */
        tr:hover .duplicate-btn {
            opacity: 1 !important;
        }

        /* Transisi halus untuk hover */
        .duplicate-btn {
            transition: opacity 0.2s ease-in-out, background-color 0.2s ease;
        }

        .duplicate-btn:hover {
            background-color: rgba(168, 85, 247, 0.3) !important;
            transform: scale(1.05);
        }
    </style>

    <style>
        /* Pastikan kolom aksi memiliki lebar tetap */
        td:last-child {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
        }

        /* Container untuk tombol aksi */
        td .relative {
            position: relative;
        }

        /* Grid untuk tombol utama */
        td .grid {
            position: relative;
            width: 100%;
            z-index: 1;
            background: transparent;
        }

        /* Styling untuk duplicate button */
        .duplicate-btn {
            transition: all 0.1s cubic-bezier(0.4, 0, 0.2, 1) !important;
            will-change: opacity, transform;
            pointer-events: none;
        }

        /* Ketika hover pada row, enable pointer events */
        tr:hover .duplicate-btn {
            pointer-events: auto;
        }

        /* Efek hover pada duplicate button */
        .duplicate-btn:hover {
            background-color: rgba(139, 92, 246, 0.95) !important;
        }

        /* Transisi untuk tombol utama saat duplicate muncul (geser ke kanan) */
        tr:hover td .grid {
            transform: translateX(8px);
            transition: transform 0.1s ease;
        }

        /* Reset untuk row yang tidak di-hover */
        tr:not(:hover) td .grid {
            transform: translateX(0);
            transition: transform 0.1s ease;
        }

        /* Pastikan row tidak overflow */
        tr {
            overflow: hidden;
        }
    </style>
@endsection
