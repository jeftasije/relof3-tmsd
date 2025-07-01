<x-guest-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex flex-col">
            <div class="flex items-center justify-center relative mb-6 mt-8">
                <h2 class="text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white flex-grow">
                    @switch(App::getLocale())
                        @case('en') Questions and answers @break
                        @case('sr-Cyrl') Питања и одговори @break
                        @default Pitanja i odgovori
                    @endswitch
                </h2>

                @auth
                    <button 
                        id="help-btn" 
                        onclick="toggleHelpModal()"
                        class="flex items-center text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group absolute right-0"
                        style="top: 50%; transform: translateY(-50%)"
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
                @endauth
            </div>
            @auth
                <div class="text-right mb-10 mt-6">
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
            
        
            @auth
            <form action="{{ route('contact.update') }}" method="POST" id="editForm" class="space-y-4">
                @csrf
                @method('PATCH')
                <div id="contentDisplay" class="prose dark:prose-invert max-w-none mb-8 text-center">
                    {{ __('question.description') }}
                </div>

                <textarea name="content" id="contentEdit" rows="15" style="text-align: center;"
                    class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('question.description')) }}</textarea>

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
                    {!! nl2br(e(__('question.description'))) !!}
                </div>
            @endauth


        </div>

        <!-- Forma za pretragu i sortiranje -->
        <form method="GET" action="{{ route('questions.index') }}">
            <div class="relative mb-24 mt-5">
                <label for="searchInput">
                    @switch(App::getLocale())
                    @case('en') Search questions @break
                    @case('sr-Cyrl') Претражи питања @break
                    @default Pretraži pitanja
                    @endswitch
                </label>
                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ App::getLocale() === 'en'
                        ? 'Enter question'
                        : (App::getLocale() === 'sr-Cyrl'
                            ? 'Унесите питање'
                            : 'Unesite pitanje') }}"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2"
                    style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);"
                >
                <div id="searchDropdown" class="absolute z-10 w-full rounded-lg mt-1 hidden"
                    style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);">
                    <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
                </div>
            </div>

            <div class="mb-4 flex justify-start items-center">
                <label for="globalSort" class="mr-2 text-sm" style="color: var(--secondary-text);">
                    @switch(App::getLocale())
                    @case('en') Sort by: @break
                    @case('sr-Cyrl') Сортитај по: @break
                    @default Sortiraj po:
                    @endswitch
                </label>
                <select
                    id="globalSort"
                    name="sort"
                    onchange="this.form.submit()"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    style="color: var(--secondary-text); border: 1px solid var(--secondary-text); border-radius: 4px;"
                >
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A</option>
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>
                        @switch(App::getLocale())
                        @case('en') Newest first @break
                        @case('sr-Cyrl') Новије прво @break
                        @default Novije prvo
                        @endswitch
                    </option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>
                        @switch(App::getLocale())
                        @case('en') Oldest first @break
                        @case('sr-Cyrl') Старије прво @break
                        @default Starije prvo
                        @endswitch
                    </option>
                </select>
            </div>
        </form>

        <div id="accordion-collapse" data-accordion="collapse"
            class="rounded-lg"
            style="background: var(--primary-bg); border-color: var(--secondary-text);">
            @foreach($questions as $question)
            @php
                $isOpen = (string) $question->id === (string) $activeQuestionId;
            @endphp
            <div class="rounded-lg border"
                style="background: var(--primary-bg); border-color: var(--secondary-text);">
                <h2>
                    <button type="button"
                            class="flex items-center justify-between w-full p-4 font-medium text-left rounded-lg"
                            style="color: var(--secondary-text); background: var(--primary-bg);"
                            data-question-id="{{ $question->id }}"
                            data-accordion-target="#accordion-body-{{ $question->id }}"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                            aria-controls="accordion-body-{{ $question->id }}">
                        <span style="color: var(--primary-text); font-weight: 600;">
                            {{ $question->question }}
                        </span>
                        <svg data-accordion-icon
                            class="w-5 h-5 rotate-0 shrink-0 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="color: var(--secondary-text);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $question->id }}"
                    class="px-4 pb-4 text-gray-700 dark:text-gray-300 whitespace-pre-line"
                    style="{{ $isOpen ? '' : 'display:none;' }}">
                    {!! nl2br(e($question->answer)) !!}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                    style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'Are you sure you want to delete?'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Да ли сте сигурни да желите да обришете'
                                    : 'Da li ste sigurni da želite da obrišete') }}
                            "<span id="deleteModalTitle"></span>"?
                        </h3>
                        <button data-modal-hide="deleteModal" id="confirmDeleteButton" type="button"
                            class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            style="background: var(--accent); color: #fff;">
                            {{ App::getLocale() === 'en'
                                ? 'Confirm'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Потврди'
                                    : 'Potvrdi') }}
                        </button>
                        <button data-modal-hide="deleteModal" type="button"
                            class="text-sm font-medium px-5 py-2.5 rounded-lg border"
                            style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'Cancel'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Откажи'
                                    : 'Otkaži') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rename Modal -->
        <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                    style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'Rename document'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Преименуј документ'
                                    : 'Preimenuj dokument') }}
                        </h3>
                        <input type="text" id="renameInput" class="w-full p-2 border rounded-lg focus:outline-none"
                            placeholder="{{ App::getLocale() === 'en' ? 'Enter new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}"
                            style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                        <div class="mt-4 text-center">
                            <button data-modal-hide="renameModal" id="confirmRenameButton" type="button"
                                class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                                style="background: var(--accent); color: #fff;">
                                {{ App::getLocale() === 'en'
                                    ? 'Save'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Сачувај'
                                        : 'Sačuvaj') }}
                            </button>
                            <button data-modal-hide="renameModal" type="button"
                                class="text-sm font-medium px-5 py-2.5 rounded-lg border"
                                style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);">
                                {{ App::getLocale() === 'en'
                                    ? 'Cancel'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Откажи'
                                        : 'Otkaži') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    By clicking the <strong>"Edit"</strong> button, a text area will open allowing you to edit the contact content.<br><br>
                    You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                    If you decide not to make changes or want to cancel, click the <strong>"Cancel"</strong> button and the content will revert to its previous state without changes.<br><br>
                    To save your edits, click the <strong>"Save"</strong> button.<br>
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
                    '
                    )
                !!}
            </p>


        </div>
    </div>
