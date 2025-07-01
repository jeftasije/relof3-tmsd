<x-guest-layout>
    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);" x-data="servicesEditor({
            initial: @js($text),
            updateUrl: '{{ route('services.update') }}',
            uploadImageUrl: '{{ route('services.uploadImage') }}',
            locale: '{{ App::getLocale() }}',
            csrf: '{{ csrf_token() }}'
        })" x-init="startCarousel()">
        <div class="max-w-7xl mx-auto px-4 py-12">

            <!-- Uspešan alert -->
            <div x-show="successMessage" x-transition @click="successMessage = ''"
                class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg cursor-pointer"
                style="top: 12%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 220px; text-align: center;"
                x-text="successMessage"></div>

            <div class="relative mb-12 flex flex-col items-center">
                @auth
                    <div class="w-full absolute right-0 top-0 flex justify-end items-center"
                        style="height: 70px; min-width:220px; max-width: 240px;">
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
                            <input type="text" x-model="form.hero_title"
                                class="text-3xl sm:text-4xl md:text-5xl font-extrabold w-full border px-2 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-title);" />
                        </template>
                        <span x-show="!editing" x-text="form.hero_title"></span>
                    </h1>
                    <p style="white-space: nowrap;">
                        <template x-if="editing">
                            <input type="text" x-model="form.hero_subtitle" class="w-full border px-2 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text);" />
                        </template>
                        <span x-show="!editing" x-text="form.hero_subtitle"></span>
                    </p>
                </div>
            </div>

            <!-- Carousel + main_text -->
            <div
                class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[500px_1fr] gap-10 min-h-[calc(100vh-120px)]">
                <!-- Carousel slike -->
                <div class="flex flex-col h-full">
                    <template x-if="!editing">
                        <div class="group h-full overflow-hidden rounded-2xl shadow-xl bg-white relative flex-1 flex">
                            <template x-for="(img, idx) in form.images" :key="img">
                                <img :src="img"
                                    class="object-cover object-left w-full h-full absolute inset-0 transition-all duration-1000"
                                    :class="currentImage === idx ? 'opacity-100 z-10' : 'opacity-0 z-0'" alt=""
                                    style="transition-property: opacity;" />
                            </template>
                        </div>
                    </template>
                    <template x-if="editing">
                        <div class="h-full">
                            <!-- Grid prikaz slika, 2 u redu -->
                            <div class="grid grid-cols-2 gap-5">
                                <template x-for="(img, idx) in form.images" :key="img + idx">
                                    <div class="relative">
                                        <img :src="img" class="h-36 w-full object-cover rounded shadow" />
                                        <button type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow"
                                            @click="removeImage(idx)">
                                            &times;
                                        </button>
                                    </div>
                                </template>
                                <!-- Dodaj nove slike -->
                                <label
                                    class="h-36 w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded cursor-pointer hover:border-blue-500 transition"
                                    title="Dodaj slike">
                                    <svg class="w-10 h-10 text-gray-400 mb-1" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="text-xs text-gray-400">Dodaj slike</span>
                                    <input type="file" class="hidden" multiple @change="onImageSelect" />
                                </label>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Main tekst -->
                <div class="flex flex-col justify-start h-full">
                    <template x-if="editing">
                        <div class="flex flex-col h-full">
                            <textarea x-ref="mainText" x-model="form.main_text"
                                class="w-full min-h-[65vh] rounded-xl border px-4 py-3 text-base font-body"
                                style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-body); resize:vertical;"></textarea>
                        </div>
                    </template>
                    <div x-show="!editing" class="prose prose-lg max-w-none h-full"
                        style="color: var(--primary-text); font-family: var(--font-body);" x-html="renderedText"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadein-img {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
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
                currentImage: 0,
                intervalId: null,
                successMessage: '',

                get renderedText() {
                    let text = this.form.main_text ?? "";
                    text = text.replace(/\n(?=\n)/g, '\n ');
                    text = text.replace(/\n+/g, '\n');
                    text = text.replace(/\n/g, '<br>');
                    return window.marked.parse(text);
                },

                startEdit() {
                    this.editing = true;
                    if (this.intervalId) clearInterval(this.intervalId);
                },

                cancelEdit() {
                    this.form = JSON.parse(JSON.stringify(this.original));
                    this.editing = false;
                    this.currentImage = 0;
                    this.startCarousel();
                },

                saveEdit() {
                    const files = this.newImages || [];
                    const uploadPromises = Array.from(files).map(file => {
                        const formData = new FormData();
                        formData.append('image', file);
                        formData.append('_token', csrf);
                        return fetch(uploadImageUrl, { method: 'POST', body: formData })
                            .then(resp => resp.json())
                            .then(data => data.image_path ? data.image_path : null);
                    });

                    Promise.all(uploadPromises).then(newImagePaths => {
                        this.form.images = this.form.images.filter(img => !img.startsWith('data:'));
                        this.form.images = [...this.form.images, ...newImagePaths.filter(Boolean)];

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
                                images: this.form.images,
                            })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success || data.status === "success") {
                                    this.original = JSON.parse(JSON.stringify(this.form));
                                    this.editing = false;
                                    this.currentImage = 0;
                                    this.newImages = [];
                                    this.startCarousel();

                                    this.successMessage = 'Uspešno sačuvano!';
                                    setTimeout(() => this.successMessage = '', 4000);

                                } else {
                                    alert('Greška u čuvanju!');
                                }
                            })
                            .catch(() => alert('Greška!'));
                    });
                },


                newImages: [],

                onImageSelect(e) {
                    const files = Array.from(e.target.files);
                    this.newImages = [...this.newImages, ...files];
                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            this.form.images.push(ev.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                    e.target.value = '';
                },

                removeImage(idx) {
                    this.form.images.splice(idx, 1);
                },

                startCarousel() {
                    if (this.intervalId) clearInterval(this.intervalId);
                    if (!this.editing && this.form.images.length > 1) {
                        this.intervalId = setInterval(() => {
                            this.currentImage = (this.currentImage + 1) % this.form.images.length;
                        }, 3500);
                    }
                }
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('servicesEditor', servicesEditor);
        });
    </script>
</x-guest-layout>