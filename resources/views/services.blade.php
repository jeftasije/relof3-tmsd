<x-guest-layout>
    <div class="w-full min-h-screen" style="background: var(--primary-bg); color: var(--primary-text);">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="text-center mb-12">
                <h1 class="font-extrabold text-3xl sm:text-4xl md:text-5xl mb-3"
                    style="color: var(--primary-text); font-family: var(--font-title);">
                    {{ $servicesData['hero_title'] ?? $servicesData['header'] }}
                </h1>
                <p class="text-base sm:text-lg md:text-xl max-w-2xl mx-auto"
                    style="color: var(--secondary-text); font-family: var(--font-body);">
                    {{ $servicesData['hero_subtitle'] ?? '' }}
                </p>
            </div>

            @foreach ($servicesData['sections'] ?? [] as $i => $section)
                <section class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-20 items-stretch">
                    @if($i === 0)
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <img src="{{ asset('images/fotokopirnica.png') }}" alt="Fotokopirnica"
                                class="rounded-2xl shadow-xl w-full h-full object-cover object-center"
                                style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);" />
                        </div>
                    @elseif($i === 1)
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <img src="{{ asset('images/knjigoveznica.jpg') }}" alt="Knjigoveznica"
                                class="rounded-2xl shadow-xl w-full h-full object-cover object-center"
                                style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);" />
                        </div>
                    @elseif(!empty($section['image']))
                        <div class="hidden md:flex md:col-span-1 justify-center items-stretch">
                            <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}"
                                class="rounded-2xl shadow-xl w-full h-full object-cover object-center"
                                style="min-width: 320px; max-width: 440px; min-height: 440px; background: var(--primary-bg);" />
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
                                         style="
                                            background: color-mix(in srgb, var(--primary-bg) 40%, var(--primary-text) 60%);
                                            background-color: #22223b; /* fallback za stare browsere */
                                            color: var(--primary-text);
                                         ">
                                        <div class="text-lg font-semibold mb-2" style="color: var(--primary-text); font-family: var(--font-title);">
                                            {{ $price['label'] }}
                                        </div>
                                        @if(isset($price['from']) && isset($price['to']))
                                            <div class="flex gap-2 items-center">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                      style="background: var(--accent); color: #fff;">
                                                    od {{ $price['from'] }}
                                                </span>
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold shadow"
                                                      style="background: var(--accent); color: #fff;">
                                                    do {{ $price['to'] }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="inline-block px-4 py-1.5 rounded-full text-base font-bold"
                                                  style="background: var(--accent); color: #fff;">
                                                {{ $price['price'] }}
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
                                        style="background: color-mix(in srgb, var(--primary-bg) 40%, var(--primary-text) 60%);
                                               background-color: #22223b; color: var(--primary-text); font-family: var(--font-body);">
                                        {!! $item !!}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if($i === 0)
                        <div class="md:hidden flex justify-center mb-6">
                            <img src="{{ asset('images/fotokopirnica.png') }}" alt="Fotokopirnica"
                                class="rounded-2xl shadow-xl w-full max-w-xs object-cover object-center"
                                style="background: var(--primary-bg);" />
                        </div>
                    @elseif($i === 1)
                        <div class="md:hidden flex justify-center mb-6">
                            <img src="{{ asset('images/knjigoveznica.png') }}" alt="Knjigoveznica"
                                class="rounded-2xl shadow-xl w-full max-w-xs object-cover object-center"
                                style="background: var(--primary-bg);" />
                        </div>
                    @elseif(!empty($section['image']))
                        <div class="md:hidden flex justify-center mb-6">
                            <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}"
                                class="rounded-2xl shadow-xl w-full max-w-xs object-cover object-center"
                                style="background: var(--primary-bg);" />
                        </div>
                    @endif
                </section>
            @endforeach
        </div>
    </div>
</x-guest-layout>