<x-app-layout>
    <div class="flex flex-col items-center w-full min-h-screen">
        <div class="mb-10 mt-10">
            <h1 class="text-2xl mb-3 sm:text-3xl md:text-4xl font-bold text-center"
                style="color: var(--primary-text) !important;">
                @switch(App::getLocale())
                @case('en') Editors @break
                @case('sr-Cyrl') Уредници @break
                @default Urednici
                @endswitch
            </h1>
            <p class="sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto" style="color: var(--secondary-text) !important;">
                @switch(App::getLocale())
                @case('en')
                On this page, you can create and manage editor accounts. Editors are allowed to edit content on existing pages of the website, including text, images, and other elements, but they are not permitted to add new pages, change the navigation, or modify the structure and appearance of the site. These privileges are reserved for you as the administrator.
                @break
                @case('sr-Cyrl')
                На овој страници можете да креирате и управљате налозима уредника. Уредници имају могућност да уређују садржај на постојећим страницама сајта, укључујући текстове, слике и друге елементе, али немају дозволу да додају нове странице, мењају навигацију или утичу на структуру и изглед сајта. Ове привилегије су резервисане за Вас као администратора.
                @break
                @default
                Na ovoj stranici možete da kreirate i upravljate nalozima urednika. Urednici imaju mogućnost da uređuju sadržaj na postojećim stranicama sajta, uključujući tekstove, slike i druge elemente, ali nemaju dozvolu da dodaju nove stranice, menjaju navigaciju ili utiču na strukturu i izgled sajta. Ove privilegije su rezervisane za Vas kao administratora.
                @endswitch
            </p>
        </div>
        <div class="flex flex-col items-center gap-20">
            <div class="w-fit">
                @include('auth.register')
            </div>
            <div x-data="editorsComponent()" x-init="loadEditors()" class="w-full">
                <table class="w-full text-sm text-left border-collapse rounded-lg overflow-hidden shadow-md">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">
                                @switch(App::getLocale())
                                @case('en') Name @break
                                @case('sr-Cyrl') Име @break
                                @default Ime
                                @endswitch
                            </th>
                            <th class="px-4 py-3">
                                @switch(App::getLocale())
                                @case('en') Email @break
                                @case('sr-Cyrl') Мејл адреса @break
                                @default Mejl adresa
                                @endswitch
                            </th>
                            <th class="px-4 py-3">
                                @switch(App::getLocale())
                                @case('en') Date @break
                                @case('sr-Cyrl') Датум @break
                                @default Datum
                                @endswitch
                            </th>
                            <th class="px-4 py-3">
                                @switch(App::getLocale())
                                @case('en') Actions @break
                                @case('sr-Cyrl') Акције @break
                                @default Akcije
                                @endswitch
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                        <template x-for="editor in editors" :key="editor.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-100" x-text="editor.name"></td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-100" x-text="editor.email"></td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-100" x-text="formatDate(editor.created_at)"></td>
                                <td class="px-4 py-3">
                                    <button
                                        @click="editorToDelete = editor; showDeleteModal = true"
                                        class="text-red-600 dark:text-red-400 hover:underline font-semibold">
                                        @switch(App::getLocale())
                                        @case('en') Delete @break
                                        @case('sr-Cyrl') Обриши @break
                                        @default Obriši
                                        @endswitch
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div
                    x-show="showDeleteModal"
                    x-cloak
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
                            @switch(App::getLocale())
                            @case('en') Confirm Deletion @break
                            @case('sr-Cyrl') Потврда брисања @break
                            @default Potvrda brisanja
                            @endswitch
                        </h2>

                        <p class="mb-6 text-gray-700 dark:text-gray-300">
                            @switch(App::getLocale())
                            @case('en') Are you sure you want to delete this editor? @break
                            @case('sr-Cyrl') Да ли сте сигурни да желите да обришете овог уредника? @break
                            @default Da li ste sigurni da želite da obrišete ovog urednika?
                            @endswitch
                        </p>

                        <div class="flex justify-end gap-4">
                            <button
                                @click="showDeleteModal = false"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                                @switch(App::getLocale())
                                @case('en') Cancel @break
                                @case('sr-Cyrl') Откажи @break
                                @default Otkaži
                                @endswitch
                            </button>

                            <button
                                @click="deleteEditor(editorToDelete.id); showDeleteModal = false"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                @switch(App::getLocale())
                                @case('en') Delete @break
                                @case('sr-Cyrl') Обриши @break
                                @default Obriši
                                @endswitch
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    x-show="successMessage"
                    x-transition
                    x-cloak
                    class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-20 left-1/2 transform -translate-x-1/2 z-50 shadow-lg"
                    x-text="successMessage">
                </div>
            </div>
        </div>
    </div>


    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 4000)"
        class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
        @switch(App::getLocale())
        @case('en')
        Editor created successfully @break
        @case('sr-Cyrl')
        Уредник је успешно додат @break
        @default
        Urednik je uspešno dodat
        @endswitch
    </div>
    @endif

</x-app-layout>

<script>
    function editorsComponent() {
        return {
            editors: [],
            successMessage: '',
            showDeleteModal: false,
            editorToDelete: null,
            async loadEditors() {
                const res = await fetch('/editors');
                this.editors = await res.json();
            },
            async deleteEditor(id) {
                const res = await fetch(`/editor/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    this.editors = this.editors.filter(editor => editor.id !== id);
                    this.successMessage = this.getLocaleMessage('deleted');
                    setTimeout(() => this.successMessage = '', 4000);
                } else {
                    alert("Greška pri brisanju!");
                }
            },
            formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('sr-RS');
            },

            getLocaleMessage(type) {
                const locale = document.documentElement.lang || 'sr';
                const messages = {
                    en: {
                        deleted: 'Editor deleted successfully',
                        created: 'Editor created successfully',
                    },
                    'sr-Cyrl': {
                        deleted: 'Уредник је успешно обрисан',
                        created: 'Уредник је успешно додат',
                    },
                    default: {
                        deleted: 'Urednik je uspešno obrisan',
                        created: 'Urednik je uspešno dodat',
                    }
                };

                return messages[locale]?.[type] ?? messages.default[type];
            }
        }
    }
</script>