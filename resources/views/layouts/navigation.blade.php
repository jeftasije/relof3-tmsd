<nav x-data="{ open: false }" class="py-4 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 mr-10 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav">
                    <div class="flex justify-end">
                        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="overflow-y-auto px-3 h-full">
                        <ul class="space-y-2">
                            <li>
                                <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-pages-1" data-collapse-toggle="dropdown-pages-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                        <path d="M12 9h.01" />
                                        <path d="M11 12h1v4h1" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                        @switch(App::getLocale())
                                        @case('en') Basic information @break
                                        @case('sr-Cyrl') Основни подаци @break
                                        @default Osnovni podaci
                                        @endswitch
                                    </span>
                                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-pages-1" class="hidden py-2 ml-5 space-y-2">
                                    <li>
                                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-layout-navbar">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M4 9l16 0" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                                @switch(App::getLocale())
                                                @case('en') Header @break
                                                @case('sr-Cyrl') Заглавље @break
                                                @default Zaglavlje
                                                @endswitch
                                            </span>
                                        </button>
                                    </li>
                                    <li>
                                        <a href="{{ route('footer.show') }}" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-layout-navbar">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M4 9l16 0" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                                @switch(App::getLocale())
                                                @case('en') Footer @break
                                                @case('sr-Cyrl') Подножје @break
                                                @default Podnožje
                                                @endswitch
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            <li>
                            <li>
                                <button data-drawer-target="aditional-sidebar" data-drawer-toggle="aditional-sidebar" aria-controls="aditional-sidebar" type="button" type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-safari">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 16l2 -6l6 -2l-2 6l-6 2" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                        @switch(App::getLocale())
                                        @case('en') Navigation @break
                                        @case('sr-Cyrl') Навигација @break
                                        @default Navigacija
                                        @endswitch
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-color-filter">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13.58 13.79c.27 .68 .42 1.43 .42 2.21c0 1.77 -.77 3.37 -2 4.46a5.93 5.93 0 0 1 -4 1.54c-3.31 0 -6 -2.69 -6 -6c0 -2.76 1.88 -5.1 4.42 -5.79" />
                                        <path d="M17.58 10.21c2.54 .69 4.42 3.03 4.42 5.79c0 3.31 -2.69 6 -6 6a5.93 5.93 0 0 1 -4 -1.54" />
                                        <path d="M12 8m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                        @switch(App::getLocale())
                                        @case('en') Styles @break
                                        @case('sr-Cyrl') Стилови @break
                                        @default Stilovi
                                        @endswitch
                                    </span>
                                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-pages" class="hidden py-2 ml-5 space-y-2">
                                    <li>
                                        <button
                                            type="button"
                                            class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                            data-drawer-target="typography-sidebar"
                                            data-drawer-toggle="typography-sidebar"
                                            aria-controls="typography-sidebar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-letter-case">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M17.5 15.5m-3.5 0a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0 -7 0" />
                                                <path d="M3 19v-10.5a3.5 3.5 0 0 1 7 0v10.5" />
                                                <path d="M3 13h7" />
                                                <path d="M21 12v7" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                                @switch(App::getLocale())
                                                @case('en') Typography @break
                                                @case('sr-Cyrl') Типографија @break
                                                @default Tipografija
                                                @endswitch
                                            </span>
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            type="button"
                                            class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                            data-drawer-target="color-sidebar"
                                            data-drawer-toggle="color-sidebar"
                                            aria-controls="color-sidebar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-palette">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" />
                                                <path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">
                                                @switch(App::getLocale())
                                                @case('en') Color @break
                                                @case('sr-Cyrl') Боје @break
                                                @default Boje
                                                @endswitch
                                            </span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <button data-drawer-target="page-sidebar" data-drawer-toggle="page-sidebar" aria-controls="page-sidebar" type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-template">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z" />
                                        <path d="M4 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M14 12l6 0" />
                                        <path d="M14 16l6 0" />
                                        <path d="M14 20l6 0" />
                                    </svg>
                                    <span class="ml-3">
                                        @switch(App::getLocale())
                                        @case('en') Pages @break
                                        @case('sr-Cyrl') Странице @break
                                        @default Stranice
                                        @endswitch
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-files">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                    <span class="ml-3">
                                        @switch(App::getLocale())
                                        @case('en') Documents @break
                                        @case('sr-Cyrl') Документи @break
                                        @default Dokumenti
                                        @endswitch
                                    </span>
                                </button>
                            </li>
                        </ul>
                        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                            <li>
                                <a href="/urednici" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                    <span class="ml-3">
                                        @switch(App::getLocale())
                                        @case('en') Editors @break
                                        @case('sr-Cyrl') Уредници @break
                                        @default Urednici
                                        @endswitch
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-help">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 17l0 .01" />
                                        <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                    </svg>
                                    <span class="ml-3">
                                        @switch(App::getLocale())
                                        @case('en') Help @break
                                        @case('sr-Cyrl') Помоћ @break
                                        @default Pomoć
                                        @endswitch
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-2 md:space-x-1">
                            @php
                            $locale = app()->getLocale();
                            $flags = [
                            'sr' => 'fi fi-rs',
                            'sr-Cyrl' => 'fi fi-rs',
                            'en' => 'fi fi-us',
                            ];
                            $languages = [
                            'sr' => __('language_sr'),
                            'sr-Cyrl' => __('language_sr_cy'),
                            'en' => __('language_en'),
                            ];
                            $localeKey = $locale === 'sr-Cyrl' ? 'sr-Cyrl' : ($locale === 'sr' ? 'sr' : 'en');
                            @endphp

                            <button type="button" data-dropdown-toggle="language-dropdown-menu-admin"
                                class="inline-flex items-center font-medium justify-center px-2 py-1 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white md:px-4 md:py-2">
                                <span class="{{ $flags[$localeKey] ?? 'fi fi-rs' }} w-4 h-4 md:w-5 md:h-5 rounded-full me-1 md:me-3"></span>
                                {{ $languages[$localeKey] ?? 'Srpski' }}
                            </button>

                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700" id="language-dropdown-menu-admin">
                                <ul class="py-1 font-medium" role="none">
                                    <li>
                                        <a href="{{ route('lang.switch', ['locale' => 'sr']) }}"
                                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                                                {{ __('language_sr') }}
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('lang.switch', ['locale' => 'sr-Cyrl']) }}"
                                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                                                {{ __('language_sr_cy') }}
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <span class="fi fi-us h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                                                {{ __('language_en') }}
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>

                <aside id="typography-sidebar" class="fixed top-0 left-0 z-50 w-96 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav-typography">
                    <div class="flex justify-start">
                        <button data-drawer-target="typography-sidebar" data-drawer-toggle="typography-sidebar" aria-controls="typography-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Close sidebar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-col justify-center items-center overflow-y-auto px-3 h-full">
                        <p class="text-lg text-center font-semibold dark:text-white mb-2">
                            {{ App::getLocale() === 'en' ? 'Typography' : (App::getLocale() === 'sr-Cyrl' ? 'Типографија' : 'Tipografija') }}
                        </p>
                        <div class="my-4">
                            <h2 class="text-base font-semibold mb-2">
                                {{ App::getLocale() === 'en' ? 'Title fonts' : (App::getLocale() === 'sr-Cyrl' ? 'Фонтови за наслов' : 'Fontovi za naslov') }}
                            </h2>
                            <div id="title-fonts-list" class="flex flex-col gap-2 overflow-y-auto" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="my-4">
                            <h2 class="text-base font-semibold mb-2">
                                {{ App::getLocale() === 'en' ? 'Description fonts' : (App::getLocale() === 'sr-Cyrl' ? 'Фонтови за опис' : 'Fontovi za opis') }}
                            </h2>
                            <div id="desc-fonts-list" class="flex flex-col gap-2 overflow-y-auto" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="my-4">
                            <h2 class="text-base font-semibold mb-2">
                                {{ App::getLocale() === 'en' ? 'Preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед' : 'Pregled') }}
                            </h2>
                            <div id="font-preview" class="w-full max-w-xs rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 transition-all duration-300 mb-4 bg-white dark:bg-gray-800 p-4 mx-auto">
                                <div id="preview-title" class="text-2xl font-bold mb-2">
                                    {{ App::getLocale() === 'en' ? 'This is a title preview' : (App::getLocale() === 'sr-Cyrl' ? 'Ово је наслов теме' : 'Ovo je naslov teme') }}
                                </div>
                                <div id="preview-desc" class="text-base">
                                    {{ App::getLocale() === 'en'
                                        ? 'This is a description preview. Change the font and click Save!'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Ово је приказ текстуалног описа (description). Промени фонт па кликни Сачувај!'
                                            : 'Ovo je prikaz tekstualnog opisa (description). Promeni font pa klikni Sačuvaj!')
                                    }}
                                </div>
                            </div>
                            <button id="font-save-btn"
                                class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white font-semibold shadow w-full"
                                disabled>
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>
                </aside>

                <aside id="color-sidebar" class="fixed top-0 left-0 z-50 w-96 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav-color">
                    <div class="flex justify-start items-center p-2">
                        <button
                            id="sidebar-back-btn"
                            type="button"
                            data-drawer-target="color-sidebar"
                            data-drawer-toggle="color-sidebar"
                            aria-controls="color-sidebar"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12h14" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                        </button>
                        <p class="text-lg text-center font-semibold dark:text-white flex-1">@switch(App::getLocale()) @case('en') Colors @break @case('sr-Cyrl') Боје @break @default Boje @endswitch</p>
                    </div>
                    <div class="overflow-y-auto max-h-56 px-4" id="palette-list"></div>
                    <div class="flex flex-col items-center justify-center flex-1 px-4">
                        <div class="flex gap-2 mb-2">
                            <button id="sidebar-preview-light" type="button" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 shadow transition hover:bg-yellow-200">
                                <svg id="sun-svg-preview" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 text-yellow-400" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                                </svg>
                            </button>
                            <button id="sidebar-preview-dark" type="button" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 shadow transition hover:bg-gray-800">
                                <svg id="moon-svg-preview" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-100" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="palette-preview" class="w-full max-w-xs rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 transition-all duration-300 mb-4"></div>
                        <button id="palette-save-btn"
                            class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white font-semibold shadow w-full"
                            disabled>Sačuvaj</button>
                    </div>
                </aside>

                <aside id="aditional-sidebar" class="fixed top-0 left-0 z-50 w-96 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav-navigation">
                    <div class="flex justify-start">
                        <button data-drawer-target="aditional-sidebar" data-drawer-toggle="aditional-sidebar" aria-controls="aditional-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Close sidebar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-col justify-center items-center overflow-y-auto px-3 h-full">
                        <p class="text-lg text-center font-semibold dark:text-white">
                            @switch(App::getLocale())
                            @case('en') Navigation @break
                            @case('sr-Cyrl') Навигација @break
                            @default Navigacija
                            @endswitch</p>
                        <div class="flex flex-row justify-between items-center mt-4">
                            <div class="flex items-center gap-2 px-4 py-2 border border-gray-400 text-gray-800 rounded-lg hover:bg-gray-100 dark:border-gray-600 dark:text-white dark:hover:bg-gray-700">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M4 14h16" />
                                </svg>
                                <button id="toggle-sortable">
                                    {{ App::getLocale() === 'en' ? 'Reorder' : (App::getLocale() === 'sr-Cyrl' ? 'Промени редослед' : 'Promeni redosled') }}
                                </button>
                            </div>
                        </div>
                        <ul id="nav-list" class="space-y-2 mt-4 dark:text-white">
                            @foreach($mainSections as $mainSection)
                            <li class="flex items-center justify-between w-full gap-1" data-id="{{ $mainSection->id }}">
                                <button type="button" class="flex items-center justify-between w-10/12 p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600" data-collapse-toggle="dropdown-section-{{ $mainSection->id }}">
                                    <span>{{ $mainSection->translate('name') }}</span>
                                    <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <span id="sort-icon-{{ $mainSection->id }}" class="hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                </span>
                                @if($mainSection->is_deletable)
                                <button id="dropdownMenuIconButton-{{ $mainSection->id }}" data-dropdown-toggle="dropdownMenuDots-{{ $mainSection->id }}" class="ml-auto inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                    </svg>
                                </button>
                                <div id="dropdownMenuDots-{{ $mainSection->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton-{{ $mainSection->id }}">
                                        <li>
                                            <button {{ $mainSection->is_deletable ? '' : 'disabled' }} data-modal-target="renameNavigationModal" data-modal-toggle="renameNavigationModal" data-nav-id="{{ $mainSection->id }}" data-nav-title="{{ $mainSection->name }}" data-nav-title-en="{{ $mainSection->name_en }}"
                                                class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                                                disabled:opacity-50 disabled:cursor-not-allowed 
                                                disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                                {{ App::getLocale() === 'en'
                                                        ? 'Rename'
                                                        : (App::getLocale() === 'sr-Cyrl'
                                                            ? 'Преименуј'
                                                            : 'Preimenuj') }}
                                            </button>
                                        </li>
                                        <li>
                                            <button {{ $mainSection->is_deletable ? '' : 'disabled' }} data-modal-target="deleteNavigationModal" data-modal-toggle="deleteNavigationModal" data-nav-id="{{ $mainSection->id }}" data-nav-title="{{ $mainSection->name }}"
                                                class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600
                                                            disabled:opacity-50 disabled:cursor-not-allowed 
                                                            disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                                {{ App::getLocale() === 'en'
                                                        ? 'Delete'
                                                        : (App::getLocale() === 'sr-Cyrl'
                                                            ? 'Обриши'
                                                            : 'Obriši') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </li>
                            <div id="dropdown-section-{{ $mainSection->id }}" class="hidden mx-4">
                                <div class="flex flex-col items-start mx-4 gap-2">
                                    @if ($subSections->has($mainSection->id))
                                    @foreach ($subSections[$mainSection->id] as $subSection)
                                    <div>
                                        <div class="flex flex-row items-center gap-1">
                                            <button class="flex items-center justify-between p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600" data-collapse-toggle="dropdown-subSection-{{ $subSection->id }}">
                                                <span>{{ $subSection->translate('name') }}</span>
                                                <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                                </svg>
                                            </button>
                                            <button id="dropdownMenuIconButton-{{ $subSection->id }}" data-dropdown-toggle="dropdownMenuDots-{{ $subSection->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                                </svg>
                                            </button>
                                            <div id="dropdownMenuDots-{{ $subSection->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                                    <li>
                                                        <button data-modal-target="renameNavigationModal" data-modal-toggle="renameNavigationModal" data-nav-id="{{ $subSection->id }}" data-nav-title="{{ $subSection->name }}" data-nav-title-en="{{ $subSection->name_en }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            {{ App::getLocale() === 'en'
                                                        ? 'Rename'
                                                        : (App::getLocale() === 'sr-Cyrl'
                                                            ? 'Преименуј'
                                                            : 'Preimenuj') }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button {{ $subSection->is_deletable ? '' : 'disabled' }} data-modal-target="deleteNavigationModal" data-modal-toggle="deleteNavigationModal" data-nav-id="{{ $subSection->id }}" data-nav-title="{{ $subSection->name }}" data-nav-title-en="{{ $subSection->name_en }}"
                                                            class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600
                                                            disabled:opacity-50 disabled:cursor-not-allowed 
                                                            disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                                            {{ App::getLocale() === 'en'
                                                        ? 'Delete'
                                                        : (App::getLocale() === 'sr-Cyrl'
                                                            ? 'Обриши'
                                                            : 'Obriši') }}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="dropdown-subSection-{{ $subSection->id }}" class="hidden">
                                            <ul class="">
                                                @foreach ($subSection->children as $child)
                                                <li class="flex items-center justify-between p-1 ml-10">
                                                    <div class="">{{ $child->translate('name') }}</div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    <button id="plus-section-{{ $mainSection->id }}" class="px-2 py-2 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </ul>
                        <div class="flex flex-col items-start justify-center space-y-16 mt-4">
                            <button id="plus" class="px-2 py-2 ml-6 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </button>
                            <button id="save-order" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                            <button id="help-btn" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-help">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 17l0 .01" />
                                    <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                </svg>
                                <span class="ml-3">{{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Plus Modal -->
                    <div id="plusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                            <div class="mt-3 text-center">
                                <h3 class="text-lg leading-6 mb-4 font-medium dark:text-gray-100 text-gray-900">{{ App::getLocale() === 'en' ? 'Add new section' : (App::getLocale() === 'sr-Cyrl' ? 'Додај нову секцију' : 'Dodaj novu sekciju') }}</h3>
                                <div class="flex flex-col text-left">
                                    <label for="section-name">
                                        @switch(App::getLocale())
                                        @case('en') Enter a new name in Serbian @break
                                        @case('sr-Cyrl') Унесите нови назив на српском @break
                                        @default Unesite novi naziv na srpskom
                                        @endswitch
                                    </label>
                                    <input type="text" id="section-name" class="w-full p-2 border mb-5 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" placeholder="{{ App::getLocale() === 'en' ? 'Section Name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив секције' : 'Naziv sekcije') }}">
                                    <label for="section-name-en">
                                        @switch(App::getLocale())
                                        @case('en') Enter a new name in English @break
                                        @case('sr-Cyrl') Унесите нови назив на енглеском @break
                                        @default Unesite novi naziv na engleskom
                                        @endswitch
                                    </label>
                                    <input type="text" id="section-name-en" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" placeholder="{{ App::getLocale() === 'en' ? 'Section name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив секције' : 'Naziv sekcije') }}">
                                </div>
                                <div class="items-center px-4 py-3 mt-4">
                                    <button id="plus-confirm-btn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-24 mr-2">{{ App::getLocale() === 'en' ? 'Confirm' : (App::getLocale() === 'sr-Cyrl' ? 'Потврди' : 'Potvrdi') }}</button>
                                    <button id="plus-cancel-btn" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24">{{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div id="deleteNavigationModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        {{ App::getLocale() === 'en'
                                ? 'Are you sure you want to delete?'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Да ли сте сигурни да желите да обришете'
                                    : 'Da li ste sigurni da želite da obrišete') }}
                                        "<span id="deleteNavigationModalTitle"></span>"?
                                    </h3>
                                    <button data-modal-hide="deleteNavigationModal" id="confirmDeleteButton" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        {{ App::getLocale() === 'en'
                                ? 'Confirm'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Потврди'
                                    : 'Potvrdi') }}
                                    </button>
                                    <button data-modal-hide="deleteNavigationModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        {{ App::getLocale() === 'en'
                                ? 'Cancel'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Откажи'
                                    : 'Otkaži') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="renameNavigationModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-6">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        {{ App::getLocale() === 'en'
                                ? 'Rename navigation'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Преименуј навигацију'
                                    : 'Preimenuj navigaciju') }}
                                    </h3>
                                    <label for="renameNavigationInput">
                                        @switch(App::getLocale())
                                        @case('en') Enter a new name in Serbian @break
                                        @case('sr-Cyrl') Унесите нови назив на српском @break
                                        @default Unesite novi naziv na srpskom
                                        @endswitch
                                    </label>
                                    <input type="text" id="renameNavigationInput" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" placeholder="{{ App::getLocale() === 'en' ? 'Enter new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}">
                                    <label for="renameNavigationInputEn">
                                        @switch(App::getLocale())
                                        @case('en') Enter a new name in English @break
                                        @case('sr-Cyrl') Унесите нови назив на енглеском @break
                                        @default Unesite novi naziv na engleskom
                                        @endswitch
                                    </label>
                                    <input type="text" id="renameNavigationInputEn" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" placeholder="{{ App::getLocale() === 'en' ? 'Enter new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}">
                                    <div class="mt-4 text-center">
                                        <button data-modal-hide="renameNavigationModal" id="confirmRenameNavigationButton" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            {{ App::getLocale() === 'en'
                                    ? 'Save'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Сачувај'
                                        : 'Sačuvaj') }}
                                        </button>
                                        <button data-modal-hide="renameNavigationModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                                            {{ App::getLocale() === 'en'
                                    ? 'Cancel'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Откажи'
                                        : 'Otkaži') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Help Modal -->
                    <div id="help-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-3xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ App::getLocale() === 'en' ? 'How to use this page' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити ову страницу' : 'Kako koristiti ovu stranicu') }}
                                </h3>
                                <!-- X close button -->
                                <button id="help-close-btn" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-4 text-base text-gray-700 dark:text-gray-300">
                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Reordering' : (App::getLocale() === 'sr-Cyrl' ? 'Промена редоследа' : 'Promena redosleda') }}
                                    </h4>
                                    <p>
                                        {{ App::getLocale() === 'en'
                                            ? 'Click the "Reorder" button, then drag the ⋮⋮ icon next to each section to move it. When you finish, click "Save" to persist your changes.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Кликните "Промени редослед", потом превуците иконицу ⋮⋮ поред сваке секције да је померите. Када завршите, кликните "Сачувај" да бисте сачували промене.'
                                                : 'Kliknite "Promeni redosled", potom prevucite ikonicu ⋮⋮ pored svake sekcije da je pomerite. Kada završite, kliknite "Sačuvaj" da biste sačuvali promene.')
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Adding a Main Section' : (App::getLocale() === 'sr-Cyrl' ? 'Додавање главне секције' : 'Dodavanje glavne sekcije') }}
                                    </h4>
                                    <p>
                                        {{ App::getLocale() === 'en'
                                            ? 'Press the "+" button at the bottom to add a new top‑level section. Enter its name and confirm.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Притисните "+" на дну листе за додавање нове главне секције. Унесите назив и потврдите.'
                                                : 'Pritisnite "+" na dnu liste za dodavanje nove glavne sekcije. Unesite naziv i potvrdite.')
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Adding a Sub‑Section' : (App::getLocale() === 'sr-Cyrl' ? 'Додавање подсекције' : 'Dodavanje podsekcije') }}
                                    </h4>
                                    <p>
                                        {{ App::getLocale() === 'en'
                                            ? 'First, expand the main section where you want to add a subsection by clicking on it. Then, click the "+" button inside that section, enter the name, and confirm.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Прво проширите главну секцију у којој желите да додате подсекцију кликом на њу. Затим кликните на дугме "+" унутар те секције, унесите назив и потврдите.'
                                                : 'Prvo proširite glavnu sekciju u kojoj želite da dodate podsekciju klikom na nju. Zatim kliknite na dugme "+" unutar te sekcije, unesite naziv i potvrdite.')
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Deleting Sections' : (App::getLocale() === 'sr-Cyrl' ? 'Брисање секција' : 'Brisanje sekcija') }}
                                    </h4>
                                    <p>
                                        {{ App::getLocale() === 'en'
                                            ? 'Click the three dots next to the navigation section you want to delete. Then, click the "Delete" button if it is enabled. For mandatory navigation sections, the "Delete" button is disabled.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Кликните на три тачке поред навигационе секције коју желите да обришете. Затим кликните на дугме "Обриши" ако је омогућено. За обавезне навигационе секције дугме "Обриши" је онемогућено.'
                                                : 'Kliknite na tri tačke pored navigacione sekcije koju želite da obrišete. Zatim kliknite na dugme "Obriši" ako je omogućeno. Za obavezne navigacione sekcije dugme "Obriši" je onemogućeno.')
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Renaming Sections' : (App::getLocale() === 'sr-Cyrl' ? 'Преименовање секција' : 'Preimenovanje sekcija') }}
                                    </h4>
                                    <p>
                                        {{ App::getLocale() === 'en'
                                            ? 'To rename a navigation section, click the three dots next to it. Then, click the "Rename" button. In the pop-up window that appears, enter the new name and confirm by clicking "Save".'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Да бисте преименовали навигациону секцију, кликните на три тачке поред ње. Затим кликните на дугме "Преименуј". У искачућем прозору који се отвори, унесите ново име и потврдите кликом на "Сачувај" или.'
                                                : 'Da biste preimenovali navigacionu sekciju, kliknite na tri tačke pored nje. Zatim kliknite na dugme "Preimenuj". U iskačućem prozoru koji se otvori, unesite novo ime i potvrdite klikom na "Sačuvaj".')
                                        }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold">
                                        {{ App::getLocale() === 'en' ? 'Why don’t I see the three dots?' : (App::getLocale() === 'sr-Cyrl' ? 'Зашто не видим три тачкице?' : 'Zašto ne vidim tri tačkice?') }}
                                    </h4>
                                    <p>
                                        @switch(App::getLocale())
                                        @case('en')
                                        The three dots are not visible for main navigation sections that are mandatory. This is because these sections do not allow renaming or deletion, which is why the option to interact with them is hidden.
                                        @break
                                        @case('sr-Cyrl')
                                        Три тачке нису видљиве за главне навигационе секције које су обавезне. То је зато што ове секције не дозвољавају преименовање или брисање, па се опција за интеракцију са њима не приказује.
                                        @break
                                        @default
                                        Tri tačke nisu vidljive za glavne navigacione sekcije koje su obavezne. To je zato što ove sekcije ne dozvoljavaju preimenovanje ili brisanje, pa se opcija za interakciju sa njima ne prikazuje.
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                @include('layouts.pageSideNavigation')

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        @switch(App::getLocale())
                        @case('en') Dashboard @break
                        @case('sr-Cyrl') Контролни панел @break
                        @default Kontrolni panel
                        @endswitch
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        @switch(App::getLocale())
                        @case('en') Edit content @break
                        @case('sr-Cyrl') Уреди садржај @break
                        @default Uredi sadržај
                        @endswitch
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('relofIndex')" :active="request()->routeIs('relofIndex')">
                        @switch(App::getLocale())
                        @case('en') Relof index @break
                        @case('sr-Cyrl') Релоф индекс @break
                        @default Relof index
                        @endswitch
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('reminders.index')" :active="request()->routeIs('reminders.index')">
                        @switch(App::getLocale())
                        @case('en') Reminders @break
                        @case('sr-Cyrl') Подсетници @break
                        @default Podsetnici
                        @endswitch
                    </x-nav-link>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <div class="relative">
                    <button id="notificationButton" class="relative focus:outline-none" onclick="toggleNotifications()">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                        </svg>
                        <span id="notificationBadge" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full hidden">0</span>
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-72 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-50">
                        <ul id="notificationList" class="max-h-60 overflow-y-auto p-2">
                        </ul>
                    </div>
                </div>
                @endauth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    #aditional-sidebar.translate-x-0~.fixed.inset-0 {
        background-color: rgba(0, 0, 0, 0.2) !important;
        transition: background-color 0.4s ease;
    }

    #default-sidebar.translate-x-0~.fixed.inset-0,
    :not(#aditional-sidebar)~.fixed.inset-0 {
        background-color: rgba(0, 0, 0, 0.2) !important;
        transition: background-color 0.4s ease;
    }
</style>
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function fetchRemindersCount() {
        try {
            const response = await fetch(`/podsetnici/aktivni/broj`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error('err in loading reminders: ' + response.status);
            }

            const data = await response.json();
            const badge = document.getElementById('notificationBadge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else if (data.count === 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        } catch (error) {
            console.error('err in counting reminders:', error);
        }
    }

    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('hidden');

        if (!dropdown.classList.contains('hidden')) {
            fetchReminders();
        }
    }

    async function fetchReminders() {
        try {
            const response = await fetch('/podsetnici/aktivni', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error('err in loading reminders: ' + response.status);
            }

            const reminders = await response.json();
            renderNotifications(reminders);
        } catch (error) {
            console.error('err in loading reminders:', error);
        }
    }

    function renderNotifications(reminders) {
        const badge = document.getElementById('notificationBadge');
        const list = document.getElementById('notificationList');

        if (reminders.length > 0) {
            badge.textContent = reminders.length;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }

        list.innerHTML = '';

        let noNotificationsMessage;
        const locale = '{{ App::getLocale() }}';
        switch (locale) {
            case 'en':
                noNotificationsMessage = 'You currently have no new notifications';
                break;
            case 'sr-Cyrl':
                noNotificationsMessage = 'Тренутно немате нове нотификације';
                break;
            default:
                noNotificationsMessage = 'Trenutno nemate nove notifikacije';
        }

        if (reminders.length === 0) {
            const li = document.createElement('li');
            li.className = 'p-2 text-sm text-gray-700 dark:text-white text-center';
            li.textContent = noNotificationsMessage;
            list.appendChild(li);
        } else {
            reminders.forEach((reminder) => {
                const li = document.createElement('li');
                const locale = '{{ App::getLocale() }}';
                li.className = 'flex justify-between items-center p-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 rounded';
                const title = locale === 'en' ?
                    reminder.title_en :
                    locale === 'sr-Cyrl' ?
                    reminder.title_cyr :
                    reminder.title_lat;
                li.innerHTML = `
                    <span>${title} (${new Date(reminder.time).toLocaleString('sr-RS')})</span>
                    <button onclick="removeNotification(${reminder.id})" class="text-red-500 hover:text-red-700 text-sm font-bold">x</button>
                `;
                list.appendChild(li);
            });
        }
    }

    async function removeNotification(id) {
        try {
            const response = await fetch(`/podsetnici/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error('Greška pri brisanju remindera: ' + response.status);
            }

            fetchReminders();
            fetchRemindersCount();
        } catch (error) {
            console.error('Greška pri brisanju remindera:', error);
        }
    }

    document.addEventListener('click', (event) => {
        const dropdown = document.getElementById('notificationDropdown');
        const button = document.getElementById('notificationButton');


        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        @auth
        fetchRemindersCount();
        setInterval(fetchRemindersCount, 30000);
        @endauth
    });

    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('toggle-sortable');
        const saveButton = document.getElementById('save-order');
        const navList = document.getElementById('nav-list');
        const locale = '{{ App::getLocale() }}';
        let sortable = null;
        let isSortableActive = false;
        let currentNavId = null;

        toggleButton.addEventListener('click', () => {
            isSortableActive = !isSortableActive;

            if (isSortableActive) {
                toggleButton.textContent = (() => {
                    switch (locale) {
                        case 'en':
                            return 'Disable Reordering';
                        case 'sr-Cyrl':
                            return 'Заврши премештање';
                        default:
                            return 'Završi premeštanje';
                    }
                })();
                navList.querySelectorAll('li').forEach(item => {
                    const iconSpan = item.querySelector(`#sort-icon-${item.getAttribute('data-id')}`);
                    if (iconSpan) {
                        iconSpan.classList.remove('hidden');
                        item.classList.add('cursor-move');
                    }
                });

                document.querySelectorAll('button[id^="dropdownMenuIconButton-"]').forEach(button => {
                    button.classList.remove('inline-flex');
                    button.classList.add('hidden');
                });

                sortable = new Sortable(navList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-dragging',
                    handle: '.cursor-move',
                    onEnd: (evt) => {
                        const items = navList.querySelectorAll('li');
                        items.forEach((item) => {
                            const dataId = item.getAttribute('data-id');
                            const dropdown = document.getElementById(`dropdown-section-${dataId}`);
                            if (dropdown) {
                                item.parentNode.insertBefore(dropdown, item.nextSibling);
                            }
                        });
                    },
                });
            } else {
                toggleButton.textContent = (() => {
                    switch (locale) {
                        case 'en':
                            return 'Enable Reordering';
                        case 'sr-Cyrl':
                            return 'Промени редослед';
                        default:
                            return 'Promeni redosled';
                    }
                })();

                navList.querySelectorAll('li').forEach(item => {
                    const iconSpan = item.querySelector(`#sort-icon-${item.getAttribute('data-id')}`);
                    if (iconSpan) {
                        iconSpan.classList.add('hidden');
                        item.classList.remove('cursor-move');
                    }
                });

                document.querySelectorAll('button[id^="dropdownMenuIconButton-"]').forEach(button => {
                    button.classList.remove('hidden');
                    button.classList.add('inline-flex');
                });

                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
            }
        });

        saveButton.addEventListener('click', () => {
            const items = [];
            const mainItems = navList.querySelectorAll('li[data-id]');

            mainItems.forEach((item, index) => {
                const id = item.getAttribute('data-id');
                items.push({
                    id: id,
                    order: index + 1,
                });
            });

            fetch(`{{ route('navigation.save-order') }}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        items
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Order saved successfully!';
                                case 'sr-Cyrl':
                                    return 'Редослед успешно сачуван!';
                                default:
                                    return 'Redosled uspešno sačuvan!';
                            }
                        })());

                        window.location.reload();
                    } else {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Error saving order.';
                                case 'sr-Cyrl':
                                    return 'Грешка при чувању редоследа.';
                                default:
                                    return 'Greška pri čuvanju redosleda.';
                            }
                        })());

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert((() => {
                        switch (locale) {
                            case 'en':
                                return 'An error occurred.';
                            case 'sr-Cyrl':
                                return 'Дошло је до грешке.';
                            default:
                                return 'Došlo je do greške.';
                        }
                    })());

                });
        });

        document.querySelectorAll('#default-sidebar [data-collapse-toggle], #aditional-sidebar [data-collapse-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = button.getAttribute('data-collapse-toggle');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.toggle('hidden');
                    const arrow = button.querySelector('svg');
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                }
            });
        });

        const plusModal = document.getElementById('plusModal');
        const sectionNameInput = document.getElementById('section-name');
        const sectionNameEnInput = document.getElementById('section-name-en');
        const confirmPlusBtn = document.getElementById('plus-confirm-btn');
        const cancelPlusBtn = document.getElementById('plus-cancel-btn');
        let activeParentId = null;


        document.querySelectorAll('#plus, [id^="plus-section-"]').forEach(button => {
            button.addEventListener('click', () => {
                plusModal.classList.remove('hidden');

                if (button.id === 'plus') {
                    activeParentId = null;
                } else {
                    activeParentId = button.id.replace('plus-section-', '');
                }
            });
        });

        confirmPlusBtn.addEventListener('click', () => {
            const sectionName = sectionNameInput.value.trim();
            const sectionNameEn = sectionNameEnInput.value.trim();
            if (sectionName && sectionNameEn) {
                const plusButton = document.querySelector('#plus') || document.querySelector('[id^="plus-section-"]:focus');
                const isMainSection = plusButton.id === 'plus';

                fetch(`{{ route('navigation.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            name: sectionName,
                            nameEn: sectionNameEn,
                            parent_id: activeParentId
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert((() => {
                                switch (locale) {
                                    case 'en':
                                        return 'Section added successfully';
                                    case 'sr-Cyrl':
                                        return 'Секција успешно додата';
                                    default:
                                        return 'Sekcija uspešno dodata';
                                }
                            })());

                            window.location.reload();
                        } else {
                            alert((() => {
                                switch (locale) {
                                    case 'en':
                                        return 'Error adding section.';
                                    case 'sr-Cyrl':
                                        return 'Грешка при додавању секције.';
                                    default:
                                        return 'Greška pri dodavanju sekcije.';
                                }
                            })());

                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'An error occurred.';
                                case 'sr-Cyrl':
                                    return 'Дошло је до грешке.';
                                default:
                                    return 'Došlo je do greške.';
                            }
                        })());

                    });
            }
        });

        cancelPlusBtn.addEventListener('click', () => {
            plusModal.classList.add('hidden');
            sectionNameInput.value = '';
        });

        const deleteNavigationModal = document.getElementById('deleteNavigationModal');
        const deleteNavigationModalTitle = document.getElementById('deleteNavigationModalTitle');

        document.querySelectorAll('[data-modal-toggle="deleteNavigationModal"]').forEach(button => {
            button.addEventListener('click', () => {
                currentNavId = button.dataset.navId;
                deleteNavigationModalTitle.textContent = button.dataset.navTitle;
            });
        });

        confirmDeleteButton.addEventListener('click', () => {
            fetch(`/navigacija/${currentNavId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Deleted successfully!';
                                case 'sr-Cyrl':
                                    return 'Успешно обрисано!';
                                default:
                                    return 'Uspešno obrisano!';
                            }
                        })());

                        window.location.reload();
                    } else {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Error deleting.';
                                case 'sr-Cyrl':
                                    return 'Грешка при брисању.';
                                default:
                                    return 'Greška pri brisanju.';
                            }
                        })());

                    }
                })
                .catch(err => {
                    console.error(err);
                    alert((() => {
                        switch (locale) {
                            case 'en':
                                return 'An error occurred.';
                            case 'sr-Cyrl':
                                return 'Дошло је до грешке.';
                            default:
                                return 'Došlo je do greške.';
                        }
                    })());

                });
        });

        const helpBtn = document.getElementById('help-btn');
        const helpModal = document.getElementById('help-modal');
        const helpCloseBtn = document.getElementById('help-close-btn');

        helpBtn.addEventListener('click', () => {
            helpModal.classList.remove('hidden');
        });

        helpCloseBtn.addEventListener('click', () => {
            helpModal.classList.add('hidden');
        });

        helpModal.addEventListener('click', e => {
            if (e.target === helpModal) {
                helpModal.classList.add('hidden');
            }
        });

        const renameNavigationModal = document.getElementById('renameNavigationModal');
        const renameNavigationInputEn = document.getElementById('renameNavigationInputEn');
        const renameNavigationInput = document.getElementById('renameNavigationInput');
        const confirmRenameNavigationButton = document.getElementById('confirmRenameNavigationButton');

        document.querySelectorAll('[data-modal-toggle="renameNavigationModal"]').forEach(button => {
            button.addEventListener('click', () => {
                currentNavId = button.dataset.navId;
                renameNavigationInput.value = button.dataset.navTitle;
                renameNavigationInputEn.value = button.dataset.navTitleEn;
            });
        });

        confirmRenameNavigationButton.addEventListener('click', () => {
            const newName = renameNavigationInput.value.trim();
            const newNameEn = renameNavigationInputEn.value.trim();
            if (!newName) {
                alert((() => {
                    switch (locale) {
                        case 'en':
                            return 'Please enter a new name.';
                        case 'sr-Cyrl':
                            return 'Молимо унесите назив.';
                        default:
                            return 'Molimo unesite naziv.';
                    }
                })());
                return;
            }

            fetch(`/navigacija/${currentNavId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: newName,
                        nameEn: newNameEn
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Renamed successfully!';
                                case 'sr-Cyrl':
                                    return 'Успешно преименовано!';
                                default:
                                    return 'Uspešno preimenovano!';
                            }
                        })());

                        window.location.reload();
                    } else {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Error renaming.';
                                case 'sr-Cyrl':
                                    return 'Грешка при преименовању.';
                                default:
                                    return 'Greška pri preimenovanju.';
                            }
                        })());

                    }
                })
                .catch(err => {
                    console.error(err);
                    alert((() => {
                        switch (locale) {
                            case 'en':
                                return 'An error occurred.';
                            case 'sr-Cyrl':
                                return 'Дошло је до грешке.';
                            default:
                                return 'Došlo je do greške.';
                        }
                    })());

                });
        });
    });
</script>