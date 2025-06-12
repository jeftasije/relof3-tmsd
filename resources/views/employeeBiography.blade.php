<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalji o zaposlenom') }}
        </h2>
    </x-slot>

    <div class="py-12 sm:py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-8 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl">
                <div class="p-6 sm:p-10 lg:p-16 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-6 text-center sm:text-left">
                        {{ $employee->position }}
                    </h1>

                    <div class="flex flex-col lg:flex-row items-start gap-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-6 sm:p-10 lg:p-12 mb-10">
                        <img
                            class="object-cover w-full lg:w-[28rem] h-[36rem] rounded-lg"
                            src="{{ asset($employee->image_path) }}"
                            alt="{{ $employee->name }}"
                            onerror="this.src='{{ asset('/images/default.jpg') }}';"
                        />
                        <div class="flex-1">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $employee->name }}
                            </h2>
                            @if ($employee->extendedBiography)
                                <p class="mb-4 text-gray-700 dark:text-gray-300">{{ $employee->extendedBiography->biography }}</p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300"><strong>Univerzitet:</strong> {{ $employee->extendedBiography->university }}</p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300"><strong>Iskustvo:</strong> {{ $employee->extendedBiography->experience }}</p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>Veštine:</strong>
                                    {{ implode(', ', is_array($employee->extendedBiography->skills) ? $employee->extendedBiography->skills : json_decode($employee->extendedBiography->skills, true) ?? []) }}
                                </p>
                            @else
                                <p class="mb-3 text-gray-700 dark:text-gray-300">Detaljna biografija nije dostupna.</p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('employees.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Nazad na zaposlene
                        <svg class="rtl:rotate-180 w-4 h-4 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5H1m0 0l4-4m-4 4l4 4"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
