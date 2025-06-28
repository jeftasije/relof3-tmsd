<x-app-layout>
    <div class="flex flex-col items-center justify-center w-full">
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
        @include('auth.register')
    </div>
</x-app-layout>