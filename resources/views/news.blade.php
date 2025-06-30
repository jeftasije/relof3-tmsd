<x-guest-layout>
    @php $locale = App::getLocale(); @endphp

    @if(session('success'))
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
            class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
            style="top: 14%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 240px; text-align: center;"
            x-init="setTimeout(() => show = false, 2200)"
        >
            {{
                $locale === 'en'
                    ? 'News added successfully!'
                    : ($locale === 'sr-Cyrl'
                        ? 'Вест је успешно додата!'
                        : 'Vest je uspešno dodata!')
            }}
        </div>
    @endif

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

    <div style="background: var(--primary-bg) !important; min-height: 90vh;" class="w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8" x-data>
        <div class="w-full max-w-screen-xl mx-auto">

            <div class="flex justify-between items-center mb-2 sm:mb-4 md:mb-6">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full" style="color: var(--primary-text) !important;">
                    {{ $text['title'] }}
                </h1>
                @auth
                <button
                    @click="$store.modals.openHelp()"
                    class="flex items-center gap-2 ml-4 px-2 py-1 text-base font-semibold rounded transition hover:text-[var(--accent)] focus:outline-none shadow-none bg-transparent border-none"
                    style="background: transparent; color: var(--secondary-text);"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 17l0 .01" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                    </svg>
                    <span>
                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                    </span>
                </button>
                @endauth
            </div>
            <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto" style="color: var(--secondary-text) !important;">
                {{ $text['description'] }}
            </p>

            <div class="flex justify-end mb-6">
                @auth
                <button
                    @click="$store.modals.openAddNews()"
                    class="flex items-center gap-1 font-semibold py-2 px-4 rounded-lg shadow"
                    style="background: var(--accent); color: #fff;"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ App::getLocale() === 'en' ? 'Add News' : (App::getLocale() === 'sr-Cyrl' ? 'Додај вест' : 'Dodaj vest') }}
                </button>
                @endauth
            </div>

            <div id="news-wrapper">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                    @foreach ($news as $newsItem)
                        <x-news-card :news="$newsItem" />
                    @endforeach
                </div>
                @if ($news->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $news->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

            <div
                x-show="$store.modals.addNewsOpen"
                x-transition
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                style="display: none;"
                @click.self="$store.modals.closeAll()"
                @keydown.escape.window="$store.modals.closeAll()"
            >
                <div
                    x-show="$store.modals.addNewsOpen"
                    x-transition
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full p-8 relative"
                    @click.stop
                >
                    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                            <div>
                                <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                    <h2 class="text-xl font-semibold" style="color: var(--primary-text) !important;">
                                        {{ App::getLocale() === 'en' ? 'Add News' : (App::getLocale() === 'sr-Cyrl' ? 'Додај вест' : 'Dodaj vest') }}
                                    </h2>
                                </div>
                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="title">
                                    {{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}
                                </label>
                                <input type="text" name="title" id="title" required
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);" />

                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="summary">
                                    {{ App::getLocale() === 'en' ? 'Summary' : (App::getLocale() === 'sr-Cyrl' ? 'Кратак опис' : 'Kratak opis') }}
                                </label>
                                <textarea name="summary" id="summary" rows="2"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);"></textarea>

                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="image">
                                    {{ App::getLocale() === 'en' ? 'Upload Image' : (App::getLocale() === 'sr-Cyrl' ? 'Додај слику' : 'Dodaj sliku') }}
                                </label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);" />

                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="author">
                                    {{ App::getLocale() === 'en' ? 'Author' : (App::getLocale() === 'sr-Cyrl' ? 'Аутор' : 'Autor') }}
                                </label>
                                <input type="text" name="author" id="author"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);" />

                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="published_at">
                                    {{ App::getLocale() === 'en' ? 'Publish Date' : (App::getLocale() === 'sr-Cyrl' ? 'Датум објаве' : 'Datum objave') }}
                                </label>
                                <input type="date" name="published_at" id="published_at"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);" />
                            </div>
                            <div>
                                <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                    <h2 class="text-xl font-semibold" style="color: var(--primary-text) !important;">
                                        {{ App::getLocale() === 'en' ? 'Extended News' : (App::getLocale() === 'sr-Cyrl' ? 'Проширена вест' : 'Proširena vest') }}
                                    </h2>
                                </div>
                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="content">
                                    {{ App::getLocale() === 'en' ? 'Full Content' : (App::getLocale() === 'sr-Cyrl' ? 'Цео садржај' : 'Ceo sadržaj') }}
                                </label>
                                <textarea name="content" id="content" rows="6"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);"></textarea>

                                <label class="block mb-2" style="color: var(--secondary-text) !important;" for="tags">
                                    {{ App::getLocale() === 'en' ? 'Tags (comma separated)' : (App::getLocale() === 'sr-Cyrl' ? 'Тагови (раздвојени зарезом)' : 'Tagovi (zarez)') }}
                                </label>
                                <input type="text" name="tags" id="tags"
                                    class="w-full p-2 mb-4 border border-gray-300 rounded"
                                    style="background: var(--primary-bg); color: var(--primary-text);" />
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 mt-8">
                            <button type="button" @click="$store.modals.closeAll()" class="px-4 py-2 rounded"
                                    style="background: #cbd5e1; color: var(--primary-text);">
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                            <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @auth
            <div
                x-show="$store.modals.helpOpen"
                x-transition
                x-cloak
                class="fixed inset-0 flex items-center justify-center z-50"
                style="background:rgba(0,0,0,0.5);"
                tabindex="0"
                @click.self="$store.modals.closeAll()"
                @keydown.escape.window="$store.modals.closeAll()"
            >
                <div
                    x-show="$store.modals.helpOpen"
                    x-transition
                    x-cloak
                    class="relative rounded-xl border-2 border-[var(--secondary-text)] shadow-2xl bg-white dark:bg-gray-900 flex flex-col items-stretch"
                    style="width:480px; height:560px; background: var(--primary-bg); color: var(--primary-text);"
                    @click.stop
                    x-data="{ slide: 1, total: 3, enlarged: false }"
                >
                    <button
                        @click="$store.modals.closeAll()"
                        class="absolute top-3 right-3 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
                        style="color: var(--secondary-text);"
                        aria-label="Close"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex flex-col flex-1 px-4 py-3 overflow-hidden h-full">
                        <div class="flex flex-col items-center justify-start" style="height: 48%;">
                            <h3 class="text-lg font-bold text-center mb-2" style="color:var(--primary-text)">
                                {{ App::getLocale() === 'en' ? 'How to use News Management' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити управљање вестима' : 'Kako koristiti upravljanje vestima') }}
                            </h3>
                            <div class="flex items-center justify-center w-full" style="min-height: 170px;">
                                <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                                    style="min-width:32px;">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <div class="flex-1 flex justify-center items-center min-h-[150px] cursor-zoom-in">
                                    <template x-if="slide === 1">
                                        <img @click="enlarged = '/images/news-help1.png'" src="/images/news-help1.png" alt="Edit or Delete News" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                    </template>
                                    <template x-if="slide === 2">
                                        <img @click="enlarged = '/images/news-help2.png'" src="/images/news-help2.png" alt="Edit Form" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                    </template>
                                    <template x-if="slide === 3">
                                        <img @click="enlarged = '/images/news-help3.png'" src="/images/news-help3.png" alt="Add News" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                    </template>
                                </div>
                                <button type="button" @click="slide = slide === total ? 1 : slide + 1"
                                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition ml-3 flex items-center justify-center"
                                    style="min-width:32px;">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
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
                        <div x-show="enlarged" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
                            style="backdrop-filter: blur(2px);" @click="enlarged = false">
                            <img :src="enlarged" class="rounded-2xl shadow-2xl max-h-[80vh] max-w-[90vw] border-4 border-white object-contain" @click.stop />
                            <button @click="enlarged = false" class="absolute top-5 right-8 bg-white/80 hover:bg-white p-2 rounded-full shadow" aria-label="Close" style="color: var(--primary-text);">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 overflow-y-auto px-1 py-1 mt-2"
                            style="color: var(--secondary-text); min-height: 160px; max-height: 48%;">
                            <template x-if="slide === 1">
                                <div>
                                    <h4 class="font-semibold mb-2">
                                        {{ App::getLocale() === 'en' ? 'Editing and Deleting News' : (App::getLocale() === 'sr-Cyrl' ? 'Измена и брисање вести' : 'Izmena i brisanje vesti') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                        @case('en')
                                            To edit or delete a news item, click the three dots located at the bottom left corner of the news card. This will open a menu with options for editing and deleting.
                                        @break
                                        @case('sr-Cyrl')
                                            Да бисте измењили или обрисали вест, кликните на три тачке у доњем левом углу компоненте вести. Појавиће се мени са опцијама за измену и брисање.
                                        @break
                                        @default
                                            Da biste izmenili ili obrisali vest, kliknite na tri tačke u donjem levom uglu komponente vesti. Pojaviće se meni sa opcijama za izmenu i brisanje.
                                        @endswitch
                                    </p>
                                </div>
                            </template>
                            <template x-if="slide === 2">
                                <div>
                                    <h4 class="font-semibold mb-2">
                                        {{ App::getLocale() === 'en' ? 'Editing News Content' : (App::getLocale() === 'sr-Cyrl' ? 'Уређивање садржаја вести' : 'Uređivanje sadržaja vesti') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                        @case('en')
                                            After clicking Edit, you can modify the text fields. You can also click on the news image to upload a different image. Once you have finished making changes, click Save to update the news.<br>
                                            If you wish to discard your changes at any moment, click Cancel. You will receive a confirmation message after successful editing.
                                        @break
                                        @case('sr-Cyrl')
                                            Након што кликнете на Измени, можете измењивати текстуална поља, као и кликнути на слику вести да бисте отпремили нову. По завршетку измена кликните на дугме Сачувај.<br>
                                            Ако желите да одустанете од промена у било ком тренутку, кликните на дугме Откажи. Након успешне измене, добићете потврду о сачуваним променама.
                                        @break
                                        @default
                                            Nakon što kliknete na Izmeni, možete izmeniti tekstualna polja, a klikom na sliku vesti možete izabrati novu. Kada završite izmene, kliknite na Sačuvaj.<br>
                                            Ako želite da otkažete izmene u bilo kom trenutku, kliknite na dugme Otkaži. Nakon uspešne izmene, dobijate poruku o sačuvanim promenama.
                                        @endswitch
                                    </p>
                                </div>
                            </template>
                            <template x-if="slide === 3">
                                <div>
                                    <h4 class="font-semibold mb-2">
                                        {{ App::getLocale() === 'en' ? 'Adding a New News Item' : (App::getLocale() === 'sr-Cyrl' ? 'Додавање нове вести' : 'Dodavanje nove vesti') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                        @case('en')
                                            To add a new news item, click the "Add News" button. Complete the fields for the basic news content, and use the fields on the right for extended news content.<br>
                                            Depending on the currently selected language, enter the content in that language; the system will automatically translate and save the content in the other languages.<br>
                                            After creating a news item, click "Show more" to view the detailed news you entered.
                                        @break
                                        @case('sr-Cyrl')
                                            Да додате нову вест, кликните на дугме "Додај вест". Попуните колоне за основну и проширену вест.<br>
                                            У зависности од изабраног језика, уносите садржај на том језику; систем ће аутоматски превести и сачувати садржај и на другим језицима.<br>
                                            Након креирања вести, кликните на "Прикажи више" како бисте видели детаљну вест коју сте унели.
                                        @break
                                        @default
                                            Da dodate novu vest, kliknite na dugme "Dodaj vest". Popunite kolone za osnovnu i proširenu vest.<br>
                                            U zavisnosti od izabranog jezika, unosite sadržaj na tom jeziku; sistem će automatski prevesti i sačuvati sadržaj i na drugim jezicima.<br>
                                            Nakon kreiranja vesti, kliknite na "Prikaži više" da detaljno vidite proširenu vest koju ste uneli.
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
    </div>

    <script>
        function initAlpineModalsStore() {
            if (!window.Alpine) return;
            if (!Alpine.store('modals')) {
                Alpine.store('modals', {
                    addNewsOpen: false,
                    helpOpen: false,
                    openAddNews() { this.addNewsOpen = true; this.helpOpen = false; },
                    openHelp() { this.helpOpen = true; this.addNewsOpen = false; },
                    closeAll() { this.addNewsOpen = false; this.helpOpen = false; }
                });
            }
        }

        document.addEventListener('alpine:init', initAlpineModalsStore);

        document.addEventListener('DOMContentLoaded', () => {
            initAlpineModalsStore();
            if (window.Alpine && Alpine.store('modals')) {
                Alpine.store('modals').closeAll();
            }
            document.querySelectorAll('[x-show]').forEach(el => el.style.display = 'none');

            document.body.addEventListener('click', e => {
                const link = e.target.closest('#news-wrapper .pagination a');
                if (!link) return;
                e.preventDefault();
                fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const wrapper = doc.getElementById('news-wrapper');
                        document.getElementById('news-wrapper').innerHTML = wrapper.innerHTML;

                        if (window.Alpine && Alpine.initTree) {
                            Alpine.initTree(document.getElementById('news-wrapper'));
                        }

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
            });
        });
    </script>
</x-guest-layout>
