<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Trade Report #{{ $formatted['tradeNo'] ?? '' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .trade-info {
            margin-bottom: 15px;
        }

        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .section-title {
            background: #f0f0f0;
            padding: 5px;
            margin: -10px -10px 10px -10px;
            border-radius: 5px 5px 0 0;
            font-weight: bold;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            margin-bottom: 8px;
        }

        .profit {
            color: green;
            font-weight: bold;
        }

        .loss {
            color: red;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>TRADE REPORT #{{ $formatted['tradeNo'] }}</h2>
        <div>{{ $trade->symbol->name ?? '' }} | {{ $formatted['date'] }} | {{ $formatted['type'] }}</div>
    </div>

    <div class="grid-2">
        <div class="section">
            <div class="section-title">Trade Details</div>
            <div class="trade-info">
                <div class="value"><span class="label">Symbol:</span> {{ $trade->symbol->name ?? '' }}</div>
                <div class="value"><span class="label">Type:</span> {{ $formatted['type'] }}</div>
                <div class="value"><span class="label">Date/Time:</span> {{ $formatted['date'] }}
                    {{ $formatted['timestamp'] }}</div>
                <div class="value"><span class="label">Session:</span> {{ $formatted['session'] }}</div>
                <div class="value"><span class="label">Result:</span>
                    <span class="{{ $formatted['hasil'] == 'win' ? 'profit' : 'loss' }}">
                        {{ strtoupper($formatted['hasil']) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Price Levels</div>
            <div class="trade-info">
                <div class="value"><span class="label">Entry:</span> {{ $formatted['entry'] }}</div>
                <div class="value"><span class="label">Stop Loss:</span> {{ $formatted['stopLoss'] }}
                    ({{ $formatted['slPips'] }} pips)</div>
                <div class="value"><span class="label">Take Profit:</span> {{ $formatted['takeProfit'] }}
                    ({{ $formatted['tpPips'] }} pips)</div>
                <div class="value"><span class="label">Exit:</span> {{ $formatted['exit'] }}
                    ({{ $formatted['exitPips'] }} pips)</div>
                <div class="value"><span class="label">R/R Ratio:</span> {{ $formatted['rr'] }}</div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="section">
            <div class="section-title">Risk Management</div>
            <div class="trade-info">
                <div class="value"><span class="label">Lot Size:</span> {{ $formatted['lotSize'] }}</div>
                <div class="value"><span class="label">Risk %:</span> {{ $formatted['riskPercent'] }}</div>
                <div class="value"><span class="label">Risk USD:</span> ${{ $formatted['riskUSD'] }}</div>
                <div class="value"><span class="label">Balance at Entry:</span> ${{ $formatted['balance'] }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Profit/Loss</div>
            <div class="trade-info" style="text-align: center; padding: 20px;">
                <div style="font-size: 24px; margin-bottom: 10px;">
                    P/L:
                    <span class="{{ $formatted['profitLossClass'] }}">
                        ${{ $formatted['profitLoss'] }}
                    </span>
                </div>
                <div style="font-size: 14px; color: #666;">
                    {{ $formatted['profitLoss'] >= 0 ? 'Profit' : 'Loss' }}
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Trading Psychology & Notes</div>
        <div class="trade-info">
            <div class="grid-2">
                <div>
                    <div class="value"><span class="label">Entry Emotion:</span> {{ $formatted['entryEmotion'] }}
                    </div>
                    <div class="value"><span class="label">Close Emotion:</span> {{ $formatted['closeEmotion'] }}
                    </div>
                    <div class="value"><span class="label">Follow Rules:</span> {{ $formatted['followRules'] }}</div>
                </div>
                <div>
                    <div class="value"><span class="label">Entry Type:</span> {{ $formatted['entryType'] }}</div>
                    <div class="value"><span class="label">Market Condition:</span>
                        {{ $formatted['marketCondition'] }}</div>
                </div>
            </div>

            <div class="value" style="margin-top: 10px;">
                <span class="label">Entry Reason:</span><br>
                {{ $formatted['entryReason'] }}
            </div>

            <div class="value" style="margin-top: 10px;">
                <span class="label">SL/TP Reasoning:</span><br>
                {{ $formatted['whySlTp'] }}
            </div>

            @if (!empty($rules))
                <div class="value" style="margin-top: 10px;">
                    <span class="label">Trading Rules Applied:</span><br>
                    {{ implode(', ', $rules) }}
                </div>
            @endif

            <div class="value" style="margin-top: 10px;">
                <span class="label">Notes:</span><br>
                {{ $formatted['note'] }}
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Chart Links</div>
        <div class="trade-info grid-2">
            <div class="value">
                <span class="label">Before Entry:</span><br>
                {{ $formatted['before'] }}
            </div>
            <div class="value">
                <span class="label">After Exit:</span><br>
                {{ $formatted['after'] }}
            </div>
        </div>
    </div>

    <div
        style="margin-top: 30px; text-align: center; font-size: 10px; color: #888; border-top: 1px solid #ddd; padding-top: 10px;">
        Report generated on {{ now()->format('d/m/Y H:i') }} | Trade ID: {{ $trade->id }}
    </div>
</body>

</html>
