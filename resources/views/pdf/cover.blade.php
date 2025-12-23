@extends('pdf.layouts.master')

@section('title', 'Trading Report Summary')
@section('report-title', 'TRADING PERFORMANCE REPORT')
@section('report-subtitle', 'Comprehensive Analysis & Statistics')
@section('report-id', 'TR-SUMMARY-' . now()->format('Ymd-His'))

@section('styles')
    <style>
        .performance-highlights {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .highlight-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .highlight-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #60a5fa);
        }

        .highlight-card.win::before {
            background: linear-gradient(90deg, var(--success), #34d399);
        }

        .highlight-card.loss::before {
            background: linear-gradient(90deg, var(--danger), #f87171);
        }

        .highlight-value {
            font-size: 24px;
            font-weight: 800;
            margin: 8px 0;
            font-family: 'JetBrains Mono', monospace;
        }

        .period-card {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }

        .symbols-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .symbol-tag {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 500;
        }

        /* Untuk media print/A4 */
        @media print {
            .performance-highlights {
                /* Sesuaikan gap untuk print */
                gap: 8px;
                /* Pastikan tidak ada elemen yang terpotong antar halaman */
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Period Information -->
    <div class="period-card">
        <div style="font-size: 16px; font-weight: 600; color: var(--primary-dark); margin-bottom: 8px;">
            REPORT PERIOD
        </div>
        <div style="font-size: 18px; font-weight: 700; color: var(--gray-900);">
            {{ $firstMonth ?? 'January' }} - {{ $lastMonth ?? 'December' }} {{ $tradeYear ?? date('Y') }}
        </div>
        <div style="font-size: 12px; color: var(--gray-700); margin-top: 5px;">
            {{ $totalTrades ?? 0 }} trades analyzed
        </div>
    </div>

    <!-- Performance Highlights -->
    <div class="performance-highlights">
        <div class="highlight-card win">
            <div class="stat-label">Win Rate</div>
            <div class="highlight-value text-success">{{ $winRate ?? '0%' }}</div>
            <div style="font-size: 10px; color: var(--gray-700);">
                {{ $winTrades ?? 0 }} wins
            </div>
        </div>

        <div class="highlight-card">
            <div class="stat-label">Total P/L</div>
            <div class="highlight-value {{ ($profit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                ${{ $profit ?? '0.00' }}
            </div>
            <div style="font-size: 10px; color: var(--gray-700);">
                {{ $totalTrades ?? 0 }} trades
            </div>
        </div>

        <div class="highlight-card">
            <div class="stat-label">Equity Growth</div>
            <div class="highlight-value {{ ($equityGrowth ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                {{ $equityGrowth ?? '0.00%' }}
            </div>
            <div style="font-size: 10px; color: var(--gray-700);">
                Start: ${{ $startBalance ?? '0.00' }}
            </div>
        </div>

        <div class="highlight-card">
            <div class="stat-label">Avg Risk/Reward</div>
            <div class="highlight-value">{{ $avgRR ?? '0.00' }}</div>
            <div style="font-size: 10px; color: var(--gray-700);">
                Risk Management
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="grid grid-2 mb-4">
        <div class="card">
            <div class="card-header">Balance Summary</div>
            <div class="grid grid-2">
                <div class="stat">
                    <div class="stat-label">Start Balance</div>
                    <div class="stat-value">${{ $startBalance ?? '0.00' }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">Current Balance</div>
                    <div class="stat-value">${{ $currentBalance ?? '0.00' }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Trade Distribution</div>
            <div class="grid grid-2">
                <div class="stat">
                    <div class="stat-label">Win Trades</div>
                    <div class="stat-value text-success">{{ $winTrades ?? 0 }}</div>
                </div>
                <div class="stat">
                    <div class="stat-label">Loss Trades</div>
                    <div class="stat-value text-danger">{{ $lossTrades ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Traded Symbols -->
    @if (!empty($symbolReport))
        <div class="card">
            <div class="card-header">Traded Symbols</div>
            <div class="symbols-cloud">
                @php
                    $symbols = explode(', ', $symbolReport);
                @endphp
                @foreach ($symbols as $symbol)
                    <span class="symbol-tag">{{ $symbol }}</span>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Generated Information -->
    <div class="card">
        <div class="grid grid-3">
            <div class="text-center">
                <div class="stat-label">Generated By</div>
                <div style="font-weight: 600;">{{ $byFX1 ?? 'Trader' }}</div>
            </div>
            <div class="text-center">
                <div class="stat-label">System</div>
                <div style="font-weight: 600;">{{ $byFX2 ?? 'Trading Journal' }}</div>
            </div>
            <div class="text-center">
                <div class="stat-label">Report Date</div>
                <div style="font-weight: 600;">{{ $generatedDate ?? now()->format('d F Y') }}</div>
            </div>
        </div>
    </div>
@endsection
