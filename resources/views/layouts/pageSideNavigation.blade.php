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
        <div class="flex flex-row justify-end items-center mt-4">
            <button id="delete-selected-pages" class="px-2 py-2 bg-red-500 text-white rounded-3xl hover:bg-red-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col gap-5">
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
            @if(count($finishedPages) > 0)
            <ul id="finishedPagesList" class="space-y-2 dark:text-white">
                @foreach($finishedPages as $page)
                <li class="flex items-center justify-between w-full gap-1" data-id="{{ $mainSection->id }}">
                    <input id="checkbox-{{ $page->id }}" data-tooltip-target="tooltip-pages-{{ $page->id }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <div id="tooltip-pages-{{ $page->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        @switch(App::getLocale())
                        @case('en')
                        Check to delete
                        @break
                        @case('sr-Cyrl')
                        Означите како бисте обрисали
                        @break
                        @default
                        Označite kako biste obrisali
                        @endswitch
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button type="button" class="flex items-center overflow-hidden justify-between w-full p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                        <span class="truncate">{{ $page->title }}</span>
                        <a href="{{ route('page.edit', $page->slug) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-1.5 w-fit dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            @switch(App::getLocale())
                            @case('en')
                            Edit
                            @break
                            @case('sr-Cyrl')
                            уреди
                            @break
                            @default
                            Izmeni
                            @endswitch
                        </a>
                    </button>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-center dark:text-white mt-16">
                @switch(App::getLocale())
                @case('en')
                You have not created any pages yet.
                @break
                @case('sr-Cyrl')
                Нисте још направили ниједну страницу.
                @break
                @default
                Još uvek niste napravili nijednu stranicu.
                @endswitch
            </p>
            @endif
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
                    <input id="checkbox-{{ $page->id }}" data-tooltip-target="tooltip-pages-{{ $page->id }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <div id="tooltip-pages-{{ $page->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        @switch(App::getLocale())
                        @case('en')
                        Check to delete
                        @break
                        @case('sr-Cyrl')
                        Означите како бисте обрисали
                        @break
                        @default
                        Označite kako biste obrisali
                        @endswitch
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button type="button" class="flex items-center justify-between overflow-hidden w-full p-2 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                        <span class="truncate">{{ $page->title }}</span>
                        <a href="{{ route('page.edit', $page->slug) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-1.5 w-fit dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            @switch(App::getLocale())
                            @case('en')
                            Continue editing
                            @break
                            @case('sr-Cyrl')
                            Настави уређивање
                            @break
                            @default
                            Nastavi uređivanje
                            @endswitch
                        </a>
                    </button>
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

    <div id="delete-modal-page" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    {{ App::getLocale() === 'en' ? 'Confirm Deletion' : (App::getLocale() === 'sr-Cyrl' ? 'Потврда брисања' : 'Potvrda brisanja') }}
                </h3>
                <div class="mt-2 px-7 py-3">
                    <p id="delete-modal-page-message" class="text-sm text-gray-600 dark:text-gray-300"></p>
                </div>
                <div class="items-center px-4 py-3 flex justify-center space-x-4">
                    <button id="delete-page-confirm-btn" class="px-4 py-2 bg-red-500 text-white font-medium rounded-md w-24 hover:bg-red-600">
                        {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
                    </button>
                    <button id="delete-page-cancel-btn" class="px-4 py-2 bg-gray-500 text-white font-medium rounded-md w-24 hover:bg-gray-600">
                        {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const locale = '{{ App::getLocale() }}';

        const unfinishedList = document.getElementById('unfinishedPagesList');
        const finishedList = document.getElementById('finishedPagesList');
        const deletePagesBtn = document.getElementById('delete-selected-pages');
        const deletePagesModal = document.getElementById('delete-modal-page');
        const deletePagesMsg = document.getElementById('delete-modal-page-message');
        const deletePagesConfirmBtn = document.getElementById('delete-page-confirm-btn');
        const deletePagesCancelBtn = document.getElementById('delete-page-cancel-btn');
        let pendingPagesDeleteIds = [];

        deletePagesBtn.addEventListener('click', () => {
            const checkedUnfinished = unfinishedList ?
                Array.from(unfinishedList.querySelectorAll('input[type="checkbox"]:checked')) :
                [];
            const checkedFinished = finishedList ?
                Array.from(finishedList.querySelectorAll('input[type="checkbox"]:checked')) :
                [];
            const checked = [...checkedUnfinished, ...checkedFinished];

            if (checked.length === 0) {
                return alert((() => {
                    switch (locale) {
                        case 'en':
                            return 'Please select at least one page to delete.';
                        case 'sr-Cyrl':
                            return 'Означите бар једну страницу за брисање.';
                        default:
                            return 'Označite bar jednu stranicu za brisanje.';
                    }
                })());
            }

            pendingPagesDeleteIds = checked.map(cb => cb.id.split('-')[1]);

            deletePagesMsg.textContent = (() => {
                switch (locale) {
                    case 'en':
                        return `You are about to delete ${pendingPagesDeleteIds.length} page(s).`;
                    case 'sr-Cyrl':
                        return `Управо ћете обрисати ${pendingPagesDeleteIds.length} страницу(е).`;
                    default:
                        return `Upravo ćete obrisati ${pendingPagesDeleteIds.length} stranicu(e).`;
                }
            })();

            deletePagesModal.classList.remove('hidden');
        });

        deletePagesCancelBtn.addEventListener('click', () => {
            deletePagesModal.classList.add('hidden');
            pendingPagesDeleteIds = [];
        });

        deletePagesConfirmBtn.addEventListener('click', () => {
            fetch(`{{ route('page.destroy') }}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        ids: pendingPagesDeleteIds
                    })
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
                        window.location.reload();
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