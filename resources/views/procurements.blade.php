<x-guest-layout>
    <div
        class="w-full px-4 py-12 min-h-screen flex justify-center"
        style="background: var(--primary-bg); color: var(--primary-text);"
    >
        <div class="w-full max-w-4xl">
            <div class="flex-col justify-center items-start">
                <div class="relative flex items-center justify-center mb-12">
                    <h1
                        class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full"
                        style="color: var(--primary-text);"
                    >
                        {{ App::getLocale() === 'en'
                            ? 'Public procurements'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Јавне набавке'
                                : 'Javne nabavke') }}
                    </h1>
                    @auth
                        <div class="absolute right-0">
                            <button
                                id="help-btn"
                                onclick="toggleHelpModal()"
                                class="flex items-center p-2 text-base font-medium transition duration-150 ease-in-out
                                rounded-xl border-2 border-[var(--secondary-text)] hover:border-[var(--primary-bg)] shadow-md
                                bg-[var(--primary-bg)] hover:bg-gray-100 dark:hover:bg-gray-800"
                                style="color: var(--primary-text);"
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
                    @endauth
                </div>
                <div class="my-10 flex justify-center items-center">
                    <div class="relative w-full max-w-md">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="{{ App::getLocale() === 'en'
                                ? 'Search document...'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Претражи документ...'
                                    : 'Pretraži dokument...') }}"
                            class="w-full px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                        >
                        <div id="searchDropdown" class="absolute z-10 w-full rounded-lg mt-1 hidden"
                            style="background: var(--primary-bg); color: var(--primary-text); border: 1px solid var(--secondary-text);">
                            <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>
                    <select
                        id="globalSort"
                        class="ml-3 rounded p-2 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                    >
                        <option value="title_asc">A-Z</option>
                        <option value="title_desc">Z-A</option>
                        <option value="date_desc">
                            {{ App::getLocale() === 'en'
                                ? 'Newest first'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Новије прво'
                                    : 'Novije prvo') }}
                        </option>
                        <option value="date_asc">
                            {{ App::getLocale() === 'en'
                                ? 'Oldest first'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Старије прво'
                                    : 'Starije prvo') }}
                        </option>
                    </select>
                </div>
            </div>

            <div
                id="procurementsList"
                class="rounded-lg shadow p-6 space-y-6"
                style="background: var(--primary-bg); color: var(--primary-text);"
            >
                @forelse ($procurements as $procurement)
                    <div
                        class="border-b pb-4 flex justify-between items-start"
                        data-proc-id="{{ $procurement->id }}"
                        data-updated="{{ $procurement->updated_at }}"
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
                                            class="block w-full text-left px-4 py-2 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
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
                                            class="block w-full text-left px-4 py-2 text-red-500 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
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
                    <p id="emptyMessage" style="color: var(--secondary-text);">
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
                        class="block w-full text-sm rounded-lg cursor-pointer bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                        id="file_input"
                        name="file"
                        type="file"
                        accept=".pdf,.doc,.docx,.xlsx,.xls"
                        required
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
                            class="px-4 py-2 rounded-lg bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]"
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
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
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
                                id="confirmDeleteButtonProc"
                                type="button"
                                class="bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
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
                                class="focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg borde text-sm font-medium px-5 py-2.5 hover:bg-gray-500  bg-gray-400"
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
                                class="w-full p-2 rounded-lg focus:outline-none focus:ring-2 bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                                placeholder="{{ App::getLocale() === 'en'
                                    ? 'Enter a new name'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Унесите нови назив'
                                        : 'Unesite novi naziv') }}"
                            >
                            <div class="mt-4 text-center">
                                <button
                                    data-modal-hide="renameModal"
                                    id="confirmRenameButton"
                                    type="button"
                                    class="focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]"
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
                                    class="focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg borde text-sm font-medium px-5 py-2.5 hover:bg-gray-500  bg-gray-400">
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

            <div
                id="helpModal"
                class="fixed inset-0 z-50 hidden flex items-center justify-center"
                style="background: rgba(0,0,0,0.5);"
            >
                <div class="relative w-full max-w-md p-6 rounded-lg shadow-lg"
                     style="background: var(--primary-bg); color: var(--primary-text);">
                    <button
                        onclick="toggleHelpModal()"
                        class="absolute top-2 right-2 text-2xl font-bold text-gray-500 hover:text-red-500"
                    >×</button>
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
            const locale = '{{ App::getLocale() }}';
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchResults = document.getElementById('searchResults');
            const globalSort = document.getElementById('globalSort');
            const procurementsList = document.getElementById('procurementsList');
            const deleteModal = document.getElementById('deleteModal');
            const renameModal = document.getElementById('renameModal');
            const deleteModalTitle = document.getElementById('deleteModalTitle');
            const renameInput = document.getElementById('renameInput');
            const confirmDeleteButton = document.getElementById('confirmDeleteButtonProc');
            const confirmRenameButton = document.getElementById('confirmRenameButton');
            let selectedIndex = -1;
            let currentProcId = null;

            if (typeof initFlowbite === 'function') {
                initFlowbite();
            }

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                searchResults.innerHTML = '';
                searchDropdown.classList.toggle('hidden', !query);
                selectedIndex = -1;

                if (query) {
                    const allProcurements = Array.from(document.querySelectorAll('div[data-proc-id]'));
                    const matchingProcs = allProcurements.filter(proc => 
                        proc.querySelector('a').textContent.toLowerCase().includes(query)
                    );

                    matchingProcs.forEach(proc => {
                        const li = document.createElement('li');
                        li.className = 'p-2 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)] cursor-pointer';
                        li.textContent = proc.querySelector('a').textContent;
                        li.dataset.procId = proc.dataset.procId;
                        li.addEventListener('click', () => {
                            const targetProc = document.querySelector(`div[data-proc-id="${proc.dataset.procId}"]`);
                            if (targetProc) {
                                const link = targetProc.querySelector('a');
                                if (link && link.href) {
                                    window.open(link.href, '_blank'); 
                                }
                                searchDropdown.classList.add('hidden');
                                searchInput.value = '';
                                selectedIndex = -1;
                            }
                        });

                        searchResults.appendChild(li);
                    });
                }
            });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target) && 
                    !e.target.closest('[data-dropdown-toggle]') && !e.target.closest('[data-modal-toggle]')) {
                    searchDropdown.classList.add('hidden');
                    selectedIndex = -1;
                }
            });

            function applySort(sortType) {
                const items = Array.from(procurementsList.querySelectorAll('div[data-proc-id]'));
                const emptyMessage = document.getElementById('emptyMessage');

                items.forEach(item => item.remove());

                items.sort((a, b) => {
                    const linkA = a.querySelector('a');
                    const linkB = b.querySelector('a');
                    if (!linkA || !linkB) return 0;

                    const titleA = linkA.textContent.trim().toLowerCase();
                    const titleB = linkB.textContent.trim().toLowerCase();
                    const dateA = new Date(a.getAttribute('data-updated'));
                    const dateB = new Date(b.getAttribute('data-updated'));

                    switch (sortType) {
                        case 'title_asc':
                            return titleA.localeCompare(titleB);
                        case 'title_desc':
                            return titleB.localeCompare(titleA);
                        case 'date_asc':
                            return dateB - dateA;
                        case 'date_desc':
                            return dateA - dateB;
                        default:
                            return 0;
                    }
                });

                const uploadForm = procurementsList.querySelector('#uploadForm');
                items.forEach(item => procurementsList.insertBefore(item, uploadForm || procurementsList.lastChild));

                if (emptyMessage) {
                    emptyMessage.style.display = items.length === 0 ? 'block' : 'none';
                }
            }

            globalSort.addEventListener('change', (e) => {
                applySort(e.target.value);
            });

            applySort(globalSort.value);

            document.querySelectorAll('[data-modal-toggle="deleteModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentProcId = button.dataset.procId;
                    deleteModalTitle.textContent = button.dataset.procTitle;
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

                        const items = procurementsList.querySelectorAll('div[data-proc-id]');
                        const emptyMessage = document.getElementById('emptyMessage');
                        if (emptyMessage) {
                            emptyMessage.style.display = items.length === 0 ? 'block' : 'none';
                        }
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

            document.querySelectorAll('[data-modal-toggle="renameModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentProcId = button.dataset.procId;
                    renameInput.value = button.dataset.procTitle;
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
                        applySort(globalSort.value);
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
                            window.location.href = `{{ route('procurements.index') }}`;
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