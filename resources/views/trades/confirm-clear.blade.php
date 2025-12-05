@extends('Layouts.index')
@section('title', 'Confirm Clear All Trades')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-red-500 to-orange-400 bg-clip-text text-transparent">
                        ⚠️ Clear All Trades
                    </h1>
                    <p class="text-gray-400 mt-2">This action cannot be undone. Please confirm carefully.</p>
                </div>
                <a href="{{ route('trades.index') }}"
                    class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                    <i class="fas fa-arrow-left text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                    <span>Back to Trades</span>
                </a>
            </div>
        </div>

        <!-- Warning Card -->
        <div class="max-w-2xl mx-auto">
            <div
                class="bg-gradient-to-br from-red-900/20 to-red-900/10 rounded-2xl p-8 border border-red-700/30 shadow-xl mb-8">
                <div class="text-center mb-6">
                    <div class="bg-red-500/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-400 text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-red-300 mb-2">Danger Zone</h2>
                    <p class="text-gray-300">You are about to delete <span class="font-bold text-red-400">ALL</span> trading
                        data</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-dark-800/50 rounded-xl p-4 text-center border border-red-800/30">
                        <div class="text-3xl font-bold text-red-400">{{ \App\Models\Trade::count() }}</div>
                        <div class="text-sm text-gray-400 mt-1">Total Trades</div>
                    </div>
                    <div class="bg-dark-800/50 rounded-xl p-4 text-center border border-red-800/30">
                        <div class="text-3xl font-bold text-green-400">
                            {{ \App\Models\Trade::where('hasil', 'win')->count() }}</div>
                        <div class="text-sm text-gray-400 mt-1">Win Trades</div>
                    </div>
                    <div class="bg-dark-800/50 rounded-xl p-4 text-center border border-red-800/30">
                        <div class="text-3xl font-bold text-red-400">
                            ${{ number_format(\App\Models\Trade::sum('profit_loss'), 2) }}</div>
                        <div class="text-sm text-gray-400 mt-1">Total P&L</div>
                    </div>
                </div>

                <!-- Warning List -->
                <div class="bg-dark-800/30 rounded-xl p-4 mb-6">
                    <h3 class="text-lg font-bold text-red-300 mb-3 flex items-center">
                        <i class="fas fa-radiation mr-2"></i>
                        What will be deleted:
                    </h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-trash text-red-500 mr-2 text-sm"></i>
                            <span>All trade records ({{ \App\Models\Trade::count() }} trades)</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chain-broken text-red-500 mr-2 text-sm"></i>
                            <span>All trading rules associations</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chart-line text-red-500 mr-2 text-sm"></i>
                            <span>All performance statistics</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-history text-red-500 mr-2 text-sm"></i>
                            <span>All trading history</span>
                        </li>
                    </ul>
                </div>

                <!-- Confirmation Form -->
                <form action="{{ route('trades.clear-all') }}" method="POST" id="clearForm">
                    @csrf
                    @method('DELETE')

                    <!-- Type to Confirm -->
                    <div class="mb-6">
                        <label for="confirmationInput" class="block text-sm font-semibold text-gray-300 mb-2">
                            Type <span class="font-mono text-red-400">DELETE_ALL_TRADES</span> to confirm:
                        </label>
                        <input type="text" id="confirmationInput" name="confirmation_input"
                            class="w-full bg-dark-800/80 border border-red-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                            placeholder="Type here..." oninput="checkConfirmation()">
                        <input type="hidden" name="confirmation" id="confirmationHidden" value="">
                        <p class="text-xs text-red-400 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            This action is irreversible. Make sure you have a backup if needed.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0">
                        <a href="{{ route('trades.index') }}"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl transition-all duration-200 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>

                        <button type="button" onclick="confirmClear()" id="clearButton" disabled
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-300 transform disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 hover:scale-105 shadow-lg flex items-center justify-center group">
                            <i class="fas fa-broom mr-2 group-hover:scale-110 transition-transform"></i>
                            Clear All Trades
                        </button>
                    </div>
                </form>
            </div>

            <!-- Backup Reminder -->
            <div class="bg-gradient-to-br from-amber-900/20 to-amber-900/10 rounded-2xl p-6 border border-amber-700/30">
                <div class="flex items-center">
                    <div class="bg-amber-500/20 p-4 rounded-xl mr-4">
                        <i class="fas fa-database text-amber-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-amber-300 mb-1">Backup Recommendation</h3>
                        <p class="text-gray-400 text-sm">Consider exporting your trades before clearing:</p>
                        <div class="mt-3">
                            <a href="{{ route('trades.export') }}"
                                class="inline-flex items-center px-4 py-2 bg-amber-900/30 hover:bg-amber-900/50 border border-amber-700/50 text-amber-400 rounded-lg transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                Export to Excel First
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #confirmationInput:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        .pulse-warning {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.8;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.8;
            }
        }
    </style>

    <script>
        function checkConfirmation() {
            const input = document.getElementById('confirmationInput');
            const button = document.getElementById('clearButton');
            const hidden = document.getElementById('confirmationHidden');

            const requiredText = 'DELETE_ALL_TRADES';

            if (input.value === requiredText) {
                button.disabled = false;
                hidden.value = requiredText;
                input.classList.remove('border-red-700/40');
                input.classList.add('border-green-700/40');
            } else {
                button.disabled = true;
                hidden.value = '';
                input.classList.remove('border-green-700/40');
                input.classList.add('border-red-700/40');
            }
        }

        function confirmClear() {
            if (!document.getElementById('clearButton').disabled) {
                Swal.fire({
                    title: 'One Last Check',
                    html: `
                    <div class="text-left">
                        <p class="text-red-400 font-bold mb-2">Are you absolutely sure?</p>
                        <ul class="text-gray-600 dark:text-gray-300 text-sm space-y-1">
                            <li>✓ This will delete <strong>ALL</strong> trading data</li>
                            <li>✓ This action is <strong>PERMANENT</strong></li>
                            <li>✓ There is no undo or recovery</li>
                        </ul>
                    </div>
                `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete everything!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true,
                    backdrop: 'rgba(0,0,0,0.8)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        const button = document.getElementById('clearButton');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Clearing...';
                        button.disabled = true;

                        // Submit form
                        document.getElementById('clearForm').submit();
                    }
                });
            }
        }

        // Auto-focus confirmation input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmationInput').focus();

            // Add warning effect
            const warningIcon = document.querySelector('.fa-exclamation-triangle');
            if (warningIcon) {
                warningIcon.parentElement.classList.add('pulse-warning');
            }
        });
    </script>
@endsection
