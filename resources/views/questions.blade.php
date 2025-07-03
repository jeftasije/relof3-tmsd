<x-guest-layout>
    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 4000)"
        class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
        {{ __('question.' . session('success')) }}
    </div>
    @endif
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex flex-col">
            <div class="flex items-center justify-center relative mb-6 mt-8">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full sm:mb-4 md:mb-6"
                    style="color: var(--primary-text); font-family: var(--font-title);">
                    @switch(App::getLocale())
                    @case('en') Questions and answers @break
                    @case('sr-Cyrl') Питања и одговори @break
                    @default Pitanja i odgovori
                    @endswitch
                </h1>

                @auth
                <div class="absolute right-0">
                    <button
                        id="help-btn"
                        onclick="toggleHelpModal()"
                        class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 group"
                        style="color: var(--primary-text); background: var(--primary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 17l0 .01" />
                            <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                        </svg>
                        <span class="ml-3">
                            {{ App::getLocale() === 'en'
                                        ? 'Help'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Помоћ'
                                            : 'Pomoć') }}
                        </span>
                    </button>
                </div>
                @endauth
            </div>
            @auth
            <div class="text-right mb-4 mt-4">
                <button id="editBtn"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded text-base"
                    style="background: var(--accent); color: #fff;"
                    type="button">
                    @switch(App::getLocale())
                    @case('en') Edit @break
                    @case('sr-Cyrl') Уреди @break
                    @default Uredi
                    @endswitch
                </button>
            </div>
            @endauth

            
            @auth
            <form action="{{ route('questions.updateDescription') }}" method="POST" id="editForm" class="space-y-4">
                @csrf
                @method('PATCH')
                <div id="contentDisplay" class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto"
                    style="color: var(--secondary-text); font-family: var(--font-body);">
                    {{ __('question.description') }}
                </div>

                <textarea name="description" id="contentEdit" rows="15" style="text-align: center;"
                    class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('question.description')) }}</textarea>

                <div id="editButtons" class="flex justify-end gap-4 hidden">
                    <button type="button" id="cancelEditBtn"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded"
                        style="background: #cbd5e1; color: var(--primary-text);">
                        @switch(App::getLocale())
                        @case('en') Cancel @break
                        @case('sr-Cyrl') Откажи @break
                        @default Otkaži
                        @endswitch
                    </button>

                    <button type="button" id="saveEditBtn" data-modal-target="submitModal1" data-modal-toggle="submitModal1"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                        style="background: var(--accent); color: #fff;">
                        @switch(App::getLocale())
                        @case('en') Save changes @break
                        @case('sr-Cyrl') Сачувај промене @break
                        @default Sačuvaj promene
                        @endswitch
                    </button>
                </div>

                <div id="submitModal1" tabindex="-1"
                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="relative w-full max-w-md max-h-full mx-auto">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="p-6 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
                                    style="color: var(--secondary-text);">
                                    @switch(App::getLocale())
                                    @case('en') Are you sure you want to save the changes? @break
                                    @case('sr-Cyrl') Да ли сте сигурни да желите да сачувате измене? @break
                                    @default Da li ste sigurni da želite da sačuvate izmene?
                                    @endswitch
                                </h3>
                                <button id="confirmSubmitBtn1" type="submit"
                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2"
                                    style="background: var(--accent); color: #fff;">
                                    @switch(App::getLocale())
                                    @case('en') Save @break
                                    @case('sr-Cyrl') Сачувај @break
                                    @default Sačuvaj
                                    @endswitch
                                </button>
                                <button data-modal-hide="submitModal1" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                    style="background: #cbd5e1; color: var(--primary-text);">
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
            <div class="prose dark:prose-invert max-w-none text-center" style="color: var(--secondary-text); font-family: var(--font-body);">
                {!! nl2br(e(__('question.description'))) !!}
            </div>
            @endauth

        </div>

        <form method="GET" action="{{ route('questions.index') }}">
            <div class="relative mb-24 mt-5" style="color: var(--secondary-text);">
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
                    style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                <div id="searchDropdown" class="absolute z-10 w-full rounded-lg mt-1 hidden"
                    style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);">
                    <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <div class="flex items-center">
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        style="color: var(--secondary-text); border: 1px solid var(--secondary-text); border-radius: 4px;">
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
                @auth
                <button 
                    id="createQuestionBtn"
                    type="button"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded text-base"
                    style="background: var(--accent); color: #fff;">
                    @switch(App::getLocale())
                    @case('en') Create question @break
                    @case('sr-Cyrl') Креирај питање @break
                    @default Kreiraj pitanje
                    @endswitch
                </button>
                @endauth
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
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </h2>

                <div id="accordion-body-{{ $question->id }}"
                    class="px-4 pb-4 text-gray-700 dark:text-gray-300 {{ $isOpen ? '' : 'hidden' }} relative">

                    <div class="answer-text p-1 break-words max-w-[90%]"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                        {!! nl2br(e($question->answer)) !!}
                    </div>

                    @auth
                    <button id="dropdownMenuIconButton"
                        class="inline-flex items-center p-2 text-sm font-medium text-center rounded-lg focus:ring-4 focus:outline-none"
                        type="button"
                        style="
                                position: absolute;
                                top: 8px;
                                right: 8px;
                                color: var(--primary-text);
                                margin-bottom: 4px; 
                                background: var(--primary-bg);
                                border: none;
                                cursor: pointer;
                            ">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>
                    <div class="dropdown-menu hidden absolute top-10 right-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded shadow-md z-20 text-left">
                        <button
                            class="dropdown-item px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 w-full text-left"
                            style="color: var(--primary-text); background: var(--primary-bg);"
                            data-action="rename"
                            data-id="{{ $question->id }}"
                            data-question="{{ $question->question }}"
                            data-answer="{{ $question->answer }}">
                            @switch(App::getLocale())
                            @case('en') Rename @break
                            @case('sr-Cyrl') Преименуј @break
                            @default Preimenuj
                            @endswitch
                        </button>

                        <button
                            class="dropdown-item px-4 py-1 text-red-600 hover:bg-red-100 dark:hover:bg-red-700 w-full text-left"
                            style="background: var(--primary-bg);"
                            data-action="delete"
                            data-id="{{ $question->id }}"
                            onclick="openDeleteModal({{ $question->id }})">
                            @switch(App::getLocale())
                            @case('en') Delete @break
                            @case('sr-Cyrl') Обриши @break
                            @default Obriši
                            @endswitch
                        </button>

                    </div>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>


        <div
            id="helpModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center"
            style="background: rgba(0,0,0,0.5);">
            <div class="relative w-full max-w-md p-6 rounded-lg shadow-lg"
                style="background: var(--primary-bg); color: var(--primary-text);">
                <button
                    onclick="toggleHelpModal()"
                    class="absolute top-2 right-2 text-2xl font-bold"
                    style="color: var(--secondary-text);">×</button>
                <h2 class="mb-4 text-xl font-bold text-center"
                    style="color: var(--primary-text);">
                    {{ App::getLocale() === 'en'
                            ? 'Help'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Помоћ'
                                : 'Pomoć') }}
                </h2>
                <p class="space-y-2 text-center"
                    style="color: var(--secondary-text);">
                    {!! App::getLocale() === 'en'
                    ? '
                    By clicking the <strong>“Edit”</strong> button, a text editing field will open on the page with the most frequently asked questions and answers.<br><br>
                    If you decide not to make changes or want to cancel, click the <strong>“Cancel”</strong> button, and the content will revert to its previous state without changes.<br><br>
                    To save the changes, click the <strong>“Save changes”</strong> button.<br>
                    You will be asked to confirm before the changes are applied.<br><br>
                    By clicking the <strong>“Create question”</strong> button, a form for creating a question and its answer will open.<br>
                    When you click the <strong>“Create question”</strong> button in the form, the question will be created. You can cancel the question creation by clicking the <strong>“Cancel”</strong> button.<br><br>
                    The text you enter in Serbian is automatically converted into another Serbian script and translated into English.
                    We recommend that you first enter the content in Serbian, save the changes, and then switch to English to check and possibly edit the translation.

                    '
                    : (App::getLocale() === 'sr-Cyrl'
                    ? '
                    Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за уређивање текста на страници где су најчешћа питања и одговори.<br><br>
                    Ако одлучите да не направите измене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                    Да бисте сачували измене, кликните на дугме <strong>„Сачувај промене“</strong>.<br>
                    Бићете упитани за потврду пре него што се промене примене.<br><br>
                    Кликом на дугме <strong>„Креирај питање“</strong> отвориће се форма за креирање питања и одговора на то питање.<br>
                    Када у форми кликнете на дугме <strong>„Креирај питање“</strong>, питање ће се креирати. На дугме <strong>„Откажи“</strong> можете отказати креирање питања.<br><br>
                    Текст који унесете на српском се аутоматски конвертује у друго српско писмо и преводи на енглески језик.
                    Препоручујемо да најпре унесете садржај на српском, сачувате измене, а затим се пребаците на енглески како бисте проверили и евентуално изменили превод.

                    '
                    : '
                    Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje teksta na stranici gde su najčešća pitanja i odgovori.<br><br>
                    Ako odlučite da ne napravite izmene ili želite da otkažete, kliknite na dugme <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje bez izmena.<br><br>
                    Da biste sačuvali izmene, kliknite na dugme <strong>„Sačuvaj promene“</strong>.<br>
                    Bićete upitani za potvrdu pre nego što se promene primene.<br><br>
                    Klikom na dugme <strong>„Kreiraj pitanje“</strong> otvoriće se forma za kreiranje pitanja i odgovora na to pitanje.<br>
                    Kada u formi kliknete na dugme <strong>„Kreiraj pitanje“</strong>, pitanje će se kreirati. Na dugme <strong>„Otkaži“</strong> možete otkazati kreiranje pitanja.<br><br>
                    Tekst koji unesete na srpskom se automatski konvertuje u drugo srpsko pismo i prevodi na engleski jezik.
                    Preporučujemo da najpre unesete sadržaj na srpskom, sačuvate izmene, a zatim se prebacite na engleski kako biste proverili i eventualno izmenili prevod.
                    '
                    )
                    !!}
                </p>
            </div>
        </div>
        <div
            id="createQuestionModal"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <button id="closeCreateQuestionModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">×</button>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">
                    @switch(App::getLocale())
                    @case('en') Create new question @break
                    @case('sr-Cyrl') Креирај ново питање @break
                    @default Kreiraj novo pitanje
                    @endswitch
                </h2>
                <form id="createQuestionForm" method="POST" action="{{ route('questions.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="newQuestion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            @switch(App::getLocale())
                            @case('en') Question @break
                            @case('sr-Cyrl') Питање @break
                            @default Pitanje
                            @endswitch
                        </label>
                        <input
                            type="text"
                            name="question"
                            id="newQuestion"
                            required
                            class="w-full p-2 border border-gray-300 dark:bg-gray-700 rounded" />
                    </div>
                    <div class="mb-4">
                        <label for="newAnswer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            @switch(App::getLocale())
                            @case('en') Answer @break
                            @case('sr-Cyrl') Одговор @break
                            @default Odgovor
                            @endswitch
                        </label>
                        <textarea
                            name="answer"
                            id="newAnswer"
                            rows="5"
                            required
                            class="w-full p-2 border border-gray-300 dark:bg-gray-700 rounded"></textarea>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button
                            type="button"
                            id="cancelCreateQuestionBtn"
                            class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded"
                            style="background: #cbd5e1; color: var(--primary-text);">
                            @switch(App::getLocale())
                            @case('en') Cancel @break
                            @case('sr-Cyrl') Откажи @break
                            @default Otkaži
                        @endswitch
                    </button>

                    <button 
                        type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded"
                        style="background: var(--accent); color: #fff;">
                        @switch(App::getLocale())
                            @case('en') Create question @break
                            @case('sr-Cyrl') Креирај питање @break
                            @default Kreiraj pitanje
                            @endswitch
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rename Modal -->
        <div id="renameModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <button id="closeRenameModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">×</button>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">{{ App::getLocale() === 'en' ? 'Rename Question' : (App::getLocale() === 'sr-Cyrl' ? 'Промени питање' : 'Promeni pitanje') }}</h2>
                <form id="renameForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="renameQuestionId" name="question_id" />
                    <div class="mb-4">
                        <label for="renameQuestion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ App::getLocale() === 'en' ? 'Question' : (App::getLocale() === 'sr-Cyrl' ? 'Питање' : 'Pitanje') }}</label>
                        <textarea id="renameQuestion" name="question" class="w-full p-2 border border-gray-300 dark:bg-gray-700 rounded" rows="2" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="renameAnswer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ App::getLocale() === 'en' ? 'Answer' : (App::getLocale() === 'sr-Cyrl' ? 'Одговор' : 'Odgovor') }}</label>
                        <textarea id="renameAnswer" name="answer" class="w-full p-2 border border-gray-300 dark:bg-gray-700 rounded" rows="5" required></textarea>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" id="cancelRenameBtn" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">{{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Затвори' : 'Zatvori') }}</button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">{{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="deleteModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-sm p-6 relative">
                <button id="closeDeleteModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">×</button>
                <p class="mb-6 text-center text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Are you sure you want to delete this question?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли ст есигурни да желите да обришете питање?' : 'Da li ste sigurni da želite da obrišete pitanje?') }}</p>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-4">
                        <button type="button" id="cancelDeleteBtn" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">{{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Затвори' : 'Zatvori') }}</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">{{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}</button>
                    </div>
                </form>
            </div>
        </div>



</x-guest-layout>

<script>
    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }

    document.getElementById('helpModal').addEventListener('click', function(event) {
        if (event.target === this) {
            toggleHelpModal();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const searchDropdown = document.getElementById('searchDropdown');
        const searchResults = document.getElementById('searchResults');
        const accordionButtons = document.querySelectorAll('[data-accordion-target]');
        const accordionContainer = document.getElementById('accordion-collapse');
        const globalSort = document.getElementById('globalSort');
        let selectedIndex = -1;

        if (globalSort) {
            globalSort.addEventListener('change', () => {
                const sortOrder = globalSort.value; 
                const questions = Array.from(accordionContainer.children);
                questions.sort((a, b) => {
                    const textA = a.querySelector('span').textContent.toLowerCase();
                    const textB = b.querySelector('span').textContent.toLowerCase();
                    if (sortOrder === 'title_asc') {
                        return textA.localeCompare(textB);
                    } else {
                        return textB.localeCompare(textA);
                    }
                });
                accordionContainer.innerHTML = '';
                questions.forEach(question => accordionContainer.appendChild(question));
            });
        } else {
            console.error('Element with ID globalSort not found');
        }

        if (searchInput && searchDropdown && searchResults) {
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                searchResults.innerHTML = '';
                searchDropdown.classList.toggle('hidden', !query);
                selectedIndex = -1;
                if (query) {
                    const allQuestions = Array.from(document.querySelectorAll('button[data-accordion-target]'));
                    const matchingQuestions = allQuestions.filter(button =>
                        button.querySelector('span').textContent.toLowerCase().includes(query)
                    );
                    matchingQuestions.forEach(button => {
                        const li = document.createElement('li');
                        li.className = 'p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';
                        li.textContent = button.querySelector('span').textContent;
                        li.dataset.questionId = button.dataset.questionId;
                        li.addEventListener('click', () => {
                            accordionButtons.forEach(btn => {
                                const targetId = btn.getAttribute('data-accordion-target').substring(1);
                                const description = document.getElementById(targetId);
                                const svgIcon = btn.querySelector('svg[data-accordion-icon]');
                                btn.setAttribute('aria-expanded', 'false');
                                description.style.display = 'none';
                                if (svgIcon) svgIcon.classList.remove('rotate-180');
                            });
                            const targetId = button.getAttribute('data-accordion-target').substring(1);
                            const description = document.getElementById(targetId);
                            const svgIcon = button.querySelector('svg[data-accordion-icon]');
                            button.setAttribute('aria-expanded', 'true');
                            description.style.display = 'block';
                            if (svgIcon) svgIcon.classList.add('rotate-180');
                            button.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                            searchDropdown.classList.add('hidden');
                            searchInput.value = '';
                            searchResults.innerHTML = '';
                        });
                        searchResults.appendChild(li);
                    });
                }
            });

            document.addEventListener('click', (e) => {
                const isButton = e.target.closest('button');
                const isHelpBtn = e.target.closest('#help-btn');
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target) && !isHelpBtn && !isButton) {
                    searchDropdown.classList.add('hidden');
                    selectedIndex = -1;
                }
            });
        } else {
            console.error('Search elements not found:', {
                searchInput,
                searchDropdown,
                searchResults
            });
        }

        accordionButtons.forEach(button => {
            button.addEventListener('click', () => {
                console.log('Accordion button clicked:', button.querySelector('span').textContent);
                const targetId = button.getAttribute('data-accordion-target').substring(1);
                const description = document.getElementById(targetId);
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                button.setAttribute('aria-expanded', !isExpanded);
                if (description) {
                    if (isExpanded) {
                        description.style.display = 'none';
                    } else {
                        description.style.display = 'block';
                    }
                }
                const svgIcon = button.querySelector('svg[data-accordion-icon]');
                if (svgIcon) {
                    if (isExpanded) {
                        svgIcon.classList.remove('rotate-180');
                    } else {
                        svgIcon.classList.add('rotate-180');
                    }
                }
            });
        });

        const editBtn = document.getElementById('editBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const saveEditBtn = document.getElementById('saveEditBtn');
        const confirmSubmitBtn = document.getElementById('confirmSubmitBtn1');
        const submitModal = document.getElementById('submitModal1');
        const contentDisplay = document.getElementById('contentDisplay');
        const contentEdit = document.getElementById('contentEdit');
        const editButtons = document.getElementById('editButtons');
        const editForm = document.getElementById('editForm');
        let originalContent = contentEdit ? contentEdit.value : '';

        if (editBtn) {
            editBtn.addEventListener('click', () => {
                console.log('Edit button clicked');
                contentDisplay.classList.add('hidden');
                contentEdit.classList.remove('hidden');
                editButtons.classList.remove('hidden');
                contentEdit.value = originalContent;
            });
        } else {
            console.error('Button with ID editBtn not found');
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', () => {
                console.log('Cancel edit button clicked');
                contentEdit.classList.add('hidden');
                contentDisplay.classList.remove('hidden');
                editButtons.classList.add('hidden');
                contentEdit.value = originalContent;
            });
        } else {
            console.error('Button with ID cancelEditBtn not found');
        }

        if (saveEditBtn) {
            saveEditBtn.addEventListener('click', () => {
                console.log('Save edit button clicked');
                submitModal.classList.remove('hidden');
            });
        } else {
            console.error('Button with ID saveEditBtn not found');
        }

        if (confirmSubmitBtn) {
            confirmSubmitBtn.addEventListener('click', () => {
                console.log('Confirm submit button clicked');
                submitModal.classList.add('hidden');
                editForm.submit();
            });
        } else {
            console.error('Button with ID confirmSubmitBtn1 not found');
        }

        document.querySelectorAll('[data-modal-hide="submitModal1"]').forEach(btn => {
            btn.addEventListener('click', () => {
                submitModal.classList.add('hidden');
            });
        });

        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            if (modal) {
                modal.classList.toggle('hidden');
            } else {
                console.error('Modal with ID helpModal not found');
            }
        }

        function toggleCreateQuestionModal() {
            const modal = document.getElementById('createQuestionModal');
            if (modal) {
                modal.classList.toggle('hidden');
            } else {
                console.error('Modal with ID createQuestionModal not found');
            }
        }

        function toggleRenameModal() {
            const modal = document.getElementById('renameModal');
            if (modal) {
                modal.classList.toggle('hidden');
            } else {
                console.error('Modal with ID renameModal not found');
            }
        }

        function toggleDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.toggle('hidden');
            } else {
                console.error('Modal with ID deleteModal not found');
            }
        }

        function openRenameModal(questionId, questionText, answerText) {
            toggleRenameModal();
            const form = document.getElementById('renameForm');
            if (form) {
                form.action = `/pitanja/${questionId}`;
                document.getElementById('renameQuestionId').value = questionId;
                document.getElementById('renameQuestion').value = questionText;
                document.getElementById('renameAnswer').value = answerText;
            } else {
                console.error('Form with ID renameForm not found');
            }
        }

        function openDeleteModal(questionId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            if (modal && form) {
                form.action = `/pitanja/${questionId}`;
                modal.classList.remove('hidden');
            } else {
                console.error('Delete modal or form not found');
            }
        }

        const helpBtn = document.getElementById('help-btn');
        if (helpBtn) {
            helpBtn.addEventListener('click', (e) => {
                e.stopPropagation(); 
                toggleHelpModal();
            });
        } else {
            console.error('Button with ID help-btn not found');
        }

        const createQuestionBtn = document.getElementById('createQuestionBtn');
        if (createQuestionBtn) {
            createQuestionBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleCreateQuestionModal();
            });
        } else {
            console.error('Button with ID createQuestionBtn not found');
        }

        const closeHelpModalBtn = document.getElementById('closeHelpModalBtn');
        if (closeHelpModalBtn) {
            closeHelpModalBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleHelpModal();
            });
        } else {
            console.error('Button with ID closeHelpModalBtn not found');
        }

        const closeCreateQuestionModalBtn = document.getElementById('closeCreateQuestionModalBtn');
        if (closeCreateQuestionModalBtn) {
            closeCreateQuestionModalBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                console.log('Close create question modal button clicked');
                toggleCreateQuestionModal();
            });
        } else {
            console.error('Button with ID closeCreateQuestionModalBtn not found');
        }

        const cancelCreateQuestionBtn = document.getElementById('cancelCreateQuestionBtn');
        if (cancelCreateQuestionBtn) {
            cancelCreateQuestionBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleCreateQuestionModal();
            });
        } else {
            console.error('Button with ID cancelCreateQuestionBtn not found');
        }

        const closeRenameModalBtn = document.getElementById('closeRenameModalBtn');
        if (closeRenameModalBtn) {
            closeRenameModalBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleRenameModal();
            });
        } else {
            console.error('Button with ID closeRenameModalBtn not found');
        }

        const cancelRenameBtn = document.getElementById('cancelRenameBtn');
        if (cancelRenameBtn) {
            cancelRenameBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleRenameModal();
            });
        } else {
            console.error('Button with ID cancelRenameBtn not found');
        }

        const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
        if (closeDeleteModalBtn) {
            closeDeleteModalBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDeleteModal();
            });
        } else {
            console.error('Button with ID closeDeleteModalBtn not found');
        }

        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDeleteModal();
            });
        } else {
            console.error('Button with ID cancelDeleteBtn not found');
        }

        document.addEventListener('click', (e) => {
            const modals = [
                document.getElementById('helpModal'),
                document.getElementById('createQuestionModal'),
                document.getElementById('renameModal'),
                document.getElementById('deleteModal'),
                document.getElementById('submitModal1')
            ];
            modals.forEach(modal => {
                if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('#dropdownMenuIconButton').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== button.nextElementSibling) {
                        menu.classList.add('hidden');
                    }
                });
                const dropdownMenu = button.nextElementSibling;
                if (dropdownMenu) {
                    dropdownMenu.classList.toggle('hidden');
                } else {
                    console.error('Dropdown menu not found for button');
                }
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        document.querySelectorAll('button[data-action="rename"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = button.getAttribute('data-id');
                const question = button.getAttribute('data-question');
                const answer = button.getAttribute('data-answer');
                openRenameModal(id, question, answer);
            });
        });

        document.querySelectorAll('button[data-action="delete"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = button.getAttribute('data-id');
                openDeleteModal(id);
            });
        });
    });
</script>