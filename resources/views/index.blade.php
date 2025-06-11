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
                            <div class="bg-white shadow-md rounded-2xl overflow-hidden flex flex-col">
                                <div class="w-full h-48 overflow-hidden">
                                    <img
                                        src="{{ asset($employee->image_path) }}"
                                        alt="{{ $employee->name }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.src='{{ asset('/images/default.jpg') }}';"
                                    >
                                </div>
                                <div class="p-4 flex flex-col flex-grow min-h-0">
                                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">{{ $employee->name }}</h2>
                                    <p class="text-sm sm:text-base text-gray-900 dark:text-gray-300">{{ $employee->position }}</p>
                                    <p class="mt-2 text-sm text-gray-900 dark:text-gray-400 flex-grow">{{ $employee->biography }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
