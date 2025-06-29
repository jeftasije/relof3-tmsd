<div class="max-w-sm rounded-lg shadow-sm border" style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%); border-color: var(--secondary-text);">
    <div>
        <img class="rounded-t-lg" src="{{ asset('storage' . $template->thumbnail) }}" alt="{{ $template->title }}" />
    </div>
    <div class="p-5">
        <div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight" style="color: var(--primary-text); font-family: var(--font-title);">
                {{ $template->translate('title') }}
            </h5>
        </div>
        <p class="mb-3 font-normal" style="color: var(--secondary-text); font-family: var(--font-body);">
            {{ $template->translate('description') }}
        </p>
        <a href="/kreiraj-stranicu?sablon={{ $template->id}}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg"
           style="background: var(--accent); color: #fff;">
            {{ App::getLocale() === 'en' ? 'Use this template' : (App::getLocale() === 'sr-Cyrl' ? 'Користи овај шаблон' : 'Koristi ovaj šablon') }}
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </a>
    </div>
</div>