<x-guest-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 text-gray-900 dark:text-white">
        <div class="flex items-center justify-center relative mb-4
         mt-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full sm:mb-4 md:mb-6"
                style="color: var(--primary-text); font-family: var(--font-title);">
                @switch(App::getLocale())
                    @case('en') History @break
                    @case('sr-Cyrl') Историјат @break
                    @default Istorijat
                @endswitch
            </h1>
            @auth
                <div class="flex justify-end mb-2">
                    <button 
                        id="help-btn" 
                        onclick="toggleHelpModal()"
                        class="flex items-center text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group absolute right-0"
                        style="top: 35%; transform: translateY(-50%)"
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
        </div>

        @auth
            <div class="text-right mb-4">
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

        @if(session('success'))
            <div id="successMessage" class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded transition-opacity duration-500">
                {{ __('history.' . session('success')) }}
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
            <form action="{{ route('history.update') }}" method="POST" id="historyForm" class="space-y-4">
                @csrf
                @method('PATCH')
                <div id="contentDisplay" class="prose dark:prose-invert max-w-none"
                    style="color: var(--secondary-text); font-family: var(--font-body);">
                    {!! __('history.content') !!}
                </div>

                <textarea name="content" id="contentEdit" rows="15" style="text-align: center;"
                    class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('history.content')) }}</textarea>

                <div id="editButtons" class="flex justify-end gap-4 hidden">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded"
                        style="background: #cbd5e1; color: var(--primary-text);">
                        @switch(App::getLocale())
                            @case('en') Cancel @break
                            @case('sr-Cyrl') Откажи @break
                            @default Otkaži
                        @endswitch
                    </button>

                    <button type="button" id="saveBtn" data-modal-target="submitModal" data-modal-toggle="submitModal"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                        style="background: var(--accent); color: #fff;">
                        @switch(App::getLocale())
                            @case('en') Save changes @break
                            @case('sr-Cyrl') Сачувај промене @break
                            @default Sačuvaj promene
                        @endswitch
                    </button>
                </div>

                <!-- Confirm Submission Modal -->
                <div id="submitModal" tabindex="-1"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
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
                                <button id="confirmSubmitBtn" type="button"
                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2"
                                    style="background: var(--accent); color: #fff;">
                                    @switch(App::getLocale())
                                        @case('en') Save @break
                                        @case('sr-Cyrl') Сачувај @break
                                        @default Sačuvaj
                                    @endswitch
                                </button>
                                <button data-modal-hide="submitModal" type="button"
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
            <div class="prose dark:prose-invert max-w-none"  style="color: var(--secondary-text); font-family: var(--font-body);">
                {!! nl2br(e(__('history.content'))) !!}
            </div>
        @endauth

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
                    By clicking the <strong>"Edit"</strong> button, a text area will open allowing you to edit the history content.<br><br>
                    You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected. <br> <br>
                    If you decide not to make changes or want to cancel, click the <strong>"Cancel"</strong> button and the content will revert to its previous state without changes.<br><br>
                    To save your edits, click the <strong>"Save"</strong> button.<br>
                    You will be asked to confirm before the changes are applied.<br><br>
                    The text you enter in Serbian is automatically converted into another Serbian script and translated into English.
                    We recommend that you first enter the content in Serbian, save the changes, and then switch to English to check and possibly edit the translation.
                    '
                    : (App::getLocale() === 'sr-Cyrl' 
                    ? '
                        Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за уређивање текста историјата.<br><br>
                        Садржај можете унети на енглеском или српском језику (ћирилицом или латиницом), а биће преведен на језик који сте изабрали. <br><br> 
                        Ако одлучите да не направите промене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                        Да бисте сачували измене, кликните на дугме <strong>„Сачувај“</strong>.<br>
                        Бићете упитани за потврду пре него што се промене примене.<br><br>
                        Текст који унесете на српском се аутоматски конвертује у друго српско писмо и преводи на енглески језик.
                        Препоручујемо да најпре унесете садржај на српском, сачувате измене, а затим се пребаците на енглески како бисте проверили и евентуално изменили превод.
                    '
                    : '
                        Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje teksta istorije.<br><br>
                        Ako odlučite da ne napravite promene ili želite da otkažete, kliknite na dugme <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje bez izmena.<br><br>
                        Da biste sačuvali izmene, kliknite na dugme <strong>„Sačuvaj“</strong>.<br>
                        Bićete upitani za potvrdu pre nego što se promene primene.<br><br>
                        Tekst koji unesete na srpskom se automatski konvertuje u drugo srpsko pismo i prevodi na engleski jezik.
                        Preporučujemo da najpre unesete sadržaj na srpskom, sačuvate izmene, a zatim se prebacite na engleski kako biste proverili i eventualno izmenili prevod.
                    '
                    )
                !!}
            </p>


        </div>
    </div>

</x-guest-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
    const modal = document.getElementById('submitModal');
    const form = document.getElementById('historyForm');
    const contentDisplay = document.getElementById('contentDisplay');
    const contentEdit = document.getElementById('contentEdit');
    const editButtons = document.getElementById('editButtons');

    editBtn.addEventListener('click', () => {
        contentDisplay.classList.add('hidden');
        contentEdit.classList.remove('hidden');
        editButtons.classList.remove('hidden');
        editBtn.classList.add('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        contentEdit.value = contentDisplay.innerText.replace(/\n/g, '\n');
        contentDisplay.classList.remove('hidden');
        contentEdit.classList.add('hidden');
        editButtons.classList.add('hidden');
        editBtn.classList.remove('hidden');
    });

    saveBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    confirmSubmitBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.submit();
    });

    document.querySelectorAll('[data-modal-hide="submitModal"]').forEach((el) => {
        el.addEventListener('click', () => {
            modal.classList.add('hidden');

            contentEdit.value = contentDisplay.innerText.replace(/\n/g, '\n');
            contentDisplay.classList.remove('hidden');
            contentEdit.classList.add('hidden');
            editButtons.classList.add('hidden');
            editBtn.classList.remove('hidden');
        });
    });
});

function toggleHelpModal() {
    const modal = document.getElementById('helpModal');
    modal.classList.toggle('hidden');
}

</script>

