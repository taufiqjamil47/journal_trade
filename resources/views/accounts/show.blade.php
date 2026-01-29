@extends('Layouts.Index')

@section('title', 'Account Details')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ __('accounts.view.account_overview') }}
                            #{{ $account->id }}</h1>
                        <p class="text-gray-400">{{ __('accounts.view.account_details') }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('accounts.edit', $account->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            {{ __('accounts.view.edit_account') }}
                        </a>
                        <a href="{{ route('accounts.index') }}"
                            class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                            <i class="fas fa-arrow-left"></i>
                            {{ __('accounts.view.back_to_accounts') }}
                        </a>
                    </div>
                </div>

                <!-- Account Details Card -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Basic Info -->
                    <div class="bg-dark-800 rounded-lg shadow-lg p-8 border border-gray-700">
                        <h2 class="text-xl font-bold text-white mb-6">{{ __('accounts.view.account_info') }}</h2>

                        <div class="space-y-4">
                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.account_id') }}</p>
                                <p class="text-white text-lg font-semibold">#{{ $account->id }}</p>
                            </div>

                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.initial_balance') }}</p>
                                <p class="text-primary-400 text-2xl font-bold">
                                    {{ number_format($account->initial_balance, 2) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.currency') }}</p>
                                <p class="text-white text-lg font-semibold">{{ $account->currency }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="bg-dark-800 rounded-lg shadow-lg p-8 border border-gray-700">
                        <h2 class="text-xl font-bold text-white mb-6">{{ __('accounts.view.metadata') }}</h2>

                        <div class="space-y-4">
                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.created_at') }}</p>
                                <p class="text-white text-lg font-semibold">
                                    {{ $account->created_at->format('Y-m-d H:i:s') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.last_updated') }}</p>
                                <p class="text-white text-lg font-semibold">
                                    {{ $account->updated_at->format('Y-m-d H:i:s') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-400 text-sm">{{ __('accounts.view.total_trades') }}</p>
                                <p class="text-white text-lg font-semibold">{{ $account->trades()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-500/10 border border-red-500 rounded-lg p-8">
                    <h2 class="text-xl font-bold text-red-400 mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __('accounts.view.danger_zone') }}
                    </h2>
                    <p class="text-gray-400 mb-6">{{ __('accounts.view.delete_account_info') }}</p>

                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2"
                            onclick="return confirm('Are you absolutely sure? This action cannot be undone.');">
                            <i class="fas fa-trash"></i>
                            {{ __('accounts.view.delete_account_button') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
