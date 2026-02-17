@extends('Layouts.index')
@section('title', __('session.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('session.header.title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('session.header.subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                @include('components.navbar-selector')
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div
                class="bg-green-700/50 dark:bg-green-900/30 rounded-lg p-4 border border-green-900 dark:border-green-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-600 dark:bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-white dark:text-green-500"></i>
                    </div>
                    <span class="text-white dark:text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900/30 rounded-lg p-4 border border-red-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <span class="text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Sessions Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold">{{ __('session.table.title') }}</h2>
                        <p class="text-gray-600 dark:text-gray-500 text-sm mt-1">
                            {{ __('session.table.total', ['total' => $sessions->total()]) }}</p>
                    </div>
                    <a href="{{ route('sessions.create') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('session.table.add_button') }}
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="border-b border-gray-600 hover:bg-gray-300">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-hashtag mr-2"></i>{{ __('session.table.columns.id') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-tag mr-2"></i>{{ __('session.table.columns.name') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-play-circle mr-2"></i>{{ __('session.table.columns.start_hour') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-stop-circle mr-2"></i>{{ __('session.table.columns.end_hour') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-clock mr-2"></i>{{ __('session.table.columns.duration') }}
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                <i class="fas fa-cogs mr-2"></i>{{ __('session.table.columns.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($sessions as $s)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors duration-150">
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $s->id }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium">
                                    <span class="text-gray-600 dark:text-white">{{ $s->name }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-green-100 dark:bg-green-500/20 text-green-500 text-green-400 border border-green-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ $s->start_hour }}:00
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-red-100 dark:bg-red-500/20 text-red-500 text-red-400 border border-red-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ $s->end_hour }}:00
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $duration = $s->end_hour - $s->start_hour;
                                        if ($duration < 0) {
                                            $duration += 24;
                                        }
                                    @endphp
                                    <span
                                        class="bg-primary-500/20 text-primary-300 border border-primary-500/30 py-1 px-3 rounded-lg text-xs font-medium">
                                        {{ __('session.duration', ['hours' => $duration]) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sessions.edit', $s) }}"
                                            class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 p-2 rounded-lg"
                                            title="{{ __('session.actions.edit') }}">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteSession({{ $s->id }}, '{{ $s->name }}')"
                                            class="bg-red-500/20 hover:bg-red-500/30 text-red-400 p-2 rounded-lg"
                                            title="{{ __('session.actions.delete') }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400 space-y-3">
                                        <div class="bg-gray-700 rounded-full p-4">
                                            <i class="fas fa-clock text-2xl opacity-50"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-base font-medium">{{ __('session.empty.title') }}</p>
                                            <p class="text-sm">{{ __('session.empty.description') }}</p>
                                        </div>
                                        <a href="{{ route('sessions.create') }}"
                                            class="mt-2 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-5 rounded-lg flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
                                            {{ __('session.empty.button') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($sessions->hasPages())
                <div class="px-6 py-4 border-t border-gray-700 bg-gray-750">
                    {{ $sessions->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Simpan terjemahan di JavaScript object
        const sessionTranslations = {
            delete_title: '{{ __('session.delete.title') }}',
            delete_to_delete: '{{ __('session.delete.to_delete') }}',
            delete_warning: '{{ __('session.delete.warning') }}',
            delete_confirm_text: '{{ __('session.delete.confirm_text') }}',
            delete_placeholder: '{{ __('session.delete.placeholder') }}',
            delete_confirm_button: '{{ __('session.delete.confirm_button') }}',
            delete_cancel_button: '{{ __('session.delete.cancel_button') }}',
            delete_validation_template: '{{ __('session.delete.validation') }}',
            delete_deleting: '{{ __('session.delete.deleting') }}',
            delete_deleting_message_template: '{{ __('session.delete.deleting_message') }}',
        };

        function deleteSession(id, name) {
            const requiredCode = `DELETE_${id}`;

            // Buat pesan validation dengan kode yang benar
            const validationMessage = sessionTranslations.delete_validation_template
                .replace(':code', `<code class="bg-red-900/30 px-1 py-0.5 rounded">DELETE_${id}</code>`);

            // Buat pesan deleting dengan nama session
            const deletingMessage = sessionTranslations.delete_deleting_message_template
                .replace(':name', `"${name}"`);

            Swal.fire({
                title: sessionTranslations.delete_title,
                html: `
                <div class="text-left text-sm">
                    <div class="bg-red-900/20 p-4 rounded-lg mb-4 border border-red-700/30">
                        <p class="font-bold mb-2 text-red-300">${sessionTranslations.delete_to_delete}</p>
                        <ul class="space-y-1 text-gray-300">
                            <li class="flex items-center">
                                <i class="fas fa-tag text-red-500 mr-2 text-xs"></i>
                                <span><strong>${name}</strong></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-amber-500 mr-2 text-xs"></i>
                                <span class="text-amber-300">${sessionTranslations.delete_warning}</span>
                            </li>
                        </ul>
                    </div>
                    <p class="text-gray-300 mb-2">${sessionTranslations.delete_confirm_text}</p>
                    <div class="bg-dark-800/50 p-3 rounded-lg mb-3">
                        <code class="text-red-400 font-mono font-bold">${requiredCode}</code>
                    </div>
                    <input type="text" 
                           id="confirmDelete" 
                           class="swal2-input w-full" 
                           placeholder="${sessionTranslations.delete_placeholder}"
                           autocomplete="off">
                </div>
            `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `<i class="fas fa-trash mr-2"></i>${sessionTranslations.delete_confirm_button}`,
                cancelButtonText: `<i class="fas fa-times mr-2"></i>${sessionTranslations.delete_cancel_button}`,
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
                    const confirmInput = document.getElementById('confirmDelete');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== requiredCode) {
                        Swal.showValidationMessage(
                            `<div class="text-red-400 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            ${validationMessage}
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
                        title: sessionTranslations.delete_deleting,
                        html: `
                        <div class="text-center">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                            <p class="text-gray-400">${deletingMessage}</p>
                        </div>
                    `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // Submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/sessions/${id}`;
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
        /* SweetAlert Custom Styles - Same as trades index */
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
            color: #fca5a5 !important;
        }
    </style>
@endsection
