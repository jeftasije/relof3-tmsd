<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header" style="background: var(--primary-bg) !important;">
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

    <div style="background: var(--primary-bg) !important; min-height: 90vh;" class="w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8" x-data>
        <div class="w-full max-w-screen-xl mx-auto">
            <div style="background: var(--primary-bg) !important;">
                <div class="p-2 sm:p-4 lg:p-6">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 sm:mb-4 md:mb-6 text-center" style="color: var(--primary-text) !important;">
                        {{ App::getLocale() === 'en' ? 'Search results for: ' : (App::getLocale() === 'sr-Cyrl' ? 'Резултати претраге за: ' : 'Rezultati pretrage za: ') }} "{{ $query }}"
                    </h1>

                    @if(empty($searchResults))
                        <p class="text-center text-sm sm:text-base md:text-lg max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto" style="color: var(--secondary-text) !important;">
                            {{ App::getLocale() === 'en' ? 'No search results.' : (App::getLocale() === 'sr-Cyrl' ? 'Нема резултата претраге.' : 'Nema rezultata pretrage.') }}
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                            @foreach ($searchResults as $result)
                                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition duration-300 hover:-translate-y-1 hover:scale-105 flex flex-col" style="background: var(--primary-bg) !important; color: var(--primary-text) !important; min-height: 200px; box-shadow: 5px 5px 15px rgba(0,0,0,0.25); border: 1px solid var(--secondary-text) !important;">
                                    <h2 class="text-xl font-semibold mb-2" style="color: var(--primary-text) !important;">{{ $result['title'] }}</h2>
                                    <p class="mb-4 text-sm sm:text-base md:text-lg flex-grow" style="color: var(--secondary-text) !important;">{{ $result['description'] }}</p>
                                    <a href="{{ $result['route'] }}" target="_blank" class="w-fit px-4 py-2 rounded-lg font-semibold transition hover:shadow mt-auto" style="background: var(--accent) !important; color: #fff !important;">
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