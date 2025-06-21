<x-guest-layout>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex-grow">
            <section class="relative h-screen w-full">
                <img
                    src="{{ asset('images/herosection.jpg') }}"
                    alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}"
                    class="absolute inset-0 w-full h-full object-cover" />
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4 animate-fadeIn">
                    <h1 class="text-5xl font-extrabold mb-4">{{ $libraryData['name'] ?? '' }}</h1>
                    <p class="text-3xl font-semibold">
                        {{ App::getLocale() === 'en' ? 'Novi Pazar' : (App::getLocale() === 'sr-Cyrl' ? 'Нови Пазар' : 'Novi Pazar') }}
                    </p>
                </div>
            </section>

            <section class="bg-white dark:bg-gray-900">
                <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                    <div class="mr-auto place-self-center lg:col-span-7">
                        <h2 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                            {{ App::getLocale() === 'en' ? 'Let’s stay in touch!' : (App::getLocale() === 'sr-Cyrl' ? 'Будимо у контакту!' : 'Budimo u kontaktu!') }}
                        </h2>
                        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                            {{ App::getLocale() === 'en'
                                ? 'Sign up to be notified about the latest news'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Пријавите се како бисмо Вас обавестили о најновијим вестима'
                                    : 'Prijavite se kako bismo Vas obavestili o najnovijim vestima') }}
                        </p>
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            {{ App::getLocale() === 'en' ? 'Sign up' : (App::getLocale() === 'sr-Cyrl' ? 'Пријава' : 'Prijava') }}
                        </a>
                    </div>
                    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                        <img
                            src="{{ asset('images/books.png') }}"
                            alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}" />
                    </div>
                </div>
            </section>
            <section class="bg-gray-100 dark:bg-gray-800 py-12">
                <div class="max-w-screen-xl mx-auto px-4 text-center">
                    <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                        {{ App::getLocale() === 'en'
                            ? 'Search for books on COBISS'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Претражи књиге на COBISS-у'
                                : 'Pretraži knjige na COBISS-u') }}
                    </h2>
                    <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">
                        {{ App::getLocale() === 'en'
                            ? 'Enter the book title, author, or ISBN and you will be redirected to COBISS'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Унесите назив књиге, аутора или ISBN број и бићете преусмерени на COBISS'
                                : 'Unesite naziv knjige, autora ili ISBN broj i bićete preusmereni na COBISS') }}
                    </p>
                    <form
                        action="https://plus.cobiss.net/cobiss/sr/sr/bib/search"
                        method="get"
                        target="_blank"
                        class="max-w-2xl mx-auto flex flex-col sm:flex-row items-center gap-4">
                        <input
                            type="text" name="q" required
                            placeholder="{{ App::getLocale() === 'en' ? 'For example: Ivo Andrić, The Bridge on the Drina...' : (App::getLocale() === 'sr-Cyrl' ? 'На пример: Иво Андрић, На Дрини ћуприја...' : 'Na primer: Ivo Andrić, Na Drini ćuprija...') }}"
                            class="w-full p-3 rounded-lg border  text-gray-900 focus:ring-2 focus:ring-blue-500" />
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            {{ App::getLocale() === 'en' ? 'Search' : (App::getLocale() === 'sr-Cyrl' ? 'Претражи' : 'Pretraži') }}
                        </button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
</x-guest-layout>