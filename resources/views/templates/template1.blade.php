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

    @php
    $placeholderText = match (App::getLocale()) {
    'en' => 'Write your article here...',
    'sr-Cyrl' => 'Напишите чланак овде...',
    default => 'Napišite članak ovde...',
    };
    @endphp

    <div
        x-data="{
        editingText: true,
        previewContent: @js(old('content.text', $content['text'] ?? '')),
        init() {
            if (!this.previewContent.trim()) {
                this.previewContent = '<p class=\'text-gray-400\'>{{ $placeholderText }}</p>';
            }
        }
    }"
        x-init="init()"
        class="my-6 w-10/12">
        <div
            x-show="!editingText"
            @click="editingText = true"
            class="w-full p-4 bg-gray-100 dark:bg-gray-900 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 transition relative group">
            <div
                x-ref="preview"
                x-html="previewContent"
                class="text-gray-800 dark:text-gray-200 whitespace-pre-line text-base leading-relaxed"></div>

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
                    let html = $refs.trixEditor.innerHTML.trim();
                    previewContent = html ? html : '<p class=\'text-gray-400\'>{{ $placeholderText }}</p>';
                    editingText = false;
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>
@else
<x-guest-layout>
    <div class="flex flex-col items-center w-9/12 mx-auto mt-6" style="background: var(--primary-bg); color: var(--primary-text);">
        <h1 class="text-3xl font-bold mb-4" style="color: var(--primary-text); font-family: var(--font-title);">{{ $content['title'] ?? '' }}</h1>

        @if (!empty($content['image']))
        <img src="{{ asset('storage/' . $content['image']) }}"
            class="rounded shadow w-full h-auto object-contain mb-6" alt="">
        @endif

        <div style="font-family: var(--font-body);">
            {!! $content['text'] !!}
        </div>

        @auth
        <button id="open-modal" type="button" class="ml-4 font-semibold py-2 px-4 rounded-lg shadow"
                style="background: var(--accent); color: #fff;">
            @switch(App::getLocale())
            @case('en') Edit @break
            @case('sr-Cyrl') Уреди @break
            @default Uredi
            @endswitch
        </button>
        @endauth
        
        <!-- Modal -->
        <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0,0,0,0.5);">
            <form id="edit-form" method="POST" action="{{ route('page.update', $page->slug) }}" enctype="multipart/form-data"
                class="rounded-lg p-6 w-11/12 md:w-3/4 lg:w-1/2 relative flex flex-col gap-4"
                style="background: var(--primary-bg); color: var(--primary-text);">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-semibold" style="color: var(--primary-text); font-family: var(--font-title);">
                    @switch(App::getLocale())
                    @case('en') Edit content @break
                    @case('sr-Cyrl') Уредите садржај @break
                    @default Uredite sadržaj
                    @endswitch
                </h2>
                @switch(App::getLocale())
                @case('en')
                <p class="text-sm" style="color: var(--secondary-text); font-family: var(--font-body);">
                    The text you enter in Serbian is automatically converted to the other Serbian script and translated into English.
                    We recommend entering the content first in Serbian, saving the page, and then switching to English to review and adjust the translation if needed.
                </p>
                @break
                @case('sr-Cyrl')
                <p class="text-sm" style="color: var(--secondary-text); font-family: var(--font-body);">
                    Текст који унесете на српском се аутоматски конвертује у друго српско писмо и преводи на енглески језик.
                    Препоручујемо да прво унесете садржај на српском, сачувате страницу, а затим се пребаците на енглески ради прегледа и корекције превода.
                </p>
                @break
                @default
                <p class="text-sm" style="color: var(--secondary-text); font-family: var(--font-body);">
                    Tekst koji unesete na srpskom se automatski konvertuje u drugo srpsko pismo i prevodi na engleski jezik.
                    Preporučujemo da najpre unesete sadržaj na srpskom, sačuvate stranicu, a zatim se prebacite na engleski kako biste proverili i eventualno izmenili prevod.
                </p>
                @endswitch

                <div class="flex gap-4" style="color: var(--secondary-text);">
                    <label>
                        <input type="radio" name="language" value="sr" checked class="w-4 h-4 focus:ring-2"
                               style="background: var(--primary-bg); border-color: var(--secondary-text);">
                        @switch(App::getLocale())
                        @case('en') Serbian @break
                        @case('sr-Cyrl') Српски @break
                        @default Srpski
                        @endswitch
                    </label>
                    <label>
                        <input type="radio" name="language" value="en" class="w-4 h-4 focus:ring-2"
                               style="background: var(--primary-bg); border-color: var(--secondary-text);">
                        @switch(App::getLocale())
                        @case('en') English @break
                        @case('sr-Cyrl') Енглески @break
                        @default Engleski
                        @endswitch
                    </label>
                </div>

                <input type="hidden" name="content[text]" id="input-sr-hidden">
                <input type="hidden" name="content_en[text]" id="input-en-hidden">

                <div id="editor-sr-wrapper">
                    <div style="background: var(--primary-bg);">
                        <trix-toolbar id="trix-toolbar-sr"></trix-toolbar>
                    </div>
                    <trix-editor input="trix-input-sr" toolbar="trix-toolbar-sr"
                        class="trix-content rounded-lg border min-h-[300px] mt-2"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text); font-family: var(--font-body);">
                    </trix-editor>
                    <input id="trix-input-sr" type="hidden" value="{{ old('content.text', $content['text'] ?? '') }}">
                </div>
                <div id="editor-en-wrapper" class="hidden">
                    <div style="background: var(--primary-bg);">
                        <trix-toolbar id="trix-toolbar-en"></trix-toolbar>
                    </div>
                    <trix-editor input="trix-input-en" toolbar="trix-toolbar-en"
                        class="trix-content rounded-lg border min-h-[300px] mt-2"
                        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text); font-family: var(--font-body);">
                    </trix-editor>
                    <input id="trix-input-en" type="hidden" value="{{ old('content_en.text', $page->content_en['text'] ?? '') }}">
                </div>

                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" id="cancel-modal" class="px-4 py-2 rounded"
                            style="background: var(--secondary-text); color: #fff;">
                        @switch(App::getLocale())
                        @case('en') Cancel @break
                        @case('sr-Cyrl') Откажи @break
                        @default Otkaži
                        @endswitch
                    </button>
                    <button type="submit" class="px-4 py-2 rounded"
                            style="background: var(--accent); color: #fff;">
                        @switch(App::getLocale())
                        @case('en') Save @break
                        @case('sr-Cyrl') Сачувај @break
                        @default Sačuvaj
                        @endswitch
                    </button>
                </div>
            </form>
        </div>
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


    document.addEventListener('DOMContentLoaded', function() {
        const openModal = document.getElementById('open-modal');
        const modal = document.getElementById('edit-modal');
        const cancelBtn = document.getElementById('cancel-modal');

        const editorSrWrapper = document.getElementById('editor-sr-wrapper');
        const editorEnWrapper = document.getElementById('editor-en-wrapper');

        const srInputHidden = document.getElementById('input-sr-hidden');
        const enInputHidden = document.getElementById('input-en-hidden');

        const trixInputSr = document.getElementById('trix-input-sr');
        const trixInputEn = document.getElementById('trix-input-en');

        function setTrixContent(editorElement, hiddenInput, content) {
            hiddenInput.value = content;
            editorElement.editor.loadHTML(content);
        }

        openModal.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTrixContent(document.querySelector('#editor-sr-wrapper trix-editor'), trixInputSr, trixInputSr.value);
            setTrixContent(document.querySelector('#editor-en-wrapper trix-editor'), trixInputEn, trixInputEn.value);

            editorSrWrapper.classList.remove('hidden');
            editorEnWrapper.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        });

        document.querySelectorAll('input[name="language"]').forEach((radio) => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'sr') {
                    editorSrWrapper.classList.remove('hidden');
                    editorEnWrapper.classList.add('hidden');
                    setTrixContent(document.querySelector('#editor-sr-wrapper trix-editor'), trixInputSr, trixInputSr.value);
                } else {
                    editorSrWrapper.classList.add('hidden');
                    editorEnWrapper.classList.remove('hidden');
                    setTrixContent(document.querySelector('#editor-en-wrapper trix-editor'), trixInputEn, trixInputEn.value);
                }
            });
        });


        document.getElementById('edit-form').addEventListener('submit', function() {
            srInputHidden.value = trixInputSr.value;
            enInputHidden.value = trixInputEn.value;
        });
    });
</script>