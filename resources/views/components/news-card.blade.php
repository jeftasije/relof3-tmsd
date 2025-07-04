<div 
  class="relative max-w-sm h-full rounded-lg shadow-lg flex flex-col transition duration-300 hover:-translate-y-1 hover:scale-105"
  style="box-shadow: 5px 5px 15px rgba(0,0,0,0.25); background: var(--primary-bg) !important; border: 1px solid var(--secondary-text) !important;"
  x-data="{
    editing: false,
    title: @js($news->translate('title')),
    summary: @js($news->translate('summary')),
    originalTitle: @js($news->translate('title')),
    originalSummary: @js($news->translate('summary')),
    image: '{{ asset($news->image_path ?? '/images/default-news.jpg') }}',
    newImage: null,
    saving: false,
    showDeleteModal: false,
    confirmDeleteUrl: '',
    showSuccess: false,
    successMessage: '',
    showToast(msg) {
      this.successMessage = msg;
      this.showSuccess = true;
      setTimeout(() => { this.showSuccess = false }, 2000);
    },
    async save() {
      this.saving = true;
      try {
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
            this.image = imgData.image_path + '?' + (new Date()).getTime();
          }
        }
        this.originalTitle = this.title;
        this.originalSummary = this.summary;
        this.editing = false;
        this.newImage = null;
        let locale = '{{ App::getLocale() }}';
        let msg = locale === 'en'
            ? 'Changes saved successfully!'
            : (locale === 'sr-Cyrl'
                ? 'Успешно сте сачували измене!'
                : 'Uspešno ste sačuvali izmene!');
        this.showToast(msg);
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
    },
    openDeleteModal(url) {
      this.confirmDeleteUrl = url;
      this.showDeleteModal = true;
    },
    closeDeleteModal() {
      this.confirmDeleteUrl = '';
      this.showDeleteModal = false;
    },
    confirmDelete() {
      this.$refs.deleteForm.submit();
    }
  }"
