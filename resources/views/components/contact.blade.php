<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h2 class="mb-4 text-5xl font-extrabold md:text-6xl dark:text-white">
                {{ __('homepage_contact_title') }}
            </h2>
            <p class=" mb-6 font-light text-gray-500 dark:text-gray-400">
                {{ __('homepage_contact_subtitle') }}
            </p>
            <div class="flex flex-row gap-2 max-w-md">
                <input 
                    type="email" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="{{ App::getLocale() === 'en' ? 'Enter your email' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите своју мејл адресу' : 'Unesite svoju mejl adresu') }}" 
                    required
                >
                <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 whitespace-nowrap">
                    {{ App::getLocale() === 'en' ? 'Sign up' : (App::getLocale() === 'sr-Cyrl' ? 'Пријава' : 'Prijava') }}
                </a>
            </div>
        </div>
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            <img
                src="{{ asset($contactImage) }}"
                alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}" />
        </div>
    </div>
</section>