<x-guest-layout>
    <div class="w-full px-4 py-12 min-h-screen"
         style="background: var(--primary-bg); color: var(--primary-text);">
        <h1 class="text-4xl font-bold text-center mb-12"
            style="color: var(--primary-text);">
            {{ App::getLocale() === 'en' ? 'Organisational structure' : (App::getLocale() === 'sr-Cyrl' ? 'Организациона структура' : 'Organizaciona struktura') }}
        </h1>

        <div class="rounded-lg shadow p-6 space-y-4 max-w-3xl mx-auto"
             style="background: var(--primary-bg); color: var(--primary-text);">
            @if ($structure)
                <div class="border-b pb-4 flex justify-between items-center w-full"
                     data-struct-id="{{ $structure->id }}"
                     style="border-color: var(--secondary-text);">
                    <a
                        href="{{ asset('storage/' . $structure->file_path) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-lg font-semibold hover:underline"
                        style="color: var(--accent);"
                    >
                        {{ $structure->title }}
                    </a>
                    @auth
                    <div class="relative">
                        <button
                            id="dropdownMenuIconButton-{{ $structure->id }}"
                            data-dropdown-toggle="dropdownDots-{{ $structure->id }}"
                            class="inline-flex items-center p-2 text-sm font-medium text-center rounded-lg focus:ring-4 focus:outline-none"
                            style="color: var(--primary-text); background: var(--primary-bg);"
                            type="button"
                        >
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                        <div
                            id="dropdownDots-{{ $structure->id }}"
                            class="z-10 hidden divide-y rounded-lg shadow-sm w-36"
                            style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);"
                        >
                            <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton-{{ $structure->id }}">
                                <li>
                                    <button
                                        data-modal-target="renameModal"
                                        data-modal-toggle="renameModal"
                                        data-struct-id="{{ $structure->id }}"
                                        data-struct-title="{{ $structure->title }}"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                                        style="color: var(--primary-text); background: var(--primary-bg);"
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
                                        class="block w-full text-left px-4 py-2"
                                        style="color: var(--accent); background: var(--primary-bg);"
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
                <p class="text-center"
                   style="color: var(--secondary-text);">
                    {{ App::getLocale() === 'en' ? 'There is currently no available document.' : (App::getLocale() === 'sr-Cyrl' ? 'Тренутно нема доступног документа.' : 'Trenutno nema dostupnog dokumenta.') }}
                </p>
            @endif

            @auth
                <form id="uploadForm" class="mb-4 mt-7" enctype="multipart/form-data">
                    <label class="block mb-2 text-sm font-medium" for="file_input"
                           style="color: var(--primary-text);">
                        {{ App::getLocale() === 'en' ? 'Upload a new document' : (App::getLocale() === 'sr-Cyrl' ? 'Постави нови документ' : 'Otpremite novi dokument') }}
                    </label>
                    <input class="block w-full text-sm border rounded-lg cursor-pointer"
                        aria-describedby="file_input_help"
                        id="file_input"
                        name="file"
                        type="file"
                        accept=".pdf,.doc,.docx,.xlsx,.xls"
                        required
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                    <p class="mt-1 text-sm"
                       id="file_input_help"
                       style="color: var(--secondary-text);">
                        {{ App::getLocale() === 'en' ? 'Supported extensions: (.pdf, .doc, .docx, .xlsx) Maximum size: 2 MB' : (App::getLocale() === 'sr-Cyrl' ? 'Подржане екстензије: (.pdf, .doc, .docx, .xlsx) Максимална величина: 2 MB' : 'Podržane ekstenzije: (.pdf, .doc, .docx, .xlsx) Maksimalna veličina: 2 MB') }}
                    </p>
                    <div class="flex items-center mt-2">
                        <button type="submit"
                                class="px-4 py-2 rounded-lg"
                                style="background: var(--accent); color: #fff;">
                            {{ App::getLocale() === 'en' ? 'Upload' : (App::getLocale() === 'sr-Cyrl' ? 'Постави' : 'Objavi') }}
                        </button>
                        <div role="status" class="ml-5">
                            <svg id="spinner" aria-hidden="true" class="hidden w-8 h-8 animate-spin" style="color: var(--secondary-text); fill: var(--accent);" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
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
                <div class="relative rounded-lg shadow"
                     style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en' ? 'Are you sure you want to delete?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете?' : 'Da li ste sigurni da želite da obrišete?') }} "<span id="deleteModalTitle"></span>"?
                        </h3>
                        <button
                            data-modal-hide="deleteModal"
                            id="confirmDeleteButton"
                            type="button"
                            class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            style="background: var(--accent); color: #fff;">
                            {{ App::getLocale() === 'en' ? 'Confirm' : (App::getLocale() === 'sr-Cyrl' ? 'Потврди' : 'Potvrdi') }}
                        </button>
                        <button
                            data-modal-hide="deleteModal"
                            type="button"
                            class="text-sm font-medium px-5 py-2.5 rounded-lg border"
                            style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);">
                            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                     style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en' ? 'Rename the document' : (App::getLocale() === 'sr-Cyrl' ? 'Преименуј документ' : 'Preimenuj dokument') }}
                        </h3>
                        <input
                            type="text"
                            id="renameInput"
                            class="w-full p-2 border rounded-lg focus:outline-none"
                            placeholder="{{ App::getLocale() === 'en' ? 'Enter a new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}"
                            style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);"
                        >
                        <div class="mt-4 text-center">
                            <button
                                data-modal-hide="renameModal"
                                id="confirmRenameButton"
                                type="button"
                                class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                                style="background: var(--accent); color: #fff;">
                                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                            </button>
                            <button
                                data-modal-hide="renameModal"
                                type="button"
                                class="text-sm font-medium px-5 py-2.5 rounded-lg border"
                                style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);">
                                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
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
