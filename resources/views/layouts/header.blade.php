<nav class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
  <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl py-5 px-10">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <x-application-logo />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Narodna biblioteka "Dositej Obradović"<br /> Novi Pazar</span>
    </a>
    <div class="flex flex-col md:flex-row items-center justify-end flex-grow space-y-2 md:space-y-0 md:space-x-4">
      <form class="w-full md:w-6/12">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Pretraži</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pretražite sajt..." required />
          <button type="submit" class="text-white absolute end-2.5 bottom-2.5 md:bottom-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1 md:px-4 md:py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pretraži</button>
        </div>
      </form>
      <div class="flex items-center space-x-2 md:space-x-1">
        <button type="button" data-dropdown-toggle="language-dropdown-menu" class="inline-flex items-center font-medium justify-center px-2 py-1 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white md:px-4 md:py-2">
          <span class="fi fi-rs w-4 h-4 md:w-5 md:h-5 rounded-full me-1 md:me-3"></span>
          Srpski
        </button>
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700" id="language-dropdown-menu">
          <ul class="py-1 font-medium" role="none">
            <li>
              <a href="#" class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2" role="menuitem">
                <div class="inline-flex items-center">
                  <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                  Srpski
                </div>
              </a>
            </li>
            <li>
              <a href="#" class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white md:px-4 md:py-2" role="menuitem">
                <div class="inline-flex items-center">
                  <span class="fi fi-us h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                  English (US)
                </div>
              </a>
            </li>
          </ul>
        </div>
        <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu-full" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
          </svg>
          </a>
        </button>
        <button id="theme-toggle" type="button" class="text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5 md:p-2.5 mx-1 md:mx-6">
          <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
          </svg>
          <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
          </svg>
          <span class="sr-only">Toggle dark mode</span>
        </button>
      </div>
    </div>
  </div>
  </div>
  <div class="flex flex-wrap justify-center items-center mx-auto max-w-screen-xl p-4">
    <div id="mega-menu-full" class="items-center justify-between font-medium hidden w-full md:flex md:w-auto md:order-1">
      <ul class="flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        @foreach ($mainSections as $section)
        @if ($subSections->has($section->id) || !$subSections->has($section->id))
        <li>
          @if ($subSections->has($section->id))
          <button id="mega-menu-full-dropdown-button-{{ $section->id }}" data-collapse-toggle="mega-menu-full-dropdown-{{ $section->id }}" class="flex items-center justify-between w-full py-1 px-2 text-sm md:text-lg text-gray-900 rounded-sm md:w-auto hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
            {{ $section->name }}
            <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
          </button>
          @else
          <a href="{{ $section->redirect_url}}" class="block py-1 px-2 text-sm md:text-lg text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">{{ $section->name }}</a>
          @endif
        </li>
        @endif
        @endforeach
      </ul>
    </div>
  </div>
  @foreach ($mainSections as $section)
  @if ($subSections->has($section->id))
  <div id="mega-menu-full-dropdown-{{ $section->id }}" class="mt-1 border-gray-200 shadow-sm bg-gray-50 md:bg-white border-y dark:bg-gray-800 dark:border-gray-600 hidden overflow-y-auto max-h-64">
    <div class="grid max-w-screen-xl px-2 py-3 mx-auto text-gray-900 dark:text-white sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 md:px-4 md:py-4">
      @foreach ($subSections[$section->id] as $subSection)
      <div>
        <div class="font-semibold text-lg md:text-xl">{{ $subSection->name }}</div>
        <hr class="border-t-2 border-white mb-2 w-10/12">
        <ul class="space-y-1">
          @foreach ($subSection->children as $child)
          <li>
            @php
            $isPdf = substr($child->redirect_url, -4) === '.pdf';
            @endphp
            <a href="{{ $child->redirect_url }}" {{ $isPdf ? 'target="_blank"' : '' }} class="block p-1 md:p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-sm md:text-base">
              <div class="font-semibold">{{ $child->name }}</div>
            </a>
          </li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
  </div>
  @endif
  @endforeach
</nav>