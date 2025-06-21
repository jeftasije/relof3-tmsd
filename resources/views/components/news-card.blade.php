@php
    $skills = is_array($extendedBiography->skills) ? $extendedBiography->skills : (array) $extendedBiography->skills;
@endphp
{{ implode(', ', $skills) }}
<div 
  class="relative max-w-sm h-full bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col"
  style="box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);"
  x-data="{
    editing: false,
    title: @js($news->translate('title')),
    summary: @js($news->translate('summary')),
    originalTitle: @js($news->translate('title')),
    originalSummary: @js($news->translate('summary')),
    image: '{{ asset($news->image_path ?? '/images/default-news.jpg') }}',
    newImage: null,
    saving: false,
    async save() {
      this.saving = true;
      try {
        // Prvo sacuvaj tekstualne izmene
        const response = await fetch('{{ route('news.update', $news->id) }}', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          },
          body: JSON.stringify({
            title: this.title,
            summary: this.summary,
            locale: '{{ App::getLocale() }}'
          }),
        });
        if (!response.ok) throw new Error('Save failed');
        // Ako ima nova slika, uploaduj je posebno
        if(this.newImage) {
          const formData = new FormData();
          formData.append('image', this.newImage);
          formData.append('_token', '{{ csrf_token() }}');
          const imgResp = await fetch('{{ route('news.uploadImage', $news->id) }}', {
            method: 'POST',
            body: formData
          });
          if(!imgResp.ok) throw new Error('Image upload failed');
          const imgData = await imgResp.json();
          if (imgData.image_path) {
            this.image = imgData.image_path;
          }
        }
        this.originalTitle = this.title;
        this.originalSummary = this.summary;
        this.editing = false;
        this.newImage = null;
      } catch (e) {
        alert('Greška pri čuvanju podataka');
      } finally {
        this.saving = false;
      }
    },
    cancel() {
      this.title = this.originalTitle;
      this.summary = this.originalSummary;
      this.editing = false;
      this.newImage = null;
      this.image = '{{ asset($news->image_path ?? '/images/default-news.jpg') }}';
    },
    previewImage(event) {
      const file = event.target.files[0];
      if(file){
        this.newImage = file;
        this.image = URL.createObjectURL(file);
      }
    }
  }"
>
  @auth
  <div class="absolute bottom-2 right-2 z-10">
    <template x-if="!editing">
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </button>
        <div x-show="open" @click.away="open = false" class="absolute bottom-full right-0 mb-2 w-32 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg z-20">
          <button 
            @click.prevent="editing = true; open = false" 
            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
          >
            {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
          </button>
          <form method="POST" action="{{ route('news.destroy', $news->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600"
              onclick="return confirm('{{ __('Are you sure you want to delete this news?') }}');"
            >
              {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
            </button>
          </form>
        </div>
      </div>
    </template>
  </div>
  @endauth

  <div class="overflow-hidden rounded-t-lg group relative cursor-pointer" style="box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);">
    <img
      class="w-full h-48 object-cover transform transition-transform duration-300 group-hover:scale-105"
      :src="image"
      alt="{{ $news->title }}"
      onerror="this.src='{{ asset('/images/default-news.jpg') }}';"
      @click="editing ? $refs.imgInput.click() : null"
      :class="editing ? 'ring-2 ring-blue-400 cursor-pointer' : ''"
      title="{{ App::getLocale() === 'en' ? 'Change image' : (App::getLocale() === 'sr-Cyrl' ? 'Промени слику' : 'Promeni sliku') }}"
    />
    <input 
      x-ref="imgInput"
      type="file"
      accept="image/*"
      class="hidden"
      @change="previewImage"
      :disabled="!editing"
    />
    <template x-if="editing">
      <span class="absolute bottom-3 right-3 bg-blue-600 text-white px-3 py-1 rounded shadow text-xs">
        {{ App::getLocale() === 'en' ? 'Click to change image' : (App::getLocale() === 'sr-Cyrl' ? 'Кликни за измену слике' : 'Klikni za izmenu slike') }}
      </span>
    </template>
  </div>

  <div class="p-5 flex flex-col flex-grow justify-between" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1) inset;">
    <div>
      <template x-if="!editing">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" x-text="title" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);"></h5>
      </template>
      <template x-if="editing">
        <input x-model="title" type="text" class="mb-2 w-full p-2 border rounded dark:bg-gray-700 dark:text-white" />
      </template>

      <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
        {{ $news->translate('author') ?? (App::getLocale() === 'en' ? 'Unknown author' : (App::getLocale() === 'sr-Cyrl' ? 'Непознат аутор' : 'Nepoznat autor')) }} • {{ \Carbon\Carbon::parse($news->published_at)->format('d.m.Y') }}
      </p>

      <template x-if="!editing">
        <p class="mb-4 font-normal text-gray-700 dark:text-gray-400" x-text="summary" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);"></p>
      </template>
      <template x-if="editing">
        <textarea x-model="summary" rows="3" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
      </template>
    </div>

    <div class="mt-4 flex justify-between items-center">
      <template x-if="editing">
        <div class="flex space-x-2">
          <button 
            @click.prevent="save()" 
            :disabled="saving"
            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
          >
            {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
          </button>
          <button 
            @click.prevent="cancel()" 
            :disabled="saving"
            class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 disabled:opacity-50"
          >
            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Одустани' : 'Otkaži') }}
          </button>
        </div>
      </template>

      <a href="{{ route('news.show', $news->id) }}"
         class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
         style="box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);">
        {{ App::getLocale() === 'en' ? 'Show more' : (App::getLocale() === 'sr-Cyrl' ? 'Прикажи више' : 'Prikaži više') }}
        <svg class="rtl:rotate-180 w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
      </a>
    </div>
  </div>
</div>