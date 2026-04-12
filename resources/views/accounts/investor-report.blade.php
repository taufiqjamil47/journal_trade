@extends('Layouts.index')
@section('title', __('investor-report.title', ['name' => $account->name]))
@section('content')
    <div id="reportContent" class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('accounts.show', $account) }}"
                        class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('investor-report.back_to_account') }}
                    </a>
                </div>
                <div class="flex gap-3">
                    <button onclick="window.print()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-print mr-2"></i>{{ __('investor-report.print_report') }}
                    </button>
                    {{-- <button onclick="exportToPDF()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-download mr-2"></i>{{ __('investor-report.export_pdf') }}
                    </button> --}}
                </div>
            </div>
            <h1 class="text-3xl font-bold text-primary-600 dark:text-primary-400 mt-4">
                📊 {{ __('investor-report.investor_performance_report') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('investor-report.account_label') }}: {{ $account->name }} |
                {{ __('investor-report.generated_label') }}: {{ now()->format('M d, Y H:i') }}
            </p>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('investor-report.total_investment') }}</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            {{ number_format($totalInvestment, 2) }} {{ $currency }}
                        </p>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-full">
                        <i class="fas fa-wallet text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('investor-report.total_profit') }}</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                            {{ number_format($totalProfit, 2) }} {{ $currency }}
                        </p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-full">
                        <i class="fas fa-chart-line text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('investor-report.roi') }}</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                            {{ number_format($roi, 2) }}%
                        </p>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-full">
                        <i class="fas fa-percentage text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('investor-report.win_rate') }}</p>
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                            {{ number_format($winRate, 1) }}%
                        </p>
                    </div>
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-full">
                        <i class="fas fa-trophy text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Investment Distribution Pie Chart -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('investor-report.investment_distribution') }}</h3>
                <div class="h-80">
                    <canvas id="investmentChart"></canvas>
                </div>
            </div>

            <!-- Growth Chart -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('investor-report.monthly_performance') }}</h3>
                <div class="h-80">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Investor Details Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('investor-report.investor_performance_details') }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-900/40">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.investor') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.initial_investment') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.ownership_percentage') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.profit_share') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.total_value') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.growth_percentage') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.join_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investorData as $investor)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $investor['name'] }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ number_format($investor['investment'], 2) }} {{ $currency }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $investor['percentage'] }}%
                                </td>
                                <td class="px-4 py-3 text-sm text-green-600 dark:text-green-400">
                                    {{ number_format($investor['profit_share'], 2) }} {{ $currency }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold">
                                    {{ number_format($investor['total_value'], 2) }} {{ $currency }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $investor['growth_percentage'] >= 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                        {{ $investor['growth_percentage'] >= 0 ? '+' : '' }}{{ $investor['growth_percentage'] }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $investor['join_date'] ? \Carbon\Carbon::parse($investor['join_date'])->format('M d, Y') : __('investor-report.na') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Trading Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('investor-report.trading_statistics') }}</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.total_trades') }}</span>
                        <span class="font-semibold">{{ $totalTrades }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.best_trade') }}</span>
                        <span class="font-semibold text-green-600">{{ number_format($bestTrade, 2) }}
                            {{ $currency }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.worst_trade') }}</span>
                        <span class="font-semibold text-red-600">{{ number_format($worstTrade, 2) }}
                            {{ $currency }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.average_trade') }}</span>
                        <span class="font-semibold">{{ number_format($avgTrade, 2) }} {{ $currency }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('investor-report.performance_metrics') }}</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.sharpe_ratio') }}</span>
                        <span
                            class="font-semibold">{{ $totalTrades > 0 ? number_format($avgTrade / max(abs($worstTrade), 0.01), 2) : __('investor-report.na') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.profit_factor') }}</span>
                        <span
                            class="font-semibold">{{ $totalTrades > 0 ? number_format(abs($totalProfit) / max(abs($worstTrade * $totalTrades * 0.1), 0.01), 2) : __('investor-report.na') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.max_drawdown') }}</span>
                        <span
                            class="font-semibold text-red-600">{{ $totalTrades > 0 ? number_format(($worstTrade / $account->initial_balance) * 100, 2) : 0 }}%</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('investor-report.risk_metrics') }}</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.risk_reward_ratio') }}</span>
                        <span
                            class="font-semibold">{{ $totalTrades > 0 ? number_format(abs($bestTrade) / max(abs($worstTrade), 0.01), 2) : __('investor-report.na') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.recovery_factor') }}</span>
                        <span
                            class="font-semibold">{{ $totalTrades > 0 ? number_format($totalProfit / max(abs($worstTrade), 0.01), 2) : __('investor-report.na') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.expectancy') }}</span>
                        <span
                            class="font-semibold">{{ $totalTrades > 0 ? number_format($avgTrade, 2) : __('investor-report.na') }}
                            {{ $currency }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 dark:text-gray-400 text-sm">
            <p>{{ __('investor-report.report_footer', ['date' => now()->format('M d, Y H:i:s')]) }}</p>
            <p class="mt-1">{{ __('investor-report.confidential_notice') }}</p>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNa5Ak4PsC7Kd9yg/m8LjSEjW4iXlqDT1tU4M45pzkqnH1j+2xk7yql5qDHF6l6AVrtcq/kfC6pTgqSTTMO2XA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
        integrity="sha512-WFwgkL4xJvq3i4uQMl0LS24nHhZSj/PvriJCiOK4FJfsg7uT0N/PYJxpp9g15rLw8RK61m2dRIM4ok82SuzzVg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Investment Distribution Pie Chart
        const investmentCtx = document.getElementById('investmentChart').getContext('2d');
        const investmentData = @json($investorData);

        new Chart(investmentCtx, {
            type: 'pie',
            data: {
                labels: investmentData.map(item => item.name),
                datasets: [{
                    data: investmentData.map(item => item.investment),
                    backgroundColor: [
                        '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
                        '#06B6D4', '#84CC16', '#F97316', '#EC4899', '#6B7280'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': ' + value.toLocaleString() +
                                    ' {{ $currency }} (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Growth Chart (Line Chart)
        const growthCtx = document.getElementById('growthChart').getContext('2d');
        const monthlyData = @json($indexedMonthlyData);

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: '{{ __('investor-report.monthly_profit') }}',
                    data: monthlyData.map(item => item.profit),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: '{{ __('investor-report.cumulative_profit') }}',
                    data: monthlyData.map(item => item.cumulative_profit),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' {{ $currency }}';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toLocaleString() +
                                    ' {{ $currency }}';
                            }
                        }
                    }
                }
            }
        });

        // Export to PDF function
        async function exportToPDF() {
            const reportEl = document.getElementById('reportContent');
            const originalScrollY = window.scrollY;
            const {
                jsPDF
            } = window.jspdf;
            const accountSlug = '{{ \Illuminate\Support\Str::slug($account->name, '_') }}';
            const saveName = `Investor_Report_${accountSlug}_${new Date().toISOString().slice(0, 10)}.pdf`;

            const canvas = await html2canvas(reportEl, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
            let heightLeft = pdfHeight;
            let position = 0;

            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();

            while (heightLeft > 0) {
                position = heightLeft - pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                heightLeft -= pdf.internal.pageSize.getHeight();
            }

            pdf.save(saveName);
            window.scrollTo(0, originalScrollY);
        }
    </script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12px;
            }

            .container {
                max-width: none !important;
            }
        }
    </style>
@endsection
