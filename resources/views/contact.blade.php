<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Kontakt
        </h2>
    </x-slot>

    <div class="w-full">
        <section 
            class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat min-h-screen py-12" 
            style="background-image: url('/images/contact.jpg');">
        
            <div class="absolute inset-0 bg-black/30"></div>

            <div class="relative z-10 py-8 lg:py-16 px-6 mx-auto max-w-screen-md 
                rounded-lg shadow-lg transition-colors duration-300
                bg-white/80 dark:bg-gray-900/80">

                @if(session('success'))
                    <div class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 text-red-800 bg-red-100 border border-red-300 p-4 rounded">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                    @switch(App::getLocale())
                    @case('en') Contact us @break
                    @case('sr-Cyrl') Контактирајте нас @break
                    @default Kontaktirajte nas
                    @endswitch
                </h2>
                @php
                    $content = \App\Models\ContactContent::first();
                    $isEditor = auth()->check() && auth()->user()->isEditor();
                @endphp

                {{-- Editabilni deo sa <p> i dugmetom --}}
                @if(session('successContent'))
                    <div class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded">
                        {{ session('successContent') }}
                    </div>
                @endif

                @if($errors->has('text_sr'))
                    <div class="mb-6 text-red-800 bg-red-100 border border-red-300 p-4 rounded">
                        {{ $errors->first('text_sr') }}
                    </div>
                @endif

                @if($isEditor)
                    <form action="{{ route('contact.update') }}" method="POST" class="space-y-6 mb-10">
                        @csrf
                        <label for="text_sr" class="block mb-2 font-semibold text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                            @case('en') Enter the content for the contact page @break
                            @case('sr-Cyrl') Унеси садржај за контакт страницу  @break
                            @default Unesi sadržaj za kontakt stranicu
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="text_sr" name="text_sr" rows="5" required class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white" style="text-align: center;">{{trim(old('text_sr', $content->text_sr ?? ''))}}</textarea>


                        <div class="flex justify-end gap-4">
                            <button type="button" data-modal-toggle="submitModal"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Sačuvaj izmene</button>
                        </div>

                        <!-- Confirm Submission Modal -->
                        <div id="submitModal" tabindex="-1"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full mx-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="p-6 text-center">
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Da li ste sigurni da želite da sačuvate izmene?
                                        </h3>
                                        <button id="confirmSubmitBtn" type="button"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                            Sačuvaj
                                        </button>
                                        <button data-modal-hide="submitModal" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Otkaži
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const openModalBtn = document.querySelector('button[data-modal-toggle="submitModal"]');
                        const confirmBtn = document.getElementById('confirmSubmitBtn');
                        const modal = document.getElementById('submitModal');
                        const form = document.querySelector('form[action="{{ route('contact.update') }}"]');

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
                @else
                    {{-- Prikaz običnog teksta za korisnike --}}
                    <p class="mb-10 whitespace-pre-wrap text-gray-800 dark:text-gray-200">
                        {{ $content->text_sr ?? 'Nema sadržaja za prikaz.' }}
                    </p>
                @endif

                <form action="{{ route('contact.store') }}" method="POST"
                    class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }}"
                    {{ $isEditor ? 'onsubmit=return false;' : '' }}>
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> 
                                @switch(App::getLocale())
                                @case('en') First name @break
                                @case('sr-Cyrl') Име @break
                                @default Ime
                                @endswitch
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="first_name" name="first_name" required 
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="Pera" value="{{ old('first_name') }}">
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> 
                                @switch(App::getLocale())
                                @case('en') Last name @break
                                @case('sr-Cyrl') Презиме @break
                                @default Prezime
                                @endswitch
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" required
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="Perić" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="name@example.com" value="{{ old('email') }}">
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                @switch(App::getLocale())
                                @case('en') Phone @break
                                @case('sr-Cyrl') Телефон @break
                                @default Telefon
                                @endswitch
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                    border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                    focus:border-grey-200 block w-full p-2.5"
                                placeholder="+381..." value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> 
                            @switch(App::getLocale())
                            @case('en') Message @break
                            @case('sr-Cyrl') Порука @break
                            @default Poruka
                            @endswitch
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required
                            class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700
                                border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                focus:border-grey-200 block w-full p-2.5"
                            placeholder="Vaša poruka...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded w-full sm:w-auto">
                        @switch(App::getLocale())
                        @case('en') Send message @break
                        @case('sr-Cyrl') Пошаљи поруку @break
                        @default Pošalji poruku
                        @endswitch
                    </button>
                </form>

            </div>
        </section>
    </div>
</x-guest-layout>
