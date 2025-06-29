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
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white text-center mb-2 mt-8">
            @switch(App::getLocale())
                @case('en') Complaints overview @break
                @case('sr-Cyrl') Преглед жалби @break
                @default Pregled žalbi
            @endswitch
        </h2>
        <p class="mb-4 font-light text-center text-gray-600 dark:text-gray-300 sm:text-lg max-w-3xl mx-auto">
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
        <form>
            <div class="py-12 bg-gray-100 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                                    @case('en')
                                        {{ $complaint->subject_en }}
                                        @break
                                    @case('sr-Cyrl')
                                        {{ $complaint->subject_cy }}
                                        @break
                                    @default
                                        {{ $complaint->subject }}
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
                                    @case('en')
                                        {{ $complaint->message_en }}
                                        @break
                                    @case('sr-Cyrl')
                                        {{ $complaint->message_cy }}
                                        @break
                                    @default
                                        {{ $complaint->message }}
                                @endswitch
                            </p>

                            <div class="mt-4">
                                @if (!$complaint->answer)
                                    <form method="POST" action="{{ route('complaints.answer', $complaint->id) }}" onsubmit="return confirm('Da li ste sigurni da želite da pošaljete odgovor?')">
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
                                        <p class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-3 rounded">{{ $complaint->answer }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </form>
    @endauth
</x-app-layout>
