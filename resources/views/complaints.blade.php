<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: var(--primary-text)">
            Žalbe
        </h2>
    </x-slot>

    <div class="w-full">
        <section class="relative w-full py-12" style="background: var(--primary-bg);">
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div 
                    x-data="complaintsEditor({
                        initialTitle: @js($text['title'] ?? ''),
                        initialDescription: @js($text['description'] ?? ''),
                        initialContent: @js($text['content'] ?? ''),
                        updateUrl: '{{ route('complaints.updateContent') }}',
                        locale: '{{ App::getLocale() }}',
                        csrf: '{{ csrf_token() }}'
                    })"
                >

                    @auth
                    <div class="w-full flex justify-end mb-3">
                        <button @click="startEdit()" class="accent font-semibold py-2 px-4 rounded text-base" style="width:100px">
                            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди' : 'Uredi') }}
                        </button>
                    </div>
                    @endauth

                    <template x-if="editing">
                        <div class="w-full flex flex-col items-center mb-8">
                            <input x-model="form.title" type="text" class="w-full max-w-xl p-3 mb-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white font-bold text-2xl" />
                            <textarea x-model="form.description" rows="2" class="w-full max-w-xl p-3 mb-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white"></textarea>
                            <textarea x-model="form.content" rows="8" class="w-full max-w-xl p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white"></textarea>
                            <div class="flex gap-3 mt-3">
                                <button @click="saveEdit()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                                <button @click="cancelEdit()" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">
                                    {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                                </button>
                            </div>
                            <div x-show="successMessage" x-text="successMessage" class="mt-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded"></div>
                        </div>
                    </template>

                    <template x-if="!editing">
                        <div>
                            <h1 class="text-4xl font-bold mb-2 text-center" style="color: var(--primary-text)" x-text="form.title"></h1>
                            <div class="w-full flex justify-center items-center relative mb-6" style="min-height:56px;">
                                <p class="text-lg text-center mx-auto"
                                    style="color: var(--secondary-text); max-width: 700px; margin: 0 auto; line-height:1.6;"
                                    x-text="form.description"></p>
                                <button id="help-btn"
                                        onclick="toggleHelpModal()"
                                        class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 absolute right-0"
                                        style="color: var(--primary-text); margin-bottom: 6px;"
                                        aria-label="Pomoć">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 17l0 .01" />
                                        <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                    </svg>
                                    <span class="ml-3 hidden sm:inline">
                                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Forma za zalbe -->
                    <div class="mb-16">
                        <div>
                            <h2 class="mb-4 text-3xl font-bold text-center" style="color: var(--primary-text)">
                                @switch(App::getLocale())
                                    @case('en') Every question, suggestion or criticism is welcome! @break
                                    @case('sr-Cyrl') Свако Ваше питање, сугестија или критика је добродошла! @break
                                    @default Svako Vaše pitanje, sugestija ili kritika je dobrodošla!
                                @endswitch
                            </h2>
                            @if(session('success'))
                                <div id="successMessage" class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded transition-opacity duration-500">
                                    {{ session('success') }}
                                </div>
                                <script>
                                    setTimeout(() => {
                                        const el = document.getElementById('successMessage');
                                        if (el) {
                                            el.style.opacity = '0';
                                            setTimeout(() => el.style.display = 'none', 500);
                                        }
                                    }, 3000);
                                </script>
                            @endif

                            @php
                                $isEditor = auth()->check() && auth()->user()->isEditor();
                            @endphp

                            <form action="{{ route('complaints.store') }}" method="POST" id="complaintsForm"
                                class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
                                {{ $isEditor ? 'onsubmit=return false;' : '' }}>
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                                            @switch(App::getLocale())
                                                @case('en') First name: @break
                                                @case('sr-Cyrl') Име: @break
                                                @default Ime:
                                            @endswitch
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                        @error('first_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                                            @switch(App::getLocale())
                                                @case('en') Last name: @break
                                                @case('sr-Cyrl') Презиме: @break
                                                @default Prezime:
                                            @endswitch
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                        @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                                        @switch(App::getLocale())
                                            @case('en') Email: @break
                                            @case('sr-Cyrl') Мејл адреса: @break
                                            @default Mejl adresa:
                                        @endswitch
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                                        @switch(App::getLocale())
                                            @case('en') Subject: @break
                                            @case('sr-Cyrl') Наслов: @break
                                            @default Naslov:
                                        @endswitch
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="subject" required value="{{ old('subject') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('subject') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                                        @switch(App::getLocale())
                                            @case('en') Message: @break
                                            @case('sr-Cyrl') Порука: @break
                                            @default Poruka:
                                        @endswitch
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="message" required rows="6"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">{{ old('message') }}</textarea>
                                    @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div class="text-center">
                                    <button id="openSubmitModal" type="button"
                                        class="text-white font-medium rounded-lg text-base px-5 py-2.5 text-center"
                                        style="background: var(--accent)">
                                        @switch(App::getLocale())
                                            @case('en') Send complaint @break
                                            @case('sr-Cyrl') Пошаљи жалбу @break
                                            @default Pošalji žalbu
                                        @endswitch
                                    </button>
                                </div>

                                <!-- Modal for submitting complaint -->
                                <div id="submitModal2" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="p-6 text-center">
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    @switch(App::getLocale())
                                                        @case('en') Are you sure you want to send the complaint? @break
                                                        @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете жалбу? @break
                                                        @default Da li ste sigurni da želite da pošaljete žalbu?
                                                    @endswitch
                                                </h3>
                                                <button id="confirmSubmitBtn2" type="button"
                                                    class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                                    @switch(App::getLocale())
                                                        @case('en') Send @break
                                                        @case('sr-Cyrl') Пошаљи @break
                                                        @default Pošalji
                                                    @endswitch
                                                </button>
                                                <button data-modal-hide="submitModal2" type="button"
                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    @switch(App::getLocale())
                                                        @case('en') Cancel @break
                                                        @case('sr-Cyrl') Откажи @break
                                                        @default Otkaži
                                                    @endswitch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CONTENT UVEK ISPOD FORME -->
                    <div class="mt-12 max-w-2xl mx-auto w-full prose prose-lg dark:prose-invert" x-show="!editing">
                        <div x-text="form.content.replace(/\n/g, '\n\n')" style="white-space:pre-line; color: var(--primary-text);"></div>
                    </div>
                    <!-- Kada je editing, textarea za content je vec u gornjem template-u -->
                </div>

                <div class="text-center mt-10">
                    <a href="/storage/documents/UPUTSTVO_ZA_ZALBE.pdf"
                       class="inline-block" style="color: var(--accent);" download>
                        @switch(App::getLocale())
                            @case('en') Download the instructions in PDF format @break
                            @case('sr-Cyrl') Преузмите упутство у PDF формату @break
                            @default Preuzmite uputstvo u PDF formatu
                        @endswitch
                    </a>
                </div>
            </div>
        </section>
    </div>

    <!-- HELP MODAL (ostaje isti) -->
    <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4" style="color: var(--primary-text); text-align:center;">
                {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
            </h2>
            <p class="space-y-2 text-sm leading-relaxed" style="color: var(--primary-text)">
                {!! App::getLocale() === 'en' 
                    ? '
                    Clicking on the button <strong>\"Edit\"</strong> will open a field for editing instructions on how the user can submit a complaint.
                    You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                    If you decide not to make changes or want to cancel, click the <strong>\"Cancel\"</strong> button and the content will revert to its previous state without changes.<br><br>
                    To save your edits, click the <strong>\"Save\"</strong> button.<br>
                    You will be asked to confirm before the changes are applied.
                    '
                    : (App::getLocale() === 'sr-Cyrl' 
                    ? '
                        Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за урeђивање упутства како може корисник да приложи жалбу.<br><br>
                        Садржај можете унети на енглеском или српском језику (ћирилицом или латиницом), а биће преведен на језик који сте изабрали. <br><br> 
                        Ако одлучите да не направите промене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                        Да бисте сачували измене, кликните на дугме <strong>„Сачувај“</strong>.<br>
                        Бићете упитани за потврду пре него што се промене примене.
                    '
                    : '
                        Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje uputstva kako može korisnik da priloži žalbu.
                        Sadržaj možete uneti na engleskom ili srpskom jeziku (ćirilicom ili latinicom), a biće preveden na jezik koji čitate. <br>  <br>                
                        Ako odlučite da ne napravite promene ili želite da otkažete, kliknite na dugme <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje bez izmena.<br><br>
                        Da biste sačuvali izmene, kliknite na dugme <strong>„Sačuvaj“</strong>.<br>
                        Bićete upitani za potvrdu pre nego što se promene primene.
                    '
                    )
                !!}
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
            successMessage: '',
            startEdit() { this.editing = true; },
            cancelEdit() { this.form = { ...this.original }; this.editing = false; },
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
                        this.original = { ...this.form };
                        this.successMessage = data.message;
                        this.editing = false;
                        setTimeout(() => this.successMessage = '', 3000);
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

    document.addEventListener('DOMContentLoaded', function () {
        const submitModal2 = document.getElementById('submitModal2');
        const confirmComplaintSubmitBtn = document.getElementById('confirmSubmitBtn2');
        const openSubmitModalBtn = document.getElementById('openSubmitModal');
        const complaintsForm = document.getElementById('complaintsForm'); 
        function showModal(modal) {
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
        }
        function hideModal(modal) {
            if (!modal) return;
            modal.classList.add('hidden');
            modal.style.display = 'none';
            modal.style.justifyContent = '';
            modal.style.alignItems = '';
        }
        if (openSubmitModalBtn) {
            openSubmitModalBtn.addEventListener('click', () => {
                showModal(submitModal2);
            });
        }
        if (confirmComplaintSubmitBtn) {
            confirmComplaintSubmitBtn.addEventListener('click', () => {
                if (complaintsForm) complaintsForm.submit();
                hideModal(submitModal2);
            });
        }
        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                hideModal(modal);
            });
        });
    });
    </script>
</x-guest-layout>
