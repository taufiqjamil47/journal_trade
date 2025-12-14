@extends('Layouts.index')
@section('title', 'Edit Symbol')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Edit Symbol
                    </h1>
                    <p class="text-gray-500 mt-1">Perbarui informasi simbol perdagangan</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('symbols.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-list text-primary-500 mr-2"></i>
                        <span>Daftar Symbols</span>
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
                        <p class="text-red-300 font-medium mb-1">Terdapat kesalahan dalam pengisian form:</p>
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
        <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Informasi Symbol</h2>
                <p class="text-gray-500 text-sm">ID: <span class="font-mono text-gray-400">{{ $symbol->id }}</span></p>
            </div>

            <form action="{{ route('symbols.update', $symbol->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-tag text-primary-500 mr-2"></i>Symbol Name
                        </label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name', $symbol->name) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="Contoh: EURUSD" required>
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
                            <i class="fas fa-coins text-primary-500 mr-2"></i>Pip Value
                        </label>
                        <div class="relative">
                            <input type="number" step="0.00001" name="pip_value"
                                value="{{ old('pip_value', format_price($symbol->pip_value)) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="Contoh: 0.0001" required>
                            @error('pip_value')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Nilai per pip dalam mata uang quote</p>
                        @error('pip_value')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Worth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign text-primary-500 mr-2"></i>Pip Worth (USD per pip per 1 lot)
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" name="pip_worth"
                                value="{{ old('pip_worth', $symbol->pip_worth ?? 10) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="Contoh: 10.00">
                            @error('pip_worth')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Nilai USD per pip untuk 1 lot standar</p>
                        @error('pip_worth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pip Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-sort-numeric-up text-primary-500 mr-2"></i>Pip Position
                        </label>
                        <div class="relative">
                            <input type="text" name="pip_position"
                                value="{{ old('pip_position', $symbol->pip_position) }}"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-colors"
                                placeholder="Contoh: 4 (untuk kebanyakan pasangan)">
                            @error('pip_position')
                                <div class="absolute right-3 top-3 text-red-500">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Posisi desimal untuk pip (biasanya 4 untuk forex)</p>
                        @error('pip_position')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-300">
                                        <i class="fas fa-power-off text-primary-500 mr-2"></i>Status Symbol
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">Tentukan apakah simbol ini aktif untuk trading</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="active" value="0">
                                    <input type="checkbox" name="active" value="1" class="sr-only peer"
                                        {{ old('active', $symbol->active) ? 'checked' : '' }}>
                                    <div
                                        class="w-12 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-6 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600">
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-300">
                                        {{ old('active', $symbol->active) ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </label>
                            </div>
                            @error('active')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
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
                            Batal
                        </a>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="window.location.href='{{ route('symbols.index') }}'"
                            class="flex items-center bg-gray-800 hover:bg-gray-700 text-gray-300 py-3 px-6 rounded-lg border border-gray-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </button>
                        <button type="submit"
                            class="flex items-center bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Current Symbol Info -->
        <div class="mt-6 bg-gray-800 rounded-xl border border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-300 mb-4">
                <i class="fas fa-info-circle text-primary-500 mr-2"></i>Informasi Saat Ini
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">Symbol</p>
                    <p class="text-white font-medium">{{ $symbol->name }}</p>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">Pip Value</p>
                    <p class="text-white font-medium">{{ format_price($symbol->pip_value) }}</p>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="{{ $symbol->active ? 'text-green-400' : 'text-red-400' }} font-medium">
                        <i class="fas {{ $symbol->active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                        {{ $symbol->active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-700">
                    <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                    <p class="text-white font-medium">{{ $symbol->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle switch text update
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.querySelector('input[name="active"]');
            const toggleText = toggleSwitch.nextElementSibling.nextElementSibling;

            toggleSwitch.addEventListener('change', function() {
                toggleText.textContent = this.checked ? 'Aktif' : 'Nonaktif';
            });
        });

        // Input validation styling
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.required) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        });
    </script>

    <style>
        /* Custom checkbox toggle */
        input[name="active"]:checked+div {
            background-color: #2563eb;
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
    </style>
@endsection