>
  <div style="background: color-mix(in srgb, var(--primary-bg) 75%, #000 25%); border-radius: 0.5rem;" class="absolute inset-0 z-0 pointer-events-none"></div>
  <div class="relative z-10 flex flex-col h-full">
    @auth
      <div class="absolute bottom-2 right-2 z-10">
        <template x-if="!editing">
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="focus:outline-none" style="color: var(--secondary-text) !important;">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </button>
            <div x-show="open" @click.away="open = false" 
                class="absolute bottom-full right-0 mb-2 w-32 rounded-md shadow-lg z-20"
                style="background: var(--primary-bg) !important; border: 1px solid var(--secondary-text) !important;">
              <button 
                @click.prevent="editing = true; open = false" 
                class="block w-full text-left px-4 py-2 text-sm bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]">
                {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
              </button>
              <button 
                @click.prevent="openDeleteModal('{{ route('news.destroy', $news->id) }}'); open = false"
                class="w-full text-left px-4 py-2 text-sm bg-[var(--primary-bg)] hover:bg-[color-mix(in_srgb,_var(--primary-bg)_80%,_black_20%)]"
                style="color: #dc2626 !important;"
              >
                {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
              </button>
            </div>
          </div>
        </template>
      </div>
    @endauth

    <div class="overflow-hidden rounded-t-lg group relative cursor-pointer" style="box-shadow: 3px 3px 10px rgba(0,0,0,0.2);">
      <img
        class="w-full h-48 object-cover transform transition-transform duration-300 group-hover:scale-105"
        :src="image"
        alt="{{ $news->title }}"
        onerror="this.src='{{ asset('/images/default-news.jpg') }}';"
        @click="editing ? $refs.imgInput.click() : null"
        :class="editing ? 'blur-[4px] brightness-90 cursor-pointer' : ''"
        title="{{ App::getLocale() === 'en' ? 'Change image' : (App::getLocale() === 'sr-Cyrl' ? 'Промени слику' : 'Promeni sliku') }}"
        style="transition: filter 0.3s, transform 0.3s;"
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
        <div class="absolute inset-0 flex items-center justify-center"
          style="backdrop-filter: blur(6px); background: rgba(50, 120, 255, 0.18); color: #fff; font-size: 1.125rem; font-weight: bold; pointer-events: none; transition: background 0.2s;">
          {{ App::getLocale() === 'en' ? 'Change image' : (App::getLocale() === 'sr-Cyrl' ? 'Промени слику' : 'Promeni sliku') }}
        </div>
      </template>
    </div>

    <div class="p-5 flex flex-col flex-grow justify-between">
      <div>
        <template x-if="!editing">
          <h5 class="mb-2 text-2xl font-bold tracking-tight" x-text="title"
              style="color: var(--primary-text) !important; text-shadow: 1px 1px 3px rgba(0,0,0,0.1);"></h5>
        </template>
        <template x-if="editing">
          <input x-model="title" type="text" class="mb-2 w-full p-2 border rounded" 
                 style="background: var(--primary-bg) !important; color: var(--primary-text) !important;" />
        </template>

        <p class="mb-2 text-sm font-medium" style="color: var(--secondary-text) !important;">
          {{ $news->translate('author') ?? (App::getLocale() === 'en' ? 'Unknown author' : (App::getLocale() === 'sr-Cyrl' ? 'Непознат аутор' : 'Nepoznat autor')) }} • {{ \Carbon\Carbon::parse($news->published_at)->format('d.m.Y') }}
        </p>

        <template x-if="!editing">
          <p class="mb-4 font-normal" x-text="summary"
             style="color: var(--primary-text) !important; text-shadow: 1px 1px 3px rgba(0,0,0,0.1);"></p>
        </template>
        <template x-if="editing">
          <textarea x-model="summary" rows="3" class="w-full p-2 border rounded"
                    style="background: var(--primary-bg) !important; color: var(--primary-text) !important;"></textarea>
        </template>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <template x-if="editing">
          <div class="flex space-x-2">
            <button 
              @click.prevent="save()" 
              :disabled="saving"
              class="px-3 py-1 rounded bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)] disabled:opacity-50"
              style="color: #fff !important;">
              {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
            </button>
            <button 
              @click.prevent="cancel()" 
              :disabled="saving"
              class="px-3 py-1 rounded hover:bg-gray-600 bg-gray-500 disabled:opacity-50"
              style="color: var(--primary-text) !important;">
              {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Одустани' : 'Otkaži') }}
            </button>
          </div>
        </template>
        <a href="{{ route('news.show', $news->id) }}"
           class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg focus:ring-4 focus:outline-none bg-[var(--accent)] hover:bg-[color-mix(in_srgb,_var(--accent)_80%,_black_20%)]"
           style="box-shadow: 2px 2px 6px rgba(0,0,0,0.2);">
          {{ App::getLocale() === 'en' ? 'Show more' : (App::getLocale() === 'sr-Cyrl' ? 'Прикажи више' : 'Prikaži više') }}
          <svg class="rtl:rotate-180 w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
               fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M1 5h12m0 0L9 1m4 4L9 9"/>
          </svg>
        </a>
      </div>
    </div>

    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5); display: none;">
      <div class="rounded-lg shadow-lg w-full max-w-md p-6"
           style="background: var(--primary-bg) !important; color: var(--primary-text) !important;">
        <h3 class="text-lg font-semibold mb-4">
          {{ App::getLocale() === 'en' ? 'Confirm Deletion' : (App::getLocale() === 'sr-Cyrl' ? 'Потврда брисања' : 'Potvrda brisanja') }}
        </h3>
        <p class="mb-6" style="color: var(--secondary-text) !important;">
          {{ App::getLocale() === 'en' ? 'Are you sure you want to delete this news?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете ову вест?' : 'Da li ste sigurni da želite da obrišete ovu vest?') }}
        </p>
        <div class="flex justify-end gap-2">
          <button @click="closeDeleteModal()" class="px-4 py-2 rounded hover:bg-gray-600 bg-gray-500 disabled:opacity-50"
            style="color: var(--primary-text) !important;">
            {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
          </button>
          <form :action="confirmDeleteUrl" method="POST" x-ref="deleteForm">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded hover:bg-red-600  bg-red-500"
              style="color: #fff !important;">
              {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
            </button>
          </form>
        </div>
      </div>
    </div>

    <div
      x-show="showSuccess"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-90 -translate-y-6"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 scale-100 translate-y-0"
      x-transition:leave-end="opacity-0 scale-90 -translate-y-6"
      class="fixed left-1/2 z-50 px-6 py-3 rounded-lg shadow-lg"
      style="
        top: 18%; 
        transform: translateX(-50%);
        background: #22c55e; 
        color: #fff; 
        font-weight: 600; 
        letter-spacing: 0.03em;
        min-width: 240px;
        text-align: center;"
      x-text="successMessage"
    ></div>
  </div>
</div>
