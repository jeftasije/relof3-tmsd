@php $locale = App::getLocale(); @endphp
<x-guest-layout>
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
                ? 'Biography is successfully changed!'
                : ($locale === 'sr-Cyrl'
                    ? 'Биографија је успешно измењена!'
                    : 'Biografija je uspešno izmenjna!')
        }}
    </div>
@endif

    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header" style="background: var(--primary-bg);">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full"
                style="color: var(--primary-text); background: var(--primary-bg);">
                <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div 
        class="min-h-[90vh] w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12"
        style="background: var(--primary-bg); color: var(--primary-text);"
        x-data="{
            editOpen: false, 
            helpOpen: false, 
            slide: 1, 
            total: 2, 
            enlarged: false 
        }"
    >
        <div class="w-full max-w-screen-xl mx-auto">
            <div style="background: var(--primary-bg); color: var(--primary-text);">
                <div class="p-2 sm:p-4 lg:p-6"
                     style="color: var(--primary-text);">

                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl sm:text-4xl font-bold"
                            style="color: var(--primary-text);">
                            {{ $employee->translate('position') }}
                        </h1>
                        @auth
                        <div class="flex flex-col items-end">
                            <!-- HELP dugme iznad Edit -->
                            <button @click="helpOpen = true"
                                class="flex items-center gap-2 mb-2 px-2 py-1 text-base font-semibold rounded transition hover:text-[var(--accent)] focus:outline-none shadow-none bg-transparent border-none"
                                style="background: transparent; color: var(--secondary-text);" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17l0 .01" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 13.5a1.5 1.5 0 0 1 1-1.5a2.6 2.6 0 1 0-3-4" />
                                </svg>
                                <span>
                                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                                </span>
                            </button>
                            <!-- EDIT dugme -->
                            <button 
                                @click="editOpen = true"
                                class="font-semibold px-4 py-2 rounded"
                                style="background: var(--accent); color: #fff;">
                                {{ $locale === 'en' ? 'Edit' : ($locale === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                            </button>
                        </div>
                        @endauth
                    </div>

                    <div class="flex flex-col lg:flex-row items-start gap-8 mb-10"
                        style="background: var(--primary-bg); color: var(--primary-text);">

                        <img
                            class="object-cover w-full lg:w-[28rem] h-[36rem] rounded-lg"
                            src="{{ asset($employee->image_path) }}"
                            alt="{{ $employee->name }}"
                            onerror="this.src='{{ asset('/images/default.jpg') }}';"
                            style="background: var(--primary-bg);"
                        />
                        <div class="flex-1">
                            <h2 class="text-2xl sm:text-3xl font-bold mb-4"
                                style="color: var(--primary-text);">
                                {{ $employee->name }}
                            </h2>
                            @if ($employee->extendedBiography)
                                @php
                                    if ($locale === 'en') {
                                        $bioKey = 'biography_translated';
                                        $uniKey = 'university_translated';
                                        $expKey = 'experience_translated';
                                        $skillsKey = 'skills_translated';
                                    } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
                                        $bioKey = 'biography_cy';
                                        $uniKey = 'university_cy';
                                        $expKey = 'experience_cy';
                                        $skillsKey = 'skills_cy';
                                    } else {
                                        $bioKey = 'biography';
                                        $uniKey = 'university';
                                        $expKey = 'experience';
                                        $skillsKey = 'skills';
                                    }
                                    $skills = $employee->extendedBiography->$skillsKey;
                                    if (!is_array($skills)) {
                                        $skills = [];
                                    }
                                @endphp
                                <p class="mb-4"
                                   style="color: var(--secondary-text);">
                                    {{ $employee->extendedBiography->$bioKey }}
                                </p>
                                <p class="mb-2" style="color: var(--secondary-text);">
                                    <strong style="color: var(--primary-text);">
                                        {{ $locale === 'en' ? 'University' : ($locale === 'sr-Cyrl' ? 'Универзитет' : 'Univerzitet') }}:
                                    </strong> {{ $employee->extendedBiography->$uniKey }}
                                </p>
                                <p class="mb-2" style="color: var(--secondary-text);">
                                    <strong style="color: var(--primary-text);">
                                        {{ $locale === 'en' ? 'Experience' : ($locale === 'sr-Cyrl' ? 'Искуство' : 'Iskustvo') }}:
                                    </strong> {{ $employee->extendedBiography->$expKey }}
                                </p>
                                <p class="mb-2" style="color: var(--secondary-text);">
                                    <strong style="color: var(--primary-text);">
                                        {{ $locale === 'en' ? 'Skills' : ($locale === 'sr-Cyrl' ? 'Вештине' : 'Veštine') }}:
                                    </strong>
                                    {{ implode(', ', $skills) }}
                                </p>
                            @else
                                <p class="mb-3" style="color: var(--secondary-text);">
                                    {{ $locale === 'en' ? 'Detailed biography not available.' : ($locale === 'sr-Cyrl' ? 'Детаљна биографија није доступна.' : 'Detaljna biografija nije dostupna.') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('employees.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg"
                       style="background: var(--accent); color: #fff;">
                        {{ $locale === 'en' ? 'Back to Employees' : ($locale === 'sr-Cyrl' ? 'Назад на запослене' : 'Nazad na zaposlene') }}
                        <svg class="rtl:rotate-180 w-4 h-4 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5H1m0 0l4-4m-4 4l4 4"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div
            x-show="editOpen"
            x-transition
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background:rgba(0,0,0,0.5);"
            @click.self="editOpen = false"
        >
            <div
                x-show="editOpen"
                x-transition
                class="rounded-lg shadow-lg max-w-lg w-full p-6 relative"
                style="background: var(--primary-bg); color: var(--primary-text);"
                @keydown.escape.window="editOpen = false"
            >
                <h2 class="text-xl font-semibold mb-4"
                    style="color: var(--primary-text);">
                    {{ $locale === 'en' ? 'Edit Employee Details' : ($locale === 'sr-Cyrl' ? 'Измени детаље запосленог' : 'Izmeni detalje zaposlenog') }}
                </h2>

                <form method="POST" action="{{ route('employees.updateExtendedBiography', $employee->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        if ($locale === 'en') {
                            $bioField = 'biography_translated';
                            $uniField = 'university_translated';
                            $expField = 'experience_translated';
                            $skillsField = 'skills_translated';
                        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
                            $bioField = 'biography_cy';
                            $uniField = 'university_cy';
                            $expField = 'experience_cy';
                            $skillsField = 'skills_cy';
                        } else {
                            $bioField = 'biography';
                            $uniField = 'university';
                            $expField = 'experience';
                            $skillsField = 'skills';
                        }
                        $bioValue = old($bioField, $employee->extendedBiography ? $employee->extendedBiography->$bioField : '');
                        $uniValue = old($uniField, $employee->extendedBiography ? $employee->extendedBiography->$uniField : '');
                        $expValue = old($expField, $employee->extendedBiography ? $employee->extendedBiography->$expField : '');
                        $skillsValue = old($skillsField, $employee->extendedBiography ? implode(',', $employee->extendedBiography->$skillsField ?? []) : '');
                    @endphp

                    <label class="block mb-2"
                        style="color: var(--secondary-text);" for="{{ $bioField }}">
                        {{ $locale === 'en' ? 'Biography' : ($locale === 'sr-Cyrl' ? 'Биографија' : 'Biografija') }}
                    </label>
                    <textarea name="{{ $bioField }}" id="{{ $bioField }}" rows="3" required
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">{{ $bioValue }}</textarea>

                    <label class="block mb-2"
                        style="color: var(--secondary-text);" for="{{ $uniField }}">
                        {{ $locale === 'en' ? 'University' : ($locale === 'sr-Cyrl' ? 'Универзитет' : 'Univerzitet') }}
                    </label>
                    <input type="text" name="{{ $uniField }}" id="{{ $uniField }}" required
                        value="{{ $uniValue }}"
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);" />

                    <label class="block mb-2"
                        style="color: var(--secondary-text);" for="{{ $expField }}">
                        {{ $locale === 'en' ? 'Experience' : ($locale === 'sr-Cyrl' ? 'Искуство' : 'Iskustvo') }}
                    </label>
                    <textarea name="{{ $expField }}" id="{{ $expField }}" rows="3" required
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">{{ $expValue }}</textarea>

                    <label class="block mb-2"
                        style="color: var(--secondary-text);" for="{{ $skillsField }}">
                        {{ $locale === 'en' ? 'Skills' : ($locale === 'sr-Cyrl' ? 'Вештине' : 'Veštine') }}
                    </label>
                    <input type="text" name="{{ $skillsField }}" id="{{ $skillsField }}"
                        value="{{ $skillsValue }}"
                        class="w-full p-2 mb-4 border rounded"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);" />
                    <p class="text-xs mb-4"
                        style="color: var(--secondary-text);">
                        {{ $locale === 'en' ? 'Separate skills with commas' : ($locale === 'sr-Cyrl' ? 'Одвојите вештине запетама' : 'Odvojite veštine zapetama') }}
                    </p>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="editOpen = false" class="px-4 py-2 rounded"
                            style="background: var(--secondary-text); color: #fff;">
                            {{ $locale === 'en' ? 'Cancel' : ($locale === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded"
                            style="background: var(--accent); color: #fff;">
                            {{ $locale === 'en' ? 'Save' : ($locale === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- HELP MODAL -->
        @auth
        <div
            x-show="helpOpen"
            x-transition
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background:rgba(0,0,0,0.5);"
            @click.self="helpOpen = false"
        >
            <div
                x-show="helpOpen"
                x-transition
                class="relative rounded-xl border-2 border-[var(--secondary-text)] shadow-2xl bg-white dark:bg-gray-900 flex flex-col items-stretch"
                style="width:500px; height:520px; background: var(--primary-bg); color: var(--primary-text);"
                @keydown.escape.window="helpOpen = false"
            >
                <button
                    @click="helpOpen = false"
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
                    <!-- Naslov i slike -->
                    <div class="flex flex-col items-center justify-start" style="height: 48%;">
                        <h3 class="text-lg font-bold text-center mb-2" style="color:var(--primary-text)">
                            {{ App::getLocale() === 'en'
                                ? 'How to edit employee details'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Како измењивати детаље запосленог'
                                    : 'Kako izmenjivati detalje zaposlenog') }}
                        </h3>
                        <div class="flex items-center justify-center w-full" style="min-height: 140px;">
                            <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                                class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                                style="min-width:32px;">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <div class="flex-1 flex justify-center items-center min-h-[120px] cursor-zoom-in">
                                <template x-if="slide === 1">
                                    <img @click="enlarged = '/images/extendedEmployee-help1.png'" src="/images/extendedEmployee-help1.png" alt="Edit Button" class="rounded-xl max-h-36 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 2">
                                    <img @click="enlarged = '/images/extendedEmployee-help2.png'" src="/images/extendedEmployee-help2.png" alt="Edit Modal" class="rounded-xl max-h-36 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
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
                    <!-- Enlarged image modal -->
                    <div x-show="enlarged" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
                        style="backdrop-filter: blur(2px);" @click="enlarged = false">
                        <img :src="enlarged" class="rounded-2xl shadow-2xl max-h-[80vh] max-w-[90vw] border-4 border-white object-contain" @click.stop />
                        <button @click="enlarged = false" class="absolute top-5 right-8 bg-white/80 hover:bg-white p-2 rounded-full shadow" aria-label="Close" style="color: var(--primary-text);">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Tekstovi -->
                    <div class="flex-1 overflow-y-auto px-1 py-1 mt-2"
                        style="color: var(--secondary-text); min-height: 120px; max-height: 48%;">
                        <!-- Slide 1 -->
                        <template x-if="slide === 1">
                            <div>
                                <h4 class="font-semibold mb-2">
                                    {{ App::getLocale() === 'en'
                                        ? 'Opening the edit dialog'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Отварање прозора за измену'
                                            : 'Otvaranje prozora za izmenu') }}
                                </h4>
                                <p>
                                    @switch(App::getLocale())
                                    @case('en')
                                        To edit employee details, click the "Edit" button located at the top right of the page (see image 1).
                                    @break
                                    @case('sr-Cyrl')
                                        Да бисте измењивали податке, кликните на дугме „Измени“ у горњем десном углу странице (слика 1).
                                    @break
                                    @default
                                        Da biste izmenili podatke, kliknite na dugme „Izmeni“ u gornjem desnom uglu stranice (slika 1).
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 2 -->
                        <template x-if="slide === 2">
                            <div>
                                <h4 class="font-semibold mb-2">
                                    {{ App::getLocale() === 'en'
                                        ? 'Editing and saving'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Измена и чување података'
                                            : 'Izmena i čuvanje podataka') }}
                                </h4>
                                <p>
                                    @switch(App::getLocale())
                                    @case('en')
                                        After clicking "Edit", a dialog will open with all fields for the employee's biography, university, experience, and skills. After making changes, click "Save" to apply them (see image 2).
                                    @break
                                    @case('sr-Cyrl')
                                        Након клика на „Измени“, отвориће се прозор са свим пољима биографије, универзитета, искуства и вештина. По завршетку измена, кликните на „Сачувај“ (слика 2).
                                    @break
                                    @default
                                        Nakon klika na „Izmeni“, otvoriće se prozor sa svim poljima biografije, univerziteta, iskustva i veština. Po završetku izmena kliknite na „Sačuvaj“ (slika 2).
                                    @endswitch
                                </p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        @endauth

    </div>
</x-guest-layout>
