<x-guest-layout>
    @php $locale = App::getLocale(); @endphp

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
            class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
            style="
                top: 14%;
                transform: translateX(-50%);
                background: #22c55e;
                color: #fff;
                font-weight: 600;
                letter-spacing: 0.03em;
                min-width: 240px;
                text-align: center;"
            x-init="setTimeout(() => show = false, 2200)">
            {{ $locale === 'en'
                ? 'Changes saved successfully!'
                : ($locale === 'sr-Cyrl'
                    ? 'Успешно сте сачували измене!'
                    : 'Uspešno ste sačuvali izmene!') }}
        </div>
    @endif

    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header" style="background: var(--primary-bg);">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full"
                style="color: var(--primary-text); background: var(--primary-bg);">
                <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z">
                    </path>
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

    <div x-data="{
        editOpen: false,
        helpOpen: false,
        slide: 1,
        total: 2,
        enlarged: false
    }" class="min-h-[90vh] w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12"
        style="background: var(--primary-bg); color: var(--primary-text);">
        <div class="w-full max-w-screen-xl mx-auto">
            <div style="background: var(--primary-bg); color: var(--primary-text);">
                <div class="p-2 sm:p-4 lg:p-6" style="color: var(--primary-text);">

                    @auth
                        <!-- HELP dugme iznad slike i edit dugmeta -->
                        <div class="flex justify-end mb-3">
                            <button @click="helpOpen = true"
                                class="flex items-center gap-2 px-2 py-1 text-base font-semibold rounded transition hover:text-[var(--accent)] focus:outline-none shadow-none bg-transparent border-none text-[var(--secondary-text)]"
                                type="button">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 17l0 .01" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 13.5a1.5 1.5 0 0 1 1-1.5a2.6 2.6 0 1 0-3-4" />
                                </svg>
                                <span>
                                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                                </span>
                            </button>
                        </div>
                    @endauth

                    @if ($news->image_path)
                        <div class="relative w-full">
                            @auth
                                <button @click.stop="editOpen = true"
                                    class="absolute top-4 right-6 font-semibold px-4 py-2 rounded z-20 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)] text-white">
                                    {{ $locale === 'en' ? 'Edit' : ($locale === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                                </button>
                            @endauth

                            <img class="w-full max-w-[200vw] h-[18rem] object-cover"
                                src="{{ asset($news->image_path) }}" alt="{{ $news->title }}"
                                onerror="this.src='{{ asset('/images/default-news.jpg') }}';"
                                style="background: var(--primary-bg);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <h1 class="text-3xl sm:text-4xl font-bold"
                                    style="color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                    {{ $locale === 'en'
                                        ? $news->title_en ?? $news->title
                                        : ($locale === 'sr-Cyrl'
                                            ? $news->title_cy ?? $news->title
                                            : $news->title) }}
                                </h1>
                            </div>
                            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 text-sm text-white dark:text-white text-center"
                                style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                <span>👤
                                    {{ $news->author ?? ($locale === 'en' ? 'Unknown' : ($locale === 'sr-Cyrl' ? 'Непознат' : 'Nepoznat')) }}</span>
                                |
                                <span>📅 {{ \Carbon\Carbon::parse($news->published_at)->format('d.m.Y') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="px-4 py-4 sm:px-6 sm:py-6 mt-2">
                        <p class="text-base sm:text-lg whitespace-pre-line text-center font-semibold text-2xl"
                            style="color: var(--secondary-text);">
                            {{ $locale === 'en'
                                ? $news->extended->content_en ?? ($news->extended->content ?? 'No additional content.')
                                : ($locale === 'sr-Cyrl'
                                    ? $news->extended->content_cy ?? ($news->extended->content ?? 'Нема додатног садржаја.')
                                    : $news->extended->content ?? 'Nema dodatnog sadržaja.') }}
                        </p>
                        @if (count($rawTags))
                            <div class="flex flex-wrap justify-center gap-2 px-4 pt-2 pb-2 mt-2">
                                @foreach ($rawTags as $tag)
                                    @if ($tag)
                                        <span
                                            class="inline-block rounded-full px-3 py-1 text-base font-semibold mb-2 border"
                                            style="background: var(--secondary-text); color: #fff; border-color: var(--primary-bg);">{{ $tag }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="px-4 py-2 sm:px-6 sm:py-4">
<a href="{{ route('news.index') }}"
    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition
        bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)] text-white">
    {{ $locale === 'en' ? 'Back to News' : ($locale === 'sr-Cyrl' ? 'Назад на вести' : 'Nazad na vesti') }}
    <svg class="rtl:rotate-180 w-4 h-4 ms-2 ml-2" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 5H1m0 0l4-4m-4 4l4 4" />
    </svg>
</a>

                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div x-show="editOpen" x-transition class="fixed inset-0 flex items-center justify-center z-50"
            style="background:rgba(0,0,0,0.5);" @click.self="editOpen = false">
            <div x-show="editOpen" x-transition class="rounded-lg shadow-lg max-w-lg w-full p-6 relative"
                style="background: var(--primary-bg); color: var(--primary-text);"
                @keydown.escape.window="editOpen = false">
                <h2 class="text-xl font-semibold mb-4 text-center" style="color: var(--primary-text);">
                    {{ $locale === 'en' ? 'Edit Extended News' : ($locale === 'sr-Cyrl' ? 'Измени проширену вест' : 'Izmeni proširenu vest') }}
                </h2>
                <form method="POST" action="{{ route('news.updateExtendedNews', $news->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="locale" value="{{ $locale }}">

                    <label class="block mb-2" for="{{ $contentField }}" style="color: var(--secondary-text);">
                        {{ $locale === 'en' ? 'Content (English)' : ($locale === 'sr-Cyrl' ? 'Садржај (Ћирилица)' : 'Sadržaj (Srpski)') }}
                    </label>
                    <textarea name="{{ $contentField }}" id="{{ $contentField }}" rows="5" required
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">{{ $contentValue }}</textarea>

                    <label class="block mb-2" for="{{ $tagsField }}" style="color: var(--secondary-text);">
                        {{ $locale === 'en'
                            ? 'Tags (comma separated)'
                            : ($locale === 'sr-Cyrl'
                                ? 'Тагови (зарезом одвојени)'
                                : 'Tagovi (zarezom odvojeni)') }}
                    </label>
                    <input type="text" name="{{ $tagsField }}" id="{{ $tagsField }}"
                        value="{{ $tagsValue }}" class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);" />
                    <p class="text-xs mb-4" style="color: var(--secondary-text);">
                        {{ $locale === 'en'
                            ? 'Separate tags with commas'
                            : ($locale === 'sr-Cyrl'
                                ? 'Одвојите тагове зарезима'
                                : 'Odvojite tagove zarezima') }}
                    </p>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="editOpen = false"
                            class="px-4 py-2 rounded bg-[var(--secondary-text)] text-white hover:bg-[color-mix(in_srgb,_var(--secondary-text)_80%,_black_20%)]">

                            {{ $locale === 'en' ? 'Cancel' : ($locale === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)] text-white">

                            {{ $locale === 'en' ? 'Save' : ($locale === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- HELP MODAL -->
        @auth
            <div x-show="helpOpen" x-transition class="fixed inset-0 flex items-center justify-center z-50"
                style="background:rgba(0,0,0,0.5);" @click.self="helpOpen = false">
                <div x-show="helpOpen" x-transition
                    class="relative rounded-xl border-2 border-[var(--secondary-text)] shadow-2xl bg-white dark:bg-gray-900 flex flex-col items-stretch"
                    style="width:500px; height:520px; background: var(--primary-bg); color: var(--primary-text);"
                    @keydown.escape.window="helpOpen = false">
                    <button @click="helpOpen = false"
                        class="absolute top-3 right-3 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
                        style="color: var(--secondary-text);" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex flex-col flex-1 px-4 py-3 overflow-hidden h-full">
                        <div class="flex flex-col items-center justify-start" style="height: 48%;">
                            <h3 class="text-lg font-bold text-center mb-2" style="color:var(--primary-text)">
                                {{ App::getLocale() === 'en'
                                    ? 'How to edit extended news'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Како измењивати проширене вести'
                                        : 'Kako izmenjivati proširene vesti') }}
                            </h3>
                            <div class="flex items-center justify-center w-full" style="min-height: 140px;">
                                <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                                    style="min-width:32px;">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <div class="flex-1 flex justify-center items-center min-h-[120px] cursor-zoom-in">
                                    <template x-if="slide === 1">
                                        <img @click="enlarged = '/images/extendedNews-help1.png'"
                                            src="/images/extendedNews-help1.png" alt="Edit Button"
                                            class="rounded-xl max-h-36 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                    </template>
                                    <template x-if="slide === 2">
                                        <img @click="enlarged = '/images/extendedNews-help2.png'"
                                            src="/images/extendedNews-help2.png" alt="Edit Modal"
                                            class="rounded-xl max-h-36 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                    </template>
                                </div>
                                <button type="button" @click="slide = slide === total ? 1 : slide + 1"
                                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition ml-3 flex items-center justify-center"
                                    style="min-width:32px;">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-center mt-2 space-x-1">
                                <template x-for="i in total">
                                    <div :class="slide === i ? 'bg-[var(--accent)]' : 'bg-gray-400'"
                                        class="w-2 h-2 rounded-full transition-all duration-200"></div>
                                </template>
                            </div>
                        </div>

                        <div x-show="enlarged" x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
                            style="backdrop-filter: blur(2px);" @click="enlarged = false">
                            <img :src="enlarged"
                                class="rounded-2xl shadow-2xl max-h-[80vh] max-w-[90vw] border-4 border-white object-contain"
                                @click.stop />
                            <button @click="enlarged = false"
                                class="absolute top-5 right-8 bg-white/80 hover:bg-white p-2 rounded-full shadow"
                                aria-label="Close" style="color: var(--primary-text);">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-1 py-1 mt-2"
                            style="color: var(--secondary-text); min-height: 120px; max-height: 48%;">
                            <template x-if="slide === 1">
                                <div>
                                    <h4 class="font-semibold mb-2">
                                        {{ App::getLocale() === 'en'
                                            ? 'Opening the edit dialog'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Отварање прозора за измену'
                                                : 'Otvaranje prozora za izmenu') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                            @case('en')
                                                To edit the extended news, click the "Edit" button located at the top right of the
                                                news image (see image 1).
                                            @break

                                            @case('sr-Cyrl')
                                                Да бисте изменили проширену вест, кликните на дугме „Измени“ у горњем десном углу
                                                слике вести (слика 1).
                                            @break

                                            @default
                                                Da biste izmenili proširenu vest, kliknite na dugme „Izmeni“ u gornjem desnom uglu
                                                slike vesti (slika 1).
                                        @endswitch
                                    </p>
                                </div>
                            </template>
                            <template x-if="slide === 2">
                                <div>
                                    <h4 class="font-semibold mb-2">
                                        {{ App::getLocale() === 'en'
                                            ? 'Editing and saving'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Измена и чување података'
                                                : 'Izmena i čuvanje podataka') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                            @case('en')
                                                After clicking "Edit", a dialog will open with all fields related to the extended
                                                news. Make your changes, then click "Save" to apply them. The changes will
                                                automatically be synchronized with all language versions of the news (see image 2).
                                            @break

                                            @case('sr-Cyrl')
                                                Наkon što kliknete na „Izmeni“, otvoriće se prozor sa svim poljima za proširenu
                                                vest. Nakon unosa izmena, kliknite „Sačuvaj“. Promene će biti automatski primenjene
                                                i na ostale jezike vesti (slika 2).
                                            @break

                                            @default
                                                Nakon što kliknete na „Izmeni“, otvoriće se prozor sa svim podacima o proširenoj
                                                vesti. Nakon izmena, kliknite „Sačuvaj“. Promene će biti automatski primenjene i na
                                                ostale jezike vesti (slika 2).
                                        @endswitch
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

    </div>
</x-guest-layout>
