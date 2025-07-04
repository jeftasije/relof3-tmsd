<section class="bg-gray-900 py-12"
    style="background: var(--primary-bg)">
    <div class="max-w-screen-xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-white mb-6">{{ __('homepage_news_title') }}</h2>
        <div class="relative flex items-center">
            <button id="scrollLeft" class="z-10 p-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div id="newsSliderWrapper" class="overflow-hidden flex-grow mx-4">
                <div id="newsSlider" class="flex gap-6 transition-transform duration-300 ease-in-out">
                    @foreach ($news as $item)
                    <div class="flex-shrink-0 rounded-lg shadow-lg overflow-hidden w-80 h-[22rem] flex flex-col transition duration-300 hover:-translate-y-1 hover:scale-105" data-news-id="{{ $item->id }}"
                    style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%);">
                        <img
                            class="w-full h-40 object-cover"
                            src="{{ asset($item->image_path ?? '/images/default-news.jpg') }}"
                            alt="{{ $item->title }}"
                            onerror="this.src='{{ asset('/images/default-news.jpg') }}';" />
                        <div class="p-4 text-white flex flex-col flex-grow justify-between">
                            <div>
                                <h3 class="text-lg font-semibold mb-2" style="color: var(--primary-text) !important;">{{ $item->title }}</h3>
                                <p class="text-gray-300 text-sm" style="color: var(--secondary-text) !important;">{{ Str::limit($item->summary, 100) }}</p>
                            </div>
                            <p class="mt-4 text-sm text-gray-400" style="color: var(--secondary-text) !important;">{{ \Carbon\Carbon::parse($item->published_at)->format('d.m.Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button id="scrollRight" class="z-10 p-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>