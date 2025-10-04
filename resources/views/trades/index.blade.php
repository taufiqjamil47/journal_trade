@extends('Layouts.index')
@section('title', 'Trades')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Trading Journal
                    </h1>
                    <p class="text-gray-400 mt-2">Kelola dan pantau semua trading Anda</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-chart-line text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Alert -->
        @if (session('success'))
            <div
                class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 backdrop-blur-sm rounded-2xl p-4 border border-green-700/30 shadow-lg mb-6 animate-fade-in">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <span class="text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Quick Stats -->
        @if ($trades->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-trophy text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Win Rate</p>
                            <p class="text-lg font-semibold">{{ $winrate }}%</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-line text-primary-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Total Trades</p>
                            <p class="text-lg font-semibold">{{ $trades->total() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-coins text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Active</p>
                            <p class="text-lg font-semibold">{{ $trades->where('exit', null)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-clock text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pending</p>
                            <p class="text-lg font-semibold">
                                {{ $trades->where('hasil', null)->where('exit', '==', null)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table Container -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700/50">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">Daftar Trade</h2>
                        <p class="text-gray-400 text-sm mt-1">Total: {{ $trades->total() }} trades</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Sorting Dropdown -->
                        <div class="relative">
                            <button id="sortDropdownButton"
                                class="bg-dark-700/70 hover:bg-dark-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 flex items-center group">
                                <i class="fas fa-sort mr-2 group-hover:rotate-180 transition-transform duration-300"></i>
                                Sort By
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div id="sortDropdown"
                                class="absolute right-0 mt-2 w-48 bg-dark-800/95 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-2xl z-10 hidden animate-fade-in">
                                <div class="py-1">
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'desc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-primary-400"></i>
                                        Date (Newest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'asc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-calendar mr-2 text-primary-400"></i>
                                        Date (Oldest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'desc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-hashtag mr-2 text-primary-400"></i>
                                        ID (Highest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'asc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200 flex items-center">
                                        <i class="fas fa-hashtag mr-2 text-primary-400"></i>
                                        ID (Lowest)
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Import Dropdown -->
                        <div class="relative">
                            <button id="importDropdownButton"
                                class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 flex items-center group shadow-lg">
                                <i class="fas fa-file-import mr-2 group-hover:scale-110 transition-transform"></i>
                                Import
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div id="importDropdown"
                                class="z-10 absolute right-0 mt-2 w-64 bg-dark-800/95 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-2xl z-10 hidden animate-fade-in">
                                <div class="p-4">
                                    <form action="{{ route('trades.import.excel') }}" method="POST"
                                        enctype="multipart/form-data" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-1">
                                                <i class="fas fa-file-excel mr-1 text-green-400"></i>
                                                Select Excel File
                                            </label>
                                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                                class="w-full bg-dark-700/50 border border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200 file:bg-dark-600 file:border-0 file:text-black file:rounded file:px-3 file:py-1">
                                        </div>
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                            <i class="fas fa-upload mr-2"></i>
                                            Upload File
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Export Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('trades.export.excel') }}"
                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                                <i class="fas fa-file-excel mr-2 group-hover:scale-110 transition-transform"></i>
                                Excel
                            </a>
                            {{-- <a href="{{ route('reports.weekly.pdf') }}"
                                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                                <i class="fas fa-file-pdf mr-2 group-hover:scale-110 transition-transform"></i>
                                PDF
                            </a> --}}
                        </div>

                        <!-- Add New Trade Button -->
                        <a href="{{ route('trades.create') }}"
                            class="bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                            Tambah Trade Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-dark-800/80 border-b border-gray-700/50">
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">#</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Symbol</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Type</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Entry</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">SL</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">TP</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Timestamp</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Exit</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">P/L ($)</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Session</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Hasil</th>
                            <th class="py-4 px-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($trades as $trade)
                            <tr class="hover:bg-dark-700/30 transition-all duration-200 group">
                                <td class="py-4 px-4">
                                    <span
                                        class="bg-dark-700/50 text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium group-hover:bg-primary-500/20 group-hover:text-primary-300 transition-colors duration-200">
                                        {{ $trade->id }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-medium text-xs">{{ $trade->symbol->name }}</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }} transition-colors duration-200">
                                        {{ strtoupper($trade->type) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-mono text-sm bg-dark-700/30 rounded-lg mx-1">{{ $trade->entry }}
                                </td>
                                <td class="py-4 px-4 font-mono">
                                    <div class="text-sm text-red-400">{{ $trade->stop_loss }}</div>
                                    <div class="text-xs text-red-400">({{ $trade->sl_pips }} pips)</div>
                                </td>
                                <td class="py-4 px-4 font-mono">
                                    <div class="text-sm text-green-400">{{ $trade->take_profit }}</div>
                                    <div class="text-xs text-green-400">({{ $trade->tp_pips }} pips)</div>
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    {{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-4 font-mono">
                                    @if ($trade->exit)
                                        <div class="text-sm">{{ $trade->exit }}</div>
                                        <div class="text-xs">({{ $trade->exit_pips }} pips)</div>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="font-mono font-semibold px-2 py-1 rounded-lg text-sm {{ $trade->profit_loss >= 0 ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }} transition-colors duration-200">
                                        {{ $trade->profit_loss ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium bg-primary-500/20 text-primary-300 border border-primary-500/30 transition-colors duration-200">
                                        {{ $trade->session }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($trade->hasil)
                                        <span
                                            class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }} transition-colors duration-200">
                                            {{ strtoupper($trade->hasil) }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-lg text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('trades.edit', $trade->id) }}"
                                            class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 p-2 rounded-lg transition-all duration-200 transform hover:scale-110 group/edit"
                                            title="Update Exit">
                                            <i
                                                class="fas fa-edit text-sm group-hover/edit:rotate-12 transition-transform"></i>
                                        </a>
                                        <a href="{{ route('trades.evaluate', $trade->id) }}"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 p-2 rounded-lg transition-all duration-200 transform hover:scale-110 group/evaluate"
                                            title="Evaluasi">
                                            <i
                                                class="fas fa-chart-bar text-sm group-hover/evaluate:scale-110 transition-transform"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400 space-y-4">
                                        <div class="bg-dark-700/50 rounded-full p-6">
                                            <i class="fas fa-chart-line text-4xl opacity-50"></i>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-lg font-medium">Belum ada trade</p>
                                            <p class="text-sm">Mulai dengan menambahkan trade pertama Anda</p>
                                        </div>
                                        <a href="{{ route('trades.create') }}"
                                            class="mt-2 bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                                            <i
                                                class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                                            Tambah Trade Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($trades->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50 bg-dark-800/50">
                    {{ $trades->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        <!-- Popup Detail Trade -->
        <div id="tradeDetailModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden animate-fade-in">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-900 rounded-2xl border border-gray-700/50 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-gray-700/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold">Detail Trade</h3>
                            <p class="text-gray-400 text-sm" id="modalTradeId"></p>
                        </div>
                        <button id="closeModal"
                            class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-gray-700/50">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        <div id="modalContent" class="space-y-6">
                            <!-- Data akan diisi oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Zoom Modal -->
        <div id="imageZoomModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[60] hidden animate-fade-in">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative w-full max-w-4xl max-h-[90vh]">
                    <button id="closeImageModal"
                        class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors duration-200 p-2 rounded-lg hover:bg-white/10">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                    <img id="zoomedImage" src="" alt="Zoomed Chart"
                        class="w-full h-auto object-contain rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Sort dropdown
            const sortDropdownButton = document.getElementById('sortDropdownButton');
            const sortDropdown = document.getElementById('sortDropdown');

            // Import dropdown
            const importDropdownButton = document.getElementById('importDropdownButton');
            const importDropdown = document.getElementById('importDropdown');

            // Toggle sort dropdown
            sortDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.classList.toggle('hidden');
                importDropdown.classList.add('hidden');
            });

            // Toggle import dropdown
            importDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                importDropdown.classList.toggle('hidden');
                sortDropdown.classList.add('hidden');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!sortDropdownButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                    sortDropdown.classList.add('hidden');
                }

                if (!importDropdownButton.contains(event.target) && !importDropdown.contains(event
                        .target)) {
                    importDropdown.classList.add('hidden');
                }
            });

            // Prevent dropdown close when clicking inside
            [sortDropdown, importDropdown].forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
    </script>

    <script>
        // Enhanced Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // ... kode dropdown yang sudah ada ...

            // Trade Detail Modal functionality
            const tradeDetailModal = document.getElementById('tradeDetailModal');
            const modalContent = document.getElementById('modalContent');
            const modalTradeId = document.getElementById('modalTradeId');
            const closeModal = document.getElementById('closeModal');

            // Function to show trade details
            async function showTradeDetail(tradeId) {
                try {
                    // Show loading state
                    modalContent.innerHTML = `
                    <div class="flex justify-center items-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-500"></div>
                    </div>
                `;

                    // Fetch trade data
                    const response = await fetch(`/trades/${tradeId}/detail`);
                    const trade = await response.json();

                    // Populate modal content
                    modalTradeId.textContent = `Trade #${trade.id}`;
                    modalContent.innerHTML = `
                    <!-- Trade Basic Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-400">Symbol</label>
                                    <p class="font-semibold">${trade.symbol.name}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-400">Type</label>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${trade.type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30'}">
                                        ${trade.type.toUpperCase()}
                                    </span>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-400">Session</label>
                                    <p class="font-semibold">${trade.session}</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-400">Date & Time</label>
                                    <p class="font-semibold">${new Date(trade.timestamp).toLocaleString()}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-400">Result</label>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${trade.hasil ? (trade.hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') : 'bg-amber-500/20 text-amber-400 border border-amber-500/30'}">
                                        ${trade.hasil ? trade.hasil.toUpperCase() : 'PENDING'}
                                    </span>
                                </div>
                            </div>
                        </div>

                    <!-- Price Levels -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <h4 class="font-semibold text-primary-400 border-b border-gray-700/50 pb-2">Entry & Exit</h4>
                                <div>
                                    <label class="text-sm text-gray-400">Entry Price</label>
                                    <p class="font-mono font-semibold">${trade.entry}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-400">Exit Price</label>
                                    <p class="font-mono font-semibold">${trade.exit || '-'}</p>
                                </div>
                                ${trade.exit_pips ? `
                                                                                                                            <div>
                                                                                                                                <label class="text-sm text-gray-400">Exit Pips</label>
                                                                                                                                <p class="font-mono font-semibold">${trade.exit_pips} pips</p>
                                                                                                                            </div>
                                                                                                                            ` : ''}
                            </div>
                            <div class="space-y-3">
                                <h4 class="font-semibold text-primary-400 border-b border-gray-700/50 pb-2">Risk Management</h4>
                                <div>
                                    <label class="text-sm text-gray-400">Stop Loss</label>
                                    <p class="font-mono text-red-400">${trade.stop_loss}</p>
                                    <p class="text-xs text-red-400">${trade.sl_pips} pips</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-400">Take Profit</label>
                                    <p class="font-mono text-green-400">${trade.take_profit}</p>
                                    <p class="text-xs text-green-400">${trade.tp_pips} pips</p>
                                </div>
                            </div>
                        </div>

                    <!-- Risk & Money Management -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="text-sm text-gray-400">Lot Size</label>
                                <p class="font-semibold">${trade.lot_size || '-'}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-400">Risk %</label>
                                <p class="font-semibold">${trade.risk_percent ? trade.risk_percent + '%' : '-'}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-400">Risk USD</label>
                                <p class="font-semibold">${trade.risk_usd ? '$' + trade.risk_usd : '-'}</p>
                            </div>
                        </div>

                    <!-- Profit/Loss -->
                        <div class="bg-gradient-to-r ${trade.profit_loss >= 0 ? 'from-green-900/20 to-green-800/10' : 'from-red-900/20 to-red-800/10'} rounded-xl p-4 border ${trade.profit_loss >= 0 ? 'border-green-500/30' : 'border-red-500/30'}">
                            <div class="flex justify-between items-center">
                                <div>
                                    <label class="text-sm text-gray-400">Profit/Loss</label>
                                    <p class="text-xl font-bold ${trade.profit_loss >= 0 ? 'text-green-400' : 'text-red-400'}">
                                        ${trade.profit_loss ? '$' + trade.profit_loss : '-'}
                                    </p>
                                </div>
                                ${trade.rr ? `
                                                                                                                    <div class="text-right">
                                                                                                                        <label class="text-sm text-gray-400">R/R Ratio</label>
                                                                                                                        <p class="text-xl font-bold text-amber-400">${trade.rr}</p>
                                                                                                                    </div>
                                                                                                                    ` : ''}
                            </div>
                        </div>

                    <!-- Chart Images Section - IFRAME VERSION -->
                    ${trade.before_link || trade.after_link ? `
                                                                <div class="border-t border-gray-700/50 pt-4">
                                                                    <h4 class="font-semibold text-primary-400 mb-4">Trading Charts</h4>
                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                
                                        ${trade.before_link ? `
                    <div class="space-y-2">
                        <label class="text-sm text-gray-400 flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            Before Entry
                        </label>
                        <a href="${trade.before_link}" target="_blank" 
                        class="block bg-dark-700/50 hover:bg-dark-600 border border-gray-600/50 hover:border-primary-500/50 rounded-lg p-4 transition-all duration-200 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                        <i class="fas fa-chart-line text-primary-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">View Chart on TradingView</p>
                                        <p class="text-sm text-gray-400">Click to open in new tab</p>
                                    </div>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                            </div>
                        </a>
                    </div>
                    ` : ''}

                                                                        ${trade.after_link ? `
<div class="space-y-2">
    <label class="text-sm text-gray-400 flex items-center">
        <i class="fas fa-chart-line mr-2"></i>
        After Entry
    </label>
    <a href="${trade.after_link}" target="_blank" 
       class="block bg-dark-700/50 hover:bg-dark-600 border border-gray-600/50 hover:border-primary-500/50 rounded-lg p-4 transition-all duration-200 group">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-primary-500"></i>
                </div>
                <div>
                    <p class="font-medium text-white">View Chart on TradingView</p>
                    <p class="text-sm text-gray-400">Click to open in new tab</p>
                </div>
            </div>
            <i class="fas fa-external-link-alt text-gray-400 group-hover:text-primary-500 transition-colors"></i>
        </div>
    </a>
</div>
` : ''}
                                                                    </div>
                                                                </div>
                                                                ` : ''}

                        
                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700/50">
                        <a href="/trades/${trade.id}/edit" class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 px-4 py-2 rounded-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Update Exit
                        </a>
                        <a href="/trades/${trade.id}/evaluate" class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 px-4 py-2 rounded-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Evaluasi
                        </a>
                    </div>
                    `;

                    // Show modal
                    tradeDetailModal.classList.remove('hidden');

                } catch (error) {
                    console.error('Error fetching trade details:', error);
                    modalContent.innerHTML = ` <
                        div class = "text-center py-8 text-red-400" >
                        <
                        i class = "fas fa-exclamation-triangle text-2xl mb-2" > < /i> <
                        p > Gagal memuat detail trade < /p> <
                        /div>
                    `;
                }
            }

            function generateChartImage(tradingViewLink) {
                if (!tradingViewLink) return '';

                // TradingView menyediakan endpoint untuk generate image dari chart
                // Format: https://tradingview.com/x/UNIQUE_ID/ -> menjadi image
                const match = tradingViewLink.match(/tradingview\.com\/x\/([a-zA-Z0-9]+)/);
                if (match) {
                    const chartId = match[1];
                    return `
                    https: //tradingview.com/x/${chartId}/image.png`;
                }

                // Fallback: menggunakan services screenshot
                return `https://s0.2mdn.net/simg/0x0/${btoa(tradingViewLink).slice(0,10)}.jpg`;
            }

            // Function to open image in zoom modal
            function openImageModal(imageSrc) {
                const imageZoomModal = document.getElementById('imageZoomModal');
                const zoomedImage = document.getElementById('zoomedImage');

                zoomedImage.src = imageSrc;
                imageZoomModal.classList.remove('hidden');
            }

            // Close image modal
            document.getElementById('closeImageModal').addEventListener('click', function() {
                document.getElementById('imageZoomModal').classList.add('hidden');
            });

            // Close image modal when clicking outside
            document.getElementById('imageZoomModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Close image modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.getElementById('imageZoomModal').classList.add('hidden');
                }
            });

            // Add click event to table rows
            document.querySelectorAll('tbody tr').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Prevent triggering when clicking on action buttons
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        const tradeId = this.querySelector('td:first-child span').textContent
                            .trim();
                        showTradeDetail(tradeId);
                    }
                });
            });

            // Close modal events
            closeModal.addEventListener('click', function() {
                tradeDetailModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            tradeDetailModal.addEventListener('click', function(e) {
                if (e.target === tradeDetailModal) {
                    tradeDetailModal.classList.add('hidden');
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !tradeDetailModal.classList.contains('hidden')) {
                    tradeDetailModal.classList.add('hidden');
                }
            });
        });
    </script>

    <style>
        /* Custom animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.2s ease-out;
        }

        /* Enhanced scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            margin: 0 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, transform, box-shadow;
            transition-duration: 200ms;
            transition-timing-function: ease-in-out;
        }

        /* Hover effects for table rows */
        tbody tr {
            cursor: pointer;
        }

        tbody tr:hover {
            transform: translateX(4px);
        }
    </style>

    <style>
        /* Hover effects for table rows */
        tbody tr {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            transform: translateX(4px);
            background: rgba(59, 130, 246, 0.05) !important;
        }

        /* Chart image hover effects */
        .chart-image {
            transition: all 0.3s ease;
        }

        .chart-image:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.3);
        }

        /* Smooth loading for images */
        img {
            transition: opacity 0.3s ease;
        }

        img[loading] {
            opacity: 0;
        }

        img:not([loading]) {
            opacity: 1;
        }

        /* Image zoom modal animation */
        #imageZoomModal img {
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ... CSS yang sudah ada ... */

        /* Modal animations */
        #tradeDetailModal {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #tradeDetailModal:not(.hidden) {
            opacity: 1;
        }

        #tradeDetailModal>div {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        #tradeDetailModal:not(.hidden)>div {
            transform: scale(1);
        }

        /* Smooth scrolling for modal content */
        #modalContent {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }

        #modalContent::-webkit-scrollbar {
            width: 6px;
        }

        #modalContent::-webkit-scrollbar-track {
            background: transparent;
        }

        #modalContent::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        #modalContent::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
@endsection
