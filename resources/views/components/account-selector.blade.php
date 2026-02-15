<!-- Account Selector Component -->
<div class="flex items-center">
    <button id="accountToggle"
        class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-2 border border-gray-200 dark:border-gray-700 hover:border-primary-500 active:scale-95 group relative z-[60]"
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

        <!-- Account List Dropdown -->
        <div id="accountDropdown"
            class="hidden absolute top-full mt-2 right-0 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-lg z-[60] min-w-[280px]">
            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Trading Accounts</p>
            </div>

            <div class="max-h-[300px] overflow-y-auto">
                @foreach ($allAccounts as $account)
                    <a href="?account_id={{ $account->id }}"
                        class="flex flex-col px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 border-b border-gray-100 dark:border-gray-700 last:border-b-0
                        {{ $selectedAccount?->id === $account->id ? 'bg-primary-50 dark:bg-primary-900/30 border-l-4 border-l-primary-500 dark:border-l-green-500' : '' }}">
                        <div class="flex items-center justify-between mb-1">
                            <span
                                class="font-semibold text-sm text-gray-900 dark:text-white">{{ $account->name }}</span>
                            @if ($selectedAccount?->id === $account->id)
                                <i class="fas fa-check text-primary-500 text-xs"></i>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $account->description ?? '-' }}
                        </p>
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
                    class="flex items-center w-full px-4 py-2 text-xs text-primary-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors">
                    <i class="fas fa-cog mr-2"></i>
                    Manage Accounts
                </a>
            </div>
        </div>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountToggle = document.getElementById('accountToggle');
        const accountToggleIcon = document.getElementById('accountToggleIcon');
        const accountDropdown = document.getElementById('accountDropdown');

        // Toggle dropdown
        accountToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            accountDropdown.classList.toggle('hidden');
            accountToggleIcon.classList.toggle('rotate-180');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!accountToggle.contains(e.target) && !accountDropdown.contains(e.target)) {
                accountDropdown.classList.add('hidden');
                accountToggleIcon.classList.remove('rotate-180');
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                accountDropdown.classList.add('hidden');
                accountToggleIcon.classList.remove('rotate-180');
            }
        });
    });
</script>
