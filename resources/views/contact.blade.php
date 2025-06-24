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
                <p class="mb-8 lg:mb-16 font-light text-center text-gray-600 dark:text-gray-300 sm:text-xl">
                    @switch(App::getLocale())
                    @case('en') Our team is here to answer all your questions and provide you with the best possible service! @break
                    @case('sr-Cyrl') Нашgit  тим је ту да одговори на сва ваша питања и обезбеди вам најбољу могућу услугу! @break
                    @default Naš tim je tu da odgovori na sva vaša pitanja i obezbedi vam najbolju moguću uslugu!
                    @endswitch
                </p>
            

                <!--<form action="{{ route('contact.store') }}" method="POST" class="space-y-6"> -->
                @php
                    $isEditor = auth()->check() && auth()->user()->isEditor();
                @endphp

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
                            placeholder=" ">{{ old('message') }}</textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" 
                            class="py-3 px-5 font-semibold text-center text-white rounded-lg 
                                   bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none 
                                   focus:ring-blue-300">
                            @switch(App::getLocale())
                            @case('en') Send message @break
                            @case('sr-Cyrl') Пошаљи поруку @break
                            @default Pošalji poruku
                            @endswitch
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</x-guest-layout>

<script>
function clearAnswer() {
    document.getElementById('answer-textarea').value = '';
}
</script>