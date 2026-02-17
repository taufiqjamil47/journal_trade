@extends('Layouts.index')
@section('title', 'Account Details')
@section('content')
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-100 dark:bg-green-800/30 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                    </div>
                    <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
                    <button type="button"
                        class="ml-auto text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300"
                        onclick="this.parentElement.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-100 dark:bg-red-800/30 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400"></i>
                    </div>
                    <span class="text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('accounts.index') }}"
                        class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Accounts
                    </a>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('accounts.edit', $account) }}"
                        class="bg-amber-600 hover:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-edit mr-2"></i>Edit Account
                    </a>
                    <button onclick="deleteAccount({{ $account->id }}, 'Account #{{ $account->id }}')"
                        class="bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-trash mr-2"></i>Delete Account
                    </button>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400 mt-4">
                Account #{{ $account->id }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">View detailed information about this account</p>
        </header>

        <!-- Account Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                        <i class="fas fa-info-circle text-primary-600 dark:text-primary-400"></i>
                    </div>
                    Basic Information
                </h2>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Account ID</div>
                        <div class="flex-1">
                            <span
                                class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full px-3 py-1 text-sm font-medium">
                                {{ $account->id }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Initial Balance</div>
                        <div class="flex-1 text-sm text-gray-900 dark:text-gray-100 font-medium">
                            {{ number_format($account->initial_balance, 2) }} {{ $account->currency }}
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Currency</div>
                        <div class="flex-1">
                            <span
                                class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 py-1 px-3 rounded-lg text-xs font-medium">
                                {{ $account->currency }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Commission/Lot</div>
                        <div class="flex-1">
                            <span
                                class="bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800 py-1 px-3 rounded-lg text-xs font-medium">
                                ${{ number_format($account->commission_per_lot, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                        <i class="fas fa-clock text-primary-600 dark:text-primary-400"></i>
                    </div>
                    Timestamps
                </h2>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Created At</div>
                        <div class="flex-1 text-sm text-gray-900 dark:text-gray-100">
                            <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                            {{ $account->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-32 text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</div>
                        <div class="flex-1 text-sm text-gray-900 dark:text-gray-100">
                            <i class="far fa-calendar-check mr-1 text-gray-400"></i>
                            {{ $account->updated_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Trades -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-primary-600 dark:text-primary-400"></i>
                </div>
                Related Trades
                @if ($account->trades->count() > 0)
                    <span
                        class="ml-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium px-2.5 py-1 rounded-full">
                        {{ $account->trades->count() }} total
                    </span>
                @endif
            </h2>

            @if ($account->trades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Symbol</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Type</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Lots</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($account->trades->take(10) as $trade)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="py-3 px-4">
                                        <span
                                            class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                            {{ $trade->id }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $trade->symbol->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                            {{ $trade->type === 'buy'
                                                ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800'
                                                : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800' }}">
                                            <i
                                                class="fas {{ $trade->type === 'buy' ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                            {{ ucfirst($trade->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 py-1 px-3 rounded-lg text-xs font-medium">
                                            {{ $trade->lot_size }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                        <i class="far fa-clock mr-1 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('trades.show', $trade) }}"
                                            class="bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 p-2 rounded-lg inline-flex"
                                            title="View Trade">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($account->trades->count() > 10)
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Showing 10 of {{ $account->trades->count() }} trades
                        </p>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-4 mb-3">
                        <i class="fas fa-chart-line text-2xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 font-medium">No trades found</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">This account doesn't have any trades yet</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteAccount(id, name) {
            const requiredCode = `DELETE_${id}`;

            Swal.fire({
                title: 'Delete Account',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg mb-4 border border-red-200 dark:border-red-800">
                            <p class="font-bold mb-2 text-red-800 dark:text-red-300">Account to delete:</p>
                            <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-wallet text-red-600 dark:text-red-400 mr-2 text-xs"></i>
                                    <span><strong>${name}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 mr-2 text-xs"></i>
                                    <span class="text-amber-800 dark:text-amber-300">This action cannot be undone. All related trades will also be deleted.</span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">Please type the confirmation code below to delete:</p>
                        <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mb-3">
                            <code class="text-red-600 dark:text-red-400 font-mono font-bold">${requiredCode}</code>
                        </div>
                        <input type="text" 
                               id="confirmDelete" 
                               class="swal2-input w-full" 
                               placeholder="Type DELETE_${id}"
                               autocomplete="off">
                    </div>
                `,
                icon: 'warning',
                iconColor: '#dc2626',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, delete it!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl',
                    title: 'text-gray-900 dark:text-gray-100 font-semibold',
                    htmlContainer: 'text-left',
                    confirmButton: 'bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 px-4 rounded-lg'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById('confirmDelete');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== requiredCode) {
                        Swal.showValidationMessage(
                            `<div class="text-red-600 dark:text-red-400 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Please type <code class="bg-red-100 dark:bg-red-900/30 px-1 py-0.5 rounded text-red-700 dark:text-red-400">${requiredCode}</code> to confirm
                            </div>`
                        );
                        return false;
                    }
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting Account',
                        html: `
                            <div class="text-center">
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-600 dark:border-red-400 mb-4"></div>
                                <p class="text-gray-700 dark:text-gray-300">Deleting ${name}...</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl',
                            title: 'text-gray-900 dark:text-gray-100 font-semibold'
                        }
                    });

                    // Submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/accounts/${id}`;
                    form.style.display = 'none';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Real-time validation for delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.id === 'confirmDelete') {
                    const matches = e.target.value.match(/DELETE_(\d+)/);
                    if (matches && matches[1]) {
                        e.target.style.borderColor = '#10b981';
                        e.target.style.boxShadow = '0 0 0 1px rgba(16, 185, 129, 0.2)';
                    } else {
                        e.target.style.borderColor = '#ef4444';
                        e.target.style.boxShadow = '0 0 0 1px rgba(239, 68, 68, 0.2)';
                    }
                }
            });
        });
    </script>

    <style>
        /* SweetAlert Custom Styles - Consistent with other pages */
        .swal2-popup {
            padding: 1.5rem !important;
        }

        .swal2-input {
            background-color: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0 !important;
            font-size: 0.875rem !important;
        }

        .swal2-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        .dark .swal2-input {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f3f4f6 !important;
        }

        .dark .swal2-input:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1) !important;
        }

        .swal2-validation-message {
            background: #fee2e2 !important;
            color: #991b1b !important;
            margin-top: 0.5rem !important;
            padding: 0.5rem !important;
            border-radius: 0.375rem !important;
        }

        .dark .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #fca5a5 !important;
        }

        /* Table scrollbar styles */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #e5e7eb #f9fafb;
        }

        .dark .overflow-x-auto {
            scrollbar-color: #4b5563 #1f2937;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 4px;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #4b5563;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background-color: #d1d5db;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
    </style>
@endsection
