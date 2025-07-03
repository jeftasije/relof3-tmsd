<x-app-layout>
    @php
    $locale = App::getLocale();
    $languageLabel = match($locale) {
    'en' => 'Translate to English',
    'sr-Cyrl' => 'Преведи на ћирилицу',
    default => 'Prevedi na latinicu',
    };
    @endphp
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

            @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                @click="show = false"
                class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
                style="top: 12%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 220px; text-align: center;"
                x-init="setTimeout(() => show = false, 4000)">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex justify-end">
                <button
                    id="help-btn"
                    onclick="toggleHelpModal()"
                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            @switch(App::getLocale())
                            @case('en') Date from: @break
                            @case('sr-Cyrl') Датум од: @break
                            @default Datum od:
                            @endswitch
                        </label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            @switch(App::getLocale())
                            @case('en') Date until: @break
                            @case('sr-Cyrl') Датум до: @break
                            @default Datum do:
                            @endswitch
                        </label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            @switch(App::getLocale())
                            @case('en') Is there an answer? @break
                            @case('sr-Cyrl') Има одговор? @break
                            @default Ima odgovor?
                            @endswitch
                        </label>
                        <select name="has_answer" class="w-full p-2 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">—</option>
                            <option value="1" {{ request('has_answer') === '1' ? 'selected' : '' }}>
                                @switch(App::getLocale())
                                @case('en') Yes @break
                                @case('sr-Cyrl') Да @break
                                @default Da
                                @endswitch
                            </option>
                            <option value="0" {{ request('has_answer') === '0' ? 'selected' : '' }}>
                                @switch(App::getLocale())
                                @case('en') No @break
                                @case('sr-Cyrl') Не @break
                                @default Ne
                                @endswitch
                            </option>
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
                        <button type="reset" id="reset-filter-btn" class="bg-gray-400 text-white py-4 mt-2 mb-2 text-lg rounded hover:bg-gray-500 w-full text-center">
                            @switch(App::getLocale())
                            @case('en') Reset @break
                            @case('sr-Cyrl') Ресетуј @break
                            @default Resetuj
                            @endswitch
                        </button>
                    </div>
                </div>
            </form>

            @foreach ($complaints as $complaint)
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow dark:text-gray-300 relative">
                <div class="absolute top-4 right-4">
                    @if($complaint->answer)
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">
                        @switch(App::getLocale())
                        @case('en') Answered @break
                        @case('sr-Cyrl') Одговорено @break
                        @default Odgovoreno
                        @endswitch
                    </span>
                    @else
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">
                        @switch(App::getLocale())
                        @case('en') Not answered @break
                        @case('sr-Cyrl') Није одговорено @break
                        @default Nije odgovoreno
                        @endswitch
                    </span>
                    @endif
                </div>

                <p><strong>
                        @switch(App::getLocale())
                        @case('en') Name: @break
                        @case('sr-Cyrl') Име: @break
                        @default Ime:
                        @endswitch
                    </strong> {{ $complaint->name }}</p>

                <p><strong>
                        @switch(App::getLocale())
                        @case('en') Email: @break
                        @case('sr-Cyrl') Мејл адреса: @break
                        @default Mejl adresa:
                        @endswitch
                    </strong> {{ $complaint->email }}</p>

                <p><strong>
                        @switch(App::getLocale())
                        @case('en') Phone: @break
                        @case('sr-Cyrl') Телефон: @break
                        @default Telefon:
                        @endswitch
                    </strong> {{ $complaint->phone ?? '-' }}</p>

                <div class="flex flex-row items-center">
                    <p><strong>
                            @switch(App::getLocale())
                            @case('en') Subject: @break
                            @case('sr-Cyrl') Наслов: @break
                            @default Naslov:
                            @endswitch
                        </strong>
                    </p>
                    <div x-data="{ showTranslatedMessage: false }" class="flex flex-row pl-1">
                        <div>
                            <p x-show="!showTranslatedMessage" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200" style="color: var(--primary-text);">
                                {{ $complaint->subject }}
                            </p>
                            <p x-show="showTranslatedMessage" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200" style="color: var(--primary-text);">
                                {{ $complaint->translate('subject') }}
                            </p>
                        </div>
                        <button
                            @click="showTranslatedMessage = !showTranslatedMessage"
                            class="text-sm text-blue-600 hover:underline pl-1" style="color: var(--accent);">
                            <template x-if="!showTranslatedMessage">
                                <span>{{ $languageLabel }}</span>
                            </template>
                            <template x-if="showTranslatedMessage">
                                <span>
                                    @switch($locale)
                                    @case('en') Show original @break
                                    @case('sr-Cyrl') Прикажи оригинал @break
                                    @default Prikaži original
                                    @endswitch
                                </span>
                            </template>
                        </button>
                    </div>
                </div>

                <p><strong>
                        @switch(App::getLocale())
                        @case('en') Message: @break
                        @case('sr-Cyrl') Порука: @break
                        @default Poruka:
                        @endswitch
                    </strong>
                </p>
                <div x-data="{ showTranslatedMessage: false }">
                    <div class="max-w-[90%] flex flex-row justify-between p-4 rounded bg-gray-50 dark:bg-gray-700 mt-2" style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                        <p x-show="!showTranslatedMessage" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200 break-words max-w-[90%]" style="color: var(--primary-text);">
                            {{ $complaint->message }}
                        </p>
                        <p x-show="showTranslatedMessage" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200 break-words max-w-[90%]" style="color: var(--primary-text);">
                            {{ $complaint->translate('message') }}
                        </p>
                    </div>
                    <button
                        @click="showTranslatedMessage = !showTranslatedMessage"
                        class="text-sm text-blue-600 hover:underline mb-2" style="color: var(--accent);">
                        <template x-if="!showTranslatedMessage">
                            <span>{{ $languageLabel }}</span>
                        </template>
                        <template x-if="showTranslatedMessage">
                            <span>
                                @switch($locale)
                                @case('en') Show original @break
                                @case('sr-Cyrl') Прикажи оригинал @break
                                @default Prikaži original
                                @endswitch
                            </span>
                        </template>
                    </button>
                </div>

                <div class="mt-4">
                    @if (!$complaint->answer)
                    <form method="POST" id="complaintAnswerForm-{{ $complaint->id }}" action="{{ route('complaints.answer', $complaint->id) }}" onsubmit="return openConfirmModal(this)">
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
                                <button type="button" class="sendAnswerBtn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" data-complaint-id="{{ $complaint->id }}">
                                    @switch(App::getLocale())
                                    @case('en') Send answer @break
                                    @case('sr-Cyrl') Пошаљи одговор @break
                                    @default Pošalji odgovor
                                    @endswitch
                                </button>
                            </div>
                        </div>

                        <div id="submitAnswerModal-{{ $complaint->id }}" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-4">
                                    @switch(App::getLocale())
                                    @case('en') Are you sure you want to send the answer? @break
                                    @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете одговор? @break
                                    @default Da li ste sigurni da želite da pošaljete odgovor?
                                    @endswitch
                                </h3>
                                <div class="flex justify-center gap-4">
                                    <button type="button" class="confirmSendBtn text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                        @switch(App::getLocale())
                                        @case('en') Send @break
                                        @case('sr-Cyrl') Пошаљи @break
                                        @default Pošalji
                                        @endswitch
                                    </button>
                                    <button type="button" data-modal-hide="submitAnswerModal-{{ $complaint->id }}" class="bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white font-medium rounded-lg text-sm px-5 py-2.5 cancelBtn">
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
                        <div x-data="{ showTranslatedAnswer: false }">
                            <div class="max-w-[90%] flex flex-row justify-between p-4 rounded bg-gray-50 dark:bg-gray-700 mt-2" style="color: var(--primary-text); border-color: var(--secondary-text);">
                                <p x-show="!showTranslatedAnswer" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200 break-words" style="color: var(--primary-text);">
                                    {{ $complaint->answer }}
                                </p>
                                <p x-show="showTranslatedAnswer" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200 break-words" style="color: var(--primary-text);">
                                    {{ $complaint->translate('answer') }}
                                </p>
                            </div>
                            <button
                                @click="showTranslatedAnswer = !showTranslatedAnswer"
                                class="text-sm text-blue-600 hover:underline mb-2" style="color: var(--accent);">
                                <template x-if="!showTranslatedAnswer">
                                    <span>{{ $languageLabel }}</span>
                                </template>
                                <template x-if="showTranslatedAnswer">
                                    <span>
                                        @switch($locale)
                                        @case('en') Show original @break
                                        @case('sr-Cyrl') Прикажи оригинал @break
                                        @default Prikaži original
                                        @endswitch
                                    </span>
                                </template>
                            </button>
                        </div>
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
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
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
</x-app-layout>

<script>
    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.sendAnswerBtn').forEach(sendBtn => {
            sendBtn.addEventListener('click', () => {
                const complaintId = sendBtn.getAttribute('data-complaint-id');
                const modal = document.getElementById(`submitAnswerModal-${complaintId}`);
                modal.classList.remove('hidden');

                const confirmSendBtn = modal.querySelector('.confirmSendBtn');
                const form = document.getElementById(`complaintAnswerForm-${complaintId}`);

                confirmSendBtn.onclick = () => {
                    modal.classList.add('hidden');
                    form.submit();
                };

                modal.querySelectorAll('.cancelBtn').forEach(cancelBtn => {
                    cancelBtn.onclick = () => modal.classList.add('hidden');
                });
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