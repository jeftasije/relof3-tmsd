<x-guest-layout>
    <div class="w-full px-4 py-12 min-h-screen flex justify-center" style="background-color: var(--primary-bg); color: var(--primary-text);">
        <div class="w-full max-w-4xl">
            <div class="flex-col justify-center items-start">
                <div class="relative flex items-center justify-center mb-12">
                    <h1 class="text-4xl font-bold text-center mb-4" style="color: var(--primary-text);">
                        {{ App::getLocale() === 'en' ? 'Organisational structure' : (App::getLocale() === 'sr-Cyrl' ? 'Организациона структура' : 'Organizaciona struktura') }}
                    </h1>
                    @auth
                    <div class="absolute right-0">
                        <button 
                            id="help-btn" 
                            onclick="toggleHelpModal()"
                            class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 hover:bg-[var(--hover-bg)] group"
                            style="color: var(--primary-text);"
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
                    @endauth
                </div>
            </div>
        
            <div class="rounded-lg shadow p-6 space-y-4 max-w-3xl mx-auto" style="background-color: var(--primary-bg); color: var(--primary-text);">
                @if ($structure)
                    <div class="border-b pb-4 flex justify-between items-start" data-struct-id="{{ $structure->id }}">
                        <div>
                            <a 
                                href="{{ asset('storage/' . $structure->file_path) }}" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="text-lg font-semibold hover:underline"
                                style="color: var(--accent);"
                            >
                                {{ $structure->title }}
                            </a>
                            <p class="text-sm mt-1" style="color: var(--secondary-text);">
                                {{ App::getLocale() === 'en' ? 'Updated at: ' : (App::getLocale() === 'sr-Cyrl' ? 'Ажурирано: ' : 'Ažurirano: ') }}{{ $structure->updated_at->format('d.m.Y. H:i') }}
                            </p>
                        </div>
                        @auth
                        <div class="relative">
                            <button 
                                id="dropdownMenuIconButton-{{ $structure->id }}" 
                                data-dropdown-toggle="dropdownDots-{{ $structure->id }}" 
                                class="inline-flex items-center p-2 text-sm font-medium rounded-lg hover:bg-[var(--hover-bg)] focus:ring-4 focus:outline-none"
                                style="color: var(--primary-text); background-color: var(--primary-bg);"
                                type="button"
                            >
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                            </button>
                            <div 
                                id="dropdownDots-{{ $structure->id }}" 
                                class="z-10 hidden divide-y rounded-lg shadow-sm w-36"
                                style="background-color: var(--primary-bg); color: var(--primary-text); border-color: var(--border);"
                            >
                                <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton-{{ $structure->id }}">
                                    <li>
                                        <button 
                                            data-modal-target="renameModal" 
                                            data-modal-toggle="renameModal" 
                                            data-struct-id="{{ $structure->id }}" 
                                            data-struct-title="{{ $structure->title }}" 
                                            class="block w-full text-left px-4 py-2 hover:bg-[var(--hover-bg)]"
                                        >
                                            {{ App::getLocale() === 'en' ? 'Rename' : (App::getLocale() === 'sr-Cyrl' ? 'Преименуј' : 'Preimenuj') }}
                                        </button>
                                    </li>
                                    <li>
                                        <button 
                                            data-modal-target="deleteModal" 
                                            data-modal-toggle="deleteModal" 
                                            data-struct-id="{{ $structure->id }}" 
                                            data-struct-title="{{ $structure->title }}" 
                                            class="block w-full text-left px-4 py-2 hover:bg-[var(--hover-bg)]"
                                            style="color: var(--error);"
                                        >
                                            {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endauth
                    </div>
                @else
                    <p class="text-center" style="color: var(--secondary-text);">
                        {{ App::getLocale() === 'en' ? 'There is currently no available document.' : (App::getLocale() === 'sr-Cyrl' ? 'Тренутно нема доступног документа.' : 'Trenutno nema dostupnog dokumenta.') }}
                    </p>
                @endif

                @auth
                    <form id="uploadForm" class="mb-4 mt-7" enctype="multipart/form-data">
                        <label class="block mb-2 text-sm font-medium" style="color: var(--primary-text);" for="file_input">
                            {{ App::getLocale() === 'en' ? 'Upload a new document' : (App::getLocale() === 'sr-Cyrl' ? 'Постави нови документ' : 'Otpremite novi документ') }}
                        </label>
                        <input 
                            class="block w-full text-sm border rounded-lg cursor-pointer focus:outline-none" 
                            style="background-color: var(--input-bg); color: var(--primary-text); border-color: var(--border);"
                            aria-describedby="file_input_help"
                            id="file_input"
                            name="file"
                            type="file"
                            accept=".pdf,.doc,.docx,.xlsx,.xls"
                            required
                        >
                        <p class="mt-1 text-sm" style="color: var(--secondary-text);" id="file_input_help">
                            {{ App::getLocale() === 'en' ? 'Supported extensions: (.pdf, .doc, .docx, .xlsx) Maximum size: 2 MB' : (App::getLocale() === 'sr-Cyrl' ? 'Подржане екстензије: (.pdf, .doc, .docx, .xlsx) Максимална величина: 2 MB' : 'Podržane ekstenzije: (.pdf, .doc, .docx, .xlsx) Maksimalna veličina: 2 MB') }}
                        </p>
                        <div class="flex items-center mt-2">
                            <button type="submit" class="px-4 py-2 rounded-lg focus:ring-4 focus:outline-none" style="background-color: var(--accent); color: var(--accent-text);">
                                {{ App::getLocale() === 'en' ? 'Upload' : (App::getLocale() === 'sr-Cyrl' ? 'Постави' : 'Objavi') }}
                            </button>
                            <div role="status" class="ml-5">
                                <svg id="spinner" aria-hidden="true" class="hidden w-8 h-8 animate-spin fill-[var(--accent)]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9926 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9926 9.08144 50.5908Z" fill="currentColor" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                </svg>
                                <span class="sr-only">
                                    {{ App::getLocale() === 'en' ? 'Loading...' : (App::getLocale() === 'sr-Cyrl' ? 'Учитавање...' : 'Učitavanje...') }}
                                </span>
                            </div>
                        </div>
                    </form>
                @endauth
            </div>

            <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="p-6 text-center">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ App::getLocale() === 'en' ? 'Are you sure you want to delete?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете?' : 'Da li ste sigurni da želite da obrišete?') }} "<span id="deleteModalTitle"></span>"?
                            </h3>
                            <button data-modal-hide="deleteModal" id="confirmDeleteButton" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                {{ App::getLocale() === 'en' ? 'Confirm' : (App::getLocale() === 'sr-Cyrl' ? 'Потврди' : 'Potvrdi') }}
                            </button>
                            <button data-modal-hide="deleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="p-6">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ App::getLocale() === 'en' ? 'Rename the document' : (App::getLocale() === 'sr-Cyrl' ? 'Преименуј документ' : 'Preimenuj документ') }}
                            </h3>
                            <input 
                                type="text" 
                                id="renameInput" 
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" 
                                placeholder="{{ App::getLocale() === 'en' ? 'Enter a new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}"
                            >
                            <div class="mt-4 text-center">
                                <button data-modal-hide="renameModal" id="confirmRenameButton" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                                <button data-modal-hide="renameModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                                    {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative text-center">
                    <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
                    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                    </h2>
                    <p class="text-gray-700 dark:text-gray-300 space-y-2">
                        {!! App::getLocale() === 'en'
                            ? 'On this page, you can <strong>delete, rename, and upload</strong> a document related to organisational structure. </br></br> If you wish to rename or delete a document, click on <strong>the three dots</strong> next to its name and select the desired option. </br></br> To upload a new document, click on the <strong>"choose file" section</strong> and select the document from your computer.'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'На овој страници можете <strong>обрисати, преименовати и отпремити</strong> документ о организационој структури. </br></br> Уколико желите да преименујете или обришете документ, притисните <strong>3 тачкице</strong> поред његовог назива и одаберите жељену опцију. </br></br> Да отпремите нови документ, кликните на <strong>"секцију "choose file"</strong> и изаберите документ на Вашем рачунару.'
                                : 'Na ovoj stranici možete <strong>obrisati, preimenovati i otpremiti</strong> dokument o organizacionoj strukturi. </br></br> Ukoliko želite da preimenujete ili obrišete dokument, pritisnite <strong>3 tačkice</strong> pored njegovog naziva i odaberite željenu opciju. </br></br> Da otpremite novi dokument, kliknite na <strong>sekciju "choose file"</strong> i izaberite документ на Vašem računaru.') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.toggle('hidden');
        }

        const helpModal = document.getElementById('helpModal');

        if (helpModal) {
            helpModal.addEventListener('click', (event) => {
                if (event.target === helpModal) {
                    toggleHelpModal();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const locale = '{{ App::getLocale() }}'; 
            const deleteModal = document.getElementById('deleteModal');
            const renameModal = document.getElementById('renameModal');
            const deleteModalTitle = document.getElementById('deleteModalTitle');
            const renameInput = document.getElementById('renameInput');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            const confirmRenameButton = document.getElementById('confirmRenameButton');
            let currentStructId = null;

            if (typeof initFlowbite === 'function') {
                initFlowbite();
            }

            document.querySelectorAll('[data-modal-toggle="deleteModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentStructId = button.dataset.structId;
                    if (deleteModalTitle) {
                        deleteModalTitle.textContent = button.dataset.structTitle || '';
                    }
                });
            });

            document.querySelectorAll('[data-modal-toggle="renameModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentStructId = button.dataset.structId;
                    if (renameInput) {
                        renameInput.value = button.dataset.structTitle || '';
                    }
                });
            });

            if (confirmDeleteButton) {
                confirmDeleteButton.addEventListener('click', () => {
                    if (!currentStructId) {
                        alert(locale === 'en' ? 'Document ID is not defined.' : (locale === 'sr-Cyrl' ? 'ID документа није дефинисан.' : 'ID dokumenta nije definisan.'));
                        return;
                    }
                    fetch(`/organizaciona-struktura/${currentStructId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP greška! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.message) {
                            const structElement = document.querySelector(`div[data-struct-id="${currentStructId}"]`);
                            if (structElement) structElement.remove();
                            if (deleteModal) deleteModal.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        alert(locale === 'en' ? 'Error deleting the document: ' + error.message : (locale === 'sr-Cyrl' ? 'Грешка при брисању документа: ' + error.message : 'Greška prilikom brisanja dokumenta: ' + error.message));
                    });
                });
            }

            if (confirmRenameButton) {
                confirmRenameButton.addEventListener('click', () => {
                    if (!currentStructId) {
                        alert(locale === 'en' ? 'Document ID is not defined.' : (locale === 'sr-Cyrl' ? 'ID документа није дефинисан.' : 'ID dokumenta nije definisan.'));
                        return;
                    }
                    const newTitle = renameInput ? renameInput.value.trim() : '';
                    if (!newTitle) {
                        alert(locale === 'en' ? 'Please enter the document name.' : (locale === 'sr-Cyrl' ? 'Унесите назив документа.' : 'Molimo unesite naziv dokumenta.'));
                        return;
                    }

                    fetch(`/organizaciona-struktura/${currentStructId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ title: newTitle })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP greška! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.message) {
                            const structLink = document.querySelector(`div[data-struct-id="${currentStructId}"] a`);
                            if (structLink) {
                                structLink.textContent = data.title;
                            }
                            const renameButton = document.querySelector(`button[data-struct-id="${currentStructId}"][data-modal-target="renameModal"]`);
                            const deleteButton = document.querySelector(`button[data-struct-id="${currentStructId}"][data-modal-target="deleteModal"]`);
                            if (renameButton) renameButton.dataset.structTitle = data.title;
                            if (deleteButton) deleteButton.dataset.structTitle = data.title;
                            if (renameModal) renameModal.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        alert(locale === 'en' ? 'Error renaming the document: ' + error.message : (locale === 'sr-Cyrl' ? 'Грешка при преименовању документа: ' + error.message : 'Greška prilikom preimenovanja dokumenta: ' + error.message));
                    });
                });
            }

            const uploadForm = document.getElementById('uploadForm');
            if (uploadForm) {
                uploadForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(uploadForm);
                    const submitButton = uploadForm.querySelector('button[type="submit"]');
                    submitButton.disabled = true;

                    const spinner = document.getElementById('spinner');
                    if (spinner) spinner.classList.remove('hidden');

                    const fileInput = document.querySelector('input[type="file"]');
                    const fileSize = fileInput.files[0].size;

                    const maxFileSize = 2048 * 1024;
                    if (fileSize > maxFileSize) {
                        alert(locale === 'en' ? 'Your file exceeds the maximum supported size of 2MB.' : (locale === 'sr-Cyrl' ? 'Ваш фајл прелази максималну дозвољену величину од 2MB.' : 'Vaš fajl prelazi maksimalnu podržanu veličinu od 2MB.'));
                        fileInput.value = '';
                        submitButton.disabled = false;
                        if (spinner) spinner.classList.add('hidden');
                        return;
                    }

                    fetch(`{{ route('organisationalStructures.store') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP greška! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.message) {
                            if (spinner) spinner.classList.add('hidden');
                            window.location.reload();
                        } else {
                            alert(locale === 'en' ? 'An error occurred: ' + (data.message || 'Unknown error') : (locale === 'sr-Cyrl' ? 'Дошло је до грешке: ' + (data.message || 'Непозната грешка') : 'Došlo je do greške: ' + (data.message || 'Nepoznata greška')));
                            submitButton.disabled = false;
                            if (spinner) spinner.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Upload greška:', error);
                        alert(locale === 'en' ? 'Error uploading the document: ' + error.message : (locale === 'sr-Cyrl' ? 'Грешка при отпремању документа: ' + error.message : 'Greška prilikom učitavanja dokumenta: ' + error.message));
                        submitButton.disabled = false;
                        if (spinner) spinner.classList.add('hidden');
                    });
                });
            }
        });
    </script>
</x-guest-layout>