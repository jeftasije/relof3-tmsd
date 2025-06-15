<x-guest-layout>
    <div class="w-full bg-white dark:bg-gray-900 px-4 py-12 min-h-screen">

        <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mb-12">
            Organizaciona struktura
        </h1>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 space-y-4 max-w-3xl mx-auto">
            @if ($structure)
                <div class="border-b pb-4">
                    <a 
                        href="{{ asset('storage/' . $structure->file_path) }}" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="text-lg font-semibold text-blue-600 hover:underline dark:text-blue-400"
                    >
                        {{ $structure->title }}
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center">Trenutno nema dostupnog dokumenta.</p>
            @endif
        </div>
        
    </div>
</x-guest-layout>
