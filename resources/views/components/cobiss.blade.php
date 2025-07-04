<section class="bg-gray-100 dark:bg-gray-800 py-12"
    style="background: var(--primary-bg)">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white"
            style="color: var(--primary-text) !important;">
            {{ __('cobiss_title') }}
        </h2>
        <p class="text-lg mb-6 text-gray-700 dark:text-gray-300"
            style="color: var(--secondary-text) !important;">
            {{ __('cobiss_subtitle') }}
        </p>
        <form
            action="https://plus.cobiss.net/cobiss/sr/sr/bib/search"
            method="get"
            target="_blank"
            class="mx-auto w-full max-w-3xl flex flex-col sm:flex-row justify-center items-center gap-4">
            <input
                type="text"
                name="q"
                required
                placeholder="{{ App::getLocale() === 'en' ? 'For example: Ivo Andrić, The Bridge on the Drina...' : (App::getLocale() === 'sr-Cyrl' ? 'На пример: Иво Андрић, На Дрини ћуприја...' : 'Na primer: Ivo Andrić, Na Drini ćuprija...') }}"
                class="flex-grow w-full p-4 text-lg rounded-lg border bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]" />
            <input type="hidden" name="db" value="nbnp-1">
            <input type="hidden" name="mat" value="allmaterials">
            <button
                type="submit"
                class="px-6 py-4 font-semibold rounded-lg transition bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                {{ App::getLocale() === 'en' ? 'Search' : (App::getLocale() === 'sr-Cyrl' ? 'Претражи' : 'Pretraži') }}
            </button>
        </form>
    </div>
</section>