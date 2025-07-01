<article x-data="{ openReply: false }" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
    <header class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</h3>
        <time datetime="{{ $comment->created_at }}" class="text-sm text-gray-500 dark:text-gray-400">
            {{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d. F Y.') }}
        </time>
    </header>

    <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>

    @if ($comment->replies->count())
    <div class="text-sm text-gray-500 mt-1">
        @switch(App::getLocale())
        @case('en')
        {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
        @break
        @case('sr-Cyrl')
        {{ $comment->replies->count() }} одговор{{ $comment->replies->count() === 1 ? '' : 'а' }}
        @break
        @default
        {{ $comment->replies->count() }} odgovor{{ $comment->replies->count() === 1 ? '' : 'a' }}
        @endswitch
    </div>
    @endif

    @if (is_null($comment->parent_id))
    <button
        @click="openReply = !openReply"
        class="text-blue-600 text-sm mt-2 hover:underline">
        <template x-if="!openReply">
            <span>
                @switch(App::getLocale())
                @case('en') Reply @break
                @case('sr-Cyrl') Одговори @break
                @default Odgovori
                @endswitch
            </span>
        </template>
        <template x-if="openReply">
            <span>
                @switch(App::getLocale())
                @case('en') Cancel @break
                @case('sr-Cyrl') Откажи @break
                @default Otkaži
                @endswitch
            </span>
        </template>
    </button>

    <div x-show="openReply" x-transition class="mt-4">
        <form method="POST" action="{{ route('comments.store') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div>
                <input type="text" name="name" required
                    placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                    class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <textarea name="comment" rows="2" required
                    placeholder="{{ App::getLocale() === 'en' ? 'Write a reply...' : 'Napiši odgovor...' }}"
                    class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    @switch(App::getLocale())
                    @case('en') Send reply @break
                    @case('sr-Cyrl') Пошаљи одговор @break
                    @default Pošalji odgovor
                    @endswitch
                </button>
            </div>
        </form>
    </div>
    @endif

    @if($comment->replies->count())
    <div x-data="{ showReplies: false }" class="mt-4">
        <button @click="showReplies = !showReplies" class="text-sm text-blue-600 hover:underline">
            <template x-if="!showReplies">
                <span>
                    @switch(App::getLocale())
                    @case('en') Show replies @break
                    @case('sr-Cyrl') Прикажи одговоре @break
                    @default Prikaži odgovore
                    @endswitch
                </span>
            </template>
            <template x-if="showReplies">
                <span>
                    @switch(App::getLocale())
                    @case('en') Hide replies @break
                    @case('sr-Cyrl') Сакриј одговоре @break
                    @default Sakrij odgovore
                    @endswitch
                </span>
            </template>
        </button>

        <div x-show="showReplies" x-transition class="ml-6 mt-4 space-y-4">
            @foreach($comment->replies as $reply)
            @include('components.comment', ['comment' => $reply])
            @endforeach
        </div>
    </div>
    @endif
</article>