<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            @switch(App::getLocale())
                @case('en') Complaints @break
                @case('sr-Cyrl') Жалбе @break
                @default Žalbe
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
                        @case('en') Complaints overview @break
                        @case('sr-Cyrl') Преглед жалби @break
                        @default Pregled žalbi
                    @endswitch
                </h2>

                <p class="mb-6 font-light text-center text-gray-600 dark:text-gray-300 sm:text-lg max-w-3xl mx-auto">
                    @switch(App::getLocale())
                        @case('en')
                            Here you can review all complaints and suggestions submitted by users. Use this section to better understand their needs and improve your services through meaningful feedback.
                            @break
                        @case('sr-Cyrl')
                            Овде можете прегледати све жалбе и сугестије које су корисници послали. Искористите ову страницу како бисте разумели потребе корисника и унапредили ваше услуге одговарајућим повратним информацијама.
                            @break
                        @default
                            Ovde možete pregledati sve žalbe i sugestije koje su korisnici poslali. Iskoristite ovu stranicu kako biste razumeli potrebe korisnika i unapredili vaše usluge odgovarajućim povratnim informacijama.
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
                            <button type="submit" class="bg-blue-600 text-white py-4 rounded hover:bg-blue-700 w-full text-lg">
                                @switch(App::getLocale())
                                    @case('en') Filter @break
                                    @case('sr-Cyrl') Филтрирај @break
                                    @default Filtriraj
                                @endswitch
                            </button>

                            <a href="{{ route('complaints.index') }}" class="bg-gray-400 text-white py-4 text-lg rounded hover:bg-gray-500 w-full text-center">
                                @switch(App::getLocale())
                                    @case('en') Reset @break
                                    @case('sr-Cyrl') Ресетуј @break
                                    @default Resetuj
                                @endswitch
                            </a>
                        </div>

                    </div>
                </form>


                @foreach ($complaints as $complaint)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow dark:text-gray-300">
                        <p><strong>
                            @switch(App::getLocale())
                                @case('en') Name: @break
                                @case('sr-Cyrl') Име: @break
                                @default Ime:
                            @endswitch
                        </strong> {{ $complaint->name }}</p>

                        <p><strong>Email:</strong> {{ $complaint->email }}</p>

                        <p><strong>
                            @switch(App::getLocale())
                                @case('en') Phone: @break
                                @case('sr-Cyrl') Телефон: @break
                                @default Telefon:
                            @endswitch
                        </strong> {{ $complaint->phone ?? 'Nije unet' }}</p>

                        <p><strong>
                            @switch(App::getLocale())
                                @case('en') Subject: @break
                                @case('sr-Cyrl') Наслов: @break
                                @default Naslov:
                            @endswitch
                        </strong> 
                            @switch(App::getLocale())
                                @case('en') {{ $complaint->subject_en }} @break
                                @case('sr-Cyrl') {{ $complaint->subject_cy }} @break
                                @default {{ $complaint->subject }}
                            @endswitch
                        </p>

                        <p><strong>
                            @switch(App::getLocale())
                                @case('en') Message: @break
                                @case('sr-Cyrl') Порука: @break
                                @default Poruka:
                            @endswitch
                        </strong> 
                            @switch(App::getLocale())
                                @case('en') {{ $complaint->message_en }} @break
                                @case('sr-Cyrl') {{ $complaint->message_cy }} @break
                                @default {{ $complaint->message }}
                            @endswitch
                        </p>

                        <div class="mt-4">
                            @if (!$complaint->answer)
                                <form method="POST" action="{{ route('complaints.answer', $complaint->id) }}" onsubmit="return openConfirmModal(this)">
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

                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                                @switch(App::getLocale())
                                                    @case('en') Send answer @break
                                                    @case('sr-Cyrl') Пошаљи одговор @break
                                                    @default Pošalji odgovor
                                                @endswitch
                                            </button>
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
                                            @case('en') {{ $complaint->answer_en ?? $complaint->answer }} @break
                                            @case('sr-Cyrl') {{ $complaint->answer_cy ?? $complaint->answer }} @break
                                            @default {{ $complaint->answer }}
                                        @endswitch
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="mt-6">
                    {{ $complaints->appends(request()->all())->links() }}
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
                    In the answer field, you can write your response to a complaint or suggestion submitted by a user.
                    You may write the response in Serbian (Cyrillic or Latin) or in English — the system will automatically translate it into the other languages based on the language of the page.
                    <br><br>
                    If you decide not to respond yet, click the <strong>“Cancel”</strong> button to discard the input without saving.
                    <br><br>
                    If you’re ready to submit your response, click the <strong>“Send answer”</strong> button.
                    A confirmation popup will appear before sending, to make sure you want to proceed.
                    <br><br>
                    After submission, your response will be displayed below the complaint.
                    <strong>You will not be able to edit the answer once it has been sent.</strong>
                    '
                    : (App::getLocale() === 'sr-Cyrl' 
                    ? '
                        У пољу за одговор можете унети свој одговор на жалбу или сугестију коју је корисник послао.
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
                        U polju za odgovor možete uneti svoj odgovor na žalbu ili sugestiju koju je korisnik poslao.
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
    <div 
        id="confirmSendModal" 
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-sm p-6 relative">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">
                @switch(App::getLocale())
                    @case('en') Are you sure you want to send the answer? @break
                    @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете одговор? @break
                    @default Da li ste sigurni da želite da pošaljete odgovor?
                @endswitch
            </h3>
            <div class="flex justify-end space-x-4">
                <button 
                    type="button" 
                    onclick="toggleConfirmSendModal(false)"
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500"
                >
                    @switch(App::getLocale())
                        @case('en') Cancel @break
                        @case('sr-Cyrl') Откажи @break
                        @default Otkaži
                    @endswitch
                </button>
                <button 
                    type="button" 
                    id="confirmSendBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    @switch(App::getLocale())
                        @case('en') Send answer @break
                        @case('sr-Cyrl') Пошаљи одговор @break
                        @default Pošalji odgovor
                    @endswitch
                </button>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }

    let formToSubmit = null;

    function openConfirmModal(form) {
        formToSubmit = form; 
        toggleConfirmSendModal(true);
        return false; 
    }

    function toggleConfirmSendModal(show) {
        const modal = document.getElementById('confirmSendModal');
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    document.getElementById('confirmSendBtn').addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit(); 
        }
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
