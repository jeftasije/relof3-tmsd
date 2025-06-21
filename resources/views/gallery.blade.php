<x-guest-layout>
    <h1 class="text-4xl font-bold text-center my-6 text-gray-800 dark:text-white">
        {{ App::getLocale() === 'en' ? 'Gallery' : 'Galerija' }}
    </h1>

    <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        {{ App::getLocale() === 'en'
            ? 'Discover our collection of images and videos.'
            : 'Pogledajte našu kolekciju slika i video snimaka.' }}
    </p>

    {{-- IMAGE GALLERY --}}
    <h2 class="text-2xl font-bold text-center mb-4 text-gray-800 dark:text-white">
        {{ App::getLocale() === 'en' ? 'Photo gallery' : 'Foto galerija' }}
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-7xl mx-auto mb-12">
        @foreach ($images as $image)
            <div class="relative group">
                <p>{{ $image->path }}</p>
                <img src="{{ asset(str_replace('public/', 'storage/', $image->path)) }}" class="rounded-lg w-full h-auto" alt="Image" />
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

    {{-- VIDEO GALLERY --}}
    <h2 class="text-2xl font-bold text-center mb-4 text-gray-800 dark:text-white">
        {{ App::getLocale() === 'en' ? 'Video gallery' : 'Video galerija' }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto mb-12">
        @foreach ($videos as $video)
            <div class="relative group">
                <video controls class="w-full rounded-lg shadow-md">
                    <source src="{{ asset(str_replace('public/', 'storage/', $video->path)) }}" type="video/mp4">
                    Your browser does not support the video tag.
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

    {{-- UPLOAD FORM FOR ADMIN --}}
    @auth
        <div class="max-w-xl mx-auto mt-10">
            <form method="POST" action="{{ route('gallery.upload') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                @csrf
                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                    {{ App::getLocale() === 'en' ? 'Upload new file' : 'Dodaj novi fajl' }}
                </label>
                <input type="file" name="file" id="file"
                       class="w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="reset"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        {{ App::getLocale() === 'en' ? 'Cancel' : 'Odustani' }}
                    </button>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ App::getLocale() === 'en' ? 'Save' : 'Sačuvaj' }}
                    </button>
                </div>
            </form>
        </div>
    @endauth
</x-guest-layout>
