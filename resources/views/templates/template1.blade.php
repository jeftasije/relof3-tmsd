<script src="//unpkg.com/alpinejs" defer></script>

@if(Request::is('kreiraj-stranicu*') || Request::is('uredi-stranicu/*'))
<div class="flex flex-col items-center w-7/12 dark:text-white">
    <div
        x-data="{ editing: {{ $isDraft ? 'false' : 'true' }}, title: '{{ addslashes(old('content.title', $content['title'] ?? '')) }}' }" class="mb-6"
        class="mb-6 flex justify-start">
        <div x-show="editing" class="flex items-center gap-2">
            <input
                x-model="title"
                type="text"
                name="content[title]"
                placeholder="{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}"
                class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <button
                type="button"
                @click="editing = false"
                class="px-2 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l5 5l10 -10" />
                </svg>
            </button>
        </div>

        <div class="relative inline-block group">
            <h1
                x-show="!editing"
                @click="editing = true"
                class="text-3xl font-bold text-gray-800 dark:text-white cursor-pointer hover:text-blue-600 hover:underline transition">
                <span x-text="title || '{{ App::getLocale() === 'en' ? 'Title' : (App::getLocale() === 'sr-Cyrl' ? 'Наслов' : 'Naslov') }}'"></span>
            </h1>
            <input type="hidden" name="content[title]" :value="title">
            <svg xmlns="http://www.w3.org/2000/svg"
                x-show="!editing"
                class="absolute top-0 right-[-30px] w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9" />
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
            </svg>
        </div>
    </div>

    <div class="flex items-center justify-center w-full">
        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 ">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <input id="dropzone-file" name="content[image]" type="file" class="hidden" />
        </label>
    </div>
    <div class="my-6 w-9/12">
        <textarea id="large-text-input" rows="4" name="content[text]" class="block w-full p-2.5 text-sm text-gray-900 bg-gray-100 dark:bg-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500  dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ App::getLocale() === 'en' ? 'Write an article here...' : (App::getLocale() === 'sr-Cyrl' ? 'Напишите чланак овде...' : 'Napišite članak ovde...') }}">
        {{ old('content.text', $content['text'] ?? '') }}
        </textarea>
    </div>
</div>
@else
<x-guest-layout>
    <div class="flex flex-col items-center dark:text-white">
        <h1 class="text-3xl font-bold">{{ $content['title'] ?? '' }}</h1>

        @if (!empty($content['image']))
        <img src="{{ asset('storage/' . $content['image']) }}"
            class="rounded shadow max-w-full h-auto" alt="">
        @endif

        <div class="prose">
            {!! nl2br(e($content['text'] ?? '')) !!}
        </div>
    </div>
</x-guest-layout>
@endif