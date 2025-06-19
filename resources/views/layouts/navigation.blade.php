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
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Basic information' : 'Osnovni podaci' }}</span>
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
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Header' : 'Zaglavlje' }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-layout-bottombar">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                <path d="M4 15l16 0" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Footer' : 'Podnožje' }}</span>
                                        </button>
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
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Navigation' : 'Navigacija' }}</span>
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
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Styles' : 'Stilovi' }}</span>
                                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-pages" class="hidden py-2 ml-5 space-y-2">
                                    <li>
                                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-letter-case">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M17.5 15.5m-3.5 0a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0 -7 0" />
                                                <path d="M3 19v-10.5a3.5 3.5 0 0 1 7 0v10.5" />
                                                <path d="M3 13h7" />
                                                <path d="M21 12v7" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Typography' : 'Tipografija' }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-palette">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" />
                                                <path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ App::getLocale() === 'en' ? 'Color' : 'Boje' }}</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-template">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z" />
                                        <path d="M4 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M14 12l6 0" />
                                        <path d="M14 16l6 0" />
                                        <path d="M14 20l6 0" />
                                    </svg>
                                    <span class="ml-3">{{ App::getLocale() === 'en' ? 'Pages' : 'Stranice' }}</span>
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
                                    <span class="ml-3">{{ App::getLocale() === 'en' ? 'Documents' : 'Dokumenti' }}</span>
                                </button>
                            </li>
                        </ul>
                        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                            <li>
                                <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                    <span class="ml-3">{{ App::getLocale() === 'en' ? 'Editors' : 'Urednici' }}</span>
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
                                    <span class="ml-3">{{ App::getLocale() === 'en' ? 'Help' : 'Pomoć' }}</span>
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
                            'en' => 'fi fi-us',
                            ];
                            $languages = [
                            'sr' => __('language_sr'),
                            'en' => __('language_en'),
                            ];
                            @endphp

                            <button type="button" data-dropdown-toggle="language-dropdown-menu-admin"
                                class="inline-flex items-center font-medium justify-center px-2 py-1 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white md:px-4 md:py-2">
                                <span class="{{ $flags[$locale] ?? 'fi fi-rs' }} w-4 h-4 md:w-5 md:h-5 rounded-full me-1 md:me-3"></span>
                                {{ $languages[$locale] ?? 'Srpski' }}
                            </button>

                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700" id="language-dropdown-menu-admin">
                                <ul class="py-1 font-medium" role="none">
                                    <li>
                                        <a href="{{ route('lang.switch', ['locale' => 'sr']) }}"
                                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                                                Srpski
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                                            class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <span class="fi fi-us h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                                                English
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
                        <p class="text-lg text-center font-semibold dark:text-white">{{ App::getLocale() === 'en' ? 'Navigation' : 'Navigacija' }}</p>
                        <button id="toggle-sortable" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">{{ App::getLocale() === 'en' ? 'Reorder' : 'Promeni redosled' }}</button>
                        <ul id="nav-list" class="space-y-2 mt-4 dark:text-white">
                            @foreach($mainSections as $mainSection)
                            <li class="flex items-center justify-between p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600" data-id="{{ $mainSection->id }}">
                                @if ($subSections->has($mainSection->id))
                                <button type="button" class="flex items-center justify-between w-full" data-collapse-toggle="dropdown-section-{{ $mainSection->id }}">
                                    <span>{{ $mainSection->name }}</span>
                                    <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                @else
                                <button type="button" class="flex items-center justify-between w-full">
                                    <span>{{ $mainSection->name }}</span>
                                </button>
                                @endif
                                <span id="sort-icon-{{ $mainSection->id }}" class="hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-move-vertical">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 18l3 3l3 -3" />
                                        <path d="M12 15v6" />
                                        <path d="M15 6l-3 -3l-3 3" />
                                        <path d="M12 3v6" />
                                    </svg>
                                </span>
                            </li>
                            @if ($subSections->has($mainSection->id))
                            <div id="dropdown-section-{{ $mainSection->id }}" class="hidden mx-4">
                                <div>
                                    @foreach ($subSections[$mainSection->id] as $subSection)
                                    <div>
                                        <button class="flex items-center justify-between p-2 mx-4 my-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600" data-collapse-toggle="dropdown-subSection-{{ $subSection->id }}">
                                            <span>{{ $subSection->name }}</span>
                                            <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                            </svg>
                                        </button>
                                        <div id="dropdown-subSection-{{ $subSection->id }}" class="hidden">
                                            <ul class="">
                                                @foreach ($subSection->children as $child)
                                                <li class="flex items-center justify-between p-1 ml-10">
                                                    <div class="">{{ $child->name }}</div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </ul>
                        <button id="save-order" class="mt-4 px-4 py-2 w-auto bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">{{ App::getLocale() === 'en' ? 'Save' : 'Sačuvaj' }}</button>
                    </div>
                </aside>

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ App::getLocale() === 'en' ? 'Dashboard' : 'Kontrolni panel' }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('welcome')" :active="!request()->routeIs('dashboard')">
                        {{ App::getLocale() === 'en' ? 'Edit content' : 'Uredi sadržај' }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
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
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('toggle-sortable');
        const saveButton = document.getElementById('save-order');
        const navList = document.getElementById('nav-list');
        const locale = '{{ App::getLocale() }}';
        let sortable = null;
        let isSortableActive = false;

        // Toggle sortable and icons
        toggleButton.addEventListener('click', () => {
            isSortableActive = !isSortableActive;

            if (isSortableActive) {
                toggleButton.textContent = (locale === 'en' ? 'Disable Reordering' : 'Završi premeštanje');
                navList.querySelectorAll('li').forEach(item => {
                    const iconSpan = item.querySelector(`#sort-icon-${item.getAttribute('data-id')}`);
                    if (iconSpan) {
                        iconSpan.classList.remove('hidden');
                        item.classList.add('cursor-move');
                    }
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
                toggleButton.textContent = (locale === 'en' ? 'Enable Reordering' : 'Promeni redosled');
                navList.querySelectorAll('li').forEach(item => {
                    const iconSpan = item.querySelector(`#sort-icon-${item.getAttribute('data-id')}`);
                    if (iconSpan) {
                        iconSpan.classList.add('hidden');
                        item.classList.remove('cursor-move');
                    }
                });

                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
            }
        });

        // Save order functionality
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
                        alert(locale === 'en' ? 'Order saved successfully!' : 'Redosled uspešno sačuvan!');
                        window.location.reload();
                    } else {
                        alert(locale === 'en' ? 'Error saving order.' : 'Greška pri čuvanju redosleda.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(locale === 'en' ? 'An error occurred.' : 'Došlo je do greške.');
                });
        });

        // Handle dropdown toggle for all levels
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
    });
</script>