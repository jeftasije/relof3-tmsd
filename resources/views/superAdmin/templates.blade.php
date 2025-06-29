<x-app-layout>
    <div x-data="{ open: false }" class="min-h-[90vh] w-full flex items-start justify-center p-2 px-4 sm:px-6 lg:px-8" style="background: var(--primary-bg);">
        <div class="w-full max-w-screen-xl mx-auto">
            <div style="background: var(--primary-bg);">
                <div class="p-2 sm:p-4 lg:p-6" style="color: var(--primary-text);">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 text-center" style="color: var(--primary-text); font-family: var(--font-title);">
                        @switch(App::getLocale())
                        @case('en') Templates @break
                        @case('sr-Cyrl') Шаблони @break
                        @default Šabloni
                        @endswitch
                    </h1>

                    <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto" style="color: var(--secondary-text); font-family: var(--font-body);">
                        {{ App::getLocale() === 'en' ? 'Choose the template you want to use when creating a new page.' : (App::getLocale() === 'sr-Cyrl' ? 'Изаберите шаблон који желите да користите приликом креирања нове странице.' : 'Izaberite šablon koji želite da koristite prilikom kreiranja nove stranice.') }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                        @foreach ($templates as $template)
                        <x-template-card :template="$template" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>