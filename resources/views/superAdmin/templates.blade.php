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

                        <!--OVAJ DEO JE SAMO ZA MVP I TREBA GA OBRISATI KASNIJE-->

                        <div class="max-w-sm rounded-lg shadow-sm border transition duration-300 hover:-translate-y-1 hover:scale-105 group overflow-hidden" style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%); border-color: var(--secondary-text); min-height: 300px; display: flex; flex-direction: column;">
                            <div>
                                <img class="rounded-t-lg transform transition-transform duration-300 group-hover:scale-105" src="{{ asset('storage/templates/template2.png') }}" />
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-grow">
                                <div>
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight" style="color: var(--primary-text); font-family: var(--font-title);">
                                        Šablon 2
                                    </h5>
                                    <p class="mb-3 font-normal" style="color: var(--secondary-text); font-family: var(--font-body);">
                                        Ovaj šablon nije obuhvaćen MVP rešenjem.
                                    </p>
                                </div>
                                <a href="#" class="w-fit inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg"
                                    style="background: var(--accent); color: #fff;">
                                    {{ App::getLocale() === 'en' ? 'Use this template' : (App::getLocale() === 'sr-Cyrl' ? 'Користи овај шаблон' : 'Koristi ovaj šablon') }}
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="max-w-sm rounded-lg shadow-sm border transition duration-300 hover:-translate-y-1 hover:scale-105 group overflow-hidden" style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%); border-color: var(--secondary-text); display: flex; flex-direction: column;">
                            <div>
                                <img class="rounded-t-lg transform transition-transform duration-300 group-hover:scale-105" src="{{ asset('storage/templates/template3.png') }}" />
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-grow">
                                <div>
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight" style="color: var(--primary-text); font-family: var(--font-title);">
                                        Šablon 3
                                    </h5>
                                    <p class="mb-3 font-normal" style="color: var(--secondary-text); font-family: var(--font-body);">
                                        Ovaj šablon nije obuhvaćen MVP rešenjem.
                                    </p>
                                </div>
                                <a href="#" class="w-fit inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg"
                                    style="background: var(--accent); color: #fff;">
                                    {{ App::getLocale() === 'en' ? 'Use this template' : (App::getLocale() === 'sr-Cyrl' ? 'Користи овај шаблон' : 'Koristi ovaj šablon') }}
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!--KRAJ BRISANJA-->


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>