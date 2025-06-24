<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4">
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-10">{{ App::getLocale() === 'en' ? 'Reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Подсетници' : 'Podsetnici') }}</h1>
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
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-lg py-3 px-8 rounded-lg shadow-md transition">
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
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-lg py-2 px-6 rounded-lg shadow-md transition">
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
                            id="confirmDeleteButton"
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
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/sr.js"></script>
    <script>
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

        document.getElementById('confirmDeleteButton').addEventListener('click', async () => {
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
                }
                else
                    alert(deleteErrorMessage);
            }
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
                } else {
                    alert(updateErrorMessage);
                }
            }
        });
    </script>
</x-app-layout>