@extends('Layouts.index')
@section('title', __('symbol.edit_title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('symbol.edit_header_title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('symbol.edit_header_subtitle') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('symbols.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-list text-primary-500 mr-2"></i>
                        <span>{{ __('symbol.back_to_list') }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if ($errors->any())
            <div class="bg-red-900/30 rounded-lg p-4 border border-red-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-red-300 font-medium mb-1">{{ __('symbol.form_error_title') }}</p>
                        <ul class="text-red-300/90 text-sm">
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
            <div class="bg-green-900/30 rounded-lg p-4 border border-green-700/30 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <span class="text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="container bg-gray-800 rounded-xl border border-gray-700 p-6 w-[100%] md:w-3/4 lg:w-2/3 mx-auto mb-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">{{ __('symbol.form_info_title') }}</h2>
                <p class="text-gray-500 text-sm">{{ __('symbol.form_id_label') }} <span
                        class="font-mono text-gray-400">{{ $symbol->id }}</span>
                </p>
            </div>

            <form action="{{ route('symbols.update', $symbol->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-tag text-primary-500 mr-2"></i>{{ __('symbol.form_name_label') }}
                        </label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name', $symbol->name) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="{{ __('symbol.form_name_placeholder') }}" required>
                            @error('name')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Value -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-coins text-primary-500 mr-2"></i>{{ __('symbol.form_pip_value_label') }}
                        </label>
                        <div class="relative">
                            <input type="number" step="0.00001" name="pip_value"
                                value="{{ old('pip_value', format_price($symbol->pip_value)) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="{{ __('symbol.form_pip_value_placeholder') }}" required>
                            @error('pip_value')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">{{ __('symbol.edit_pip_value_help') }}</p>
                        @error('pip_value')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Worth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign text-primary-500 mr-2"></i>{{ __('symbol.form_pip_worth_label') }}
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" name="pip_worth"
                                value="{{ old('pip_worth', $symbol->pip_worth ?? 10) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="{{ __('symbol.form_pip_worth_placeholder') }}">
                            @error('pip_worth')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">{{ __('symbol.edit_pip_worth_help') }}</p>
                        @error('pip_worth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i
                                class="fas fa-sort-numeric-up text-primary-500 mr-2"></i>{{ __('symbol.form_pip_position_label') }}
                        </label>
                        <div class="relative">
                            <input type="text" name="pip_position"
                                value="{{ old('pip_position', $symbol->pip_position) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="{{ __('symbol.form_pip_position_placeholder') }}">
                            @error('pip_position')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">{{ __('symbol.edit_pip_position_help') }}</p>
                        @error('pip_position')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-900/40 rounded-xl p-5 border border-gray-800 shadow-lg">
                            <div class="mb-4">
                                <h3 class="font-semibold text-gray-100 text-lg mb-1">
                                    {{ __('symbol.edit_status_title') }}
                                </h3>
                                <p class="text-sm text-gray-400">{{ __('symbol.edit_status_subtitle') }}</p>
                            </div>

                            <div class="grid grid-cols-1 space-y-2 lg:space-y-0 lg:grid-cols-2  items-center">
                                <!-- Active Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="1" class="hidden peer"
                                        {{ old('active', $symbol->active) == 1 ? 'checked' : '' }}>
                                    <div
                                        class="w-5 h-5 border-2 border-gray-600 rounded-full mr-3 flex items-center justify-center peer-checked:border-primary-500 peer-checked:bg-primary-500">
                                        <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-300">{{ __('symbol.status_active') }}</span>
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs bg-green-500/20 text-green-400 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Enabled
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">{{ __('symbol.status_active_description') }}
                                        </p>
                                    </div>
                                </label>

                                <!-- Inactive Option -->
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="0" class="hidden peer"
                                        {{ old('active', $symbol->active) == 0 ? 'checked' : '' }}>
                                    <div
                                        class="w-5 h-5 border-2 border-gray-600 rounded-full mr-3 flex items-center justify-center peer-checked:border-red-500 peer-checked:bg-red-500">
                                        <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <span
                                                class="font-medium text-gray-300">{{ __('symbol.status_inactive') }}</span>
                                            <span class="ml-2 px-2 py-0.5 text-xs bg-red-500/20 text-red-400 rounded-full">
                                                <i class="fas fa-times mr-1"></i>Disabled
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ __('symbol.status_inactive_description') }}</p>
                                    </div>
                                </label>
                            </div>

                            @error('active')
                                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg">
                                    <p class="text-sm text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-700 flex flex-col md:flex-row justify-between gap-4">
                    <div>
                        <a href="{{ route('symbols.index') }}"
                            class="flex items-center bg-gray-800 hover:bg-gray-700 text-gray-300 py-3 px-6 rounded-lg border border-gray-700 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('symbol.cancel_button') }}
                        </a>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="window.location.href='{{ route('symbols.index') }}'"
                            class="flex items-center bg-gray-800 hover:bg-gray-700 text-gray-300 py-3 px-6 rounded-lg border border-gray-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('symbol.back_button') }}
                        </button>
                        <button type="submit"
                            class="flex items-center bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            {{ __('symbol.edit_submit_button') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Current Symbol Info -->
        <div class="mt-6 bg-gray-800 rounded-xl border border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-300 mb-4">
                <i class="fas fa-info-circle text-primary-500 mr-2"></i>{{ __('symbol.current_info_title') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">{{ __('symbol.current_symbol_label') }}</p>
                    <p class="text-white font-medium">{{ $symbol->name }}</p>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">{{ __('symbol.current_pip_value_label') }}</p>
                    <p class="text-white font-medium">{{ format_price($symbol->pip_value) }}</p>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">{{ __('symbol.current_status_label') }}</p>
                    <span class="{{ $symbol->active ? 'text-green-400' : 'text-red-400' }} font-medium">
                        <i class="fas {{ $symbol->active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                        {{ $symbol->active ? __('symbol.status_active') : __('symbol.status_inactive') }}
                    </span>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">{{ __('symbol.last_updated_label') }}</p>
                    <p class="text-white font-medium">{{ $symbol->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memperbarui status toggle switch
        function updateActiveStatus() {
            const checkbox = document.getElementById('active_checkbox');
            const hiddenInput = document.getElementById('active_hidden');
            const statusBadge = document.getElementById('status_badge');
            const mobileBadge = document.getElementById('mobile_status_badge');

            // Pastikan checkbox dalam keadaan yang benar
            const isChecked = checkbox.checked;

            // Update hidden input value sesuai dengan checkbox
            hiddenInput.value = isChecked ? '1' : '0';

            // Update badge appearance
            if (isChecked) {
                statusBadge.className = 'px-3 py-1.5 rounded-full text-sm font-medium bg-green-500/20 text-green-400';
                statusBadge.innerHTML = '<i class="fas fa-check-circle mr-1.5"></i>{{ __('symbol.status_active') }}';

                mobileBadge.className = 'px-3 py-1.5 rounded-full text-sm font-medium bg-green-500/20 text-green-400';
                mobileBadge.innerHTML = '<i class="fas fa-check-circle mr-1.5"></i>{{ __('symbol.status_active') }}';
            } else {
                statusBadge.className = 'px-3 py-1.5 rounded-full text-sm font-medium bg-red-500/20 text-red-400';
                statusBadge.innerHTML = '<i class="fas fa-times-circle mr-1.5"></i>{{ __('symbol.status_inactive') }}';

                mobileBadge.className = 'px-3 py-1.5 rounded-full text-sm font-medium bg-red-500/20 text-red-400';
                mobileBadge.innerHTML = '<i class="fas fa-times-circle mr-1.5"></i>{{ __('symbol.status_inactive') }}';
            }
        }

        // Event listener untuk toggle switch
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('active_checkbox');
            const hiddenInput = document.getElementById('active_hidden');

            // Inisialisasi status awal
            updateActiveStatus();

            // Tambahkan event listener untuk perubahan checkbox
            checkbox.addEventListener('change', function() {
                updateActiveStatus();
            });

            // Pastikan hidden input selalu sinkron dengan checkbox
            checkbox.addEventListener('click', function() {
                // Ini memastikan bahwa ketika checkbox diklik, nilainya sudah diperbarui
                setTimeout(() => {
                    hiddenInput.value = this.checked ? '1' : '0';
                }, 10);
            });
        });

        // Input validation styling
        document.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-700');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-700');
                }
            });
        });
    </script>

    <style>
        /* Custom checkbox toggle styling */
        .peer:checked+div {
            background-color: #2563eb !important;
        }

        /* Smooth transitions */
        input,
        button,
        a,
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* Focus states */
        input:focus,
        button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Hover effects for toggle */
        .group:hover .peer+div {
            background-color: #4b5563;
        }

        .group:hover .peer:checked+div {
            background-color: #1d4ed8 !important;
        }
    </style>
@endsection
