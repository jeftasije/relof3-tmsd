<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4">

        <!-- Glavni naslov -->
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-10">{{ App::getLocale() === 'en' ? 'Reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Подсетници' : 'Podsetnici') }}</h1>

        <!-- Forma za novi podsetnik -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Make your reminder' : (App::getLocale() === 'sr-Cyrl' ? 'Направи свој подсетник' : 'Napravi novi podsetnik') }}</h2>
            @if(session('success'))
                <div class="text-green-600 dark:text-green-400 font-medium mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('reminders.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ App::getLocale() === 'en' ? 'Name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив' : 'Naziv') }}</label>
                    <input type="text" name="title_en" id="title_en" required
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ App::getLocale() === 'en' ? 'Date & time' : (App::getLocale() === 'sr-Cyrl' ? 'Датум и време' : 'Datum i vreme') }}</label>
                    <input type="text" id="datetime" name="date" required
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg py-3 px-8 rounded-lg">
                        {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista postojećih podsetnika -->
        <div class="bg-gray-100 dark:bg-gray-700 shadow rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Your reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Твоји подсетници' : 'Tvoji podsetnici') }}</h2>

            @if ($reminders->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">{{ App::getLocale() === 'en' ? 'Still no reminders' : (App::getLocale() === 'sr-Cyrl' ? 'Још нема подстеника' : 'Još nema podsetnika.') }}</p>
            @else
                <ul class="space-y-4">
                    @foreach ($reminders as $reminder)
                        <li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                            <div class="text-lg font-medium text-gray-900 dark:text-white">
                                @switch(App::getLocale())
                                @case('en') {{ $reminder->title_en }} @break
                                @case('sr-Cyrl') {{ $reminder->title_cyr }} @break
                                @default {{ $reminder->title_lat }}
                                @endswitch
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ App::getLocale() === 'en' ? 'Time:' : (App::getLocale() === 'sr-Cyrl' ? 'Време:' : 'Vreme:') }} {{ \Carbon\Carbon::parse($reminder->time)->format('d.m.Y H:i') }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
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
</script>

</x-app-layout>