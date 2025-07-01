<article x-data="{ openReply: false }" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
    <header class="flex items-center justify-between mb-2">
        <div class="flex flex-row items-center">
            @if($comment->is_official)
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $libary_name }}</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class=" ml-1 icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
            </svg>
            @else
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</h3>
            @endif
        </div>
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

    @php
    $isLogged = auth()->check();
    @endphp
    
    <div x-show="openReply" x-transition class="mt-4">
        <form method="POST" action="{{ route('comments.store') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            @if($isLogged === true)
            <div class="relative group">
                <input type="text"
                    name="name"
                    value="{{ $libary_name }}"
                    readonly
                    class="w-full p-3 shadow-sm bg-gray-100 dark:bg-gray-700 dark:text-gray-400 text-gray-500 border border-gray-300 dark:border-gray-600 text-sm rounded-lg cursor-not-allowed"
                    aria-describedby="name-tooltip">

                <div id="name-tooltip"
                    class="absolute top-full mt-1 left-0 w-max max-w-s px-2 py-1 text-s text-white bg-gray-800 rounded shadow opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    @switch(App::getLocale())
                    @case('en') This name is automatically set to the institution name. @break
                    @case('sr-Cyrl') Име је аутоматски подешено на назив установе. @break
                    @default Ime je automatski podešeno na naziv ustanove.
                    @endswitch
                </div>
            </div>
            @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
            @else
            <input type="text" name="name" placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                value="{{ old('name') }}" required
                class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200">
            @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
            @endif
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