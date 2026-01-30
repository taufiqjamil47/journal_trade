@extends('Layouts.index')
@section('title', 'Create Account')
@section('content')
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        <!-- Header -->
        <header class="mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('accounts.index') }}"
                    class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Accounts
                </a>
            </div>
            <h1 class="text-2xl font-bold text-primary-500 mt-4">
                Create New Account
            </h1>
        </header>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Initial Balance -->
                    <div>
                        <label for="initial_balance"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Initial Balance *
                        </label>
                        <input type="number" step="0.01" name="initial_balance" id="initial_balance"
                            value="{{ old('initial_balance') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            required>
                        @error('initial_balance')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Currency *
                        </label>
                        <select name="currency" id="currency"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            required>
                            <option value="">Select Currency</option>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                            <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY</option>
                            <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD</option>
                            <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD</option>
                        </select>
                        @error('currency')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commission per Lot -->
                    <div>
                        <label for="commission_per_lot"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Commission per Lot ($)
                        </label>
                        <input type="number" step="0.01" name="commission_per_lot" id="commission_per_lot"
                            value="{{ old('commission_per_lot', 1.0) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Default is $1.00 per lot</p>
                        @error('commission_per_lot')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('accounts.index') }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md transition-colors">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
