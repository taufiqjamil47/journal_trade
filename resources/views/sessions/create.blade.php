@extends('Layouts.index')
@section('title', __('session.create_session'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('session.add_session') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('session.create_new_trading_session') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sessions.index') }}"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-400">
                        <i class="fas fa-arrow-left text-primary-600 dark:text-primary-400 mr-2"></i>
                        <span class="text-gray-700 dark:text-gray-300">{{ __('session.back_to_sessions') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                            <i class="fas fa-plus text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ __('session.create_new_session') }}</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('session.set_time_in_ny') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('sessions.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <i
                                    class="fas fa-tag mr-2 text-primary-600 dark:text-primary-400"></i>{{ __('session.session_name') }}
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:focus:ring-primary-400/20 focus:border-primary-500 dark:focus:border-primary-400"
                                placeholder="{{ __('session.name_placeholder') }}" required>
                            @error('name')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="start_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <i
                                        class="fas fa-play-circle mr-2 text-green-600 dark:text-green-400"></i>{{ __('session.start_hour') }}
                                </label>
                                <input type="number" name="start_hour" value="{{ old('start_hour') }}" min="0"
                                    max="23"
                                    class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500/20 dark:focus:ring-green-400/20 focus:border-green-500 dark:focus:border-green-400"
                                    required>
                                @error('start_hour')
                                    <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="end_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <i
                                        class="fas fa-stop-circle mr-2 text-red-600 dark:text-red-400"></i>{{ __('session.end_hour') }}
                                </label>
                                <input type="number" name="end_hour" value="{{ old('end_hour') }}" min="0"
                                    max="23"
                                    class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:focus:ring-red-400/20 focus:border-red-500 dark:focus:border-red-400"
                                    required>
                                @error('end_hour')
                                    <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration Preview -->
                        <div
                            class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                                    <i class="fas fa-clock text-primary-600 dark:text-primary-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('session.session_duration') }}</p>
                                    <p id="durationPreview" class="text-lg font-semibold text-gray-900 dark:text-gray-100">0
                                        {{ __('session.hours') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('sessions.index') }}"
                            class="flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 w-full sm:w-auto justify-center sm:justify-start">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('session.back_to_sessions') }}
                        </a>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="button" onclick="cancelCreate()"
                                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-3 px-6 rounded-lg flex items-center justify-center w-full sm:w-auto">
                                <i class="fas fa-times mr-2"></i>
                                {{ __('session.cancel') }}
                            </button>
                            <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center w-full sm:w-auto">
                                <i class="fas fa-save mr-2"></i>
                                {{ __('session.save_session') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cancelCreate() {
            Swal.fire({
                title: '{{ __('session.cancel_creation') }}',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg mb-4 border border-amber-200 dark:border-amber-800">
                            <p class="font-bold mb-2 text-amber-800 dark:text-amber-300">{{ __('session.filled_data_warning') }}</p>
                            <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 mr-2 text-xs"></i>
                                    <span>{{ __('session.all_inputs_will_be_cleared') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#f59e0b',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-times mr-2"></i>{{ __('session.yes_cancel') }}',
                cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>{{ __('session.back_to_fill') }}',
                reverseButtons: true,
                customClass: {
                    popup: 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl',
                    title: 'text-gray-900 dark:text-gray-100 font-semibold',
                    htmlContainer: 'text-left',
                    confirmButton: 'bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 px-4 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('sessions.index') }}';
                }
            });
        }

        // Real-time duration calculation
        document.addEventListener('DOMContentLoaded', function() {
            const startHourInput = document.querySelector('input[name="start_hour"]');
            const endHourInput = document.querySelector('input[name="end_hour"]');
            const durationPreview = document.getElementById('durationPreview');
            const durationDiv = document.querySelector('.bg-gray-50.dark\\:bg-gray-700\\/30');

            function updateDurationPreview() {
                const startHour = parseInt(startHourInput.value) || 0;
                const endHour = parseInt(endHourInput.value) || 0;

                let duration = endHour - startHour;
                if (duration < 0) duration += 24;

                // Update duration text
                durationPreview.textContent = `${duration} {{ __('session.hours') }}`;

                // Add visual feedback
                if (duration <= 0) {
                    durationDiv.classList.add('border-red-300', 'dark:border-red-800');
                    durationDiv.classList.remove('border-gray-200', 'dark:border-gray-700');
                    durationPreview.classList.add('text-red-600', 'dark:text-red-400');
                    durationPreview.classList.remove('text-gray-900', 'dark:text-gray-100');
                } else {
                    durationDiv.classList.remove('border-red-300', 'dark:border-red-800');
                    durationDiv.classList.add('border-gray-200', 'dark:border-gray-700');
                    durationPreview.classList.remove('text-red-600', 'dark:text-red-400');
                    durationPreview.classList.add('text-gray-900', 'dark:text-gray-100');
                }
            }

            [startHourInput, endHourInput].forEach(input => {
                input.addEventListener('input', updateDurationPreview);
                input.addEventListener('change', updateDurationPreview);
            });

            // Initial update
            updateDurationPreview();
        });

        // Form validation before submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                const startHour = parseInt(document.querySelector('input[name="start_hour"]').value);
                const endHour = parseInt(document.querySelector('input[name="end_hour"]').value);

                if (isNaN(startHour) || isNaN(endHour)) {
                    e.preventDefault();
                    showValidationError('{{ __('session.fill_start_end_hours') }}');
                    return;
                }

                let duration = endHour - startHour;
                if (duration < 0) duration += 24;

                if (duration <= 0) {
                    e.preventDefault();
                    showValidationError('{{ __('session.duration_must_be_positive') }}');
                    return;
                }

                if (duration > 24) {
                    e.preventDefault();
                    showValidationError('{{ __('session.duration_max_24_hours') }}');
                    return;
                }
            });

            function showValidationError(message) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('session.validation_failed') }}',
                    text: message,
                    confirmButtonColor: '#dc2626',
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl',
                        title: 'text-gray-900 dark:text-gray-100 font-semibold',
                        confirmButton: 'bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg'
                    }
                });
            }
        });
    </script>

    <style>
        /* SweetAlert Custom Styles - Consistent with index page */
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

        /* Number input styles */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 0.5;
        }

        /* Form input focus styles */
        input:focus {
            outline: none;
        }
    </style>
@endsection
