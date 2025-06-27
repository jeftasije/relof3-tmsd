<x-app-layout>
    <div
        x-data="{
        main: {{ optional($parentSection)->id ?? (optional($currentSection)->id ?? 'null') }},
        sub: {{ optional($currentSection)->id ?? 'null' }},
        currentId: {{ optional($currentSection)->id ?? 'null' }},
        subSections: {},
        titleValue: '{{ old('title', $title) }}',
        slugValue: '{{ old('slug', $slug) }}',
        loading: false
    }"
        x-init="
        subSections = JSON.parse($refs.jsonSubSections.textContent);
        $refs.hiddenTitle.value = $refs.title?.value;
        $refs.hiddenSlug.value = $refs.slug?.value;
        $refs.hiddenMain.value = main;
        $refs.hiddenSub.value = sub;
    "
        x-effect="
        $refs.hiddenTitle.value = $refs.title?.value;
        $refs.hiddenSlug.value = $refs.slug?.value;
        $refs.hiddenMain.value = main;
        $refs.hiddenSub.value = sub;
    ">
        <div class="fixed top-0 right-0">
            <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-placement="right" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>

            <aside id="sidebar-multi-level-sidebar" class="fixed top-0 right-0 z-40 w-64 h-screen transition-transform translate-x-full sm:translate-x-0" aria-label="Sidebar">
                <div class="flex flex-col h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 dark:text-white">
                    <div class="text-center font-semibold text-lg mb-10">
                        {{__('page_settings')}}
                    </div>
                    <ul class="space-y-2 font-medium gap-5">
                        <li>
                            <div class="mb-6">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{__('name_label')}}
                                </label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    x-ref="title"
                                    x-model="titleValue"
                                    value="{{ old('title', $title) }}"
                                    {{ isset($page) && !$page->is_deletable ? 'disabled' : '' }}
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </li>
                        <li>
                            <div class="mb-6">
                                <label for="slug" data-tooltip-target="tooltip-url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{__('url_label')}}
                                </label>
                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    x-ref="slug"
                                    x-model="slugValue"
                                    value="{{ old('slug', $slug) }}"
                                    data-tooltip-target="tooltip-url"
                                    {{ isset($page) && !$page->is_deletable ? 'disabled' : '' }}
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                                @enderror

                                <div id="tooltip-url" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    {{__('url_tooltip')}}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="mb-6">
                                <div class="flex flex-col gap-2">
                                    <span x-ref="jsonSubSections" class="hidden">
                                        @json($subSections)
                                    </span>

                                    <label for="main">{{__('main_section_label')}}</label>
                                    <select x-model="main" x-ref="main" name="navigation[]" @change="$refs.hiddenMain.value = main" id="main" {{ (isset($page) && !$page->is_deletable) ? 'disabled' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('navigation.0') border-red-500 dark:border-red-400 @enderror disabled:bg-gray-200 disabled:cursor-not-allowed disabled:text-gray-400 dark:disabled:bg-gray-600 dark:disabled:text-gray-500">
                                        @if(!isset($page) || $page->is_deletable)
                                        <option value="">
                                            @switch(App::getLocale())
                                            @case('en') Select main section @break
                                            @case('sr-Cyrl') Изабери главну секцију @break
                                            @default Izaberi glavnu sekciju
                                            @endswitch
                                        </option>
                                        @foreach ($mainSections as $section)
                                        @php
                                        $isSelectedMain = $section->id === optional($currentSection)->id || $section->id === optional($parentSection)->id;
                                        $isActive = ($section->children()->count() === 0) ? true : false;
                                        @endphp
                                        <option
                                            value="{{ $section->id }}"
                                            {{ $isActive ? 'disabled' : '' }}
                                            {{ $isSelectedMain ? 'selected' : '' }}>
                                            {{ $section->translate('name') }}
                                        </option>
                                        @endforeach
                                        @else
                                        <option value="{{ ($parentSection === null) ? $currentSection->id : $parentSection->id }}">{{ ($parentSection === null) ? $currentSection->name : $parentSection->name }}</option>
                                        @endif
                                    </select>
                                    @error('navigation.0')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                    @enderror

                                    <label for="sub" x-ref="sub" x-show="main" class="mt-6">{{__('sub_section_label')}}</label>
                                    <select x-model="sub" name="navigation[]" id="sub" @change="$refs.hiddenSub.value = sub" x-show="main" :disabled="!main" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">
                                            @switch(App::getLocale())
                                            @case('en') Navigation subcategory @break
                                            @case('sr-Cyrl') Подкатегорија навигације @break
                                            @default Podkategorija navigacije
                                            @endswitch
                                        </option>
                                        <template x-for="item in subSections[main] || []" :key="item.id">
                                            <option :value="item.id" x-text="item.name{{ App::getLocale() === 'en' ? '_en' : (App::getLocale() === 'sr-Cyrl' ? '_cy' : '') }}" :selected="item.id === currentId"></option>
                                        </template>
                                    </select>
                                    @error('navigation.1')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </li>
                    </ul>
                    @php
                    $isEnglish = request()->query('en') === 'true';
                    @endphp
                    <div class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <input {{ $isEnglish ? '' : 'checked' }} id="language-radio-button-sr" type="radio" form="page-form" value="sr" name="language-radio-button" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="language-radio-button-sr" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                @switch(App::getLocale())
                                @case('en') Serbian @break
                                @case('sr-Cyrl') Српски @break
                                @default Srpski
                                @endswitch
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input {{ $isEnglish ? 'checked' : '' }} id="language-radio-button-en" type="radio" form="page-form" value="en" name="language-radio-button" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="language-radio-button-en" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                @switch(App::getLocale())
                                @case('en') English @break
                                @case('sr-Cyrl') Енглески @break
                                @default Engleski
                                @endswitch
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col mt-auto">
                        <button
                            type="submit"
                            name="action"
                            value="draft"
                            form="page-form"
                            @click="
                                loading = true;
                                $refs.actionInput.value = 'draft';
                                $refs.form.submit();
                            "
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Sačuvaj promene</button>
                        <button
                            type="submit"
                            name="action"
                            value="publish"
                            form="page-form"
                            @click="
                                loading = true;
                                $refs.actionInput.value = 'publish';
                                $refs.form.submit();
                            "
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Objavi</button>
                    </div>
                </div>
            </aside>
        </div>
        <form id="page-form"
            action="{{ route('page.store') }}?sablon={{ $templateId }}{{ $isDraft ? '&slug='.$slug : '' }}"
            method="POST"
            enctype="multipart/form-data"
            class="hidden">

            @csrf
            <input type="hidden" name="template_id" value="{{ $templateId }}">
            <input type="hidden" name="title" :value="titleValue">
            <input type="hidden" name="slug" :value="slugValue">
            <input type="hidden" name="navigation[]" x-ref="hiddenMain" :value="main">
            <input type="hidden" name="navigation[]" x-ref="hiddenSub" :value="sub">
        </form>
        <div
            x-show="loading"
            x-transition
            class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 mb-6 text-orange-800 bg-orange-100 border border-orange-300 p-4 rounded shadow-lg">
            @switch(App::getLocale())
            @case('en') Please wait... @break
            @case('sr-Cyrl') Молимо сачекајте... @break
            @default Molimo sačekajte...
            @endswitch
        </div>
        @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
            @switch(App::getLocale())
            @case('en') Saved successfully @break
            @case('sr-Cyrl') Успешно сачувано @break
            @default Uspešno sačuvano
            @endswitch
        </div>
        @endif

        @if(!isset($page) || $page->is_deletable)
        <div class="min-h-screen w-full flex items-center justify-center">
            @include('templates.template' . $templateId)
        </div>
        @else
        <div class="flex-1 pr-64">
            {!! $basePageContent !!}
        </div>
        @endif
    </div>

</x-app-layout>

<script>
    document.getElementById('language-radio-button-en').addEventListener('change', function() {
        if (this.checked) {
            const slug = @json($slug);
            const url = `/uredi-stranicu/${slug}?en=true`;
            window.location.href = url;
        }
    });
</script>