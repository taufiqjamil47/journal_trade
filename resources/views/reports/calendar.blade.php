@extends('Layouts.index')
@section('title', __('calendar.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('calendar.header_title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('calendar.header_subtitle', [
                            'month' => \Carbon\Carbon::create($year, $month)->format('F'),
                            'year' => $year,
                        ]) }}
                    </p>
                </div>

                <!-- Navigation and Trader Info -->
                @include('components.navbar-selector')
            </div>
        </header>

        <!-- Month/Year Navigation - Responsive Version -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 md:p-5 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Navigation Buttons (Previous/Next) -->
                <div class="flex gap-2 w-full md:w-auto justify-between md:justify-start">
                    <a href="{{ route('reports.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                        class="flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg px-3 py-2 md:px-4 border border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 md:flex-none max-w-[48%] md:max-w-none">
                        <i class="fas fa-chevron-left text-indigo-600 dark:text-indigo-400 mr-2 text-sm md:text-base"></i>
                        <span
                            class="text-sm md:text-base text-gray-700 dark:text-gray-300 truncate">{{ __('calendar.previous_month') }}</span>
                    </a>
                    <a href="{{ route('reports.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                        class="flex items-center justify-center bg-white dark:bg-gray-800 rounded-lg px-3 py-2 md:px-4 border border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 md:flex-none max-w-[48%] md:max-w-none">
                        <span
                            class="text-sm md:text-base text-gray-700 dark:text-gray-300 truncate">{{ __('calendar.next_month') }}</span>
                        <i class="fas fa-chevron-right text-indigo-600 dark:text-indigo-400 ml-2 text-sm md:text-base"></i>
                    </a>
                </div>

                <!-- Month/Year Selector -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col md:flex-row items-center gap-3">
                        <!-- Month/Year Select Grid for Mobile -->
                        <div class="grid grid-cols-2 gap-3 w-full md:w-auto md:flex md:items-center">
                            <div class="grid lg:flex items-center gap-2 w-full">
                                <label for="monthSelect"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap hidden lg:block">{{ __('calendar.month') }}:</label>
                                <select id="monthSelect"
                                    class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-2 md:px-3 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow text-sm md:text-base w-auto">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ $monthNames[$m] ?? \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="grid lg:flex items-center gap-2 w-full">
                                <label for="yearSelect"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap hidden lg:block">{{ __('calendar.year') }}:</label>
                                <select id="yearSelect"
                                    class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-2 md:px-3 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow text-sm md:text-base w-auto">
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
                                class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm md:text-base flex-1 md:flex-none shadow-sm hover:shadow">
                                {{ __('calendar.go') }}
                            </button>

                            <a href="{{ route('reports.calendar', ['month' => \Carbon\Carbon::now('Asia/Jakarta')->month, 'year' => \Carbon\Carbon::now('Asia/Jakarta')->year]) }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-4 py-2 text-sm md:text-base flex-1 md:flex-none text-center shadow-sm hover:shadow">
                                {{ __('calendar.today') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('calendar.day_calendar', ['year' => $year]) }}
            </h3>

            <!-- Container dengan scroll horizontal -->
            <div class="overflow-x-auto pb-2 -mx-3 sm:mx-0">
                <div class="min-w-[900px] sm:min-w-full">
                    <!-- Day headers + Weekly Summary Header -->
                    <div class="grid grid-cols-9 gap-1 mb-2">
                        @foreach ([__('calendar.sun'), __('calendar.mon'), __('calendar.tue'), __('calendar.wed'), __('calendar.thu'), __('calendar.fri'), __('calendar.sat'), __('calendar.week_summary')] as $day)
                            <div
                                class="text-center font-medium text-gray-700 dark:text-gray-300 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg {{ $loop->last ? 'col-span-2' : '' }}">
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
                                    $bgColor = 'bg-emerald-100 dark:bg-emerald-900/30';
                                    $borderColor = 'border-emerald-600 dark:border-emerald-500/40';
                                    $textColor = 'text-emerald-700 dark:text-emerald-400';
                                } elseif ($profit < 0) {
                                    $bgColor = 'bg-rose-100 dark:bg-rose-900/30';
                                    $borderColor = 'border-rose-600 dark:border-rose-500/40';
                                    $textColor = 'text-rose-700 dark:text-rose-400';
                                } else {
                                    $bgColor = 'bg-gray-50 dark:bg-gray-700/30';
                                    $borderColor = 'border-gray-300 dark:border-gray-600';
                                    $textColor = 'text-gray-500 dark:text-gray-400';
                                }

                                if ($isToday) {
                                    $borderColor =
                                        'border-indigo-500 dark:border-indigo-400 ring-2 ring-indigo-500/20 dark:ring-indigo-400/20';
                                    $bgColor = $bgColor . ' bg-indigo-50/50 dark:bg-indigo-900/20';
                                }
                            @endphp

                            <!-- Day Cell -->
                            <div class="p-2 rounded-lg border {{ $borderColor }} {{ $bgColor }} {{ $opacityClass }} cursor-pointer day-cell hover:shadow-md hover:scale-[1.02] transition-transform duration-150"
                                data-date="{{ $date }}" data-trades='@json($dayTrades)'
                                data-profit="{{ $profit }}">
                                <div class="flex justify-between items-start">
                                    <strong
                                        class="text-sm {{ $isToday ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">{{ $day->format('d') }}</strong>
                                    @if (count($dayTrades) > 0)
                                        <span
                                            class="text-xs bg-gray-800 dark:bg-indigo-500/30 text-white dark:text-indigo-300 rounded-full px-1.5 py-0.5">
                                            {{ count($dayTrades) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1 text-xs lg:text-base {{ $textColor }} font-semibold">
                                    ${{ number_format($profit, 2) }}
                                </div>
                                <div class="pt-3 border-t border-gray-200 dark:border-gray-600/50 mt-1">
                                    <div class="flex justify-center items-center">
                                        @if ($profit != 0)
                                            <div class="w-16 h-8">
                                                <svg viewBox="0 0 100 40" class="w-full h-full">
                                                    @if ($profit > 0)
                                                        <path d="M0,30 L20,20 L40,25 L60,15 L80,10 L100,5" stroke="#10B981"
                                                            stroke-width="2.5" fill="none" class="profit-line" />
                                                        <path d="M0,30 L20,20 L40,25 L60,15 L80,10 L100,5 L100,40 L0,40 Z"
                                                            fill="rgba(16, 185, 129, 0.15)" class="profit-fill" />
                                                    @else
                                                        <path d="M0,10 L20,15 L40,20 L60,25 L80,30 L100,35" stroke="#EF4444"
                                                            stroke-width="2.5" fill="none" class="loss-line" />
                                                        <path d="M0,10 L20,15 L40,20 L60,25 L80,30 L100,35 L100,40 L0,40 Z"
                                                            fill="rgba(239, 68, 68, 0.15)" class="loss-fill" />
                                                    @endif
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm {{ $profit > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} ml-2">
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
                                            ? 'text-emerald-600 dark:text-emerald-400'
                                            : ($weekTotalProfit < 0
                                                ? 'text-rose-600 dark:text-rose-400'
                                                : 'text-gray-600 dark:text-gray-400');
                                    $weekBgColor =
                                        $weekTotalProfit > 0
                                            ? 'bg-emerald-100 dark:bg-emerald-900/30'
                                            : ($weekTotalProfit < 0
                                                ? 'bg-rose-100 dark:bg-rose-900/30'
                                                : 'bg-gray-100 dark:bg-gray-700/50');
                                    $weekBorderColor =
                                        $weekTotalProfit > 0
                                            ? 'border-emerald-600 dark:border-emerald-500/40'
                                            : ($weekTotalProfit < 0
                                                ? 'border-rose-600 dark:border-rose-500/40'
                                                : 'border-gray-300 dark:border-gray-600');

                                    $isCurrentWeek =
                                        $currentWeekStart <= \Carbon\Carbon::now('Asia/Jakarta') &&
                                        \Carbon\Carbon::now('Asia/Jakarta') <= $currentWeekStart->copy()->endOfWeek();
                                    if ($isCurrentWeek) {
                                        $weekBorderColor =
                                            'border-indigo-500 dark:border-indigo-400 ring-2 ring-indigo-500/20 dark:ring-indigo-400/20';
                                        $weekBgColor .= ' bg-indigo-50/50 dark:bg-indigo-900/20';
                                    }

                                    $weekStartFormatted = $currentWeekStart->format('M d');
                                    $weekEndFormatted = $currentWeekStart->copy()->endOfWeek()->format('M d');
                                    $weekRange = "{$weekStartFormatted} - {$weekEndFormatted}";
                                @endphp

                                <!-- Weekly Summary Cell -->
                                <div class="p-2 col-span-2 rounded-lg border {{ $weekBorderColor }} {{ $weekBgColor }} cursor-pointer weekly-cell hover:shadow-md hover:scale-[1.01] transition-transform duration-150"
                                    data-week="{{ $weekNumber }}"
                                    data-week-start="{{ $currentWeekStart->format('Y-m-d') }}"
                                    data-week-end="{{ $currentWeekStart->copy()->endOfWeek()->format('Y-m-d') }}"
                                    data-week-profit="{{ $weekTotalProfit }}" data-week-trades="{{ $weekTotalTrades }}">
                                    <div class="flex justify-between items-start mb-1">
                                        <strong class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ __('calendar.week_label', ['week' => $weekNumber]) }}
                                        </strong>
                                        @if ($isCurrentWeek)
                                            <span
                                                class="text-xs bg-indigo-600 dark:bg-indigo-500 text-white px-1.5 py-0.5 rounded">{{ __('calendar.now') }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $weekRange }}</div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.trades') }}:</span>
                                            <span
                                                class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $weekTotalTrades }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.pl') }}:</span>
                                            <span class="text-xs font-bold {{ $weekProfitColor }}">
                                                ${{ number_format($weekTotalProfit, 2) }}
                                            </span>
                                        </div>
                                        @if ($weekTotalTrades > 0)
                                            <div class="pt-1 border-t border-gray-200 dark:border-gray-600/50 mt-1">
                                                <div class="flex justify-center">
                                                    @if ($weekTotalProfit > 0)
                                                        <i
                                                            class="fas fa-arrow-up text-emerald-600 dark:text-emerald-400 text-xs"></i>
                                                        <span
                                                            class="text-xs text-emerald-600 dark:text-emerald-400 ml-1">{{ __('calendar.profit') }}</span>
                                                    @elseif ($weekTotalProfit < 0)
                                                        <i
                                                            class="fas fa-arrow-down text-rose-600 dark:text-rose-400 text-xs"></i>
                                                        <span
                                                            class="text-xs text-rose-600 dark:text-rose-400 ml-1">{{ __('calendar.loss') }}</span>
                                                    @else
                                                        <span
                                                            class="text-xs text-gray-500 dark:text-gray-400">{{ __('calendar.even') }}</span>
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('calendar.profit_loss_trend') }}
                        </h3>
                        <p id="chartPeriodInfo" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Period Selector -->
                        <div
                            class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 border border-gray-200 dark:border-gray-600 gap-1">
                            <button type="button" data-period="weekly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium bg-indigo-600 text-white shadow-sm">
                                {{ __('calendar.weekly') }}
                            </button>
                            <button type="button" data-period="monthly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                {{ __('calendar.monthly') }}
                            </button>
                            <button type="button" data-period="yearly"
                                class="period-btn px-3 py-1.5 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                {{ __('calendar.yearly') }}
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="text-xs text-gray-600 dark:text-gray-400 hidden md:block" id="dataCountInfo">
                                {{ $weekly->count() }}
                                {{ __('calendar.weeks') }}</div>
                            <div class="bg-sky-100 dark:bg-sky-900/30 p-1.5 rounded-lg">
                                <i class="fas fa-chart-line text-sky-600 dark:text-sky-400 text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="relative">
                    <!-- Loading State -->
                    <div id="chartLoading"
                        class="hidden absolute inset-0 bg-white/80 dark:bg-gray-800/80 flex items-center justify-center z-10 rounded-lg backdrop-blur-sm">
                        <div class="flex flex-col items-center">
                            <div
                                class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600 dark:border-indigo-400 mb-2">
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ __('calendar.loading_chart') }}</p>
                        </div>
                    </div>

                    <!-- Chart Canvas -->
                    <div class="h-80">
                        <canvas id="performanceChart"></canvas>
                    </div>

                    <!-- No Data State -->
                    <div id="noDataMessage"
                        class="hidden flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-chart-bar text-3xl mb-3 opacity-50"></i>
                        <p class="text-base font-medium text-gray-700 dark:text-gray-300">
                            {{ __('calendar.no_data_available') }}</p>
                        <p class="text-sm mt-1">{{ __('calendar.start_trading_see_performance') }}</p>
                    </div>
                </div>

                <!-- Chart Legend -->
                <div class="mt-4 flex flex-wrap gap-4 justify-center">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-sky-600 dark:bg-sky-400 rounded-full"></div>
                        <span
                            class="text-sm text-gray-700 dark:text-gray-300">{{ __('calendar.profit_loss_currency') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-emerald-600 dark:bg-emerald-400 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('calendar.profit_legend') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-rose-600 dark:bg-rose-400 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('calendar.loss_legend') }}</span>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ __('calendar.monthly_calendar', ['year' => $year]) }}
                    </h3>
                    <div class="flex items-center gap-2">
                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ $monthly->count() }}
                            {{ __('calendar.months_with_trades') }}</div>
                        <div class="bg-emerald-100 dark:bg-emerald-900/30 p-1.5 rounded-lg">
                            <i class="fas fa-calendar-alt text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        </div>
                    </div>
                </div>

                @if ($monthly->count() > 0)
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2">
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

                                $profitColor = '';
                                $profitBg = '';

                                if ($totalProfit > 0) {
                                    $profitColor = 'text-emerald-600 dark:text-emerald-400';
                                    $profitBg = 'bg-emerald-100 dark:bg-emerald-900/30';
                                } elseif ($totalProfit < 0) {
                                    $profitColor = 'text-rose-600 dark:text-rose-400';
                                    $profitBg = 'bg-rose-100 dark:bg-rose-900/30';
                                } else {
                                    $profitColor = 'text-gray-600 dark:text-gray-400';
                                    $profitBg = 'bg-gray-100 dark:bg-gray-700/50';
                                }

                                $isCurrentMonth = $m->month == $currentMonth && $m->year == $currentYear;
                                $borderClass = $isCurrentMonth
                                    ? 'ring-2 ring-indigo-500 dark:ring-indigo-400 ring-offset-2 dark:ring-offset-gray-800'
                                    : 'border border-gray-200 dark:border-gray-700';
                            @endphp

                            <div
                                class="{{ $profitBg }} {{ $borderClass }} rounded-lg p-3 hover:shadow-md transition-transform duration-150 cursor-pointer monthly-summary">
                                <!-- Month Header -->
                                <div class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">
                                            {{ $monthName }}</h4>
                                        @if ($isCurrentMonth)
                                            <span
                                                class="text-xs bg-indigo-600 dark:bg-indigo-500 text-white px-1.5 py-0.5 rounded">{{ __('calendar.now') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="space-y-2">
                                    <!-- Trades -->
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.trades') }}</span>
                                        <span class="font-semibold text-gray-900 dark:text-white text-base">
                                            {{ $totalTrades }}
                                        </span>
                                    </div>

                                    <!-- P/L -->
                                    <div
                                        class="flex justify-between items-center pt-1 border-t border-gray-200 dark:border-gray-600">
                                        <span
                                            class="text-xs text-gray-600 dark:text-gray-400">{{ __('calendar.pl') }}</span>
                                        <div class="font-bold {{ $profitColor }} text-base flex items-center gap-1">
                                            ${{ number_format($totalProfit, 0) }}
                                            @if ($totalProfit != 0)
                                                @if ($totalProfit > 0)
                                                    <i
                                                        class="fas fa-arrow-up text-emerald-600 dark:text-emerald-400 text-xs"></i>
                                                @else
                                                    <i
                                                        class="fas fa-arrow-down text-rose-600 dark:text-rose-400 text-xs"></i>
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
                        <div class="text-gray-400 dark:text-gray-500 mb-2">
                            <i class="fas fa-calendar-times text-3xl"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('calendar.no_trades_recorded') }}
                            {{ $year }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Trade Details Modal -->
    <div id="tradeModal"
        class="hidden fixed inset-0 bg-black/50 dark:bg-black/80 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl w-full max-w-md mx-auto"
            id="modalContentContainer">
            <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                <h4 id="modalTitle" class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ __('calendar.trade_details') }}</h4>
                <button id="closeModal"
                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
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

                    // Set modal title
                    modalTitle.textContent = formatDate(date, {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

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
                        <div class="mb-4 p-3 rounded-lg ${profit > 0 ? 'bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-600/30 dark:border-emerald-500/30' : 'bg-rose-100 dark:bg-rose-900/30 border border-rose-600/30 dark:border-rose-500/30'}">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-medium text-gray-700 dark:text-gray-300">${translations.total_pl}:</p>
                                <span class="${profit > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'} font-bold text-lg">$${profit.toFixed(2)}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div class="text-center p-1 bg-gray-100 dark:bg-gray-700 rounded">
                                    <span class="text-gray-600 dark:text-gray-400 block text-xs">${translations.total}</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">${trades.length}</span>
                                </div>
                                <div class="text-center p-1 bg-emerald-100 dark:bg-emerald-900/30 rounded">
                                    <span class="text-emerald-600 dark:text-emerald-400 block text-xs">${translations.winning}</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-300">${winningTrades}</span>
                                </div>
                                <div class="text-center p-1 bg-rose-100 dark:bg-rose-900/30 rounded">
                                    <span class="text-rose-600 dark:text-rose-400 block text-xs">${translations.losing}</span>
                                    <span class="font-semibold text-rose-700 dark:text-rose-300">${losingTrades}</span>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 text-gray-600 dark:text-gray-400 font-medium">${translations.symbol}</th>
                                        <th class="text-left py-2 text-gray-600 dark:text-gray-400 font-medium">${translations.type}</th>
                                        <th class="text-right py-2 text-gray-600 dark:text-gray-400 font-medium">P/L ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        trades.forEach(trade => {
                            content += `
                            <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-2 text-gray-900 dark:text-gray-300">${trade.symbol_name}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium ${trade.type === 'buy' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400'}">
                                        ${trade.type.toUpperCase()}
                                    </span>
                                </td>
                                <td class="py-2 text-right font-medium ${trade.profit_loss > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'}">
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
                        <div class="flex flex-col items-center justify-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-chart-bar text-4xl mb-3 opacity-50"></i>
                            <p class="text-base font-medium text-gray-700 dark:text-gray-300">${translations.no_trades_day}</p>
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
                        `Week ${weekNumber} (${formattedStart} - ${formattedEnd})`;

                    // Create modal content for weekly summary
                    let profitClass = weekProfit > 0 ? 'text-emerald-600 dark:text-emerald-400' : (
                        weekProfit < 0 ? 'text-rose-600 dark:text-rose-400' :
                        'text-gray-600 dark:text-gray-400');
                    let bgClass = weekProfit > 0 ? 'bg-emerald-100 dark:bg-emerald-900/30' : (
                        weekProfit < 0 ? 'bg-rose-100 dark:bg-rose-900/30' :
                        'bg-gray-100 dark:bg-gray-700');

                    let content = `
                        <div class="mb-4 p-4 rounded-lg border ${bgClass}">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">${translations.total_weekly}</div>
                                    <div class="text-3xl font-bold text-gray-900 dark:text-white">${weekTrades}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">${translations.total_pl}</div>
                                    <div class="text-3xl font-bold ${profitClass}">
                                        $${weekProfit.toFixed(2)}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">${translations.week_range}</div>
                                <div class="text-gray-900 dark:text-white">
                                    ${formatDate(weekStart, {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })} 
                                    ${translations.to} 
                                    ${formatDate(weekEnd, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                                </div>
                            </div>
                        </div>
                        <div class="text-center py-3">
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

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#e5e7eb' : '#374151';
                const gridColor = isDark ? 'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)';

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
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointBackgroundColor: function(context) {
                                const value = context.dataset.data[context.dataIndex];
                                return value >= 0 ? '#10b981' : '#ef4444';
                            },
                            pointBorderColor: isDark ? '#1f2937' : '#ffffff',
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
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: isDark ? '#e5e7eb' : '#111827',
                                bodyColor: isDark ? '#e5e7eb' : '#111827',
                                borderColor: isDark ? '#374151' : '#e5e7eb',
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
                                    color: gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: textColor,
                                    maxRotation: 45
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: {
                                    color: gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: textColor,
                                    callback: function(value) {
                                        return '$' + value.toFixed(0);
                                    }
                                },
                                title: {
                                    display: true,
                                    text: translations.profit_loss_currency,
                                    color: textColor
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
                        label: `W${week.week}`,
                        profit: parseFloat(week.total_profit || 0),
                        trades: week.total_trades || 0,
                        weekNumber: week.week,
                        month: week.month,
                        year: week.year,
                        weekRange: `Week ${week.week} (${weekStartDate.getDate()}/${week.month})`
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
                            `${translations.weekly} - ${new Date(backendData.currentYear, backendData.currentMonth - 1).toLocaleString(getDateLocale(), { month: 'long' })} ${backendData.currentYear}`;
                        periodType = translations.weeks;
                        break;
                    case 'monthly':
                        data = getMonthlyData();
                        periodInfo =
                            `${translations.monthly} - ${new Date(backendData.currentYear, backendData.currentMonth - 1).toLocaleString(getDateLocale(), { month: 'long' })} ${backendData.currentYear}`;
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
                        btn.classList.remove('bg-indigo-600', 'text-white');
                        btn.classList.add('text-gray-700', 'dark:text-gray-300');
                    });

                    this.classList.remove('text-gray-700', 'dark:text-gray-300');
                    this.classList.add('bg-indigo-600', 'text-white');

                    // Update chart data
                    currentPeriod = period;
                    loadChartData(period);
                });
            });

            // Initialize the chart
            initChart();

            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        // Update chart colors when theme changes
                        if (performanceChart) {
                            const isDark = document.documentElement.classList.contains('dark');
                            const textColor = isDark ? '#e5e7eb' : '#374151';
                            const gridColor = isDark ? 'rgba(75, 85, 99, 0.3)' :
                                'rgba(209, 213, 219, 0.5)';

                            performanceChart.options.scales.x.ticks.color = textColor;
                            performanceChart.options.scales.y.ticks.color = textColor;
                            performanceChart.options.scales.y.title.color = textColor;
                            performanceChart.options.scales.x.grid.color = gridColor;
                            performanceChart.options.scales.y.grid.color = gridColor;
                            performanceChart.options.plugins.tooltip.backgroundColor = isDark ?
                                '#1f2937' : '#ffffff';
                            performanceChart.options.plugins.tooltip.titleColor = isDark ?
                                '#e5e7eb' : '#111827';
                            performanceChart.options.plugins.tooltip.bodyColor = isDark ?
                                '#e5e7eb' : '#111827';

                            performanceChart.update();
                        }
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true
            });

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
            min-width: 70px;
        }

        .period-btn:hover {
            transform: translateY(-1px);
        }

        #performanceChart {
            width: 100% !important;
            height: 320px !important;
        }

        /* Simple scrollbar for modal */
        #modalContent::-webkit-scrollbar {
            width: 5px;
        }

        #modalContent::-webkit-scrollbar-track {
            background: transparent;
        }

        #modalContent::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 4px;
        }

        #modalContent::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.7);
        }

        .dark #modalContent::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.5);
        }

        .dark #modalContent::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.7);
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
