<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .period {
            background: #f0f0f0;
            padding: 10px;
            text-align: center;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #2d3748;
            color: white;
            padding: 8px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .profit {
            color: green;
        }

        .loss {
            color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>TRADING REPORT</h2>
        <div><strong>Account:</strong> {{ $cover['accountName'] ?? 'All Accounts' }}</div>
        <div class="period">
            <strong>Period:</strong> {{ $dateRange['start'] }} to {{ $dateRange['end'] }}
        </div>
    </div>

    <!-- Summary Stats -->
    <div style="margin: 20px 0; padding: 15px; background: #f8fafc; border-radius: 5px;">
        <h3>Summary</h3>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
            <div><strong>Total Trades:</strong> {{ $cover['totalTrades'] }}</div>
            <div><strong>Win Rate:</strong> {{ $cover['winRate'] }}%</div>
            <div><strong>Profit/Loss:</strong> ${{ $cover['profit'] }}</div>
            <div><strong>Equity Growth:</strong> {{ $cover['equityGrowth'] }}%</div>
        </div>
    </div>

    <!-- Trades Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Symbol</th>
                <th>Type</th>
                <th>Entry</th>
                <th>Exit</th>
                <th>P/L</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @if ($trades->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center; color: #666; padding: 20px;">No trades found for this
                        period.</td>
                </tr>
            @else
                @foreach ($trades as $trade)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($trade->date)->format('d/m/Y') }}</td>
                        <td>{{ $trade->symbol->name ?? '-' }}</td>
                        <td>{{ strtoupper($trade->type) }}</td>
                        <td>{{ $trade->entry }}</td>
                        <td>{{ $trade->exit ?? '-' }}</td>
                        <td class="{{ $trade->profit_loss >= 0 ? 'profit' : 'loss' }}">
                            ${{ number_format($trade->profit_loss ?? 0, 2) }}
                        </td>
                        <td>
                            @if ($trade->hasil == 'win')
                                <span style="color: green;">WIN</span>
                            @elseif($trade->hasil == 'loss')
                                <span style="color: red;">LOSS</span>
                            @else
                                {{ $trade->hasil ?? '-' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        Generated on {{ $cover['generatedDate'] }}
    </div>
</body>

</html>
