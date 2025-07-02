<section class="bg-gray-100 dark:bg-gray-800 py-12">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
            {{ __('cobiss_title') }}
        </h2>
        <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">
            {{ __('cobiss_subtitle') }}
        </p>
        <form
            action="https://plus.cobiss.net/cobiss/sr/sr/bib/search"
            method="get"
            target="_blank"
            class="mx-auto w-full max-w-3xl flex flex-col sm:flex-row justify-center items-center gap-4"
        >
            <input
                type="text"
                name="q"
                required
                placeholder="{{ App::getLocale() === 'en' ? 'For example: Ivo Andrić, The Bridge on the Drina...' : (App::getLocale() === 'sr-Cyrl' ? 'На пример: Иво Андрић, На Дрини ћуприја...' : 'Na primer: Ivo Andrić, Na Drini ćuprija...') }}"
                class="flex-grow w-full p-4 text-lg rounded-lg border border-gray-300 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
        />
            <input type="hidden" name="db" value="nbnp-1">
            <input type="hidden" name="mat" value="allmaterials">
            <button
                type="submit"
                class="px-6 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
                {{ App::getLocale() === 'en' ? 'Search' : (App::getLocale() === 'sr-Cyrl' ? 'Претражи' : 'Pretraži') }}
            </button>
        </form>
    </div>
</section>