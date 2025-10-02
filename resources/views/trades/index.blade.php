@extends('Layouts.index')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Trading Journal</h1>
                    <p class="text-gray-400 mt-2">Kelola dan pantau semua trading Anda</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Alert -->
        @if (session('success'))
            <div
                class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 backdrop-blur-sm rounded-2xl p-4 border border-green-700/30 shadow-lg mb-6">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <span class="text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Table Container -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700/50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Daftar Trade</h2>
                        <p class="text-gray-400 text-sm mt-1">Total: {{ $trades->total() }} trades</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mt-4 md:mt-0">
                        <!-- Sorting Dropdown -->
                        <div class="relative">
                            <button id="sortDropdownButton"
                                class="bg-dark-700/70 hover:bg-dark-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 flex items-center">
                                <i class="fas fa-sort mr-2"></i>Sort By
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div id="sortDropdown"
                                class="absolute right-0 mt-2 w-48 bg-dark-800/90 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg z-10 hidden">
                                <div class="py-1">
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'desc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200">
                                        <i class="fas fa-calendar-alt mr-2"></i>Date (Newest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'asc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200">
                                        <i class="fas fa-calendar mr-2"></i>Date (Oldest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'desc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200">
                                        <i class="fas fa-hashtag mr-2"></i>ID (Highest)
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'asc']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-primary-500/20 hover:text-primary-300 transition-colors duration-200">
                                        <i class="fas fa-hashtag mr-2"></i>ID (Lowest)
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Import Form -->
                        <div class="relative">
                            <button id="importDropdownButton"
                                class="bg-gradient-to-r from-purple-600 to-purple-600 hover:from-purple-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 flex items-center">
                                <i class="fas fa-file-import mr-2"></i>Import
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div id="importDropdown"
                                class="absolute right-0 mt-2 w-64 bg-dark-800/90 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg z-10 hidden">
                                <div class="p-4">
                                    <form action="{{ route('trades.import.excel') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-300 mb-1">Select Excel
                                                File</label>
                                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                                class="w-full bg-dark-700/50 border border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        </div>
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-purple-600 to-purple-600 hover:from-purple-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                                            <i class="fas fa-upload mr-2"></i>Upload File
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Export Button -->
                        <a href="{{ route('trades.export.excel') }}"
                            class="bg-gradient-to-r from-green-600 to-green-600 hover:from-green-700 hover:to-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-file-export mr-2"></i>Excel
                        </a>

                        <a href="{{ route('reports.weekly.pdf') }}"
                            class="bg-gradient-to-r from-red-600 to-red-600 hover:from-red-700 hover:to-red-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-file-export mr-2"></i>PDF
                        </a>

                        <!-- Add New Trade Button -->
                        <a href="{{ route('trades.create') }}"
                            class="bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>Tambah Trade Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
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
                            <tr class="hover:bg-dark-700/30 transition-colors duration-200">
                                <td class="py-4 px-4">
                                    <span
                                        class="bg-dark-700/50 text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $trade->id }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-medium">{{ $trade->symbol->name }}</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                        {{ strtoupper($trade->type) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-mono text-sm">{{ $trade->entry }}</td>
                                <td class="py-4 px-4 font-mono text-sm text-red-400">{{ $trade->stop_loss }}
                                    <p class="text-xs">({{ $trade->sl_pips }} pips)</p>
                                </td>
                                <td class="py-4 px-4 font-mono text-sm text-green-400">{{ $trade->take_profit }}
                                    <p class="text-xs">({{ $trade->tp_pips }} pips)</p>
                                </td>
                                <td class="py-4 px-4 text-sm">{{ $trade->timestamp }}</td>
                                <td class="py-4 px-4 font-mono text-sm">{{ $trade->exit ?? '-' }}
                                    <p class="text-xs">({{ $trade->exit_pips ?? '-' }} pips)</p>
                                </td>
                                <td
                                    class="py-4 px-4 font-mono font-semibold {{ $trade->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $trade->profit_loss }}
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-xs font-medium bg-primary-500/20 text-primary-300">
                                        {{ $trade->session }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($trade->hasil)
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                            {{ strtoupper($trade->hasil) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('trades.edit', $trade->id) }}"
                                            class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 p-2 rounded-lg transition-colors duration-200"
                                            title="Update Exit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <a href="{{ route('trades.evaluate', $trade->id) }}"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 p-2 rounded-lg transition-colors duration-200"
                                            title="Evaluasi">
                                            <i class="fas fa-chart-bar text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-chart-line text-4xl mb-4 opacity-50"></i>
                                        <p class="text-lg">Belum ada trade</p>
                                        <p class="text-sm mt-2">Mulai dengan menambahkan trade pertama Anda</p>
                                        <a href="{{ route('trades.create') }}"
                                            class="mt-4 bg-gradient-to-r from-primary-600 to-blue-600 hover:from-primary-700 hover:to-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                            <i class="fas fa-plus mr-2"></i>Tambah Trade Pertama
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
                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $trades->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        @if ($trades->count() > 0)
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-trophy text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Win Rate</p>
                            <p class="text-lg font-semibold">
                                {{ $winrate }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30">
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
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30">
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
                    class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30">
                    <div class="flex items-center">
                        <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-clock text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pending</p>
                            <p class="text-lg font-semibold">
                                {{ $trades->where('hasil', null)->where('exit', '!=', null)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Sort dropdown
            const sortDropdownButton = document.getElementById('sortDropdownButton');
            const sortDropdown = document.getElementById('sortDropdown');

            // Import dropdown
            const importDropdownButton = document.getElementById('importDropdownButton');
            const importDropdown = document.getElementById('importDropdown');

            // Toggle sort dropdown
            sortDropdownButton.addEventListener('click', function() {
                sortDropdown.classList.toggle('hidden');
                importDropdown.classList.add('hidden');
            });

            // Toggle import dropdown
            importDropdownButton.addEventListener('click', function() {
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
        });
    </script>

    <style>
        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
@endsection
