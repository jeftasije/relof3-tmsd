<x-guest-layput>
<div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
        <h2 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white text-center">
            @switch(App::getLocale())
                @case('en') Comments @break
                @case('sr-Cyrl') Коментари @break
                @default Komentari
            @endswitch
        </h2>
            @if(session('success_comment'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                {{ session('success_comment') }}
            </div>
            @endif

            <form method="POST" action="{{ route('comments.store') }}" class="mb-6 space-y-4">
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
                            @case('en') Send comment  @break
                            @case('sr-Cyrl') Пошаљи коментар @break
                            @default Pošalji komentar
                        @endswitch
                    </button>
                </div>
            </form>


            
            @foreach($comments as $comment)
                <article class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <header class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</h3>
                        <time datetime="{{ $comment->created_at }}" class="text-sm text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d. F Y.') }}
                        </time>
                    </header>
                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                </article>
            @endforeach


    </div>
</x-guest-layout>

