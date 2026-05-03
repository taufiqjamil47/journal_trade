<!-- Account Selector Component - Responsive Fix for Mobile -->
<div class="flex items-center relative">
    <button id="accountToggle"
        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-3 sm:px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 active:scale-95 transition-transform group"
        title="Switch Account">
        <i class="fas fa-building text-primary-500 mr-2"></i>
        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
            @php
                $name = $selectedAccount->name ?? 'Select Account';
                $words = explode(' ', $name);
                $abbreviated =
                    count($words) >= 2
                        ? substr($words[0], 0, 3) . ' ' . substr($words[1], 0, 3)
                        : substr($words[0], 0, 3);
            @endphp
            {{ $abbreviated }}
        </span>
        <i class="fas fa-chevron-down text-primary-500 ml-2 transition-transform duration-300" id="accountToggleIcon"></i>
    </button>

    <!-- Account List Dropdown - Repositioned outside button for better control -->
    <div id="accountDropdown"
        class="hidden fixed sm:absolute top-auto sm:top-full left-0 right-0 sm:left-auto sm:right-0 mt-2 sm:mt-2 mx-4 sm:mx-0 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-xl z-[9999] sm:min-w-[320px] w-auto sm:w-auto">

        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Trading Accounts</p>
        </div>

        <div class="max-h-[300px] overflow-y-auto">
            @foreach ($allAccounts as $account)
                <a href="?account_id={{ $account->id }}"
                    class="flex flex-col px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 duration-200 border-b border-gray-100 dark:border-gray-700 last:border-b-0
                    {{ $selectedAccount?->id === $account->id ? 'bg-primary-50 dark:bg-primary-900/30 border-l-4 dark:border-l-green-500 border-l-primary-500' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ $account->name }}</span>
                        @if ($selectedAccount?->id === $account->id)
                            <i class="fas fa-check text-primary-500 text-xs"></i>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $account->description ?? '-' }}</p>
                    <div class="flex justify-between items-center mt-2 text-xs">
                        <span class="text-gray-600 dark:text-gray-400">
                            <i
                                class="fas fa-dollar-sign text-green-500 mr-1"></i>{{ number_format($account->initial_balance, 2) }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-500">{{ $account->currency }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="p-2 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('accounts.index') }}"
                class="flex items-center w-full px-4 py-2 text-xs text-primary-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <i class="fas fa-cog mr-2"></i>
                Manage Accounts
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountToggle = document.getElementById('accountToggle');
        const accountToggleIcon = document.getElementById('accountToggleIcon');
        const accountDropdown = document.getElementById('accountDropdown');

        function closeDropdown() {
            if (accountDropdown) {
                accountDropdown.classList.add('hidden');
                if (accountToggleIcon) {
                    accountToggleIcon.classList.remove('rotate-180');
                }
            }
        }

        function openDropdown() {
            if (accountDropdown) {
                accountDropdown.classList.remove('hidden');
                if (accountToggleIcon) {
                    accountToggleIcon.classList.add('rotate-180');
                }
            }
        }

        function isDropdownOpen() {
            return accountDropdown && !accountDropdown.classList.contains('hidden');
        }

        // Toggle dropdown
        if (accountToggle) {
            accountToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (isDropdownOpen()) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (accountToggle && accountDropdown && !accountToggle.contains(e.target) && !
                accountDropdown.contains(e.target)) {
                closeDropdown();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        // Optional: Reposition on window resize (for mobile to desktop transition)
        window.addEventListener('resize', function() {
            // If dropdown is open and we switch from mobile to desktop, keep it functional
            // No additional action needed, CSS handles layout
        });
    });
</script>

<style>
    /* Additional fix for mobile to ensure dropdown is readable */
    @media (max-width: 640px) {
        #accountDropdown:not(.hidden) {
            display: block;
            position: fixed;
            top: auto;
            bottom: auto;
            left: 16px;
            right: 16px;
            max-width: calc(100% - 32px);
            margin: 0 auto;
        }

        /* Better touch target for mobile */
        #accountDropdown a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }
</style>
