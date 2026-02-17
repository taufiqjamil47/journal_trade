@extends('Layouts.index')
@section('title', __('symbol.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('symbol.header_title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('symbol.header_subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                @include('components.navbar-selector')
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-100 dark:bg-green-800/30 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                    </div>
                    <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
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

        <!-- Symbols Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __('symbol.table_title') }}
                        </h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            {{ __('symbol.total_symbols', ['count' => $symbols->count()]) }}</p>
                    </div>
                    <a href="{{ route('symbols.create') }}"
                        class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('symbol.add_symbol_button') }}
                    </a>
                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>{{ __('symbol.column_id') }}
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>{{ __('symbol.column_name') }}
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-coins mr-2"></i>{{ __('symbol.column_pip_value') }}
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-dollar-sign mr-2"></i>{{ __('symbol.column_pip_worth') }}
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-power-off mr-2"></i>{{ __('symbol.column_active') }}
                            </th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>{{ __('symbol.column_actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($symbols as $s)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $s->id }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">
                                    {{ $s->name }}
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ (float) $s->pip_value }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ $s->pip_worth ?? 10 }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($s->active)
                                        <span
                                            class="bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 py-1 px-3 rounded-lg text-xs font-medium">
                                            <i class="fas fa-check-circle mr-1"></i> {{ __('symbol.status_active') }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 py-1 px-3 rounded-lg text-xs font-medium">
                                            <i class="fas fa-times-circle mr-1"></i> {{ __('symbol.status_inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('symbols.edit', $s->id) }}"
                                            class="bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-900/50 text-amber-600 dark:text-amber-400 p-2 rounded-lg"
                                            title="{{ __('symbol.edit_button_title') }}">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteSymbol({{ $s->id }}, '{{ $s->name }}')"
                                            class="bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 p-2 rounded-lg"
                                            title="{{ __('symbol.delete_button_title') }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-4">
                                            <i class="fas fa-chart-line text-3xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium text-gray-700 dark:text-gray-300">
                                                {{ __('symbol.no_symbols_title') }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ __('symbol.no_symbols_subtitle') }}</p>
                                        </div>
                                        <a href="{{ route('symbols.create') }}"
                                            class="mt-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-2 px-5 rounded-lg flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
                                            {{ __('symbol.add_first_symbol_button') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($symbols) && method_exists($symbols, 'hasPages') && $symbols->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $symbols->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteSymbol(id, name) {
            const requiredCode = `DELETE_${id}`;

            Swal.fire({
                title: '{{ __('symbol.delete_modal_title') }}',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg mb-4 border border-red-200 dark:border-red-800">
                            <p class="font-bold mb-2 text-red-800 dark:text-red-300">{{ __('symbol.delete_modal_symbol_to_delete') }}</p>
                            <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-tag text-red-600 dark:text-red-400 mr-2 text-xs"></i>
                                    <span><strong>${name}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 mr-2 text-xs"></i>
                                    <span class="text-amber-800 dark:text-amber-300">{{ __('symbol.delete_modal_warning') }}</span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">{{ __('symbol.delete_modal_confirm_prompt') }}</p>
                        <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mb-3">
                            <code class="text-red-600 dark:text-red-400 font-mono font-bold">${requiredCode}</code>
                        </div>
                        <input type="text" 
                               id="confirmDelete" 
                               class="swal2-input w-full" 
                               placeholder="{{ __('symbol.delete_modal_input_placeholder') }}"
                               autocomplete="off">
                    </div>
                `,
                icon: 'warning',
                iconColor: '#dc2626',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>{{ __('symbol.delete_modal_confirm_button') }}',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __('symbol.delete_modal_cancel_button') }}',
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
                                {{ __('symbol.delete_modal_validation_message_part1') }} <code class="bg-red-100 dark:bg-red-900/30 px-1 py-0.5 rounded text-red-700 dark:text-red-400">${requiredCode}</code>{{ __('symbol.delete_modal_validation_message_part2') }}
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
                        title: '{{ __('symbol.delete_loading_title') }}',
                        html: `
                            <div class="text-center">
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-600 dark:border-red-400 mb-4"></div>
                                <p class="text-gray-700 dark:text-gray-300">{{ __('symbol.delete_loading_message', ['name' => '${name}']) }}</p>
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
                    form.action = `/symbols/${id}`;
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

        /* Table styles */
        .table-container {
            scrollbar-width: thin;
            scrollbar-color: #e5e7eb #f9fafb;
        }

        .dark .table-container {
            scrollbar-color: #4b5563 #1f2937;
        }

        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        .dark .table-container::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 4px;
        }

        .dark .table-container::-webkit-scrollbar-thumb {
            background-color: #4b5563;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background-color: #d1d5db;
        }

        .dark .table-container::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
    </style>
@endsection
