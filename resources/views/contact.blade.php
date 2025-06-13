<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Kontakt
        </h2>
    </x-slot>

    <div class="w-full">
        <div class="w-full">
            <section 
                class="relative w-full bg-gray-900 bg-cover bg-center bg-no-repeat min-h-screen py-12" 
                style="background-image: url('/images/contact.jpg');">
            
                <div class="absolute inset-0 bg-black/30"></div>

                <div class="relative z-10 py-8 lg:py-16 px-6 mx-auto max-w-screen-md 
                    backdrop-blur-sm rounded-lg shadow-lg transition-colors duration-300
                    bg-white/80 dark:bg-gray-900/80">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                        Kontaktirajte nas
                    </h2>
                    <p class="mb-8 lg:mb-16 font-light text-center text-gray-600 dark:text-gray-300 sm:text-xl">
                        Naš tim je tu da odgovori na sva vaša pitanja i obezbedi vam najbolju moguću uslugu!
                    </p>
                    
                    <form action="#" class="space-y-6">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ime<span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" name="first_name" required
                                    class="shadow-sm bg-white dark:bg-blue-950 dark:text-white dark:border-blue-800 
                                           border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                           focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Pera">
                            </div>
                            <div>
                                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Prezime <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="last_name" name="last_name" required
                                    class="shadow-sm bg-white dark:bg-blue-950 dark:text-white dark:border-blue-800 
                                           border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                           focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Peric">
                            </div>
                        </div>

                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email
                                </label>
                                <input type="email" id="email" name="email"
                                    class="shadow-sm bg-white dark:bg-blue-950 dark:text-white dark:border-blue-800 
                                           border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                           focus:border-blue-500 block w-full p-2.5"
                                    placeholder="name@example.com">
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Telefon
                                </label>
                                <input type="tel" id="phone" name="phone"
                                    class="shadow-sm bg-white dark:bg-blue-950 dark:text-white dark:border-blue-800 
                                           border border-gray-300 text-sm rounded-lg focus:ring-blue-500 
                                           focus:border-blue-500 block w-full p-2.5"
                                    placeholder="">
                            </div>
                        </div>

                        
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Poruka <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                class="block p-2.5 w-full text-sm text-gray-900 dark:text-white 
                                       bg-white dark:bg-blue-950 rounded-lg shadow-sm border 
                                       border-gray-300 dark:border-blue-800 focus:ring-blue-500 
                                       focus:border-blue-500">
                            </textarea>
                        </div>

                        
                        <div class="flex justify-center">
                            <button type="submit" 
                                class="py-3 px-5 font-semibold text-center text-white rounded-lg 
                                       bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none 
                                       focus:ring-blue-300">
                                Pošalji poruku
                            </button>

                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
