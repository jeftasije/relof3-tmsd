<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="relative flex items-center justify-center mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full">{{ App::getLocale() === 'en' ? 'Reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Подсетници' : 'Podsetnici') }}</h1>
            <div class="absolute right-0">
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
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-lg rounded-xl p-6 mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Make your reminder' : (App::getLocale() === 'sr-Cyrl' ? 'Направи свој подсетник' : 'Napravi novi podsetnik') }}</h2>
            @if(session('success'))
                <div class="text-green-600 dark:text-green-400 font-medium mb-4">
                    @switch(App::getLocale())
                    @case('en') Reminder created successfully @break
                    @case('sr-Cyrl') Подсетник успешно направљен @break
                    @default Podsetnik uspešno napravljen 
                    @endswitch
                </div>
            @endif
            <form action="{{ route('reminders.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ App::getLocale() === 'en' ? 'Name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив' : 'Naziv') }}</label>
                    <input type="text" name="title_en" id="title_en" required
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ App::getLocale() === 'en' ? 'Date & time' : (App::getLocale() === 'sr-Cyrl' ? 'Датум и време' : 'Datum i vreme') }}</label>
                    <input type="text" id="datetime" name="date" required
                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>
                <div class="text-right">
                    <button type="submit"
                        class=" bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-semibold text-lg py-3 px-8 rounded-lg shadow-md transition">
                        {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                    </button>
                </div>
            </form>
        </div>
        <form method="GET" action="{{ route('reminders.index') }}" class="mb-6 flex gap-4 items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search', $search ?? '') }}"
                placeholder="{{ App::getLocale() === 'en' ? 'Search by name' : (App::getLocale() === 'sr-Cyrl' ? 'Претрага по називу' : 'Pretraga po nazivu') }}"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition" 
            />
            <select name="sort" class="border rounded p-2  text-gray-900 dark:text-white dark:bg-gray-700 dark:border-gray-600">
                <option value="asc"  text-gray-900 dark:text-white {{ (request('sort', $sort ?? '') === 'asc') ? 'selected' : '' }}>
                    {{ App::getLocale() === 'en' ? 'Oldest first' : (App::getLocale() === 'sr-Cyrl' ? 'Први старији' : 'Prvi stariji') }}
                </option>
                <option value="desc"  text-gray-900 dark:text-white {{ (request('sort', $sort ?? '') === 'desc') ? 'selected' : '' }}>
                    {{ App::getLocale() === 'en' ? 'Newest first' : (App::getLocale() === 'sr-Cyrl' ? 'Први новији' : 'Prvi noviji') }}
                </option>
            </select>
                <button type="submit"
                    class="bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-semibold text-lg py-2 px-6 rounded-lg shadow-md transition">
                {{ App::getLocale() === 'en' ? 'Apply' : (App::getLocale() === 'sr-Cyrl' ? 'Примени' : 'Primeni') }}
            </button>
        </form>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-lg rounded-xl p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Your reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Твоји подсетници' : 'Tvoji podsetnici') }}</h2>
            @if ($reminders->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">{{ App::getLocale() === 'en' ? 'Still no reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Још нема подстеника' : 'Još nema podsetnika.') }}</p>
            @else
                <ul class="space-y-4">
                    @foreach ($reminders as $reminder)
                        <li class="relative bg-white dark:bg-gray-800 p-4 rounded-lg shadow" data-reminder-id="{{ $reminder->id }}">
                            <div class="flex justify-between items-start">
                                <div class="text-lg font-medium text-gray-900 dark:text-white">
                                    @switch(App::getLocale())
                                        @case('en') {{ $reminder->title_en }} @break
                                        @case('sr-Cyrl') {{ $reminder->title_cyr }} @break
                                        @default {{ $reminder->title_lat }}
                                    @endswitch
                                </div>
                                <div class="relative">
                                    <button id="dotsMenuButton{{ $reminder->id }}" data-dropdown-toggle="dropdownDots{{ $reminder->id }}"
                                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 4 15" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <div id="dropdownDots{{ $reminder->id }}"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dotsMenuButton{{ $reminder->id }}">
                                            <li>
                                                <button
                                                    data-modal-target="renameModal"
                                                    data-modal-toggle="renameModal"
                                                    data-id="{{ $reminder->id }}"
                                                    data-title="@switch(App::getLocale()) @case('en') {{ $reminder->title_en }} @break @case('sr-Cyrl') {{ $reminder->title_cyr }} @break @default {{ $reminder->title_lat }} @endswitch"
                                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                >
                                                    {{ App::getLocale() === 'en' ? 'Change' : (App::getLocale() === 'sr-Cyrl' ? 'Промени' : 'Promeni') }}
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    data-modal-target="deleteModal"
                                                    data-modal-toggle="deleteModal"
                                                    data-id="{{ $reminder->id }}"
                                                    data-title="@switch(App::getLocale()) @case('en') {{ $reminder->title_en }} @break @case('sr-Cyrl') {{ $reminder->title_cyr }} @break @default {{ $reminder->title_lat }} @endswitch"
                                                    class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                >
                                                    {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ App::getLocale() === 'en' ? 'Time:' : (App::getLocale() === 'sr-Cyrl' ? 'Време:' : 'Vreme:') }} {{ \Carbon\Carbon::parse($reminder->time)->format('d.m.Y H:i') }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            {{ App::getLocale() === 'en' ? 'Are you sure you want to delete?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете?' : 'Da li ste sigurni da želite da obrišete?') }} "<span id="deleteModalTitle"></span>"?
                        </h3>
                        <button
                            data-modal-hide="deleteModal"
                            id="confirmDeleteButtonReminder"
                            type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                        >
                            {{ App::getLocale() === 'en' ? 'Confirm' : (App::getLocale() === 'sr-Cyrl' ? 'Потврди' : 'Potvrdi') }}
                        </button>
                        <button
                            data-modal-hide="deleteModal"
                            type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600"
                        >
                            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-6">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            {{ App::getLocale() === 'en' ? 'Change the reminder' : (App::getLocale() === 'sr-Cyrl' ? 'Промени подсетник' : 'Promeni podsetnik') }}
                        </h3>
                        <input
                            type="text"
                            id="renameInput"
                            class="w-full mb-4 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400"
                            placeholder="{{ App::getLocale() === 'en' ? 'Enter a new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}"
                        >

                        <input
                            type="text"
                            id="renameDateInput"
                            class="w-full mb-4 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400"
                            placeholder="{{ App::getLocale() === 'en' ? 'Enter new date and time' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови датум и време' : 'Unesite novi datum i vreme') }}"
                        >

                        <div class="text-center">
                            <button
                                data-modal-hide="renameModal"
                                id="confirmRenameButton"
                                type="button"
                                class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            >
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                            <button
                                data-modal-hide="renameModal"
                                type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600"
                            >
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
                <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </h2>
                <p class="text-gray-700 dark:text-gray-300 space-y-2">
                    {!! App::getLocale() === 'en'
                        ? '<strong>Reminders</strong> are used to remind you to upoad something on your page.</br></br>If you want to create a <strong>new reminder</strong>, you need to enter a title in the form on the page (something that will remind you what needs to be posted) and select the time and date when you want the notification to appear (<strong>the bell</strong> in the top right corner).</br></br>By clicking the save button, you will save the created reminder.</br>Each reminder can be <strong>edited</strong> (both the title and the time) or <strong>deleted</strong> if it is no longer needed.</br></br>Below the form for creating a new reminder, you can see all your reminders.'
                        : (App::getLocale() === 'sr-Cyrl'
                            ? '<strong>Подсетници</strong> служе да Вас подсете да објавите на Вашој страници.</br></br>Уколико желите да направите <strong>нови подсетник</strong>, треба да у форми на страници унесете назив (нешто што ће Вас подсетити шта треба да објавите) и да изаберете време и датум када желите да Вам се прикаже нотификација (<strong>звоно</strong> у горњем десном углу).</br></br>Притиском на дугме сачувај, сачуваћете направљени подсетник.</br>Сваки подсетник можете <strong>изменити</strong> (и назив и време) и <strong>обрисати</strong> уколико Вам ипак није потребан.</br></br>Испод форме за креирање новог подсетника можете видети све Ваше подсетнике.'
                            : '<strong>Podsetnici</strong> služe da Vas podsete da objavite podatke na Vašoj stranici.</br></br>Ukoliko želite da napravite <strong>novi podsetnik</strong>, treba da u formi na stranici unesete naziv (nešto što će Vas podsetiti šta treba da objavite) i da izaberete vreme i datum kada želite da Vam se prikaže notifikacija (<strong>zvono</strong> u gornjem desnom uglu).</br></br>Pritiskom na dugme sačuvaj, sačuvaćete napravljeni podsetnik.</br>Svaki podsetnik možete <strong>izmeniti</strong> (i naziv i vreme) i <strong>obrisati</strong> ukoliko Vam ipak nije potreban.</br></br>Ispod forme za kreiranje novog podsetnika možete videti sve Vaše podsetnike.')
                    !!}
                </p>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/sr.js"></script>
    <script>
        @if (session('success'))
            if (typeof fetchReminders === 'function') {
                fetchReminders();
            }
            if (typeof fetchRemindersCount === 'function') {
                fetchRemindersCount();
            }
        @endif
        flatpickr("#datetime", {
            enableTime: true,
            dateFormat: "d.m.Y H:i",
            locale: "en"
        });
        flatpickr("#renameDateInput", {
            enableTime: true,
            dateFormat: "d.m.Y H:i",
            locale: "en"
        });

        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height } = chart;
                const ctx = chart.ctx;
                ctx.restore();
                const fontSize = (height / 5).toFixed(2);
                ctx.font = `${fontSize}px Arial`;
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#10B981";
                const text = "72%";
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        };

        const updateErrorMessage = @json(
            App::getLocale() === 'en' ? 'An error occurred while updating.' :
            (App::getLocale() === 'sr-Cyrl' ? 'Дошло је до грешке приликом ажурирања.' : 'Došlo je do greške prilikom ažuriranja.')
        );

        const updateConfirmationMessage = @json(
            App::getLocale() === 'en' ? 'The reminder changed successfully.' :
            (App::getLocale() === 'sr-Cyrl' ? 'Успешно ажуриран подсетник.' : 'Uspešno ažuriran podsetnik.')
        );

        const deleteErrorMessage = @json(
            App::getLocale() === 'en' ? 'An error occurred while deleting.' :
            (App::getLocale() === 'sr-Cyrl' ? 'Дошло је до грешке приликом брисања.' : 'Došlo je do greške prilikom brisanja.')
        );

        const deleteConfirmationMessage = @json(
            App::getLocale() === 'en' ? 'The reminder deleted successfully.' :
            (App::getLocale() === 'sr-Cyrl' ? 'Успешно обрисан подсетник.' : 'Uspešno obrisan podsetnik.')
        );

        let selectedReminderId = null;

        document.querySelectorAll('button[data-modal-target="deleteModal"]').forEach(button => {
            button.addEventListener('click', () => {
                selectedReminderId = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                document.getElementById('deleteModalTitle').textContent = title;
            });
        });

        document.querySelectorAll('button[data-modal-target="renameModal"]').forEach(button => {
            button.addEventListener('click', () => {
                selectedReminderId = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                document.getElementById('renameInput').value = title;
            });
        });

        document.getElementById('confirmRenameButton').addEventListener('click', async () => {
            const newTitle = document.getElementById('renameInput').value.trim();
            const newDate = document.getElementById('renameDateInput').value.trim();

            if (selectedReminderId && newTitle !== '') {
                const response = await fetch(`/podsetnici/${selectedReminderId}/preimenuj`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title_en: newTitle,
                        date: newDate
                    })
                });

                if (response.ok) {
                    location.reload();
                    alert(updateConfirmationMessage);
                    if (typeof fetchReminders === 'function') 
                        fetchReminders();

                    if (typeof fetchRemindersCount === 'function') 
                        fetchRemindersCount();
                } else {
                    alert(updateErrorMessage);
                }
            }
        });

        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.toggle('hidden');
        }

        document.getElementById('helpModal').addEventListener('click', function(event) {
            if (event.target === this) {
                toggleHelpModal();
            }
        });

        document.getElementById('confirmDeleteButtonReminder').addEventListener('click', async () => {
            if (confirmDeleteButtonReminder) {
                if (selectedReminderId) {
                    const response = await fetch(`/podsetnici/${selectedReminderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        alert(deleteConfirmationMessage);
                        document.querySelector(`[data-reminder-id="${selectedReminderId}"]`).remove();
                        if (typeof fetchReminders === 'function') 
                            fetchReminders();
                        
                        if (typeof fetchRemindersCount === 'function') 
                            fetchRemindersCount();           
                    }
                    else
                        alert(deleteErrorMessage);
                }
            }
            else{
                console.log('bravo majmune');
            }
        });
    </script>
</x-app-layout>