@extends('Layouts.Index')

@section('title', 'Create Account')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="p-6">
            <div class="max-w-2xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ __('accounts.create.create_account') }}</h1>
                    <p class="text-gray-400">{{ __('accounts.create.account_info') }}</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-dark-800 rounded-lg shadow-lg p-8 border border-gray-700">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf

                        <!-- Initial Balance -->
                        <div class="mb-6">
                            <label for="initial_balance" class="block text-sm font-semibold text-gray-300 mb-2">
                                {{ __('accounts.create.initial_balance') }}
                            </label>
                            <input type="number" id="initial_balance" name="initial_balance" step="0.01" min="0"
                                class="w-full px-4 py-3 bg-dark-900 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition"
                                placeholder="Enter initial balance" value="{{ old('initial_balance') }}" required>
                            @error('initial_balance')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div class="mb-8">
                            <label for="currency" class="block text-sm font-semibold text-gray-300 mb-2">
                                {{ __('accounts.create.currency') }}
                            </label>
                            <select id="currency" name="currency"
                                class="w-full px-4 py-3 bg-dark-900 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition"
                                required>
                                <option value="">Select a currency</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar
                                </option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound
                                </option>
                                <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen
                                </option>
                                <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian
                                    Dollar
                                </option>
                                <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD - Australian
                                    Dollar
                                </option>
                                <option value="CHF" {{ old('currency') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc
                                </option>
                                <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan
                                </option>
                                <option value="SGD" {{ old('currency') == 'SGD' ? 'selected' : '' }}>SGD - Singapore
                                    Dollar
                                </option>
                                <option value="IDR" {{ old('currency') == 'IDR' ? 'selected' : '' }}>IDR - Indonesian
                                    Rupiah
                                </option>
                            </select>
                            @error('currency')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                {{ __('accounts.create.create_account_button') }}
                            </button>
                            <a href="{{ route('accounts.index') }}"
                                class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-times"></i>
                                {{ __('accounts.create.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
