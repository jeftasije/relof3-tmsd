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
                @auth
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
                @endauth
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
            <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[500px_1fr] gap-10 min-h-[calc(100vh-120px)]">
                <!-- Carousel slike -->
                <div 
                    class="flex flex-col h-full"
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
                    <div class="group h-full overflow-hidden rounded-2xl shadow-xl bg-white relative flex-1 flex">
                        <template x-for="(img, idx) in images" :key="idx">
                            <img
                                :src="img"
                                class="object-cover object-left w-full h-full absolute inset-0 transition-all duration-1000"
                                :class="current === idx ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                alt=""
                                style="transition-property: opacity;"
                            />
                        </template>
                    </div>
                </div>
                <!-- Main tekst -->
                <div class="flex flex-col justify-start h-full">
                    <template x-if="editing">
                        <div>
                            <textarea
                                x-ref="mainText"
                                x-model="form.main_text"
                                class="w-full min-h-[350px] h-full rounded-xl border px-4 py-3 text-base font-body"
                                style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-body);"
                            ></textarea>
                        </div>
                    </template>
                    <div 
                        x-show="!editing"
                        class="prose prose-lg max-w-none h-full"
                        style="color: var(--primary-text); font-family: var(--font-body);"
                        x-html="renderedText"
                    ></div>
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
                // Dodaj razmak iza svakog \n koji ima još neki \n iza sebe
                text = text.replace(/\n(?=\n)/g, '\n ');
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
            }
        }
    }
    </script>
</x-guest-layout>
