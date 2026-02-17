@extends('Layouts.index')
@section('title', __('rules.title'))
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ __('rules.header.title') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('rules.header.subtitle') }}</p>
                </div>

                <!-- Navigation and Trader Info -->
                @include('components.navbar-selector')
            </div>
        </header>

        <!-- Stats Cards - Consistent with trades index -->
        @if ($rules->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-primary-100 dark:bg-primary-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-list text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('rules.stats.total_rules') }}</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $rules->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('rules.stats.active_rules') }}</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $rules->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-red-100 dark:bg-red-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-pause-circle text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('rules.stats.inactive_rules') }}</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $rules->where('is_active', false)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-history text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('rules.stats.last_updated') }}</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $rules->sortByDesc('updated_at')->first()->updated_at->diffForHumans() ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Rules Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ __('rules.table.title') }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            {{ __('rules.table.total', ['count' => $rules->total()]) }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Search Input -->
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="{{ __('rules.table.search_placeholder') }}"
                                class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500/50 w-48 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        </div>

                        <!-- Sorting Dropdown -->
                        <div class="relative">
                            <button id="sortDropdownButton"
                                class="bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium py-2 px-4 rounded-lg flex items-center border border-gray-300 dark:border-gray-600">
                                <i class="fas fa-sort mr-2"></i>
                                {{ __('rules.table.sort_by') }}
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div id="sortDropdown"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 z-10 hidden shadow-lg">
                                <div class="py-1">
                                    <button onclick="sortTable('name', 'asc')"
                                        class="block px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-500/20 hover:text-primary-700 dark:hover:text-primary-300 flex items-center w-full text-left text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-font mr-2 text-primary-500 dark:text-primary-400"></i>
                                        {{ __('rules.table.sort_name_asc') }}
                                    </button>
                                    <button onclick="sortTable('name', 'desc')"
                                        class="block px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-500/20 hover:text-primary-700 dark:hover:text-primary-300 flex items-center w-full text-left text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-font mr-2 text-primary-500 dark:text-primary-400"></i>
                                        {{ __('rules.table.sort_name_desc') }}
                                    </button>
                                    <button onclick="sortTable('order', 'asc')"
                                        class="block px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-500/20 hover:text-primary-700 dark:hover:text-primary-300 flex items-center w-full text-left text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-sort-numeric-up mr-2 text-primary-500 dark:text-primary-400"></i>
                                        {{ __('rules.table.sort_order_asc') }}
                                    </button>
                                    <button onclick="sortTable('order', 'desc')"
                                        class="block px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-500/20 hover:text-primary-700 dark:hover:text-primary-300 flex items-center w-full text-left text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-sort-numeric-down mr-2 text-primary-500 dark:text-primary-400"></i>
                                        {{ __('rules.table.sort_order_desc') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button onclick="openCreateModal()"
                                class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                {{ __('rules.table.add_new_rule') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">#</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('rules.table.columns.name') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('rules.table.columns.description') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('rules.table.columns.status') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('rules.table.columns.order') }}</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('rules.table.columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50" id="rulesTableBody">
                        @forelse($rules as $rule)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-150 rule-item draggable-row"
                                data-id="{{ $rule->id }}" data-name="{{ strtolower($rule->name) }}"
                                data-description="{{ strtolower($rule->description ?? '') }}"
                                data-order="{{ $rule->order }}" draggable="true">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <span
                                            class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium mr-2">
                                            {{ $loop->iteration }}
                                        </span>
                                        <i
                                            class="fas fa-grip-vertical text-gray-400 dark:text-gray-500 cursor-move drag-handle"></i>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $rule->name }}</td>
                                <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $rule->description ? Str::limit($rule->description, 50) : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold {{ $rule->is_active ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/30' : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/30' }}">
                                        {{ $rule->is_active ? __('rules.status.active') : __('rules.status.inactive') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                        {{ $rule->order }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button
                                            onclick="openEditModal({{ $rule->id }}, '{{ $rule->name }}', `{{ $rule->description }}`, {{ $rule->order }}, {{ $rule->is_active ? 'true' : 'false' }})"
                                            class="bg-amber-100 dark:bg-amber-500/20 hover:bg-amber-200 dark:hover:bg-amber-500/30 text-amber-700 dark:text-amber-400 p-2 rounded-lg"
                                            title="{{ __('rules.actions.edit') }}">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button onclick="deleteRule({{ $rule->id }}, '{{ $rule->name }}')"
                                            class="bg-red-100 dark:bg-red-500/20 hover:bg-red-200 dark:hover:bg-red-500/30 text-red-700 dark:text-red-400 p-2 rounded-lg"
                                            title="{{ __('rules.actions.delete') }}">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-full p-4 mb-3">
                                            <i class="fas fa-list text-gray-400 dark:text-gray-500 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('rules.table.empty.title') }}
                                        </h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                                            {{ __('rules.table.empty.message') }}
                                        </p>
                                        <button onclick="openCreateModal()"
                                            class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
                                            {{ __('rules.table.empty.add_first_rule') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($rules->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                    {{ $rules->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        <!-- Quick Tips -->
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="bg-amber-100 dark:bg-amber-500/20 p-2 rounded-lg mr-3">
                    <i class="fas fa-lightbulb text-amber-600 dark:text-amber-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('rules.tips.title') }}
                    </h3>
                    <ul class="text-gray-600 dark:text-gray-400 text-sm space-y-1">
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-amber-500 dark:text-amber-400 mr-2 text-xs"></i>
                            {{ __('rules.tips.tip1') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-amber-500 dark:text-amber-400 mr-2 text-xs"></i>
                            {{ __('rules.tips.tip2') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-amber-500 dark:text-amber-400 mr-2 text-xs"></i>
                            {{ __('rules.tips.tip3') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chevron-right text-amber-500 dark:text-amber-400 mr-2 text-xs"></i>
                            {{ __('rules.tips.tip4') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="ruleModal" class="fixed inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm hidden z-[70] overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 w-full max-w-2xl">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-primary-100 dark:bg-primary-500/20 p-2 rounded-lg mr-3">
                                <i class="fas fa-rules text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <div>
                                <h2 id="modalTitle" class="text-xl font-semibold text-gray-800 dark:text-white">
                                    {{ __('rules.modal.create_title') }}
                                </h2>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                    {{ __('rules.modal.create_subtitle') }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal()"
                            class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Form -->
                <form id="ruleForm" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" id="ruleId" name="id">

                    <div class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <i
                                    class="fas fa-tag mr-2 text-primary-500 dark:text-primary-400"></i>{{ __('rules.modal.fields.name.label') }}
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500/50 transition-all duration-200"
                                placeholder="{{ __('rules.modal.fields.name.placeholder') }}">
                            @error('name')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <i
                                    class="fas fa-align-left mr-2 text-blue-500 dark:text-blue-400"></i>{{ __('rules.modal.fields.description.label') }}
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500/50 transition-all duration-200 resize-none"
                                placeholder="{{ __('rules.modal.fields.description.placeholder') }}"></textarea>
                            @error('description')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div class="space-y-2">
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <i
                                    class="fas fa-sort-numeric-up mr-2 text-amber-500 dark:text-amber-400"></i>{{ __('rules.modal.fields.order.label') }}
                            </label>
                            <input type="number" id="order" name="order" min="0"
                                class="w-full bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg py-3 px-4 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500/50 transition-all duration-200"
                                placeholder="{{ __('rules.modal.fields.order.placeholder') }}">
                            @error('order')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <i
                                    class="fas fa-toggle-on mr-2 text-green-500 dark:text-green-400"></i>{{ __('rules.modal.fields.status.label') }}
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="is_active" value="1" checked class="peer hidden">
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-300 dark:border-gray-600 peer-checked:border-green-500 peer-checked:bg-green-100 dark:peer-checked:bg-green-500/20 rounded-lg p-3 text-center transition-all duration-200">
                                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 mb-1"></i>
                                        <div class="text-green-700 dark:text-green-400 font-medium text-sm">
                                            {{ __('rules.modal.fields.status.active') }}</div>
                                        <div class="text-green-600/70 dark:text-green-400/70 text-xs mt-1">
                                            {{ __('rules.modal.fields.status.active_desc') }}</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="is_active" value="0" class="peer hidden">
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-300 dark:border-gray-600 peer-checked:border-red-500 peer-checked:bg-red-100 dark:peer-checked:bg-red-500/20 rounded-lg p-3 text-center transition-all duration-200">
                                        <i class="fas fa-pause-circle text-red-600 dark:text-red-400 mb-1"></i>
                                        <div class="text-red-700 dark:text-red-400 font-medium text-sm">
                                            {{ __('rules.modal.fields.status.inactive') }}</div>
                                        <div class="text-red-600/70 dark:text-red-400/70 text-xs mt-1">
                                            {{ __('rules.modal.fields.status.inactive_desc') }}</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeModal()"
                            class="flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 w-full sm:w-auto justify-center sm:justify-start">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('rules.modal.buttons.cancel') }}
                        </button>
                        <button type="submit" id="submitBtn"
                            class="bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center w-full sm:w-auto">
                            <i class="fas fa-save mr-2"></i>
                            <span id="submitText">{{ __('rules.modal.buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        let currentRuleId = null;
        let deleteRuleId = null;
        let deleteRuleName = null;

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = '{{ __('rules.modal.create_title') }}';
            document.getElementById('ruleForm').action = "{{ route('trading-rules.store') }}";
            document.getElementById('ruleForm').method = 'POST';

            // Reset form
            document.getElementById('ruleId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('order').value = '';
            document.querySelector('input[name="is_active"][value="1"]').checked = true;
            document.getElementById('submitText').textContent = '{{ __('rules.modal.buttons.save') }}';

            // Remove PUT method if exists
            const methodField = document.querySelector('input[name="_method"]');
            if (methodField) methodField.remove();

            document.getElementById('ruleModal').classList.remove('hidden');
        }

        function openEditModal(id, name, description, order, isActive) {
            document.getElementById('modalTitle').textContent = '{{ __('rules.modal.edit_title') }}';
            document.getElementById('ruleForm').action = "{{ route('trading-rules.update', '') }}/" + id;
            document.getElementById('ruleForm').method = 'POST';

            // Ensure method field exists for PUT
            if (!document.querySelector('input[name="_method"]')) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                document.getElementById('ruleForm').appendChild(methodInput);
            }

            // Populate form
            document.getElementById('ruleId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description || '';
            document.getElementById('order').value = order || '';

            // Set status radio
            const statusValue = isActive ? '1' : '0';
            document.querySelector(`input[name="is_active"][value="${statusValue}"]`).checked = true;

            document.getElementById('submitText').textContent = '{{ __('rules.modal.buttons.update') }}';
            document.getElementById('ruleModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('ruleModal').classList.add('hidden');
        }

        function deleteRule(id, name) {
            deleteRuleId = id;
            deleteRuleName = name;

            // Ambil pesan validasi dari Blade terlebih dahulu
            const validationMessage = `{{ __('rules.delete.validation_message', ['code' => 'DELETE_RULE_ID']) }}`.replace(
                'DELETE_RULE_ID', 'DELETE_RULE_' + id);

            Swal.fire({
                title: '{{ __('rules.delete.title') }}',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-red-900/20 p-4 rounded-lg mb-4 border border-red-700/30">
                            <p class="font-bold mb-2 text-red-300">{{ __('rules.delete.rule_to_delete') }}:</p>
                            <ul class="space-y-1 text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-tag text-red-500 mr-2 text-xs"></i>
                                    <span><strong>${name}</strong></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-500 mr-2 text-xs"></i>
                                    <span class="text-amber-300">{{ __('rules.delete.warning_used') }}</span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-300 mb-2">{{ __('rules.delete.confirm_text') }}</p>
                        <div class="bg-dark-800/50 p-3 rounded-lg mb-3">
                            <code class="text-red-400 font-mono font-bold">DELETE_RULE_${id}</code>
                        </div>
                        <input type="text" 
                            id="confirmDelete" 
                            class="swal2-input w-full" 
                            placeholder="{{ __('rules.delete.input_placeholder') }}"
                            autocomplete="off">
                    </div>
                `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>{{ __('rules.delete.confirm_button') }}',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __('rules.delete.cancel_button') }}',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                reverseButtons: true,
                customClass: {
                    popup: 'bg-gray-800 border border-red-700/30',
                    title: 'text-red-300',
                    htmlContainer: 'text-left',
                    confirmButton: 'hover:bg-red-700',
                    cancelButton: 'hover:bg-gray-700'
                },
                preConfirm: () => {
                    const confirmInput = document.getElementById('confirmDelete');
                    const typedValue = confirmInput.value.trim();

                    if (typedValue !== `DELETE_RULE_${deleteRuleId}`) {
                        Swal.showValidationMessage(
                            `<div class="text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        ${validationMessage}
                    </div>`
                        );
                        return false;
                    }
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading - tambahkan replace untuk dynamic name
                    const deletingMessage = `{{ __('rules.delete.deleting_message', ['name' => 'RULE_NAME']) }}`
                        .replace('RULE_NAME', deleteRuleName);

                    Swal.fire({
                        title: '{{ __('rules.delete.deleting') }}',
                        html: `
                                <div class="text-center">
                                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500 mb-4"></div>
                                    <p class="text-gray-400">${deletingMessage}</p>
                                </div>
                            `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // Submit delete
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/trading-rules/${deleteRuleId}`;
                    form.style.display = 'none';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#rulesTableBody tr.rule-item');

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const description = row.dataset.description || '';
                const matches = name.includes(searchTerm) || description.includes(searchTerm);
                row.style.display = matches ? '' : 'none';
            });
        });

        // Sorting functionality
        let currentSort = {
            column: null,
            direction: 'asc'
        };

        function sortTable(column, direction) {
            const tbody = document.getElementById('rulesTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr.rule-item'));

            rows.sort((a, b) => {
                let aValue, bValue;

                if (column === 'name') {
                    aValue = a.dataset.name;
                    bValue = b.dataset.name;
                } else if (column === 'order') {
                    aValue = parseInt(a.querySelector('td:nth-child(5) .bg-gray-700').textContent) || 0;
                    bValue = parseInt(b.querySelector('td:nth-child(5) .bg-gray-700').textContent) || 0;
                }

                if (direction === 'asc') {
                    return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
                } else {
                    return aValue > bValue ? -1 : aValue < bValue ? 1 : 0;
                }
            });

            // Reorder rows
            rows.forEach(row => tbody.appendChild(row));

            // Close dropdown
            document.getElementById('sortDropdown').classList.add('hidden');
        }

        // Order management
        async function moveUp(id) {
            await updateOrder(id, 'up');
        }

        async function moveDown(id) {
            await updateOrder(id, 'down');
        }

        async function updateOrder(id, direction) {
            try {
                const response = await fetch(`/trading-rules/${id}/order`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        direction
                    })
                });

                if (response.ok) {
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('rules.messages.error') }}',
                        text: '{{ __('rules.messages.order_failed') }}',
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('rules.messages.error') }}',
                    text: '{{ __('rules.messages.order_error') }}',
                    confirmButtonColor: '#d33'
                });
            }
        }

        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sortDropdownButton = document.getElementById('sortDropdownButton');
            const sortDropdown = document.getElementById('sortDropdown');

            sortDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!sortDropdownButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                    sortDropdown.classList.add('hidden');
                }
            });

            sortDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Real-time validation for delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.id === 'confirmDelete') {
                    const matches = e.target.value.match(/DELETE_RULE_(\d+)/);
                    if (matches && matches[1]) {
                        e.target.style.borderColor = '#10b981';
                        e.target.style.boxShadow = '0 0 0 1px rgba(16, 185, 129, 0.2)';
                    } else {
                        e.target.style.borderColor = '#ef4444';
                        e.target.style.boxShadow = '0 0 0 1px rgba(239, 68, 68, 0.2)';
                    }
                }
            });
        });
    </script>

    <script>
        // Tambahkan di bagian <script> sebelum fungsi lainnya

        // Drag & Drop Functionality
        let draggedRow = null;
        let draggedIndex = null;

        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.draggable-row');
            const tableBody = document.getElementById('rulesTableBody');

            rows.forEach(row => {
                // Make whole row draggable
                row.addEventListener('dragstart', function(e) {
                    draggedRow = this;
                    draggedIndex = Array.from(rows).indexOf(this);
                    this.classList.add('dragging');

                    // Hanya tambahkan sedikit opacity untuk feedback visual
                    this.style.opacity = '0.8';

                    // Set data untuk transfer
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/html', this.innerHTML);

                    // Gunakan ghost image yang lebih sederhana
                    setTimeout(() => {
                        this.style.display = 'none';
                    }, 0);
                });

                row.addEventListener('dragend', function(e) {
                    this.style.display = '';
                    this.style.opacity = '';
                    this.classList.remove('dragging');

                    // Hapus semua class drag-over dari row lain
                    rows.forEach(r => r.classList.remove('drag-over'));

                    // Update order numbers
                    updateRowNumbers();

                    // Reset
                    draggedRow = null;
                    draggedIndex = null;
                });

                // Events untuk memberikan feedback visual saat drag over
                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    if (this !== draggedRow) {
                        this.classList.add('drag-over');
                    }
                });

                row.addEventListener('dragleave', function(e) {
                    this.classList.remove('drag-over');
                });
            });

            // Drag over event for the table body
            tableBody.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';

                // Cari elemen setelah posisi drag
                const draggableElements = [...tableBody.querySelectorAll('.draggable-row:not(.dragging)')];
                const afterElement = getDragAfterElement(tableBody, e.clientY);

                if (afterElement == null) {
                    tableBody.appendChild(draggedRow);
                } else {
                    tableBody.insertBefore(draggedRow, afterElement);
                }
            });

            // Drop event
            tableBody.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Save new order to database
                saveNewOrder();
            });

            // Touch events untuk mobile support
            rows.forEach(row => {
                let touchStartY = 0;
                let touchEndY = 0;

                row.addEventListener('touchstart', function(e) {
                    touchStartY = e.touches[0].clientY;
                    this.classList.add('touch-active');
                }, {
                    passive: true
                });

                row.addEventListener('touchend', function(e) {
                    this.classList.remove('touch-active');
                }, {
                    passive: true
                });
            });
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.draggable-row:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('.draggable-row');
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child .bg-gray-700');
                if (numberCell) {
                    numberCell.textContent = index + 1;
                }

                // Update order di data attribute
                row.dataset.order = index + 1;

                // Update order display di kolom urutan
                const orderCell = row.querySelector('td:nth-child(5) .bg-gray-700');
                if (orderCell) {
                    orderCell.textContent = index + 1;
                }
            });
        }

        async function saveNewOrder() {
            const rows = document.querySelectorAll('.draggable-row');
            const rules = [];

            rows.forEach((row, index) => {
                rules.push({
                    id: row.dataset.id,
                    order: index + 1
                });
            });

            try {
                const response = await fetch('{{ route('trading-rules.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rules
                    })
                });

                if (response.ok) {
                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('rules.messages.success') }}',
                        text: '{{ __('rules.messages.order_updated') }}',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        background: '#1f2937',
                        color: '#d1d5db',
                        iconColor: '#10b981'
                    });
                } else {
                    throw new Error('Failed to save order');
                }
            } catch (error) {
                console.error('Error saving order:', error);

                Swal.fire({
                    icon: 'error',
                    title: '{{ __('rules.messages.error') }}',
                    text: '{{ __('rules.messages.order_save_failed') }}',
                    confirmButtonColor: '#d33'
                });
            }
        }
    </script>

    <style>
        /* ... existing styles ... */

        /* Drag & Drop Styles yang lebih minimal */
        .draggable-row {
            cursor: move;
            user-select: none;
            transition: background-color 0.2s ease;
            position: relative;
        }

        .draggable-row.dragging {
            background-color: rgba(59, 130, 246, 0.1) !important;
            border: 1px solid #3b82f6 !important;
            opacity: 0.8;
            z-index: 1000;
            position: relative;
        }

        .draggable-row.drag-over {
            border-top: 2px solid #3b82f6 !important;
        }

        .draggable-row.drag-over-top {
            border-top: 2px solid #3b82f6 !important;
        }

        .draggable-row.drag-over-bottom {
            border-bottom: 2px solid #3b82f6 !important;
        }

        .drag-handle {
            cursor: move;
            transition: color 0.2s;
        }

        .drag-handle:hover {
            color: #3b82f6;
        }

        .draggable-row:active {
            cursor: grabbing;
        }

        /* Feedback untuk touch devices */
        .draggable-row.touch-active {
            background-color: rgba(59, 130, 246, 0.05) !important;
        }

        /* Highlight area saat drag */
        .drag-placeholder {
            height: 2px;
            background-color: #3b82f6;
            margin: 2px 0;
        }

        /* Visual feedback minimal selama drag */
        #rulesTableBody {
            min-height: 100px;
            transition: all 0.2s ease;
        }

        /* Efek saat hover untuk drag handle */
        .draggable-row:hover .drag-handle {
            color: #3b82f6;
        }
    </style>

    <style>
        /* SweetAlert Custom Styles - Optimized for both themes */
        .swal2-popup {
            background: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02) !important;
        }

        .dark .swal2-popup {
            background: #1f2937 !important;
            border: 1px solid #374151 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3) !important;
        }

        /* Title */
        .swal2-title {
            color: #1f2937 !important;
            font-weight: 600 !important;
            font-size: 1.25rem !important;
            padding-top: 1.5rem !important;
        }

        .dark .swal2-title {
            color: #f3f4f6 !important;
        }

        /* HTML Container */
        .swal2-html-container {
            color: #4b5563 !important;
            font-size: 0.95rem !important;
            line-height: 1.5 !important;
            margin: 0.5rem 0 1rem !important;
        }

        .dark .swal2-html-container {
            color: #9ca3af !important;
        }

        /* Input field */
        .swal2-input {
            background-color: #f9fafb !important;
            border: 1px solid #d1d5db !important;
            color: #1f2937 !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0.5rem 0 0 !important;
            font-size: 0.95rem !important;
            transition: all 0.2s ease !important;
        }

        .swal2-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            outline: none !important;
        }

        .swal2-input::placeholder {
            color: #9ca3af !important;
            opacity: 1 !important;
        }

        .dark .swal2-input {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            color: #f3f4f6 !important;
        }

        .dark .swal2-input::placeholder {
            color: #6b7280 !important;
        }

        .dark .swal2-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
        }

        /* Validation message */
        .swal2-validation-message {
            background: #fef2f2 !important;
            color: #b91c1c !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem !important;
            margin-top: 0.75rem !important;
            font-size: 0.9rem !important;
            border: 1px solid #fecaca !important;
        }

        .dark .swal2-validation-message {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
        }

        /* Buttons */
        .swal2-actions {
            margin-top: 1rem !important;
            gap: 0.75rem !important;
        }

        /* Confirm button (Delete) */
        .swal2-confirm {
            background: #ef4444 !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
            color: white !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2) !important;
        }

        .swal2-confirm:hover {
            background: #dc2626 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-confirm:active {
            transform: translateY(0) !important;
        }

        .dark .swal2-confirm {
            background: #ef4444 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        }

        .dark .swal2-confirm:hover {
            background: #f87171 !important;
        }

        /* Cancel button */
        .swal2-cancel {
            background-color: white !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
            color: #4b5563 !important;
            transition: all 0.2s ease !important;
        }

        .swal2-cancel:hover {
            background-color: #f9fafb !important;
            border-color: #9ca3af !important;
            color: #1f2937 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important;
        }

        .swal2-cancel:active {
            transform: translateY(0) !important;
        }

        .dark .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            color: #d1d5db !important;
        }

        .dark .swal2-cancel:hover {
            background-color: #4b5563 !important;
            border-color: #6b7280 !important;
            color: #f3f4f6 !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2) !important;
        }

        /* Icon styling */
        .swal2-icon.swal2-warning {
            border-color: #fbbf24 !important;
            color: #f59e0b !important;
        }

        .dark .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #fbbf24 !important;
        }

        /* Timer progress bar */
        .swal2-timer-progress-bar {
            background: #ef4444 !important;
        }

        /* Loading spinner */
        .swal2-loader {
            border-color: #ef4444 transparent #ef4444 transparent !important;
        }

        /* Toast notifications (if used) */
        .swal2-toast {
            background: white !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }

        .dark .swal2-toast {
            background: #1f2937 !important;
            border: 1px solid #374151 !important;
        }

        /* Toast title */
        .swal2-toast .swal2-title {
            color: #1f2937 !important;
        }

        .dark .swal2-toast .swal2-title {
            color: #f3f4f6 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .swal2-popup {
                padding: 1rem !important;
            }

            .swal2-actions {
                flex-direction: column-reverse !important;
                width: 100% !important;
            }

            .swal2-confirm,
            .swal2-cancel {
                width: 100% !important;
                margin: 0 !important;
            }
        }
    </style>
@endsection
