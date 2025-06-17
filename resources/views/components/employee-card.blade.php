<div class="max-w-sm h-full bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col" style="box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);">
    <a href="{{ route('employees.show', $employee->id) }}" class="overflow-hidden rounded-t-lg group" style="box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);">
        <img
            class="w-full h-48 object-cover transform transition-transform duration-300 group-hover:scale-105"
            src="{{ asset($employee->image_path) }}"
            alt="{{ $employee->name }}"
            onerror="this.src='{{ asset('/images/default.jpg') }}';"
        />
    </a>
    <div class="p-5 flex flex-col flex-grow justify-between" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1) inset;">
        <div>
            <a href="{{ route('employees.show', $employee->id) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);">
                    {{ $employee->name }}
                </h5>
            </a>
            <p class="mb-2 font-medium text-gray-700 dark:text-gray-300" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);">
                {{ $employee->translated_position }}
            </p>
            <p class="mb-4 font-normal text-gray-700 dark:text-gray-400" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);">
                {{ $employee->translated_biography }}
            </p>
        </div>

        <a href="{{ route('employees.show', $employee->id) }}"
           class="mt-auto self-start inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);">
            {{ App::getLocale() === 'en' ? 'Show more' : 'Prikaži više' }}
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
        </a>
    </div>
</div>