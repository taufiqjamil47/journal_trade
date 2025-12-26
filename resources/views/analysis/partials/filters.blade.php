<!-- Filters -->
<div class="bg-gray-800 rounded-xl border border-gray-700 p-5 mb-6">
    <form method="GET" action="{{ route('analysis.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Period Filter -->
        <div>
            <label for="period"
                class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.period') }}</label>
            <select name="period" onchange="this.form.submit()"
                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                <option value="all" {{ $period === 'all' ? 'selected' : '' }}>
                    {{ __('analysis.filters.all_time') }}</option>
                <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>
                    {{ __('analysis.filters.weekly') }}</option>
                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>
                    {{ __('analysis.filters.monthly') }}</option>
            </select>
        </div>

        <!-- Session Filter -->
        <div>
            <label for="session"
                class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.session') }}</label>
            <select name="session" onchange="this.form.submit()"
                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                <option value="all" {{ $sessionFilter === 'all' ? 'selected' : '' }}>
                    {{ __('analysis.filters.all_sessions') }}</option>
                @foreach ($availableSessions as $sessionName)
                    <option value="{{ $sessionName }}" {{ $sessionFilter === $sessionName ? 'selected' : '' }}>
                        {{ $sessionName }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Entry Type Filter -->
        <div>
            <label for="entry_type"
                class="block text-sm font-medium text-gray-300 mb-1">{{ __('analysis.filters.entry_type') }}</label>
            <select name="entry_type" onchange="this.form.submit()"
                class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 px-3 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent">
                <option value="all" {{ $entryFilter === 'all' ? 'selected' : '' }}>
                    {{ __('analysis.filters.all_types') }}</option>
                @foreach ($availableEntryTypes as $entryType)
                    <option value="{{ $entryType }}" {{ $entryFilter === $entryType ? 'selected' : '' }}>
                        {{ $entryType }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>
