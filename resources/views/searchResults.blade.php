<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full text-gray-900 hover:bg-gray-200 focus:outline-none dark:text-white dark:hover:bg-gray-700">
                <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="min-h-[90vh] w-full bg-white flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="bg-white dark:bg-gray-900">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-white">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 text-center dark:text-white">
                        {{ App::getLocale() === 'en' ? 'Search results for: ' : (App::getLocale() === 'sr-Cyrl' ? 'Резултати претраге за: ' : 'Rezultati pretrage za: ') }} "{{ $query }}"
                    </h1>

                    @if(empty($searchResults))
                        <p class="text-center text-gray-700 dark:text-gray-300">Nema rezultata pretrage.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                            @foreach ($searchResults as $result)
                                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800 shadow hover:shadow-lg transition cursor-pointer">
                                    <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ $result['title'] }}</h2>
                                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $result['description'] }}</p>
                                    <a href="{{ $result['route'] }}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        {{ App::getLocale() === 'en' ? 'Show' : (App::getLocale() === 'sr-Cyrl' ? 'Погледај' : 'Pogledaj') }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
