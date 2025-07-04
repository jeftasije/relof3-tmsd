<x-guest-layout>
    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 4000)"
        class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
        {{ __('gallery.' . session('success')) }}
    </div>
    @endif
    <div class="max-w-4xl mx-auto py-10 px-6 text-gray-900 dark:text-white">
        <div class="flex items-center justify-center relative mb-6 mt-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full sm:mb-4 md:mb-6"
                style="color: var(--primary-text); font-family: var(--font-title);">
                @switch(App::getLocale())
                @case('en') Gallery @break
                @case('sr-Cyrl') Галерија @break
                @default Galerija
                @endswitch
            </h1>
            @auth
            <div class="flex justify-end mb-2">
                <button
                    id="help-btn"
                    data-modal-target="helpModal" data-modal-toggle="helpModal"
                    class="flex items-center text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group absolute right-0"
                    style="top: 35%; transform: translateY(-50%)">
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
            @endauth
        </div>

        @auth
        <div class="text-right mb-6">
            <button id="editBtn"
                class="py-2 px-4 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]"
                type="button">
                @switch(App::getLocale())
                @case('en') Edit @break
                @case('sr-Cyrl') Уреди @break
                @default Uredi
                @endswitch
            </button>
        </div>
        @endauth

        @auth
        <form action="{{ route('gallery.updateDescription') }}" method="POST" id="galleryForm" class="space-y-4 ">
            @csrf
            @method('PATCH')
            <div class="max-w-lg mx-auto">
                <div id="valueDisplay" class="prose dark:prose-invert max-w-none text-center"
                    style="color: var(--secondary-text); font-family: var(--font-body); text-align: center;">
                    {!! __('gallery.description') !!}
                </div>

                <textarea name="value" id="valueEdit" rows="15" style="text-align: center;"
                    class="w-full p-4 border rounded shadow-sm focus:ring focus:outline-none hidden  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">{{ old('value', __('gallery.description')) }}</textarea>

                <div id="editButtons" class="flex justify-end gap-4 hidden">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded"
                        style="background: #cbd5e1; color: var(--primary-text);">
                        @switch(App::getLocale())
                        @case('en') Cancel @break
                        @case('sr-Cyrl') Откажи @break
                        @default Otkaži
                        @endswitch
                    </button>

                    <button type="button" id="saveBtn" data-modal-target="submitModal" data-modal-toggle="submitModal"
                        class="py-2 px-4 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                        @switch(App::getLocale())
                        @case('en') Save changes @break
                        @case('sr-Cyrl') Сачувај промене @break
                        @default Sačuvaj promene
                        @endswitch
                    </button>
                </div>
            </div>


            <div class="flex justify-end gap-4">


                <!-- Confirm Submission Modal -->
                <div id="submitModal" tabindex="-1"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full mx-auto">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="p-6 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
                                    style="color: var(--secondary-text);">
                                    @switch(App::getLocale())
                                    @case('en') Are you sure you want to save the changes? @break
                                    @case('sr-Cyrl') Да ли сте сигурни да желите да сачувате измене? @break
                                    @default Da li ste sigurni da želite da sačuvate izmene?
                                    @endswitch
                                </h3>
                                <button id="confirmSubmitBtn" type="button"
                                    class="focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                                    @switch(App::getLocale())
                                    @case('en') Save @break
                                    @case('sr-Cyrl') Сачувај @break
                                    @default Sačuvaj
                                    @endswitch
                                </button>
                                <button data-modal-hide="submitModal" type="button"
                                    class="bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none rounded text-sm font-medium px-5 py-2.5 focus:z-10">
                                    @switch(App::getLocale())
                                    @case('en') Cancel @break
                                    @case('sr-Cyrl') Откажи @break
                                    @default Otkaži
                                    @endswitch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="prose dark:prose-invert max-w-none" style="color: var(--secondary-text); font-family: var(--font-body); text-align: center;">
            {!! nl2br(e(__('gallery.description'))) !!}
        </div>
        @endauth
    </div>

    @auth
    <div class="max-w-xl mx-auto mt-6 mb-10">
        <form id="uploadForm" method="POST" action="{{ route('gallery.upload') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf
            <label for="file" class="block text-base font-medium text-gray-700 dark:text-white mb-2">
                @switch(App::getLocale())
                @case('en') Upload new file @break
                @case('sr-Cyrl') Додај нови фајл @break
                @default Dodaj novi fajl
                @endswitch
            </label>
            <input type="file" name="file" id="file" accept=".jpg, .jpeg, .png, .mp4, .mov, .avi"
                class="w-full text-base text-gray-900 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
            <p class="mb-2  text-sm font-normal text-gray-500 dark:text-gray-400">
                @error('file')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                {{ $message }}
            </p>
            @enderror
            @switch(App::getLocale())
            @case('en')
            Your file can be up to 2 MB.
            @break
            @case('sr-Cyrl')
            Ваш фајл може бити до 2 МБ.
            @break
            @default
            Vaš fajl može biti do 2 MB.
            @endswitch
            </p>
            <div class="mt-4 flex justify-end space-x-2">
                <div id="file-error" class="text-red-600 mt-2 text-sm hidden">
                    @switch(App::getLocale())
                    @case('en') Please select an image or video before submitting. @break
                    @case('sr-Cyrl') Молимо вас да изаберете слику или видео пре слања. @break
                    @default Molimo vas da izaberete sliku ili video pre slanja.
                    @endswitch
                </div>
                <button type="reset"
                    class="bg-gray-500 px-4 py-2 rounded hover:bg-gray-600">
                    @switch(App::getLocale())
                    @case('en') Cancel @break
                    @case('sr-Cyrl') Откажи @break
                    @default Otkaži
                    @endswitch
                </button>
                <button type="submit" id="add-button"
                    class="px-4 py-2 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                    @switch(App::getLocale())
                    @case('en') Add @break
                    @case('sr-Cyrl') Додај @break
                    @default Dodaj
                    @endswitch
                </button>
            </div>
        </form>
        @if(session('error'))
        <div id="errorMessage" class="mb-6 text-red-800 bg-red-100 border border-red-300 p-4 rounded transition-opacity duration-500">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('errorMessage');
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => el.style.display = 'none', 500);
                }
            }, 3000);
        </script>
        @endif

    </div>
    @endauth

    <h2 class="text-2xl font-bold text-center mb-4"
        style="color: var(--secondary-text); font-family: var(--font-body);">
        @switch(App::getLocale())
        @case('en') Photo gallery @break
        @case('sr-Cyrl') Фото галерија @break
        @default Foto galerija
        @endswitch
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-7xl mx-auto mb-12">
        @foreach ($images as $image)
        <div class="relative group">
            <img src="{{ asset('storage/' . $image->path) }}" class="rounded-lg w-full h-48 object-cover transition duration-300 hover:-translate-y-1 hover:scale-105" alt="Image" />
            @auth
            <form method="POST" action="{{ route('gallery.destroy', $image->id) }}" class="absolute top-2 right-2 hidden group-hover:block delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs delete-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
            </form>
            @endauth
        </div>
        @endforeach
    </div>


    <h2 class="text-2xl font-bold text-center mb-4"
        style="color: var(--secondary-text); font-family: var(--font-body);">
        @switch(App::getLocale())
        @case('en') Video gallery @break
        @case('sr-Cyrl') Видео галерија @break
        @default Video galerija
        @endswitch
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto mb-12">
        @foreach ($videos as $video)
        <div class="relative group">
            <video controls class="w-full rounded-lg shadow-md">
                <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">

                @switch(App::getLocale())
                @case('en') Your browser does not support the video tag. @break
                @case('sr-Cyrl') Ваш прегледач не подржава видео ознаку. @break
                @default Vaš pregledač ne podržava video oznaku.
                @endswitch
            </video>
            @auth
            <form method="POST" action="{{ route('gallery.destroy', $video->id) }}" class="absolute top-2 right-2 hidden group-hover:block delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs delete-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
            </form>
            @endauth
        </div>
        @endforeach
    </div>

    <div id="deleteGalleryModal" tabindex="-1" class="fixed inset-0 z-50 hidden flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative rounded-lg shadow" style="background: var(--primary-bg); color: var(--primary-text);">
                <div class="p-6 text-center">
                    <h3 class="mb-5 text-lg font-normal" style="color: var(--secondary-text);">
                        {{ App::getLocale() === 'en' ? 'Are you sure you want to delete this item?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете ову ставку' : 'Da li ste sigurni da želite da obrišete ovu stavku') }}
                    </h3>
                    <button data-modal-hide="deleteGalleryModal" id="confirmDeleteGalleryBtn" type="button" class="bg-red-500 hover:bg-red-600 py-2 px-4 rounded">
                        {{ App::getLocale() === 'en' ? 'Confirm' : (App::getLocale() === 'sr-Cyrl' ? 'Потврди' : 'Potvrdi') }}
                    </button>
                    <button data-modal-hide="deleteGalleryModal" id="cancelDeleteGalleryBtn" type="button" class="px-4 py-2 bg-gray-500 hover:gray-600 rounded">
                        {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div
        id="helpModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button data-modal-hide="helpModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">
                {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
            </h2>
            <p class="text-gray-700 dark:text-gray-300 space-y-2 text-sm leading-relaxed">
                {!! App::getLocale() === 'en'
                ? '
                By clicking the <strong>"Edit"</strong> button, a text area will open allowing you to edit the gallery content.<br><br>
                If you decide not to make changes or want to cancel, click the <strong>"Cancel"</strong> button and the content will revert to its previous state without changes.<br><br>
                To save your edits, click the <strong>"Save"</strong> button.<br>
                You will be asked to confirm before the changes are applied.<br><br>
                If you want to add <strong>images or videos</strong>, use the provided form to upload your file.<br><br>
                You can enter content in English or Serbian (in Cyrillic or Latin script), and it will be translated into the language you have selected.
                The system will automatically recognize the file type and place it into the appropriate section.
                '
                : (App::getLocale() === 'sr-Cyrl'
                ? '
                Кликом на дугме <strong>„Уреди“</strong> отвориће се поље за уређивање текста галерије.<br><br>
                Ако одлучите да не направите промене или желите да откажете, кликните на дугме <strong>„Откажи“</strong> и садржај ће се вратити на претходно стање без измена.<br><br>
                Да бисте сачували измене, кликните на дугме <strong>„Сачувај“</strong>.<br>
                Бићете упитани за потврду пре него што се промене примене.<br><br>
                Ако желите да додате <strong>слику или видео</strong>, користите понуђену форму за отпремање фајла.<br><br>
                Садржај можете унети на енглеском или српском језику (ћирилицом или латиницом), а биће преведен на језик који сте изабрали.
                Систем ће аутоматски препознати тип и сврстати га у одговарајући сегмент.
                '
                : '
                Klikom na dugme <strong>„Uredi“</strong> otvoriće se polje za uređivanje teksta galerije.<br><br>
                Ako odlučite da ne napravite promene ili želite da otkažete, kliknite na dugme <strong>„Otkaži“</strong> i sadržaj će se vratiti na prethodno stanje bez izmena.<br><br>
                Da biste sačuvali izmene, kliknite na dugme <strong>„Sačuvaj“</strong>.<br>
                Bićete upitani za potvrdu pre nego što se promene primene.<br><br>
                Ako želite da dodate <strong>sliku ili video</strong>, koristite ponuđeni formular za otpremanje fajla.<br><br>
                Sadržaj možete uneti na engleskom ili srpskom jeziku (ćirilicom ili latinicom), a biće preveden na jezik koji čitate.
                Sistem će automatski prepoznati tip i svrstati ga u odgovarajući segment.
                '
                )
                !!}
            </p>
        </div>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('uploadForm');
        const fileInput = form.querySelector('input[type="file"]');
        const submitButton = form.querySelector('button[type="submit"]');
        const resetButton = form.querySelector('button[type="reset"]');

        form.addEventListener('submit', (e) => {
            const file = fileInput.files[0];
            const maxFileSize = 2 * 1024 * 1024; // 2MB

            if (file && file.size > maxFileSize) {
                e.preventDefault();
                alert("{{ App::getLocale() === 'en' ? 'Your file exceeds the 2MB limit.' : (App::getLocale() === 'sr-Cyrl' ? 'Ваш фајл прелази дозвољену величину од 2МБ.' : 'Vaš fajl prelazi dozvoljenu veličinu od 2MB.') }}");
                fileInput.value = '';
                return;
            }

            submitButton.disabled = true;
            resetButton.disabled = true;
        });

        resetButton.addEventListener('click', () => {
            submitButton.disabled = false;
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const editBtn = document.getElementById('editBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
        const modal = document.getElementById('submitModal');
        const form = document.getElementById('galleryForm');
        const valueDisplay = document.getElementById('valueDisplay');
        const valueEdit = document.getElementById('valueEdit');
        const editButtons = document.getElementById('editButtons');

        editBtn.addEventListener('click', () => {
            valueDisplay.classList.add('hidden');
            valueEdit.classList.remove('hidden');
            editButtons.classList.remove('hidden');
            editBtn.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            valueEdit.value = valueDisplay.innerText.replace(/\n/g, '\n');
            valueDisplay.classList.remove('hidden');
            valueEdit.classList.add('hidden');
            editButtons.classList.add('hidden');
            editBtn.classList.remove('hidden');
        });

        saveBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        confirmSubmitBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            form.submit();
        });

        document.querySelectorAll('[data-modal-hide="submitModal"]').forEach((el) => {
            el.addEventListener('click', () => {
                modal.classList.add('hidden');

                valueEdit.value = valueDisplay.innerText.replace(/\n/g, '\n');
                valueDisplay.classList.remove('hidden');
                valueEdit.classList.add('hidden');
                editButtons.classList.add('hidden');
                editBtn.classList.remove('hidden');
            });
        });
    });

    document.getElementById('add-button').addEventListener('click', function(e) {
        const fileInput = document.getElementById('file');
        const errorDiv = document.getElementById('file-error');

        if (!fileInput.value) {
            e.preventDefault();
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        let formToDelete = null;

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                formToDelete = e.target.closest('form');
                const deleteModal = document.getElementById('deleteGalleryModal');
                deleteModal.classList.remove('hidden');
            });
        });

        const confirmDeleteBtn = document.getElementById('confirmDeleteGalleryBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteGalleryBtn');
        const deleteModal = document.getElementById('deleteGalleryModal');

        confirmDeleteBtn.addEventListener('click', () => {
            if (formToDelete) {
                formToDelete.submit();
            }
        });

        cancelDeleteBtn.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
            formToDelete = null;
        });
    });
</script>