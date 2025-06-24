<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4">

        <!-- Glavni naslov -->
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-10">Podsetnici</h1>

        <!-- Forma za novi podsetnik -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Napravi novi podsetnik</h2>
            @if(session('success'))
                <div class="text-green-600 dark:text-green-400 font-medium mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('reminders.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Naziv</label>
                    <input type="text" name="title_en" id="title_en" required
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Datum</label>
                    <input type="text" id="datetime" name="date" required
                           class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="text-right">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-400 rounded-lg">
                        Sačuvaj
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista postojećih podsetnika -->
        <div class="bg-gray-100 dark:bg-gray-700 shadow rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Tvoji podsetnici</h2>

            @if ($reminders->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">Još nema podsetnika.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($reminders as $reminder)
                        <li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                            <div class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $reminder->title_lat }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Vreme: {{ \Carbon\Carbon::parse($reminder->time)->format('d.m.Y H:i') }}
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