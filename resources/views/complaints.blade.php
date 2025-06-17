<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Žalbe i komentari
        </h2>
    </x-slot>

    <div class="w-full">
        <section 
            class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat py-12" 
            style="background-image: url('/images/contact.jpg');">
        
            <div class="absolute inset-0 bg-black/30"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-12 px-6 py-12">
                    <div class="flex flex-col">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                            {{ App::getLocale() === 'en' ? 'How to file a complaint?' : 'Kako podneti žalbu?' }}
                        </h3>

                        <p class="mb-6 text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' ? 'If you have any complaints, suggestions, or questions regarding the work of our library, you can contact us in several ways:' : 'Ukoliko imate bilo kakvu primedbu, sugestiju ili pitanje vezano za rad naše biblioteke, možete nas kontaktirati na nekoliko načina:' }}
                        </p>
                        <ul class="list-disc list-inside mb-6 text-gray-700 dark:text-gray-300 pl-4">
                            <p>
                                @if(App::getLocale() === 'en')
                                    <li>Fill out the online form on the right — your opinion is important to us and we will do our best to respond as soon as possible.</li>
                                    <li>Call us by phone at: <strong>+381 (0)20 331 010</strong> (weekdays from 08:00 to 16:00 and weekends from 08:00 to 14:00).</li>
                                    <li>Visit us in person at the library at: <strong>Stefana Nemanje 2, Novi Pazar</strong>, where you can directly talk to our staff and submit a complaint or give feedback.</li>
                                @else
                                    <li>Popunite online formu sa desne strane — vaše mišljenje nam je važno i potrudićemo se da odgovorimo u najkraćem roku.</li>
                                    <li>Pozovite nas telefonom na broj: <strong>+381 (0)20 331 010</strong> (radnim danima od 08:00 do 16:00 i vikendom od 08:00 do 14:00).</li>
                                    <li>Posetite nas lično u biblioteci na adresi: <strong>Stefana Nemanje 2, Novi Pazar</strong>, gde možete direktno razgovarati sa našim osobljem i podneti žalbu ili dati komentar.</li>
                                @endif
                            </p>
                        </ul>

                        <p class="mb-6 text-gray-700 dark:text-gray-300">
                            {{ App::getLocale() === 'en' 
                                ? 'Your feedback helps us improve our services and provide a better experience for all users.' 
                                : 'Vaš glas nam pomaže da unapredimo naše usluge i obezbedimo bolje iskustvo za sve korisnike.' }}
                        </p>

                        <div class="text-center mt-auto">
                            <a href="/documents/uputstvo_za_zalbe.pdf" 
                            class="inline-block text-blue-600 hover:underline dark:text-blue-400" 
                            download>
                                {{ App::getLocale() === 'en' 
                                    ? 'Download the instructions in PDF format' 
                                    : 'Preuzmite uputstvo u PDF formatu' }}
                            </a>
                        </div>

                    </div>

                    <div>
                        <h2 class="mb-4 text-3xl font-bold text-center text-gray-900 dark:text-white">
                            {{ App::getLocale() === 'en' ? 'Every question, suggestion or criticism is welcome!' : 'Svako Vaše pitanje, sugestija ili kritika je dobrodošla!' }}
                        </h2>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('complaints.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ App::getLocale() === 'en' ? 'First Name' : 'Ime' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('first_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ App::getLocale() === 'en' ? 'Last Name' : 'Prezime' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ App::getLocale() === 'en' ? 'Email' : 'Email' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ App::getLocale() === 'en' ? 'Phone' : 'Telefon' }}
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">
                                    @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ App::getLocale() === 'en' ? 'Message' : 'Poruka' }} <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" rows="5" required
                                    class="shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200 block w-full p-2.5">{{ old('message') }}</textarea>
                                @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-center">
                                <button type="submit" 
                                    class="py-3 px-5 font-semibold text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    {{ App::getLocale() === 'en' ? 'Submit Complaint' : 'Pošalji žalbu' }}
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Deo za komentare ispod žalbi -->
                <div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
                    <h2 class="mb-6 text-3xl font-bold text-gray-900 dark:text-white text-center">Komentari</h2>
                    {{-- Ovde ubaci kod za prikaz komentara --}}
                </div>

            </div>
        </section>
    </div>
</x-guest-layout>