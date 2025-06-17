<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full p-4" id="header">
            <div></div>
            <button id="theme-toggle" class="p-2 rounded-full text-gray-900 hover:bg-gray-200 focus:outline-none dark:text-white dark:hover:bg-gray-700">
                <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="min-h-[90vh] w-full bg-white flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12 dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="bg-white dark:bg-gray-900">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-white">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-2 text-center sm:text-left dark:text-white">
                        {{ $employee->translate('position') }}
                    </h1>

                    <div class="flex flex-col lg:flex-row items-start gap-8 bg-white dark:bg-gray-900 p-6 sm:p-10 lg:p-12 mb-10">

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
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    {{ $employee->extendedBiography->translate('biography') }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Univerzitet') }}:</strong> {{ $employee->extendedBiography->translate('university') }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Iskustvo') }}:</strong> {{ $employee->extendedBiography->translate('experience') }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Veštine') }}:</strong>
                                    {{ implode(', ',
                                        is_array($employee->extendedBiography->translate('skills'))
                                            ? $employee->extendedBiography->translate('skills')
                                            : []
                                    ) }}
                                </p>
                            @else
                                <p class="mb-3 text-gray-700 dark:text-gray-300">Detaljna biografija nije dostupna.</p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('employees.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ App::getLocale() === 'en' ? 'Back to Employees' : 'Nazad na zaposlene' }}
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