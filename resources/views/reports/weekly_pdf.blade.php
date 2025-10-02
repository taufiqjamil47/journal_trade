<!DOCTYPE html>
<html>

<head>
    <title>Weekly Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Trading Journal - Weekly Report</h2>
    <p>Period: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</p>

    <h3>Summary</h3>
    <ul>
        <li>Total Trades: {{ $summary['total'] }}</li>
        <li>Wins: {{ $summary['wins'] }}</li>
        <li>Losses: {{ $summary['losses'] }}</li>
        <li>Win Rate: {{ $summary['winrate'] }}%</li>
        <li>Total Profit: ${{ number_format($summary['profit'], 2) }}</li>
    </ul>

    <h3>Trades Detail</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Symbol</th>
                <th>Type</th>
                <th>Entry</th>
                <th>SL</th>
                <th>TP</th>
                <th>P/L</th>
                <th>Result</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trades as $trade)
                <tr>
                    <td>{{ $trade->id }}</td>
                    <td>{{ $trade->symbol->name ?? '-' }}</td>
                    <td>{{ $trade->type }}</td>
                    <td>{{ $trade->entry }}</td>
                    <td>{{ $trade->sl }}</td>
                    <td>{{ $trade->tp }}</td>
                    <td>{{ $trade->profit_loss }}</td>
                    <td>{{ $trade->hasil }}</td>
                    <td>{{ $trade->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
