<x-app-layout>
    <div
        x-data="{
        main: {{ optional($parentSection)->id ?? (optional($currentSection)->id ?? 'null') }},
        sub: {{ optional($currentSection)->id ?? 'null' }},
        currentId: {{ optional($currentSection)->id ?? 'null' }},
        subSections: {},
        titleValue: '{{ old('title', $title) }}',
        slugValue: '{{ old('slug', $slug) }}',
        loading: false,
        helpOpen: false
    }"
        x-init="
        subSections = JSON.parse($refs.jsonSubSections.textContent);
        $refs.hiddenTitle.value = $refs.title?.value;
        $refs.hiddenSlug.value = $refs.slug?.value;
        $refs.hiddenMain.value = main;
        $refs.hiddenSub.value = sub;
    "
        x-effect="
        $refs.hiddenTitle.value = $refs.title?.value;
        $refs.hiddenSlug.value = $refs.slug?.value;
        $refs.hiddenMain.value = main;
        $refs.hiddenSub.value = sub;
    "
        style="background: var(--primary-bg); color: var(--primary-text);">
        <div class="fixed top-0 right-0">
            <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-placement="right" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" style="color: var(--secondary-text); background: var(--primary-bg);">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>

            <aside id="sidebar-multi-level-sidebar" class="fixed top-0 right-0 z-40 w-64 h-screen transition-transform translate-x-full sm:translate-x-0" aria-label="Sidebar">
                <div class="flex flex-col h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 dark:text-white">
                    <div class="text-center font-semibold text-lg mb-10">
                        {{__('page_settings')}}
                    </div>
                    <ul class="space-y-2 font-medium gap-5">
                        <li>
                            <div class="mb-6">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{__('name_label')}}
                                </label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    x-ref="title"
                                    x-model="titleValue"
                                    value="{{ old('title', $title) }}"
                                    {{ isset($page) && !$page->is_deletable ? 'disabled' : '' }}
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </li>
                        <li>
                            <div class="mb-6">
                                <label for="slug" data-tooltip-target="tooltip-url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{__('url_label')}}
                                </label>
                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    x-ref="slug"
                                    x-model="slugValue"
                                    value="{{ old('slug', $slug) }}"
                                    data-tooltip-target="tooltip-url"
                                    {{ isset($page) && !$page->is_deletable ? 'disabled' : '' }}
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                                @enderror

                                <div id="tooltip-url" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    {{__('url_tooltip')}}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="mb-6">
                                <div class="flex flex-col">
                                    <span x-ref="jsonSubSections" class="hidden">
                                        @json($subSections)
                                    </span>

                                    <label for="main" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('main_section_label')}}</label>
                                    <select x-model="main" x-ref="main" name="navigation[]" @change="$refs.hiddenMain.value = main" id="main" {{ (isset($page) && !$page->is_deletable) ? 'disabled' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('navigation.0') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                        @if(!isset($page) || $page->is_deletable)
                                        <option value="">
                                            @switch(App::getLocale())
                                            @case('en') Select main section @break
                                            @case('sr-Cyrl') Изабери главну секцију @break
                                            @default Izaberi glavnu sekciju
                                            @endswitch
                                        </option>
                                        @foreach ($mainSections as $section)
                                        @php
                                        $isSelectedMain = $section->id === optional($currentSection)->id || $section->id === optional($parentSection)->id;
                                        $isActive = ($section->children()->count() === 0) ? true : false;
                                        @endphp
                                        <option
                                            value="{{ $section->id }}"
                                            {{ $isActive ? 'disabled' : '' }}
                                            {{ $isSelectedMain ? 'selected' : '' }}>
                                            {{ $section->translate('name') }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option value="{{ ($parentSection === null) ? $currentSection->id : $parentSection->id }}">{{ ($parentSection === null) ? $currentSection->name : $parentSection->name }}</option>
                                        @endif
                                    </select>
                                    @error('navigation.0')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                    @enderror

                                    <label for="sub" x-ref="sub" x-show="main" class="mt-6 block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('sub_section_label')}}</label>
                                    <select x-model="sub" name="navigation[]" id="sub" @change="$refs.hiddenSub.value = sub" x-show="main" :disabled="!main" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">
                                            @switch(App::getLocale())
                                            @case('en') Navigation subcategory @break
                                            @case('sr-Cyrl') Подкатегорија навигације @break
                                            @default Podkategorija navigacije
                                            @endswitch
                                        </option>
                                        <template x-for="item in subSections[main] || []" :key="item.id">
                                            <option :value="item.id" x-text="item.name{{ App::getLocale() === 'en' ? '_en' : (App::getLocale() === 'sr-Cyrl' ? '_cy' : '') }}" :selected="item.id === currentId"></option>
                                        </template>
                                    </select>
                                    @error('navigation.1')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </li>
                    </ul>
                    @php
                    $isEnglish = request()->query('en') === 'true';
                    @endphp
                    <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        @switch(App::getLocale())
                        @case('en') Page language @break
                        @case('sr-Cyrl') Језик странице @break
                        @default Jezik stranice
                        @endswitch
                    </label>
                    <div id="languages" class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <input {{ $isEnglish ? '' : 'checked' }} id="language-radio-button-sr" type="radio" form="page-form" value="sr" name="language-radio-button" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="language-radio-button-sr" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                @switch(App::getLocale())
                                @case('en') Serbian @break
                                @case('sr-Cyrl') српски @break
                                @default srpski
                                @endswitch
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input {{ $isEnglish ? 'checked' : '' }} id="language-radio-button-en" type="radio" form="page-form" value="en" name="language-radio-button" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="language-radio-button-en" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                @switch(App::getLocale())
                                @case('en') English @break
                                @case('sr-Cyrl') енглески @break
                                @default engleski
                                @endswitch
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col mt-auto">
                        <button
                            @click="helpOpen = true"
                            class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-help">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 17l0 .01" />
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                            </svg>
                            <span class="ml-3">{{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}</span>
                        </button>
                        <button
                            type="submit"
                            name="action"
                            value="draft"
                            form="page-form"
                            @click="
                                loading = true;
                                $refs.actionInput.value = 'draft';
                                $refs.form.submit();
                            "
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            @switch(App::getLocale())
                            @case('en') Save changes @break
                            @case('sr-Cyrl') Сачувај промене @break
                            @default Sačuvaj promene
                            @endswitch
                        </button>
                        @if(isset($page) && $page->is_active)
                        <button
                            type="submit"
                            name="action"
                            value="turnOff"
                            form="page-form"
                            @click="
                            loading = true;
                            $refs.actionInput.value = 'turnOff';
                            $refs.form.submit();"
                            class="focus:outline-none text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800
                            disabled:bg-gray-400 dark:disabled:bg-gray-400  disabled:cursor-not-allowed"
                            @if( isset($page) && !$page->is_deletable) disabled @endif>
                            @switch(App::getLocale())
                            @case('en') Turn off the page @break
                            @case('sr-Cyrl') Искључи страницу @break
                            @default Isključi stranicu
                            @endswitch
                        </button>
                        @else
                        <button
                            type="submit"
                            name="action"
                            value="publish"
                            form="page-form"
                            @click="
                                loading = true;
                                $refs.actionInput.value = 'publish';
                                $refs.form.submit();
                            "
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            @switch(App::getLocale())
                            @case('en') Publish @break
                            @case('sr-Cyrl') Објави @break
                            @default Objavi
                            @endswitch
                        </button>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
        <form id="page-form"
            action="{{ route('page.store') }}?sablon={{ $templateId }}{{ $isDraft ? '&slug='.$slug : '' }}"
            method="POST"
            enctype="multipart/form-data"
            class="hidden">

            @csrf
            <input type="hidden" name="template_id" value="{{ $templateId }}">
            <input type="hidden" name="title" :value="titleValue">
            <input type="hidden" name="slug" :value="slugValue">
            <input type="hidden" name="navigation[]" x-ref="hiddenMain" :value="main">
            <input type="hidden" name="navigation[]" x-ref="hiddenSub" :value="sub">
        </form>
        <div
            x-show="loading"
            x-transition
            class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 mb-6 text-orange-800 bg-orange-100 border border-orange-300 p-4 rounded shadow-lg">
            @switch(App::getLocale())
            @case('en') Please wait... @break
            @case('sr-Cyrl') Молимо сачекајте... @break
            @default Molimo sačekajte...
            @endswitch
        </div>
        @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
            @switch(App::getLocale())
            @case('en') Saved successfully @break
            @case('sr-Cyrl') Успешно сачувано @break
            @default Uspešno sačuvano
            @endswitch
        </div>
        @endif

        @if(!isset($page) || $page->is_deletable)
        <div class="min-h-screen w-full flex items-center justify-center" style="background: var(--primary-bg); color: var(--primary-text);">
            @include('templates.template' . $templateId)
        </div>
        @else
        <div class="flex-1 pr-64" style="background: var(--primary-bg); color: var(--primary-text);">
            {!! $basePageContent !!}
        </div>
        @endif

        <div
            x-show="helpOpen"
            x-transition
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background:rgba(0,0,0,0.5);"
            @click.self="helpOpen = false">
            <div
                x-show="helpOpen"
                x-transition
                class="relative rounded-xl border-2 shadow-2xl flex flex-col items-stretch"
                style="width:480px; height:560px; background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);"
                @keydown.escape.window="helpOpen = false"
                x-data="{ slide: 1, total: 7, enlarged: false }">
                <button
                    @click="helpOpen = false"
                    class="absolute top-3 right-3 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
                    style="color: var(--secondary-text);"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="flex flex-col flex-1 px-4 py-3 overflow-hidden h-full">

                    <div class="flex flex-col items-center justify-start" style="height: 48%;">
                        <h3 class="text-lg font-bold text-center mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                            {{ App::getLocale() === 'en' ? 'How to use Page Management' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити управљање страницама' : 'Kako koristiti upravljanje stranicama') }}
                        </h3>
                        <div class="flex items-center justify-center w-full" style="min-height: 170px;">
                            <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                                class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                                style="min-width:32px; color: var(--secondary-text);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <div class="flex-1 flex justify-center items-center min-h-[150px] cursor-zoom-in">
                                <template x-if="slide === 1">
                                    <img @click="enlarged = '/images/pages-help1.png'" src="/images/pages-help1.png" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 2">
                                    <img @click="enlarged = '/images/pages-help2.gif'" src="/images/pages-help2.gif" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 3">
                                    <img @click="enlarged = '/images/pages-help3.gif'" src="/images/pages-help3.gif" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 4">
                                    <img @click="enlarged = '/images/pages-help4.jpg'" src="/images/pages-help4.jpg" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 5">
                                    <img @click="enlarged = '/images/pages-help5.png'" src="/images/pages-help5.png" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 6">
                                    <img @click="enlarged = '/images/pages-help6.png'" src="/images/pages-help6.png" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 7">
                                    <img @click="enlarged = '/images/pages-help7.png'" src="/images/pages-help7.png" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                            </div>
                            <button type="button" @click="slide = slide === total ? 1 : slide + 1"
                                class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition ml-3 flex items-center justify-center"
                                style="min-width:32px; color: var(--secondary-text);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
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

                    <div class="flex-1 overflow-y-auto px-1 py-1 mt-2"
                        style="color: var(--secondary-text); min-height: 160px; max-height: 48%;">
                        <!-- Slide 1 -->
                        <template x-if="slide === 1">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Creating and editing pages' : (App::getLocale() === 'sr-Cyrl' ? 'Креирање и уређивање страница' : 'Kreiranje i uređivanje stranica') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Welcome to the Page creation and editing tool. Here you can easily create and customize pages using simple steps.
                                    @break
                                    @case('sr-Cyrl')
                                    Добродошли у алат за креирање и уређивање страница. Овде можете лако креирати и прилагодити странице користећи једноставне кораке.
                                    @break
                                    @default
                                    Dobrodošli u alat za kreiranje i uređivanje stranica. Ovde možete lako kreirati i prilagoditi stranice koristeći jednostavne korake.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 2 -->
                        <template x-if="slide === 2">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Text input' : (App::getLocale() === 'sr-Cyrl' ? 'Унос текста' : 'Unos teksta') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Enter the desired text, then click the blue button next to the field to save it.<br>
                                    To edit the text, click on it and repeat the process.
                                    @break
                                    @case('sr-Cyrl')
                                    Унесите жељени текст, а затим кликните на плаво дугме поред поља да бисте га сачували.<br>
                                    Ако желите да измените текст, кликните на њега и поновите поступак.
                                    @break
                                    @default
                                    Unesite željeni tekst, a zatim kliknite na plavo dugme pored polja da biste ga sačuvali.<br>
                                    Ako želite da izmenite tekst, kliknite na njega i ponovite postupak.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 3 -->
                        <template x-if="slide === 3">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Adding an image' : (App::getLocale() === 'sr-Cyrl' ? 'Додавање слике' : 'Dodavanje slike') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Drag your photo from your computer and drop it into the upload area. Alternatively, click on the upload area and choose an image from your computer.
                                    Once selected, a preview of the image will immediately appear. If you want to remove the image, click the red <strong>"Remove Image"</strong> button.
                                    This will immediately remove the image from the upload area, after which you can add a new one if you wish.
                                    @break
                                    @case('sr-Cyrl')
                                    Превуците вашу фотографију из рачунара и испустите је у означено подручје. Алтернативно, кликните на означено подручје и изаберите слику са рачунара.
                                    Након избора, преглед слике ће се одмах приказати у подручју. Ако желите да уклоните слику, кликните на црвено дугме <strong>"Уклони слику"</strong>.
                                    Ово ће одмах уклонити слику из подручја за отпремање, а након тога можете додати нову уколико желите.
                                    @break
                                    @default
                                    Prevucite vašu fotografiju iz računara i ispustite je u označeno područje. Alternativno, kliknite na označeno područje i izaberite sliku sa računara.
                                    Nakon izbora, pregled slike će se odmah prikazati u području. Ako želite da uklonite sliku, kliknite na crveno dugme <strong>"Ukloni sliku"</strong>.
                                    Ovo će odmah ukloniti sliku iz područja za otpremanje, a nakon toga možete dodati novu ukoliko želite.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 4 -->
                        <template x-if="slide === 4">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Page URL' : (App::getLocale() === 'sr-Cyrl' ? '"URL" странице' : 'URL stranice') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Enter the page identifier in the 'URL of the page' field, which is the final part of the address (e.g., 'most-important-news'). Use lowercase letters and hyphens instead of spaces.<br>
                                    @break
                                    @case('sr-Cyrl')
                                    Унесите идентификатор странице у поље 'URL странице', који представља крајњи део адресе (нпр. 'najvaznije-vesti'). Користите мала слова и цртице уместо размака.<br>
                                    @break
                                    @default
                                    Unesite identifikator stranice u polje 'URL stranice', koji predstavlja krajnji deo adrese (npr. 'najvaznije-vesti'). Koristite mala slova i crtice umesto razmaka.<br>
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 5 -->
                        <template x-if="slide === 5">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Navigation section' : (App::getLocale() === 'sr-Cyrl' ? 'Навигациона секција' : 'Navigaciona sekcija') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Navigation sections link your page to the main menu. Choose a section (e.g., "About us") to connect it to the navigation. Some sections appear gray and disabled because other pages are already linked to them, and these sections are not dropdown. If you want to add new sections or edit existing ones, go to the navigation settings.
                                    @break
                                    @case('sr-Cyrl')
                                    Навигaционые секције повезују вашу страницу са главним менијем. Изаберите секцију (нпр. "О нама") да је повежете са навигацијом. Некe секције су сиве и онемогућене јер су на њих већ повезане друге странице, а те секције нису опадајуће. Ако желите да додате нове секције или измените постојеће, идите у подешавања навигације.
                                    @break
                                    @default
                                    Navigacione sekcije povezuju vašu stranicu sa glavnim menijem. Izaberite sekciju (npr. "O nama") da je povežete sa navigacijom. Neke sekcije su sive i isključene jer su na njih već povezane druge stranice, a te sekcije nisu opadajuće. Ako želite da dodate nove sekcije ili izmenite postojeće, idite u podešavanja navigacije.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 6 -->
                        <template x-if="slide === 6">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Page automatic translation' : (App::getLocale() === 'sr-Cyrl' ? 'Аутоматски превод странице' : 'Automatski prevod stranice') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    This section manages <strong>automatic translation.</strong> When you enter text and select "Serbian," clicking the <strong>"Save Changes"</strong> button will automatically save and translate the text into the opposite script and English. Click the "English" button to review the translation, correct any errors if present, and save again by clicking "Save Changes."
                                    @break
                                    @case('sr-Cyrl')
                                    Ова секција управља <strong>аутоматским преводом.</strong> Када унесете текст и одаберете "српски", кликом на дугме <strong>"Сачувај промене"</strong> текст ће се аутоматски сачувати и превести у супротно писмо и на енглески. Кликните на дугме "енглески" да проверите превод, исправите грешке ако их има, и сачувајте поново кликом на дугме "Сачувај промене".
                                    @break
                                    @default
                                    Ova sekcija upravlja <strong>automatskim prevodom.</strong> Kada unesete tekst i izaberete "srpski", klikom na dugme <strong>"Sačuvaj promene"</strong>, tekst će se automatski sačuvati i prevesti u suprotno pismo i na engleski. Kliknite na dugme "engleski" da proverite prevod, ispravite greške ako ih ima, i sačuvajte ponovo klikom na dugme "Sačuvaj promene".
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 7 -->
                        <template x-if="slide === 7">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Page automatic translation' : (App::getLocale() === 'sr-Cyrl' ? 'Аутоматски превод странице' : 'Automatski prevod stranice') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    The <strong>"Save Changes"</strong> button saves your edits, allowing you to return and continue editing the page at any time. The page remains visible only to you as the editor until you publish it with the <strong>"Publish"</strong> button.
                                    @break
                                    @case('sr-Cyrl')
                                    Дугме <strong>"Сачувај промене"</strong> чува ваше измене, омогућавајући вам да се вратите и наставите уређивање странице у било ком тренутку. Страница остаје видљива само вама као уреднику док је не објавите дугметом <strong>"Објави"</strong>.
                                    @break
                                    @default
                                    Dugme <strong>"Sačuvaj promene"</strong> čuva vaše izmene, omogućavajući vam da se vratite i nastavite uređivanje stranice u bilo kom trenutku. Stranica ostaje vidljiva samo vama kao uredniku dok je ne objavite dugmetom <strong>"Objavi"</strong>.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('language-radio-button-en').addEventListener('change', function() {
        if (this.checked) {
            const slug = @json($slug);
            const url = `/uredi-stranicu/${slug}?en=true`;
            window.location.href = url;
        }
    });
</script>