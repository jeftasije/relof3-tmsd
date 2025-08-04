<section style="background: var(--primary-bg)">
    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h2 class="mb-4 text-5xl font-extrabold md:text-6xl"
            style="color: var(--primary-text) !important;">
                {{ __('homepage_contact_title') }}
            </h2>
            <p class=" mb-6 font-light"
            style="color: var(--secondary-text) !important;">
                {{ __('homepage_contact_subtitle') }}
            </p>
            <div class="flex flex-row gap-2 max-w-md">
                <input 
                    type="email" 
                    class="bg-gray-50 border text-sm rounded-lg block w-full p-2 bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]" 
                    placeholder="{{ App::getLocale() === 'en' ? 'Enter your email' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите своју мејл адресу' : 'Unesite svoju mejl adresu') }}" 
                    required
                >
                <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center rounded whitespace-nowrap bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                    {{ App::getLocale() === 'en' ? 'Sign up' : (App::getLocale() === 'sr-Cyrl' ? 'Пријава' : 'Prijava') }}
                </a>
            </div>
        </div>
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            <img
                src="{{ asset($contactImage) }}"
                alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}"/>
        </div>
    </div>
</section>