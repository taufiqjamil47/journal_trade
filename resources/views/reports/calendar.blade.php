@extends('Layouts.index')
@section('title', __('calendar.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('calendar.header_title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">
                        {{ __('calendar.header_subtitle', [
                            'month' => \Carbon\Carbon::create($year, $month)->format('F'),
                            'year' => $year,
                        ]) }}
                    </p>
                </div>

                <!-- Navigation and Trader Info -->
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 active:scale-95"
                        data-nav-state-save="true">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2 nav-toggle-icon"></i>
                    </button>

                    <!-- Navigation Items Container -->
                    <div id="navItems"
                        class="hidden nav-items-container opacity-0 scale-95 transform transition-all duration-300">
                        <div
                            class="flex items-center space-x-1 bg-white dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-gray-700">
                            <!-- Dashboard Link -->
                            @if (!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-white dark:hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                                    title="Dashboard" data-nav-state-save="true">
                                    <i
                                        class="fas fa-home text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
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
                                    <i
                                        class="fas fa-list text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
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
                                    <i
                                        class="fas fa-user text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.accounts') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trader Item dengan animasi muncul -->
                    <div
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500">
                        <i class="fas fa-user text-primary-500 mr-2 transition-transform duration-200 hover:scale-110"></i>
                        <span class="transition-all duration-200">Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Month/Year Navigation - Responsive Version -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 md:p-5 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Navigation Buttons (Previous/Next) -->
                <div class="flex gap-2 w-full md:w-auto justify-between md:justify-start">
                    <a href="{{ route('reports.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                        class="flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg px-3 py-2 md:px-4 border border-gray-200 dark:border-gray-700 hover:border-primary-500  flex-1 md:flex-none max-w-[48%] md:max-w-none">
                        <i class="fas fa-chevron-left text-primary-500 mr-2 text-sm md:text-base"></i>
                        <span class="text-sm md:text-base truncate">{{ __('calendar.previous_month') }}</span>
                    </a>
                    <a href="{{ route('reports.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                        class="flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg px-3 py-2 md:px-4 border border-gray-200 dark:border-gray-700 hover:border-primary-500  flex-1 md:flex-none max-w-[48%] md:max-w-none">
                        <span class="text-sm md:text-base truncate">{{ __('calendar.next_month') }}</span>
                        <i class="fas fa-chevron-right text-primary-500 ml-2 text-sm md:text-base"></i>
                    </a>
                </div>

                <!-- Month/Year Selector -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col md:flex-row items-center gap-3">
                        <!-- Month/Year Select Grid for Mobile -->
                        <div class="grid grid-cols-2 gap-3 w-full md:w-auto md:flex md:items-center">
                            <div class="grid lg:flex items-center gap-2 w-full">
                                <label for="monthSelect"
                                    class="text-sm text-gray-400 dark:text-gray-300 whitespace-nowrap hidden lg:block">{{ __('calendar.month') }}:</label>
                                <select id="monthSelect"
                                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-2 md:px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent text-sm md:text-base w-auto">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ $monthNames[$m] ?? \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="grid lg:flex items-center gap-2 w-full">
                                <label for="yearSelect"
                                    class="text-sm text-gray-400 dark:text-gray-300 whitespace-nowrap hidden lg:block">{{ __('calendar.year') }}:</label>
                                <select id="yearSelect"
                                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg py-2 px-2 md:px-3 text-gray-600 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent text-sm md:text-base w-auto">
                                    @php $nowJakarta = \Carbon\Carbon::now('Asia/Jakarta'); @endphp
                                    @for ($y = $nowJakarta->year - 5; $y <= $nowJakarta->year + 1; $y++)
                                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 w-full md:w-auto mt-2 md:mt-0">
                            <button id="goToDate"
                                class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg px-4 py-2  text-sm md:text-base flex-1 md:flex-none">
                                {{ __('calendar.go') }}
                            </button>

                            <a href="{{ route('reports.calendar', ['month' => \Carbon\Carbon::now('Asia/Jakarta')->month, 'year' => \Carbon\Carbon::now('Asia/Jakarta')->year]) }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-4 py-2  text-sm md:text-base flex-1 md:flex-none text-center">
                                {{ __('calendar.today') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-6">
            <h3 class="text-xl font-bold text-primary-300 mb-4">
                {{ __('calendar.day_calendar', ['year' => $year]) }}
            </h3>

            <!-- Container dengan scroll horizontal -->
            <div class="overflow-x-auto pb-2 -mx-3 sm:mx-0">
                <div class="min-w-[900px] sm:min-w-full">
                    <!-- Day headers + Weekly Summary Header -->
                    <div class="grid grid-cols-9 gap-1 mb-2">
                        @foreach ([__('calendar.sun'), __('calendar.mon'), __('calendar.tue'), __('calendar.wed'), __('calendar.thu'), __('calendar.fri'), __('calendar.sat'), __('calendar.week_summary')] as $day)
                            <div
                                class="text-center font-medium text-gray-600 dark:text-gray-400 py-2 bg-gray-750 rounded-lg {{ $loop->last ? 'col-span-2' : '' }}">
                                {{ $day }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Calendar days + Weekly Summary -->
                    <div class="grid grid-cols-9 gap-1 grid-flow-row-dense">
                        @php
                            $weekNumber = null;
                            $weekDays = [];
                            $weekTotalProfit = 0;
                            $weekTotalTrades = 0;
                            $currentWeekStart = null;
                        @endphp

                        @foreach ($period as $index => $day)
                            @php
                                $date = $day->format('Y-m-d');
                                $info = $daily[$date] ?? null;
                                $profit = $info->total_profit ?? 0;
                                $dayTrades = $trades[$date] ?? collect();
                                $isCurrentMonth = $day->month == $month;
                                $opacityClass = $isCurrentMonth ? 'opacity-100' : 'opacity-30';
                                $isToday = $date == \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
                                $dayOfWeek = $day->dayOfWeek;
                                $currentWeekNum = $day->weekOfYear;

                                if ($weekNumber === null) {
                                    $weekNumber = $currentWeekNum;
                                    $currentWeekStart = $day->copy()->startOfWeek();
                                }

                                $weekTotalProfit += $profit;
                                $weekTotalTrades += count($dayTrades);
                                $weekDays[$dayOfWeek] = [
                                    'date' => $date,
                                    'profit' => $profit,
                                    'trades' => count($dayTrades),
                                    'day' => $day,
                                ];

                                if ($profit > 0) {
                                    $bgColor = 'bg-green-200 dark:bg-green-800/20';
                                    $borderColor = 'border-green-600 dark:border-green-500/40';
                                    $textColor = 'text-green-600 dark:text-green-400';
                                } elseif ($profit < 0) {
                                    $bgColor = 'bg-red-200 dark:bg-red-500/20';
                                    $borderColor = 'border-red-600 dark:border-red-500/40';
                                    $textColor = 'text-red-600 dark:text-red-400';
                                } else {
                                    $bgColor = 'bg-gray-750';
                                    $borderColor = 'border-gray-400 dark:border-gray-600';
                                    $textColor = 'text-gray-200 dark:text-gray-400';
                                }

                                if ($isToday) {
                                    $borderColor = 'border-primary-500';
                                    $bgColor = $bgColor . ' bg-primary-500/10';
                                }
                            @endphp

                            <!-- Day Cell -->
                            <div class="p-2 rounded-lg border {{ $borderColor }} {{ $bgColor }} {{ $opacityClass }} cursor-pointer day-cell  hover:bg-gray-300/30 dark:hover:bg-gray-700/50"
                                data-date="{{ $date }}" data-trades='@json($dayTrades)'
                                data-profit="{{ $profit }}">
                                <div class="flex justify-between items-start">
                                    <strong
                                        class="text-sm {{ $isToday ? 'text-primary-400' : 'text-gray-600 dark:text-gray-200' }}">{{ $day->format('d') }}</strong>
                                    @if (count($dayTrades) > 0)
                                        <span
                                            class="text-xs bg-gray-800 dark:bg-primary-500/30 text-white dark:text-primary-300 rounded-full px-1.5 py-0.5">
                                            {{ count($dayTrades) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1 text-xs lg:text-lg {{ $textColor }} font-medium">
                                    ${{ number_format($profit, 2) }}
                                </div>
                                <div class="pt-3 border-t border-gray-600/50 mt-1">
                                    <div class="flex justify-center items-center">
                                        @if ($profit != 0)
                                            <div class="w-16 h-8">
                                                <svg viewBox="0 0 100 40" class="w-full h-full">
                                                    @if ($profit > 0)
                                                        <path d="M0,30 L20,20 L40,25 L60,15 L80,10 L100,5" stroke="#10B981"
                                                            stroke-width="2" fill="none" class="profit-line" />
                                                        <path d="M0,30 L20,20 L40,25 L60,15 L80,10 L100,5 L100,40 L0,40 Z"
                                                            fill="rgba(16, 185, 129, 0.1)" class="profit-fill" />
                                                    @else
                                                        <path d="M0,10 L20,15 L40,20 L60,25 L80,30 L100,35"
                                                            stroke="#EF4444" stroke-width="2" fill="none"
                                                            class="loss-line" />
                                                        <path d="M0,10 L20,15 L40,20 L60,25 L80,30 L100,35 L100,40 L0,40 Z"
                                                            fill="rgba(239, 68, 68, 0.1)" class="loss-fill" />
                                                    @endif
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm {{ $profit > 0 ? 'text-green-400' : 'text-red-400' }} ml-2">
                                                {{ $profit > 0 ? __('calendar.profit') : __('calendar.loss') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Weekly Summary Column (Every Saturday OR last day of month) -->
                            @if ($dayOfWeek == 6 || $loop->last)
                                @php
                                    $weekProfitColor =
                                        $weekTotalProfit > 0
                                            ? 'text-green-600 dark:text-green-400'
                                            : ($weekTotalProfit < 0
                                                ? 'text-red-600 dark:text-red-400'
                                                : 'text-gray-600 dark:text-gray-400');
                                    $weekBgColor =
                                        $weekTotalProfit > 0
                                            ? 'bg-green-200 dark:bg-green-900/20'
                                            : ($weekTotalProfit < 0
                                                ? 'bg-red-200 dark:bg-red-900/20'
                                                : 'bg-gray-750');
                                    $weekBorderColor =
                                        $weekTotalProfit > 0
                                            ? 'border-green-600 dark:border-green-500/40'
                                            : ($weekTotalProfit < 0
                                                ? 'border-red-600 dark:border-red-500/40'
                                                : 'border-gray-600');

                                    $isCurrentWeek =
                                        $currentWeekStart <= \Carbon\Carbon::now('Asia/Jakarta') &&
                                        \Carbon\Carbon::now('Asia/Jakarta') <= $currentWeekStart->copy()->endOfWeek();
                                    if ($isCurrentWeek) {
                                        $weekBorderColor = 'border-primary-500';
                                        $weekBgColor .= ' bg-primary-500/10';
                                    }

                                    $weekStartFormatted = $currentWeekStart->format('M d');
                                    $weekEndFormatted = $currentWeekStart->copy()->endOfWeek()->format('M d');
                                    $weekRange = "{$weekStartFormatted} - {$weekEndFormatted}";
                                @endphp

                                <!-- Weekly Summary Cell -->
                                <div class="p-2 col-span-2 rounded-lg border {{ $weekBorderColor }} {{ $weekBgColor }} cursor-pointer weekly-cell hover:bg-gray-300/50 dark:hover:bg-gray-700/50"
                                    data-week="{{ $weekNumber }}"
                                    data-week-start="{{ $currentWeekStart->format('Y-m-d') }}"
                                    data-week-end="{{ $currentWeekStart->copy()->endOfWeek()->format('Y-m-d') }}"
                                    data-week-profit="{{ $weekTotalProfit }}" data-week-trades="{{ $weekTotalTrades }}">
                                    <div class="flex justify-between items-start mb-1">
                                        <strong class="text-sm text-gray-600 dark:text-gray-200">
                                            {{ __('calendar.week_label', ['week' => $weekNumber]) }}
                                        </strong>
                                        @if ($isCurrentWeek)
                                            <span
                                                class="text-xs bg-primary-500 text-white px-1.5 py-0.5 rounded">{{ __('calendar.now') }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $weekRange }}</div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.trades') }}:</span>
                                            <span
                                                class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ $weekTotalTrades }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.pl') }}:</span>
                                            <span class="text-xs font-bold {{ $weekProfitColor }}">
                                                ${{ number_format($weekTotalProfit, 2) }}
                                            </span>
                                        </div>
                                        @if ($weekTotalTrades > 0)
                                            <div class="pt-1 border-t border-gray-600/50 mt-1">
                                                <div class="flex justify-center">
                                                    @if ($weekTotalProfit > 0)
                                                        <i
                                                            class="fas fa-arrow-up text-green-600 dark:text-green-500 text-xs"></i>
                                                        <span
                                                            class="text-xs text-green-600 dark:text-green-400 ml-1">{{ __('calendar.profit') }}</span>
                                                    @elseif ($weekTotalProfit < 0)
                                                        <i
                                                            class="fas fa-arrow-down text-red-600 darktext-red-500 text-xs"></i>
                                                        <span
                                                            class="text-xs text-red-600 darktext-red-400 ml-1">{{ __('calendar.loss') }}</span>
                                                    @else
                                                        <span
                                                            class="text-xs text-gray-400">{{ __('calendar.even') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @php
                                    $weekNumber = $currentWeekNum;
                                    $weekTotalProfit = 0;
                                    $weekTotalTrades = 0;
                                    $weekDays = [];
                                    $currentWeekStart = $day->copy()->addDay()->startOfWeek();
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Weekly Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-primary-300">{{ __('calendar.profit_loss_trend') }}</h3>
                        <p id="chartPeriodInfo" class="text-sm text-gray-400 mt-1">
                            {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Period Selector -->
                        <div class="flex bg-gray-750 rounded-lg p-1 border border-gray-300 dark:border-gray-600 gap-1">
                            <button type="button" data-period="weekly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium  bg-primary-600 text-white">
                                {{ __('calendar.weekly') }}
                            </button>
                            <button type="button" data-period="monthly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium  text-gray-300 hover:text-white hover:bg-gray-700">
                                {{ __('calendar.monthly') }}
                            </button>
                            <button type="button" data-period="yearly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium  text-gray-300 hover:text-white hover:bg-gray-700">
                                {{ __('calendar.yearly') }}
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="text-xs text-gray-600 dark:text-gray-400 hidden md:block" id="dataCountInfo">
                                {{ $weekly->count() }}
                                {{ __('calendar.weeks') }}</div>
                            <div class="bg-blue-500/20 p-1.5 rounded-lg">
                                <i class="fas fa-chart-line text-blue-500 text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="relative">
                    <!-- Loading State -->
                    <div id="chartLoading"
                        class="hidden absolute inset-0 bg-gray-400/20 dark:bg-gray-800/80 flex items-center justify-center z-10 rounded-lg">
                        <div class="flex flex-col items-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary-500 mb-2">
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('calendar.loading_chart') }}</p>
                        </div>
                    </div>

                    <!-- Chart Canvas -->
                    <div class="h-80">
                        <canvas id="performanceChart"></canvas>
                    </div>

                    <!-- No Data State -->
                    <div id="noDataMessage" class="hidden flex flex-col items-center justify-center py-12 text-gray-400">
                        <i class="fas fa-chart-bar text-3xl mb-3 opacity-50"></i>
                        <p class="text-base text-gray-300">{{ __('calendar.no_data_available') }}</p>
                        <p class="text-sm mt-1">{{ __('calendar.start_trading_see_performance') }}</p>
                    </div>
                </div>

                <!-- Chart Legend -->
                <div class="mt-4 flex flex-wrap gap-4 justify-center">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span
                            class="text-sm text-gray-600 dark:text-gray-300">{{ __('calendar.profit_loss_currency') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('calendar.trades_count') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-primary-500 rounded-full"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('calendar.profit_legend') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('calendar.loss_legend') }}</span>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-primary-300">
                        {{ __('calendar.monthly_calendar', ['year' => $year]) }}
                    </h3>
                    <div class="flex items-center gap-2">
                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ $monthly->count() }}
                            {{ __('calendar.months_with_trades') }}</div>
                        <div class="bg-green-500/20 p-1.5 rounded-lg">
                            <i class="fas fa-calendar-alt text-green-500 text-sm"></i>
                        </div>
                    </div>
                </div>

                @if ($monthly->count() > 0)
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-1">
                        @php
                            $nowJakarta = \Carbon\Carbon::now('Asia/Jakarta');
                            $currentMonth = $nowJakarta->month;
                            $currentYear = $nowJakarta->year;
                        @endphp

                        @foreach ($monthly as $m)
                            @php
                                $monthName =
                                    $shortMonthNames[$m->month] ??
                                    \Carbon\Carbon::create()->month($m->month)->format('M');
                                $totalProfit = $m->total_profit ?? 0;
                                $totalTrades = $m->total_trades ?? 0;

                                $profitColor = 'text-green-600 dark:text-gray-400';
                                $profitBg = '';

                                if ($totalProfit > 0) {
                                    $profitColor = 'text-green-600 dark:text-green-400';
                                    $profitBg = 'bg-green-400/40 dark:bg-green-900/10';
                                } elseif ($totalProfit < 0) {
                                    $profitColor = 'text-red-600 dark:text-red-400';
                                    $profitBg = 'bg-red-400/40 bg-red-900/10';
                                }

                                $isCurrentMonth = $m->month == $currentMonth && $m->year == $currentYear;
                                $borderClass = $isCurrentMonth
                                    ? 'ring-1 ring-primary-500'
                                    : 'border border-gray-500 dark:border-gray-700';
                            @endphp

                            <div class="{{ $profitBg }} {{ $borderClass }} rounded-lg p-2 hover:bg-gray-750/30 ">
                                <!-- Month Header -->
                                <div class="mb-1">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-semibold text-gray-700 dark:text-gray-200 text-sm">
                                            {{ $monthName }}</h4>
                                        @if ($isCurrentMonth)
                                            <span
                                                class="text-xs bg-primary-500 text-white px-1.5 py-0.5 rounded">{{ __('calendar.now') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="space-y-1 flex items-center justify-between">
                                    <!-- Trades -->
                                    <div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mb-0.5">
                                            {{ __('calendar.trades') }}</div>
                                        <div class="font-bold text-gray-600 dark:text-gray-200 text-base">
                                            {{ $totalTrades }}
                                        </div>
                                    </div>

                                    <!-- P/L -->
                                    <div>
                                        <div class="text-xs text-gray-400 mb-0.5">{{ __('calendar.pl') }}</div>
                                        <div class="font-bold {{ $profitColor }} text-lg flex items-center gap-2">
                                            ${{ number_format($totalProfit, 0) }}
                                            @if ($totalProfit != 0)
                                                @if ($totalProfit > 0)
                                                    <i
                                                        class="fas fa-arrow-up text-green-700 dark:text-green-500 text-xs mr-1"></i>
                                                @else
                                                    <i
                                                        class="fas fa-arrow-down text-red-700 dark:text-red-500 text-xs mr-1"></i>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-2">
                            <i class="fas fa-calendar-times text-3xl"></i>
                        </div>
                        <p class="text-gray-400">{{ __('calendar.no_trades_recorded') }} {{ $year }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Trade Details Modal -->
    <div id="tradeModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl w-full max-w-md mx-auto"
            id="modalContentContainer">
            <div class="flex justify-between items-center p-4 border-b border-gray-700">
                <h4 id="modalTitle" class="text-lg font-bold text-primary-400">{{ __('calendar.trade_details') }}</h4>
                <button id="closeModal" class="text-gray-400 hover:text-black dark:hover:text-white  p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div id="modalContent" class="p-4 max-h-[60vh] overflow-y-auto">
                <!-- Content will be filled by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Scripts Khusus menangani modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === HELPER FUNCTION UNTUK FORMAT TANGGAL ===
            function getDateLocale() {
                const laravelLocale = '{{ app()->getLocale() }}';
                const localeMap = {
                    'en': 'en-US',
                    'id': 'id-ID',
                };
                return localeMap[laravelLocale] || 'en-US';
            }

            function formatDate(date, options = {}) {
                return new Date(date).toLocaleDateString(getDateLocale(), options);
            }
            // === END HELPER FUNCTION ===

            const modal = document.getElementById('tradeModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const closeModalBtn = document.getElementById('closeModal');
            const monthSelect = document.getElementById('monthSelect');
            const yearSelect = document.getElementById('yearSelect');
            const goToDateBtn = document.getElementById('goToDate');

            // Get translation strings from Blade
            const translations = {
                profit: "{{ __('calendar.profit') }}",
                loss: "{{ __('calendar.loss') }}",
                winning: "{{ __('calendar.winning') }}",
                losing: "{{ __('calendar.losing') }}",
                total: "{{ __('calendar.total') }}",
                symbol: "{{ __('calendar.symbol') }}",
                type: "{{ __('calendar.type') }}",
                no_trades_day: "{{ __('calendar.no_trades_day') }}",
                start_trading_see_performance_day: "{{ __('calendar.start_trading_see_performance_day') }}",
                click_days_detail: "{{ __('calendar.click_days_detail') }}",
                week_range: "{{ __('calendar.week_range') }}",
                to: "{{ __('calendar.to') }}",
                total_pl: "{{ __('calendar.total_pl') }}",
                total_weekly: "{{ __('calendar.total_weekly') }}",
            };

            // Navigate to selected month/year
            goToDateBtn.addEventListener('click', function() {
                const month = monthSelect.value;
                const year = yearSelect.value;
                window.location.href = `{{ route('reports.calendar') }}?month=${month}&year=${year}`;
            });

            // Event listener for day cells
            document.querySelectorAll('.day-cell').forEach(cell => {
                cell.addEventListener('click', function() {
                    const date = this.getAttribute('data-date');
                    const trades = JSON.parse(this.getAttribute('data-trades'));
                    const profit = parseFloat(this.getAttribute('data-profit'));

                    // Format date for modal title
                    const dateObj = new Date(date);
                    const options = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };
                    const formattedDate = formatDate(date, {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Set modal title
                    modalTitle.textContent = `${formattedDate}`;

                    // Create modal content
                    let content = '';

                    if (trades.length > 0) {
                        let totalProfit = 0;
                        let winningTrades = 0;
                        let losingTrades = 0;

                        trades.forEach(trade => {
                            totalProfit += parseFloat(trade.profit_loss);
                            if (trade.profit_loss > 0) winningTrades++;
                            else if (trade.profit_loss < 0) losingTrades++;
                        });

                        content += `
                        <div class="mb-4 p-3 rounded-lg ${profit > 0 ? 'bg-green-500/10 border border-green-500/30' : 'bg-red-500/10 border border-red-500/30'}">
                            <div class="flex justify-between items-center mb-1">
                                <p class="font-medium text-gray-600 dark:text-gray-300">${translations.total_pl}:</p>
                                <span class="${profit > 0 ? 'text-green-400' : 'text-red-400'} font-bold">$${profit.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-400">
                                <span class="text-gray-600 dark:text-gray-300">${translations.winning}: <span class="text-green-400">${winningTrades}</span></span>
                                <span class="text-gray-600 dark:text-gray-300">${translations.losing}: <span class="text-red-400">${losingTrades}</span></span>
                                <span class="text-gray-600 dark:text-gray-300">${translations.total}: <span class="text-gray-600 dark:text-gray-300">${trades.length}</span></span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-300 dark:border-gray-600">
                                        <th class="text-left py-2 text-gray-600 dark:text-gray-400 font-medium">${translations.symbol}</th>
                                        <th class="text-left py-2 text-gray-600 dark:text-gray-400 font-medium">${translations.type}</th>
                                        <th class="text-right py-2 text-gray-600 dark:text-gray-400 font-medium">P/L ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        trades.forEach(trade => {
                            content += `
                            <tr class="border-b border-gray-300 dark:border-gray-700/50 hover:bg-gray-300/60 dark:hover:bg-gray-750/50 ">
                                <td class="py-2 text-gray-600 dark:text-gray-300">${trade.symbol_name}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs ${trade.type === 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'}">
                                        ${trade.type.toUpperCase()}
                                    </span>
                                </td>
                                <td class="py-2 text-right font-medium ${trade.profit_loss > 0 ? 'text-green-400' : 'text-red-400'}">
                                    $${parseFloat(trade.profit_loss).toFixed(2)}
                                </td>
                            </tr>
                        `;
                        });

                        content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    } else {
                        content = `
                        <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                            <i class="fas fa-chart-bar text-3xl mb-3 opacity-50"></i>
                            <p class="text-base text-gray-300">${translations.no_trades_day}</p>
                            <p class="text-sm mt-1">${translations.start_trading_see_performance_day}</p>
                        </div>
                    `;
                    }

                    modalContent.innerHTML = content;
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Event listener for weekly summary cells
            document.querySelectorAll('.weekly-cell').forEach(cell => {
                cell.addEventListener('click', function() {
                    const weekNumber = this.getAttribute('data-week');
                    const weekStart = this.getAttribute('data-week-start');
                    const weekEnd = this.getAttribute('data-week-end');
                    const weekProfit = parseFloat(this.getAttribute('data-week-profit'));
                    const weekTrades = parseInt(this.getAttribute('data-week-trades'));

                    // Format dates
                    const startDate = new Date(weekStart);
                    const endDate = new Date(weekEnd);
                    const options = {
                        month: 'short',
                        day: 'numeric'
                    };
                    const formattedStart = formatDate(weekStart, {
                        month: 'short',
                        day: 'numeric'
                    });
                    const formattedEnd = formatDate(weekEnd, {
                        month: 'short',
                        day: 'numeric'
                    });

                    // Set modal title
                    modalTitle.textContent =
                        `{{ __('calendar.week') }} ${weekNumber} (${formattedStart} - ${formattedEnd})`;

                    // Create modal content for weekly summary
                    let content = `
                        <div class="mb-4 p-3 rounded-lg ${weekProfit > 0 ? 'bg-green-500/10 border border-green-500/30' : weekProfit < 0 ? 'bg-red-500/10 border border-red-500/30' : 'bg-gray-300/50 dark:bg-gray-700/50 border border-gray-600'}">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">${translations.total_weekly}</div>
                                    <div class="text-2xl font-bold text-gray-600 dark:text-gray-200">${weekTrades}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">${translations.total_pl}</div>
                                    <div class="text-2xl font-bold ${weekProfit > 0 ? 'text-green-400' : weekProfit < 0 ? 'text-red-400' : 'text-gray-400'}">
                                        $${weekProfit.toFixed(2)}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-600">
                                <div class="text-sm text-gray-600 dark:text-gray-400">${translations.week_range}</div>
                                <div class="text-gray-400 dark:text-gray-300">
                                    ${formatDate(weekStart, {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })} 
                                    ${translations.to} 
                                    ${formatDate(weekEnd, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                                </div>
                            </div>
                        </div>
                    `;

                    content += `
                        <div class="text-center py-4">
                            <p class="text-gray-600 dark:text-gray-400">${translations.click_days_detail}</p>
                        </div>
                    `;

                    modalContent.innerHTML = content;
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Close modal button
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === HELPER FUNCTION UNTUK FORMAT TANGGAL ===
            function getDateLocale() {
                const laravelLocale = '{{ app()->getLocale() }}';
                const localeMap = {
                    'en': 'en-US',
                    'id': 'id-ID',
                };
                return localeMap[laravelLocale] || 'en-US';
            }

            function formatDate(date, options = {}) {
                return new Date(date).toLocaleDateString(getDateLocale(), options);
            }
            // === END HELPER FUNCTION ===
            // Chart.js Initialization
            const chartCanvas = document.getElementById('performanceChart');
            const ctx = chartCanvas.getContext('2d');
            const chartLoading = document.getElementById('chartLoading');
            const noDataMessage = document.getElementById('noDataMessage');
            const periodButtons = document.querySelectorAll('.period-btn');
            const chartPeriodInfo = document.getElementById('chartPeriodInfo');
            const dataCountInfo = document.getElementById('dataCountInfo');

            // Get translation strings
            const translations = {
                profit_loss_currency: "{{ __('calendar.profit_loss_currency') }}",
                pl: "{{ __('calendar.pl') }}",
                weeks: "{{ __('calendar.week') }}",
                days: "{{ __('calendar.day') }}",
                months: "{{ __('calendar.month') }}",
                weekly: "{{ __('calendar.weekly') }}",
                monthly: "{{ __('calendar.monthly') }}",
                yearly: "{{ __('calendar.yearly') }}"
            };

            // Data dari backend
            const backendData = {
                daily: @json($daily),
                trades: @json($trades),
                weekly: @json($weekly),
                monthly: @json($monthly),
                currentMonth: {{ $month }},
                currentYear: {{ $year }}
            };

            let performanceChart = null;
            let currentPeriod = 'weekly';

            // Initialize Chart
            function initChart() {
                if (performanceChart) {
                    performanceChart.destroy();
                }

                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

                performanceChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: translations.profit_loss_currency,
                            data: [],
                            borderColor: '#3b82f6',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: function(context) {
                                const value = context.dataset.data[context.dataIndex];
                                return value >= 0 ? '#10b981' : '#ef4444';
                            },
                            pointBorderColor: '#1f2937',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                titleColor: '#d1d5db',
                                bodyColor: '#d1d5db',
                                borderColor: '#374151',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y;
                                        return `${translations.pl}: $${value.toFixed(2)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    maxRotation: 45
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        return '$' + value.toFixed(0);
                                    }
                                },
                                title: {
                                    display: true,
                                    text: translations.profit_loss_currency,
                                    color: '#9ca3af'
                                }
                            }
                        }
                    }
                });

                // Load initial data
                loadChartData('weekly');
            }

            // Get weekly data
            function getWeeklyData() {
                if (!backendData.weekly || backendData.weekly.length === 0) {
                    return [];
                }

                const sortedWeekly = [...backendData.weekly].sort((a, b) => {
                    if (a.year !== b.year) return a.year - b.year;
                    if (a.month !== b.month) return a.month - b.month;
                    return a.week - b.week;
                });

                return sortedWeekly.map(week => {
                    const weekStart = new Date(week.year, week.month - 1, 1);
                    const weekStartDate = new Date(weekStart);
                    weekStartDate.setDate((week.week - 1) * 7 + 1);

                    return {
                        label: `{{ __('calendar.week_label', ['week' => '']) }}${week.week}`,
                        profit: parseFloat(week.total_profit || 0),
                        trades: week.total_trades || 0,
                        weekNumber: week.week,
                        month: week.month,
                        year: week.year,
                        weekRange: `{{ __('calendar.week_label', ['week' => '']) }}${week.week} (${weekStartDate.getDate()}/${week.month})`
                    };
                });
            }

            // Get monthly data
            function getMonthlyData() {
                const monthData = [];
                const daysInMonth = new Date(backendData.currentYear, backendData.currentMonth, 0).getDate();

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr =
                        `${backendData.currentYear}-${String(backendData.currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dayData = backendData.daily[dateStr];
                    const dayTrades = backendData.trades[dateStr];

                    monthData.push({
                        label: String(day),
                        profit: dayData ? parseFloat(dayData.total_profit || 0) : 0,
                        trades: dayTrades ? dayTrades.length : 0,
                        date: dateStr
                    });
                }

                return monthData;
            }

            // Get yearly data
            function getYearlyData() {
                if (!backendData.monthly || backendData.monthly.length === 0) {
                    return [];
                }

                const monthNames = [
                    @foreach (range(1, 12) as $m)
                        "{{ $shortMonthNames[$m] ?? \Carbon\Carbon::create()->month($m)->format('M') }}",
                    @endforeach
                ];

                const yearData = backendData.monthly
                    .filter(month => month.year === backendData.currentYear)
                    .sort((a, b) => a.month - b.month)
                    .map(month => ({
                        label: monthNames[month.month - 1],
                        profit: parseFloat(month.total_profit || 0),
                        trades: month.total_trades || 0,
                        month: month.month
                    }));

                return yearData;
            }

            // Load Chart Data
            function loadChartData(period) {
                chartLoading.classList.remove('hidden');
                chartCanvas.classList.add('opacity-50');
                noDataMessage.classList.add('hidden');

                let data = [];
                let periodInfo = '';
                let periodType = '';

                switch (period) {
                    case 'weekly':
                        data = getWeeklyData();
                        periodInfo =
                            `${translations.weekly} - ${new Date(backendData.currentYear, backendData.currentMonth - 1).toLocaleString('default', { month: 'long' })} ${backendData.currentYear}`;
                        periodType = translations.weeks;
                        break;
                    case 'monthly':
                        data = getMonthlyData();
                        periodInfo =
                            `${translations.monthly} - ${new Date(backendData.currentYear, backendData.currentMonth - 1).toLocaleString('default', { month: 'long' })} ${backendData.currentYear}`;
                        periodType = translations.days;
                        break;
                    case 'yearly':
                        data = getYearlyData();
                        periodInfo = `${translations.yearly} - ${backendData.currentYear}`;
                        periodType = translations.months;
                        break;
                }

                // Update UI
                chartPeriodInfo.textContent = periodInfo;
                dataCountInfo.textContent = `${data.length} ${periodType}`;

                // Update chart
                updateChartWithData(data, period);

                // Hide loading
                setTimeout(() => {
                    chartLoading.classList.add('hidden');
                    chartCanvas.classList.remove('opacity-50');
                }, 300);
            }

            // Update Chart with Data
            function updateChartWithData(data, period) {
                if (!data || data.length === 0) {
                    chartCanvas.classList.add('hidden');
                    noDataMessage.classList.remove('hidden');
                    return;
                }

                chartCanvas.classList.remove('hidden');
                noDataMessage.classList.add('hidden');

                // Extract labels and data
                const labels = data.map(item => item.label);
                const profits = data.map(item => item.profit);

                // Update chart data
                performanceChart.data.labels = labels;
                performanceChart.data.datasets[0].data = profits;

                // Customize tooltip based on period
                performanceChart.options.plugins.tooltip.callbacks.title = function(tooltipItems) {
                    const index = tooltipItems[0].dataIndex;
                    const item = data[index];

                    if (period === 'weekly' && item.weekRange) {
                        return item.weekRange;
                    } else if (period === 'monthly' && item.date) {
                        return formatDate(item.date, {
                            weekday: 'short',
                            month: 'short',
                            day: 'numeric'
                        });
                    } else if (period === 'yearly' && item.month) {
                        const monthName = new Date(backendData.currentYear, item.month - 1)
                            .toLocaleDateString(getDateLocale(), {
                                month: 'long'
                            });
                        return `${monthName} ${backendData.currentYear}`;
                    }

                    return item.label;
                };

                performanceChart.update();
            }

            // Period Button Click Handler
            periodButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const period = this.getAttribute('data-period');

                    // Update active button
                    periodButtons.forEach(btn => {
                        btn.classList.remove('bg-primary-600', 'text-white');
                        btn.classList.add('text-gray-300', 'hover:text-white',
                            'hover:bg-gray-700');
                    });

                    this.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-gray-700');
                    this.classList.add('bg-primary-600', 'text-white');

                    // Update chart data
                    currentPeriod = period;
                    loadChartData(period);
                });
            });

            // Initialize the chart
            initChart();

            // Resize chart on window resize
            window.addEventListener('resize', function() {
                if (performanceChart) {
                    performanceChart.resize();
                }
            });
        });
    </script>

    <!-- General Styles -->
    <style>
        .period-btn {
            transition: all 0.2s ease;
            min-width: 70px;
        }

        .period-btn:hover {
            transform: translateY(-1px);
        }

        #performanceChart {
            width: 100% !important;
            height: 320px !important;
        }
    </style>

    <!-- Custom Styles -->
    <style>
        /* Simple scrollbar for modal */
        #modalContent::-webkit-scrollbar {
            width: 5px;
        }

        #modalContent::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        #modalContent::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Calendar day hover effect */
        .day-cell:hover,
        .weekly-cell:hover {
            transform: translateY(-1px);
        }

        /* Grid layout for 8 columns */
        @media (min-width: 768px) {
            .grid-cols-8 {
                grid-template-columns: repeat(8, minmax(0, 1fr));
            }
        }
    </style>
@endsection
