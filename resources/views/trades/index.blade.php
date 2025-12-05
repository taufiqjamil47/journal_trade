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
                    <p class="text-gray-400 mt-2">Pantau kinerja dan analitik perdagangan Anda</p>
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
                            <button onclick="quickClearAll()"
                                class="flex items-center bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg group">
                                <i class="fas fa-broom mr-2 group-hover:scale-110 transition-transform"></i>
                                Clear All
                            </button>
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
                            <tr class="hover:bg-dark-700/30 transition-all duration-200 group cursor-pointer"
                                onclick="window.location.href='{{ route('trades.show', $trade->id) }}'">
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
        function quickClearAll() {
            // Get current trade count for display
            const tradeCount = {{ \App\Models\Trade::count() }};

            if (tradeCount === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Data',
                    text: 'There are no trades to clear.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                title: '🚨 Clear All Trades?',
                html: `
            <div class="text-left text-sm">
                <p class="text-red-400 mb-3 font-bold">Tindakan ini tidak dapat dibatalkan!</p>
                <div class="bg-red-900/20 p-4 rounded-lg mb-4 border border-red-700/30">
                    <p class="font-bold mb-2 text-red-300">Akan dihapus secara permanen:</p>
                    <ul class="space-y-1 text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-trash text-red-500 mr-2 text-xs"></i>
                            <span><strong>${tradeCount}</strong> catatan trading</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chart-bar text-red-500 mr-2 text-xs"></i>
                            <span>Semua statistik kinerja</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-link text-red-500 mr-2 text-xs"></i>
                            <span>Semua aturan asosiasi</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-history text-red-500 mr-2 text-xs"></i>
                            <span>Riwayat trading lengkap</span>
                        </li>
                    </ul>
                </div>
                <p class="text-gray-300 mb-2">Untuk mengonfirmasi, ketik:</p>
                <div class="bg-dark-800/50 p-3 rounded-lg mb-3">
                    <code class="text-red-400 font-mono font-bold">DELETE_ALL_TRADES</code>
                </div>
                <input type="text" 
                       id="quickConfirm" 
                       class="swal2-input w-full" 
                       placeholder="Ketik teks konfirmasi..."
                       autocomplete="off">
            </div>
        `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-broom mr-2"></i>Clear All Trades',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-gradient-to-br from-dark-800 to-dark-900 border border-red-800/30',
                    title: 'text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:scale-105 transition-transform',
                    cancelButton: 'hover:bg-gray-700 transition-colors'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById('quickConfirm');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== 'DELETE_ALL_TRADES') {
                        Swal.showValidationMessage(
                            `<div class="text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Silakan ketik <code class="bg-red-900/30 px-1 py-0.5 rounded">DELETE_ALL_TRADES</code> tepat
                    </div>`
                        );
                        return false;
                    }
                    return {
                        confirmation: typedValue
                    };
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // Show loading with custom message
                    Swal.fire({
                        title: 'Membersihkan Perdagangan...',
                        html: `
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                        <p class="text-gray-400">Menghapus ${tradeCount} catatan perdagangan...</p>
                        <p class="text-xs text-gray-500 mt-2">Tolong jangan tutup jendela ini</p>
                    </div>
                `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // Submit via AJAX
                    fetch('{{ route('trades.clear-all') }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(async response => {
                            // Try to parse JSON response
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            }

                            // If not JSON, throw error
                            const text = await response.text();
                            throw new Error(`Server returned: ${text.substring(0, 100)}...`);
                        })
                        .then(data => {
                            if (data.success) {
                                // SUCCESS - Show success message
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: '#10b981',
                                    title: 'Success!',
                                    html: `
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/20 rounded-full mb-4">
                                    <i class="fas fa-check text-green-500 text-2xl"></i>
                                </div>
                                <p class="text-green-400 font-bold text-lg mb-2">${data.message}</p>
                                <p class="text-gray-400 text-sm">Semua data perdagangan telah dihapus.</p>
                                <p class="text-gray-500 text-xs mt-2">Halaman akan dimuat ulang dalam beberapa detik...</p>
                            </div>
                        `,
                                    showConfirmButton: true,
                                    confirmButtonText: '<i class="fas fa-sync-alt mr-2"></i>Reload Now',
                                    confirmButtonColor: '#10b981',
                                    timer: 5000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        location.reload();
                                    }
                                }).then((reloadResult) => {
                                    if (reloadResult.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                // SERVER RETURNED ERROR
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    html: `
                            <div class="text-left">
                                <p class="text-red-400 mb-3">${data.message}</p>
                                ${data.error ? `<p class="text-gray-500 text-xs mb-2">${data.error}</p>` : ''}
                                <p class="text-gray-400 text-sm mt-3">Silakan coba lagi atau hubungi dukungan.</p>
                            </div>
                        `,
                                    confirmButtonColor: '#d33'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Clear All Error:', error);

                            Swal.fire({
                                icon: 'error',
                                title: 'Connection Error',
                                html: `
                        <div class="text-left">
                            <p class="text-red-400 mb-3">Failed to connect to server.</p>
                            <p class="text-gray-500 text-xs mb-2">${error.message}</p>
                            <p class="text-gray-400 text-sm mt-3">Silakan periksa koneksi Anda dan coba lagi.</p>
                        </div>
                    `,
                                confirmButtonColor: '#d33'
                            });
                        });
                }
            });
        }

        // Add real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            // If we're on SweetAlert, watch for input changes
            document.addEventListener('input', function(e) {
                if (e.target.id === 'quickConfirm' && e.target.value.trim() === 'DELETE_ALL_TRADES') {
                    e.target.style.borderColor = '#10b981';
                    e.target.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.2)';
                } else if (e.target.id === 'quickConfirm') {
                    e.target.style.borderColor = '#ef4444';
                    e.target.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                }
            });
        });
    </script>

    <style>
        /* SweetAlert Custom Styles */
        .swal2-popup {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 1rem !important;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.2) !important;
        }

        .swal2-title {
            color: #fca5a5 !important;
            font-weight: 700 !important;
        }

        .swal2-html-container {
            color: #d1d5db !important;
        }

        .swal2-input {
            background-color: rgba(31, 41, 55, 0.8) !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: #f3f4f6 !important;
            border-radius: 0.75rem !important;
            padding: 0.875rem 1rem !important;
            margin: 0 !important;
            /* Atau margin sesuai kebutuhan Anda */
        }

        .swal2-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            transition: all 0.3s !important;
        }

        .swal2-confirm:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4) !important;
        }

        .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            transition: all 0.3s !important;
        }

        .swal2-cancel:hover {
            background-color: #4b5563 !important;
        }

        .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
            border-radius: 0.5rem !important;
        }
    </style>

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
