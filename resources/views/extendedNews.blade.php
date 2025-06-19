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

    @php
        $locale = App::getLocale();
        $contentField = $locale === 'en' ? 'content_en' : ($locale === 'sr-Cyrl' ? 'content_cy' : 'content');
        $tagsField = $locale === 'en' ? 'tags_en' : ($locale === 'sr-Cyrl' ? 'tags_cy' : 'tags');
        $contentValue = old($contentField, $news->extended ? $news->extended->$contentField : '');

        $rawTags = $news->extended ? $news->extended->$tagsField : [];
        if (is_string($rawTags)) {
            $decoded = json_decode($rawTags, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $rawTags = $decoded;
            } else {
                $rawTags = array_map('trim', explode(',', $rawTags));
            }
        }
        if (!is_array($rawTags)) {
            $rawTags = [];
        }
        $tagsValue = old($tagsField, implode(',', $rawTags));
    @endphp

    <div x-data="{ editOpen: false }" class="min-h-[90vh] w-full bg-white flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12 dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="bg-white dark:bg-gray-900">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-white">

                    @if($news->image_path)
                        <div class="relative w-full">
                            <img class="w-full max-w-[200vw] h-[18rem] object-cover" src="{{ asset($news->image_path) }}" alt="{{ $news->title }}" onerror="this.src='{{ asset('/images/default-news.jpg') }}';">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <h1 class="text-3xl sm:text-4xl font-bold text-white dark:text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                    {{ $locale === 'en' 
                                        ? ($news->title_en ?? $news->title) 
                                        : ($locale === 'sr-Cyrl' 
                                            ? ($news->title_cy ?? $news->title) 
                                            : $news->title) 
                                    }}
                                </h1>
                                @auth
                                    <button
                                        @click.stop="editOpen = true"
                                        class="absolute top-4 right-6 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded z-20"
                                    >
                                        {{ $locale === 'en' ? 'Edit' : ($locale === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                                    </button>
                                @endauth
                            </div>
                            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 text-sm text-white dark:text-white text-center" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                <span>👤 {{ $news->author ?? ($locale === 'en' ? 'Unknown' : ($locale === 'sr-Cyrl' ? 'Непознат' : 'Nepoznat')) }}</span> | 
                                <span>📅 {{ \Carbon\Carbon::parse($news->published_at)->format('d.m.Y') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="px-4 py-4 sm:px-6 sm:py-6 mt-2">
                        <p class="text-gray-700 text-base sm:text-lg dark:text-gray-300 whitespace-pre-line text-center font-semibold text-2xl">
                            {{
                                $locale === 'en'
                                    ? ($news->extended->content_en ?? $news->extended->content ?? 'No additional content.')
                                    : (
                                        $locale === 'sr-Cyrl'
                                            ? ($news->extended->content_cy ?? $news->extended->content ?? 'Нема додатног садржаја.')
                                            : ($news->extended->content ?? 'Nema dodatnog sadržaja.')
                                    )
                            }}
                        </p>
                        @if(count($rawTags))
                            <div class="flex flex-wrap justify-center gap-2 px-4 pt-2 pb-2 mt-2">
                                @foreach($rawTags as $tag)
                                    @if($tag)
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-base font-semibold text-gray-700 mb-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-400">{{ $tag }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="px-4 py-2 sm:px-6 sm:py-4">
                        <a href="{{ route('news.index') }}"
                           class="inline-flex items-center px-3 sm:px-4 py-1 sm:py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ $locale === 'en' ? 'Back to news' : ($locale === 'sr-Cyrl' ? 'Назад на вести' : 'Nazad na vesti') }}
                            <svg class="rtl:rotate-180 w-4 h-4 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4-4m-4 4l4 4"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-show="editOpen"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: none;"
            @click.self="editOpen = false"
        >
            <div
                x-show="editOpen"
                x-transition
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-lg w-full p-6 relative"
                @keydown.escape.window="editOpen = false"
            >
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white text-center">
                    {{ $locale === 'en' ? 'Edit Extended News' : ($locale === 'sr-Cyrl' ? 'Измени проширену вест' : 'Izmeni proširenu vest') }}
                </h2>
                <form method="POST" action="{{ route('news.updateExtendedNews', $news->id) }}">
                    @csrf
                    @method('PUT')

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $contentField }}">
                        {{ $locale === 'en'
                            ? 'Content (English)'
                            : ($locale === 'sr-Cyrl'
                                ? 'Садржај (Ћирилица)'
                                : 'Sadržaj (Srpski)')
                        }}
                    </label>
                    <textarea name="{{ $contentField }}" id="{{ $contentField }}" rows="5" required
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">{{ $contentValue }}</textarea>

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $tagsField }}">
                        {{ $locale === 'en'
                            ? 'Tags (comma separated)'
                            : ($locale === 'sr-Cyrl'
                                ? 'Тагови (зарезом одвојени)'
                                : 'Tagovi (zarezom odvojeni)')
                        }}
                    </label>
                    <input type="text" name="{{ $tagsField }}" id="{{ $tagsField }}"
                        value="{{ $tagsValue }}"
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />
                    <p class="text-xs text-gray-500 mb-4">
                        {{ $locale === 'en'
                            ? 'Separate tags with commas'
                            : ($locale === 'sr-Cyrl'
                                ? 'Одвојите тагове зарезима'
                                : 'Odvojite tagove zarezima')
                        }}
                    </p>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="editOpen = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700">
                            {{ $locale === 'en' ? 'Cancel' : ($locale === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded bg-yellow-500 hover:bg-yellow-600 text-white">
                            {{ $locale === 'en' ? 'Save' : ($locale === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>