<nav style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
  <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl py-5 px-10">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <x-application-logo />
      <span class="block text-2xl sm:text-xl font-semibold break-words" style="color: var(--primary-text)">
        {{ $libraryData['name'] ?? '' }}<br /> {{ $libraryData['city'] ?? '' }}
      </span>
    </a>
    <div class="flex flex-col md:flex-row items-center justify-end flex-grow space-y-2 md:space-y-0 md:space-x-4">
      <form action="{{ route('search.index') }}" method="GET" class="w-full md:w-6/12">
        <label for="default-search" class="mb-2 text-sm font-medium sr-only" style="color: var(--primary-text)">Pretraži</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" style="color: var(--secondary-text)">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input
            type="search"
            name="q"
            id="default-search"
            style="color: var(--primary-text); border: 1px solid var(--secondary-text);"
            class="block w-full p-4 ps-10 text-sm rounded-lg focus:ring-2 bg-[color-mix(in_srgb,_var(--primary-bg)_95%,_black_5%)] dark:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
            placeholder="{{ __('header.search_placeholder') }}"
            required />
          <button
            type="submit"
            class="absolute end-2.5 bottom-2.5 md:bottom-2 font-medium rounded-lg text-sm px-3 py-1 md:px-4 md:py-2 bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]">
            {{ __('header.search_button') }}
          </button>
        </div>
      </form>

      <div class="flex items-center space-x-2 md:space-x-1">
        @php
        $locale = app()->getLocale();
        $flags = [
        'sr' => 'fi fi-rs',
        'sr-Cyrl' => 'fi fi-rs',
        'en' => 'fi fi-us',
        ];
        $languages = [
        'sr' => __('language_sr'),
        'sr-Cyrl' => __('language_sr_cy'),
        'en' => __('language_en'),
        ];
        $localeKey = $locale === 'sr-Cyrl' ? 'sr-Cyrl' : ($locale === 'sr' ? 'sr' : 'en');
        @endphp

        <button type="button" data-dropdown-toggle="language-dropdown-menu"
          class="inline-flex items-center font-medium justify-center px-2 py-1 text-sm rounded-lg cursor-pointer md:px-4 md:py-2 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
          style=" border-color: var(--secondary-text);">
          <span class="{{ $flags[$localeKey] ?? 'fi fi-rs' }} w-4 h-4 md:w-5 md:h-5 rounded-full me-1 md:me-3"></span>
          {{ $languages[$localeKey] ?? 'Srpski' }}
        </button>

        <div class="z-50 hidden my-4 text-base list-none rounded-lg shadow-sm" id="language-dropdown-menu" style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
          <ul class="py-1 font-medium" role="none">
            <li>
              <a href="{{ route('lang.switch', ['locale' => 'sr']) }}"
                class="block px-2 py-1 text-sm md:px-4 md:py-2 rounded bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--secondary-text);"
                role="menuitem">
                <div class="inline-flex items-center">
                  <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                  {{ __('language_sr') }}
                </div>
              </a>
            </li>
            <li>
              <a href="{{ route('lang.switch', ['locale' => 'sr-Cyrl']) }}"
                class="block px-2 py-1 text-sm md:px-4 md:py-2 rounded bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--secondary-text);"
                role="menuitem">
                <div class="inline-flex items-center">
                  <span class="fi fi-rs h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                  {{ __('language_sr_cy') }}
                </div>
              </a>
            </li>
            <li>
              <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                class="block px-2 py-1 text-sm md:px-4 md:py-2 rounded bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: var(--secondary-text);"
                role="menuitem">
                <div class="inline-flex items-center">
                  <span class="fi fi-us h-3 w-3 md:h-3.5 md:w-3.5 rounded-full me-1 md:me-2"></span>
                  {{ __('language_en') }}
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden mx-1 md:mx-6 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
        style="color: var(--secondary-text); border-color: var(--secondary-text);">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14" style="color: var(--secondary-text);">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>

      <button id="theme-toggle" type="button"
        class="rounded-lg text-sm p-1.5 md:p-2.5 mx-1 md:mx-6 bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
        style="color: var(--secondary-text); border-color: var(--secondary-text);">
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
  <div class="flex flex-wrap justify-center items-center mx-auto max-w-screen-xl p-4">
    <div id="mega-menu-full" class="items-center justify-between font-medium hidden w-full md:flex md:w-auto md:order-1">
      <ul class="flex flex-col p-4 md:p-0 mt-4 border rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0"
        style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
        @foreach ($mainSections as $section)
        @if ($subSections->has($section->id) || !$subSections->has($section->id))
        <li>
          @if ($subSections->has($section->id))
          <button id="mega-menu-full-dropdown-button-{{ $section->id }}" data-collapse-toggle="mega-menu-full-dropdown-{{ $section->id }}" class="flex items-center justify-between w-full py-1 px-2 text-sm md:text-lg rounded-sm md:w-auto md:p-0 hover:underline"
            style="color: var(--primary-text); background: var(--primary-bg); border-color: var(--secondary-text);">
            {{ $section->translate('name') }}
            <svg class="w-2 h-2 md:w-2.5 md:h-2.5 ms-1 md:ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" style="color: var(--secondary-text);">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
          </button>
          @else
          <a href="{{ $section->redirect_url}}" class="block py-1 px-2 text-sm md:text-lg rounded-sm md:p-0 hover:underline"
            style="color: var(--primary-text); background: var(--primary-bg); border-color: var(--secondary-text);">
            {{ $section->translate('name') }}
          </a>
          @endif
        </li>
        @endif
        @endforeach
      </ul>
    </div>
  </div>
  @foreach ($mainSections as $section)
  @if ($subSections->has($section->id))
  <div id="mega-menu-full-dropdown-{{ $section->id }}" class="mt-1 border shadow-sm border-y hidden overflow-y-auto max-h-64"
    style="background: var(--primary-bg); color: var(--primary-text); border-color: var(--secondary-text);">
    <div class="grid max-w-screen-xl px-2 py-3 mx-auto sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 md:px-4 md:py-4">
      @foreach ($subSections[$section->id] as $subSection)
      <div>
        <div class="font-semibold text-lg md:text-xl" style="color: var(--primary-text);">{{ $subSection->translate('name') }}</div>
        <hr class="border-t-2 mb-2 w-10/12" style="border-color: var(--secondary-text);">
        <ul class="space-y-1">
          @foreach ($subSection->children as $child)
          @if($child->is_active)
          <li>
            @php
            $isPdf = substr($child->redirect_url, -4) === '.pdf';
            @endphp
            <a href="{{ $child->redirect_url }}" {{ $isPdf ? 'target="_blank"' : '' }} class="block p-1 md:p-1 rounded-lg bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
              style="color: var(--secondary-text);">
              <div class="font-semibold" style="color: var(--secondary-text);">{{ $child->translate('name') }}</div>
            </a>
          </li>
          @endif
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
  </div>
  @endif
  @endforeach
</nav>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('#mega-menu-full [data-collapse-toggle]');
    let activeCollapse = null;

    buttons.forEach(button => {
      const targetId = button.getAttribute('data-collapse-toggle');
      const target = document.getElementById(targetId);
      const arrow = button.querySelector('svg');

      if (target && arrow) {
        button.addEventListener('click', () => {
          if (activeCollapse && activeCollapse !== target) {
            activeCollapse.classList.add('hidden');
            const prevButton = document.querySelector(`#mega-menu-full [data-collapse-toggle="${activeCollapse.id}"]`);
            if (prevButton) {
              prevButton.querySelector('svg').classList.remove('rotate-180');
            }
          }

          const isOpen = !target.classList.contains('hidden');
          target.classList.toggle('hidden');
          arrow.classList.toggle('rotate-180');

          activeCollapse = isOpen ? null : target;
        });
      }
    });
  });
</script>