</x-guest-layout>


<script>
    document.querySelectorAll('button[data-accordion-target]').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-accordion-target').substring(1);
            const content = document.getElementById(targetId);
            const isExpanded = button.getAttribute('aria-expanded') === 'true';

            // Toggle aria-expanded
            button.setAttribute('aria-expanded', !isExpanded);

            // Toggle visibility
            if (content) {
                if (isExpanded) {
                    content.style.display = 'none';
                } else {
                    content.style.display = 'block';
                }
            }

            // Optionally toggle arrow rotation
            const svgIcon = button.querySelector('svg[data-accordion-icon]');
            if(svgIcon) {
                if(isExpanded) {
                    svgIcon.classList.remove('rotate-180');
                } else {
                    svgIcon.classList.add('rotate-180');
                }
            }
        });
    });
    
    function clearAnswer() {
        document.getElementById('answer-textarea').value = '';
    }


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

        // Klik na "Uredi"
        editBtn.addEventListener('click', () => {
            contentDisplay.classList.add('hidden');
            contentEdit.classList.remove('hidden');
            editButtons.classList.remove('hidden');
            contentEdit.value = originalContent;
        });

        // Klik na "Otkaži"
        cancelEditBtn.addEventListener('click', () => {
            contentEdit.classList.add('hidden');
            contentDisplay.classList.remove('hidden');
            editButtons.classList.add('hidden');
            contentEdit.value = originalContent;
        });

        // Klik na "Sačuvaj" (otvara modal)
        saveEditBtn.addEventListener('click', () => {
            submitModal.classList.remove('hidden');
        });

        // Klik na "Potvrdi - Sačuvaj" u modalu (submituje formu)
        confirmSubmitBtn.addEventListener('click', () => {
            submitModal.classList.add('hidden');
            editForm.submit();
        });

        // Modal close dugme (otkazuje modal)
        document.querySelectorAll('[data-modal-hide="submitModal1"]').forEach(btn => {
            btn.addEventListener('click', () => {
                submitModal.classList.add('hidden');
            });
        });
    });
</script>