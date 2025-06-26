<x-guest-layout>
    <h1 class="text-4xl font-bold text-center my-6 text-gray-800 dark:text-white">
        @switch(App::getLocale())
        @case('en') Gallery @break
        @case('sr-Cyrl') Галерија @break
        @default Galerija
        @endswitch
        </h1>

    <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        @switch(App::getLocale())
        @case('en') Discover our collection of images and videos. @break
        @case('sr-Cyrl') Погледајте нашу колекцију слика и видео снимака. @break
        @default Pogledajte našu kolekciju slika i video snimaka.
        @endswitch
    </p>

    
    <h2 class="text-2xl font-bold text-center mb-4 text-gray-800 dark:text-white">
        @switch(App::getLocale())
        @case('en') Photo gallery @break
        @case('sr-Cyrl') Фото галерија @break
        @default Foto galerija
        @endswitch
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-7xl mx-auto mb-12">
        @foreach ($images as $image)
            <div class="relative group">
                <img src="{{ asset('storage/' . $image->path) }}" class="rounded-lg w-full h-48 object-cover" alt="Image" />
                @auth
                    <form method="POST" action="{{ route('gallery.destroy', $image->id) }}" class="absolute top-2 right-2 hidden group-hover:block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs">🗑</button>
                    </form>
                @endauth
            </div>
        @endforeach
    </div>

   
    <h2 class="text-2xl font-bold text-center mb-4 text-gray-800 dark:text-white">
        @switch(App::getLocale())
        @case('en') Video gallery @break
        @case('sr-Cyrl') Видео галерија @break
        @default Video galerija
        @endswitch
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto mb-12">
        @foreach ($videos as $video)
            <div class="relative group">
                <video controls class="w-full rounded-lg shadow-md">
                    <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                    
                    @switch(App::getLocale())
                    @case('en') Your browser does not support the video tag. @break
                    @case('sr-Cyrl') Ваш прегледач не подржава видео ознаку. @break
                    @default Vaš pregledač ne podržava video oznaku.
                    @endswitch
                </video>
                @auth
                    <form method="POST" action="{{ route('gallery.destroy', $video->id) }}" class="absolute top-2 right-2 hidden group-hover:block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs">🗑</button>
                    </form>
                @endauth
            </div>
        @endforeach
    </div>

    
    @auth
        <div class="max-w-xl mx-auto mt-10">
            <form method="POST" action="{{ route('gallery.upload') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                @csrf
                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                    @switch(App::getLocale())
                    @case('en') Upload new file @break
                    @case('sr-Cyrl') Додај нови фајл @break
                    @default Dodaj novi fajl
                    @endswitch
                </label>
                <input type="file" name="file" id="file" accept=".jpg, .jpeg, .png, .mp4, .mov, .avi"
                       class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="reset"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        @switch(App::getLocale())
                        @case('en') Cancel @break
                        @case('sr-Cyrl') Откажи @break
                        @default Otkaži
                        @endswitch                    
                    </button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        @switch(App::getLocale())
                        @case('en') Add @break
                        @case('sr-Cyrl') Додај @break
                        @default Dodaj
                        @endswitch
                    </button>
                </div>
            </form>
        </div>
    @endauth
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form[action="{{ route('gallery.upload') }}"]');
        const fileInput = form.querySelector('input[type="file"]');
        const submitButton = form.querySelector('button[type="submit"]');
        const resetButton = form.querySelector('button[type="reset"]');

        form.addEventListener('submit', (e) => {
            const file = fileInput.files[0];
            const maxFileSize = 2 * 1024 * 1024; // 2MB

            if (file && file.size > maxFileSize) {
                e.preventDefault();
                alert("{{ App::getLocale() === 'en' ? 'Your file exceeds the 2MB limit.' : 'Vaš fajl prelazi dozvoljenu veličinu od 2MB.' }}");
                fileInput.value = '';
                return;
            }

            // Optional: disable buttons to prevent double submission
            submitButton.disabled = true;
            resetButton.disabled = true;
        });

        resetButton.addEventListener('click', () => {
            submitButton.disabled = false;
        });
    });
</script>
