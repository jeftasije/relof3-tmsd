<x-guest-layout>
@php $locale = App::getLocale(); @endphp

@if(session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
        class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
        style="
            top: 14%; 
            transform: translateX(-50%);
            background: #22c55e; 
            color: #fff; 
            font-weight: 600; 
            letter-spacing: 0.03em;
            min-width: 240px;
            text-align: center;"
        x-init="setTimeout(() => show = false, 2200)"
    >
        {{
            $locale === 'en'
                ? 'Employee added successfully!'
                : ($locale === 'sr-Cyrl'
                    ? 'Запослени је успешно додат!'
                    : 'Zaposleni je uspešno dodat!')
        }}
    </div>
@endif

<x-slot name="header">
    <div class="flex justify-between items-center w-full p-4" id="header">
        <div></div>
        <button id="theme-toggle" class="p-2 rounded-full text-gray-900 hover:bg-gray-200 focus:outline-none dark:text-white dark:hover:bg-gray-700">
            <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
            </svg>
        </button>
    </div>
</x-slot>

<div style="background: var(--primary-bg) !important; min-height: 90vh;" class="w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8">
    <div 
        class="w-full max-w-screen-xl mx-auto" 
        x-data="{ open: false }"
        x-init="open = false"
    >
        <!-- HEADER + HELP DUGME -->
        <div class="flex justify-between items-center mb-2 sm:mb-4 md:mb-6">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full"
                style="color: var(--primary-text) !important;">
                {{ $text['title'] }}
            </h1>
            @auth
            <button
                @click="window.dispatchEvent(new CustomEvent('show-help-modal'))"
                class="flex items-center gap-2 ml-4 px-2 py-1 text-base font-semibold rounded transition hover:text-[var(--accent)] focus:outline-none shadow-none bg-transparent border-none"
                style="background: transparent; color: var(--secondary-text);"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 17l0 .01" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                </svg>
                <span>
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </span>
            </button>
            @endauth
        </div>
        <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto" style="color: var(--secondary-text) !important;">
            {{ $text['description'] }}
        </p>

        <!-- DODAJ ZAPOSLENOG DUGME -->
        <div class="flex justify-end mb-6">
            @auth
            <button 
                @click="open = true"
                class="flex items-center gap-1 font-semibold py-2 px-4 rounded-lg shadow"
                style="background: var(--accent); color: #fff;"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ App::getLocale() === 'en' ? 'Add Employee' : (App::getLocale() === 'sr-Cyrl' ? 'Додај запосленог' : 'Dodaj zaposlenog') }}
            </button>
            @endauth
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
            @foreach ($employees as $employee)
                <x-employee-card :employee="$employee" />
            @endforeach
        </div>
        @if ($employees->hasPages())
            <div class="flex justify-center mt-8">
                {{ $employees->links('pagination::tailwind') }}
            </div>
        @endif

        <div
            x-show="open"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: none;"
            @click.self="open = false"
        >
            <div
                x-show="open"
                x-transition
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full p-8 relative"
                @keydown.escape.window="open = false"
            >
                <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                <h2 class="text-xl font-semibold" style="color: var(--primary-text) !important;">
                                    {{ App::getLocale() === 'en' ? 'Add Employee' : (App::getLocale() === 'sr-Cyrl' ? 'Додај запосленог' : 'Dodaj zaposlenog') }}
                                </h2>
                            </div>
                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="name">
                                {{ App::getLocale() === 'en' ? 'Name' : (App::getLocale() === 'sr-Cyrl' ? 'Име' : 'Ime') }}
                            </label>
                            <input type="text" name="name" id="name" required
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);" />

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="position">
                                {{ App::getLocale() === 'en' ? 'Position' : (App::getLocale() === 'sr-Cyrl' ? 'Позиција' : 'Pozicija') }}
                            </label>
                            <input type="text" name="position" id="position" required
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);" />

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="biography">
                                {{ App::getLocale() === 'en' ? 'Short Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Кратка биографија' : 'Kratka biografija') }}
                            </label>
                            <textarea name="biography" id="biography" rows="4"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);"></textarea>

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="image">
                                {{ App::getLocale() === 'en' ? 'Upload Image' : (App::getLocale() === 'sr-Cyrl' ? 'Додај слику' : 'Dodaj sliku') }}
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);" />
                        </div>
                        <div>
                            <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                <h2 class="text-xl font-semibold" style="color: var(--primary-text) !important;">
                                    {{ App::getLocale() === 'en' ? 'Extended Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Проширена биографија' : 'Proširena biografija') }}
                                </h2>
                            </div>
                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="biography_extended">
                                {{ App::getLocale() === 'en' ? 'Full Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Цела биографија' : 'Cela biografija') }}
                            </label>
                            <textarea name="biography_extended" id="biography_extended" rows="4"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);"></textarea>

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="university">
                                {{ App::getLocale() === 'en' ? 'University' : (App::getLocale() === 'sr-Cyrl' ? 'Универзитет' : 'Univerzitet') }}
                            </label>
                            <input type="text" name="university" id="university"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);" />

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="experience">
                                {{ App::getLocale() === 'en' ? 'Experience' : (App::getLocale() === 'sr-Cyrl' ? 'Искуство' : 'Iskustvo') }}
                            </label>
                            <textarea name="experience" id="experience" rows="3"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);"></textarea>

                            <label class="block mb-2" style="color: var(--secondary-text) !important;" for="skills">
                                {{ App::getLocale() === 'en' ? 'Skills' : (App::getLocale() === 'sr-Cyrl' ? 'Вештине' : 'Veštine') }}
                            </label>
                            <textarea name="skills" id="skills" rows="3"
                                class="w-full p-2 mb-4 border border-gray-300 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-8">
                        <button type="button" @click="open = false" class="px-4 py-2 rounded"
                                style="background: #cbd5e1; color: var(--primary-text);">
                            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- HELP MODAL VAN GLAVNOG SCOPE-A -->
