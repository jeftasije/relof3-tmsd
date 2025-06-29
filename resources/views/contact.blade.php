<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Kontakt
        </h2>
    </x-slot>

    <div class="w-full">
        <section 
            class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat min-h-screen py-12" 
            style="background-image: url('/images/contact.jpg');">
           

            <div class="relative z-10 py-4 lg:py-12 px-6 mx-auto max-w-screen-md 
                rounded-lg shadow-lg transition-colors duration-300
                bg-white/80 dark:bg-gray-900/80">

                @auth
                    <div class="flex justify-end mb-2 mt-2">
                        <button 
                            id="help-btn" 
                            onclick="toggleHelpModal()"
                            class="flex items-center  text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
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
                <h2 class="mb-6 mt-8 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                    @switch(App::getLocale())
                    @case('en') Contact us @break
                    @case('sr-Cyrl') Контактирајте нас @break
                    @default Kontaktirajte nas
                    @endswitch
                </h2>
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
                <form action="{{ route('contact.update') }}" method="POST" id="contactForm" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div id="contentDisplay" class="prose dark:prose-invert max-w-none mb-8 text-center">
                        {{ __('contact.content') }}
                    </div>

                    <textarea name="content" id="contentEdit" rows="15" style="text-align: center;"
                        class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white hidden">{{ old('value', __('contact.content')) }}</textarea>

                    <div id="editButtons" class="flex justify-end gap-4 hidden">
                        <button type="button" id="cancelBtn"
                            class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">
                            @switch(App::getLocale())
                                @case('en') Cancel @break
                                @case('sr-Cyrl') Откажи @break
                                @default Otkaži
                            @endswitch
                        </button>

                        <button type="button" id="saveBtn" data-modal-target="submitModal" data-modal-toggle="submitModal"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
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
                                    <button data-modal-hide="submitModal" type="button"
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
            

                @php
                    $isEditor = auth()->check() && auth()->user()->isEditor();
                @endphp

                <form action="{{ route('contact.store') }}" method="POST"
                    class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
                    {{ $isEditor ? 'onsubmit=return false;' : '' }}>
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block mb-2 mt-8 text-sm font-medium text-gray-900 dark:text-white"> 
                                @switch(App::getLocale())
                                @case('en') First name @break
                                @case('sr-Cyrl') Име @break
                                @default Ime
                                @endswitch
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="first_name" name="first_name" required 
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5" 
                                placeholder="Pera" value="{{ old('first_name') }}">
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 mt-8 text-sm font-medium text-gray-900 dark:text-white"> 
                                @switch(App::getLocale())
                                @case('en') Last name @break
                                @case('sr-Cyrl') Презиме @break
                                @default Prezime
                                @endswitch
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" required
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5 "
                                placeholder="Perić" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="name@example.com" value="{{ old('email') }}">
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                @switch(App::getLocale())
                                @case('en') Phone @break
                                @case('sr-Cyrl') Телефон @break
                                @default Telefon
                                @endswitch
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="+381..." value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> 
                            @switch(App::getLocale())
                            @case('en') Message @break
                            @case('sr-Cyrl') Порука @break
                            @default Poruka
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required
                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                focus:border-grey-200 block w-full p-2.5"
                            placeholder="Vaša poruka...">{{ old('message') }}</textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded sm:w-auto text-center">
                            @switch(App::getLocale())
                                @case('en') Send message @break
                                @case('sr-Cyrl') Пошаљи поруку @break
                                @default Pošalji poruku
                            @endswitch
                        </button>
                    </div>
                </form>

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
function clearAnswer() {
    document.getElementById('answer-textarea').value = '';
}
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
    const modal = document.getElementById('submitModal');
    const form = document.getElementById('contactForm');
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
