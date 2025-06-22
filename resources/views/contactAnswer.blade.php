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

    <form>
        <div class="py-12 bg-gray-100 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                        <p><strong>Telefon:</strong> {{ $message->phone ?? 'Nije unet' }}</p>
                        <p><strong>Poruka:</strong> {{ $message->message }}</p>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                @switch(App::getLocale())
                                @case('en') Answer: @break
                                @case('sr-Cyrl') Одговор: @break
                                @default Odgovor:
                                @endswitch
                            </label>
                            <textarea name="answer" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white p-2"></textarea>

                            <div class="mt-2 flex space-x-2 justify-end">
                                <button type="reset"
                                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
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
                    </div>
                @endforeach

            </div>
        </div>
    </form>
    @endauth
</x-app-layout>
