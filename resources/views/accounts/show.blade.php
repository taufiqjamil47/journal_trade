@extends('Layouts.index')
@section('title', 'Account Details')
@section('content')
    <div class="container mx-auto px-4 py-6 max-w-4xl">
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
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('accounts.index') }}"
                        class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Accounts
                    </a>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('accounts.edit', $account) }}"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Account
                    </a>
                    <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this account?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete Account
                        </button>
                    </form>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-primary-500 mt-4">
                Account #{{ $account->id }}
            </h1>
        </header>

        <!-- Account Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-primary-500"></i>Basic Information
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Account ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $account->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Initial Balance</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ number_format($account->initial_balance, 2) }} {{ $account->currency }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Currency</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $account->currency }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Commission per Lot</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            ${{ number_format($account->commission_per_lot, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-clock mr-2 text-primary-500"></i>Timestamps
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $account->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $account->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Trades -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-chart-line mr-2 text-primary-500"></i>Related Trades
            </h2>

            @if ($account->trades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    ID</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Symbol</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Type</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Lots</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Date</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($account->trades->take(10) as $trade)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $trade->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">
                                        {{ $trade->symbol->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $trade->type === 'buy' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ ucfirst($trade->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">{{ $trade->lot_size }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($trade->timestamp)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="{{ route('trades.show', $trade) }}"
                                            class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($account->trades->count() > 10)
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Showing 10 of {{ $account->trades->count() }}
                            trades</p>
                    </div>
                @endif
            @else
                <p class="text-gray-500 dark:text-gray-400">No trades found for this account.</p>
            @endif
        </div>
    </div>
@endsection
