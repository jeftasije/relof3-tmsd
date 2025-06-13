<x-guest-layout>
    <div class="w-full bg-white dark:bg-gray-900 px-4 py-12 min-h-screen">
        
        <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mb-12">
            Javne nabavke
        </h1>

        <div class="my-10 flex justify-center">
    <form action="{{ route('procurements.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4 w-full max-w-2xl">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Pretraži dokument..."
            class="flex-grow px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600"
        >
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
            Pretraži
        </button>
    </form>
</div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 space-y-4">
            @forelse ($procurements as $procurement)
                <div class="border-b pb-4">
                    <a 
                        href="{{ asset('storage/' . $procurement->file_path) }}" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="text-lg font-semibold text-blue-600 hover:underline dark:text-blue-400"
                    >
                        {{ $procurement->title }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Trenutno nema dostupnih dokumenata.</p>
            @endforelse
        </div>
    </div>
</x-guest-layout>
