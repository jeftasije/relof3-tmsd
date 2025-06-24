<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header" style="background: var(--primary-bg);">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full"
                style="color: var(--primary-text); background: var(--primary-bg);">
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

    <div x-data="{ editOpen: false }" class="min-h-[90vh] w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12"
        style="background: var(--primary-bg); color: var(--primary-text);">
        <div class="w-full max-w-screen-xl mx-auto">
            <div style="background: var(--primary-bg); color: var(--primary-text);">
                <div class="p-2 sm:p-4 lg:p-6"
                    style="color: var(--primary-text);">

                    @if($news->image_path)
                        <div class="relative w-full">
                            <img class="w-full max-w-[200vw] h-[18rem] object-cover"
                                src="{{ asset($news->image_path) }}" alt="{{ $news->title }}"
                                onerror="this.src='{{ asset('/images/default-news.jpg') }}';"
                                style="background: var(--primary-bg);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <h1 class="text-3xl sm:text-4xl font-bold"
                                    style="color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
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
                                        class="absolute top-4 right-6 font-semibold px-4 py-2 rounded z-20"
                                        style="background: var(--accent); color: #fff;">
                                        {{ $locale === 'en' ? 'Edit' : ($locale === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                                    </button>
                                @endauth
                            </div>
                            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 text-sm text-white dark:text-white text-center"
                                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                <span>👤 {{ $news->author ?? ($locale === 'en' ? 'Unknown' : ($locale === 'sr-Cyrl' ? 'Непознат' : 'Nepoznat')) }}</span> | 
                                <span>📅 {{ \Carbon\Carbon::parse($news->published_at)->format('d.m.Y') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="px-4 py-4 sm:px-6 sm:py-6 mt-2">
                        <p class="text-base sm:text-lg whitespace-pre-line text-center font-semibold text-2xl"
                           style="color: var(--secondary-text);">
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
                                        <span class="inline-block rounded-full px-3 py-1 text-base font-semibold mb-2 border"
                                              style="background: var(--secondary-text); color: #fff; border-color: var(--primary-bg);">{{ $tag }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="px-4 py-2 sm:px-6 sm:py-4">
                        <a href="{{ route('news.index') }}"
                           class="inline-flex items-center px-3 sm:px-4 py-1 sm:py-2 text-sm font-medium rounded-lg"
                           style="background: var(--accent); color: #fff;">
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
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background:rgba(0,0,0,0.5);"
            @click.self="editOpen = false"
        >
            <div
                x-show="editOpen"
                x-transition
                class="rounded-lg shadow-lg max-w-lg w-full p-6 relative"
                style="background: var(--primary-bg); color: var(--primary-text);"
                @keydown.escape.window="editOpen = false"
            >
                <h2 class="text-xl font-semibold mb-4 text-center"
                    style="color: var(--primary-text);">
                    {{ $locale === 'en' ? 'Edit Extended News' : ($locale === 'sr-Cyrl' ? 'Измени проширену вест' : 'Izmeni proširenu vest') }}
                </h2>
                <form method="POST" action="{{ route('news.updateExtendedNews', $news->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="locale" value="{{ $locale }}">

                    <label class="block mb-2" for="{{ $contentField }}"
                        style="color: var(--secondary-text);">
                        {{ $locale === 'en'
                            ? 'Content (English)'
                            : ($locale === 'sr-Cyrl'
                                ? 'Садржај (Ћирилица)'
                                : 'Sadržaj (Srpski)')
                        }}
                    </label>
                    <textarea name="{{ $contentField }}" id="{{ $contentField }}" rows="5" required
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">{{ $contentValue }}</textarea>

                    <label class="block mb-2" for="{{ $tagsField }}"
                        style="color: var(--secondary-text);">
                        {{ $locale === 'en'
                            ? 'Tags (comma separated)'
                            : ($locale === 'sr-Cyrl'
                                ? 'Тагови (зарезом одвојени)'
                                : 'Tagovi (zarezom odvojeni)')
                        }}
                    </label>
                    <input type="text" name="{{ $tagsField }}" id="{{ $tagsField }}"
                        value="{{ $tagsValue }}"
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);" />
                    <p class="text-xs mb-4"
                        style="color: var(--secondary-text);">
                        {{ $locale === 'en'
                            ? 'Separate tags with commas'
                            : ($locale === 'sr-Cyrl'
                                ? 'Одвојите тагове зарезима'
                                : 'Odvojite tagove zarezima')
                        }}
                    </p>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="editOpen = false" class="px-4 py-2 rounded"
                            style="background: var(--secondary-text); color: #fff;">
                            {{ $locale === 'en' ? 'Cancel' : ($locale === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded"
                            style="background: var(--accent); color: #fff;">
                            {{ $locale === 'en' ? 'Save' : ($locale === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>