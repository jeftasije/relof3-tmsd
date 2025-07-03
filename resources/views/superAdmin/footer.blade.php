<x-app-layout>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="relative flex items-center justify-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'Edit Footer' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди подножје' : 'Uredi podnožje') }}
            </h1>

            <div class="absolute right-0">
                <button 
                    id="help-btn" 
                    onclick="toggleHelpModal()"
                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        
        <p class="mb-6 text-gray-700 dark:text-gray-300">
            {{ App::getLocale() === 'en' ? 
                'Fill in the details for changes in the Serbian form, then review the details in English in the form below. You can edit them if necessary.' : 
                (App::getLocale() === 'sr-Cyrl' ? 
                    'Попуните податке за промену у форми за српски језик, а потом прегледајте податке на енглеском језику у форми испод. Можете их исправити уколико има потребе.' : 
                    'Popunite podatke za promenu u formi za srpski jezik, a potom pregledajte podatke na engleskom jeziku u formi ispod. Možete ih ispraviti ukoliko ima potrebe.') 
            }}
            <br>
            <a href="#footer-preview" class="text-indigo-600 hover:underline">
                {{ App::getLocale() === 'en' ? 'To view the footer layout, check the bottom of the page.' : (App::getLocale() === 'sr-Cyrl' ? 'За приказ изгледа подножја погледајте дно странице.' : 'Za prikaz izgleda podnožja pogledajte dno stranice.') }}
            </a>
        </p>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ App::getLocale() === 'en' ? 'Footer successfully edited.' : (App::getLocale() === 'sr-Cyrl' ? 'Подножје успешно ажурирано' : 'Podnožje uspešno ažurirano.') }}
            </div>
        @endif

        <div class="mb-12">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                {{ App::getLocale() === 'en' ? 'Serbian Data' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци на српском језику' : 'Podaci na srpskom jeziku') }}
            </h2>
            <form id="serbian-form" action="{{ route('footer.edit.sr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Library information' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци о библиотеци' : 'Podaci o biblioteci') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Library name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив Библиотеке' : 'Naziv biblioteke') }}
                            </label>
                            <textarea
                                id="name"
                                name="name"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="name"
                                data-lang="sr"
                            >{{ app()->getLocale() === 'sr-Cyrl' ? $libraryDataSrCyr['name'] : $libraryDataSr['name'] }}</textarea>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Address' : (App::getLocale() === 'sr-Cyrl' ? 'Адреса' : 'Adresa') }}
                            </label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="address"
                                data-lang="sr"
                            >{{ old('address', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['address'] ?? '') : ($libraryDataSr['address'] ?? '') ) }}</textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pib" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Tax ID (PIB)' : (App::getLocale() === 'sr-Cyrl' ? 'ПИБ' : 'PIB') }}
                            </label>
                            <input
                                type="text"
                                id="pib"
                                name="pib"
                                value="{{ old('pib', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['pib'] ?? '') : ($libraryDataSr['pib'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="pib"
                                data-lang="sr"
                            >
                            @error('pib') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo_light" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Upload logo (light theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (светла тема)' : 'Otpremite logo (svetla tema)') }}
                            </label>
                            <input
                                type="file"
                                id="logo_light"
                                name="logo_light"
                                accept="image/*"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="logo_light"
                                data-lang="sr"
                            >
                            @error('logo_light') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo_dark" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Upload logo (dark theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (тамна тема)' : 'Otpremite logo (tamna tema)') }}
                            </label>
                            <input
                                type="file"
                                id="logo_dark"
                                name="logo_dark"
                                accept="image/*"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="logo_dark"
                                data-lang="sr"
                            >
                            @error('logo_dark') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Contact information' : (App::getLocale() === 'sr-Cyrl' ? 'Контакт информације' : 'Kontakt informacije') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Phone' : (App::getLocale() === 'sr-Cyrl' ? 'Телефон' : 'Telefon') }}
                            </label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['phone'] ?? '') : ($libraryDataSr['phone'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="phone"
                                data-lang="sr"
                            >
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Email' : (App::getLocale() === 'sr-Cyrl' ? 'Мејл адреса' : 'Mejl adresa') }}
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['email'] ?? '') : ($libraryDataSr['email'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="email"
                                data-lang="sr"
                            >
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Facebook URL' : (App::getLocale() === 'sr-Cyrl' ? 'Facebook URL' : 'Facebook URL') }}
                            </label>
                            <input
                                type="url"
                                id="facebook"
                                name="facebook"
                                value="{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['facebook'] ?? '') : ($libraryDataSr['facebook'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="facebook"
                                data-lang="sr"
                            >
                            @error('facebook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Twitter URL' : (App::getLocale() === 'sr-Cyrl' ? 'Twitter URL' : 'Twitter URL') }}
                            </label>
                            <input
                                type="url"
                                id="twitter"
                                name="twitter"
                                value="{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['twitter'] ?? '') : ($libraryDataSr['twitter'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="twitter"
                                data-lang="sr"
                            >
                            @error('twitter') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Working hours' : (App::getLocale() === 'sr-Cyrl' ? 'Радно време' : 'Radno vreme') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="work_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Working hours (one per line)' : (App::getLocale() === 'sr-Cyrl' ? 'Радно време (једно по реду)' : 'Radno vreme (jedno po redu)') }}
                            </label>
                            <textarea
                                id="work_hours"
                                name="work_hours"
                                rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="work_hours"
                                data-lang="sr"
                            >{{ old(
                                    'work_hours', 
                                    implode("\n", app()->getLocale() === 'sr-Cyrl' 
                                        ? ($libraryDataSrCyr['work_hours_formatted'] ?? []) 
                                        : ($libraryDataSr['work_hours_formatted'] ?? [])
                                    )
                            ) }}
                            </textarea>
                            @error('work_hours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Map and copyrights' : (App::getLocale() === 'sr-Cyrl' ? 'Мапа и ауторска права' : 'Mapa i autorska prava') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="map_embed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Google Maps Embed URL' : (App::getLocale() === 'sr-Cyrl' ? '"Google Maps URL"' : '"Google Maps URL"') }}
                            </label>
                            <input
                                type="url"
                                id="map_embed"
                                name="map_embed"
                                value="{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['map_embed'] ?? '') : ($libraryDataSr['map_embed'] ?? '') ) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="map_embed"
                                data-lang="sr"
                            >
                            @error('map_embed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="copyrights" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Copyright text' : (App::getLocale() === 'sr-Cyrl' ? 'Текст ауторских права' : 'Tekst autorskih prava') }}
                            </label>
                            <textarea
                                id="copyrights"
                                name="copyrights"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="copyrights"
                                data-lang="sr"
                            >{{ old('phone', app()->getLocale() === 'sr-Cyrl' ? ($libraryDataSrCyr['copyrights'] ?? '') : ($libraryDataSr['copyrights'] ?? '') ) }}</textarea>
                            @error('copyrights') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="mb-12">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                {{ App::getLocale() === 'en' ? 'English Data' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци на енглеском језику' : 'Podaci na engleskom jeziku') }}
            </h2>
            <form id="english-form" action="{{ route('footer.edit.en') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Library information' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци о библиотеци' : 'Podaci o biblioteci') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Library name' : (App::getLocale() === 'sr-Cyrl' ? 'Назив библиотеке' : 'Naziv biblioteke') }}
                            </label>
                            <textarea
                                id="name_en"
                                name="name_en"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="name"
                                data-lang="en"
                            >{{ old('name_en', $libraryDataEn['name'] ?? '') }}</textarea>
                            @error('name_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Address' : (App::getLocale() === 'sr-Cyrl' ? 'Адреса' : 'Adresa') }}
                            </label>
                            <textarea
                                id="address_en"
                                name="address_en"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="address"
                                data-lang="en"
                            >{{ old('address_en', $libraryDataEn['address'] ?? '') }}</textarea>
                            @error('address_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pib_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Tax ID (PIB)' : (App::getLocale() === 'sr-Cyrl' ? 'ПИБ' : 'PIB') }}
                            </label>
                            <input
                                type="text"
                                id="pib_en"
                                name="pib"
                                value="{{ old('pib', $libraryDataEn['pib'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="pib"
                                data-lang="en"
                            >
                            @error('pib') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo_light_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Upload logo (Light theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (светла тема)' : 'Otpremite logo (svetla tema)') }}
                            </label>
                            <input
                                type="file"
                                id="logo_light_en"
                                name="logo_light"
                                accept="image/*"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="logo_light"
                                data-lang="en"
                            >
                            @error('logo_light') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo_dark_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Upload logo (dark theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (тамна тема)' : 'Otpremite logo (tamna tema)') }}
                            </label>
                            <input
                                type="file"
                                id="logo_dark_en"
                                name="logo_dark"
                                accept="image/*"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="logo_dark"
                                data-lang="en"
                            >
                            @error('logo_dark') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Contact information' : (App::getLocale() === 'sr-Cyrl' ? 'Контакт информације' : 'Kontakt informacije') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="phone_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Phone' : (App::getLocale() === 'sr-Cyrl' ? 'Телефон' : 'Telefon') }}
                            </label>
                            <input
                                type="text"
                                id="phone_en"
                                name="phone"
                                value="{{ old('phone', $libraryDataEn['phone'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="phone"
                                data-lang="en"
                            >
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Email' : (App::getLocale() === 'sr-Cyrl' ? 'Мејл адреса' : 'Mejl adresa') }}
                            </label>
                            <input
                                type="email"
                                id="email_en"
                                name="email"
                                value="{{ old('email', $libraryDataEn['email'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="email"
                                data-lang="en"
                            >
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="facebook_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Facebook URL' : (App::getLocale() === 'sr-Cyrl' ? 'Facebook URL' : 'Facebook URL') }}
                            </label>
                            <input
                                type="url"
                                id="facebook_en"
                                name="facebook"
                                value="{{ old('facebook', $libraryDataEn['facebook'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="facebook"
                                data-lang="en"
                            >
                            @error('facebook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="twitter_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Twitter URL' : (App::getLocale() === 'sr-Cyrl' ? 'Twitter URL' : 'Twitter URL') }}
                            </label>
                            <input
                                type="url"
                                id="twitter_en"
                                name="twitter"
                                value="{{ old('twitter', $libraryDataEn['twitter'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="twitter"
                                data-lang="en"
                            >
                            @error('twitter') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Working hours' : (App::getLocale() === 'sr-Cyrl' ? 'Радно време' : 'Radno vreme') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="work_hours_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Working Hours (one per line)' : (App::getLocale() === 'sr-Cyrl' ? 'Радно време (једно по реду)' : 'Radno Vreme (jedno po redu)') }}
                            </label>
                            <textarea
                                id="work_hours_en"
                                name="work_hours_en"
                                rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="work_hours"
                                data-lang="en"
                            >{{ old('work_hours_en', implode("\n", $libraryDataEn['work_hours_formatted'] ?? [])) }}</textarea>
                            @error('work_hours_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ App::getLocale() === 'en' ? 'Map and copyrights' : (App::getLocale() === 'sr-Cyrl' ? 'Мапа и ауторска права' : 'Mapa i autorska prava') }}
                        </h3>
                        
                        <div class="mb-4">
                            <label for="map_embed_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Google Maps Embed URL' : (App::getLocale() === 'sr-Cyrl' ? '"Google Maps URL"' : '"Google Maps URL"') }}
                            </label>
                            <input
                                type="url"
                                id="map_embed_en"
                                name="map_embed"
                                value="{{ old('map_embed', $libraryDataEn['map_embed'] ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="map_embed"
                                data-lang="en"
                            >
                            @error('map_embed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="copyrights_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Copyright text' : (App::getLocale() === 'sr-Cyrl' ? 'Текст ауторских права' : 'Tekst autorskih prava') }}
                            </label>
                            <textarea
                                id="copyrights_en"
                                name="copyrights_en"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                data-preview-target="copyrights"
                                data-lang="en"
                            >{{ old('copyrights_en', $libraryDataEn['copyrights'] ?? '') }}</textarea>
                            @error('copyrights_en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-12">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ App::getLocale() === 'en' ? 'Footer preview' : (App::getLocale() === 'sr-Cyrl' ? 'Преглед подножја' : 'Pregled podnožja') }}
            </h2>
            <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                <div class="mb-4">
                    <label class="mr-4 text-gray-700 dark:text-gray-300">
                        <input type="radio" name="preview-lang" value="sr" checked> {{ App::getLocale() === 'en' ? 'serbian (latin)' : (App::getLocale() === 'sr-Cyrl' ? 'српски (латиница)' : 'srpski (latinica)') }}
                    </label>
                    <label class="mr-4 text-gray-700 dark:text-gray-300">
                        <input type="radio" name="preview-lang" value="sr-Cyrl"> {{ App::getLocale() === 'en' ? 'serbian (cyrillic)' : (App::getLocale() === 'sr-Cyrl' ? 'српски (ћирилица)' : 'srpski (ćirilica)') }}
                    </label>
                    <label class="text-gray-700 dark:text-gray-300">
                        <input type="radio" name="preview-lang" value="en"> {{ App::getLocale() === 'en' ? 'English' : (App::getLocale() === 'sr-Cyrl' ? 'eнглески' : 'engleski') }}
                    </label>
                </div>
                <footer id="footer-preview" class="bg-white dark:bg-gray-900">
                    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
                        <div class="flex flex-col md:flex-row md:justify-between md:flex-wrap gap-6">
                            <div class="flex-grow md:flex-grow-0 md:basis-1/3 mb-6 md:mb-0">
                                <a class="flex flex-col items-start">
                                    <img id="preview-logo_light" src="{{ asset($libraryData['logo_light'] ?? 'images/nbnp-logo.png') }}" alt="Logo Light" class="max-h-12 hidden dark:block">
                                    <img id="preview-logo_dark" src="{{ asset($libraryData['logo_dark'] ?? 'images/nbnp-logo-dark.png') }}" alt="Logo Dark" class="max-h-12 block dark:hidden">
                                    <span id="preview-name" class="text-2xl font-semibold whitespace-normal max-w-xs break-words dark:text-white">
                                        {{ $libraryData['name'] ?? '' }}
                                    </span>
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                        <p><span id="preview-address_label">{{ $libraryData['address_label'] }}:</span> <span id="preview-address">{{ $libraryData['address'] ?? '' }}</span></p>
                                        <p><span id="preview-pib_label">{{ $libraryData['pib_label'] }}:</span> <span id="preview-pib">{{ $libraryData['pib'] ?? '' }}</span></p>
                                    </div>
                                </a>
                            </div>

                            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2 md:basis-1/3 flex-grow">
                                <div>
                                    <h2 id="preview-work_hours_label" class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                        {{ $libraryData['work_hours_label'] }}
                                    </h2>
                                    <ul id="preview-work_hours" class="text-gray-500 dark:text-gray-400 font-medium">
                                        @foreach ($libraryData['work_hours_formatted'] ?? [] as $line)
                                            <li>{{ $line }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    <h2 id="preview-phone_label" class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                        {{ $libraryData['phone_label'] }}
                                    </h2>
                                    <ul class="ul text-gray-400 dark:text-gray-300 font-medium space-y-2 mb-4">
                                        <li><i class="fas fa-phone me-2"></i> <span id="preview-phone">{{ $libraryData['phone'] ?? '' }}</span></li>
                                        <li><i class="fas fa-envelope me-2"></i> <span id="preview-email">{{ $libraryData['email'] ?? '' }}</span></li>
                                    </ul>

                                <div>
                                    <ul class="text-gray-500 dark:text-gray-400 font-medium space-y-2 mb-4">
                                        <li><i class="fas fa-phone me-2"></i> <span id="preview-phone">{{ $libraryData->phone ?? '' }}</span></li>
                                        <li><i class="fas fa-envelope me-2"></i> <span id="preview-email">{{ $libraryData->email ?? '' }}</span></li>
                                    </ul>

                                    <div class="flex space-x-4 mt-2">
                                        @if ($libraryDataSr['facebook'] && $libraryDataEn['facebook'] !== '#')
                                            <a id="preview-facebook" href="{{ $libraryData['facebook'] }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Facebook page">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 8 19" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($libraryDataSr['twitter'] && $libraryDataEn['twitter'] !== '#')
                                            <a id="preview-twitter" href="{{ $libraryData['twitter'] }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Twitter page">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        @endif
                                        <a id="preview-email-link" href="mailto:{{ $libraryData['email'] ?? 'dositejbib@gmail.com' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Email">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a3 3 0 0 0 3.22 0L21 8m-18 0v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8M3 8V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 md:mt-0 md:basis-1/4 w-full md:w-auto">
                            <iframe
                                id="preview-map_embed"
                                src="{{ $libraryData['map_embed']  }}"
                                width="100%"
                                height="200"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="rounded shadow-sm"
                            ></iframe>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />

                    <div class="text-center mt-4 text-sm text-gray-500 dark:text-gray-400">
                        <span id="preview-copyrights">{{ $libraryData['copyrights'] ?? '' }}</span>
                        <a href="#" class="hover:underline" id="preview-name_footer">{{ $libraryData['name'] ?? '' }}</a>.
                    </div>
                </div>
                </footer>
                <div id="updateModal" tabindex="-1" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow dark:bg-gray-700 w-full max-w-md">
                        <div class="p-6 text-center">
                            <h3 class="mb-5 text-lg font-normal text-gray-700 dark:text-gray-300">
                                {{ App::getLocale() === 'en' ? 'Data changed successfully.' : (App::getLocale() === 'sr-Cyrl' ? 'Подаци су успешно ажурирани.' : 'Podaci su uspešno ažurirani.') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div id="helpModalContent" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
                        <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                            &times;
                        </button>
                        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                            {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 space-y-2">
                            {!! App::getLocale() === 'en'
                                ? 'To change the <strong>footer data</strong>, please fill out the form below with the data you want to update, in Serbian (Latin or Cyrillic). Fields you do not change will remain the same. </br> The data will be saved by clicking the <strong>Save button</strong>.  </br> In the second form (the one below the one you previously filled out), you will be able to review the data that has been <strong>automatically translated</strong> into <strong>English</strong> based on the data you previously entered. <strong>Review</strong> the data and <strong>edit</strong> it if necessary.  </br> If you change the data in English, save it by clicking the <strong>Save button</strong>. To see how the footer will look with the new data, you can check at the bottom of the page.'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Да бисте променили <strong>податке у подножју</strong>, потребно је да попуните форму испод подацима на српском језику (на било ком писму) које желите да промените. Поља која не промените остаће иста. </br> Подaци ће се сачувати кликом на дугме <strong>сачувај</strong>.  </br> У другој форми (форма испод оне коју сте претходно попунили), моћи ћете да прегледате податке који су <strong>аутоматски преведени на енглески језик</strong>, на основу оних које сте претходно унели. Податке <strong>прегледајте</strong> и, по потреби, <strong>измените</strong>.  </br> Уколико промените податке на енглеском језику, сачувајте их кликом на <strong>дугме сачувај</strong>. Како би подножје изгледало са новим подацима, можете погледати на дну странице.' 
                                    : 'Da biste promenili <strong>podatke u podnožju</strong>, potrebno je da popunite formu ispod podacima na srpskom jeziku (na bilo kom pismu) koje želite promeniti. Polja koja ne promenite će ostati ista. </br> Podaci će se sačuvati klikom na dugme <strong>sačuvaj</strong>.  </br> U drugoj formi (forma ispod one koju ste prethodno popunili), moći ćete da pregledate podatke koji su <strong>automatski prevedeni na engleski jezik</strong>, na osnovu onih koje ste prethodno uneli. Podatke <strong>pregledajte</strong> i, po potrebi, <strong>izmenite</strong>. </br> Ukoliko promenite podatke na engleskom jeziku, sačuvajte ih klikom na <strong>dugme sačuvaj</strong>. Kako bi podnožje izgledalo sa novim podacima možete pogledati na dnu stranice.')
                            !!}
                        </p>
                    </div>
                </div>
            </div>
        <script>
            function toggleHelpModal() {
                const modal = document.getElementById('helpModal');
                modal.classList.toggle('hidden');
            }

            document.getElementById('helpModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    toggleHelpModal();
                }
            });
            
            document.addEventListener('DOMContentLoaded', () => {
                const inputs = document.querySelectorAll('[data-preview-target]');
                let currentLang = 'sr'; 

                const srData = @json($libraryDataSr);
                const enData = @json($libraryDataEn);
                const srCyrData = @json($libraryDataSrCyr);

                function updatePreview(lang) {
                    const data = lang === 'sr' ? srData : (lang === 'sr-Cyrl' ? srCyrData : enData);
                    document.getElementById('preview-name').textContent = data.name || '';
                    document.getElementById('preview-address').textContent = data.address || '';
                    document.getElementById('preview-address_label').textContent = data.address_label || '{{ App::getLocale() === 'en' ? 'Address' : (App::getLocale() === 'sr-Cyrl' ? 'Адреса' : 'Adresa') }}';
                    document.getElementById('preview-pib').textContent = data.pib || '';
                    document.getElementById('preview-pib_label').textContent = data.pib_label || '{{ App::getLocale() === 'en' ? 'Tax ID (PIB)' : (App::getLocale() === 'sr-Cyrl' ? 'ПИБ' : 'PIB') }}';
                    document.getElementById('preview-phone').textContent = data.phone || '';
                    document.getElementById('preview-phone_label').textContent = data.phone_label || '{{ App::getLocale() === 'en' ? 'Contact' : (App::getLocale() === 'sr-Cyrl' ? 'Контакт' : 'Kontakt') }}';
                    document.getElementById('preview-email').textContent = data.email || '';
                    document.getElementById('preview-email-link').href = `mailto:${data.email || 'dositejbib@gmail.com'}`;
                    document.getElementById('preview-facebook').href = data.facebook || '#';
                    document.getElementById('preview-twitter').href = data.twitter || '#';
                    document.getElementById('preview-work_hours_label').textContent = data.work_hours_label || '{{ App::getLocale() === 'en' ? 'Working Hours' : (App::getLocale() === 'sr-Cyrl' ? 'Радно Време' : 'Radno Vreme') }}';
                    document.getElementById('preview-work_hours').innerHTML = (data.work_hours_formatted || []).map(line => `<li>${line}</li>`).join('');
                    document.getElementById('preview-map_embed').src = data.map_embed || 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed';
                    document.getElementById('preview-copyrights').textContent = data.copyrights || '';
                    document.getElementById('preview-name_footer').textContent = data.name || '';
                    document.getElementById('preview-logo_light').src = data.logo_light || '{{ asset('images/nbnp-logo.png') }}';
                    document.getElementById('preview-logo_dark').src = data.logo_dark || '{{ asset('images/nbnp-logo-dark.png') }}';
                }

                document.querySelectorAll('input[name="preview-lang"]').forEach(radio => {
                    radio.addEventListener('change', (e) => {
                        currentLang = e.target.value;
                        updatePreview(currentLang);
                    });
                });

                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        if (input.dataset.lang === currentLang) {
                            const target = input.dataset.previewTarget;
                            const preview = document.getElementById(`preview-${target}`);
                            if (input.type === 'file' && input.files[0]) {
                                preview.src = URL.createObjectURL(input.files[0]);
                            } else if (target === 'work_hours') {
                                const lines = input.value.split('\n').filter(line => line.trim());
                                preview.innerHTML = lines.map(line => `<li>${line}</li>`).join('');
                            } else if (target === 'map_embed') {
                                preview.src = input.value || 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed';
                            } else if (target === 'facebook' || target === 'twitter') {
                                preview.href = input.value || '#';
                            } else if (target === 'email') {
                                preview.textContent = input.value || '';
                                document.getElementById('preview-email-link').href = `mailto:${input.value || 'dositejbib@gmail.com'}`;
                            } else {
                                preview.textContent = input.value || '';
                            }
                        }
                    });
                });
                updatePreview(currentLang);
            });

            document.addEventListener('DOMContentLoaded', () => {
                const updateModal = document.getElementById('updateModal');
                const serbianForm = document.getElementById('serbian-form');
                const englishForm = document.getElementById('english-form');

                if (!updateModal || !serbianForm || !englishForm) {
                    console.log('One or more elements not found:', { updateModal, serbianForm, englishForm, });
                    return;
                }

                function showModal() {
                    updateModal.classList.remove('hidden');
                }

                function hideModal() {
                    updateModal.classList.add('hidden');
                }

                serbianForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(serbianForm);

                    fetch(serbianForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showModal();
                            if (data.data) {
                                const srData = data.data;
                                document.getElementById('preview-name').textContent = srData.name || '';
                                document.getElementById('preview-address').textContent = srData.address || '';
                                document.getElementById('preview-pib').textContent = srData.pib || '';
                                document.getElementById('preview-phone').textContent = srData.phone || '';
                                document.getElementById('preview-email').textContent = srData.email || '';
                                document.getElementById('preview-facebook').href = srData.facebook || '#';
                                document.getElementById('preview-twitter').href = srData.twitter || '#';
                                document.getElementById('preview-work_hours').innerHTML = (srData.work_hours_formatted || []).map(line => `<li>${line}</li>`).join('');
                                document.getElementById('preview-map_embed').src = srData.map_embed || 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed';
                                document.getElementById('preview-copyrights').textContent = srData.copyrights || '';
                                document.getElementById('preview-name_footer').textContent = srData.name || '';
                                document.getElementById('preview-logo_light').src = srData.logo_light || '{{ asset('images/nbnp-logo.png') }}';
                                document.getElementById('preview-logo_dark').src = srData.logo_dark || '{{ asset('images/nbnp-logo-dark.png') }}';
                            }
                        } else {
                            console.error('Error:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });

                englishForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(englishForm);

                    fetch(englishForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showModal();
                            if (data.data) {
                                const enData = data.data;
                                document.getElementById('preview-name').textContent = enData.name || '';
                                document.getElementById('preview-address').textContent = enData.address || '';
                                document.getElementById('preview-pib').textContent = enData.pib || '';
                                document.getElementById('preview-phone').textContent = enData.phone || '';
                                document.getElementById('preview-email').textContent = enData.email || '';
                                document.getElementById('preview-facebook').href = enData.facebook || '#';
                                document.getElementById('preview-twitter').href = enData.twitter || '#';
                                document.getElementById('preview-work_hours').innerHTML = (enData.work_hours_formatted || []).map(line => `<li>${line}</li>`).join('');
                                document.getElementById('preview-map_embed').src = enData.map_embed || 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed';
                                document.getElementById('preview-copyrights').textContent = enData.copyrights || '';
                                document.getElementById('preview-name_footer').textContent = enData.name || '';
                                document.getElementById('preview-logo_light').src = enData.logo_light || '{{ asset('images/nbnp-logo.png') }}';
                                document.getElementById('preview-logo_dark').src = enData.logo_dark || '{{ asset('images/nbnp-logo-dark.png') }}';
                            }
                        } else {
                            console.error('Error:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });

                updateModal.addEventListener('click', (event) => {
                    if (event.target === updateModal) {
                        hideModal();
                    }
                });
            });
        </script>
</x-app-layout>