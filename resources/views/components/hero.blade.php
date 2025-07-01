<section class="relative h-screen w-full">
    <img
        src="{{ asset(__('homepage_hero_image_path')) }}"
        alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}"
        class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4 animate-fadeIn">
        <h1 class="text-5xl font-extrabold mb-4">{{ __('homepage_title') }}</h1>
        <p class="text-3xl font-semibold">
            {{ __('homepage_subtitle') }}
        </p>
    </div>
</section>