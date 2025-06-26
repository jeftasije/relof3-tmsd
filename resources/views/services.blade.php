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

            <template x-for="(section, i) in form.sections">
                <section class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-20 items-stretch" :key="i">
                    <!-- Slika sa uploadom -->
                    <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                        <div class="group overflow-hidden rounded-2xl shadow-xl w-full h-full relative"
                             style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);">
                            <img
                                :src="section.image ?? (i === 0 ? '{{ asset('images/fotokopirnica.png') }}' : (i === 1 ? '{{ asset('images/knjigoveznica.jpg') }}' : ''))"
                                :alt="section.title"
                                class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                :class="editing ? 'blur-[4px] brightness-90 cursor-pointer' : ''"
                                @click="editing ? $refs['imgInput'+i][0].click() : null"
                                style="cursor:pointer;"
                            />
                            <input 
                                type="file"
                                accept="image/*"
                                class="hidden"
                                :ref="'imgInput'+i"
                                @change="previewImage($event, i)"
                                :disabled="!editing"
                            />
                            <template x-if="editing">
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <span 
                                        class="bg-black/60 text-white px-3 py-2 rounded" 
                                        style="pointer-events: auto;"
                                        x-text="locale === 'sr' ? 'Klikni za promenu slike' : (locale === 'sr-Cyrl' ? 'Кликни за промену слике' : 'Click to change image')"
                                    ></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex flex-col justify-center">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4"
                            style="color: var(--accent); font-family: var(--font-title);">
                            <template x-if="editing">
                                <input type="text" x-model="form.sections[i].title" class="text-2xl sm:text-3xl md:text-4xl font-bold w-full border px-2 rounded"
                                    style="background: var(--primary-bg); color: var(--accent); font-family: var(--font-title);" />
                            </template>
                            <span x-show="!editing" x-text="form.sections[i].title"></span>
                        </h2>
                        <p class="mb-6 text-base md:text-lg" style="color: var(--secondary-text); font-family: var(--font-body);">
                            <template x-if="editing">
                                <textarea x-model="form.sections[i].description" class="w-full border px-2 rounded bg-white text-black"></textarea>
                            </template>
                            <span x-show="!editing" x-text="form.sections[i].description"></span>
                        </p>
                        <template x-if="section.features && section.features.length > 0">
                            <ul class="flex flex-wrap gap-2 mb-6">
                                <template x-for="(feature, j) in section.features" :key="j">
                                    <li class="px-4 py-1 rounded-full text-sm font-medium shadow"
                                        style="background: var(--accent); color: #fff; font-family: var(--font-body);">
                                        <template x-if="editing">
                                            <input type="text" x-model="form.sections[i].features[j]" class="w-full border px-2 rounded"
                                                   style="background: var(--accent); color: #fff;"/>
                                        </template>
                                        <span x-show="!editing" x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <template x-if="section.prices && section.prices.length > 0">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <template x-for="(price, pidx) in section.prices" :key="pidx">
                                    <div class="rounded-2xl shadow p-5 mb-2 flex flex-col items-start hover:scale-[1.025] transition-all duration-200 border border-[var(--accent)]"
                                         style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%);
                                                color: var(--primary-text);">
                                        <div class="text-lg font-semibold mb-2"
                                             style="color: var(--primary-text); font-family: var(--font-title);">
                                            <template x-if="editing">
                                                <input type="text" x-model="form.sections[i].prices[pidx].label" class="w-full border px-2 rounded"
                                                       style="background: var(--primary-bg); color: var(--primary-text);"/>
                                            </template>
                                            <span x-show="!editing" x-text="price.label"></span>
                                        </div>
                                        <template x-if="editing">
                                            <div class="flex gap-2 items-center mb-2 w-full">
                                                <template x-if="price.from !== undefined">
                                                    <input type="text" x-model="form.sections[i].prices[pidx].from" class="w-24 border px-2 rounded bg-white text-black" />
                                                </template>
                                                <template x-if="price.to !== undefined">
                                                    <input type="text" x-model="form.sections[i].prices[pidx].to" class="w-24 border px-2 rounded bg-white text-black" />
                                                </template>
                                                <template x-if="price.price !== undefined">
                                                    <input type="text" x-model="form.sections[i].prices[pidx].price" class="w-24 border px-2 rounded bg-white text-black" />
                                                </template>
                                                <input type="text" x-model="form.sections[i].prices[pidx].unit" class="w-32 border px-2 rounded bg-white text-black" />
                                                <textarea x-model="form.sections[i].prices[pidx].description" class="flex-1 border px-2 rounded bg-white text-black" style="min-height:38px"></textarea>
                                            </div>
                                        </template>
                                        <template x-if="!editing">
                                            <div>
                                                <template x-if="price.from !== undefined && price.to !== undefined">
                                                    <div class="flex gap-2 items-center">
                                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                            style="background: var(--accent); color: #fff;">
                                                            {{ $text['from_label'] ?? 'od' }} <span x-text="price.from"></span>
                                                        </span>
                                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                            style="background: var(--accent); color: #fff;">
                                                            {{ $text['to_label'] ?? 'do' }} <span x-text="price.to"></span>
                                                        </span>
                                                    </div>
                                                </template>
                                                <template x-if="price.price !== undefined">
                                                    <span class="inline-block px-4 py-1.5 rounded-full text-base font-bold"
                                                        style="background: var(--accent); color: #fff;">
                                                        <span x-text="price.price"></span>
                                                    </span>
                                                </template>
                                                <span class="ml-2 text-xs text-[var(--secondary-text)]" x-text="price.unit"></span>
                                                <div class="text-xs mt-2" x-text="price.description"></div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="section.list && section.list.length > 0">
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                                <template x-for="(item, k) in section.list" :key="k">
                                    <li class="p-4 rounded-xl shadow text-base border border-[var(--accent)]"
                                        style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%);
                                               color: var(--primary-text); font-family: var(--font-body);">
                                        <template x-if="editing">
                                            <input type="text" x-model="form.sections[i].list[k]" class="w-full border px-2 rounded" />
                                        </template>
                                        <span x-show="!editing" x-text="item"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </section>
            </template>
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
    </style>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
    function servicesEditor({ initial, updateUrl, uploadImageUrl, locale, csrf }) {
        return {
            form: JSON.parse(JSON.stringify(initial)),
            original: JSON.parse(JSON.stringify(initial)),
            editing: false,
            startEdit() {
                this.editing = true;
            },
            cancelEdit() {
                this.form = JSON.parse(JSON.stringify(this.original));
                this.editing = false;
            },
            async previewImage(event, sectionIdx) {
                const file = event.target.files[0];
                if (file) {
                    // Prikazi odmah preview
                    this.form.sections[sectionIdx].image = URL.createObjectURL(file);
                    // Odmah salji serveru
                    let formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', csrf);
                    const resp = await fetch(`${uploadImageUrl}/${sectionIdx}`, {
                        method: 'POST',
                        body: formData
                    });
                    if(resp.ok) {
                        const data = await resp.json();
                        if (data.image_path) {
                            // Zamenjuje preview src sa novim url iz backenda
                            this.form.sections[sectionIdx].image = data.image_path + '?' + (new Date()).getTime();
                        }
                    } else {
                        alert('Greška pri uploadu slike!');
                    }
                }
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
                        header: this.form.header ?? '',
                        sections: this.form.sections,
                        from_label: this.form.from_label ?? 'od',
                        to_label: this.form.to_label ?? 'do',
                        price_unit_label: this.form.price_unit_label ?? 'po komadu'
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
