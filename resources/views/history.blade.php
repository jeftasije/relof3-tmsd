<x-guest-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 text-gray-900 dark:text-white">

        <h1 class="text-center text-5xl font-extrabold mb-6">
            {{ App::getLocale() === 'en' ? 'History' : 'Istorijat' }}
        </h1>

        @if(session('success'))
            <div class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @auth
            <form action="{{ route('history.update') }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="content" rows="15"
                    class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white">{{ old('content', $history->content) }}</textarea>

                <div class="flex justify-end gap-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        {{ App::getLocale() === 'en' ? 'Save changes' : 'Sačuvaj izmene' }}
                    </button>

                </div>
            </form>
        @else
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($history->content)) !!}
            </div>
        @endauth

    </div>
</x-guest-layout>
