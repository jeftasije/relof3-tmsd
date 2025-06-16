<footer class="bg-white dark:bg-gray-900">
  <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
    <div class="flex flex-col md:flex-row md:justify-between md:flex-wrap gap-6">
      
      <div class="flex-grow md:flex-grow-0 md:basis-1/3 mb-6 md:mb-0">
        <a class="flex flex-col items-start">
          <x-application-logo/>
          <span class="text-2xl font-semibold whitespace-normal max-w-xs break-words dark:text-white">
            {{ $libraryData['name'] ?? '' }}
          </span>
          <div class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            <p>{{ $libraryData['address_label'] ?? 'Adresa' }}: {{ $libraryData['address'] ?? '' }}</p>
            <p>{{ $libraryData['pib_label'] ?? 'PIB' }}: {{ $libraryData['pib'] ?? '' }}</p>
          </div>
        </a>
      </div>

      <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2 md:basis-1/3 flex-grow">
        <div>
          <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">{{ $libraryData['work_hours_label'] ?? 'Radno vreme' }}</h2>
          <ul class="text-gray-500 dark:text-gray-400 font-medium">
            @foreach ($libraryData['work_hours_formatted'] ?? [] as $line)
              <li>{{ $line }}</li>
            @endforeach
          </ul>
        </div>

        <div>
          <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">{{ $libraryData['phone_label'] ?? 'Kontakt' }}</h2>
          <ul class="text-gray-500 dark:text-gray-400 font-medium space-y-2 mb-4">
            <li><i class="fas fa-phone me-2"></i> {{ $libraryData['phone'] ?? '' }}</li>
            <li><i class="fas fa-envelope me-2"></i> {{ $libraryData['email'] ?? '' }}</li>
          </ul>

          <div class="flex space-x-4 mt-2">
            <a href="{{ $libraryData['facebook'] ?? '#' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Facebook page">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 8 19" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
              </svg>
            </a>
            <a href="{{ $libraryData['twitter'] ?? '#' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Twitter page">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
              </svg>
            </a>
            <a href="mailto:{{ $libraryData['email'] ?? 'dositejbib@gmail.com' }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white" aria-label="Email">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a3 3 0 0 0 3.22 0L21 8m-18 0v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8M3 8V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2"/>
              </svg>
            </a>
          </div>
        </div>
      </div>

      <div class="mt-6 md:mt-0 md:basis-1/4 w-full md:w-auto">
        <iframe
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
      {{ $libraryData['copyrights'] ?? '' }} <a href="#" class="hover:underline">{{ $libraryData['name'] ?? '' }}</a>.
    </div>
  </div>
</footer>