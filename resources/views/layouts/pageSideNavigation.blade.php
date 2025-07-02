<aside id="page-sidebar" class="fixed top-0 left-0 z-50 w-96 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav-page-navigation">
    <div class="flex justify-start">
        <button data-drawer-target="page-sidebar" data-drawer-toggle="page-sidebar" aria-controls="page-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Close sidebar</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12l14 0" />
                <path d="M5 12l6 6" />
                <path d="M5 12l6 -6" />
            </svg>
        </button>
    </div>
    <div class="flex-col justify-center items-center overflow-y-auto px-3 h-full">
        <p class="text-lg text-center font-semibold dark:text-white">
            @switch(App::getLocale())
            @case('en') Pages @break
            @case('sr-Cyrl') Странице @break
            @default Stranice
            @endswitch
        </p>
        <div class="flex flex-col gap-5 mt-5">
            <label for="pagesList" class="dark:text-white font-semibold ml-6">
                @switch(App::getLocale())
                @case('en')
                Finished pages
                @break
                @case('sr-Cyrl')
                Завршене странице
                @break
                @default
                Zavšene stranice
                @endswitch
            </label>
            <ul id="finishedPagesList" class="space-y-2 dark:text-white">
                @foreach($finishedPages as $page)
                <li class="flex items-center justify-between w-full gap-1" data-id="{{ $mainSection->id }}">
                    <button type="button" class="flex items-center overflow-hidden justify-between w-full p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                        <span class="truncate">{{ $page->translate('title') }}</span>
                    </button>
                    <button id="dropdownPageIconButton-{{ $page->id }}" data-dropdown-toggle="dropdownPageDots-{{ $page->id }}" class="ml-auto inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>
                    <div id="dropdownPageDots-{{ $page->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownPageIconButton-{{ $page->id }}">
                            <li>
                                <a href="{{ route('page.edit', $page->slug) }}"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                                            disabled:opacity-50 disabled:cursor-not-allowed 
                                          disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Edit
                                    @break
                                    @case('sr-Cyrl')
                                    Уреди
                                    @break
                                    @default
                                    Uredi
                                    @endswitch
                                </a>
                            </li>
                            <li>
                                <button {{ $page->is_deletable ? '' : 'disabled' }} data-modal-target="deletePageModal" data-modal-toggle="deletePageModal" data-page-id="{{ $page->id }}" data-page-title="{{ $page->title }}"
                                    class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600
                                                                disabled:opacity-50 disabled:cursor-not-allowed 
                                                                disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                    {{ App::getLocale() === 'en'
                                                            ? 'Delete'
                                                            : (App::getLocale() === 'sr-Cyrl'
                                                                ? 'Обриши'
                                                                : 'Obriši') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
            @if (count($unfinishedPages) > 0)
            <label for="unfinishedPagesList" class="dark:text-white font-semibold ml-6 pt-5 border-t border-gray-200 dark:border-gray-700">
                @switch(App::getLocale())
                @case('en')
                Unfinished pages
                @break
                @case('sr-Cyrl')
                Незавршене странице
                @break
                @default
                Nezavšene stranice
                @endswitch
            </label>
            <ul id="unfinishedPagesList" class="space-y-2 dark:text-white">
                @foreach($unfinishedPages as $page)
                <li class="flex items-center justify-between w-full gap-1" data-id="{{ $mainSection->id }}">
                    <button type="button" class="flex items-center justify-between overflow-hidden w-full p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                        <span class="truncate">{{ $page->translate('title') }}</span>
                    </button>
                    <button id="dropdownPageIconButton-{{ $page->id }}" data-dropdown-toggle="dropdownPageDots-{{ $page->id }}" class="ml-auto inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>
                    <div id="dropdownPageDots-{{ $page->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownPageIconButton-{{ $page->id }}">
                            <li>
                                <a href="{{ route('page.edit', $page->slug) }}"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                                            disabled:opacity-50 disabled:cursor-not-allowed 
                                          disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                    @switch(App::getLocale())
                                    @case('en')
                                    Edit
                                    @break
                                    @case('sr-Cyrl')
                                    Уреди
                                    @break
                                    @default
                                    Uredi
                                    @endswitch
                                </a>
                            </li>
                            <li>
                                <button {{ $page->is_deletable ? '' : 'disabled' }} data-modal-target="deletePageModal" data-modal-toggle="deletePageModal" data-page-id="{{ $page->id }}" data-page-title="{{ $page->title }}"
                                    class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600
                                                                disabled:opacity-50 disabled:cursor-not-allowed 
                                                                disabled:text-gray-400 disabled:hover:bg-transparent dark:disabled:hover:bg-transparent">
                                    {{ App::getLocale() === 'en'
                                                            ? 'Delete'
                                                            : (App::getLocale() === 'sr-Cyrl'
                                                                ? 'Обриши'
                                                                : 'Obriši') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
            <a href="/sabloni" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm ml-5 mt-5 px-2.5 py-2.5 w-fit dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                @switch(App::getLocale())
                @case('en')
                Create a page.
                @break
                @case('sr-Cyrl')
                Креирај страницу.
                @break
                @default
                Kreiraj stranicu.
                @endswitch
            </a>
        </div>
    </div>

    <div id="deletePageModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 text-center">
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        {{ App::getLocale() === 'en'
                                ? 'Are you sure you want to delete?'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Да ли сте сигурни да желите да обришете'
                                    : 'Da li ste sigurni da želite da obrišete') }}
                        "<span id="deletePageModalTitle"></span>"?
                    </h3>
                    <button data-modal-hide="deletePageModal" id="confirmDeletePageButton" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        {{ App::getLocale() === 'en'
                                ? 'Confirm'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Потврди'
                                    : 'Potvrdi') }}
                    </button>
                    <button data-modal-hide="deletePageModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const locale = '{{ App::getLocale() }}';

        let currentPageId = null;
        const deletePageModal = document.getElementById('deletePageModal');
        const deletePageModalTitle = document.getElementById('deletePageModalTitle');

        document.querySelectorAll('[data-modal-toggle="deletePageModal"]').forEach(button => {
            button.addEventListener('click', () => {
                currentPageId = button.dataset.pageId;
                deletePageModalTitle.textContent = button.dataset.pageTitle;
            });
        });

        confirmDeletePageButton.addEventListener('click', () => {
            fetch(`/stranica/${currentPageId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Deleted successfully!';
                                case 'sr-Cyrl':
                                    return 'Успешно обрисано!';
                                default:
                                    return 'Uspešno obrisano!';
                            }
                        })());
                        window.location.href = '/';
                    } else {
                        alert((() => {
                            switch (locale) {
                                case 'en':
                                    return 'Error deleting.';
                                case 'sr-Cyrl':
                                    return 'Грешка при брисању.';
                                default:
                                    return 'Greška pri brisanju.';
                            }
                        })());
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert((() => {
                        switch (locale) {
                            case 'en':
                                return 'An error occurred.';
                            case 'sr-Cyrl':
                                return 'Дошло је до грешке.';
                            default:
                                return 'Došlo je do greške.';
                        }
                    })());
                });
        });
    });
</script>