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
            <div
                class="bg-green-100 dark:bg-green-900/30 rounded-lg p-4 border border-green-300 dark:border-green-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-200 dark:bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-500"></i>
                    </div>
                    <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900/30 rounded-lg p-4 border border-red-300 dark:border-red-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-200 dark:bg-red-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-500"></i>
                    </div>
                    <span class="text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Symbols Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ __('symbol.table_title') }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            {{ __('symbol.total_symbols', ['count' => $symbols->count()]) }}</p>
                    </div>
                    <a href="{{ route('symbols.create') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('symbol.add_symbol_button') }}
                    </a>
                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-hashtag mr-2"></i>{{ __('symbol.column_id') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-tag mr-2"></i>{{ __('symbol.column_name') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-coins mr-2"></i>{{ __('symbol.column_pip_value') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-dollar-sign mr-2"></i>{{ __('symbol.column_pip_worth') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-power-off mr-2"></i>{{ __('symbol.column_active') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-cogs mr-2"></i>{{ __('symbol.column_actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @forelse($symbols as $s)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $s->id }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium">
                                    <span class="text-gray-900 dark:text-white">{{ $s->name }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-blue-100 dark:bg-blue-500/20 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ format_price($s->pip_value) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-green-100 dark:bg-green-500/20 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ $s->pip_worth ?? 10 }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($s->active)
                                        <span
                                            class="bg-green-100 dark:bg-green-500/20 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                            <i class="fas fa-check-circle mr-1"></i> {{ __('symbol.status_active') }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                            <i class="fas fa-times-circle mr-1"></i> {{ __('symbol.status_inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('symbols.edit', $s->id) }}"
                                            class="bg-amber-100 dark:bg-amber-500/20 hover:bg-amber-200 dark:hover:bg-amber-500/30 text-amber-800 dark:text-amber-400 p-2 rounded-lg"
                                            title="{{ __('symbol.edit_button_title') }}">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteSymbol({{ $s->id }}, '{{ $s->name }}')"
                                            class="bg-red-100 dark:bg-red-500/20 hover:bg-red-200 dark:hover:bg-red-500/30 text-red-800 dark:text-red-400 p-2 rounded-lg"
                                            title="{{ __('symbol.delete_button_title') }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400 space-y-3">
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-4">
                                            <i class="fas fa-chart-line text-2xl opacity-50"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium text-gray-700 dark:text-gray-300">
                                                {{ __('symbol.no_symbols_title') }}</p>
                                            <p class="text-sm">{{ __('symbol.no_symbols_subtitle') }}</p>
                                        </div>
                                        <a href="{{ route('symbols.create') }}"
                                            class="mt-2 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-5 rounded-lg flex items-center">
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
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    {{ $symbols->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteSymbol(id, name) {
            Swal.fire({
                title: '{{ __('symbol.delete_modal_title') }}',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg mb-4 border border-red-200 dark:border-red-700/30">
                            <p class="font-bold mb-2 text-red-700 dark:text-red-300">{{ __('symbol.delete_modal_symbol_to_delete') }}</p>
                            <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-tag text-red-500 mr-2 text-xs"></i>
                                    <span><strong>${name}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-500 mr-2 text-xs"></i>
                                    <span class="text-amber-700 dark:text-amber-300">{{ __('symbol.delete_modal_warning') }}</span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">{{ __('symbol.delete_modal_confirm_prompt') }}</p>
                        <div class="bg-gray-100 dark:bg-dark-800/50 p-3 rounded-lg mb-3">
                            <code class="text-red-600 dark:text-red-400 font-mono font-bold">DELETE_${id}</code>
                        </div>
                        <input type="text" 
                               id="confirmDelete" 
                               class="swal2-input w-full" 
                               placeholder="{{ __('symbol.delete_modal_input_placeholder') }}"
                               autocomplete="off">
                    </div>
                `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>{{ __('symbol.delete_modal_confirm_button') }}',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __('symbol.delete_modal_cancel_button') }}',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 border border-red-300 dark:border-red-700/30',
                    title: 'text-red-700 dark:text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:bg-red-700',
                    cancelButton: 'hover:bg-gray-700'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById('confirmDelete');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== `DELETE_${id}`) {
                        Swal.showValidationMessage(
                            `<div class="text-red-600 dark:text-red-400 text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ __('symbol.delete_modal_validation_message_part1') }} <code class="bg-red-100 dark:bg-red-900/30 px-1 py-0.5 rounded">DELETE_${id}</code>{{ __('symbol.delete_modal_validation_message_part2') }}
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
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('symbol.delete_loading_message', ['name' => '${name}']) }}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
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
        /* SweetAlert Custom Styles */
        .swal2-popup {
            background: white !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 0.75rem !important;
        }

        .dark .swal2-popup {
            background: #1f2937 !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-title {
            color: #b91c1c !important;
            font-weight: 600 !important;
        }

        .dark .swal2-title {
            color: #fca5a5 !important;
        }

        .swal2-html-container {
            color: #374151 !important;
        }

        .dark .swal2-html-container {
            color: #d1d5db !important;
        }

        .swal2-input {
            background-color: #f9fafb !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0 !important;
        }

        .dark .swal2-input {
            background-color: rgba(31, 41, 55, 0.8) !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
            color: #f3f4f6 !important;
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
            background-color: #e5e7eb !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
            color: #111827 !important;
        }

        .dark .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            color: white !important;
        }

        .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #b91c1c !important;
        }

        .dark .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #fca5a5 !important;
        }
    </style>
@endsection
