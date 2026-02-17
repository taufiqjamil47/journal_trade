@extends('Layouts.index')
@section('title', __('symbol.create_title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('symbol.create_header_title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('symbol.create_header_subtitle') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('symbols.index') }}"
                        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-400 text-gray-700 dark:text-gray-300">
                        <i class="fas fa-arrow-left text-primary-500 dark:text-primary-400 mr-2"></i>
                        <span>{{ __('symbol.back_to_list') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4 border border-red-200 dark:border-red-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-100 dark:bg-red-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-red-800 dark:text-red-300 font-medium mb-1">{{ __('symbol.form_error_title') }}</p>
                        <ul class="text-red-700 dark:text-red-300/90 text-sm">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>{{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div
                class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4 border border-green-200 dark:border-green-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-100 dark:bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-500"></i>
                    </div>
                    <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ __('symbol.form_section_title') }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('symbol.form_section_subtitle') }}</p>
            </div>

            <form action="{{ route('symbols.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i
                                class="fas fa-tag text-primary-500 dark:text-primary-400 mr-2"></i>{{ __('symbol.form_name_label') }}
                        </label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg py-3 px-4 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-500/20 dark:focus:ring-primary-400/20 focus:outline-none"
                                placeholder="{{ __('symbol.form_name_placeholder') }}" required>
                            @error('name')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('symbol.form_name_help') }}</p>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Value -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i
                                class="fas fa-coins text-primary-500 dark:text-primary-400 mr-2"></i>{{ __('symbol.form_pip_value_label') }}
                        </label>
                        <div class="relative">
                            <input type="number" step="0.00001" name="pip_value" value="{{ old('pip_value') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg py-3 px-4 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-500/20 dark:focus:ring-primary-400/20 focus:outline-none"
                                placeholder="{{ __('symbol.form_pip_value_placeholder') }}" required>
                            @error('pip_value')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('symbol.form_pip_value_help') }}</p>
                        @error('pip_value')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Worth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i
                                class="fas fa-dollar-sign text-primary-500 dark:text-primary-400 mr-2"></i>{{ __('symbol.form_pip_worth_label') }}
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" name="pip_worth" value="{{ old('pip_worth', 10) }}"
                                class="w-full bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg py-3 px-4 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-500/20 dark:focus:ring-primary-400/20 focus:outline-none"
                                placeholder="{{ __('symbol.form_pip_worth_placeholder') }}">
                            @error('pip_worth')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('symbol.form_pip_worth_help') }}</p>
                        @error('pip_worth')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i
                                class="fas fa-sort-numeric-up text-primary-500 dark:text-primary-400 mr-2"></i>{{ __('symbol.form_pip_position_label') }}
                        </label>
                        <div class="relative">
                            <input type="text" name="pip_position" value="{{ old('pip_position') }}"
                                class="w-full bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg py-3 px-4 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-500/20 dark:focus:ring-primary-400/20 focus:outline-none"
                                placeholder="{{ __('symbol.form_pip_position_placeholder') }}">
                            @error('pip_position')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('symbol.form_pip_position_help') }}
                        </p>
                        @error('pip_position')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div
                            class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="mb-4">
                                <h3 class="font-medium text-gray-700 dark:text-gray-300">
                                    <i
                                        class="fas fa-power-off text-primary-500 dark:text-primary-400 mr-2"></i>{{ __('symbol.form_status_label') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ __('symbol.form_status_help') }}</p>
                            </div>

                            <div class="space-y-3">
                                <!-- Active Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="1" class="hidden peer"
                                        {{ old('active', 1) == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-5 h-5 border-2 border-gray-400 dark:border-gray-600 rounded-full mr-3 flex items-center justify-center
                    peer-checked:border-primary-500 dark:peer-checked:border-primary-400 peer-checked:bg-primary-500 dark:peer-checked:bg-primary-400">
                                        <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <span
                                            class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.status_active') }}</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ __('symbol.status_active_description') }}
                                        </p>
                                    </div>
                                </label>

                                <!-- Inactive Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="0" class="hidden peer"
                                        {{ old('active', 1) == 0 ? 'checked' : '' }}>
                                    <div
                                        class="w-5 h-5 border-2 border-gray-400 dark:border-gray-600 rounded-full mr-3 flex items-center justify-center
                    peer-checked:border-red-500 dark:peer-checked:border-red-400 peer-checked:bg-red-500 dark:peer-checked:bg-red-400">
                                        <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <span
                                            class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.status_inactive') }}</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ __('symbol.status_inactive_description') }}</p>
                                    </div>
                                </label>
                            </div>

                            @error('active')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between gap-4">
                    <div>
                        <a href="{{ route('symbols.index') }}"
                            class="flex items-center bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 px-6 rounded-lg border border-gray-200 dark:border-gray-700">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('symbol.cancel_button') }}
                        </a>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="window.location.href='{{ route('symbols.index') }}'"
                            class="flex items-center bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 px-6 rounded-lg border border-gray-200 dark:border-gray-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('symbol.back_button') }}
                        </button>
                        <button type="submit"
                            class="flex items-center bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white py-3 px-6 rounded-lg font-medium">
                            <i class="fas fa-plus-circle mr-2"></i>
                            {{ __('symbol.submit_button') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-300 mb-4">
                <i class="fas fa-lightbulb text-amber-500 dark:text-amber-400 mr-2"></i>{{ __('symbol.tips_title') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-2">
                        <div class="bg-primary-100 dark:bg-primary-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-info-circle text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.tip_format_title') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{!! __('symbol.tip_format_description') !!}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-2">
                        <div class="bg-green-100 dark:bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-calculator text-green-600 dark:text-green-400"></i>
                        </div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.tip_pip_value_title') }}
                        </h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{!! __('symbol.tip_pip_value_description') !!}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-100 dark:bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-dollar-sign text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.tip_pip_worth_title') }}
                        </h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{!! __('symbol.tip_pip_worth_description') !!}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-2">
                        <div class="bg-amber-100 dark:bg-amber-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400"></i>
                        </div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">{{ __('symbol.tip_status_title') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('symbol.tip_status_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle switch text update
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.querySelector('input[name="active"]');
            const toggleText = document.getElementById('statusText');

            if (toggleSwitch && toggleText) {
                toggleSwitch.addEventListener('change', function() {
                    toggleText.textContent = this.checked ?
                        '{{ __('symbol.status_active') }}' :
                        '{{ __('symbol.status_inactive') }}';
                });
            }

            // Input validation styling
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '' && this.required) {
                        this.classList.add('border-red-500', 'dark:border-red-400');
                    } else {
                        this.classList.remove('border-red-500', 'dark:border-red-400');
                    }
                });

                // Real-time validation for pip position
                if (input.name === 'pip_position') {
                    input.addEventListener('input', function() {
                        const value = this.value.trim();
                        if (value === '' || (['2', '3', '4', '5'].includes(value))) {
                            this.classList.remove('border-red-500', 'dark:border-red-400');
                            this.classList.add('border-green-500', 'dark:border-green-400');
                        } else {
                            this.classList.remove('border-green-500', 'dark:border-green-400');
                            this.classList.add('border-red-500', 'dark:border-red-400');
                        }
                    });
                }
            });
        });
    </script>

    <style>
        /* Custom checkbox toggle */
        input[name="active"]:checked+div {
            background-color: #2563eb;
        }

        .dark input[name="active"]:checked+div {
            background-color: #3b82f6;
        }

        /* Smooth transitions */
        input,
        button,
        a {
            transition: all 0.2s ease-in-out;
        }

        /* Focus states */
        input:focus,
        button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .dark input:focus,
        .dark button:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Code styling */
        code {
            padding: 0.1rem 0.3rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
@endsection
