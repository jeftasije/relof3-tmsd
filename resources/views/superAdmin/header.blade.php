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
    <div x-data="{helpOpen: false}" class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8 mid-h-screen">
        <div>
            <div class="relative flex items-center justify-center mb-8">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full">
                    {{ App::getLocale() === 'en' ? 'Edit header' : (App::getLocale() === 'sr-Cyrl' ? 'Уреди заглавље' : 'Uredi zaglavlje') }}
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
            <form id="serbian-form" action="{{ route('header.edit.sr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                        <div class="mb-4">
                            <label for="title_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}</label>
                                <input type="text" id="title_sr" name="title_sr" value="{{ $titleValue }}" data-lang="sr"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="subtitle_sr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}</label>
                            <input type="text" id="subtitle_sr" name="subtitle_sr" value="{{ $subtitleValue }}" data-lang="sr"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="logo_light" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Upload logo (light theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (светла тема)' : 'Otpremite logo (svetla tema)') }}</label>
                            <input type="file" id="logo_light" name="logo_light" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 dark:text-white bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600"></input>
                        </div>
                        <div class="mb-4">
                            <label for="logo_dark" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Upload logo (dark theme)' : (App::getLocale() === 'sr-Cyrl' ? 'Отпреми лого (тамна тема)' : 'Otpremite logo (tamna tema)') }}</label>
                            <input type="file" id="logo_dark" name="logo_dark" accept="image/*"
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
            <form id="english-form" action="{{ route('header.edit.en') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg flex flex-col">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Hero section (EN)' : (App::getLocale() === 'sr-Cyrl' ? 'Насловни део (EH)' : 'Naslovni deo (EN)') }}
                    </h2>
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}
                        </label> 
                        <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $title_en ?? '') }}" data-lang="en"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="subtitle_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Subtitle' : (App::getLocale() === 'sr-Cyrl' ? 'Поднаслов' : 'Podnaslov') }}
                        </label>
                        <input type="text" id="subtitle_en" name="subtitle_en" value="{{ old('subtitle_en', $subtitle_en ?? '') }}" data-lang="en"
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
            <label class="mr-5"><input type="radio" name="lang" value="sr" checked>{{ App::getLocale() === 'en' ? 'latin' : (App::getLocale() === 'sr-Cyrl' ? 'латиница' : 'latinica') }}</label>
            <label class="mr-5"><input type="radio" name="lang" value="sr_cyrl"> {{ App::getLocale() === 'en' ? 'cyrillic' : (App::getLocale() === 'sr-Cyrl' ? 'ћирилица' : 'ćirilica') }}</label>
            <label class="mr-5"><input type="radio" name="lang" value="en"> {{ App::getLocale() === 'en' ? 'English' : (App::getLocale() === 'sr-Cyrl' ? 'енглески' : 'engleski') }}</label>
        </div>
        <div id="header-preview-container" class="mt-6 border rounded-lg shadow-sm break-words">
            <nav class="py-5 px-10" style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <div class="flex items-center space-x-3">
                        <x-application-logo/>
                        <span class="self-center text-2xl font-semibold whitespace-nowrap break-words" style="color: var(--primary-text)">
                            <span id="preview-header-title" class="break-all whitespace-normal overflow-hidden">
                                {{ $title_sr_lat }}
                            </span><br />
                            <span id="preview-header-subtitle" class="break-all whitespace-normal overflow-hidden">
                                {{ $subtitle_sr_lat }}
                            </span>
                        </span>
                    </div>
                </div>
            </nav>
        </div>

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
                        ? 'On this page, you can <strong>change the information</strong> displayed in <strong>the header</strong> of your page.<br>
                            To change the content, you need to enter the information in <strong>the form</strong> and press <strong>the "Save"</strong> button.<br>
                            In the first form, you should enter the information in Serbian (Latin or Cyrillic), and then the system will <strong>automatically translate</strong> the information into English. You can <strong>review</strong> and, if necessary, <strong>edit</strong> it in the form for the English language.<br>
                            How the header with the new data will look can be seen below the form, in the preview.'
                        : (App::getLocale() === 'sr-Cyrl'
                            ? 'На овој страници можете <strong>променити податке</strong> који се приказују у <strong>заглављу</strong> ваше странице.<br>
                                Да бисте променили садржај, потребно је да унесете податке у <strong>форму</strong> и притиснете дугме <strong>„Сачувај“</strong>.<br>
                                У прву форму треба да унесете податке на српском језику , на било ком писму, а онда ће систем <strong>аутоматски превести</strong> податке на енглески језик, те податке можете <strong>проверити</strong> и, по потреби, <strong>изменити</strong> у форми за енглески језик.<br>
                                Како би заглавље са новим подацима изгледало, можете видети испод форме, у приказу.' 
                            : 'Na ovoj stranici možete <strong>promeniti podatke</strong> koji se prikazuju u <strong>zaglavlju</strong> Vaše stranice.</br> Da biste promenili sadržaj, potrebno je da unesete podatke u <strong>formu</strong> i pritisnete dugme <strong>"Sačuvaj"</strong>. </br> U prvu formu treba da unesete podatke na srpskom jeziku, na bilo kom pismu, a onda će sistem <strong>automatski prevesti</strong> podatke na engleski jezik, te podatke možete <strong>proveriti</strong> i, po potrebi, <strong>izmeniti</strong> u formi za engleski jezik. </br> Kako bi zaglavlje sa novim podacima izgledalo, možete videti ispod forme, u prikazu.')
                    !!}
                </p>
            </div>
        </div>
    </div>
    <script>
        const titles = {
            sr: {
                title: @json($title_sr_lat),
                subtitle: @json($subtitle_sr_lat),
            },
            'sr_cyrl': {
                title: @json($title_sr_cyr),
                subtitle: @json($subtitle_sr_cyr),
            },
            en: {
                title: @json($title_en),
                subtitle: @json($subtitle_en),
            }
        };

        let currentLang = 'sr';

        document.querySelectorAll('input[name="lang"]').forEach(radio => {
            radio.addEventListener('change', function () {
                currentLang = this.value;
                updatePreview(titles[currentLang].title, titles[currentLang].subtitle);
            });
        });

        function updatePreview(title, subtitle) {
            document.getElementById('preview-header-title').textContent = title;
            document.getElementById('preview-header-subtitle').textContent = subtitle;
        }

        function setupRealtimeInput(idTitle, idSubtitle) {
            const titleInput = document.getElementById(idTitle);
            const subtitleInput = document.getElementById(idSubtitle);

            if (titleInput) {
                titleInput.addEventListener('input', () => {
                    if (currentLang === titleInput.dataset.lang) {
                        document.getElementById('preview-header-title').textContent = titleInput.value;
                    }
                });
            }

            if (subtitleInput) {
                subtitleInput.addEventListener('input', () => {
                    if (currentLang === subtitleInput.dataset.lang) {
                        document.getElementById('preview-header-subtitle').textContent = subtitleInput.value;
                    }
                });
            }
        }

        setupRealtimeInput('title_sr', 'subtitle_sr');         
        setupRealtimeInput('title_en', 'subtitle_en');         

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
                            showModal(); } 
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
                });

                updateModal.addEventListener('click', (event) => {
                    if (event.target === updateModal) {
                        hideModal();
                    }
                });
            });
    </script>
</x-app-layout>