@auth
<div
    x-data="{ show: false, slide: 1, total: 3, enlarged: false }"
    x-init="window.addEventListener('show-help-modal', () => { show = true })"
    x-show="show"
    x-transition
    class="fixed inset-0 flex items-center justify-center z-50"
    style="background:rgba(0,0,0,0.5);"
    @click.self="show = false"
>
    <div
        x-show="show"
        x-transition
        class="relative rounded-xl border-2 border-[var(--secondary-text)] shadow-2xl bg-white dark:bg-gray-900 flex flex-col items-stretch"
        style="width:480px; height:560px; background: var(--primary-bg); color: var(--primary-text);"
        @keydown.escape.window="show = false"
    >
        <button
            @click="show = false"
            class="absolute top-3 right-3 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
            style="color: var(--secondary-text);"
            aria-label="Close"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="flex flex-col flex-1 px-4 py-3 overflow-hidden h-full">

        <div class="flex flex-col items-center justify-start" style="height: 48%;">
            <h3 class="text-lg font-bold text-center mb-2" style="color:var(--primary-text)">
                {{ App::getLocale() === 'en' ? 'How to use News Management' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити управљање вестима' : 'Kako koristiti upravljanje vestima') }}
            </h3>
            <div class="flex items-center justify-center w-full" style="min-height: 170px;">
                <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                    style="min-width:32px;">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <div class="flex-1 flex justify-center items-center min-h-[150px] cursor-zoom-in">
                    <template x-if="slide === 1">
                        <img @click="enlarged = '/images/employee-help1.png'" src="/images/employee-help1.png" alt="Edit or Delete News" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                    </template>
                    <template x-if="slide === 2">
                        <img @click="enlarged = '/images/employee-help2.png'" src="/images/employee-help2.png" alt="Edit Form" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                    </template>
                    <template x-if="slide === 3">
                        <img @click="enlarged = '/images/employee-help3.png'" src="/images/employee-help3.png" alt="Add News" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                    </template>
                </div>
                <button type="button" @click="slide = slide === total ? 1 : slide + 1"
                    class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition ml-3 flex items-center justify-center"
                    style="min-width:32px;">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-center mt-2 space-x-1">
                <template x-for="i in total">
                    <div :class="slide === i ? 'bg-[var(--accent)]' : 'bg-gray-400'"
                        class="w-2 h-2 rounded-full transition-all duration-200"></div>
                </template>
            </div>
        </div>

        <div x-show="enlarged" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
            style="backdrop-filter: blur(2px);" @click="enlarged = false">
            <img :src="enlarged" class="rounded-2xl shadow-2xl max-h-[80vh] max-w-[90vw] border-4 border-white object-contain" @click.stop />
            <button @click="enlarged = false" class="absolute top-5 right-8 bg-white/80 hover:bg-white p-2 rounded-full shadow" aria-label="Close" style="color: var(--primary-text);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

            <div class="flex-1 overflow-y-auto px-1 py-1 mt-2"
                style="color: var(--secondary-text); min-height: 160px; max-height: 48%;">
                <!-- Slide 1 -->
                <template x-if="slide === 1">
                    <div>
                        <h4 class="font-semibold mb-2">
                            {{ App::getLocale() === 'en'
                                ? 'Editing and Deleting Employees'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Измена и брисање запослених'
                                    : 'Izmena i brisanje zaposlenih') }}
                        </h4>
                        <p>
                            @switch(App::getLocale())
                            @case('en')
                                After clicking Edit, you can update fields such as name, position, biography, and upload a new photo. Click Save when finished.<br>
                                If you wish to discard changes at any moment, click Cancel. A confirmation message will appear after successful editing.
                            @break
                            @case('sr-Cyrl')
                                Након што кликнете на Измени, можете ажурирати поља као што су име, позиција, биографија, као и поставити нову фотографију. По завршетку измена кликните на дугме Сачувај.<br>
                                Ако желите да одустанете од промена у било ком тренутку, кликните на дугме Откажи. Након успешне измене добићете потврду.
                            @break
                            @default
                                Nakon što kliknete na Izmeni, možete ažurirati polja kao što su ime, pozicija, biografija i postaviti novu fotografiju. Kada završite, kliknite na Sačuvaj.<br>
                                Ako želite da otkažete izmene, kliknite na dugme Otkaži. Nakon uspešne izmene dobićete potvrdu.
                            @endswitch
                        </p>
                    </div>
                </template>
                <!-- Slide 2 -->
                <template x-if="slide === 2">
                    <div>
                        <h4 class="font-semibold mb-2">
                            {{ App::getLocale() === 'en'
                                ? 'Editing Employee Data'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Уређивање података о запосленом'
                                    : 'Uređivanje podataka o zaposlenom') }}
                        </h4>
                        <p>
                            @switch(App::getLocale())
                            @case('en')
                                After clicking Edit, you can update fields such as name, position, biography, and upload a new photo. Click Save when finished.<br>
                                If you wish to discard changes at any moment, click Cancel. A confirmation message will appear after successful editing.
                            @break
                            @case('sr-Cyrl')
                                Након што кликнете на Измени, можете ажурирати поља као што су име, позиција, биографија, као и поставити нову фотографију. По завршетку измена кликните на дугме Сачувај.<br>
                                Ако желите да одустанете од промена у било ком тренутку, кликните на дугме Откажи. Након успешне измене добићете потврду.
                            @break
                            @default
                                Nakon što kliknete na Izmeni, možete ažurirati polja kao što su ime, pozicija, biografija i postaviti novu fotografiju. Kada završite, kliknite na Sačuvaj.<br>
                                Ako želite da otkažete izmene, kliknite na dugme Otkaži. Nakon uspešne izmene dobićete potvrdu.
                            @endswitch
                        </p>
                    </div>
                </template>
                <!-- Slide 3 -->
                <template x-if="slide === 3">
                    <div>
                        <h4 class="font-semibold mb-2">
                            {{ App::getLocale() === 'en'
                                ? 'Adding a New Employee'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Додавање новог запосленог'
                                    : 'Dodavanje novog zaposlenog') }}
                        </h4>
                        <p>
                            @switch(App::getLocale())
                            @case('en')
                                To add a new employee, click the "Add Employee" button. Fill in the required fields such as name, position, biography, and upload a photo.<br>
                                Extended fields allow you to add full biography, university, experience, and skills.<br>
                                After adding an employee, you can view their details by clicking "Show more" on their card.
                            @break
                            @case('sr-Cyrl')
                                Да додате новог запосленог, кликните на дугме "Додај запосленог". Попуните обавезна поља као што су име, позиција, биографија и фотографија.<br>
                                У проширеним пољима можете додати целу биографију, универзитет, искуство и вештине.<br>
                                Након додавања запосленог, можете видети детаље кликом на "Прикажи више" на картици.
                            @break
                            @default
                                Da dodate novog zaposlenog, kliknite na dugme "Dodaj zaposlenog". Popunite obavezna polja: ime, pozicija, biografija i fotografija.<br>
                                U proširenim poljima možete uneti celu biografiju, univerzitet, iskustvo i veštine.<br>
                                Nakon dodavanja zaposlenog, detalje gledate klikom na "Prikaži više" na kartici zaposlenog.
                            @endswitch
                        </p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endauth

</x-guest-layout>
