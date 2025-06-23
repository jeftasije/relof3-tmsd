<x-guest-layout>
    <h1 class="text-4xl font-bold text-center my-6 text-gray-800 dark:text-white">
        @switch(App::getLocale())
        @case('en') Gallery @break
        @case('sr-Cyrl') Галерија @break
        @default Galerija
        @endswitch
        </h1>

        <p class="mb-8 text-center text-gray-700 dark:text-gray-300 whitespace-pre-line">
            {{ $galleryDescription->value ?? '' }}
        </p>

        @auth
            <form action="{{ route('gallery.updateDescription') }}" method="POST" class="space-y-4 ">
                @csrf
                <div class="max-w-lg mx-auto">
                    <textarea name="value" rows="8"
                        class="w-full p-4 bg-white dark:bg-gray-800 border rounded shadow-sm focus:ring focus:outline-none dark:text-white"
                    >{{ old('value', $galleryDescription->value ?? '') }}</textarea>

                    <div class="flex justify-end mt-4">
                        <button type="button" data-modal-toggle="submitModal"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            @switch(App::getLocale())
                                @case('en') Save changes @break
                                @case('sr-Cyrl') Сачувај промене @break
                                @default Sačuvaj promene
                            @endswitch
                        </button>
                    </div>
                </div>


                <div class="flex justify-end gap-4">
                    

                    <!-- Confirm Submission Modal -->
                    <div id="submitModal" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full mx-auto">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        @switch(App::getLocale())
                                            @case('en') Are you sure you want to save the changes? @break
                                            @case('sr-Cyrl') Да ли сте сигурни да желите да сачувате измене? @break
                                            @default Da li ste sigurni da želite da sačuvate izmene?
                                        @endswitch
                                    </h3>
                                    <button id="confirmSubmitBtn" type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                        @switch(App::getLocale())
                                            @case('en') Save @break
                                            @case('sr-Cyrl') Сачувај @break
                                            @default Sačuvaj
                                        @endswitch
                                    </button>
                                    <button data-modal-hide="submitModal" type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        @switch(App::getLocale())
                                            @case('en') Cancel @break
                                            @case('sr-Cyrl') Откажи @break
                                            @default Otkaži
                                        @endswitch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endauth
    

    
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

    
    document.addEventListener('DOMContentLoaded', function () {
        const openModalBtn = document.querySelector('button[data-modal-toggle="submitModal"]');
        const confirmBtn = document.getElementById('confirmSubmitBtn');
        const modal = document.getElementById('submitModal');
        const form = document.querySelector('form[action="{{ route('gallery.updateDescription') }}"]');

        if (!openModalBtn || !confirmBtn || !modal || !form) return;

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        confirmBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            form.submit();
        });

        document.querySelectorAll('[data-modal-hide="submitModal"]').forEach((el) => {
            el.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
    
</script>
