<x-app-layout>
    <form
        action="{{ route('page.store') }}?sablon={{ $templateId }}{{ $isDraft ? '&slug='.$slug : '' }}"
        method="POST"
        enctype="multipart/form-data"
        class="flex">
        @csrf

        <input type="hidden" name="template_id" value="{{ $templateId }}">

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
                                    value="{{ old('title', $title) }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 dark:border-red-400 @enderror">
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
                                    value="{{ old('slug', $slug) }}"
                                    data-tooltip-target="tooltip-url"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('slug') border-red-500 dark:border-red-400 @enderror">
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
                                <div
                                    x-data="{ 
                                    main: {{ optional($parentSection)->id ?? (optional($currentSection)->id ?? 'null') }},
                                    sub: {{ optional($currentSection)->id ?? 'null' }},
                                    currentId: {{ optional($currentSection)->id ?? 'null' }},
                                    subSections: {} }"
                                    x-init="subSections = JSON.parse($refs.jsonSubSections.textContent);"
                                    class="flex flex-col gap-2">

                                    <span x-ref="jsonSubSections" class="hidden">
                                        @json($subSections)
                                    </span>

                                    <label for="main">{{__('main_section_label')}}</label>
                                    <select x-model="main" name="navigation[]" id="main" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('navigation.0') border-red-500 dark:border-red-400 @enderror">
                                        <option value="">Izaberi glavnu sekciju</option>
                                        @foreach ($mainSections as $section)
                                        @php
                                        $isSelectedMain = $section->id === optional($currentSection)->id || $section->id === optional($parentSection)->id;
                                        $isActive = ($section->redirect_url && $section->is_active) ? true : false;
                                        @endphp
                                        <option
                                            value="{{ $section->id }}"
                                            {{ $isActive ? 'disabled' : '' }}
                                            {{ $isSelectedMain ? 'selected' : '' }}>
                                            {{ $section->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('navigation.0')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                    @enderror

                                    <label for="sub" x-show="main" class="mt-6">{{__('sub_section_label')}}</label>
                                    <select x-model="sub" name="navigation[]" id="sub" x-show="main" :disabled="!main" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Podkategorija navigacije</option>
                                        <template x-for="item in subSections[main] || []" :key="item.id">
                                            <option :value="item.id" x-text="item.name" :selected="item.id === currentId"></option>
                                        </template>
                                    </select>
                                    @error('navigation.1')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="flex flex-col mt-auto">
                        <button
                            type="submit"
                            name="action"
                            value="draft"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Sačuvaj promene</button>
                        <button
                            type="submit"
                            name="action"
                            value="publish"
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Objavi</button>
                    </div>
                </div>
            </aside>
        </div>
        <div class="min-h-screen w-full flex items-center justify-center">
            @include('templates.template' . $templateId)
        </div>
    </form>
</x-app-layout>