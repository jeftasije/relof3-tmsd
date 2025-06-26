<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Žalbe i komentari
        </h2>
    </x-slot>

    <div class="w-full">
        <section 
            class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat py-12" 
            style="background-image: url('/images/comments.jpg');">
        
            <div class="absolute inset-0 bg-black/30"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-12 px-6 py-12">
                    <div class="flex flex-col">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                                @case('en') How to file a complaint? @break
                                @case('sr-Cyrl') Како поднети жалбу? @break
                                @default Kako podneti žalbu?
                            @endswitch
                        </h3>

                        <p class="mb-6 text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'If you have any complaints, suggestions, or questions regarding the work of our library, you can contact us in several ways:' : 'Ukoliko imate bilo kakvu primedbu, sugestiju ili pitanje vezano za rad naše biblioteke, možete nas kontaktirati na nekoliko načina:' }}
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 dark:text-gray-300 pl-4">
                            <p>
                                @if(App::getLocale() === 'en')
                                    <li>Fill out the online form on the right — your opinion is important to us and we will do our best to respond as soon as possible.</li>
                                    <li>Call us by phone at: <strong>+381 (0)20 331 010</strong> (weekdays from 08:00 to 16:00 and weekends from 08:00 to 14:00).</li>
                                    <li>Visit us in person at the library at: <strong>Stefana Nemanje 2, Novi Pazar</strong>, where you can directly talk to our staff and submit a complaint or give feedback.</li>
                                @else
                                    <li>Popunite online formu sa desne strane — vaše mišljenje nam je važno i potrudićemo se da odgovorimo u najkraćem roku.</li>
                                    <li>Pozovite nas telefonom na broj: <strong>+381 (0)20 331 010</strong> (radnim danima od 08:00 do 16:00 i vikendom od 08:00 do 14:00).</li>
                                    <li>Posetite nas lično u biblioteci na adresi: <strong>Stefana Nemanje 2, Novi Pazar</strong>, gde možete direktno razgovarati sa našim osobljem i podneti žalbu ili dati komentar.</li>
                                @endif
                            </p>
                        </ul>

                        <p class="mb-6 text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' 
                                ? 'Your feedback helps us improve our services and provide a better experience for all users.' 
                                : 'Vaš glas nam pomaže da unapredimo naše usluge i obezbedimo bolje iskustvo za sve korisnike.' }}
                        </p>

                        <div class="text-center mt-auto">
                            <a href="/documents/uputstvo_za_zalbe.pdf" 
                            class="inline-block text-blue-600 hover:underline dark:text-blue-400" 
                            download>
                                @switch(App::getLocale())
                                    @case('en') Download the instructions in PDF format @break
                                    @case('sr-Cyrl') Преузмите упутство у PDF формату @break
                                    @default Preuzmite uputstvo u PDF formatu
                                @endswitch
                            </a>
                        </div>

                    </div>

                    <div>
                        <h2 class="mb-4 text-3xl font-bold text-center text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                                @case('en') Every question, suggestion or criticism is welcome! @break
                                @case('sr-Cyrl') Свако Ваше питање, сугестија или критика је добродошла! @break
                                @default Svako Vaše pitanje, sugestija ili kritika je dobrodošla!
                            @endswitch
                        </h2>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!--<form action="{{ route('complaints.store') }}" method="POST" class="space-y-6"> -->
                        @php
                            $isEditor = auth()->check() && auth()->user()->isEditor();
                        @endphp

                        <form action="{{ route('complaints.store') }}" method="POST"
                            class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
                            {{ $isEditor ? 'onsubmit=return false;' : '' }}>
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        @switch(App::getLocale())
                                            @case('en') First name: @break
                                            @case('sr-Cyrl') Име: @break
                                            @default Ime:
                                        @endswitch
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('first_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        @switch(App::getLocale())
                                            @case('en') Last name: @break
                                            @case('sr-Cyrl') Презиме: @break
                                            @default Prezime:
                                        @endswitch
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ 'Email' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        @switch(App::getLocale())
                                            @case('en') Phone: @break
                                            @case('sr-Cyrl') Телефон: @break
                                            @default Telefon:
                                        @endswitch
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    @switch(App::getLocale())
                                        @case('en') Message: @break
                                        @case('sr-Cyrl') Порука: @break
                                        @default Poruka:
                                    @endswitch
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" rows="5" required
                                    class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">{{ old('message') }}</textarea>
                                @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-center">
                                <button type="button" id="openSubmitModal"
                                    class="py-3 px-5 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    @switch(App::getLocale())
                                        @case('en') Submit complaint @break
                                        @case('sr-Cyrl') Пошаљи жалбу @break
                                        @default Pošalji žalbu
                                    @endswitch
                                </button>

                            </div>
                        </form>
                        <!-- Confirm Submission Modal -->
                        <div id="submitModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full mx-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            @switch(App::getLocale())
                                                @case('en') Are you sure you want to submit the complaint? @break
                                                @case('sr-Cyrl') Да ли сте сигурни да желите да пошаљете жалбу? @break
                                                @default Da li ste sigurni da želite da pošaljete žalbu?
                                            @endswitch
                                        </h3>
                                        <button id="confirmSubmitBtn" type="button"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                            @switch(App::getLocale())
                                                @case('en') Confirm @break
                                                @case('sr-Cyrl') Потврди @break
                                                @default Potvrdi
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


                    </div>
                </div>

                <div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
                    <h2 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white text-center">
                        @switch(App::getLocale())
                            @case('en') Comments @break
                            @case('sr-Cyrl') Коментари @break
                            @default Komentari
                        @endswitch
                    </h2>
                        @if(session('success_comment'))
                        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                            {{ session('success_comment') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('comments.store') }}" class="mb-6 space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="text" name="name" placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                                    value="{{ old('name') }}" required
                                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200">
                                @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <textarea name="comment" rows="4"
                                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200"
                                    placeholder="{{ App::getLocale() === 'en' ? 'Write a comment...' : 'Napiši komentar...' }}"
                                    required>{{ old('comment') }}</textarea>
                                @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <button type="submit"
                                    class="px-5 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                    @switch(App::getLocale())
                                        @case('en') Send comment  @break
                                        @case('sr-Cyrl') Пошаљи коментар @break
                                        @default Pošalji komentar
                                    @endswitch
                                </button>
                            </div>
                        </form>


                        
                        @foreach($comments as $comment)
                            <article class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                                <header class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</h3>
                                    <time datetime="{{ $comment->created_at }}" class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d. F Y.') }}
                                    </time>
                                </header>
                                <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                            </article>
                        @endforeach


                </div>

            </div>
        </section>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openModalBtn = document.getElementById('openSubmitModal');
        const confirmBtn = document.getElementById('confirmSubmitBtn');
        const modal = document.getElementById('submitModal');
        const form = document.querySelector('form[action="{{ route('complaints.store') }}"]');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        confirmBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            form.submit();
        });

        document.querySelectorAll('[data-modal-hide="submitModal"]').forEach((el) => {
            el.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
</script>
