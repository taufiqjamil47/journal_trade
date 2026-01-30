@extends('Layouts.index')
@section('title', 'Accounts')
@section('content')
    <div class="container mx-auto px-4 py-6">
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
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('trades.header_title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('trades.header_subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Toggle Button -->
                    <button id="navToggle"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-all duration-300  active:scale-95"
                        data-nav-state-save="true">
                        <i id="navToggleIcon" class="fas fa-chevron-right text-primary-500 mr-2 nav-toggle-icon"></i>
                    </button>

                    <!-- Navigation Items Container -->
                    <div id="navItems"
                        class="hidden nav-items-container opacity-0 scale-95 transform transition-all duration-300">
                        <div class="flex items-center space-x-1 bg-gray-800 rounded-lg p-1 border border-gray-700">
                            <!-- Dashboard Link -->
                            @if (!request()->routeIs('dashboard'))
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}"
                                    title="Dashboard" data-nav-state-save="true">
                                    <i
                                        class="fas fa-home text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.dashboard') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Calendar Link -->
                            @if (!request()->routeIs('reports.calendar'))
                                <a href="{{ route('reports.calendar') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Calendar" data-nav-state-save="true">
                                    <i
                                        class="fas fa-calendar text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.calendar') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Analysis Link -->
                            @if (!request()->routeIs('analysis.*'))
                                <a href="{{ route('analysis.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Analysis" data-nav-state-save="true">
                                    <i
                                        class="fa-solid fa-magnifying-glass-chart text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.analysis') }}
                                    </span>
                                </a>
                            @endif

                            <div class="h-6 w-px bg-gray-600 transition-all duration-300"></div>

                            <!-- Trades Link -->
                            @if (!request()->routeIs('trades.*'))
                                <a href="{{ route('trades.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Trades" data-nav-state-save="true">
                                    <i
                                        class="fas fa-chart-line text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.trades') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Sessions Link -->
                            @if (!request()->routeIs('sessions.*'))
                                <a href="{{ route('sessions.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Sessions" data-nav-state-save="true">
                                    <i
                                        class="fas fa-clock text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.sessions') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Symbols Link -->
                            @if (!request()->routeIs('symbols.*'))
                                <a href="{{ route('symbols.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Symbols" data-nav-state-save="true">
                                    <i
                                        class="fas fa-money-bill-transfer text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.symbols') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Rules Link -->
                            @if (!request()->routeIs('trading-rules.*'))
                                <a href="{{ route('trading-rules.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Rules" data-nav-state-save="true">
                                    <i
                                        class="fas fa-list text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.rules') }}
                                    </span>
                                </a>
                            @endif

                            <!-- Account Link - Ditambahkan setelah Rules Link -->
                            @if (!request()->routeIs('accounts.*'))
                                <a href="{{ route('accounts.index') }}"
                                    class="nav-link flex items-center justify-center w-10 h-10 rounded-md hover:bg-gray-700 transition-all duration-200 group relative"
                                    title="Account" data-nav-state-save="true">
                                    <i
                                        class="fas fa-user text-primary-500 transition-transform duration-200 group-hover:scale-110"></i>
                                    <span class="tooltip">
                                        {{ __('nav_header.nav.accounts') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Trader Item dengan animasi muncul -->
                    <div
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 transition-all duration-300 hover:border-primary-500 ">
                        <i class="fas fa-user text-primary-500 mr-2 transition-transform duration-200 hover:scale-110"></i>
                        <span class="transition-all duration-200">Trader</span>
                    </div>
                </div>
            </div>
        </header>
        <div class="mb-6 flex flex-col md:flex-row justify-end items-start md:items-center gap-4">
            <div class="flex gap-3">
                <a href="{{ route('accounts.create') }}"
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add Account
                </a>
            </div>
        </div>

        <!-- Accounts Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Initial Balance</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Currency</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Commission per Lot</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Created</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($accounts as $account)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $account->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ number_format($account->initial_balance, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $account->currency }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    ${{ number_format($account->commission_per_lot, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $account->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('accounts.show', $account) }}"
                                            class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('accounts.edit', $account) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this account?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No accounts found. <a href="{{ route('accounts.create') }}"
                                        class="text-primary-600 hover:text-primary-900">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($accounts->hasPages())
            <div class="mt-6">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
@endsection
