<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Trading Report')</title>
    <style>
        /* ===== MODERN DESIGN SYSTEM ===== */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: var(--gray-900);
            margin: 0;
            padding: 25px;
            background: white;
        }

        /* Header Styles */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary);
        }

        .report-title {
            flex: 1;
        }

        .report-title h1 {
            color: var(--primary-dark);
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }

        .report-title .subtitle {
            color: var(--gray-700);
            font-size: 13px;
            font-weight: 400;
        }

        .report-meta {
            text-align: right;
            font-size: 10px;
            color: var(--gray-700);
        }

        /* Card Styles */
        .card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grid System */
        .grid {
            display: grid;
            gap: 12px;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        /* Stat Cards */
        .stat {
            text-align: center;
            padding: 12px;
            border-radius: 6px;
            background: var(--gray-50);
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            margin: 4px 0;
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-label {
            font-size: 9px;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d1fae5;
            color: var(--success);
        }

        .badge-danger {
            background: #fee2e2;
            color: var(--danger);
        }

        .badge-warning {
            background: #fef3c7;
            color: var(--warning);
        }

        .badge-info {
            background: #dbeafe;
            color: var(--primary);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: var(--gray-50);
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 2px solid var(--gray-200);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 11px;
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Typography */
        .text-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        .text-success {
            color: var(--success);
        }

        .text-danger {
            color: var(--danger);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-muted {
            color: var(--gray-700);
        }

        /* Footer */
        .report-footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid var(--gray-200);
            text-align: center;
            font-size: 9px;
            color: var(--gray-700);
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 12px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mt-3 {
            margin-top: 12px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .p-1 {
            padding: 4px;
        }

        .p-2 {
            padding: 8px;
        }

        .p-3 {
            padding: 12px;
        }

        .p-4 {
            padding: 16px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Header -->
    <div class="report-header">
        <div class="report-title">
            <h1>@yield('report-title', 'Trading Report')</h1>
            <div class="subtitle">@yield('report-subtitle', 'Professional Trading Analysis')</div>
        </div>
        <div class="report-meta">
            <div>Generated: {{ now()->format('d M Y, H:i') }}</div>
            <div>Report ID: @yield('report-id', 'TR-' . now()->format('Ymd-His'))</div>
            @hasSection('report-period')
                <div>Period: @yield('report-period')</div>
            @endif
        </div>
    </div>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <div class="report-footer">
        <div>© {{ date('Y') }} Trading Journal System</div>
        <div class="text-muted mt-1">This report is generated automatically. For official records, consult with a
            financial advisor.</div>
        <div class="mt-1">Page <span class="page-number"></span></div>
    </div>

    <script>
        // Add page numbers
        document.addEventListener('DOMContentLoaded', function() {
            const pages = document.querySelectorAll('.page-number');
            pages.forEach((page, index) => {
                page.textContent = (index + 1);
            });
        });
    </script>
</body>

</html>
