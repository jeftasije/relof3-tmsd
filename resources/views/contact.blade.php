<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center" style="color: var(--primary-text)">
            Kontakt
        </h2>
    </x-slot>
    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 4000)"
        class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
        {{ __('contact.' . session('success')) }}
    </div>
    @endif
    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);"
        x-data="contactEditor({
            initialTitle: @js($text['title'] ?? ''),
            initialDescription: @js($text['description'] ?? ''),
            initialContent: @js($text['content'] ?? ''),
            updateUrl: '{{ route('contact.updateContent') }}',
            locale: '{{ App::getLocale() }}',
            csrf: '{{ csrf_token() }}'
        })">

        <div x-show="showEditAlert" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
            class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
            style="top: 12%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 220px; text-align: center;"
            x-init="$watch('showEditAlert', val => { if (val) { setTimeout(() => showEditAlert = false, 3200) } })">
            <span x-text="msg"></span>
        </div>

        <div class="max-w-3xl mx-auto px-4 py-12 relative">
            @auth
            <div class="absolute right-[-100px] top-0 flex flex-col items-end z-10" style="gap:8px; padding-top: 50px;">

                <button id="help-btn" data-modal-target="helpModal" data-modal-toggle="helpModal"
                    class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 order-first"
                    style="color: var(--primary-text); background:transparent;"
                    aria-label="Pomoć">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" stroke-width="2" />
                        <path d="M12 17l0 .01" />
                        <path d="M12 13.5a1.5 1.5 0 0 1 1-1.5a2.6 2.6 0 1 0-3-4" />
                    </svg>
                    <span class="ml-2 hidden sm:inline">
                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                    </span>
                </button>

                <button x-show="!editing" @click="startEdit()" class="py-2 px-4 rounded text-base bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                    {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди' : 'Uredi') }}
                </button>

                <template x-if="editing">
                    <div class="flex gap-2 justify-end w-full">
                        <button @click="saveEdit()"
                            class="py-2 px-4 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                        <button @click="cancelEdit()"
                            class="bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded">
                            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                    </div>
                </template>
            </div>
            @endauth

            <div class="flex flex-col items-center w-full mb-12 gap-4">
                <div class="w-full flex flex-col items-center mb-2">
                    <template x-if="editing">
                        <input type="text" x-model="form.title"
                            class="text-3xl sm:text-4xl md:text-5xl font-extrabold border px-2 rounded text-center w-full"
                            style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-title);" />
                    </template>
                    <span x-show="!editing" x-text="form.title"
                        class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center w-full"
                        style="color: var(--primary-text); font-family: var(--font-title);"></span>
                </div>

                <div class="w-full flex flex-col items-center mb-2">
                    <template x-if="editing">
                        <input type="text" x-model="form.description"
                            class="text-lg w-full border px-2 rounded text-center"
                            style="background: var(--primary-bg); color: var(--primary-text);" />
                    </template>
                    <span x-show="!editing" class="text-lg text-center w-full" style="color: var(--secondary-text);"
                        x-text="form.description"></span>
                </div>

                <div class="w-full flex flex-col items-center">
                    <template x-if="editing">
                        <textarea x-model="form.content" rows="4" class="w-full border rounded-xl p-4 text-center dark:bg-gray-800"
                            style="background: var(--primary-bg); color: var(--primary-text); resize:vertical; font-size: 1.2rem;"></textarea>
                    </template>
                    <div x-show="!editing" x-text="form.content.replace(/\n/g, '\n\n')" class="text-center w-full"
                        style="white-space:pre-line; color: var(--primary-text); font-size: 1.2rem;"></div>
                </div>
            </div>

            @php
            $isLogged = auth()->check();
            @endphp

            <form action="{{ route('contact.store') }}" method="POST" id="contactForm"
                class="space-y-6 w-full max-w-3xl mx-auto mt-12 {{ $isLogged ? 'opacity-50 pointer-events-none' : '' }}"
                {{ $isLogged ? 'onsubmit=return false;' : '' }}>
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                            @case('en')
                            First name:
                            @break

                            @case('sr-Cyrl')
                            Име:
                            @break

                            @default
                            Ime:
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" required value="{{ old('first_name') }}"
                            class="shadow-sm text-sm rounded-lg focus:border-grey-200 block w-full p-2.5  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                            @case('en')
                            Last name:
                            @break

                            @case('sr-Cyrl')
                            Презиме:
                            @break

                            @default
                            Prezime:
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="last_name" required value="{{ old('last_name') }}"
                            class="shadow-sm text-sm rounded-lg focus:focus:border-grey-200 block w-full p-2.5  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                            @case('en')
                            Email:
                            @break

                            @case('sr-Cyrl')
                            Мејл адреса:
                            @break

                            @default
                            Mejl adresa:
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="shadow-sm text-sm rounded-lg focus:border-grey-200 block w-full p-2.5  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                            @case('en')
                            Phone
                            @break

                            @case('sr-Cyrl')
                            Телефон
                            @break

                            @default
                            Telefon
                            @endswitch
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="shadow-sm text-sm rounded-lg focus:border-grey-200 block w-full p-2.5  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                        @switch(App::getLocale())
                        @case('en')
                        Message
                        @break

                        @case('sr-Cyrl')
                        Порука
                        @break

                        @default
                        Poruka
                        @endswitch
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" rows="6" required
                        class="shadow-sm text-sm rounded-lg focus:border-grey-200 block w-full p-2.5  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                        placeholder="Vaša poruka...">{{ old('message') }}</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="sendBtn"
                        class="rounded-lg text-base px-5 py-2.5 text-center bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                        @switch(App::getLocale())
                        @case('en')
                        Send message
                        @break

                        @case('sr-Cyrl')
                        Пошаљи поруку
                        @break

                        @default
                        Pošalji poruku
                        @endswitch
                    </button>
                </div>
            </form>
        </div>

        <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <button data-modal-hide="helpModal"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4" style="color: var(--primary-text); text-align:center;">
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </h2>
                <p class="space-y-2 text-sm leading-relaxed" style="color: var(--primary-text)">
                    {!! App::getLocale() === 'en'
                    ? '


                    By clicking the <strong>"Edit"</strong> button, a text area will open allowing you to edit the contact content.<br><br>
                    You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                    If you decide not to make changes or want to cancel, click the <strong>"Cancel"</strong> button and the content will revert to its previous state without changes.<br><br>
                    To save your edits, click the <strong>"Save"</strong> button.<br>
                    You will be asked to confirm before the changes are applied.
                    '
                    : (App::getLocale() === 'sr-Cyrl'
                    ? '


                    Кликом на дугме <strong>„Уреди“</strong> отворићеће се поље за уређивање текста за контактирање.<br><br>
                    Садржај можете унети на енглеском или српском језику (ћирилицом или латиницом), а биће преведен на језик који сте изабрали. <br><br>
                    Ако одлучите да не направите промене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                    Да бисте сачували измене, кликните на дугме <strong>„Сачувај“</strong>.<br>
                    Бићете упитани за потврду пре него што се промене примене.
                    '
                    : '


                    Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje teksta za kontaktiranje.<br><br>
                    Sadržaj možete uneti na engleskom ili srpskom jeziku (ćiilicom ili latinicom), a biće preveden na jezik koji čitate. <br> <br>
                    Ako odlucite da ne napravite promene ili zelite da otkazete, kliknite na dugme <strong>„Otkazi“</strong> i sadrzaj ce se vratiti na prethodno stanje bez izmena.<br><br>
                    Da biste sacuvali izmene, kliknite na dugme <strong>„Sacuvaj“</strong>.<br>
                    Bicete upitani za potvrdu pre nego sto se promene primene.
                    ') !!}
                </p>
            </div>
        </div>

        <div id="submitEditModal" tabindex="-1"
            class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-opacity-50">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                    style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal color-[var(--primary-text)]">
                            @switch(App::getLocale())
                            @case('en')
                            Are you sure you want to save the changes?
                            @break

                            @case('sr-Cyrl')
                            Да ли сте сигурни да желите да сачувате измене?
                            @break

                            @default
                            Da li ste sigurni da želite da sačuvate izmene?
                            @endswitch
                        </h3>
                        <button id="confirmSubmitEditBtn" type="button"
                            class="focus:ring-4 focus:outline-none font-medium rounded text-sm px-5 py-2.5 text-center mr-2 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                            @switch(App::getLocale())
                            @case('en')
                            Save
                            @break

                            @case('sr-Cyrl')
                            Сачувај
                            @break

                            @default
                            Sačuvaj
                            @endswitch
                        </button>
                        <button data-modal-hide="submitEditModal" type="button"
                            class="focus:ring-4 focus:outline-none rounded text-sm font-medium px-5 py-2.5 focus:z-10 bg-gray-500 hover:bg-gray-600">
                            @switch(App::getLocale())
                            @case('en')
                            Cancel
                            @break

                            @case('sr-Cyrl')
                            Откажи
                            @break

                            @default
                            Otkaži
                            @endswitch
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function contactEditor({
            initialTitle,
            initialDescription,
            initialContent,
            updateUrl,
            locale,
            csrf
        }) {
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
                startEdit() {
                    this.editing = true;
                },
                cancelEdit() {
                    this.form = {
                        ...this.original
                    };
                    this.editing = false;
                },
                saveEdit() {
                    document.getElementById('submitEditModal').classList.remove('hidden');
                    document.getElementById('confirmSubmitEditBtn').onclick = () => {
                        fetch(updateUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    title: this.form.title,
                                    description: this.form.description,
                                    content: this.form.content,
                                    locale: locale
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
                                    this.original = {
                                        ...this.form
                                    };
                                } else {
                                    alert(data.message || 'Greška pri čuvanju!');
                                }
                            })
                            .catch(() => alert('Greška pri čuvanju!'));
                        document.getElementById('submitEditModal').classList.add('hidden');
                    };
                    document.querySelectorAll('[data-modal-hide="submitEditModal"]').forEach(btn => {
                        btn.onclick = () => document.getElementById('submitEditModal').classList.add('hidden');
                    });
                }
            }
        }
    </script>
</x-guest-layout>