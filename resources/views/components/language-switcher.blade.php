<div class="flex items-center space-x-2 mb-4 ml-4">
    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
            class="px-3 py-1 rounded-md text-sm {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'bg-primary-500 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
            {{ strtoupper($localeCode) }}
        </a>
    @endforeach
</div>
