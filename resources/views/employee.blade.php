<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full text-gray-900 hover:bg-gray-200 focus:outline-none dark:text-white dark:hover:bg-gray-700">
                <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div x-data="{ open: false }" class="min-h-[90vh] w-full bg-white flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="bg-white dark:bg-gray-900">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-white">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 text-center dark:text-white">
                        {{ $text['title'] }}
                    </h1>
                    <p class="text-gray-700 mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto dark:text-gray-300">
                        {{ $text['description'] }}
                    </p>

                    <div class="flex justify-end mb-6">
                        @auth
                            <button @click="open = true" class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ App::getLocale() === 'en' ? 'Add' : (App::getLocale() === 'sr-Cyrl' ? 'Додај' : 'Dodaj') }}
                            </button>
                        @endauth
                    </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                    @foreach ($employees as $employee)
                        <x-employee-card :employee="$employee" />
                    @endforeach
                </div>
                @if ($employees->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $employees->links('pagination::tailwind') }}
                    </div>
                @endif
                </div>
            </div>
        </div>

        <div
            x-show="open"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: none;"
            @click.self="open = false"
        >
            <div
                x-show="open"
                x-transition
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full p-8 relative"
                @keydown.escape.window="open = false"
            >
                <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ App::getLocale() === 'en' ? 'Add Employee' : (App::getLocale() === 'sr-Cyrl' ? 'Додај запосленог' : 'Dodaj zaposlenog') }}
                                </h2>
                            </div>

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="name">
                                {{ App::getLocale() === 'en' ? 'Name' : (App::getLocale() === 'sr-Cyrl' ? 'Име' : 'Ime') }}
                            </label>
                            <input type="text" name="name" id="name" required
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="position">
                                {{ App::getLocale() === 'en' ? 'Position' : (App::getLocale() === 'sr-Cyrl' ? 'Позиција' : 'Pozicija') }}
                            </label>
                            <input type="text" name="position" id="position" required
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="biography">
                                {{ App::getLocale() === 'en' ? 'Short Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Кратка биографија' : 'Kratka biografija') }}
                            </label>
                            <textarea name="biography" id="biography" rows="4"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white"></textarea>

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="image">
                                {{ App::getLocale() === 'en' ? 'Upload Image' : (App::getLocale() === 'sr-Cyrl' ? 'Додај слику' : 'Dodaj sliku') }}
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />
                        </div>

                        <div>
                            <div class="flex items-center mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ App::getLocale() === 'en' ? 'Extended Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Проширена биографија' : 'Proširena biografija') }}
                                </h2>
                            </div>

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="biography_extended">
                                {{ App::getLocale() === 'en' ? 'Full Biography' : (App::getLocale() === 'sr-Cyrl' ? 'Цела биографија' : 'Cela biografija') }}
                            </label>
                            <textarea name="biography_extended" id="biography_extended" rows="4"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white"></textarea>

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="university">
                                {{ App::getLocale() === 'en' ? 'University' : (App::getLocale() === 'sr-Cyrl' ? 'Универзитет' : 'Univerzitet') }}
                            </label>
                            <input type="text" name="university" id="university"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="experience">
                                {{ App::getLocale() === 'en' ? 'Experience' : (App::getLocale() === 'sr-Cyrl' ? 'Искуство' : 'Iskustvo') }}
                            </label>
                            <textarea name="experience" id="experience" rows="3"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white"></textarea>

                            <label class="block mb-2 text-gray-700 dark:text-gray-300" for="skills">
                                {{ App::getLocale() === 'en' ? 'Skills' : (App::getLocale() === 'sr-Cyrl' ? 'Вештине' : 'Veštine') }}
                            </label>
                            <textarea name="skills" id="skills" rows="3"
                                class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-8">
                        <button type="button" @click="open = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700">
                            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">
                            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>