<x-guest-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="relative mb-24 mt-5">
            <input type="text" id="searchInput" placeholder="Pretraži dokumente..." class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div id="searchDropdown" class="absolute z-10 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg mt-1 hidden">
                <ul id="searchResults" class="max-h-40 overflow-y-auto"></ul>
            </div>
        </div>

        <div id="accordion-collapse" data-accordion="collapse" class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
            @foreach($categories as $category)
            <div class="rounded-lg border bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-600 dark:text-gray-400 rounded-lg bg-white dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700"
                        data-accordion-target="#accordion-body-{{ $category->id }}"
                        aria-expanded="false"
                        aria-controls="accordion-body-{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                        <svg data-accordion-icon class="w-5 h-5 rotate-0 shrink-0 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $category->id }}" class="hidden" aria-labelledby="accordion-heading-{{ $category->id }}">
                    <div class="p-5 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                        @if($category->documents->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nema dostupnih dokumenata.</p>
                        @else
                        <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                            @foreach($category->documents as $doc)
                            <li data-doc-id="{{ $doc->id }}" data-category-id="{{ $category->id }}">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="hover:underline text-blue-600">
                                    {{ $doc->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchResults = document.getElementById('searchResults');
            const accordionButtons = document.querySelectorAll('[data-accordion-target]');

            let selectedIndex = -1;

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
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
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
                    targetAccordion.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    searchDropdown.classList.add('hidden');
                    searchInput.value = '';
                    selectedIndex = -1;
                }
            }
        });
    </script>
</x-guest-layout>