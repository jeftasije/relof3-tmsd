<x-app-layout>
    @php
        $locale = App::getLocale();
        $subtitleValue = '';
        $titleValue = '';

        if ($locale === 'sr-Cyrl') {
            $subtitleValue = old('subtitle_sr_cyr', $subtitle_sr_cyr ?? '');
            $titleValue = old('title_sr_cyr', $title_sr_cyr ?? '');
        } else {
            $subtitleValue = old('subtitle_sr_lat', $subtitle_sr_lat ?? '');
            $titleValue = old('title_sr_lat', $title_sr_lat ?? '');
        }
    @endphp
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">

        <div class="flex items-center justify-between mb-6">    
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'Edit homepage' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди почетну страницу' : 'Uredi početnu stranicu') }}
            </h1>
        </div>

        <form action="{{ route('homepage.updateSr') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Leva strana --}}
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Edit herosection' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди насловни део' : 'Uredi naslovni deo') }}
                    </h2>

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
        <form action="#" method="POST" enctype="multipart/form-data">
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
        

    </div>
</x-app-layout>