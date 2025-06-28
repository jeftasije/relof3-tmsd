<x-guest-layout>
    <div 
        class="w-full min-h-screen"
        style="background: var(--primary-bg); color: var(--primary-text);"
        x-data="servicesEditor({
            initial: @js($text),
            updateUrl: '{{ route('services.update') }}',
            uploadImageUrl: '{{ url('/services/upload-image') }}',
            locale: '{{ App::getLocale() }}',
            csrf: '{{ csrf_token() }}'
        })"
    >
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="relative mb-12 flex flex-col items-center">
                <!-- Dugmad za editovanje -->
                <div class="w-full absolute right-0 top-0 flex justify-end items-center" style="height: 70px; min-width:220px; max-width: 240px;">
                    <div class="flex items-center">
                        <button x-show="!editing" @click="startEdit()"
                            class="px-5 py-2 rounded-2xl font-semibold text-base shadow bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white transition-all duration-200"
                            type="button">
                            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                        </button>
                        <template x-if="editing">
                            <div class="flex gap-2">
                                <button @click="saveEdit()"
                                    class="px-4 py-2 rounded-xl font-semibold text-base shadow bg-green-600 hover:bg-green-700 text-white transition-all duration-200"
                                    type="button">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                                <button @click="cancelEdit()"
                                    class="px-4 py-2 rounded-xl font-semibold text-base shadow bg-gray-400 hover:bg-gray-500 text-white transition-all duration-200"
                                    type="button">
                                    {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center">
                    <h1 class="font-extrabold text-3xl sm:text-4xl md:text-5xl mb-3"
                        style="color: var(--primary-text); font-family: var(--font-title);">
                        <template x-if="editing">
                            <input type="text" x-model="form.hero_title" class="text-3xl sm:text-4xl md:text-5xl font-extrabold w-full border px-2 rounded"
                                   style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-title);"/>
                        </template>
                        <span x-show="!editing" x-text="form.hero_title"></span>
                    </h1>
                    <p style="white-space: nowrap;">
                        <template x-if="editing">
                            <input type="text" x-model="form.hero_subtitle" class="w-full border px-2 rounded" style="background: var(--primary-bg); color: var(--primary-text);"/>
                        </template>
                        <span x-show="!editing" x-text="form.hero_subtitle"></span>
                    </p>
                </div>
            </div>

            <!-- Carousel + main_text -->
            <div class="w-full max-w-5xl mx-auto">
                <div class="flex flex-col md:flex-row gap-10 items-stretch">
                    <!-- Carousel slike -->
                    <div 
                        class="md:w-[420px] w-full flex-shrink-0 flex items-start justify-center"
                        x-data="{
                            images: [
                                '{{ asset('images/fotokopirnica.png') }}',
                                '{{ asset('images/knjigoveznica.jpg') }}'
                            ],
                            current: 0,
                            start() {
                                setInterval(() => {
                                    this.current = (this.current + 1) % this.images.length;
                                }, 3500);
                            }
                        }"
                        x-init="start()"
                    >
                        <div class="group overflow-hidden rounded-2xl shadow-xl w-full h-[440px] bg-white relative">
                            <template x-for="(img, idx) in images" :key="idx">
                                <img
                                    :src="img"
                                    class="object-cover object-center w-full h-full absolute inset-0 transition-all duration-1000"
                                    :class="current === idx ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                    alt=""
                                    style="transition-property: opacity;"
                                />
                            </template>
                        </div>
                    </div>
                    <!-- Main tekst -->
                    <div class="flex-1 flex flex-col justify-start">
                        <template x-if="editing">
                            <div>
                                <!-- Toolbar sa 3 tamna dugmeta -->
                                <div class="flex gap-2 mb-2">
                                    <button type="button" class="px-2 py-1 rounded bg-gray-700 text-white hover:bg-gray-800 font-bold"
                                        @click="insertMarkdown('**', '**')"><span style="font-weight:bold">B</span></button>
                                    <button type="button" class="px-2 py-1 rounded bg-gray-700 text-white hover:bg-gray-800 italic"
                                        @click="insertMarkdown('*', '*')"><span style="font-style:italic">I</span></button>
                                    <button type="button" class="px-2 py-1 rounded bg-gray-700 text-white hover:bg-gray-800 underline"
                                        @click="insertMarkdown('<u>', '</u>')"><span style="text-decoration:underline">U</span></button>
                                </div>
                                <textarea
                                    x-ref="mainText"
                                    x-model="form.main_text"
                                    class="w-full min-h-[350px] rounded-xl border px-4 py-3 text-base font-body"
                                    style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-body);"
                                ></textarea>
                                <small class="text-gray-500">
                                    <strong>Markdown podrška:</strong> 
                                    Bold: <code>**bold**</code> &nbsp; Italic: <code>*italic*</code> &nbsp; Podvučeno: <code>&lt;u&gt;podvučeno&lt;/u&gt;</code> &nbsp; Novi red: <code>Enter</code>
                                </small>
                            </div>
                        </template>
                        <div 
                            x-show="!editing"
                            class="prose prose-lg max-w-none"
                            style="color: var(--primary-text); font-family: var(--font-body);"
                            x-html="renderedText"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    @keyframes fadein-img {
        from { opacity: 0; transform: scale(0.95);}
        to   { opacity: 1; transform: scale(1);}
    }
    .animate-fadein-img {
        animation: fadein-img 1s ease forwards;
    }
    .max-w-7xl {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    </style>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
    window.marked.setOptions({ breaks: false });

    function servicesEditor({ initial, updateUrl, uploadImageUrl, locale, csrf }) {
        return {
            form: JSON.parse(JSON.stringify(initial)),
            original: JSON.parse(JSON.stringify(initial)),
            editing: false,
            get renderedText() {
                let text = this.form.main_text ?? "";
                text = text.replace(/\n+/g, '\n');
                text = text.replace(/\n/g, '<br>');
                return window.marked.parse(text);
            },
            startEdit() {
                this.editing = true;
            },
            cancelEdit() {
                this.form = JSON.parse(JSON.stringify(this.original));
                this.editing = false;
            },
            saveEdit() {
                fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        locale: locale,
                        hero_title: this.form.hero_title,
                        hero_subtitle: this.form.hero_subtitle,
                        main_text: this.form.main_text,
                    })
                }).then(res => res.json())
                .then(data => {
                    if (data.success || data.status === "success") {
                        this.original = JSON.parse(JSON.stringify(this.form));
                        this.editing = false;
                        alert('Uspešno sačuvano!');
                    } else {
                        alert('Greška u čuvanju!');
                    }
                }).catch(() => {
                    alert('Greška!');
                });
            },
            insertMarkdown(before, after) {
                let textarea = this.$refs.mainText;
                let val = textarea.value;
                let start = textarea.selectionStart;
                let end = textarea.selectionEnd;
                let selected = val.substring(start, end);

                if (!selected) {
                    this.form.main_text = val.substring(0, start) + before + after + val.substring(end);
                    textarea.selectionStart = textarea.selectionEnd = start + before.length;
                } else {
                    this.form.main_text = val.substring(0, start) + before + selected + after + val.substring(end);
                    textarea.selectionStart = start;
                    textarea.selectionEnd = end + before.length + after.length;
                }
                textarea.focus();
            }
        }
    }
    </script>
</x-guest-layout>
