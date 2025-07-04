<x-guest-layout>
    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);"
        x-data="servicesEditor({
            initial: @js($text),
            updateUrl: '{{ route('services.update') }}',
            uploadImageUrl: '{{ route('services.uploadImage') }}',
            locale: '{{ App::getLocale() }}',
            csrf: '{{ csrf_token() }}'
        })" x-init="startCarousel()">
        <div class="max-w-7xl mx-auto px-4 py-12">

            <div x-show="successMessage" x-transition @click="successMessage = ''"
                class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg cursor-pointer"
                style="top: 12%; transform: translateX(-50%); background: #22c55e; color: #fff; font-weight: 600; letter-spacing: 0.03em; min-width: 220px; text-align: center;"
                x-text="successMessage"></div>

            <div class="relative mb-12 flex flex-col items-center">
                @auth
                <div class="w-full absolute right-0 top-0 flex flex-col items-end"
                    style="height: 90px; min-width:220px; max-width: 240px;">
                    <!-- HELP dugme -->
                    <button @click="$store.modals.openHelp()"
                        class="flex items-center gap-2 mb-2 px-2 py-1 text-base font-medium transition duration-150 ease-in-out
                                rounded-xl border-2 border-[var(--secondary-text)] hover:border-[var(--primary-bg)] shadow-md
                                bg-[var(--primary-bg)] hover:bg-gray-100 dark:hover:bg-gray-800"
                        style="color: var(--primary-text);"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <circle cx="12" cy="12" r="9" stroke-width="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17l0 .01" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 13.5a1.5 1.5 0 0 1 1-1.5a2.6 2.6 0 1 0-3-4" />
                        </svg>
                        <span>
                            {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                        </span>
                    </button>
                    <!-- EDIT dugme -->
                    <div class="flex items-center gap-1">
                        <button x-show="!editing" @click="startEdit()"
                            class="px-5 py-2 rounded text-base shadow
                                        bg-[var(--accent)]
                                        hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]
                                        transition-all duration-200"
                            type="button">
                            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                        </button>
                        <template x-if="editing">
                            <div class="flex gap-2">
                                <button @click="saveEdit()"
                                    class="px-4 py-2 rounded text-base shadow
                bg-[var(--accent)]
                hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]
                transition-all duration-200"
                                    type="button">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                                <button @click="cancelEdit()"
                                    class="px-4 py-2 rounded text-base shadow
                bg-gray-400
                hover:bg-gray-500
                transition-all duration-200"
                                    type="button">
                                    {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                                </button>
                            </div>
                        </template>

                    </div>

                </div>
                @endauth
                <div class="w-full flex flex-col items-center">
                    <h1 class="font-extrabold text-2xl sm:text-3xl md:text-4xl mb-3"
                        style="color: var(--primary-text); font-family: var(--font-title);">
                        <template x-if="editing">
                            <input type="text" x-model="form.hero_title"
                                class="text-2xl sm:text-3xl md:text-4xl font-extrabold w-full border px-2 rounded"
                                style="background: var(--primary-bg); color: var(--primary-text); font-family: var(--font-title) !important;" />
                        </template>
                        <h1 x-show="!editing" x-text="form.hero_title" class="font-extrabold text-2xl sm:text-3xl md:text-4xl mb-3"
                            style="color: var(--primary-text); font-family: var(--font-title);"></h1>
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

            <div
                class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[500px_1fr] gap-10 min-h-[calc(100vh-120px)]">
                <div class="flex flex-col h-full">
                    <template x-if="!editing">
                        <div
                            class="group overflow-hidden rounded-2xl shadow-xl bg-white relative flex w-full aspect-[1/1] sm:aspect-auto sm:flex-1">
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
                            <div class="grid grid-cols-2 gap-5">
                                <template x-for="(img, idx) in form.images" :key="img + idx">
                                    <div class="relative">
                                        <img :src="img" class="h-36 w-full object-cover rounded shadow" />
                                        <button type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow
                                        hover:bg-red-600 transition"
                                            @click="removeImage(idx)">
                                            &times;
                                        </button>

                                    </div>
                                </template>
                                <label
                                    class="h-36 w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded cursor-pointer hover:border-blue-500 transition"
                                    title="Dodaj slike">
                                    <svg class="w-10 h-10 text-gray-400 mb-1" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="text-xs text-gray-400">Dodaj slike</span>
                                    <input id="imageUpload" type="file" class="hidden" multiple @change="onImageSelect" />
                                </label>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-col justify-start h-full">
                    <template x-if="editing">
                        <div class="flex flex-col h-full">
                            <textarea x-ref="mainText" x-model="form.main_text"
                                class="w-full min-h-[65vh] rounded-xl border px-4 py-3 text-base font-body bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                                style="font-family: var(--font-body); resize:vertical;"></textarea>
                        </div>
                    </template>
                    <div x-show="!editing" class="prose prose-lg max-w-none h-full"
                        style="color: var(--primary-text); font-family: var(--font-body);" x-html="renderedText">
                    </div>
                </div>
            </div>
        </div>

        <div x-show="$store.modals.helpOpen" x-transition x-cloak
            class="fixed inset-0 flex items-center justify-center z-50" style="background:rgba(0,0,0,0.5);"
            tabindex="0" @click.self="$store.modals.closeAll()" @keydown.escape.window="$store.modals.closeAll()">
            <div x-show="$store.modals.helpOpen" x-transition x-cloak
                class="relative rounded-xl border-2 border-[var(--secondary-text)] shadow-2xl bg-white dark:bg-gray-900 flex flex-col items-stretch"
                style="width:480px; height:500px; background: var(--primary-bg); color: var(--primary-text);"
                @click.stop x-data="{ slide: 1, total: 2, enlarged: false, enlargedImg: '' }">
                <button @click="$store.modals.closeAll()"
                    class="absolute top-3 right-3 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700"
                    style="color: var(--secondary-text);" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="flex flex-col flex-1 px-4 py-3 overflow-hidden h-full">
                    <h3 class="text-lg font-bold text-center mb-2" style="color:var(--primary-text)">
                        {{ App::getLocale() === 'en' ? 'How to use Services Section' : (App::getLocale() === 'sr-Cyrl' ? 'Како користити секцију Услуге' : 'Kako koristiti sekciju Usluge') }}
                    </h3>
                    <div class="flex items-center justify-center w-full" style="min-height: 170px;">
                        <button type="button" @click="slide = slide === 1 ? total : slide - 1"
                            class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-3 flex items-center justify-center"
                            style="min-width:32px;">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <div class="flex-1 flex flex-col justify-center items-center min-h-[150px]">
                            <template x-if="slide === 1">
                                <img src="/images/services-help1.png"
                                    class="rounded-xl max-h-40 mb-3 object-contain bg-transparent shadow cursor-zoom-in"
                                    alt="Edit"
                                    @click="enlarged = true; enlargedImg='/images/services-help1.png'" />
                            </template>
                            <template x-if="slide === 2">
                                <img src="/images/services-help2.png"
                                    class="rounded-xl max-h-40 mb-3 object-contain bg-transparent shadow cursor-zoom-in"
                                    alt="Images"
                                    @click="enlarged = true; enlargedImg='/images/services-help2.png'" />
                            </template>
                            <div class="flex justify-center mb-4 mt-1 space-x-1">
                                <template x-for="i in total">
                                    <div :class="slide === i ? 'bg-[var(--accent)]' : 'bg-gray-400'"
                                        class="w-2 h-2 rounded-full transition-all duration-200"></div>
                                </template>
                            </div>
                            <!-- Tekst -->
                            <div class="text-base text-center px-1">
                                <template x-if="slide === 1">
                                    <div>
                                        {{ App::getLocale() === 'en'
                                            ? 'After clicking the "Edit" button, you can change the title, subtitle, and content below the form. All changes will be automatically synchronized across all languages.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Након што кликнете на дугме "Измени", можете променити наслов, поднаслов и садржај испод форме. Све измене ће бити аутоматски примењене и на остале језике.'
                                                : 'Nakon što kliknete na dugme "Izmeni", možete promeniti naslov, podnaslov i sadržaj ispod forme. Sve izmene će biti automatski primenjene i na ostale jezike.') }}
                                    </div>
                                </template>
                                <template x-if="slide === 2">
                                    <div>
                                        {{ App::getLocale() === 'en'
                                            ? 'Images are displayed in a loop (carousel). In edit mode, you can click the plus (+) button to add a new image or the X in the image corner to remove one. After saving, new images will rotate automatically.'
                                            : (App::getLocale() === 'sr-Cyrl'
                                                ? 'Слике се приказују у петљи (carousel). У режиму измене можете додати нову слику кликом на дугме плус (+), или обрисати слику кликом на X у углу слике. Након чувања, нове слике ће се аутоматски ротирати.'
                                                : 'Slike se prikazuju u petlji (carousel). U režimu izmene možete dodati novu sliku klikom na dugme plus (+), ili obrisati sliku klikom na X u uglu slike. Nakon čuvanja, nove slike će se automatski vrteti u krug.') }}
                                    </div>
                                </template>
                            </div>
                        </div>
                        <button type="button" @click="slide = slide === total ? 1 : slide + 1"
                            class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition ml-3 flex items-center justify-center"
                            style="min-width:32px;">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                    <!-- Overlay za uveličanu sliku -->
                    <div x-show="enlarged" x-transition
                        class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
                        style="backdrop-filter: blur(2px);" @click="enlarged = false">
                        <img :src="enlargedImg"
                            class="rounded-2xl shadow-2xl max-h-[80vh] max-w-[90vw] border-4 border-white object-contain"
                            @click.stop />
                        <button @click="enlarged = false"
                            class="absolute top-5 right-8 bg-white/80 hover:bg-white p-2 rounded-full shadow"
                            aria-label="Close" style="color: var(--primary-text);">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('modals', {
                    helpOpen: false,
                    openHelp() {
                        this.helpOpen = true
                    },
                    closeAll() {
                        this.helpOpen = false
                    }
                });
            });

            window.marked.setOptions({
                breaks: false
            });

            function servicesEditor({
                initial,
                updateUrl,
                uploadImageUrl,
                locale,
                csrf
            }) {
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
                            return fetch(uploadImageUrl, {
                                    method: 'POST',
                                    body: formData
                                })
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
                        const fileInput = document.getElementById('imageUpload');
                        files.forEach(file => {
                            const maxFileSize = 2 * 1024 * 1024;
                            if (file && file.size > maxFileSize) {
                                alert("{{ App::getLocale() === 'en' ? 'Your file exceeds the 2MB limit.' : (App::getLocale() === 'sr-Cyrl' ? 'Ваш фајл прелази дозвољену величину од 2МБ.' : 'Vaš fajl prelazi dozvoljenu veličinu od 2MB.') }}");
                                fileInput.value = '';
                                return;
                            }
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
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
</x-guest-layout>