<article x-data="{ openReply: false }" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow mb-4" style="background: var(--primary-bg); color: var(--primary-text);">
    <header class="flex items-center justify-between mb-2">
        <div class="flex flex-row items-center">
            @if($comment->is_official)
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class=" ml-1 icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check" style="color: var(--accent);">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
            </svg>
            <h3 class="ml-2 text-lg font-semibold text-gray-900 dark:text-white" style="color: var(--primary-text);">{{ $libary_name }}</h3>
            @else
            <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600" style="background: var(--secondary-text);">
                <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--primary-text);">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="ml-2 text-lg font-semibold text-gray-900 dark:text-white" style="color: var(--primary-text);">{{ $comment->name }}</h3>
            @endif
        </div>
        <time datetime="{{ $comment->created_at }}" class="text-xs italic text-gray-400 dark:text-gray-500" style="color: var(--secondary-text);">
            {{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d. F Y.') }}
        </time>
    </header>

    @php
    $locale = App::getLocale();
    $languageLabel = match($locale) {
    'en' => 'Translate to English',
    'sr-Cyrl' => 'Преведи на ћирилицу',
    default => 'Prevedi na latinicu',
    };
    @endphp

    <div x-data="{ showTranslated: false }">
        <div class="flex flex-row justify-between p-4 rounded bg-gray-50 dark:bg-gray-700 mt-2" style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
            <p x-show="!showTranslated" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200" style="color: var(--primary-text);">
                {{ $comment->comment }}
            </p>
            <p x-show="showTranslated" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-gray-800 dark:text-gray-200" style="color: var(--primary-text);">
                {{ $comment->translate('comment') }}
            </p>
            @auth
            <button class="delete-comment-btn text-red-500 transition duration-300 hover:-translate-y-1 hover:scale-105" title="
                @switch(App::getLocale())
                @case('en') Delete @break
                @case('sr-Cyrl') Обриши @break
                @default Obriši
                @endswitch"
                data-comment-id="{{ $comment->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>
            @endauth
        </div>
        <button
            @click="showTranslated = !showTranslated"
            class="text-sm hover:underline mb-2" style="color: var(--accent);">
            <template x-if="!showTranslated">
                <span>{{ $languageLabel }}</span>
            </template>
            <template x-if="showTranslated">
                <span>
                    @switch($locale)
                    @case('en') Show original @break
                    @case('sr-Cyrl') Прикажи оригинал @break
                    @default Prikaži original
                    @endswitch
                </span>
            </template>
        </button>
    </div>

    @if (is_null($comment->parent_id))
    <button
        @click="openReply = !openReply"
        class="color-[var(--secondary-text)] text-sm mt-2 hover:underline">
        <template x-if="!openReply">
            <button class="px-3 py-2 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
                @switch(App::getLocale())
                @case('en') Reply @break
                @case('sr-Cyrl') Одговори @break
                @default Odgovori
                @endswitch
            </button>
        </template>
        <template x-if="openReply">
            <button class="px-3 py-2 rounded bg-gray-400 hover:bg-gray-500">
                @switch(App::getLocale())
                @case('en') Cancel @break
                @case('sr-Cyrl') Откажи @break
                @default Otkaži
                @endswitch
            </button>
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
                    class="w-full p-3 shadow-sm text-sm rounded-lg cursor-not-allowed  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                    aria-describedby="name-tooltip">

                <div id="name-tooltip"
                    class="absolute top-full mt-1 left-0 w-max max-w-s px-2 py-1 text-s text-white bg-gray-800 rounded shadow opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                    style="background: var(--secondary-text); color: #fff;">
                    @switch(App::getLocale())
                    @case('en') This name is automatically set to the institution name. @break
                    @case('sr-Cyrl') Име је аутоматски подешено на назив установе. @break
                    @default Ime je automatski podešeno na naziv ustanove.
                    @endswitch
                </div>
            </div>
            @error('name') <p class="text-red-500 text-sm col-span-2" style="color: var(--accent);">{{ $message }}</p> @enderror
            @else
            <input type="text" name="name" placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                value="{{ old('name') }}" required
                class="w-full p-3 shadow-sm text-sm rounded-lg focus:border-grey-200  bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
            @error('name') <p class="text-red-500 text-sm col-span-2" style="color: var(--accent);">{{ $message }}</p> @enderror
            @endif
            <div>
                <textarea name="comment" rows="2" required
                    placeholder="{{ App::getLocale() === 'en' ? 'Write a reply...' : 'Napiši odgovor...' }}"
                    class="w-full p-2 border rounded bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="px-4 py-2 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
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
        <button @click="showReplies = !showReplies" class="text-sm text-blue-600 hover:underline" style="color: var(--accent);">
            <template x-if="!showReplies">
                <span>
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