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

        if ($locale === 'sr-Cyrl') {
            $subtitleValue = old('subtitle_sr_cyr', $subtitle_sr_cyr ?? '');
            $titleValue = old('title_sr_cyr', $title_sr_cyr ?? '');
            $newsTitleValue = old('news_title_sr_cyr', $news_title_sr_cyr ?? '');
            $contactTitleValue = old('contact_title_sr_cyr', $contact_title_sr_cyr ?? '');
            $contactSubtitleValue = old('contact_subtitle_sr_cyr', $contact_subtitle_sr_cyr ?? '');
            $cobissTitleValue = old('cobiss_title_sr_cyr', $cobiss_title_sr_cyr ?? '');
            $cobissSubtitleValue = old('cobiss_subtitle_sr_cyr', $cobiss_subtitle_sr_cyr ?? '');

        } else {
            $subtitleValue = old('subtitle_sr_lat', $subtitle_sr_lat ?? '');
            $titleValue = old('title_sr_lat', $title_sr_lat ?? '');
            $newsTitleValue = old('news_title_sr_lat', $news_title_sr_lat ?? '');
            $contactTitleValue = old('contact_title_sr_lat', $contact_title_sr_lat ?? '');
            $contactSubtitleValue = old('contact_subtitle_sr_lat', $contact_subtitle_sr_lat ?? '');
            $cobissTitleValue = old('cobiss_title_sr_lat', $cobiss_title_sr_lat ?? '');
            $cobissSubtitleValue = old('cobiss_subtitle_sr_lat', $cobiss_subtitle_sr_lat ?? '');
        }
    @endphp
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div>
            <div class="relative flex items-center justify-center mb-8">
                <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Edit homepage' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди почетну страницу' : 'Uredi početnu stranicu') }}
                </h1>

                <div class="absolute right-0">
                    <button 
                        id="help-btn" 
                        onclick="toggleHelpModal()"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 17l0 .01" />
                            <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                        </svg>
                        <span class="ml-3">
                            {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                        </span>
                    </button>
                </div>
            </div>


            <form action="{{ route('homepage.updateSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">

                    {{-- Leva strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">

                        {{-- Slika --}}
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

                        {{-- Upload slike --}}
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'New background photo' : (App::getLocale() === 'sr-Cyrl' ? 'Нова позадинска фотографија' : 'Nova pozadinska fotografija') }}</label>
                            <input type="file" id="image" name="image" accept="image/*"
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
            <form action="{{ route('homepage.updateEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    {{-- Desna strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EN)' : 'Naslovni deo (EN)') }}
                        </h2>

                        <div class="mb-4">
                            <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                            <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $title_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="subtitle_en" name="subtitle_en" value="{{ old('subtitle_en', $subtitle_en ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
            </form>
            
        </div>






        <div>
            <div class="flex items-center justify-between mb-6">    
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ App::getLocale() === 'en' ? 'Edit news section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди секцију вести' : 'Uredi sekciju vesti') }}
                    </h1>

                    <!-- Zeleno oko -->
                    <svg id="eye-open" class="w-6 h-6 text-green-600 cursor-pointer transition" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24" onclick="toggleEye()">
                        <path stroke="currentColor" stroke-width="2"
                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    <!-- Crveno precrtano oko -->
                    <svg id="eye-closed" class="w-6 h-6 text-red-600 cursor-pointer transition hidden" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24" onclick="toggleEye()">
                        <path
                            d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                        <path
                            d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                        <path
                            d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                    </svg>
                </div>
            </div>

            <form action="{{ route('homepage.updateNewsSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">

                    {{-- Leva strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">

                        {{-- Slika --}}
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
                <form action="{{ route('homepage.updateNewsEn') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        {{-- Desna strana --}}
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EN)' : 'Naslovni deo (EN)') }}
                            </h2>

                            <div class="mb-4">
                                <label for="news_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="news_title_en" name="news_title_en" value="{{ old('news_title_en', $news_title_en ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                        </div>
                </form>
        </div>







        <div>
            <div class="flex items-center justify-between mb-6">    
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Edit contact section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди контакт секцију' : 'Uredi kontakt sekciju') }}
                </h1>
            </div>

            <form action="{{ route('homepage.updateContactSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">

                    {{-- Leva strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">

                        {{-- Slika --}}
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

                        {{-- Upload slike --}}
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'New photo' : (App::getLocale() === 'sr-Cyrl' ? 'Нова фотографија' : 'Nova fotografija') }}</label>
                            <input type="file" id="image2" name="image2" accept="image/*"
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
            <form action="{{ route('homepage.updateContactEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    {{-- Desna strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EN)' : 'Naslovni deo (EN)') }}
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
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
            </form>
        </div>





        <div>
            <div class="flex items-center justify-between mb-6">    
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Edit COBISS section' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди "COBISS" секцију' : 'Uredi "COBISS" sekciju') }}
                </h1>
            </div>

            <form action="{{ route('homepage.updateCobissSr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">

                    {{-- Leva strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">

                        {{-- Slika --}}
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
            <form action="{{ route('homepage.updateCobissEn') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    {{-- Desna strana --}}
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EN)' : 'Naslovni deo (EN)') }}
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
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
            </form>
        </div>
        <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
                <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </h2>
                <p class="text-gray-700 dark:text-gray-300 space-y-2">
                    {!! App::getLocale() === 'en'
                        ? 'On this page, you can edit your homepage by selecting the components you want to appear on it and editing their content.
                            The only mandatory component is the title section.
                            If you want a component to be displayed or hidden on the homepage, you should click the eye icon next to the name of that section. A green eye icon indicates that the component will be displayed, while a red, crossed-out eye indicates that the component will not be displayed on the homepage.
                            You can change the content of the components in the forms on this page. In the forms for the Serbian language, you can write in both scripts (Latin or Cyrillic), and the system will translate the data into English, which you can then review and, if necessary, correct in the adjacent forms.
                            The data will be saved by clicking the "save" button.
                            Each form contains a photo of the section it modifies, allowing you to confirm which component you are editing.'
                        : (App::getLocale() === 'sr-Cyrl'
                            ? 'На овој страници можете уредити Вашу почетну страницу, тако што бирате компоненте које желите да се на њој налазе и уређујете њихов садржај.
                                Једина обавезна компонента је насловни део.
                                Уколико желите да се нека компонента прикаже или не прикаже на почетној страници, треба да притиснете иконицу ока поред назива те секције. Зелена иконица ока означава да ће та компонента бити приказана, а црвено, прецртано око указује да се та компонента неће приказати на почетној страници.
                                Садржај компоненти можете да промените у формама на овој страници, у формама за српски језик можете писати на оба писма (латиница или ћирилица), систем ће податке превести на енглески језик, које потом можете проверити и, по потреби, исправити у формама поред.
                                Подаци ће бити сачувани кликом на дугме "сачувај".
                                У свакој форми налази се фотографија секције коју та форма мења и на тај начин се можете уверити коју компоненту мењате.'
                            : 'Na ovoj stranici možete urediti Vašu početnu stranicu, tako što birate komponente koje želite da se na njoj nalaze i uređujete njihov sadržaj.
                                Jedina obavezna komponenta je naslovni deo.
                                Ukoliko želite da se neka komponenta prikaže ili ne prikaže na početnoj stranici, treba da pritisnete ikonicu oka pored naziva te sekcije. Zelena ikonica oka označava da će ta komponenta biti prikazana, a crveno, precrtano oko ukazuje da se ta komponenta neće prikazati na početnoj stranici. 
                                Sadržaj komponenti možete da promenite u formama na ovoj stranici, u formama za srpski jezik možete pisati na oba pisma (latinica ili ćirilica), sistem će podatke prevesti na engleski jezik, koje potom možete proveriti i, po potrebi, ispraviti u formama pored. 
                                Podaci će biti sačuvani klikom na dugme "sačuvaj".
                                U svakoj formi nalazi se fotografija sekcije koju ta forma menja i na taj način se možete uveriti koju komponentu menjate.')
                            !!}
                </p>
            </div>
        </div>
    </div>
    <script>
        function toggleEye() {
            const openEye = document.getElementById('eye-open');
            const closedEye = document.getElementById('eye-closed');

            openEye.classList.toggle('hidden');
            closedEye.classList.toggle('hidden');
        }

        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.toggle('hidden');
        }

    </script>

</x-app-layout>