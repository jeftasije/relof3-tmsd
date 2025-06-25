<head>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
</head>
@if(Request::is('kreiraj-stranicu*') || Request::is('uredi-stranicu/*'))
<div class="flex flex-col items-center w-9/12 dark:text-white">
    <div
        x-data="{ editing: {{ $isDraft ? 'false' : 'true' }}, title: '{{ addslashes(old('content.title', $content['title'] ?? '')) }}' }"
        class="my-6 flex justify-start">
        <div x-show="editing" class="flex items-center gap-2">
            <input
                x-model="title"
                type="text"
                name="content[title]"
                form="page-form"
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
            <input type="hidden" name="content[title]" form="page-form" :value="title">
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

    <div id="dropzoneWrapper" class="flex items-center justify-center w-9/12 {{ !isset($content['image']) ? '' : 'hidden' }}">
        <label for="dropzone-file" class="flex flex-col items-center justify-center w-11/12 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 ">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <input id="dropzone-file" name="content[image]" form="page-form" accept="image/png, image/jpeg, image/jpg, image/gif, image/svg+xml" type="file" class="hidden" />
            @if(isset($content['image']))
            <input type="hidden" name="content[image_existing]" form="page-form" value="{{ $content['image'] }}">
            @endif
        </label>
    </div>
    <img
        id="image-preview"
        class="mt-4 w-11/12 h-auto object-contain {{ isset($content['image']) ? '' : 'hidden' }}"
        @if(isset($content['image']))
        src="{{ asset('storage/' . $content['image']) }}"
        @endif />
    <div class="mt-2 flex flex-col items-start">
        <button type="button" id="remove-image-btn" class="px-3 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
            @switch(App::getLocale())
            @case('en') Remove image @break
            @case('sr-Cyrl') Уклони слику @break
            @default Ukloni sliku
            @endswitch
        </button>
    </div>

    <div x-data="{ editingText: false }" class="my-6 w-auto self-start">
        <div
            x-data="{
                editingText: false,
                previewContent: @js(old('content.text', $content['text'] ?? ''))
            }"
            class="my-6 w-11/12">
            <div
                x-show="!editingText"
                @click="editingText = true"
                class="w-full p-4 bg-gray-100 dark:bg-gray-900 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 transition relative group">
                <div x-ref="preview" x-html="previewContent"
                    class="text-gray-800 dark:text-gray-200 whitespace-pre-line text-base leading-relaxed">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute top-0 right-[-30px] w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
            </div>

            <div x-show="editingText" class="my-4 w-full">
                <input id="large-text-input" type="hidden" name="content[text]" form="page-form"
                    value="{{ old('content.text', $content['text'] ?? '') }}">
                <div class="my-6 w-auto">
                    <div class="bg-white">
                        <trix-toolbar id="trix-toolbar"></trix-toolbar>
                    </div>
                    <trix-editor input="large-text-input"
                        toolbar="trix-toolbar"
                        x-ref="trixEditor"
                        class="trix-content mt-3 bg-white dark:bg-gray-800 dark:text-white rounded-lg border-gray-300 dark:border-gray-600 min-h-[300px]">
                    </trix-editor>
                </div>

                <div class="mt-2 flex gap-2">
                    <button type="button"
                        class="px-3 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700"
                        @click="
                            previewContent = $refs.trixEditor.innerHTML;
                            editingText = false;
                        ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<x-guest-layout>
    <div class="flex flex-col items-center w-9/12 mx-auto dark:text-white mt-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">{{ $content['title'] ?? '' }}</h1>

        @if (!empty($content['image']))
        <img src="{{ asset('storage/' . $content['image']) }}"
            class="rounded shadow w-full h-auto object-contain mb-6" alt="">
        @endif

        <form id="edit-page" method="POST" action="{{ route('page.update', $page->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="w-full p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                <div x-data="{ editingText: false }" class="my-6 w-auto self-start">
                    <div
                        x-data="{
                editingText: false,
                previewContent: @js(old('content.text', $content['text'] ?? ''))}"
                        class="my-6 w-11/12">
                        <button x-show="!editingText" type="button" @click="editingText = true" class="ml-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                            @switch(App::getLocale())
                            @case('en') Edit @break
                            @case('sr-Cyrl') Уреди @break
                            @default Uredi
                            @endswitch
                        </button>
                        <div
                            x-show="!editingText"
                            class="w-full p-4 bg-gray-100 dark:bg-gray-900 rounded-lg relative group">
                            <div x-ref="preview" x-html="previewContent"
                                class="text-gray-800 dark:text-gray-200 whitespace-pre-line text-base leading-relaxed">
                            </div>
                        </div>

                        <div x-show="editingText" class="my-4 w-full">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded-lg shadow"
                                @click="
                                    previewContent = $refs.trixEditor.innerHTML;
                                    editingText = false;">
                                @switch(App::getLocale())
                                @case('en') Save @break
                                @case('sr-Cyrl') Сачувај @break
                                @default Sačuvaj
                                @endswitch
                            </button>
                            <input id="large-text-input" type="hidden" name="content[text]" form="edit-page"
                                value="{{ old('content.text', $content['text'] ?? '') }}">
                            <div class="my-6 w-auto">
                                <div class="bg-white">
                                    <trix-toolbar id="trix-toolbar"></trix-toolbar>
                                </div>
                                <trix-editor input="large-text-input"
                                    toolbar="trix-toolbar"
                                    x-ref="trixEditor"
                                    class="trix-content mt-3 bg-white dark:bg-gray-800 dark:text-white rounded-lg border-gray-300 dark:border-gray-600 min-h-[300px]">
                                </trix-editor>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropzone = document.querySelector('label[for="dropzone-file"]');
        const previewImage = document.getElementById('image-preview');
        const dropzoneWrapper = document.getElementById('dropzoneWrapper');
        const fileInput = document.getElementById('dropzone-file');
        const removeBtn = document.getElementById('remove-image-btn');

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                if (previewImage) {
                    previewImage.classList.add('hidden');
                    previewImage.src = '';
                }

                if (fileInput) {
                    fileInput.value = '';
                }

                if (dropzoneWrapper) {
                    dropzoneWrapper.classList.remove('hidden');
                }
            });
        }

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => e.preventDefault());
            dropzone.addEventListener(eventName, (e) => e.stopPropagation());
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-gray-600');
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-gray-600');
        });

        function showImagePreview(file) {
            dropzoneWrapper.classList.add('hidden');
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        dropzone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                if (!file.type.startsWith('image/')) {
                    alert('Only image files are allowed.');
                    return;
                }
                fileInput.files = e.dataTransfer.files;
                showImagePreview(file);
            }
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                showImagePreview(file);
            }
        });
    });
</script>