<x-guest-layout>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex-grow">
            <section class="relative h-screen w-full">
                <img
                    src="{{ asset('images/herosection.jpg') }}"
                    alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}"
                    class="absolute inset-0 w-full h-full object-cover" />
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4 animate-fadeIn">
                    <h1 class="text-5xl font-extrabold mb-4">{{ $libraryData['name'] ?? '' }}</h1>
                    <p class="text-3xl font-semibold">
                        {{ App::getLocale() === 'en' ? 'Novi Pazar' : (App::getLocale() === 'sr-Cyrl' ? 'Нови Пазар' : 'Novi Pazar') }}
                    </p>
                </div>
            </section>
            <section class="bg-gray-900 py-12">
                <div class="max-w-screen-xl mx-auto px-4">
                    <h2 class="text-3xl font-bold text-white mb-6">{{ App::getLocale() === 'en' ? 'Latest News' : (App::getLocale() === 'sr-Cyrl' ? 'Најновије вести' : 'Najnovije vesti') }}</h2>
                    <div class="relative flex items-center">
                        <button id="scrollLeft" class="z-10 p-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div id="newsSliderWrapper" class="overflow-hidden flex-grow mx-4">
                            <div id="newsSlider" class="flex gap-6 transition-transform duration-300 ease-in-out">
                                @foreach ($news as $item)
                                    <div class="flex-shrink-0 bg-gray-800 rounded-lg shadow-lg overflow-hidden w-80 h-[22rem] flex flex-col" data-news-id="{{ $item->id }}">
                                        <img
                                            class="w-full h-40 object-cover"
                                            src="{{ asset($item->image_path ?? '/images/default-news.jpg') }}"
                                            alt="{{ $item->title }}"
                                            onerror="this.src='{{ asset('/images/default-news.jpg') }}';"
                                        />
                                        <div class="p-4 text-white flex flex-col flex-grow justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold mb-2">{{ $item->title }}</h3>
                                                <p class="text-gray-300 text-sm">{{ Str::limit($item->summary, 100) }}</p>
                                            </div>
                                            <p class="mt-4 text-sm text-gray-400">{{ \Carbon\Carbon::parse($item->published_at)->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button id="scrollRight" class="z-10 p-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>
            <section class="bg-white dark:bg-gray-900">
                <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                    <div class="mr-auto place-self-center lg:col-span-7">
                        <h2 class="mb-4 text-5xl font-extrabold md:text-6xl dark:text-white">
                            {{ App::getLocale() === 'en' ? 'Let’s stay in touch!' : (App::getLocale() === 'sr-Cyrl' ? 'Будимо у контакту!' : 'Budimo u kontaktu!') }}
                        </h2>
                        <p class=" mb-6 font-light text-gray-500 dark:text-gray-400">
                            {{ App::getLocale() === 'en'
                                ? 'Sign up to be notified about the latest news'
                                : (App::getLocale() === 'sr-Cyrl'
                                    ? 'Пријавите се како бисмо Вас обавестили о најновијим вестима'
                                    : 'Prijavite se kako bismo Vas obavestili o najnovijim vestima') }}
                        </p>
                        <div class="flex flex-row gap-2 max-w-md">
                            <input 
                                type="email" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="{{ App::getLocale() === 'en' ? 'Enter your email' : (App::getLocale() === 'sr-Cyrl' ? 'Унесите свој имејл' : 'Unesite svoj imejl') }}" 
                                required
                            >
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 whitespace-nowrap">
                                {{ App::getLocale() === 'en' ? 'Sign up' : (App::getLocale() === 'sr-Cyrl' ? 'Пријава' : 'Prijava') }}
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                        <img
                            src="{{ asset('images/books.png') }}"
                            alt="{{ App::getLocale() === 'en' ? 'Novi Pazar background' : (App::getLocale() === 'sr-Cyrl' ? 'Позадина Нови Пазар' : 'Pozadina Novi Pazar') }}" />
                    </div>
                </div>
            </section>
            <section class="bg-gray-100 dark:bg-gray-800 py-12">
                <div class="max-w-screen-xl mx-auto px-4 text-center">
                    <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                        {{ App::getLocale() === 'en'
                            ? 'Search for books on COBISS'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Претражи књиге на COBISS-у'
                                : 'Pretraži knjige na COBISS-u') }}
                    </h2>
                    <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">
                        {{ App::getLocale() === 'en'
                            ? 'Enter the book title, author, or ISBN and you will be redirected to COBISS'
                            : (App::getLocale() === 'sr-Cyrl'
                                ? 'Унесите назив књиге, аутора или ISBN број и бићете преусмерени на COBISS'
                                : 'Unesite naziv knjige, autora ili ISBN broj i bićete preusmereni na COBISS') }}
                    </p>
                    <form
                        action="https://plus.cobiss.net/cobiss/sr/sr/bib/search"
                        method="get"
                        target="_blank"
                        class="max-w-2xl mx-auto flex flex-col sm:flex-row items-center gap-4"
                    >
                        <input
                            type="text"
                            name="q"
                            required
                            placeholder="{{ App::getLocale() === 'en' ? 'For example: Ivo Andrić, The Bridge on the Drina...' : (App::getLocale() === 'sr-Cyrl' ? 'На пример: Иво Андрић, На Дрини ћуприја...' : 'Na primer: Ivo Andrić, Na Drini ćuprija...') }}"
                            class="w-full p-3 rounded-lg border text-gray-900 focus:ring-2 focus:ring-blue-500"
                        />
                        <input type="hidden" name="db" value="nbnp-1">
                        <input type="hidden" name="mat" value="allmaterials">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                        >
                            {{ App::getLocale() === 'en' ? 'Search' : (App::getLocale() === 'sr-Cyrl' ? 'Претражи' : 'Pretraži') }}
                        </button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
    <script>
        const slider = document.getElementById('newsSlider');
        const wrapper = document.getElementById('newsSliderWrapper');
        const originalCards = Array.from(slider.children); // Čuvamo originalne kartice
        const leftBtn = document.getElementById('scrollLeft');
        const rightBtn = document.getElementById('scrollRight');

        const visibleCards = 3;
        let currentIndex = visibleCards; // Počinjemo od originalnih kartica
        const gap = 24;
        let autoScrollInterval;
        const scrollInterval = 5000;
        let isTransitioning = false;

        // Kloniraj kartice za beskonačno klizanje
        function setupInfiniteScroll() {
            // Kloni prvih nekoliko kartica i dodaj na kraj
            for (let i = 0; i < visibleCards; i++) {
                const clone = originalCards[i].cloneNode(true);
                slider.appendChild(clone);
            }
            
            // Kloni poslednjih nekoliko kartica i dodaj na početak
            for (let i = originalCards.length - 1; i >= originalCards.length - visibleCards; i--) {
                const clone = originalCards[i].cloneNode(true);
                slider.insertBefore(clone, slider.firstChild);
            }
            
            // Postavi širinu kartica
            setupCards();
            
            // Postavi početnu poziciju
            slider.style.transform = `translateX(-${currentIndex * (getCardWidth() + gap)}px)`;
        }

        // Postavljamo širinu kartica
        function setupCards() {
            const wrapperWidth = wrapper.offsetWidth;
            const cardWidth = (wrapperWidth - (gap * (visibleCards - 1))) / visibleCards;
            
            Array.from(slider.children).forEach(card => {
                card.style.width = `${cardWidth}px`;
                card.addEventListener('click', (e) => {
                    if (e.target.closest('button') || isTransitioning) return;
                    
                    const newsId = card.getAttribute('data-news-id');
                    if (newsId) {
                        window.location.href = `/news/${newsId}`;
                    }
                });
                card.style.cursor = 'pointer';
            });
        }

        function getCardWidth() {
            return slider.children[0].offsetWidth;
        }

        // Funkcija za ažuriranje stanja dugmadi
        function updateButtons() {
            leftBtn.disabled = false;
            rightBtn.disabled = false;
        }

        // Funkcija za pomeranje slajdera
        function updateSlider() {
            isTransitioning = true;
            const cardWidth = getCardWidth();
            const translateX = currentIndex * (cardWidth + gap);
            
            slider.style.transition = 'transform 0.5s ease-in-out';
            slider.style.transform = `translateX(-${translateX}px)`;
            updateButtons();
        }

        // Funkcija za automatsko klizanje
        function startAutoScroll() {
            autoScrollInterval = setInterval(() => {
                if (!isTransitioning) {
                    currentIndex++;
                    updateSlider();
                }
            }, scrollInterval);
        }

        // Resetujemo poziciju kada se završi animacija
        slider.addEventListener('transitionend', () => {
            isTransitioning = false;
            
            const totalClones = visibleCards * 2;
            const totalSlides = slider.children.length;
            
            // Ako smo došli do kloniranih kartica na kraju, vratimo se neprimetno
            if (currentIndex >= totalSlides - visibleCards) {
                slider.style.transition = 'none';
                currentIndex = visibleCards;
                slider.style.transform = `translateX(-${currentIndex * (getCardWidth() + gap)}px)`;
                void slider.offsetWidth; // Forsiraj repaint
            }
            // Ako smo došli do kloniranih kartica na početku, vratimo se neprimetno
            else if (currentIndex <= 0) {
                slider.style.transition = 'none';
                currentIndex = totalSlides - totalClones;
                slider.style.transform = `translateX(-${currentIndex * (getCardWidth() + gap)}px)`;
                void slider.offsetWidth; // Forsiraj repaint
            }
        });

        // Pomeranje ulevo
        leftBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isTransitioning) return;
            
            clearInterval(autoScrollInterval);
            currentIndex--;
            updateSlider();
            startAutoScroll();
        });

        // Pomeranje udesno
        rightBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isTransitioning) return;
            
            clearInterval(autoScrollInterval);
            currentIndex++;
            updateSlider();
            startAutoScroll();
        });

        // Ažuriranje na resize prozora
        window.addEventListener('resize', () => {
            setupCards();
            updateSlider();
        });

        // Pauziraj auto scroll kada je miš iznad slidera
        wrapper.addEventListener('mouseenter', () => {
            clearInterval(autoScrollInterval);
        });

        // Nastavi auto scroll kada miš napusti slider
        wrapper.addEventListener('mouseleave', () => {
            startAutoScroll();
        });

        // Inicijalno postavljanje
        setupInfiniteScroll();
        updateButtons();
        startAutoScroll();
    </script>


</x-guest-layout>