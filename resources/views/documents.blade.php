<x-guest-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="relative mb-24 mt-5">
            <input type="text" id="searchInput" placeholder="{{ App::getLocale() === 'en' ? 'Search documents...' : 'Pretraži dokumente...' }}" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div id="searchDropdown" class="absolute z-10 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg mt-1 hidden">
                <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
            </div>
        </div>

        <div id="accordion-collapse" data-accordion="collapse" class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
            @foreach($categories as $category)
            @php
            $isOpen = (string) $category->id === (string) $activeCategoryId;
            @endphp
            <div class="rounded-lg border bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
                <h2>
                    <button type="button"
                        class="$isOpen ? flex items-center justify-between w-full p-4 font-medium text-left text-gray-600 dark:text-gray-400 rounded-lg bg-white dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700"
                        data-accordion-target="#accordion-body-{{ $category->id }}"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                        aria-controls="accordion-body-{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                        <svg data-accordion-icon class="$isOpen ? w-5 h-5 rotate-0 shrink-0 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $category->id }}" class=" $isOpen ? '' : 'hidden' " aria-labelledby="accordion-heading-{{ $category->id }}">
                    <div class="p-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                        @if($category->documents->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nema dostupnih dokumenata.</p>
                        @else
                        <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                            @foreach($category->documents as $doc)
                            <li data-doc-id="{{ $doc->id }}" data-category-id="{{ $category->id }}">
                                @php
                                $isPdf = substr($doc->file_path, -4) === '.pdf';
                                $notPdf = in_array(substr($doc->file_path, -4), ['.doc', 'docx', 'xlsx']);
                                @endphp
                                <div class="flex justify-between items-center">
                                    @if($isPdf)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="hover:underline text-blue-600">
                                        {{ $doc->title }}
                                    </a>
                                    @elseif($notPdf)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="hover:underline text-blue-600">
                                        {{ $doc->title }}
                                    </a>
                                    @else
                                    <a href="{{ $doc->file_path }}" target="_blank" class="hover:underline text-blue-600">
                                        {{ $doc->title }}
                                    </a>
                                    @endif
                                    @auth
                                    <button id="dropdownMenuIconButton-{{ $doc->id }}" data-dropdown-toggle="dropdownDots-{{ $doc->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                        </svg>
                                    </button>
                                    <div id="dropdownDots-{{ $doc->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                            <li>
                                                <button data-modal-target="renameModal" data-modal-toggle="renameModal" data-doc-id="{{ $doc->id }}" data-doc-title="{{ $doc->title }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ App::getLocale() === 'en' ? 'Rename' : 'Preimenuj' }}</button>
                                            </li>
                                            <li>
                                                <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-doc-id="{{ $doc->id }}" data-doc-title="{{ $doc->title }}" class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600">{{ App::getLocale() === 'en' ? 'Delete' : 'Obriši' }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    @endauth
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @auth
                        <form id="uploadForm-{{ $category->id }}" class="mb-4 mt-7" enctype="multipart/form-data">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input-{{ $category->id }}">{{ App::getLocale() === 'en' ? 'Upload a new document' : 'Otpremite novi dokument' }}</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="file_input_help-{{ $category->id }}"
                                id="file_input-{{ $category->id }}"
                                name="file"
                                type="file"
                                accept=".pdf,.doc,.docx,.xlsx,.xls"
                                required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help-{{ $category->id }}">{{ App::getLocale() === 'en' ? 'Supported extensions: (.pdf, .doc, .docx, .xlsx) Maximum size: 2 MB' : 'Podržane ekstenzije: (.pdf, .doc, .docx, .xlsx) Maksimalna veličina: 2 MB' }}</p>
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <input type="hidden" name="category_name" value="{{ $category->name }}">
                            <div class="flex items-center mt-2">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                    {{ App::getLocale() === 'en' ? 'Upload' : 'Objavi' }}
                                </button>
                                <div role="status" class="ml-5">
                                    <svg id="spinner-{{ $category->id }}" aria-hidden="true" class="hidden w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ App::getLocale() === 'en' ? 'Are you sure you want to delete?' : 'Da li ste sigurni da želite da obrišete' }}"<span id="deleteModalTitle"></span>"?</h3>
                        <button data-modal-hide="deleteModal" id="confirmDeleteButton" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            {{ App::getLocale() === 'en' ? 'Confirm' : 'Potvrdi' }}
                        </button>
                        <button data-modal-hide="deleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ App::getLocale() === 'en' ? 'Cancel' : 'Otkaži' }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rename Modal -->
        <div id="renameModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-6">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ App::getLocale() === 'en' ? 'Rename document' : 'Preimenuj dokument' }}</h3>
                        <input type="text" id="renameInput" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" placeholder="Unesite novi naziv">
                        <div class="mt-4 text-center">
                            <button data-modal-hide="renameModal" id="confirmRenameButton" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                {{ App::getLocale() === 'en' ? 'Save' : 'Sačuvaj' }}
                            </button>
                            <button data-modal-hide="renameModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">{{ App::getLocale() === 'en' ? 'Cancel' : 'Otkaži' }}</button>
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
                        li.className = 'p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';
                        li.textContent = doc.textContent;
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
    </script>
</x-guest-layout>