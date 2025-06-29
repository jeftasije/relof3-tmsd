<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            @switch(App::getLocale())
                @case('en') Messages @break
                @case('sr-Cyrl') Поруке @break
                @default Poruke
            @endswitch
        </h2>
    </x-slot>

    @auth
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-end">
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
            <h2 class="text-4xl font-bold text-gray-800 dark:text-white text-center mb-2 mt-8">
                @switch(App::getLocale())
                    @case('en') Contacting overview @break
                    @case('sr-Cyrl') Преглед контактирања @break
                    @default Pregled kontaktiranja
                @endswitch
            </h2>
            <p class="mb-4 font-light text-center text-gray-600 dark:text-gray-300 sm:text-lg max-w-3xl mx-auto">
                @switch(App::getLocale())
                    @case('en')
                        View and manage all user contacts, questions, and requests in one place. Respond promptly to provide the best support.
                        @break
                    @case('sr-Cyrl')
                        Прегледајте и управљајте свим корисничким контактима, питањима и захтевима на једном месту. Одговарајте правовремено како бисте пружили најбољу подршку.
                        @break
                    @default
                        Pregledajte i upravljajte svim korisničkim kontaktima, pitanjima i zahtevima na jednom mestu. Odgovarajte pravovremeno kako biste pružili najbolju podršku.
                @endswitch
            </p>
            <form method="GET" class="mb-6 bg-white dark:bg-gray-800 p-4 rounded shadow space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum od</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum do</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ima odgovor?</label>
                        <select name="has_answer" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">—</option>
                            <option value="1" {{ request('has_answer') === '1' ? 'selected' : '' }}>Da</option>
                            <option value="0" {{ request('has_answer') === '0' ? 'selected' : '' }}>Ne</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-blue-600 text-white py-4 mt-2 mb-2 rounded hover:bg-blue-700 w-full text-lg">
                            @switch(App::getLocale())
                                @case('en') Filter @break
                                @case('sr-Cyrl') Филтрирај @break
                                @default Filtriraj
                            @endswitch
                        </button>

                        <a href="{{ route('contact.index') }}" class="bg-gray-400 text-white py-4 mt-2 mb-2 text-lg rounded hover:bg-gray-500 w-full text-center">
                            @switch(App::getLocale())
                                @case('en') Reset @break
                                @case('sr-Cyrl') Ресетуј @break
                                @default Resetuj
                            @endswitch
                        </a>
                    </div>

                </div>
            </form>



            @foreach ($messages as $message)
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow dark:text-gray-300">
                    <p><strong>
                        @switch(App::getLocale())
                        @case('en') Name: @break
                        @case('sr-Cyrl') Име: @break
                        @default Ime:
                        @endswitch
                    </strong> {{ $message->first_name }} {{ $message->last_name }}</p>
                    <p><strong>Email:</strong> {{ $message->email ?? 'Nije unet' }}</p>
                    <p><strong>
                        @switch(App::getLocale())
                        @case('en') Phone: @break
                        @case('sr-Cyrl') Телефон: @break
                        @default Telefon:
                        @endswitch
                    </strong> {{ $message->phone ?? 'Nije unet' }}</p>
                    <p><strong>
                        @switch(App::getLocale())
                        @case('en') Message: @break
                        @case('sr-Cyrl') Порука: @break
                        @default Poruka:
                        @endswitch
                    </strong> 
                        @switch(App::getLocale())
                        @case('en') {{ $message->message_en }} @break
                        @case('sr-Cyrl') {{ $message->message_cy }} @break
                        @default {{ $message->message }}
                        @endswitch
                    </p>

                    <div class="mt-4">
                        @if (!$ contact->answer)
                            <form method="POST" id="contactAnswerForm" action="{{ route('contact.answer', $ contact->id) }}" onsubmit="return openConfirmModal(this)">
                                @csrf
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        @switch(App::getLocale())
                                            @case('en') Answer: @break
                                            @case('sr-Cyrl') Одговор: @break
                                            @default Odgovor:
                                        @endswitch
                                    </label>
                                    <textarea name="answer" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white p-2" required></textarea>

                                    <div class="mt-2 flex space-x-2 justify-end">
                                        <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                                            @switch(App::getLocale())
                                                @case('en') Cancel @break
                                                @case('sr-Cyrl') Откажи @break
                                                @default Otkaži
                                            @endswitch
                                        </button>

                                        <button type="button" id="sendAnswerBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                            @switch(App::getLocale())
                                                @case('en') Send answer @break
                                                @case('sr-Cyrl') Пошаљи одговор @break
                                                @default Pošalji odgovor
                                            @endswitch
                                        </button>
                                    </div>
                                </div>
                                <!-- Confirm Answer Submission Modal -->
                                <div id="submitAnswerModal" tabindex="-1"
                                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-4">
                                            @switch(App::getLocale())
                                                @case('en') Are you sure you want to send the answer? @break
                                                @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете одговор? @break
                                                @default Da li ste sigurni da želite da pošaljete odgovor?
                                            @endswitch
                                        </h3>
                                        <div class="flex justify-center gap-4">
                                            <button type="button" id="confirmSendBtn"
                                                class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                                @switch(App::getLocale())
                                                    @case('en') Send @break
                                                    @case('sr-Cyrl') Пошаљи @break
                                                    @default Pošalji
                                                @endswitch
                                            </button>
                                            <button type="button" data-modal-hide="submitAnswerModal"
                                                class="bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white font-medium rounded-lg text-sm px-5 py-2.5">
                                                @switch(App::getLocale())
                                                    @case('en') Cancel @break
                                                    @case('sr-Cyrl') Откажи @break
                                                    @default Otkaži
                                                @endswitch
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        @else
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    @switch(App::getLocale())
                                        @case('en') Your Answer: @break
                                        @case('sr-Cyrl') Ваш одговор: @break
                                        @default Vaš odgovor:
                                    @endswitch
                                </label>
                                <p class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-3 rounded">
                                    @switch(App::getLocale())
                                        @case('en') {{ $ message->answer_en ?? $ message->answer }} @break
                                        @case('sr-Cyrl') {{ $ message->answer_cy ?? $ message->answer }} @break
                                        @default {{ $ message->answer }}
                                    @endswitch
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="mt-6">
                {{ $message->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
    @endauth
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
                    In the answer field, you can write your response to a contact question by a user.
                    You may write the response in Serbian (Cyrillic or Latin) or in English — the system will automatically translate it into the other languages based on the language of the page.
                    <br><br>
                    If you decide not to respond yet, click the <strong>“Cancel”</strong> button to discard the input without saving.
                    <br><br>
                    If you’re ready to submit your response, click the <strong>“Send answer”</strong> button.
                    A confirmation popup will appear before sending, to make sure you want to proceed.
                    <br><br>
                    After submission, your response will be displayed below the contact.
                    <strong>You will not be able to edit the answer once it has been sent.</strong>
                    '
                    : (App::getLocale() === 'sr-Cyrl' 
                    ? '
                        У пољу за одговор можете унети свој одговор на питање које је корисник послао.
                        Текст можете написати на српском језику (ћирилицом или латиницом) или на енглеском — систем ће аутоматски превести одговор на остале језике, у зависности од језика странице.
                        <br><br>
                        Ако одлучите да још не желите да одговорите, кликните на дугме <strong>„Откажи“</strong> и унос ће бити обрисан без чувања.
                        <br><br>
                        Ако сте спремни да пошаљете одговор, кликните на дугме <strong>„Пошаљи одговор“</strong>.
                        Пре слања, приказаће се потврда да бисте били сигурни да желите да наставите.
                        <br><br>
                        Након слања, ваш одговор ће бити приказан испод жалбе.
                        <strong>Одговор није могуће мењати након што је послат.</strong>
                    '
                    : '
                        U polju za odgovor možete uneti svoj odgovor na pitanje koje je korisnik poslao.
                        Tekst možete napisati na srpskom jeziku (ćirilicom ili latinicom) ili na engleskom — sistem će automatski prevesti odgovor na ostale jezike, u zavisnosti od jezika stranice.
                        <br><br>
                        Ako odlučite da još ne želite da odgovorite, kliknite na dugme <strong>„Otkaži“</strong> i unos će biti obrisan bez čuvanja.
                        <br><br>
                        Ako ste spremni da pošaljete odgovor, kliknite na dugme <strong>„Pošalji odgovor“</strong>.
                        Pre slanja, prikazaće se potvrda da biste bili sigurni da želite da nastavite.
                        <br><br>
                        Nakon slanja, vaš odgovor će biti prikazan ispod žalbe.
                        <strong>Odgovor nije moguće menjati nakon što je poslat.</strong>
                    '
                    )
                !!}
            </p>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const sendBtn = document.getElementById('sendAnswerBtn'); 
        const confirmModal = document.getElementById('submitAnswerModal');
        const confirmSendBtn = document.getElementById('confirmSendBtn');
        const form = document.getElementById('contactAnswerForm'); 

        sendBtn?.addEventListener('click', () => {
            confirmModal.classList.remove('hidden');
        });

        confirmSendBtn?.addEventListener('click', () => {
            confirmModal.classList.add('hidden');
            form.submit();
        });

        document.querySelectorAll('[data-modal-hide="submitAnswerModal"]').forEach((el) => {
            el.addEventListener('click', () => {
                confirmModal.classList.add('hidden');
            });
        });
    });



    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');

    dateFrom.addEventListener('change', function() {
        if (dateFrom.value) {
            dateTo.min = dateFrom.value;

            if (dateTo.value && dateTo.value < dateFrom.value) {
                dateTo.value = dateFrom.value;
            }
        } else {
            dateTo.min = '';
        }
    });

    window.addEventListener('load', () => {
        if (dateFrom.value) {
            dateTo.min = dateFrom.value;
            if (dateTo.value && dateTo.value < dateFrom.value) {
                dateTo.value = dateFrom.value;
            }
        }
    });
</script>