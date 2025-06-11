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
