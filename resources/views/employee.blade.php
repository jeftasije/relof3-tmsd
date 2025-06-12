<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Naš Tim') }}
        </h2>
    </x-slot>

    <div class="py-12 sm:py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-8 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl">
                <div class="p-6 sm:p-10 lg:p-16 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-6 text-center sm:text-left">Naš tim</h1>
                    <p class="text-gray-900 dark:text-gray-300 mb-8 sm:mb-12 text-base sm:text-lg text-center sm:text-left max-w-4xl mx-auto sm:mx-0">
                        Mi smo dinamična grupa pojedinaca koji su strastveni prema onome što radimo i posvećeni pružanju najboljih rezultata za naše klijente.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-12">
                        @foreach ($employees as $employee)
                            <x-employee-card :employee="$employee" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
