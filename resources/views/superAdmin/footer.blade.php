<x-app-layout>
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            {{ App::getLocale() === 'en' ? 'Edit Footer' : 'Uredi Podnožje' }}
        </h1>
        
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('footer.edit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Library Information' : 'Podaci o Biblioteci' }}
                    </h2>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Library Name' : 'Naziv Biblioteke' }}
                        </label>
                        <textarea
                            id="name"
                            name="name"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="name"
                        >{{ old('name', $libraryData['name'] ?? '') }}</textarea>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Address' : 'Adresa' }}
                        </label>
                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="address"
                        >{{ old('address', $libraryData['address'] ?? '') }}</textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="pib" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Tax ID (PIB)' : 'PIB' }}
                        </label>
                        <input
                            type="text"
                            id="pib"
                            name="pib"
                            value="{{ old('pib', $libraryData['pib'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="pib"
                        >
                        @error('pib') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="logo_light" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Upload Logo (Light Theme)' : 'Učitaj Logo (Svetla Tema)' }}
                        </label>
                        <input
                            type="file"
                            id="logo_light"
                            name="logo_light"
                            accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="logo_light"
                        >
                        @error('logo_light') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="logo_dark" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Upload Logo (Dark Theme)' : 'Učitaj Logo (Tamna Tema)' }}
                        </label>
                        <input
                            type="file"
                            id="logo_dark"
                            name="logo_dark"
                            accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="logo_dark"
                        >
                        @error('logo_dark') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Contact Information' : 'Kontakt Informacije' }}
                    </h2>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Phone' : 'Telefon' }}
                        </label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $libraryData['phone'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="phone"
                        >
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Email' : 'Email' }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $libraryData['email'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="email"
                        >
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Facebook URL' : 'Facebook URL' }}
                        </label>
                        <input
                            type="url"
                            id="facebook"
                            name="facebook"
                            value="{{ old('facebook', $libraryData['facebook'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="facebook"
                        >
                        @error('facebook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Twitter URL' : 'Twitter URL' }}
                        </label>
                        <input
                            type="url"
                            id="twitter"
                            name="twitter"
                            value="{{ old('twitter', $libraryData['twitter'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="twitter"
                        >
                        @error('twitter') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Work Hours -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Working Hours' : 'Radno Vreme' }}
                    </h2>
                    
                    <div class="mb-4">
                        <label for="work_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Working Hours (one per line)' : 'Radno Vreme (jedan po redu)' }}
                        </label>
                        <textarea
                            id="work_hours"
                            name="work_hours"
                            rows="5"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="work_hours"
                        >{{ old('work_hours', implode("\n", $libraryData['work_hours_formatted'] ?? [])) }}</textarea>
                        @error('work_hours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Map and Copyright -->
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ App::getLocale() === 'en' ? 'Map and Copyrights' : 'Mapa i Autorska Prava' }}
                    </h2>
                    
                    <div class="mb-4">
                        <label for="map_embed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Google Maps Embed URL' : 'Google Maps Embed URL' }}
                        </label>
                        <input
                            type="url"
                            id="map_embed"
                            name="map_embed"
                            value="{{ old('map_embed', $libraryData['map_embed'] ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="map_embed"
                        >
                        @error('map_embed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="copyrights" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'Copyright Text' : 'Tekst Autorskih Prava' }}
                        </label>
                        <textarea
                            id="copyrights"
                            name="copyrights"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            data-preview-target="copyrights"
                        >{{ old('copyrights', $libraryData['copyrights'] ?? '') }}</textarea>
                        @error('copyrights') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ App::getLocale() === 'en' ? 'Save Changes' : 'Sačuvaj Promene' }}
                </button>
            </div>
        </form>

        <!-- Footer Preview -->
        <div class="mt-12">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ App::getLocale() === 'en' ? 'Footer Preview' : 'Pregled Podnožja' }}
            </h2>
            <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                <footer id="footer-preview" class="bg-white dark:bg-gray-900">
                    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
                        <div class="flex flex-col md:flex-row md:justify-between md:flex-wrap gap-6">
                            <div class="flex-grow md:flex-grow-0 md:basis-1/3 mb-6 md:mb-0">
                                <a class="flex flex-col items-start">
                                    <img id="preview-logo_light" src="{{ asset('images/nbnp-logo.png') }}" alt="Logo Light" class="max-h-12 hidden dark:block">
                                    <img id="preview-logo_dark" src="{{ asset('images/nbnp-logo-dark.png') }}" alt="Logo Dark" class="max-h-12 block dark:hidden">
                                    <span id="preview-name" class="text-2xl font-semibold whitespace-normal max-w-xs break-words dark:text-white">
                                        {{ $libraryData['name'] ?? '' }}
                                    </span>
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                        <p><span>{{ $libraryData['address_label'] ?? (App::getLocale() === 'en' ? 'Address' : 'Adresa') }}:</span> <span id="preview-address">{{ $libraryData['address'] ?? '' }}</span></p>
                                        <p><span>{{ $libraryData['pib_label'] ?? (App::getLocale() === 'en' ? 'Tax ID (PIB)' : 'PIB') }}:</span> <span id="preview-pib">{{ $libraryData['pib'] ?? '' }}</span></p>
                                    </div>
                                </a>
                            </div>

                            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2 md:basis-1/3 flex-grow">
                                <div>
                                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                        {{ $libraryData['work_hours_label'] ?? (App::getLocale() === 'en' ? 'Working Hours' : 'Radno vreme') }}
                                    </h2>
                                    <ul id="preview-work_hours" class="text-gray-500 dark:text-gray-400 font-medium">
                                        @foreach ($libraryData['work_hours_formatted'] ?? [] as $line)
                                            <li>{{ $line }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                        {{ $libraryData['phone_label'] ?? (App::getLocale() === 'en' ? 'Contact' : 'Kontakt') }}
                                    </h2>
                                    <ul class="text-gray-500 dark:text-gray-400 font-medium space-y-2 mb-4">
                                        <li><i class="fas fa-phone me-2"></i> <span id="preview-phone">{{ $libraryData['phone'] ?? '' }}</span></li>
                                        <li><i class="fas fa-envelope me-2"></i> <span id="preview-email">{{ $libraryData['email'] ?? '' }}</span></li>
                                    </ul>

                                    <div class="flex space-x-4 mt-2">
                                        <a id="preview-facebook" href="{{ $libraryData['facebook'] ?? '#' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Facebook page">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 8 19" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <a id="preview-twitter" href="{{ $libraryData['twitter'] ?? '#' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Twitter page">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <a id="preview-email-link" href="mailto:{{ $libraryData['email'] ?? 'dositejbib@gmail.com' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Email">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a3 3 0 0 0 3.22 0L21 8m-18 0v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8M3 8V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 md:mt-0 md:basis-1/4 w-full md:w-auto">
                                <iframe
                                    id="preview-map_embed"
                                    src="{{ $libraryData['map_embed'] ?? 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed' }}"
                                    width="100%"
                                    height="200"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="rounded shadow-sm"
                                ></iframe>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />

                        <div class="text-center mt-4 text-sm text-gray-500 dark:text-gray-400">
                            <span id="preview-copyrights">{{ $libraryData['copyrights'] ?? '' }}</span>
                            <a href="#" class="hover:underline" id="preview-name_footer">{{ $libraryData['name'] ?? '' }}</a>.
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const inputs = document.querySelectorAll('[data-preview-target]');
                
                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        const target = input.dataset.previewTarget;
                        const preview = document.getElementById(`preview-${target}`);
                        if (input.type === 'file' && input.files[0]) {
                            preview.src = URL.createObjectURL(input.files[0]);
                        } else if (target === 'work_hours') {
                            const lines = input.value.split('\n').filter(line => line.trim());
                            preview.innerHTML = lines.map(line => `<li>${line}</li>`).join('');
                        } else if (target === 'map_embed') {
                            preview.src = input.value || '{{ $libraryData['map_embed'] ?? 'https://www.google.com/maps?q=Stevana+Nemanje+2,+Novi+Pazar&output=embed' }}';
                        } else if (target === 'facebook' || target === 'twitter') {
                            preview.href = input.value || '#';
                        } else {
                            preview.textContent = input.value || '';
                        }
                    });
                });
            });
        </script>
    </div>
</x-app-layout>
