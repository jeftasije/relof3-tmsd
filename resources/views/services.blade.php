<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center" style="color: var(--primary-text)">
            Žalbe
        </h2>
    </x-slot>
    <div class="w-full min-h-screen flex flex-col items-center justify-center px-2"
        style="background: var(--primary-bg); color: var(--primary-text);"
        x-data="complaintsEditor({
            initialTitle: @js($text['title'] ?? ''),
            initialDescription: @js($text['description'] ?? ''),
            initialContent: @js($text['content'] ?? ''),
            updateUrl: '{{ route('complaints.updateContent') }}',
            locale: '{{ App::getLocale() }}',
            csrf: '{{ csrf_token() }}'
        })">

        <!-- ALERT -->
        <div x-show="showEditAlert"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
             class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
             style="top: 10%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 220px; text-align: center;"
             x-init="$watch('showEditAlert', val => { if (val) { setTimeout(() => showEditAlert = false, 3200) } })">
            <span x-text="msg"></span>
        </div>

        <!-- CARD CENTERED -->
        <div class="w-full max-w-2xl bg-white/70 dark:bg-gray-900/80 rounded-2xl shadow-xl p-8 flex flex-col items-center relative">

            <!-- Help dugme, potpuno apstraktno, iznad svega i centrirano -->
            <button id="help-btn" type="button" onclick="toggleHelpModal()"
                class="absolute left-1/2 -top-6 -translate-x-1/2 flex items-center gap-2 px-4 py-2 rounded-full bg-[var(--accent)] text-white font-semibold shadow transition hover:bg-green-700 focus:outline-none"
                style="z-index:12;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 17l0 .01" />
                    <path d="M12 13.5a1.5 1.5 0 0 1 1-1.5a2.6 2.6 0 1 0-3-4" />
                </svg>
                <span>
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </span>
            </button>

            <!-- Naslov -->
            <h1 class="font-extrabold text-3xl sm:text-4xl mb-3 text-center w-full" style="color: var(--primary-text); font-family: var(--font-title); margin-top: 2.5rem;">
                <template x-if="editing">
                    <input type="text" x-model="form.title"
                        class="text-3xl sm:text-4xl font-extrabold w-full border px-2 py-1 rounded text-center"
                        style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-title);" />
                </template>
                <span x-show="!editing" x-text="form.title"></span>
            </h1>
            <!-- Opis -->
            <div class="w-full flex flex-col items-center mb-2">
                <template x-if="editing">
                    <input type="text" x-model="form.description"
                        class="text-lg w-full max-w-xl border px-2 py-1 rounded text-center"
                        style="background: var(--primary-bg); color: var(--primary-text);" />
                </template>
                <span x-show="!editing"
                    class="text-lg text-center block w-full max-w-2xl"
                    style="color: var(--secondary-text);"
                    x-html="window.marked.parse(form.description)">
                </span>
            </div>

            <!-- Edit dugme centriran -->
            @auth
                <div class="flex justify-center gap-3 mt-3 mb-1">
                    <button x-show="!editing" @click="startEdit()"
                        class="accent font-semibold py-2 px-8 rounded-full text-base shadow transition bg-[var(--accent)] text-white hover:bg-green-700"
                        style="width:120px">
                        {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                    </button>
                    <template x-if="editing">
                        <div class="flex gap-2">
                            <button @click="saveEdit()"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-full shadow">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                            <button @click="cancelEdit()"
                                class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-6 rounded-full shadow">
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                        </div>
                    </template>
                </div>
            @endauth

            <h2 class="text-2xl font-bold mt-6 mb-4 text-center w-full" style="color: var(--primary-text);">
                @switch(App::getLocale())
                    @case('en')
                        Every question, suggestion or criticism is welcome!
                    @break
                    @case('sr-Cyrl')
                        Свако Ваше питање, сугестија или критика је добродошла!
                    @break
                    @default
                        Svako Vaše pitanje, sugestija ili kritika je dobrodošla!
                @endswitch
            </h2>

            <div class="w-full prose prose-lg dark:prose-invert text-center mb-4">
                <template x-if="editing">
                    <textarea x-model="form.content" rows="8" class="w-full border rounded-xl p-4 text-lg dark:bg-gray-800 text-center"
                        style="background: var(--primary-bg); color: var(--primary-text); resize:vertical;"></textarea>
                </template>
                <div x-show="!editing" x-text="form.content.replace(/\n/g, '\n\n')" style="white-space:pre-line; color: var(--primary-text);"></div>
            </div>

            <a href="{{ asset('storage/documents/UPUTSTVO%20ZA%20ZALBE.pdf') }}" target="_blank"
                class="block text-base font-semibold mt-4 mb-1 hover:underline text-[var(--accent)] text-center">
                @switch(App::getLocale())
                    @case('en')
                        Download the instructions in PDF format
                    @break
                    @case('sr-Cyrl')
                        Преузмите упутство у PDF формату
                    @break
                    @default
                        Preuzmite uputstvo u PDF formatu
                @endswitch
            </a>
        </div>

        <!-- HELP MODAL -->
        <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
                <button onclick="toggleHelpModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4" style="color: var(--primary-text);">
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </h2>
                <p class="space-y-2 text-sm leading-relaxed" style="color: var(--primary-text)">
                    {!! App::getLocale() === 'en'
                        ? '
                            Clicking on the <strong>\"Edit\"</strong> button will open the field for editing the instructions on how a user can submit a complaint.
                            You can enter content in English or Serbian (Cyrillic or Latin), and it will be translated into the selected language. <br><br>
                            If you decide not to make changes or want to cancel, click the <strong>\"Cancel\"</strong> button and the content will revert to its previous state without changes.<br><br>
                            To save your edits, click the <strong>\"Save\"</strong> button.<br>
                            You will be asked to confirm before the changes are applied.
                        '
                        : (App::getLocale() === 'sr-Cyrl'
                            ? '
                                Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за уређивање упутства како корисник може да пошаље жалбу.<br><br>
                                Садржај можете унети на енглеском или српском (ћирилицом или латиницом), а биће преведен на изабрани језик. <br><br>
                                Ако не желите измене, кликните <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање.<br><br>
                                Да сачувате измене, кликните <strong>„Сачувај“</strong>.<br>
                                Бићете упитани за потврду пре примене.
                            '
                            : '
                                Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje uputstva kako korisnik može da pošalje žalbu.
                                Sadržaj možete uneti na engleskom ili srpskom jeziku (ćirilicom ili latinicom), a biće preveden na izabrani jezik. <br><br>
                                Ako ne želite izmene, kliknite <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje.<br><br>
                                Da sačuvate izmene, kliknite <strong>„Sačuvaj“</strong>.<br>
                                Bićete upitani za potvrdu pre primene.
                            ') !!}
                </p>
            </div>
        </div>

        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            function complaintsEditor({ initialTitle, initialDescription, initialContent, updateUrl, locale, csrf }) {
                return {
                    editing: false,
                    form: {
                        title: initialTitle,
                        description: initialDescription,
                        content: initialContent
                    },
                    original: {
                        title: initialTitle,
                        description: initialDescription,
                        content: initialContent
                    },
                    showEditAlert: false,
                    msg: '',
                    startEdit() { this.editing = true; },
                    cancelEdit() {
                        this.form = { ...this.original };
                        this.editing = false;
                    },
                    saveEdit() {
                        fetch(updateUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    locale: locale,
                                    title: this.form.title,
                                    description: this.form.description,
                                    content: this.form.content
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    this.showEditAlert = true;
                                    if (locale === 'en') {
                                        this.msg = "Changes saved successfully!";
                                    } else if (locale === 'sr-Cyrl') {
                                        this.msg = "Измене су успешно сачуване!";
                                    } else {
                                        this.msg = "Izmene su uspešno sačuvane!";
                                    }
                                    this.editing = false;
                                    this.original = { ...this.form };
                                } else {
                                    alert(data.message || 'Greška pri čuvanju!');
                                }
                            })
                            .catch(() => alert('Greška pri čuvanju!'));
                    }
                }
            }
            function toggleHelpModal() {
                const modal = document.getElementById('helpModal');
                modal.classList.toggle('hidden');
            }
        </script>
    </div>
</x-guest-layout>
