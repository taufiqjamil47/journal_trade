@extends('Layouts.index')
@section('title', __('analysis.title'))

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('analysis.title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('analysis.subtitle') }}</p>
                </div>

                <!-- Navigation -->
                <div class="flex flex-wrap gap-3">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2"></i>
                    </button>

                    <!-- Navigation Items (hidden by default) -->
                    <div id="navItems" class="hidden">
                        @include('analysis.partials.navigation')
                    </div>

                    <!-- Trader Item -->
                    <div class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Summary Alert -->
        @if ($summary)
            @include('analysis.partials.summary-alert')
        @endif

        <!-- Basic Stats Overview -->
        @include('analysis.partials.basic-stats')

        <!-- Expectancy Card -->
        @include('analysis.partials.expectancy-card')

        <!-- Filters -->
        @include('analysis.partials.filters')

        <!-- Risk Management Metrics -->
        @include('analysis.partials.risk-management')

        <!-- Time-Based Analysis -->
        @include('analysis.partials.time-analysis')

        <!-- Two Column Charts -->
        @include('analysis.partials.pair-analysis')

        <!-- Session-Time Heatmap Modal -->
        @include('analysis.partials.session-modal')
    </div>
@endsection

@section('scripts')
    <script>
        // Expose data to JavaScript
        window.analysisData = {!! json_encode([
            'hourlyPerformance' => $hourlyPerformance->sortKeys()->toArray(),
            'pairData' => $pairData->toArray(),
            'entryTypeData' => $entryTypeData->toArray(),
            'dayOfWeekPerformance' => $dayOfWeekPerformance->sortBy('day_number')->values()->toArray(),
            'monthlyPerformance' => $monthlyPerformance->sortDesc()->values()->toArray(),
            'heatmapData' => $heatmapData,
        ]) !!};

        // Pass translations to JavaScript
        window.translations = {
            analysis: {
                // Stats
                stats: {
                    trades: "{{ __('analysis.stats.trades') }}",
                    winrate: "{{ __('analysis.stats.winrate') }}",
                    winrate_short: "{{ __('analysis.stats.winrate_short') }}",
                    toggle_balance: "{{ __('analysis.stats.toggle_balance') }}",
                    show_balance: "{{ __('analysis.stats.show_balance') }}",
                    hide_balance: "{{ __('analysis.stats.hide_balance') }}"
                },

                // Time Analysis
                time_analysis: {
                    day_label: "{{ __('analysis.time_analysis.day_label') }}",
                    profitable: "{{ __('analysis.time_analysis.profitable') }}",
                    unprofitable: "{{ __('analysis.time_analysis.unprofitable') }}",
                    no_trades: "{{ __('analysis.time_analysis.no_trades') }}"
                },

                // Modal
                modal: {
                    session_details: "{{ __('analysis.modal.session_details') }}",
                    total_performance: "{{ __('analysis.modal.total_performance') }}",
                    total_trades: "{{ __('analysis.modal.total_trades') }}",
                    time_slot: "{{ __('analysis.modal.time_slot') }}",
                    performance_insights: "{{ __('analysis.modal.performance_insights') }}",
                    avg_pl_per_trade: "{{ __('analysis.modal.avg_pl_per_trade') }}",
                    win_loss_ratio: "{{ __('analysis.modal.win_loss_ratio') }}",
                    recommendations: "{{ __('analysis.modal.recommendations') }}",
                    positive_recommendation: "{{ __('analysis.modal.positive_recommendation') }}",
                    negative_recommendation: "{{ __('analysis.modal.negative_recommendation') }}",
                    based_on: "{{ __('analysis.modal.based_on') }}",
                    at_this_time: "{{ __('analysis.modal.at_this_time') }}",
                    click_other_slots: "{{ __('analysis.modal.click_other_slots') }}",
                    profitable: "{{ __('analysis.modal.profitable') }}",
                    unprofitable: "{{ __('analysis.modal.unprofitable') }}"
                },

                // Risk Management
                risk_management: {
                    show_details: "{{ __('analysis.risk_management.show_details') }}",
                    hide_details: "{{ __('analysis.risk_management.hide_details') }}"
                },

                // Charts
                charts: {
                    profit: "{{ __('analysis.charts.profit') }}",
                    profit_loss: "{{ __('analysis.charts.profit_loss') }}",
                    monthly_profit: "{{ __('analysis.charts.monthly_profit') }}"
                },

                // Days (untuk heatmap modal)
                days: {
                    Mon: "{{ __('analysis.days.Mon') }}",
                    Tue: "{{ __('analysis.days.Tue') }}",
                    Wed: "{{ __('analysis.days.Wed') }}",
                    Thu: "{{ __('analysis.days.Thu') }}",
                    Fri: "{{ __('analysis.days.Fri') }}",
                    Sat: "{{ __('analysis.days.Sat') }}",
                    Sun: "{{ __('analysis.days.Sun') }}"
                },

                // Loading
                loading: {
                    chart_error: "{{ __('analysis.loading.chart_error') }}"
                }
            }
        };
    </script>

    <script src="{{ asset('js/analysis/chart-loader.js') }}"></script>
    <script src="{{ asset('js/analysis/main.js') }}"></script>
    <script src="{{ asset('js/analysis/session-modal.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/analysis/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/analysis/charts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/analysis/heatmap.css') }}">
@endsection
