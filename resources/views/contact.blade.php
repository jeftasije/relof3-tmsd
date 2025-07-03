<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center" style="color: var(--primary-text)">
            Kontakt
        </h2>
    </x-slot>

    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);">

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="flex flex-col items-center w-full mb-12 gap-2">
                <h1 class="font-extrabold text-3xl sm:text-4xl md:text-5xl mb-2 text-center"
                    style="color: var(--primary-text); font-family: var(--font-title);">
                    @switch(App::getLocale())
                        @case('en')
                            Contact us
                        @break
                        @case('sr-Cyrl')
                            Контактирајте нас
                        @break
                        @default
                            Kontaktirajte nas
                    @endswitch
                </h1>
                <div class="flex flex-row items-center gap-3 justify-center w-full">
                    @auth
                        <button id="help-btn" onclick="toggleHelpModal()"
                            class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700"
                            style="color: var(--primary-text); margin-bottom: 0;" aria-label="Pomoć">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 17l0 .01" />
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                            </svg>
                            <span class="ml-3 hidden sm:inline">
                                {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                            </span>
                        </button>
                    @endauth
                </div>
            </div>

            <div class="mb-8"></div>
            <div class="relative flex items-center mb-6">
                <h2 class="absolute left-1/2 transform -translate-x-1/2 text-3xl font-bold whitespace-nowrap"
                    style="color: var(--primary-text);">
                    @switch(App::getLocale())
                        @case('en')
                            We would love to hear from you!
                        @break
                        @case('sr-Cyrl')
                            Ваша питања, сугестије или похвале су добродошле!
                        @break
                        @default
                            Vaša pitanja, sugestije ili pohvale su dobrodošle!
                    @endswitch
                </h2>
                @auth
                    <div class="ml-auto flex gap-2">
                        <button id="editBtn"
                            class="accent font-semibold py-2 px-4 rounded text-base" style="width:100px" type="button">
                            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди' : 'Uredi') }}
                        </button>
                    </div>
                @endauth
            </div>

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

            @auth
                <form action="{{ route('contact.update') }}" method="POST" id="editForm" class="space-y-4 w-full max-w-3xl mx-auto">
                    @csrf
                    @method('PATCH')
                    <div id="contentDisplay" class="prose dark:prose-invert max-w-none mb-8 text-center">
                        {{ __('contact.content') }}
                    </div>

                    <textarea name="content" id="contentEdit" rows="15" style="text-align: center;"
                        class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('contact.content')) }}</textarea>

                    <div id="editButtons" class="flex justify-end gap-4 hidden">
                        <button type="button" id="cancelEditBtn"
                            class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">
                            @switch(App::getLocale())
                                @case('en') Cancel @break
                                @case('sr-Cyrl') Откажи @break
                                @default Otkaži
                            @endswitch
                        </button>

                        <button type="button" id="saveEditBtn" data-modal-target="submitModal" data-modal-toggle="submitModal"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            @switch(App::getLocale())
                                @case('en') Save changes @break
                                @case('sr-Cyrl') Сачувај промене @break
                                @default Sačuvaj promene
                            @endswitch
                        </button>
                    </div>

                    <!-- Confirm Submission Modal -->
                    <div id="submitModal1" tabindex="-1"
                        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="relative w-full max-w-md max-h-full mx-auto">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        @switch(App::getLocale())
                                            @case('en') Are you sure you want to save the changes? @break
                                            @case('sr-Cyrl') Да ли сте сигурни да желите да сачувате измене? @break
                                            @default Da li ste sigurni da želite da sačuvate izmene?
                                        @endswitch
                                    </h3>
                                    <button id="confirmSubmitBtn1" type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                        @switch(App::getLocale())
                                            @case('en') Save @break
                                            @case('sr-Cyrl') Сачувај @break
                                            @default Sačuvaj
                                        @endswitch
                                    </button>
                                    <button data-modal-hide="submitModal1" type="button"
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
            @else
                <div class="prose dark:prose-invert max-w-none text-center">
                    {!! nl2br(e(__('contact.content'))) !!}
                </div>
            @endauth

            <div class="mb-16"></div>

            @php
                $isEditor = auth()->check() && auth()->user()->isEditor();
            @endphp

            <form action="{{ route('contact.store') }}" method="POST" id="contactForm"
                class="space-y-6 w-full max-w-3xl mx-auto {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
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
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                                @case('en') Email: @break
                                @case('sr-Cyrl') Мејл адреса: @break
                                @default Mejl adresa:
                            @endswitch
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                            @switch(App::getLocale())
                                @case('en') Phone @break
                                @case('sr-Cyrl') Телефон @break
                                @default Telefon
                            @endswitch
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text)">
                        @switch(App::getLocale())
                            @case('en') Message @break
                            @case('sr-Cyrl') Порука @break
                            @default Poruka
                        @endswitch
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" rows="6" required
                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5"
                        placeholder="Vaša poruka...">{{ old('message') }}</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="sendBtn"
                        class="text-white font-medium rounded-lg text-base px-5 py-2.5 text-center"
                        style="background: var(--accent)">
                        @switch(App::getLocale())
                            @case('en') Send message @break
                            @case('sr-Cyrl') Пошаљи поруку @break
                            @default Pošalji poruku
                        @endswitch
                    </button>
                </div>
            </form>
        </div>

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
                        By clicking the <strong>\"Edit\"</strong> button, a text area will open allowing you to edit the contact content.<br><br>
                        You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                        If you decide not to make changes or want to cancel, click the <strong>\"Cancel\"</strong> button and the content will revert to its previous state without changes.<br><br>
                        To save your edits, click the <strong>\"Save\"</strong> button.<br>
                        You will be asked to confirm before the changes are applied.
                        '
                        : (App::getLocale() === 'sr-Cyrl'
                            ? '
                                Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за уређивање текста за контактирање.<br><br>
                                Садржај можете унети на енглеском или српском језику (ћирилицом или латиницом), а биће преведен на језик који сте изабрали. <br><br>
                                Ако одлучите да не направите промене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                                Да бисте сачували измене, кликните на дугме <strong>„Сачувај“</strong>.<br>
                                Бићете упитани за потврду пре него што се промене примене.
                            '
                            : '
                                Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje teksta za kontaktiranje.<br><br>
                                Sadržaj možete uneti na engleskom ili srpskom jeziku (ćirilicom ili latinicom), a biće preveden na jezik koji čitate. <br>  <br>
                                Ako odlučite da ne napravite promene ili želite da otkažete, kliknite na dugme <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje bez izmena.<br><br>
                                Da biste sačuvali izmene, kliknite na dugme <strong>„Sačuvaj“</strong>.<br>
                                Bićete upitani za potvrdu pre nego što se promene primene.
                            ') !!}
                </p>
            </div>
        </div>

    </div>

    <script>
        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.toggle('hidden');
        }
        document.addEventListener('DOMContentLoaded', function () {
            const editBtn = document.getElementById('editBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const saveEditBtn = document.getElementById('saveEditBtn');
            const confirmSubmitBtn = document.getElementById('confirmSubmitBtn1');
            const submitModal = document.getElementById('submitModal1');

            const contentDisplay = document.getElementById('contentDisplay');
            const contentEdit = document.getElementById('contentEdit');
            const editButtons = document.getElementById('editButtons');
            const editForm = document.getElementById('editForm');

            let originalContent = contentEdit.value;

            if(editBtn){
                editBtn.addEventListener('click', () => {
                    contentDisplay.classList.add('hidden');
                    contentEdit.classList.remove('hidden');
                    editButtons.classList.remove('hidden');
                    contentEdit.value = originalContent;
                });
            }
            if(cancelEditBtn){
                cancelEditBtn.addEventListener('click', () => {
                    contentEdit.classList.add('hidden');
                    contentDisplay.classList.remove('hidden');
                    editButtons.classList.add('hidden');
                    contentEdit.value = originalContent;
                });
            }
            if(saveEditBtn){
                saveEditBtn.addEventListener('click', () => {
                    submitModal.classList.remove('hidden');
                });
            }
            if(confirmSubmitBtn){
                confirmSubmitBtn.addEventListener('click', () => {
                    submitModal.classList.add('hidden');
                    editForm.submit();
                });
            }
            document.querySelectorAll('[data-modal-hide="submitModal1"]').forEach(btn => {
                btn.addEventListener('click', () => {
                    submitModal.classList.add('hidden');
                });
            });
        });
    </script>
</x-guest-layout>