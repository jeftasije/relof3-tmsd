<x-guest-layout>
    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);">
        <div class="max-w-7xl mx-auto px-4 py-12">
            {{-- HEADER: centriran naslov, dugmad fiksno desno --}}
            <div class="relative mb-12 flex flex-col items-center">
                <div class="w-full absolute right-0 top-0 flex justify-end items-center" style="height: 70px; min-width:220px; max-width: 240px;">
                    <div x-data="{ editing: false }" class="flex items-center">
                        <button x-show="!editing" @click="editing = true"
                            class="px-5 py-2 rounded-2xl font-semibold text-base shadow bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white transition-all duration-200"
                            style="font-family: var(--font-body);"
                            type="button">
                            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                        </button>
                        <template x-if="editing">
                            <div class="flex gap-2">
                                <button @click="editing = false"
                                    class="px-4 py-2 rounded-xl font-semibold text-base shadow bg-green-600 hover:bg-green-700 text-white transition-all duration-200"
                                    style="font-family: var(--font-body);"
                                    type="button">
                                    {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
                                </button>
                                <button @click="editing = false"
                                    class="px-4 py-2 rounded-xl font-semibold text-base shadow bg-gray-400 hover:bg-gray-500 text-white transition-all duration-200"
                                    style="font-family: var(--font-body);"
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
                        {{ $text['hero_title'] ?? $text['header'] }}
                    </h1>
                    <p style="white-space: nowrap;">
                        {{ $text['hero_subtitle'] ?? '' }}
                    </p>
                </div>
            </div>

            @foreach ($text['sections'] ?? [] as $i => $section)
                <section class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-20 items-stretch">
                    @if($i === 0)
                        {{-- Fotokopirnica DESKTOP --}}
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full h-full"
                                 style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);">
                                <img src="{{ asset('images/fotokopirnica.png') }}" alt="Fotokopirnica"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @elseif($i === 1)
                        {{-- Knjigoveznica DESKTOP --}}
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full h-full"
                                 style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);">
                                <img src="{{ asset('images/knjigoveznica.jpg') }}" alt="Knjigoveznica"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @elseif(!empty($section['image']))
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full h-full"
                                 style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);">
                                <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-2 flex flex-col justify-center">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4"
                            style="color: var(--accent); font-family: var(--font-title);">
                            {{ $section['title'] }}
                        </h2>
                        <p class="mb-6 text-base md:text-lg" style="color: var(--secondary-text); font-family: var(--font-body);">
                            {{ $section['description'] ?? '' }}
                        </p>
                        @if(!empty($section['features']))
                            <ul class="flex flex-wrap gap-2 mb-6">
                                @foreach ($section['features'] as $feature)
                                    <li class="px-4 py-1 rounded-full text-sm font-medium shadow"
                                        style="background: var(--accent); color: #fff; font-family: var(--font-body);">
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if(isset($section['prices']))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($section['prices'] as $price)
                                    <div class="rounded-2xl shadow p-5 mb-2 flex flex-col items-start hover:scale-[1.025] transition-all duration-200 border border-[var(--accent)]"
                                         style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%);
                                                color: var(--primary-text);">
                                        <div class="text-lg font-semibold mb-2"
                                             style="color: var(--primary-text); font-family: var(--font-title);">
                                            {{ $price['label'] }}
                                        </div>
                                        @if(isset($price['from']) && isset($price['to']))
                                            <div class="flex gap-2 items-center">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                      style="background: var(--accent); color: #fff;">
                                                    {{ $text['from_label'] ?? 'od' }} {{ $price['from'] }}
                                                </span>
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                      style="background: var(--accent); color: #fff;">
                                                    {{ $text['to_label'] ?? 'do' }} {{ $price['to'] }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="inline-block px-4 py-1.5 rounded-full text-base font-bold"
                                                  style="background: var(--accent); color: #fff;">
                                                {{ $price['price'] }}
                                            </span>
                                        @endif
                                        @if(!empty($price['unit']))
                                            <span class="ml-2 text-xs text-[var(--secondary-text)]">
                                                {{ $text['price_unit_label'] ?? $price['unit'] }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(isset($section['list']))
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                                @foreach ($section['list'] as $item)
                                    <li class="p-4 rounded-xl shadow text-base border border-[var(--accent)]"
                                        style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%);
                                               color: var(--primary-text); font-family: var(--font-body);">
                                        {!! $item !!}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if($i === 0)
                        {{-- Fotokopirnica MOBILNI --}}
                        <div class="md:hidden flex justify-center mb-6">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full max-w-xs"
                                 style="background: var(--primary-bg);">
                                <img src="{{ asset('images/fotokopirnica.png') }}" alt="Fotokopirnica"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @elseif($i === 1)
                        {{-- Knjigoveznica MOBILNI --}}
                        <div class="md:hidden flex justify-center mb-6">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full max-w-xs"
                                 style="background: var(--primary-bg);">
                                <img src="{{ asset('images/knjigoveznica.jpg') }}" alt="Knjigoveznica"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @elseif(!empty($section['image']))
                        <div class="md:hidden flex justify-center mb-6">
                            <div class="group overflow-hidden rounded-2xl shadow-xl w-full max-w-xs"
                                 style="background: var(--primary-bg);">
                                <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}"
                                     class="object-cover object-center w-full h-full transition-transform duration-300 transform group-hover:scale-105"
                                     style="cursor:pointer;" />
                            </div>
                        </div>
                    @endif
                </section>
            @endforeach
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
</x-guest-layout>
