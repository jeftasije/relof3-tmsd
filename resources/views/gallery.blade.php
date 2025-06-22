<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Galerija
        </h2>
    </x-slot>

    <h2 class="text-4xl font-bold text-gray-800 dark:text-white text-center mb-2 mt-8">
        {{ App::getLocale() === 'en' ? 'Gallery' : 'Galerija' }}
    </h2>
    <p class="mb-4 font-light text-center text-gray-600 dark:text-gray-300 sm:text-lg max-w-3xl mx-auto">
        {{ App::getLocale() === 'en' 
            ? 'A glimpse into our world through photos and videos. Discover stories that inspire and moments worth remembering.' 
            : 'Pogled u naš svet kroz slike i snimke. Otkrijte priče koje inspirišu i trenutke za pamćenje.' }}
    </p>


    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-8">
            {{ App::getLocale() === 'en' ? 'Photo gallery' : 'Foto galerija' }}
        </h3>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="grid gap-4">
                    <div>
                        <img src="{{ asset('images/np12.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np2.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np1.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img src="{{ asset('images/np4.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np5.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np6.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img src="{{ asset('images/np7.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np8.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np10.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img src="{{ asset('images/np9.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np11.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                    <div>
                        <img src="{{ asset('images/np3.jpg') }}" alt="Slika 1" class="h-auto max-w-full rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-16">
    <h3 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-8">
        {{ App::getLocale() === 'en' ? 'Video gallery' : 'Video galerija' }}
    </h3>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="w-full">
                <video controls class="w-full rounded-lg shadow-lg">
                    <source src="{{ asset('videos/video1.mp4') }}" type="video/mp4">
                    Vaš pregledač ne podržava HTML5 video.
                </video>
            </div>

            <div class="w-full">
                <video controls class="w-full rounded-lg shadow-lg">
                    <source src="{{ asset('videos/video2.mp4') }}" type="video/mp4">
                    Vaš pregledač ne podržava HTML5 video.
                </video>
            </div>
        </div>
    </div>
</div>


</x-guest-layout>
