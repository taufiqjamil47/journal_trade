@extends('Layouts.index')
@section('title', __('investor-report.title', ['name' => $account->name]))
@section('content')
    <div id="reportContent" class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header -->
        <div class="mb-6 no-print">
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

        <!-- Executive Summary -->
        <div
            class="executive-summary mb-8 p-6 rounded-xl border {{ match ($performanceSentiment) {
                'positive' => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800',
                'negative' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800',
                'caution' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800',
                default => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800',
            } }}">
            <div class="flex items-start gap-4">
                <div class="text-4xl">{{ $summaryText['trend_icon'] }}</div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        📋 {{ __('investor-report.performance_summary') }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        {{ $summaryText['main_text'] }}
                    </p>
                    <div
                        class="inline-block px-3 py-2 rounded-lg text-sm font-medium {{ match ($performanceSentiment) {
                            'positive' => 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300',
                            'negative' => 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300',
                            'caution' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300',
                            default => 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300',
                        } }}">
                        💡 {{ $summaryText['guidance'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('investor-report.total_investment') }}
                        </p>
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
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
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
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
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
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ number_format($winRate, 1) }}%
                        </p>
                    </div>
                    <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-full">
                        <i class="fas fa-trophy text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section - Hanya untuk layar -->
        <div class="charts-screen-only no-print">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Investment Distribution Pie Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('investor-report.investment_distribution') }}
                    </h3>
                    <div class="h-80">
                        <canvas id="investmentChart"></canvas>
                    </div>
                </div>

                <!-- Growth Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('investor-report.monthly_performance') }}
                    </h3>
                    <div class="h-80">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        💰 {{ __('investor-report.profit_distribution') }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('investor-report.profit_share_per_investor') }}
                    </p>
                    <div class="h-80">
                        <canvas id="profitDistributionChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        📈 {{ __('investor-report.growth_comparison') }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('investor-report.growth_percentage_by_investor') }}
                    </p>
                    <div class="h-80">
                        <canvas id="growthComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL ALTERNATIF UNTUK CETAK (HITAM PUTIH) -->
        <div class="print-only-data" style="display: none;">
            <!-- Investment Distribution Table untuk cetak -->
            <div class="print-investment-table mb-8">
                <h3 class="text-lg font-bold mb-3 dark:text-white">📊 Distribusi Investasi</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Investor</th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Investasi</th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investorData as $inv)
                            <tr class="dark:text-gray-300">
                                <td class="border border-black dark:border-gray-600 px-3 py-2">{{ $inv['name'] }}</td>
                                <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                    {{ number_format($inv['investment'], 2) }} {{ $currency }}</td>
                                <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                    {{ $inv['percentage'] }}%</td>
                            </tr>
                        @endforeach
                        <tr class="font-bold dark:text-white">
                            <td class="border border-black dark:border-gray-600 px-3 py-2">TOTAL</td>
                            <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                {{ number_format($totalInvestment, 2) }} {{ $currency }}</td>
                            <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Monthly Performance Table untuk cetak -->
            <div class="print-monthly-table mb-8">
                <h3 class="text-lg font-bold mb-3 dark:text-white">📈 Performa Bulanan</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">Bulan
                            </th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">Profit
                                Bulanan</th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Kumulatif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($indexedMonthlyData as $month)
                            <tr class="dark:text-gray-300">
                                <td class="border border-black dark:border-gray-600 px-3 py-2">{{ $month['month'] }}</td>
                                <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                    {{ number_format($month['profit'], 2) }} {{ $currency }}</td>
                                <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                    {{ number_format($month['cumulative_profit'], 2) }} {{ $currency }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Profit Distribution Table untuk cetak -->
            <div class="print-profit-table mb-8">
                <h3 class="text-lg font-bold mb-3 dark:text-white">💰 Distribusi Profit</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Investor</th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">Alokasi
                                Profit</th>
                            <th class="border border-black dark:border-gray-600 px-3 py-2 text-left dark:text-white">
                                Pertumbuhan (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profitDistributionData as $profit)
                            <tr class="dark:text-gray-300">
                                <td class="border border-black dark:border-gray-600 px-3 py-2">{{ $profit['name'] }}</td>
                                <td class="border border-black dark:border-gray-600 px-3 py-2 text-right">
                                    {{ number_format($profit['profit_share'], 2) }} {{ $currency }}</td>
                                <td
                                    class="border border-black dark:border-gray-600 px-3 py-2 text-right {{ $profit['growth_percentage'] >= 0 ? 'text-positive' : 'text-negative' }}">
                                    {{ $profit['growth_percentage'] >= 0 ? '+' : '' }}{{ number_format($profit['growth_percentage'], 2) }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Investor Details Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('investor-report.investor_performance_details') }}
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.investor') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                {{ __('investor-report.performance_status') }}</th>
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
                            <tr
                                class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $investor['name'] }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @php
                                        $badgeConfig = [
                                            'excellent' => [
                                                'icon' => '⭐',
                                                'bg' => 'bg-green-100 dark:bg-green-900/30',
                                                'text' => 'text-green-800 dark:text-green-300',
                                                'label' => 'Excellent',
                                            ],
                                            'good' => [
                                                'icon' => '👍',
                                                'bg' => 'bg-blue-100 dark:bg-blue-900/30',
                                                'text' => 'text-blue-800 dark:text-blue-300',
                                                'label' => 'Good',
                                            ],
                                            'fair' => [
                                                'icon' => '➡️',
                                                'bg' => 'bg-cyan-100 dark:bg-cyan-900/30',
                                                'text' => 'text-cyan-800 dark:text-cyan-300',
                                                'label' => 'Fair',
                                            ],
                                            'caution' => [
                                                'icon' => '⚠️',
                                                'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                                'text' => 'text-yellow-800 dark:text-yellow-300',
                                                'label' => 'Caution',
                                            ],
                                            'concerning' => [
                                                'icon' => '⛔',
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-800 dark:text-red-300',
                                                'label' => 'Concerning',
                                            ],
                                        ];
                                        $badge = $badgeConfig[$investor['performance_badge']] ?? $badgeConfig['fair'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['bg'] }} {{ $badge['text'] }}">
                                        {{ $badge['icon'] }} {{ $badge['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($investor['investment'], 2) }} {{ $currency }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $investor['percentage'] }}%</td>
                                <td class="px-4 py-3 text-sm text-green-600 dark:text-green-400">
                                    {{ number_format($investor['profit_share'], 2) }} {{ $currency }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ number_format($investor['total_value'], 2) }} {{ $currency }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $investor['growth_percentage'] >= 0 ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
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
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.total_trades') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades }}</span></div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.best_trade') }}</span><span
                            class="font-semibold text-green-600 dark:text-green-400">{{ number_format($bestTrade, 2) }}
                            {{ $currency }}</span></div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.worst_trade') }}</span><span
                            class="font-semibold text-red-600 dark:text-red-400">{{ number_format($worstTrade, 2) }}
                            {{ $currency }}</span></div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.average_trade') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ number_format($avgTrade, 2) }}
                            {{ $currency }}</span></div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('investor-report.performance_metrics') }}</h4>
                <div class="space-y-3">
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.sharpe_ratio') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades > 0 ? number_format($avgTrade / max(abs($worstTrade), 0.01), 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.profit_factor') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades > 0 ? number_format(abs($totalProfit) / max(abs($worstTrade * $totalTrades * 0.1), 0.01), 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.max_drawdown') }}</span><span
                            class="font-semibold text-red-600 dark:text-red-400">{{ $totalTrades > 0 ? number_format(($worstTrade / $account->initial_balance) * 100, 2) : 0 }}%</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('investor-report.risk_metrics') }}</h4>
                <div class="space-y-3">
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.risk_reward_ratio') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades > 0 ? number_format(abs($bestTrade) / max(abs($worstTrade), 0.01), 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.recovery_factor') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades > 0 ? number_format($totalProfit / max(abs($worstTrade), 0.01), 2) : '-' }}</span>
                    </div>
                    <div class="flex justify-between"><span
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('investor-report.expectancy') }}</span><span
                            class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTrades > 0 ? number_format($avgTrade, 2) : '-' }}
                            {{ $currency }}</span></div>
                </div>
            </div>
        </div>

        <!-- Keterangan/rumus Pembagian keuntungan -->
        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mt-4 mb-8">
            <h5 class="font-medium text-gray-900 dark:text-gray-300 mb-2">
                <b>{{ __('investor-report.profit_distribution_explanation') }}</b>
            </h5>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('investor-report.profit_distribution_description') }}
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('investor-report.profit_distribution_description_rumus') }}
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                {{ __('investor-report.profit_distribution_description_example') }}
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 dark:text-gray-400 text-sm">
            <p>{{ __('investor-report.report_footer', ['date' => now()->format('M d, Y H:i:s')]) }}</p>
            <p class="mt-1">{{ __('investor-report.confidential_notice') }}</p>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Persiapan data dari PHP array ke JavaScript
            const investorDataArray = @json($investorData);
            const monthlyDataArray = @json($indexedMonthlyData);
            const profitDistributionArray = @json($profitDistributionData);

            // Extract data untuk chart
            const investorNames = investorDataArray.map(item => item.name);
            const investmentValues = investorDataArray.map(item => item.investment);
            const monthlyLabels = monthlyDataArray.map(item => item.month);
            const monthlyProfits = monthlyDataArray.map(item => item.profit);
            const monthlyCumulative = monthlyDataArray.map(item => item.cumulative_profit);
            const profitNames = profitDistributionArray.map(item => item.name);
            const profitShares = profitDistributionArray.map(item => item.profit_share);
            const growthPercentages = profitDistributionArray.map(item => item.growth_percentage);

            // Array untuk menyimpan semua chart instance
            window.charts = [];

            // Helper function untuk mendapatkan warna berdasarkan theme
            function getThemeColors() {
                const isDark = document.documentElement.classList.contains('dark');
                return {
                    textColor: isDark ? '#e5e7eb' : '#1f2937',
                    gridColor: isDark ? '#374151' : '#e5e7eb'
                };
            }

            // 1. Investment Distribution Pie Chart
            const investmentCtx = document.getElementById('investmentChart');
            if (investmentCtx) {
                window.charts.push(new Chart(investmentCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: investorNames,
                        datasets: [{
                            data: investmentValues,
                            backgroundColor: ['#3B82F6', '#EF4444', '#10B981', '#F59E0B',
                                '#8B5CF6', '#06B6D4', '#84CC16', '#F97316', '#EC4899',
                                '#6B7280'
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
                                    usePointStyle: true,
                                    color: getThemeColors().textColor
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b,
                                            0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return context.label + ': ' + value.toLocaleString() +
                                            ' {{ $currency }} (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                }));
            }

            // 2. Growth Chart (Line Chart)
            const growthCtx = document.getElementById('growthChart');
            if (growthCtx) {
                window.charts.push(new Chart(growthCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: '{{ __('investor-report.monthly_profit') }}',
                            data: monthlyProfits,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: '{{ __('investor-report.cumulative_profit') }}',
                            data: monthlyCumulative,
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
                                    },
                                    color: getThemeColors().textColor
                                },
                                grid: {
                                    color: getThemeColors().gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: getThemeColors().textColor
                                },
                                grid: {
                                    color: getThemeColors().gridColor
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: getThemeColors().textColor
                                }
                            }
                        }
                    }
                }));
            }

            // 3. Profit Distribution Bar Chart
            const profitCtx = document.getElementById('profitDistributionChart');
            if (profitCtx) {
                window.charts.push(new Chart(profitCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: profitNames,
                        datasets: [{
                            label: '{{ __('investor-report.profit_share') }}',
                            data: profitShares,
                            backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444',
                                '#8B5CF6', '#06B6D4', '#84CC16', '#F97316', '#EC4899',
                                '#6B7280'
                            ],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString() + ' {{ $currency }}';
                                    },
                                    color: getThemeColors().textColor
                                },
                                grid: {
                                    color: getThemeColors().gridColor
                                }
                            },
                            y: {
                                ticks: {
                                    color: getThemeColors().textColor
                                },
                                grid: {
                                    color: getThemeColors().gridColor
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: getThemeColors().textColor
                                }
                            }
                        }
                    }
                }));
            }

            // 4. Growth Comparison Radar Chart
            const growthCompCtx = document.getElementById('growthComparisonChart');
            if (growthCompCtx) {
                window.charts.push(new Chart(growthCompCtx.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: profitNames,
                        datasets: [{
                            label: '{{ __('investor-report.growth_percentage') }}',
                            data: growthPercentages,
                            borderColor: '#6366F1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 2,
                            pointBackgroundColor: '#6366F1',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    },
                                    color: getThemeColors().textColor
                                },
                                grid: {
                                    color: getThemeColors().gridColor
                                },
                                pointLabels: {
                                    color: getThemeColors().textColor
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: getThemeColors().textColor
                                }
                            }
                        }
                    }
                }));
            }

            // ========== FUNGSI UNTUK UPDATE WARNA CHART SAAT THEME BERUBAH ==========
            function updateAllChartColors() {
                const colors = getThemeColors();

                window.charts.forEach(chart => {
                    if (!chart) return;

                    // Update legend labels color
                    if (chart.options.plugins?.legend?.labels) {
                        chart.options.plugins.legend.labels.color = colors.textColor;
                    }

                    // Update scales colors
                    if (chart.options.scales) {
                        if (chart.options.scales.y) {
                            if (chart.options.scales.y.ticks) chart.options.scales.y.ticks.color = colors
                                .textColor;
                            if (chart.options.scales.y.grid) chart.options.scales.y.grid.color = colors
                                .gridColor;
                        }
                        if (chart.options.scales.x) {
                            if (chart.options.scales.x.ticks) chart.options.scales.x.ticks.color = colors
                                .textColor;
                            if (chart.options.scales.x.grid) chart.options.scales.x.grid.color = colors
                                .gridColor;
                        }
                        if (chart.options.scales.r) {
                            if (chart.options.scales.r.ticks) chart.options.scales.r.ticks.color = colors
                                .textColor;
                            if (chart.options.scales.r.grid) chart.options.scales.r.grid.color = colors
                                .gridColor;
                            if (chart.options.scales.r.pointLabels) chart.options.scales.r.pointLabels
                                .color = colors.textColor;
                        }
                    }

                    chart.update();
                });
            }

            // Observasi perubahan class dark pada html element
            const themeObserver = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        updateAllChartColors();
                    }
                });
            });

            themeObserver.observe(document.documentElement, {
                attributes: true
            });
        });
    </script>

    <style>
        /* ========== STYLE UNTUK CETAK (OPTIMAL) ========== */
        @media print {

            /* Sembunyikan elemen interaktif dan chart */
            .no-print,
            .charts-screen-only,
            button,
            .fa-print,
            .fa-arrow-left {
                display: none !important;
            }

            /* Tampilkan tabel alternatif untuk cetak */
            .print-only-data {
                display: block !important;
            }

            /* Reset dasar untuk cetak */
            body {
                font-size: 11pt;
                color: #000 !important;
                background: #fff !important;
                line-height: 1.4;
            }

            .container {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Page setup */
            @page {
                size: A4;
                margin: 15mm;
            }

            /* Header styling */
            h1 {
                font-size: 16pt;
                border-bottom: 2px solid #000;
                padding-bottom: 5px;
                margin: 10px 0;
            }

            h3 {
                font-size: 12pt;
                margin: 8px 0 4px 0;
            }

            /* Executive summary untuk cetak */
            .executive-summary {
                border-left: 4px solid #000 !important;
                border-right: 1px solid #ccc !important;
                border-top: 1px solid #ccc !important;
                border-bottom: 1px solid #ccc !important;
                background: #f9f9f9 !important;
                padding: 10px !important;
                margin-bottom: 15px !important;
            }

            /* Cards styling */
            .bg-white,
            .rounded-xl,
            .shadow-sm {
                border: 1px solid #ccc !important;
                background: #fff !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 8px !important;
            }

            /* Grid spacing */
            .grid {
                gap: 8px !important;
            }

            .grid>div {
                page-break-inside: avoid;
            }

            /* Table styling */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin: 10px 0 !important;
                font-size: 9pt;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px 4px !important;
                text-align: left !important;
            }

            th {
                background: #e0e0e0 !important;
                font-weight: bold;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            /* Badge styling untuk cetak */
            .inline-flex {
                display: inline-block !important;
                border: 1px solid #000 !important;
                padding: 2px 6px !important;
                background: #f0f0f0 !important;
                color: #000 !important;
                font-weight: normal !important;
            }

            /* Warna dipaksa hitam */
            .text-green-600,
            .text-red-600,
            .text-blue-600,
            .text-purple-600,
            .text-indigo-600,
            .text-gray-500,
            .text-gray-600,
            .text-gray-700,
            .text-gray-800,
            .text-green-800,
            .text-red-800 {
                color: #000 !important;
            }

            /* Background warna dipaksa transparan atau abu-abu terang */
            .bg-green-100,
            .bg-red-100,
            .bg-yellow-100,
            .bg-blue-100,
            .bg-purple-100,
            .bg-indigo-100,
            .bg-gray-100 {
                background-color: #f0f0f0 !important;
            }

            /* Icons */
            i,
            .fas {
                display: none !important;
            }

            /* Margin adjustments */
            .mb-8,
            .mb-6 {
                margin-bottom: 10px !important;
            }

            .mb-4 {
                margin-bottom: 5px !important;
            }

            /* Text alignment */
            .text-right {
                text-align: right !important;
            }

            /* Positive/Negative indicators */
            .text-positive {
                font-weight: bold;
            }

            .text-negative {
                font-weight: bold;
            }

            /* Overflow */
            .overflow-x-auto {
                overflow: visible !important;
            }

            /* Page breaks */
            .page-break-before {
                page-break-before: always;
            }

            .page-break-inside-avoid {
                page-break-inside: avoid;
            }
        }

        /* ========== STYLE UNTUK LAYAR ========== */
        @media screen {
            .print-only-data {
                display: none !important;
            }
        }
    </style>
@endsection
