@extends('Layouts.index')
@section('title', 'Trades')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Trading Journal
                    </h1>
                    <p class="text-gray-500 mt-1">Pantau kinerja dan analitik perdagangan Anda</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700">
                        <i class="fas fa-user text-primary-500 mr-2"></i>
                        <span>Trader</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="bg-green-900/30 rounded-lg p-4 border border-green-700/30 mb-6">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-trophy text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Win Rate</p>
                            <p class="text-base font-semibold">{{ $winrate }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-line text-primary-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Total Trades</p>
                            <p class="text-base font-semibold">{{ $trades->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-coins text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Active</p>
                            <p class="text-base font-semibold">{{ $trades->where('exit', null)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-3 border border-gray-600">
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
        <div class="bg-gray-800 rounded-xl border border-gray-700">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">Daftar Trade</h2>
                        <p class="text-gray-500 text-sm mt-1">Total: {{ $trades->total() }} trades</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Sorting Dropdown -->
                        <div class="relative group">
                            <button
                                class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg flex items-center group">
                                <i class="fas fa-sort mr-2"></i>
                                Sort By
                                <i class="fas fa-chevron-down ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown ke samping kanan -->
                            <div
                                class="absolute left-0 top-full mt-1 w-[12rem] bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'desc']) }}"
                                        class="block px-4 py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i class="fas fa-calendar-alt mr-3 text-primary-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">Date</div>
                                            <div class="text-xs text-gray-400">Newest First</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'date', 'order' => 'asc']) }}"
                                        class="block px-4 py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i class="fas fa-calendar mr-3 text-primary-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">Date</div>
                                            <div class="text-xs text-gray-400">Oldest First</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'desc']) }}"
                                        class="block px-4 py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center border-b border-gray-700/50">
                                        <i class="fas fa-hashtag mr-3 text-primary-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">ID</div>
                                            <div class="text-xs text-gray-400">Highest First</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('trades.index', ['sort_by' => 'id', 'order' => 'asc']) }}"
                                        class="block px-4 py-3 text-sm hover:bg-primary-500/20 hover:text-primary-300 flex items-center">
                                        <i class="fas fa-hashtag mr-3 text-primary-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">ID</div>
                                            <div class="text-xs text-gray-400">Lowest First</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Import/Export Group -->
                        <div class="relative group">
                            <button
                                class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center group">
                                <i class="fas fa-exchange-alt mr-2"></i>
                                Data
                                <i class="fas fa-chevron-down ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown ke samping kanan -->
                            <div
                                class="absolute left-0 top-full mt-1 w-64 bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="p-3">
                                    <!-- Import Section -->
                                    <div class="mb-3">
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-file-import mr-2 text-purple-400"></i>
                                            Import Data
                                        </div>
                                        <form action="{{ route('trades.import.excel') }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-2">
                                            @csrf
                                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-purple-500 file:bg-purple-600 file:border-0 file:text-white file:rounded file:px-3 file:py-1 file:text-sm file:hover:bg-purple-700">
                                            <button type="submit"
                                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition-colors">
                                                <i class="fas fa-upload mr-2"></i>
                                                Upload File
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Export Section -->
                                    <div>
                                        <div class="flex items-center text-sm font-medium text-gray-300 mb-2">
                                            <i class="fas fa-file-export mr-2 text-green-400"></i>
                                            Export Data
                                        </div>
                                        <a href="{{ route('trades.export.excel') }}"
                                            class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fas fa-file-excel mr-2"></i>
                                            Export to Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Management Actions -->
                        <div class="relative group">
                            <button
                                class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-medium py-2 px-4 rounded-lg flex items-center group">
                                <i class="fas fa-tools mr-2"></i>
                                Manage
                                <i
                                    class="fas fa-chevron-down ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>
                            <!-- Dropdown ke samping kanan -->
                            <div
                                class="absolute left-0 top-full mt-1 w-[12rem] bg-gray-800 rounded-lg border border-gray-600 shadow-xl z-20 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('trades.create') }}"
                                        class="block px-4 py-3 text-sm hover:bg-blue-500/20 hover:text-blue-300 flex items-center border-b border-gray-700/50">
                                        <i class="fas fa-plus-circle mr-3 text-blue-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">Add New Trade</div>
                                            <div class="text-xs text-gray-400">Create new entry</div>
                                        </div>
                                    </a>
                                    <button onclick="quickClearAll()"
                                        class="w-full text-left px-4 py-3 text-sm hover:bg-red-500/20 hover:text-red-300 flex items-center">
                                        <i class="fas fa-trash-alt mr-3 text-red-400 w-5 text-center"></i>
                                        <div>
                                            <div class="font-medium">Clear All Trades</div>
                                            <div class="text-xs text-gray-400">Remove all data</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-750 border-b border-gray-600">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">#</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Symbol</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Type</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Entry</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">SL</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">TP</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Timestamp</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Exit</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">P/L ($)</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Session</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Hasil</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($trades as $trade)
                            <tr class="hover:bg-gray-750 cursor-pointer"
                                onclick="window.location.href='{{ route('trades.show', $trade->id) }}'">
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-700 text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $trade->id }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-xs">{{ $trade->symbol->name }}</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->type == 'buy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        {{ strtoupper($trade->type) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-mono text-sm">{{ format_price($trade->entry) }}</td>
                                <td class="py-3 px-4 font-mono">
                                    <div class="text-sm text-red-400">{{ format_price($trade->stop_loss) }}</div>
                                    <div class="text-xs text-red-400">({{ $trade->sl_pips }} pips)</div>
                                </td>
                                <td class="py-3 px-4 font-mono">
                                    <div class="text-sm text-green-400">{{ format_price($trade->take_profit) }}</div>
                                    <div class="text-xs text-green-400">({{ $trade->tp_pips }} pips)</div>
                                </td>
                                <td class="py-3 px-4 text-sm">
                                    {{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4 font-mono">
                                    @if ($trade->exit)
                                        <div class="text-sm">{{ format_price($trade->exit) }}</div>
                                        <div class="text-xs">({{ $trade->exit_pips }} pips)</div>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="font-mono font-semibold px-2 py-1 rounded-lg text-sm {{ $trade->profit_loss >= 0 ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        {{ $trade->profit_loss ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-xs font-medium bg-primary-500/20 text-primary-300 border border-primary-500/30">
                                        {{ $trade->session }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($trade->hasil)
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $trade->hasil == 'win' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                            {{ strtoupper($trade->hasil) }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-lg text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('trades.edit', $trade->id) }}"
                                            class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 p-2 rounded-lg"
                                            title="Update Exit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <a href="{{ route('trades.evaluate', $trade->id) }}"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 p-2 rounded-lg"
                                            title="Evaluasi">
                                            <i class="fas fa-chart-bar text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400 space-y-3">
                                        <div class="bg-gray-700 rounded-full p-4">
                                            <i class="fas fa-chart-line text-2xl opacity-50"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium">Belum ada trade</p>
                                            <p class="text-sm">Mulai dengan menambahkan trade pertama Anda</p>
                                        </div>
                                        <a href="{{ route('trades.create') }}"
                                            class="mt-2 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-5 rounded-lg flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
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
                <div class="px-6 py-4 border-t border-gray-700 bg-gray-750">
                    {{ $trades->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Basic Dropdown functionality
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
                    popup: 'bg-gray-800 border border-red-700/30',
                    title: 'text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:bg-red-700',
                    cancelButton: 'hover:bg-gray-700'
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
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            }

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
            document.addEventListener('input', function(e) {
                if (e.target.id === 'quickConfirm' && e.target.value.trim() === 'DELETE_ALL_TRADES') {
                    e.target.style.borderColor = '#10b981';
                    e.target.style.boxShadow = '0 0 0 1px rgba(16, 185, 129, 0.2)';
                } else if (e.target.id === 'quickConfirm') {
                    e.target.style.borderColor = '#ef4444';
                    e.target.style.boxShadow = '0 0 0 1px rgba(239, 68, 68, 0.2)';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actionsDropdownButton = document.getElementById('actionsDropdownButton');
            const actionsDropdown = document.getElementById('actionsDropdown');

            if (actionsDropdownButton && actionsDropdown) {
                actionsDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    actionsDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!actionsDropdown.contains(e.target) && !actionsDropdownButton.contains(e.target)) {
                        actionsDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <style>
        /* SweetAlert Custom Styles */
        .swal2-popup {
            background: #1f2937 !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 0.75rem !important;
        }

        .swal2-title {
            color: #fca5a5 !important;
            font-weight: 600 !important;
        }

        .swal2-html-container {
            color: #d1d5db !important;
        }

        .swal2-input {
            background-color: rgba(31, 41, 55, 0.8) !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: #f3f4f6 !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0 !important;
        }

        .swal2-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-confirm {
            background: #ef4444 !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            /* border: 1px solid rgba(239, 68, 68, 0.3) !important; */
            color: #fca5a5 !important;
            /* border-radius: 0.25rem !important; */
        }
    </style>

    <style>
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }

        .relative>div {
            transition: all 0.2s ease-in-out;
            transform: translateY(-5px);
        }

        .group:hover>div {
            transform: translateY(0);
        }
    </style>
@endsection
