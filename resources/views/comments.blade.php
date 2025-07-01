<x-guest-layout>
    <div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full sm:mb-4 md:mb-6"
                style="color: var(--primary-text); font-family: var(--font-title);">
                @switch(App::getLocale())
                @case('en') Blog @break
                @case('sr-Cyrl') Блог @break
                @default Blog
                @endswitch
            </h1>
            <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto"
                style="color: var(--secondary-text); font-family: var(--font-body);">
                @switch(App::getLocale())
                @case('en')
                We invite you to explore our blog, share your thoughts, and read comments from the community.<br>
                Your voice matters—join the conversation!
                @break

                @case('sr-Cyrl')
                Позивамо Вас да прегледате наш блог, поделите своје мишљење и прочитате коментаре заједнице.<br>
                Ваш глас је важан — укључите се у разговор!
                @break

                @default
                Pozivamo Vas da pregledate naš blog, podelite svoje mišljenje i pročitate komentare zajednice.<br>
                Vaš glas je važan — uključite se u razgovor!
                @endswitch
            </p>
        </div>
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

        <p class="text-center mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-300"
            style="font-family: var(--font-title);">
            @switch(App::getLocale())
            @case('en')
            User Comments
            @break

            @case('sr-Cyrl')
            Коментари корисника
            @break

            @default
            Komentari korisnika
            @endswitch
        </p>


        @foreach($comments->whereNull('parent_id') as $comment)
        @include('components.comment', ['comment' => $comment])
        @endforeach

        <div class="flex justify-center mt-6">
            {{ $comments->links() }}
        </div>

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