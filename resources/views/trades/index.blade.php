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
                                {{ $trades->where('hasil', null)->where('exit', '!=', null)->count() }}</p>
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
                                                class="w-full bg-dark-700/50 border border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200 file:bg-dark-600 file:border-0 file:text-white file:rounded file:px-3 file:py-1">
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
                                <td class="py-4 px-4 text-sm">{{ $trade->timestamp }}</td>
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
@endsection
