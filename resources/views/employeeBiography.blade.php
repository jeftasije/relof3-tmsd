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

    <div class="min-h-[90vh] w-full bg-white flex items-start justify-center p-2 px-4 sm:px-6 lg:px-12 dark:bg-gray-900" x-data="{ editOpen: false }">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="bg-white dark:bg-gray-900">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-white">

                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl sm:text-4xl font-bold dark:text-white">
                            {{ $employee->translate('position') }}
                        </h1>
                        @auth
                        <button 
                            @click="editOpen = true"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded"
                        >
                            {{ __('Edit') }}
                        </button>
                        @endauth
                    </div>

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
                                @php
                                    $locale = App::getLocale();
                                    $bioKey = $locale === 'en' ? 'biography_translated' : 'biography';
                                    $uniKey = $locale === 'en' ? 'university_translated' : 'university';
                                    $expKey = $locale === 'en' ? 'experience_translated' : 'experience';
                                    $skillsKey = $locale === 'en' ? 'skills_translated' : 'skills';

                                    $skills = $employee->extendedBiography->$skillsKey;
                                    if (!is_array($skills)) {
                                        $skills = [];
                                    }
                                @endphp
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    {{ $employee->extendedBiography->$bioKey }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Univerzitet') }}:</strong> {{ $employee->extendedBiography->$uniKey }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Iskustvo') }}:</strong> {{ $employee->extendedBiography->$expKey }}
                                </p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                    <strong>{{ __('Veštine') }}:</strong>
                                    {{ implode(', ', $skills) }}
                                </p>
                            @else
                                <p class="mb-3 text-gray-700 dark:text-gray-300">Detaljna biografija nije dostupna.</p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('employees.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ $locale === 'en' ? 'Back to Employees' : 'Nazad na zaposlene' }}
                        <svg class="rtl:rotate-180 w-4 h-4 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5H1m0 0l4-4m-4 4l4 4"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal za izmenu -->
        <div
            x-show="editOpen"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: none;"
            @click.self="editOpen = false"
        >
            <div
                x-show="editOpen"
                x-transition
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-lg w-full p-6 relative"
                @keydown.escape.window="editOpen = false"
            >
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
                    {{ __('Edit Employee Details') }}
                </h2>

                <form method="POST" action="{{ route('employees.updateExtendedBiography', $employee->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        // Koja polja prikazujemo u zavisnosti od jezika
                        $bioField = $locale === 'en' ? 'biography_translated' : 'biography';
                        $uniField = $locale === 'en' ? 'university_translated' : 'university';
                        $expField = $locale === 'en' ? 'experience_translated' : 'experience';
                        $skillsField = $locale === 'en' ? 'skills_translated' : 'skills';

                        // Vrednosti za inpute iz baze (ili stara vrednost)
                        $bioValue = old($bioField, $employee->extendedBiography ? $employee->extendedBiography->$bioField : '');
                        $uniValue = old($uniField, $employee->extendedBiography ? $employee->extendedBiography->$uniField : '');
                        $expValue = old($expField, $employee->extendedBiography ? $employee->extendedBiography->$expField : '');
                        $skillsValue = old($skillsField, $employee->extendedBiography ? implode(',', $employee->extendedBiography->$skillsField ?? []) : '');
                    @endphp

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $bioField }}">
                        {{ __('Biography') }}
                    </label>
                    <textarea name="{{ $bioField }}" id="{{ $bioField }}" rows="3" required
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">{{ $bioValue }}</textarea>

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $uniField }}">
                        {{ __('University') }}
                    </label>
                    <input type="text" name="{{ $uniField }}" id="{{ $uniField }}" required
                        value="{{ $uniValue }}"
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $expField }}">
                        {{ __('Experience') }}
                    </label>
                    <textarea name="{{ $expField }}" id="{{ $expField }}" rows="3" required
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">{{ $expValue }}</textarea>

                    <label class="block mb-2 text-gray-700 dark:text-gray-300" for="{{ $skillsField }}">
                        {{ __('Skills') }}
                    </label>
                    <input type="text" name="{{ $skillsField }}" id="{{ $skillsField }}"
                        value="{{ $skillsValue }}"
                        class="w-full p-2 mb-4 border border-gray-300 rounded dark:bg-gray-700 dark:text-white" />
                    <p class="text-xs text-gray-500 mb-4">{{ __('Separate skills with commas') }}</p>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="editOpen = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="px-4 py-2 rounded bg-yellow-500 hover:bg-yellow-600 text-white">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>