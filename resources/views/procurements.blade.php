<x-guest-layout>
    <div
        class="w-full px-4 py-12 min-h-screen flex justify-center"
        style="background: var(--primary-bg); color: var(--primary-text);"
    >
        <div class="w-full max-w-4xl">
            <div class="flex-col justify-center items-start">
                <div class="relative flex items-center justify-center mb-12">
                    <h1
                        class="text-4xl font-bold text-center"
                        style="color: var(--primary-text);"
                    >
                        {{ App::getLocale() === 'en'
                            ? 'Public procurements'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Јавне набавке'
                                : 'Javne nabavke') }}
                    </h1>
                    <div class="absolute right-0">
                        <button
                            id="help-btn"
                            onclick="toggleHelpModal()"
                            class="flex items-center p-2 text-base font-normal rounded-lg transition duration-75 group"
                            style="color: var(--primary-text); background: var(--primary-bg);"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 17l0 .01" />
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                            </svg>
                            <span class="ml-3">
                                {{ App::getLocale() === 'en'
                                    ? 'Help'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Помоћ'
                                        : 'Pomoć') }}
                            </span>
                        </button>
                    </div>
                </div>
                <div class="my-10 flex justify-center">
                    <form action="{{ route('procurements.index') }}" method="GET">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ App::getLocale() === 'en'
                                ? 'Search document...'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Претражи документ...'
                                    : 'Pretraži dokument...') }}"
                            class="flex-grow px-4 py-2 mr-3 rounded-lg shadow-sm focus:outline-none focus:ring-2"
                            style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                        >
                        <select
                            name="sort"
                            class="rounded p-2"
                            style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                        >
                            <option
                                value="asc"
                                {{ (request('sort', $sort ?? '') === 'asc') ? 'selected' : '' }}
                            >
                                {{ App::getLocale() === 'en'
                                    ? 'Oldest first'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Први старији'
                                        : 'Prvi stariji') }}
                            </option>
                            <option
                                value="desc"
                                {{ (request('sort', $sort ?? '') === 'desc') ? 'selected' : '' }}
                            >
                                {{ App::getLocale() === 'en'
                                    ? 'Newest first'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Први новији'
                                        : 'Prvi noviji') }}
                            </option>
                        </select>
                        <button
                            type="submit"
                            class="px-6 py-2 ml-3 font-semibold rounded-lg transition"
                            style="background: var(--accent); color: #fff;"
                        >
                            {{ App::getLocale() === 'en'
                                ? 'Search'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Претражи'
                                    : 'Pretraži') }}
                        </button>
                    </form>
                </div>
            </div>

            <div
                class="rounded-lg shadow p-6 space-y-6"
                style="background: var(--primary-bg); color: var(--primary-text);"
            >
                @forelse ($procurements as $procurement)
                    <div
                        class="border-b pb-4 flex justify-between items-start"
                        data-proc-id="{{ $procurement->id }}"
                        style="border-color: var(--secondary-text);"
                    >
                        <div>
                            <a
                                href="{{ asset('storage/' . $procurement->file_path) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-lg font-semibold hover:underline"
                                style="color: var(--accent);"
                            >
                                {{ $procurement->title }}
                            </a>
                            <p
                                class="text-sm mt-1"
                                style="color: var(--secondary-text);"
                            >
                                {{ App::getLocale() === 'en'
                                    ? 'Updated at: '
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Ажурирано: '
                                        : 'Ažurirano: ')
                                }}{{ $procurement->updated_at->format('d.m.Y. H:i') }}
                            </p>
                        </div>
                        @auth
                        <div class="relative">
                            <button
                                id="dropdownMenuIconButton-{{ $procurement->id }}"
                                data-dropdown-toggle="dropdownDots-{{ $procurement->id }}"
                                class="inline-flex items-center p-2 text-sm font-medium rounded-lg focus:ring-4 focus:outline-none"
                                style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                                type="button"
                            >
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                            </button>
                            <div
                                id="dropdownDots-{{ $procurement->id }}"
                                class="z-10 hidden rounded-lg shadow-sm w-36"
                                style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                            >
                                <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton-{{ $procurement->id }}">
                                    <li>
                                        <button
                                            data-modal-target="renameModal"
                                            data-modal-toggle="renameModal"
                                            data-proc-id="{{ $procurement->id }}"
                                            data-proc-title="{{ $procurement->title }}"
                                            class="block w-full text-left px-4 py-2"
                                            style="background: var(--primary-bg); color: var(--primary-text);"
                                        >
                                            {{ App::getLocale() === 'en' ? 'Rename'
                                                : (App::getLocale() === 'sr-Cyrl'
                                                    ? 'Преименуј'
                                                    : 'Preimenuj') }}
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            data-modal-target="deleteModal"
                                            data-modal-toggle="deleteModal"
                                            data-proc-id="{{ $procurement->id }}"
                                            data-proc-title="{{ $procurement->title }}"
                                            class="block w-full text-left px-4 py-2"
                                            style="background: var(--primary-bg); color: var(--accent);"
                                        >
                                            {{ App::getLocale() === 'en' ? 'Delete'
                                                : (App::getLocale() === 'sr-Cyrl'
                                                    ? 'Обриши'
                                                    : 'Obriši') }}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endauth
                    </div>
                @empty
                    <p style="color: var(--secondary-text);">
                        {{ App::getLocale() === 'en'
                            ? 'There is currently no available document.'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Тренутно нема доступног документа.'
                                : 'Trenutno nema dostupnog dokumenta.') }}
                    </p>
                @endforelse

                @auth
                <form id="uploadForm" class="mb-4 mt-7" enctype="multipart/form-data">
                    <label
                        class="block mb-2 text-sm font-medium"
                        for="file_input"
                        style="color: var(--primary-text);"
                    >
                        {{ App::getLocale() === 'en'
                            ? 'Upload new file.'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Постави нови документ.'
                                : 'Otpremite novi dokument.') }}
                    </label>
                    <input
                        class="block w-full text-sm rounded-lg cursor-pointer"
                        id="file_input"
                        name="file"
                        type="file"
                        accept=".pdf,.doc,.docx,.xlsx,.xls"
                        required
                        style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                    >
                    <p
                        class="mt-1 text-sm"
                        id="file_input_help"
                        style="color: var(--secondary-text);"
                    >
                        {{ App::getLocale() === 'en'
                            ? 'Supported extensions: (.pdf, .doc, .docx, .xlsx) Maximum size: 2 MB'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Подржане екстензије: (.pdf, .doc, .docx, .xlsx) Максимална величина: 2 MB'
                                : 'Podržane ekstenzije: (.pdf, .doc, .docx, .xlsx) Maksimalna veličina: 2 MB') }}
                    </p>
                    <div class="flex items-center mt-2">
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg"
                            style="background: var(--accent); color: #fff;"
                        >
                            {{ App::getLocale() === 'en'
                                ? 'Upload'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Постави'
                                    : 'Otpremi') }}
                        </button>
                        <div role="status" class="ml-5">
                            <svg
                                id="spinner"
                                aria-hidden="true"
                                class="hidden w-8 h-8 animate-spin"
                                style="color: var(--secondary-text); fill: var(--accent);"
                                viewBox="0 0 100 101"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591…Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393…Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only">
                                {{ App::getLocale() === 'en'
                                    ? 'Loading…'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Учитавање…'
                                        : 'Učitavanje…') }}
                            </span>
                        </div>
                    </div>
                </form>
                @endauth
            </div>

            {{-- Delete Modal --}}
            <div
                id="deleteModal"
                tabindex="-1"
                class="fixed inset-0 z-50 hidden overflow-auto p-4"
            >
                <div class="relative w-full max-w-md mx-auto my-20">
                    <div class="rounded-lg shadow"
                         style="background: var(--primary-bg); color: var(--primary-text);">
                        <div class="p-6 text-center">
                            <h3 class="mb-5 text-lg font-normal" style="color: var(--secondary-text);">
                                {{ App::getLocale() === 'en'
                                    ? 'Are you sure you want to delete?'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Да ли сте сигурни да желите да обришете?'
                                        : 'Da li ste sigurni da želite da obrišete?') }}
                                "<span id="deleteModalTitle"></span>"?
                            </h3>
                            <button
                                data-modal-hide="deleteModal"
                                id="confirmDeleteButton"
                                type="button"
                                class="px-5 py-2.5 rounded-lg font-medium"
                                style="background: var(--accent); color: #fff;"
                            >
                                {{ App::getLocale() === 'en'
                                    ? 'Confirm'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Потврди'
                                        : 'Potvrdi') }}
                            </button>
                            <button
                                data-modal-hide="deleteModal"
                                type="button"
                                class="px-5 py-2.5 ml-2 rounded-lg border"
                                style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);"
                            >
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

            {{-- Rename Modal --}}
            <div
                id="renameModal"
                tabindex="-1"
                class="fixed inset-0 z-50 hidden overflow-auto p-4"
            >
                <div class="relative w-full max-w-md mx-auto my-20">
                    <div class="rounded-lg shadow"
                         style="background: var(--primary-bg); color: var(--primary-text);">
                        <div class="p-6">
                            <h3 class="mb-5 text-lg font-normal" style="color: var(--secondary-text);">
                                {{ App::getLocale() === 'en'
                                    ? 'Rename the document'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Преименуј документ'
                                        : 'Preimenuj dokument') }}
                            </h3>
                            <input
                                type="text"
                                id="renameInput"
                                class="w-full p-2 rounded-lg focus:outline-none focus:ring-2"
                                placeholder="{{ App::getLocale() === 'en'
                                    ? 'Enter a new name'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Унесите нови назив'
                                        : 'Unesite novi naziv') }}"
                                style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);"
                            >
                            <div class="mt-4 text-center">
                                <button
                                    data-modal-hide="renameModal"
                                    id="confirmRenameButton"
                                    type="button"
                                    class="px-5 py-2.5 rounded-lg font-medium"
                                    style="background: var(--accent); color: #fff;"
                                >
                                    {{ App::getLocale() === 'en'
                                        ? 'Save'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Сачувај'
                                            : 'Sačuvaj') }}
                                </button>
                                <button
                                    data-modal-hide="renameModal"
                                    type="button"
                                    class="px-5 py-2.5 ml-2 rounded-lg border"
                                    style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);"
                                >
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

        </div>
    </div>

    {{-- Help Modal --}}
    <div
        id="helpModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center"
        style="background: rgba(0,0,0,0.5);"
    >
        <div class="relative w-full max-w-md p-6 rounded-lg shadow-lg"
             style="background: var(--primary-bg); color: var(--primary-text);">
            <button
                onclick="toggleHelpModal()"
                class="absolute top-2 right-2 text-2xl font-bold"
                style="color: var(--secondary-text);"
            >&times;</button>
            <h2 class="mb-4 text-xl font-bold text-center"
                style="color: var(--primary-text);"
            >
                {{ App::getLocale() === 'en'
                    ? 'Help'
                    : (App::getLocale() === 'sr-Cyrl'
                        ? 'Помоћ'
                        : 'Pomoć') }}
            </h2>
            <p class="space-y-2 text-center"
               style="color: var(--secondary-text);">
                {!! App::getLocale() === 'en'
                    ? 'On this page, you can <strong>delete, rename, and upload</strong> a document related to public procurement.<br><br>If you wish to rename or delete a document, click on <strong>the three dots</strong> next to its name and select the desired option.<br><br>To upload a new document, click on the <strong>"choose file" section</strong> and select the document from your computer.'
                    : (App::getLocale() === 'sr-Cyrl'
                        ? 'На овој страници можете <strong>обрисати, преименовати и отпремити</strong> документ о јавним набавкама.<br><br>Уколико желите да преименујете или обришете документ, притисните <strong>3 тачкице</strong> поред његовог назива и одаберите жељену опцију.<br><br>Да отпремите нови документ, кликните на <strong>секцију "choose file"</strong> и изаберите документ на Вашем рачунару.'
                        : 'Na ovoj stranici možete <strong>obrisati, preimenovati i otpremiti</strong> dokument o javnim nabavkama.<br><br>Ukoliko želite da preimenujete ili obrišete dokument, pritisnite <strong>3 tačkice</strong> pored njegovog naziva i odaberite željenu opciju.<br><br>Da otpremite novi dokument, kliknite na <strong>sekciju "choose file"</strong> i izaberite dokument na Vašem računaru.') !!}
            </p>
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
            let currentProcId = null;

            if (typeof initFlowbite === 'function') {
                initFlowbite();
            }

            document.querySelectorAll('[data-modal-toggle="deleteModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentProcId = button.dataset.procId;
                    deleteModalTitle.textContent = button.dataset.procTitle;
                });
            });

            document.querySelectorAll('[data-modal-toggle="renameModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentProcId = button.dataset.procId;
                    renameInput.value = button.dataset.procTitle;
                });
            });

            confirmDeleteButton.addEventListener('click', () => {
                fetch(`/nabavke/${currentProcId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP err! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        const procElement = document.querySelector(`div[data-proc-id="${currentProcId}"]`);
                        if (procElement) procElement.remove();
                        deleteModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    alert(
                        locale === 'en'
                        ? 'Error deleting the document: ' + error.message
                        : (locale === 'sr-Cyrl'
                            ? 'Грешка при брисању документа: ' + error.message
                            : 'Greška prilikom brisanja dokumenta: ' + error.message
                        )
                    );
                });
            });

            confirmRenameButton.addEventListener('click', () => {
                const newTitle = renameInput.value.trim();
                if (!newTitle) {
                    alert(
                        locale === 'en'
                        ? 'Please enter the document name.'
                        : (locale === 'sr-Cyrl'
                            ? 'Унесите назив документа.'
                            : 'Molimo unesite naziv dokumenta.'
                        )
                    );
                    return;
                }

                fetch(`/nabavke/${currentProcId}`, {
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
                        throw new Error(`HTTP err! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        const procLink = document.querySelector(`div[data-proc-id="${currentProcId}"] a`);
                        if (procLink) {
                            procLink.textContent = data.title;
                            const renameButton = document.querySelector(`button[data-proc-id="${currentProcId}"][data-modal-target="renameModal"]`);
                            const deleteButton = document.querySelector(`button[data-proc-id="${currentProcId}"][data-modal-target="deleteModal"]`);
                            if (renameButton) renameButton.dataset.procTitle = data.title;
                            if (deleteButton) deleteButton.dataset.procTitle = data.title;
                        }
                        renameModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    alert(
                        locale === 'en'
                        ? 'Error renaming the document: ' + error.message
                        : (locale === 'sr-Cyrl'
                            ? 'Грешка при преименовању документа: ' + error.message
                            : 'Greška prilikom preimenovanja dokumenta: ' + error.message
                        )
                    );
                });
            });

            const uploadForm = document.getElementById('uploadForm');
            if (uploadForm) {
                uploadForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(uploadForm);
                    const submitButton = uploadForm.querySelector('button[type="submit"]');
                    submitButton.disabled = true;

                    const spinner = document.getElementById('spinner');
                    spinner.classList.remove('hidden');

                    const fileInput = uploadForm.querySelector('input[type="file"]');
                    const fileSize = fileInput.files[0].size;

                    const maxFileSize = 2048 * 1024;
                    if (fileSize > maxFileSize) {
                        alert(
                            locale === 'en'
                            ? 'Your file exceeds the maximum supported size of 2MB.'
                            : (locale === 'sr-Cyrl'
                                ? 'Ваш фајл прелази максималну подржану величину од 2MB.'
                                : 'Vaš fajl prelazi maksimalnu podržanu veličinu od 2MB.'
                            )
                        );
                        fileInput.value = '';
                        submitButton.disabled = false;
                        spinner.classList.add('hidden');
                        return;
                    }

                    fetch(`{{ route('procurements.store') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP err! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.message) {
                            spinner.classList.add('hidden');
                            window.location.reload();
                        } else {
                            alert(
                                locale === 'en'
                                ? 'An error occurred: ' + (data.message || 'Unknown error')
                                : (locale === 'sr-Cyrl'
                                    ? 'Дошло је до грешке: ' + (data.message || 'Непозната грешка')
                                    : 'Došlo je do greške: ' + (data.message || 'Nepoznata greška')
                                )
                            );
                            submitButton.disabled = false;
                            spinner.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        alert(
                            locale === 'en'
                            ? 'Error uploading the document: ' + error.message
                            : (locale === 'sr-Cyrl'
                                ? 'Грешка при учитавању документа: ' + error.message
                                : 'Greška prilikom učitavanja dokumenta: ' + error.message
                            )
                        );
                        submitButton.disabled = false;
                        spinner.classList.add('hidden');
                    });
                });
            }
        });
    </script>
</x-guest-layout>