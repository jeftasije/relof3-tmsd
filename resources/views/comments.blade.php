<x-guest-layout>
    <div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
        <h2 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white text-center">
            @switch(App::getLocale())
            @case('en') Comments @break
            @case('sr-Cyrl') Коментари @break
            @default Komentari
            @endswitch
        </h2>

        @php
        $isEditor = auth()->check() && auth()->user()->isEditor();
        @endphp

        <form method="POST" action="{{ route('comments.store') }}" class="space-y-6 {{ $isEditor ? 'opacity-50 pointer-events-none' : '' }} mb-10"
            {{ $isEditor ? 'onsubmit=return false;' : '' }}>
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                    value="{{ old('name') }}" required
                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200">
                @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <textarea name="comment" rows="4"
                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200"
                    placeholder="{{ App::getLocale() === 'en' ? 'Write a comment...' : 'Napiši komentar...' }}"
                    required>{{ old('comment') }}</textarea>
                @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit"
                    class="px-5 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    @switch(App::getLocale())
                    @case('en') Send comment @break
                    @case('sr-Cyrl') Пошаљи коментар @break
                    @default Pošalji komentar
                    @endswitch
                </button>
            </div>
        </form>

        @foreach($comments->whereNull('parent_id') as $comment)
            @include('components.comment', ['comment' => $comment])
        @endforeach


        @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
            {{ session('success') }}
        </div>
        @endif

    </div>
</x-guest-layout>