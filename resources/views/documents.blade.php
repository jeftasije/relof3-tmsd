<x-guest-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full mb-5" style="color: var(--primary-text);">
                @switch(App::getLocale())
                @case('en') Documents @break
                @case('sr-Cyrl') Документa @break
                @default Dokumenta
                @endswitch
            </h1>
            <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto"
                style="color: var(--secondary-text); font-family: var(--font-body);">
                @switch(App::getLocale())
                @case('en') This page contains the institution’s official documents – regulations, decisions, reports, and other public records available for viewing and download @break
                @case('sr-Cyrl') На овој страници налазе се званична документа установе – правилници, одлуке, извештаји и друга акта од јавног значаја доступни за преглед и преузимање @break
                @default Na ovoj stranici nalaze se zvanična dokumenta ustanove – pravilnici, odluke, izveštaji i druga akta od javnog značaja dostupni za pregled i preuzimanje
                @endswitch
            </p>
        </div>
        <div class="relative mb-24 mt-5" style="color: var(--secondary-text);">
            <label for="searchInput">
                @switch(App::getLocale())
                @case('en') Search documents @break
                @case('sr-Cyrl') Претражи документa @break
                @default Pretraži dokumenta
                @endswitch
            </label>
            <input type="text" id="searchInput" placeholder="{{ App::getLocale() === 'en'
                ? 'Enter title'
                : (App::getLocale() === 'sr-Cyrl'
                    ? 'Унесите назив документа'
                    : 'Unesite naziv dokumenta') }}"
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--primary-text); border-color: var(--secondary-text);">
            <div id="searchDropdown" class="absolute z-10 w-full rounded-lg mt-1 hidden bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--secondary-text); border: 1px solid var(--secondary-text);">
                <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
            </div>
        </div>

        <div class="mb-4 flex justify-start items-center">
            <label for="globalSort" class="mr-2 text-sm" style="color: var(--secondary-text);">
                @switch(App::getLocale())
                @case('en') Sort by: @break
                @case('sr-Cyrl') Сортитај по: @break
                @default Sortiraj po:
                @endswitch
            </label>
            <select id="globalSort" class="text-sm rounded-lg w-fit p-2.5 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--secondary-text); border: 1px solid var(--secondary-text); border-radius: 4px;">
                <option value="title_asc">A-Z</option>
                <option value="title_desc">Z-A</option>
                <option value="date_desc">
                    @switch(App::getLocale())
                    @case('en') Newest first @break
                    @case('sr-Cyrl') Новије прво @break
                    @default Novije prvo
                    @endswitch
                </option>
                <option value="date_asc">
                    @switch(App::getLocale())
                    @case('en') Oldest first @break
                    @case('sr-Cyrl') Старије прво @break
                    @default Starije prvo
                    @endswitch
                </option>
            </select>
        </div>

        <div id="accordion-collapse" data-accordion="collapse"
            class="rounded-lg"
            style="background: var(--primary-bg); border-color: var(--secondary-text);">
            @foreach($categories as $category)
            @php
            $isOpen = (string) $category->id === (string) $activeCategoryId;
            @endphp
            <div class="rounded-lg border"
                style="background: var(--primary-bg); border-color: var(--secondary-text);">
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 font-medium text-left rounded-lg"
                        style="color: var(--secondary-text); background: var(--primary-bg);"
                        data-category-id="{{ $category->id }}"
                        data-accordion-target="#accordion-body-{{ $category->id }}"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                        aria-controls="accordion-body-{{ $category->id }}">
                        <span style="color: var(--primary-text);">{{ $category->translate('name') }}</span>
                        <svg data-accordion-icon class="w-5 h-5 rotate-0 shrink-0 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            style="color: var(--secondary-text);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $category->id }}" class="{{ $isOpen ? '' : 'hidden' }}">
                    <div class="p-5 border-t"
                        style="background: var(--primary-bg); border-color: var(--secondary-text);">
                        @if($category->documents->isEmpty())
                        <p class="text-sm"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'No documents available.'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Нема доступних докумената.'
                                    : 'Nema dostupnih dokumenata.') }}
                        </p>
                        @else
                        <ul class="list-disc pl-5 space-y-1"
                            style="color: var(--primary-text);">
                            @foreach($category->documents as $doc)
                            <li data-doc-id="{{ $doc->id }}" data-category-id="{{ $category->id }}" data-updated="{{ $doc->updated_at }}">
                                @php
                                $isPdf = substr($doc->file_path, -4) === '.pdf';
                                $notPdf = in_array(substr($doc->file_path, -4), ['.doc', 'docx', 'xlsx']);
                                @endphp
                                <div class="flex flex-row justify-between items-center">
                                    @if($isPdf)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="hover:underline"
                                        style="color: var(--accent);">
                                        {{ $doc->title }}
                                    </a>
                                    @elseif($notPdf)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="hover:underline"
                                        style="color: var(--accent);">
                                        {{ $doc->title }}
                                    </a>
                                    @else
                                    <a href="{{ $doc->file_path }}" target="_blank" class="hover:underline"
                                        style="color: var(--accent);">
                                        {{ $doc->title }}
                                    </a>
                                    @endif
                                    <div class="flex flex-row items-center">
                                        <p class="text-xs mt-1" style="color: var(--secondary-text);">
                                            @switch(App::getLocale())
                                            @case('en') Updated at: @break
                                            @case('sr-Cyrl') Ажурирано: @break
                                            @default Ažurirano:
                                            @endswitch
                                            {{ $doc->updated_at->format('d.m.Y. H:i') }}
                                        </p>
                                        @auth
                                        <button id="dropdownMenuIconButton-{{ $doc->id }}" data-dropdown-toggle="dropdownDots-{{ $doc->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center rounded-lg focus:ring-4 focus:outline-none" type="button"
                                            style="color: var(--primary-text); background: var(--primary-bg);">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>
                                        </button>
                                        <div id="dropdownDots-{{ $doc->id }}" class="z-10 hidden rounded-lg shadow-sm w-36"
                                            style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
                                            <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton">
                                                <li>
                                                    <button data-modal-target="renameModal" data-modal-toggle="renameModal" data-doc-id="{{ $doc->id }}" data-doc-title="{{ $doc->title }}" class="block w-full text-left px-4 py-2 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                                                        style="color: var(--primary-text);">
                                                        {{ App::getLocale() === 'en'
                                                            ? 'Rename'
                                                            : (App::getLocale() === 'sr-Cyrl'
                                                                ? 'Преименуј'
                                                                : 'Preimenuj') }}
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-doc-id="{{ $doc->id }}" data-doc-title="{{ $doc->title }}" class="block w-full text-left px-4 py-2 text-red-500 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                                                        {{ App::getLocale() === 'en'
                                                            ? 'Delete'
                                                            : (App::getLocale() === 'sr-Cyrl'
                                                                ? 'Обриши'
                                                                : 'Obriši') }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @auth
                        <form id="uploadForm-{{ $category->id }}" class="mb-4 mt-7" enctype="multipart/form-data">
                            <label class="block mb-2 text-sm font-medium"
                                for="file_input-{{ $category->id }}"
                                style="color: var(--primary-text);">
                                {{ App::getLocale() === 'en'
                                    ? 'Upload a new document'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Постави нови документ'
                                        : 'Otpremite novi dokument') }}
                            </label>
                            <input class="block w-full text-sm border rounded-lg cursor-pointer  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                                aria-describedby="file_input_help-{{ $category->id }}"
                                id="file_input-{{ $category->id }}"
                                name="file"
                                type="file"
                                accept=".pdf,.doc,.docx,.xlsx,.xls"
                                required
                                style=" color: var(--primary-text); border-color: var(--secondary-text);">
                            <p class="mt-1 text-sm"
                                id="file_input_help-{{ $category->id }}"
                                style="color: var(--secondary-text);">
                                {{ App::getLocale() === 'en'
                                    ? 'Supported extensions: (.pdf, .doc, .docx, .xlsx) Maximum size: 2 MB'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Подржане екстензије: (.pdf, .doc, .docx, .xlsx) Максимална величина: 2 MB'
                                        : 'Podržane ekstenzije: (.pdf, .doc, .docx, .xlsx) Maksimalna veličina: 2 MB') }}
                            </p>
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <input type="hidden" name="category_name" value="{{ $category->name }}">
                            <div class="flex items-center mt-2">
                                <button type="submit" class="px-4 py-2 rounded-lg bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                                    {{ App::getLocale() === 'en'
                                        ? 'Upload'
                                        : (App::getLocale() === 'sr-Cyrl'
                                            ? 'Постави'
                                            : 'Objavi') }}
                                </button>
                                <div role="status" class="ml-5">
                                    <svg id="spinner-{{ $category->id }}" aria-hidden="true" class="hidden w-8 h-8 animate-spin"
                                        style="color: var(--secondary-text); fill: var(--accent);" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </form>
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                    style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--secondary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'Are you sure you want to delete?'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Да ли сте сигурни да желите да обришете'
                                    : 'Da li ste sigurni da želite da obrišete') }}
                            "<span id="deleteModalTitle"></span>"?
                        </h3>
                        <button data-modal-hide="deleteModal" id="confirmDeleteButton" type="button"
                            class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            style="background: var(--accent); color: #fff;">
                            {{ App::getLocale() === 'en'
                                ? 'Confirm'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Потврди'
                                    : 'Potvrdi') }}
                        </button>
                        <button data-modal-hide="deleteModal" type="button"
                            class="text-sm font-medium px-5 py-2.5 rounded-lg border"
                            style="background: var(--primary-bg); color: var(--secondary-text); border-color: var(--secondary-text);">
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

        <!-- Rename Modal -->
        <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative rounded-lg shadow"
                    style="background: var(--primary-bg); color: var(--primary-text);">
                    <div class="p-6">
                        <h3 class="mb-5 text-lg font-normal"
                            style="color: var(--primary-text);">
                            {{ App::getLocale() === 'en'
                                ? 'Rename document'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Преименуј документ'
                                    : 'Preimenuj dokument') }}
                        </h3>
                        <input type="text" id="renameInput" class="w-full p-2 border rounded-lg focus:outline-none  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                            placeholder="{{ App::getLocale() === 'en' ? 'Enter new name' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите нови назив' : 'Unesite novi naziv') }}"
                            style="border-color: var(--secondary-text);">
                        <div class="mt-4 text-center">
                            <button data-modal-hide="renameModal" id="confirmRenameButton" type="button"
                                class="font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                                {{ App::getLocale() === 'en'
                                    ? 'Save'
                                    : (App::getLocale() === 'sr-Cyrl'
                                        ? 'Сачувај'
                                        : 'Sačuvaj') }}
                            </button>
                            <button data-modal-hide="renameModal" type="button"
                                class="text-sm font-medium px-5 py-2.5 rounded-lg bg-gray-400 hover:bg-gray-500">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchResults = document.getElementById('searchResults');
            const accordionButtons = document.querySelectorAll('[data-accordion-target]');
            const deleteModal = document.getElementById('deleteModal');
            const renameModal = document.getElementById('renameModal');
            const deleteModalTitle = document.getElementById('deleteModalTitle');
            const renameInput = document.getElementById('renameInput');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            const confirmRenameButton = document.getElementById('confirmRenameButton');
            let selectedIndex = -1;
            let currentDocId = null;

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                searchResults.innerHTML = '';
                searchDropdown.classList.toggle('hidden', !query);
                selectedIndex = -1;

                if (query) {
                    const allDocuments = Array.from(document.querySelectorAll('li[data-doc-id]'));
                    const matchingDocs = allDocuments.filter(li => li.textContent.toLowerCase().includes(query));

                    matchingDocs.forEach(doc => {
                        const li = document.createElement('li');
                        li.className = 'p-2 cursor-pointer bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]';

                        const link = doc.querySelector('a');
                        li.textContent = link ? link.textContent : 'Neimenovan dokument';

                        li.dataset.docId = doc.dataset.docId;
                        li.dataset.categoryId = doc.dataset.categoryId;
                        li.addEventListener('click', () => handleDocumentSelect(doc));
                        searchResults.appendChild(li);
                    });

                }
            });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target) && !e.target.closest('[data-dropdown-toggle]') && !e.target.closest('[data-modal-toggle]')) {
                    searchDropdown.classList.add('hidden');
                    selectedIndex = -1;
                }
            });

            function handleDocumentSelect(doc) {
                accordionButtons.forEach(button => {
                    button.setAttribute('aria-expanded', 'false');
                    const target = document.querySelector(button.getAttribute('data-accordion-target'));
                    if (target) target.classList.add('hidden');
                    button.classList.remove('text-blue-800', 'dark:text-white');
                    button.classList.add('text-gray-600', 'dark:text-gray-400');
                    setTimeout(() => applySortToCategory(categoryId, sortType), 50);
                });

                const categoryId = doc.dataset.categoryId;
                const targetAccordion = document.getElementById(`accordion-body-${categoryId}`);
                const button = targetAccordion ? targetAccordion.previousElementSibling.querySelector('button') : null;
                if (button && targetAccordion) {
                    button.setAttribute('aria-expanded', 'true');
                    targetAccordion.classList.remove('hidden');
                    button.classList.remove('text-gray-600', 'dark:text-gray-400');
                    button.classList.add('text-blue-800', 'dark:text-white');
                    targetAccordion.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    searchDropdown.classList.add('hidden');
                    searchInput.value = '';
                    selectedIndex = -1;
                }
            }

            document.querySelectorAll('[data-modal-toggle="deleteModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentDocId = button.dataset.docId;
                    deleteModalTitle.textContent = button.dataset.docTitle;
                });
            });

            document.querySelectorAll('[data-modal-toggle="renameModal"]').forEach(button => {
                button.addEventListener('click', () => {
                    currentDocId = button.dataset.docId;
                    renameInput.value = button.dataset.docTitle;
                });
            });

            confirmDeleteButton.addEventListener('click', () => {
                fetch(`/dokumenti/${currentDocId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            const docElement = document.querySelector(`li[data-doc-id="${currentDocId}"]`);
                            if (docElement) docElement.remove();
                            deleteModal.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error deleting document:', error));
            });

            confirmRenameButton.addEventListener('click', () => {
                const newTitle = renameInput.value.trim();
                if (!newTitle) {
                    alert('Molimo unesite naziv dokumenta.');
                    return;
                }
                fetch(`/dokumenti/${currentDocId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            title: newTitle
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            const docLink = document.querySelector(`li[data-doc-id="${currentDocId}"] a`);
                            if (docLink) docLink.textContent = data.title;
                            renameModal.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error renaming document:', error));
            });
        });

        document.querySelectorAll('form[id^="uploadForm-"]').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const categoryId = form.querySelector('input[name="category_id"]').value;
                const categoryName = form.querySelector('input[name="category_name"]').value;
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                const spinner = document.getElementById(`spinner-${categoryId}`);
                spinner.classList.remove('hidden');

                const fileInput = form.querySelector('input[type="file"]');
                const fileSize = fileInput.files[0].size;

                const maxFileSize = 2048 * 1024;
                if (fileSize > maxFileSize) {
                    alert(`Vaš fajl prelazi maksimalnu podržanu veličinu`);
                    fileInput.value = '';
                    submitButton.disabled = false;
                    spinner.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('documents.store') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            spinner.classList.add('hidden');
                            window.location.href = `{{ route('documents.index') }}?category=${categoryName}`;
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Došlo je do greške prilikom učitavanja dokumenta: ' + error.message);
                        submitButton.disabled = false;
                        spinner.classList.add('hidden');
                    });
            });
        });

        function applySortToCategory(categoryId, sortType) {
            const ul = document.querySelector(
                `#accordion-body-${categoryId} ul.list-disc`
            );
            if (!ul) return;

            const items = Array.from(ul.children);

            items.sort((a, b) => {
                const linkA = a.querySelector('a');
                const linkB = b.querySelector('a');
                if (!linkA || !linkB) return 0;

                const titleA = linkA.innerText.trim().toLowerCase();
                const titleB = linkB.innerText.trim().toLowerCase();
                const dateA = new Date(a.getAttribute('data-updated'));
                const dateB = new Date(b.getAttribute('data-updated'));

                switch (sortType) {
                    case 'title_asc':
                        return titleA.localeCompare(titleB);
                    case 'title_desc':
                        return titleB.localeCompare(titleA);
                    case 'date_asc':
                        return dateA - dateB;
                    case 'date_desc':
                        return dateB - dateA;
                    default:
                        return 0;
                }
            });

            items.forEach(item => ul.appendChild(item));
        }


        document.getElementById('globalSort').addEventListener('change', (e) => {
            const activeAccordion = document.querySelector('[id^="accordion-body-"]:not(.hidden)');
            if (!activeAccordion) return;

            const categoryId = activeAccordion.id.replace('accordion-body-', '');
            applySortToCategory(categoryId, e.target.value);
        });
    </script>
</x-guest-layout>