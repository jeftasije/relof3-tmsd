<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Žalbe
        </h2>
    </x-slot>

    <div class="w-full">
        <section 
            class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat py-12" 
            style="background-image: url('/images/comments.jpg');">
        
            <div class="absolute inset-0 bg-black/30"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-12 px-6 py-12">
                    
                    <div class="flex flex-col">
                        @auth
                            <div class="flex justify-end mb-2">
                                <button 
                                    id="help-btn" 
                                    onclick="toggleHelpModal()"
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 17l0 .01" />
                                        <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                    </svg>
                                    <span class="ml-3">
                                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                                    </span>
                                </button>
                            </div>
                        @endauth
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                                @case('en') How to file a complaint? @break
                                @case('sr-Cyrl') Како поднети жалбу? @break
                                @default Kako podneti žalbu?
                            @endswitch
                        </h3>
                        @auth
                            <div class="text-right mb-6">
                                <button id="editBtn" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded text-base"
                                    type="button">
                                    @switch(App::getLocale())
                                        @case('en') Edit @break
                                        @case('sr-Cyrl') Уреди @break
                                        @default Uredi
                                    @endswitch
                                </button>
                            </div>
                        @endauth
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
                                }, 3000); // 3000ms = 3s
                            </script>
                        @endif
                        <div class="prose dark:prose-invert max-w-none space-y-6">
                            @auth
                            <form action="{{ route('complaints.update') }}" method="POST" id="historyForm" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div id="contentDisplay" class="prose dark:prose-invert max-w-none">
                                    {{ __('complaints.content') }}
                                </div>

                                <textarea name="content" id="contentEdit" rows="15" 
                                    class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('complaints.content')) }}</textarea>

                                <div id="editButtons" class="flex justify-end gap-4 hidden">
                                    <button type="button" id="cancelBtn"
                                        class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">
                                        @switch(App::getLocale())
                                            @case('en') Cancel @break
                                            @case('sr-Cyrl') Откажи @break
                                            @default Otkaži
                                        @endswitch
                                    </button>

                                    <button type="button" id="saveBtn" data-modal-target="submitModal1" data-modal-toggle="submitModal1"
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
                                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
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
                                                <button id="confirmSubmitBtn" type="button"
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
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e(__('complaints.content'))) !!}
                            </div>
                        @endauth

                        </div>

                        <div class="text-center mt-auto mt-8">
                            <a href="/documents/uputstvo_za_zalbe.pdf" 
                            class="inline-block text-blue-600 hover:underline dark:text-blue-400" 
                            download>
                                @switch(App::getLocale())
                                    @case('en') Download the instructions in PDF format @break
                                    @case('sr-Cyrl') Преузмите упутство у PDF формату @break
                                    @default Preuzmite uputstvo u PDF formatu
                                @endswitch
                            </a>
                        </div>

                    </div>

                    <div>
                        <h2 class="mb-4 text-3xl font-bold text-center text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                                @case('en') Every question, suggestion or criticism is welcome! @break
                                @case('sr-Cyrl') Свако Ваше питање, сугестија или критика је добродошла! @break
                                @default Svako Vaše pitanje, sugestija ili kritika je dobrodošla!
                            @endswitch
                        </h2>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!--<form action="{{ route('complaints.store') }}" method="POST" class="space-y-6"> -->
                        @php
                            $isEditor = auth()->check() && auth()->user()->isEditor();
                        @endphp

                        <form action="{{ route('complaints.store') }}" method="POST"
                            class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
                            {{ $isEditor ? 'onsubmit=return false;' : '' }}>
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
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
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
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

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ 'Email' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        @switch(App::getLocale())
                                            @case('en') Phone: @break
                                            @case('sr-Cyrl') Телефон: @break
                                            @default Telefon:
                                        @endswitch
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    @switch(App::getLocale())
                                        @case('en') Message: @break
                                        @case('sr-Cyrl') Порука: @break
                                        @default Poruka:
                                    @endswitch
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" rows="5" required
                                    class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">{{ old('message') }}</textarea>
                                @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-center">
                                <button type="button" id="openSubmitModal"
                                    class="py-3 px-5 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    @switch(App::getLocale())
                                        @case('en') Submit complaint @break
                                        @case('sr-Cyrl') Пошаљи жалбу @break
                                        @default Pošalji žalbu
                                    @endswitch
                                </button>

                            </div>
                        </form>
                        <!-- Confirm Submission Modal -->
                        <div id="submitModal2" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full mx-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            @switch(App::getLocale())
                                                @case('en') Are you sure you want to submit the complaint? @break
                                                @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете жалбу? @break
                                                @default Da li ste sigurni da želite da pošaljete žalbu?
                                            @endswitch
                                        </h3>
                                        <button id="confirmSubmitBtn" type="button"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                            @switch(App::getLocale())
                                                @case('en') Confirm @break
                                                @case('sr-Cyrl') Потврди @break
                                                @default Potvrdi
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


                    </div>
                </div>

                
            </div>
        </section>
    </div>
    <div 
        id="helpModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">
                {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
            </h2>
            <p class="text-gray-700 dark:text-gray-300 space-y-2 text-sm leading-relaxed">
                {!! App::getLocale() === 'en' 
                    ? '
                    Clicking on the button <strong>"Edit"</strong> will open a field for editing instructions on how the user can submit a complaint.
                    You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                    If you decide not to make changes or want to cancel, click the <strong>"Cancel"</strong> button and the content will revert to its previous state without changes.<br><br>
                    To save your edits, click the <strong>"Save"</strong> button.<br>
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

</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Edit dugme
        const editBtn = document.getElementById('editBtn');
        const contentDisplay = document.getElementById('contentDisplay');
        const contentEdit = document.getElementById('contentEdit');
        const editButtons = document.getElementById('editButtons');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const submitModal1 = document.getElementById('submitModal1');
        const confirmContentSaveBtn = document.getElementById('confirmSubmitBtn'); // Promenićemo ID da bude jedinstven

        // Za submit modal 1, promenićemo ID dugmeta da ne bude isti kao kod forme slanja
        if (confirmContentSaveBtn) {
            confirmContentSaveBtn.id = 'confirmContentSaveBtn';
        }

        // Funkcija za prikazivanje modala
        function showModal(modal) {
            if (modal) modal.classList.remove('hidden');
        }
        // Funkcija za skrivanje modala
        function hideModal(modal) {
            if (modal) modal.classList.add('hidden');
        }

        // Klik na edit dugme - otvori textarea i dugmad za editovanje
        if (editBtn) {
            editBtn.addEventListener('click', () => {
                contentDisplay.classList.add('hidden');
                contentEdit.classList.remove('hidden');
                editButtons.classList.remove('hidden');
                editBtn.classList.add('hidden');
            });
        }

        // Klik na cancel - vrati na prikaz bez editovanja
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                contentEdit.classList.add('hidden');
                editButtons.classList.add('hidden');
                contentDisplay.classList.remove('hidden');
                editBtn.classList.remove('hidden');
                // Vrati vrednost u textarea na originalni tekst da odbaci izmene
                contentEdit.value = contentDisplay.innerText.trim();
            });
        }

        // Klik na save - otvori modal za potvrdu izmene
        if (saveBtn) {
            saveBtn.addEventListener('click', () => {
                showModal(submitModal1);
            });
        }

        // Klik na potvrdu u modalu za izmene - submit forme
        const confirmSave = document.getElementById('confirmContentSaveBtn');
        if (confirmSave) {
            confirmSave.addEventListener('click', () => {
                // submit forme za update
                document.getElementById('historyForm').submit();
            });
        }

        // Modal zatvaranje na klik Cancel (ima data-modal-hide atribut, dodajemo JS)
        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', e => {
                const modalId = btn.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                hideModal(modal);
            });
        });

        // --- Modal za slanje zahteva (submitModal2) ---

        const openSubmitModalBtn = document.getElementById('openSubmitModal');
        const submitModal2 = document.getElementById('submitModal2');
        const confirmSubmitBtn = submitModal2?.querySelector('button[id="confirmSubmitBtn"]') || submitModal2?.querySelector('button:not([data-modal-hide])'); 

        // Da bi potvrdni dugme za slanje bilo unikatno, promenićemo mu id:
        if (confirmSubmitBtn) {
            confirmSubmitBtn.id = 'confirmComplaintSubmitBtn';
        }

        if (openSubmitModalBtn && submitModal2) {
            openSubmitModalBtn.addEventListener('click', () => {
                showModal(submitModal2);
            });
        }

        // Klik na potvrdu u modalu za slanje - submit forme
        const confirmComplaintSubmitBtn = document.getElementById('confirmComplaintSubmitBtn');
        if (confirmComplaintSubmitBtn) {
            confirmComplaintSubmitBtn.addEventListener('click', () => {
                // Šaljemo formu za slanje žalbe
                document.querySelector('form[action="{{ route('complaints.store') }}"]').submit();
            });
        }

    });

    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }
</script>
