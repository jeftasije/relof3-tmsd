<x-guest-layout>
    <div class="w-full bg-white dark:bg-gray-900 px-4 py-12 min-h-screen">
        <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mb-12">
            Javne nabavke
        </h1>

        <div class="my-10 flex justify-center">
            <form action="{{ route('procurements.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4 w-full max-w-2xl">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Pretraži dokument..."
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600"
                >
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Pretraži
                </button>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 space-y-4">
            @forelse ($procurements as $procurement)
                <div class="border-b pb-4 flex justify-between items-center" data-proc-id="{{ $procurement->id }}">
                    <a 
                        href="{{ asset('storage/' . $procurement->file_path) }}" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="text-lg font-semibold text-blue-600 hover:underline dark:text-blue-400"
                    >
                        {{ $procurement->title }}
                    </a>
                    @auth
                    <div class="relative">
                        <button 
                            id="dropdownMenuIconButton-{{ $procurement->id }}" 
                            data-dropdown-toggle="dropdownDots-{{ $procurement->id }}" 
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" 
                            type="button"
                        >
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                        <div 
                            id="dropdownDots-{{ $procurement->id }}" 
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700 dark:divide-gray-600"
                        >
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton-{{ $procurement->id }}">
                                <li>
                                    <button 
                                        data-modal-target="renameModal" 
                                        data-modal-toggle="renameModal" 
                                        data-proc-id="{{ $procurement->id }}" 
                                        data-proc-title="{{ $procurement->title }}" 
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        Preimenuj
                                    </button>
                                </li>
                                <li>
                                    <button 
                                        data-modal-target="deleteModal" 
                                        data-modal-toggle="deleteModal" 
                                        data-proc-id="{{ $procurement->id }}" 
                                        data-proc-title="{{ $procurement->title }}" 
                                        class="block w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600"
                                    >
                                        Obriši
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endauth
                </div>
            @empty
                <p class="text-gray-500">Trenutno nema dostupnih dokumenata.</p>
            @endforelse
        </div>

        <div id="deleteModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Da li ste sigurni da želite da obrišete "<span id="deleteModalTitle"></span>"?
                        </h3>
                        <button 
                            data-modal-hide="deleteModal" 
                            id="confirmDeleteButton" 
                            type="button" 
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                        >
                            Potvrdi
                        </button>
                        <button 
                            data-modal-hide="deleteModal" 
                            type="button" 
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600"
                        >
                            Otkaži
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
                            Preimenuj dokument
                        </h3>
                        <input 
                            type="text" 
                            id="renameInput" 
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400" 
                            placeholder="Unesite novi naziv"
                        >
                        <div class="mt-4 text-center">
                            <button 
                                data-modal-hide="renameModal" 
                                id="confirmRenameButton" 
                                type="button" 
                                class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            >
                                Sačuvaj
                            </button>
                            <button 
                                data-modal-hide="renameModal" 
                                type="button" 
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600"
                            >
                                Otkaži
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        const procElement = document.querySelector(`div[data-proc-id="${currentProcId}"]`);
                        if (procElement) procElement.remove();
                        deleteModal.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Greška prilikom brisanja dokumenta:', error));
            });

            confirmRenameButton.addEventListener('click', () => {
                const newTitle = renameInput.value.trim();
                if (!newTitle) {
                    alert('Molimo unesite naziv dokumenta.');
                    return;
                }

                fetch(`/nabavke/${currentProcId}`, {
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
                .catch(error => console.error('Greška prilikom preimenovanja dokumenta:', error));
            });
        });
    </script>
</x-guest-layout>