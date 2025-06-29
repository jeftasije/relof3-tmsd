<x-guest-layout>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex-grow">
            @include('components.hero')

            @foreach ($order as $component)
                @if ($component === 'news' && $newsVisible)
                    @include('components.news', ['news' => $news])
                @elseif ($component === 'contact' && $contactVisible)
                    @include('components.contact')
                @elseif ($component === 'cobiss' && $cobissVisible)
                    @include('components.cobiss')
                @endif
            @endforeach

        </main>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
    <script>
        const slider = document.getElementById('newsSlider');
        const wrapper = document.getElementById('newsSliderWrapper');
        const originalCards = Array.from(slider.children); 
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