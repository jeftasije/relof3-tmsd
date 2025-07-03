<x-app-layout>
    @php
        $locale = App::getLocale();
        $subtitleValue = '';
        $titleValue = '';
        $newsTitleValue = '';
        $contactTitleValue = '';
        $contactSubtitleValue = '';
        $cobissTitleValue = '';
        $cobissSubtitleValue = '';
        $ourTeamTitleValue = '';
        $ourTeamSubtitleValue = '';

        if ($locale === 'sr-Cyrl') {
            $subtitleValue = old('subtitle_sr_cyr', $subtitle_sr_cyr ?? '');
            $titleValue = old('title_sr_cyr', $title_sr_cyr ?? '');
            $newsTitleValue = old('news_title_sr_cyr', $news_title_sr_cyr ?? '');
            $contactTitleValue = old('contact_title_sr_cyr', $contact_title_sr_cyr ?? '');
            $contactSubtitleValue = old('contact_subtitle_sr_cyr', $contact_subtitle_sr_cyr ?? '');
            $cobissTitleValue = old('cobiss_title_sr_cyr', $cobiss_title_sr_cyr ?? '');
            $cobissSubtitleValue = old('cobiss_subtitle_sr_cyr', $cobiss_subtitle_sr_cyr ?? '');
            $ourTeamTitleValue = old('our_team_title_sr_cyr', $our_team_title_sr_cyr ?? '');
            $ourTeamSubtitleValue = old('our_team_subtitle_sr_cyr', $our_team_subtitle_sr_cyr ?? '');

        } else {
            $subtitleValue = old('subtitle_sr_lat', $subtitle_sr_lat ?? '');
            $titleValue = old('title_sr_lat', $title_sr_lat ?? '');
            $newsTitleValue = old('news_title_sr_lat', $news_title_sr_lat ?? '');
            $contactTitleValue = old('contact_title_sr_lat', $contact_title_sr_lat ?? '');
            $contactSubtitleValue = old('contact_subtitle_sr_lat', $contact_subtitle_sr_lat ?? '');
            $cobissTitleValue = old('cobiss_title_sr_lat', $cobiss_title_sr_lat ?? '');
            $cobissSubtitleValue = old('cobiss_subtitle_sr_lat', $cobiss_subtitle_sr_lat ?? '');
            $ourTeamTitleValue = old('our_team_title_sr_lat', $our_team_title_sr_lat ?? '');
            $ourTeamSubtitleValue = old('our_team_subtitle_sr_lat', $our_team_subtitle_sr_lat ?? '');
        }

        $path = storage_path('app/public/homepageVisibility.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $newsVisible = $data['news_visible'] ?? true;
        $contactVisible = $data['contact_visible'] ?? true;
        $cobissVisible = $data['cobiss_visible'] ?? true;
        $ourTeamVisible = $data['our_team_visible'] ?? true;
        $ourTeamIsSelected = $data['our_team_is_selected'] ?? true;

    @endphp
    <div x-data="{helpOpen: false}" class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div>
            <div class="relative flex items-center justify-center mb-8">
                <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Edit homepage' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди почетну страницу' : 'Uredi početnu stranicu') }}
                </h1>

                <div class="absolute right-0">
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
                </div>
            </div>
            <form id="serbian-hero" action="{{ route('homepage.updateSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-between mb-6">    
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ App::getLocale() === 'en' ? 'Edit herosection' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди насловни део' : 'Uredi naslovni deo') }}
                    </h1>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="mb-4">
                            <img src="{{ asset('images/herosection_home_edit.png') }}" alt="{{ App::getLocale() === 'en' ? 'Hero image preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед насловне слике' : 'Pregled naslovne slike') }}" class="w-full h-auto border-2 border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="title_sr" name="title_sr" value="{{ $titleValue }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="subtitle_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="subtitle_sr" name="subtitle_sr" value="{{ $subtitleValue }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'New background photo (max 2MB)' : (App::getLocale() === 'sr-Cyrl' ? 'Нова позадинска фотографија (max 2MB)' : 'Nova pozadinska fotografija (max 2MB)') }}</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 dark:text-white bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600"></input>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>    
            </form>
            <form id="english-hero" action="{{ route('homepage.updateEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EH)' : 'Naslovni deo (EN)') }}
                    </h2>
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}
                        </label>
                        <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $title_en ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}
                        </label>
                        <input type="text" id="subtitle_en" name="subtitle_en" value="{{ old('subtitle_en', $subtitle_en ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                    </div>
                    <div class="mt-auto flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div class="flex items-center justify-between mb-6">    
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ App::getLocale() === 'en' ? 'Edit news section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди секцију вести' : 'Uredi sekciju vesti') }}
                    </h1>
                    <button onclick="toggleNewsVisibility()" id="eyeToggle" class="transition">
                        @if ($newsVisible)
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                                <path
                                    d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                                <path
                                    d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
            <form id="serbian-news" action="{{ route('homepage.updateNewsSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="mb-4">
                            <img src="{{ asset('images/homepage_news.png') }}" alt="{{ App::getLocale() === 'en' ? 'Hero image preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед насловне слике' : 'Pregled naslovne slike') }}" class="w-full h-auto border-2 border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="news_title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="news_title_sr" name="news_title_sr" value="{{ $newsTitleValue }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>
                </form>
                <form id="english-news" action="{{ route('homepage.updateNewsEn') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ App::getLocale() === 'en' ? 'News section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Вести (EН)' : 'Vesti (EN)') }}
                            </h2>
                            <div class="mb-4">
                                <label for="news_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="news_title_en" name="news_title_en" value="{{ old('news_title_en', $news_title_en ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                            </div>
                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                    </button>
                                </div>
                        </div>
                </form>
        </div>
        <div>
            <div class="flex items-center justify-between mb-6"> 
                <div class="flex items-center gap-2">   
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ App::getLocale() === 'en' ? 'Edit contact section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди контакт секцију' : 'Uredi kontakt sekciju') }}
                    </h1>
                    <button onclick="toggleContactVisibility()" id="eyeToggleContact" class="transition">
                        @if ($contactVisible)
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                                <path
                                    d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                                <path
                                    d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
            <form id="serbian-contact" action="{{ route('homepage.updateContactSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="mb-4">
                            <img src="{{ asset('images/lets_stay_in_touch.png') }}" alt="{{ App::getLocale() === 'en' ? 'Hero image preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед насловне слике' : 'Pregled naslovne slike') }}" class="w-full h-auto border-2 border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="contact_title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="contact_title_sr" name="contact_title_sr" value="{{ $contactTitleValue }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="contact_subtitle_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="contact_subtitle_sr" name="contact_subtitle_sr" value="{{ $contactSubtitleValue }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="imageContact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'New photo (max 2MB)' : (App::getLocale() === 'sr-Cyrl' ? 'Нова фотографија (max 2MB)' : 'Nova fotografija (max 2MB)') }}</label>
                            <input type="file" id="imageContact" name="imageContact" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 dark:text-white bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>
            </form>
            <form id="english-contact" action="{{ route('homepage.updateContactEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Contact section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Контакт (EН)' : 'kontakt (EN)') }}
                        </h2>
                        <div class="mb-4">
                            <label for="contact_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                            <input type="text" id="contact_title_en" name="contact_title_en" value="{{ old('contact_title_en', $contact_title_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="contact_subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="contact_subtitle_en" name="contact_subtitle_en" value="{{ old('contact_subtitle_en', $contact_subtitle_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                            </div>
                    </div>
            </form>
        </div>
        <div>
            <div class="flex items-center justify-between mb-6">    
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ App::getLocale() === 'en' ? 'Edit COBISS section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди "COBISS" секцију' : 'Uredi "COBISS" sekciju') }}
                    </h1>
                    <button onclick="toggleCobissVisibility()" id="cobissToggle" class="transition">
                        @if ($cobissVisible)
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                                <path
                                    d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                                <path
                                    d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>

            <form id="serbian-cobiss" action="{{ route('homepage.updateCobissSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="mb-4">
                            <img src="{{ asset('images/cobiss.png') }}" alt="{{ App::getLocale() === 'en' ? 'Hero image preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед насловне слике' : 'Pregled naslovne slike') }}" class="w-full h-auto border-2 border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="cobiss_title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="cobiss_title_sr" name="cobiss_title_sr" value="{{ $cobissTitleValue }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="cobiss_subtitle_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="cobiss_subtitle_sr" name="cobiss_subtitle_sr" value="{{ $cobissSubtitleValue }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>
            </form>
            <form id="english-cobiss" action="{{ route('homepage.updateCobissEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Cobiss section (EN)' : (App::getLocale() === 'sr-Cyrl' ? '"Cobiss" (EH)' : '"Cobiss" (EN)') }}
                        </h2>

                        <div class="mb-4">
                            <label for="cobiss_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                            <input type="text" id="cobiss_title_en" name="cobiss_title_en" value="{{ old('cobiss_title_en', $cobiss_title_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="cobiss_subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="cobiss_subtitle_en" name="cobiss_subtitle_en" value="{{ old('cobiss_subtitle_en', $cobiss_subtitle_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                            </div>
                    </div>
            </form>
        </div>

        @if ($ourTeamIsSelected)
            <div>
                <div class="flex items-center justify-between mb-6">    
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                            {{ App::getLocale() === 'en' ? 'Edit our team section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди "Наш тим" секцију' : 'Uredi "Naš tim" sekciju') }}
                        </h1>
                        <button onclick="toggleOurTeamVisibility()" id="cobissToggle" class="transition">
                            @if ($ourTeamVisible)
                                <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                                    <path
                                        d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                                    <path
                                        d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                                </svg>
                            @endif
                        </button>
                    </div>
                </div>

                <form id="serbian-team" action="{{ route('homepage.updateOurTeamSr') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                            <div class="mb-4">
                                <img src="{{ asset('images/editOurTeam.png') }}" alt="{{ App::getLocale() === 'en' ? 'Hero image preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед насловне слике' : 'Pregled naslovne slike') }}" class="w-full h-auto border-2 border-gray-300 rounded">
                            </div>

                            <div class="mb-4">
                                <label for="our_team_title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                    <input type="text" id="our_team_title_sr" name="our_team_title_sr" value="{{ $ourTeamTitleValue }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label for="our_team_subtitle_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                                <input type="text" id="our_team_subtitle_sr" name="our_team_subtitle_sr" value="{{ $ourTeamSubtitleValue }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                            </div>

                            <div class="mb-4">
                                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ App::getLocale() === 'en' ? 'Select employees:' : (App::getLocale() === 'sr-Cyrl' ? 'Изабери запослене:' : 'Izaberi zaposlene:') }}
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 max-h-80 overflow-y-auto">
                                    @foreach ($employees as $employee)
                                        <label class="flex items-center space-x-3 p-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <input type="checkbox" name="employees[]" value="{{ $employee->id }}"
                                                {{ in_array($employee->id, $selectedEmployees ?? []) ? 'checked' : '' }}
                                                class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600">
                                            <span class="text-gray-900 dark:text-gray-200">{{ $employee->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                            </div>
                        </div>
                </form>
                <form id="english-team" action="{{ route('homepage.updateOurTeamEn') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Team section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Тим (EН)' : 'Tim (EN)') }}
                        </h2>

                        <div class="mb-4">
                            <label for="our_team_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}
                            </label>
                            <input type="text" id="our_team_title_en" name="our_team_title_en" value="{{ old('our_team_title_en', $our_team_title_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="our_team_subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}
                            </label>
                            <input type="text" id="our_team_subtitle_en" name="our_team_subtitle_en" value="{{ old('our_team_subtitle_en', $our_team_subtitle_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mt-auto flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
       <div class="mt-10">
            <button onclick="showTemplates()" type="button"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ App::getLocale() === 'en' ? 'Add new section' : (App::getLocale() === 'sr-Cyrl' ? 'Додај нову секцију' : 'Dodaj novu sekciju') }}
            </button>
        </div>
        <div id="templateForm" class="mt-6 hidden">
            <form method="POST" action="{{ route('homepage.saveTeamVisibility') }}">
                @csrf
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                        {{ App::getLocale() === 'en' ? 'Choose a section template:' : (App::getLocale() === 'sr-Cyrl' ? 'Изабери шаблон секције:' : 'Izaberi šablon sekcije:') }}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($templateImages as $key => $imagePath)
                            @if (!($ourTeamIsSelected && $key === 'template1'))
                                <label class="cursor-pointer border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 hover:border-blue-500 transition-all">
                                    <input type="radio" name="template" value="{{ $key }}" class="hidden peer" required onclick="showEmployeesForm('{{ $key }}')">
                                    <img src="{{ asset($imagePath) }}" alt="Template {{ $key }}"
                                        class="rounded-lg w-full h-48 object-cover peer-checked:ring-4 peer-checked:ring-blue-500">
                                </label>
                            @endif
                        @endforeach
                    </div>
                    <div id="employeesForm" class="hidden">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ App::getLocale() === 'en' ? 'Select employees:' : (App::getLocale() === 'sr-Cyrl' ? 'Изабери запослене:' : 'Izaberi zaposlene:') }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 max-h-80 overflow-y-auto">
                            @foreach ($employees as $employee)
                                <label class="flex items-center space-x-3 p-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <input type="checkbox" name="employees[]" value="{{ $employee->id }}"
                                        class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600">
                                    <span class="text-gray-900 dark:text-gray-200">{{ $employee->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <button type="button" onclick="hideEmployeesForm()"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 focus:outline-none">
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                            <button id="show-team-forms" type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Add' : (App::getLocale() === 'sr-Cyrl' ? 'Додај' : 'Dodaj') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <form action="{{ route('homepage.updateComponentOrder') }}" method="POST" class="mt-10">
            @csrf
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg max-w-full md:max-w-[49%]">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    {{ App::getLocale() === 'en' ? 'Sort visible components' : (App::getLocale() === 'sr-Cyrl' ? 'Поређај видљиве компоненте' : 'Poređaj vidljive komponente') }}
                </h2>

                <ul id="sortable" class="space-y-2 cursor-move">
                    @php
                        $componentMap = [
                            'en' => [
                                'news' => 'News',
                                'contact' => 'Contact',
                                'cobiss' => 'Cobiss',
                                'our_team' => 'Team',
                            ],
                            'sr-Cyrl' => [
                                'news' => 'Вести',
                                'contact' => 'Контакт',
                                'cobiss' => 'Cobiss',
                                'our_team' => 'Тим',
                            ],
                            'sr' => [
                                'news' => 'Vesti',
                                'contact' => 'Kontakt',
                                'cobiss' => 'Cobiss',
                                'our_team' => 'Tim',
                            ],
                        ];

                        $visibleComponents = [];
                        if ($newsVisible ?? false) $visibleComponents[] = 'news';
                        if ($contactVisible ?? false) $visibleComponents[] = 'contact';
                        if ($cobissVisible ?? false) $visibleComponents[] = 'cobiss';
                        if ($ourTeamVisible ?? false) $visibleComponents[] = 'our_team';

                        $currentOrder = $data['component_order'] ?? [];
                        $sorted = array_filter($currentOrder, fn($item) => in_array($item, $visibleComponents));
                        $remaining = array_diff($visibleComponents, $sorted);
                        $finalOrder = array_merge($sorted, $remaining);

                        $locale = App::getLocale();
                    @endphp

                    <ul id="sortable" class="space-y-2 cursor-move">
                        {{-- Hero sekcija je uvek prva --}}
                        <li class="flex items-center justify-between w-64 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded shadow">
                            <span class="truncate">
                                {{ $locale === 'en' ? 'HERO (fixed first)' : ($locale === 'sr-Cyrl' ? 'Насловни део (фиксно)' : 'Naslovni deo (fiksno)') }}
                            </span>
                            <input type="hidden" name="components[]" value="hero">
                        </li>

                        @foreach ($finalOrder as $component)
                            <li class="flex items-center justify-between w-64 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded shadow">
                                <span class="truncate">
                                    {{ $componentMap[$locale][$component] ?? ucfirst(str_replace('_', ' ', $component)) }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-300 cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 5a1 1  0 1 0 2 0 1 1 0 1 0 -2 0" />
                                    <path d="M9 12a1 1 0 1 0 2 0 1 1 0 1 0 -2 0" />
                                    <path d="M9 19a1 1 0 1 0 2 0 1 1 0 1 0 -2 0" />
                                    <path d="M15 5a1 1 0 1 0 2 0 1 1 0 1 0 -2 0" />
                                    <path d="M15 12a1 1 0 1 0 2 0 1 1 0 1 0 -2 0" />
                                    <path d="M15 19a1 1 0 1 0 2 0 1 1 0 1 0 -2 0" />
                                </svg>
                                <input type="hidden" name="components[]" value="{{ $component }}">
                            </li>
                        @endforeach
                    </ul>
                </ul>
                <button type="submit"
                    class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none">
                    {{ App::getLocale() === 'en' ? 'Save order' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај поредак' : 'Sačuvaj poredak') }}
                </button>
            </div>
        </form>
        <div id="updateModal" tabindex="-1" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow dark:bg-gray-700 w-full max-w-md">
                <div class="p-6 text-center">
                    <h3 class="mb-5 text-lg font-normal text-gray-700 dark:text-gray-300">
                        {{ App::getLocale() === 'en' ? 'Data changed successfully.' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци су успешно ажурирани.' : 'Podaci su uspešno ažurirani.') }}
                    </h3>
                </div>
            </div>
        </div>
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
                x-data="{ slide: 1, total: 4, enlarged: false }">
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
                            {{ App::getLocale() === 'en' ? 'How to use homepage edit' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити уређивање почетне странице' : 'Kako koristiti uređivanje početne stranice') }}
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
                                    <img @click="enlarged = '/images/eyeIconVisibilityGif.gif'" src="/images/eyeIconVisibilityGif.gif" alt="change component visibility" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 2">
                                    <img @click="enlarged = '/images/newsSection.gif'" src="/images/newsSection.gif" alt="Edit Form" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 3">
                                    <img @click="enlarged = '/images/additionalSect.gif'" src="/images/additionalSect.gif" alt="Additional section" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
                                </template>
                                <template x-if="slide === 4">
                                    <img @click="enlarged = '/images/reordering.gif'" src="/images/reordering.gif" alt="reordering" class="rounded-xl max-h-52 object-contain bg-transparent transition-all duration-300 shadow hover:scale-105" />
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
                                    {{ App::getLocale() === 'en' ? 'Components visibility' : (App::getLocale() === 'sr-Cyrl' ? 'Видљивост компонената' : 'Vidljivost komponenata') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    On this page, you can edit your homepage by <strong>selecting the components</strong> you want to appear on it and editing their content. </br>
                                    The only mandatory component is the <strong>title section</strong>.</br>
                                    If you want a component to be displayed or hidden on the homepage, you should click the <strong>eye icon</strong> next to the name of that section. A <strong>green eye</strong> icon indicates that the component will be displayed, while a <strong>red, crossed-out eye</strong> indicates that the component will not be displayed on the homepage.
                                    @break
                                    @case('sr-Cyrl')
                                    На овој страници можете уредити Вашу почетну страницу, тако што <strong>бирате компоненте</strong> које желите да се на њој налазе и уређујете њихов садржај. </br>
                                    Једина обавезна компонента је <strong>насловни део</strong>.</br>
                                    Уколико желите да се нека компонента прикаже или не прикаже на почетној страници, треба да притиснете <strong>иконицу ока</strong> поред назива те секције. <strong>Зелена иконица ока</strong> означава да ће та компонента бити приказана, а <strong>црвено, прецртано око</strong> указује да се та компонента неће приказати на почетној страници.
                                    @break
                                    @default
                                    Na ovoj stranici možete urediti Vašu početnu stranicu, tako što <strong>birate komponente</strong> koje želite da se na njoj nalaze i uređujete njihov sadržaj.</br>
                                    Jedina obavezna komponenta je <strong>naslovni deo</strong>.</br>
                                    Ukoliko želite da se neka komponenta prikaže ili ne prikaže na početnoj stranici, treba da pritisnete <strong>ikonicu oka</strong> pored naziva te sekcije. <strong>Zelena ikonica oka</strong> označava da će ta komponenta biti prikazana, a <strong>crveno, precrtano oko</strong> ukazuje da se ta komponenta neće prikazati na početnoj stranici.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 2 -->
                        <template x-if="slide === 2">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Changing section data' : (App::getLocale() === 'sr-Cyrl' ? 'Промена података секције' : 'Promena podataka sekcije') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    You can change the content of the components in the forms on this page.</br> In the forms for the Serbian language, you can write in <strong>both scripts</strong> (Latin or Cyrillic), and the <strong>system will translate</strong> the data into English, which you can then <strong>review</strong> and, if necessary, <strong>correct</strong> in the adjacent forms.</br>
                                    The data will be saved by clicking the <strong>"save" button</strong>.
                                    Each form contains a photo of the section it modifies, allowing you to confirm which component you are editing.
                                    @break
                                    @case('sr-Cyrl')
                                    Садржај компонената можете да промените у формама на овој страници. </br> У формама за српски језик можете писати на <strong>оба писма</strong> (латиница или ћирилица), <strong>систем ће податке превести</strong> на енглески језик, које потом можете <strong>проверити</strong> и, по потреби, <strong>исправити</strong> у формама поред.</br>
                                    Подаци ће бити сачувани кликом на <strong>дугме "сачувај"</strong>.
                                    У свакој форми налази се фотографија секције коју та форма мења и на тај начин се можете уверити коју компоненту мењате.
                                    @break
                                    @default
                                    Sadržaj komponenata možete da promenite u formama na ovoj stranici. </br> U formama za srpski jezik možete pisati na <strong>oba pisma</strong> (latinica ili ćirilica), <strong>sistem će podatke prevesti</strong> na engleski jezik, koje potom možete <strong>proveriti</strong> i, po potrebi, <strong>ispraviti</strong> u formama pored. </br>
                                    Podaci će biti sačuvani klikom na dugme "sačuvaj".
                                    U svakoj formi nalazi se fotografija sekcije koju ta forma menja i na taj način se možete uveriti koju komponentu menjate.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 3 -->
                        <template x-if="slide === 3">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Adding new section' : (App::getLocale() === 'sr-Cyrl' ? 'Додавање нове секције' : 'Dodavanje nove sekcije') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    To add a new section to the homepage, you need to press the "Add New Section" button and then select the section you want to add. If you are sure you want to add the section, press the "Save" button.
                                    The data for the new section, as well as all other sections, can be modified in the form that will automatically appear on the page once the section is added.
                                    @break
                                    @case('sr-Cyrl')
                                    Да бисте додали нову секцију на почетну страницу, потребно је да притиснете дугме „Додај нову секцију“, а затим треба да изаберете секцију коју желите додати. Уколико сте сигурни да желите да додате секцију, притисните дугме „Сачувај“.
                                    Подаци нове секције, као и свих осталих, могу се променити у форми, која ће се аутоматски приказати на страници чим додате секцију.
                                    @break
                                    @default
                                    Da biste dodali novu sekciju na početnu stranicu, potrebno je da pritisnete dugme <strong>"Dodaj novu sekciju"</strong>, a potom treba da <strong>izaberete sekciju</strong> koju želite dodati. </br> Ukoliko ste sigurni da želite da dodate sekciju, pritisnite dugme <strong>"Sačuvaj".</strong> </br>
                                    Podatke nove sekcije, kao i svih ostalih, možete promeniti u formi, koja će se automatski prikazati na stranici, čim dodate sekciju.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        <!-- Slide 4 -->
                        <template x-if="slide === 4">
                            <div>
                                <h4 class="font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                    {{ App::getLocale() === 'en' ? 'Reordering sections' : (App::getLocale() === 'sr-Cyrl' ? 'Промена редоследа секција' : 'Promena redosleda sekcija') }}
                                </h4>
                                <p style="font-family: var(--font-body);">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Since the header section is the only <strong>mandatory component</strong>, it is always <strong>displayed first</strong> on the page. </br>
                                    The order of the other components can be changed at the bottom of the page by simply dragging the component to the desired position, as shown in the screenshot.</br>
                                    Save the order by pressing the <strong>"Save"</strong> button.
                                    @break
                                    @case('sr-Cyrl')
                                    Будући да је насловни део једина <strong>обавезна компонента</strong>, она се увек <strong>приказује прва</strong> на страници.</br>
                                    Распоред осталих компоненти можете променити у дну странице, једноставним превлачењем компоненте на жељено место, као што је приказано на снимку.</br>
                                    Редослед сачувајте притиском на дугме <strong>„Сачувај“</strong>.
                                    @break
                                    @default
                                    Budući da je naslovni deo jedina <strong>obavezna komponenta</strong>, ona se uvek <strong>prikazuje prva</strong> na stranici.</br>
                                    Raspored ostalih komponenata možete promeniti u dnu stranice, jednostavnim prevlačenjem komponente na željeno mesto, kao što je prikazano na snimku.</br>
                                    Redosled sačuvajte pritiskom da dugme <strong>"Sačuvaj"</strong>.
                                    @endswitch
                                </p>
                            </div>
                        </template>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(function () {
            $("#sortable").sortable({
                items: "li:not(:first-child)" 
            });
        });

        function toggleEye() {
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            const visible = eyeClosed.classList.contains('hidden') ? 0 : 1;

            fetch("{{ route('homepage.toggleNewsVisibility') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ visible })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                }
            });
        }

        function toggleNewsVisibility() {
            fetch("{{ route('homepage.toggleNewsVisibility') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(() => {
                location.reload(); 
            });
        }

        function toggleContactVisibility() {
            fetch("{{ route('homepage.toggleContactVisibility') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(() => location.reload());
        }

        function toggleCobissVisibility() {
            fetch("{{ route('homepage.toggleCobissVisibility') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(() => location.reload());
        }

        function toggleOurTeamVisibility() {
            fetch("{{ route('homepage.toggleOurTeamVisibility') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(() => location.reload());
        }

        function showTemplates() {
            document.getElementById('templateForm').classList.toggle('hidden');
        }

        function showEmployeesForm(templateKey) {
            const employeesForm = document.getElementById('employeesForm');

            if (templateKey === 'template1') {
                employeesForm.classList.remove('hidden');
            } else {
                employeesForm.classList.add('hidden');
                alert("Implementacija ovog šablona nije obuhvaćena MVP rešenjem. Prikaz ove komponente treba da prikaže na koji način bi ova internet stranica bila skalabilna. Sekcija koja jeste implementirana u ovom MVP rešenju je \"Naš tim\", koju u potpunosti možete testirati.");
            }
        }

        function hideEmployeesForm() {
            document.getElementById('employeesForm').classList.add('hidden');
            document.getElementById('employeeSearch').value = ''; 
            filterEmployees(); 
        }


        document.addEventListener('DOMContentLoaded', () => {
            const updateModal = document.getElementById('updateModal');

            function showModal() {
                updateModal.classList.remove('hidden');
                setTimeout(() => {
                    updateModal.classList.add('hidden');
                }, 3000); 
            }

            function handleFormSubmission(form, url) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);

                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();
                        if (data.success) {
                            showModal();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                });
            }

            const forms = [
                { element: document.getElementById('serbian-hero'), url: "{{ route('homepage.updateSr') }}" },
                { element: document.getElementById('english-hero'), url: "{{ route('homepage.updateEn') }}" },
                { element: document.getElementById('serbian-news'), url: "{{ route('homepage.updateNewsSr') }}" },
                { element: document.getElementById('english-news'), url: "{{ route('homepage.updateNewsEn') }}" },
                { element: document.getElementById('serbian-contact'), url: "{{ route('homepage.updateContactSr') }}" },
                { element: document.getElementById('english-contact'), url: "{{ route('homepage.updateContactEn') }}" },
                { element: document.getElementById('serbian-cobiss'), url: "{{ route('homepage.updateCobissSr') }}" },
                { element: document.getElementById('english-cobiss'), url: "{{ route('homepage.updateCobissEn') }}" }
            ];

            const serbianTeam = document.getElementById('serbian-team');
            const englishTeam = document.getElementById('english-team');
            
            if (serbianTeam) {
                forms.push({ element: serbianTeam, url: "{{ route('homepage.updateOurTeamSr') }}" });
            }
            if (englishTeam) {
                forms.push({ element: englishTeam, url: "{{ route('homepage.updateOurTeamEn') }}" });
            }

            forms.forEach(formConfig => {
                if (formConfig.element) {
                    handleFormSubmission(formConfig.element, formConfig.url);
                }
            });

            updateModal.addEventListener('click', (event) => {
                if (event.target === updateModal) {
                    updateModal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>