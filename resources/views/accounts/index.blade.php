@extends('Layouts.Index')

@section('title', 'Accounts')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        {{ __('accounts.title') }}
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('accounts.subtitle') }}</p>
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

        <div class="p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ __('accounts.index.accounts') }}</h1>
                        <p class="text-gray-400">{{ __('accounts.index.info') }}</p>
                    </div>
                    <a href="{{ route('accounts.create') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        {{ __('accounts.index.add_account') }}
                    </a>
                </div>

                <!-- Success Message -->
                @if ($message = Session::get('success'))
                    <div
                        class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        {{ $message }}
                    </div>
                @endif

                <!-- Accounts Table -->
                <div class="bg-dark-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                    @if ($accounts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-dark-900 border-b border-gray-700">
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">ID</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">
                                            {{ __('accounts.index.initial_balance') }}
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">
                                            {{ __('accounts.index.currency') }}</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-400">
                                            {{ __('accounts.index.created_at') }}</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-400">
                                            {{ __('accounts.index.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr class="border-b border-gray-700 hover:bg-dark-700 transition">
                                            <td class="px-6 py-4 text-white font-medium">#{{ $account->id }}</td>
                                            <td class="px-6 py-4 text-white">
                                                <span class="text-primary-400 font-semibold">
                                                    {{ number_format($account->initial_balance, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-300">{{ $account->currency }}</td>
                                            <td class="px-6 py-4 text-gray-400 text-sm">
                                                {{ $account->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end gap-3">
                                                    <a href="{{ route('accounts.show', $account->id) }}"
                                                        class="text-primary-400 hover:text-primary-300 transition"
                                                        title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('accounts.edit', $account->id) }}"
                                                        class="text-blue-400 hover:text-blue-300 transition" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('accounts.destroy', $account->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-400 hover:text-red-300 transition"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-inbox text-gray-600 text-4xl mb-4 block"></i>
                            <p class="text-gray-400 text-lg">{{ __('accounts.index.no_accounts') }}</p>
                            <a href="{{ route('accounts.create') }}"
                                class="text-primary-500 hover:text-primary-400 mt-4 inline-block">
                                {{ __('accounts.index.create_first_account') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
