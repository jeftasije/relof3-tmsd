<div 
  class="relative max-w-sm h-full bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col" 
  style="box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);"
  x-data="{
    editing: false,
    biography: @js($employee->translated_biography),
    position: @js($employee->translated_position),
    originalBiography: @js($employee->translated_biography),
    originalPosition: @js($employee->translated_position),
    imageSrc: '{{ asset($employee->image_path) }}',
    saving: false,
    uploading: false,
    async save() {
      this.saving = true;
      try {
        const response = await fetch('{{ route('employees.update', $employee->id) }}', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          },
          body: JSON.stringify({
            biography: this.biography,
            position: this.position,
          }),
        });
        if (!response.ok) throw new Error('Save failed');
        this.originalBiography = this.biography;
        this.originalPosition = this.position;
        this.editing = false;
      } catch (e) {
        alert('Failed to save data');
      } finally {
        this.saving = false;
      }
    },
    cancel() {
      this.biography = this.originalBiography;
      this.position = this.originalPosition;
      this.editing = false;
    },
    uploadImage(e) {
      if (!e.target.files.length) return;
      this.uploading = true;
      const formData = new FormData();
      formData.append('image', e.target.files[0]);
      formData.append('_token', '{{ csrf_token() }}');
      fetch('/zaposleni/{{ $employee->id }}/izmeni-sliku', {
        method: 'POST',
        body: formData,
      })
        .then(async r => {
          let data;
          try { data = await r.json(); } catch { data = null; }
          if (r.ok && data && data.success) {
            this.imageSrc = data.employee.image_path + '?' + (new Date()).getTime();
          } else {
            alert('Greška pri uploadu slike! ' + (data && data.error ? data.error : ''));
          }
        })
        .catch(() => alert('Greška pri uploadu slike!'))
        .finally(() => this.uploading = false);
    }
  }"
>
    @auth
    <div class="absolute bottom-2 right-2 z-10">
        <template x-if="!editing">
          <div x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none">
                <svg class="w-6 h-6 transform" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute bottom-full right-0 mb-2 w-32 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg">
                <button 
                  @click.prevent="editing = true; open = false" 
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                    {{ App::getLocale() === 'en' ? 'Edit' : 'Izmeni' }}
                </button>
                <form method="POST" action="{{ route('employees.destroy', $employee->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                        {{ App::getLocale() === 'en' ? 'Delete' : 'Obriši' }}
                    </button>
                </form>
            </div>
          </div>
        </template>
    </div>
    @endauth

    <div class="relative overflow-hidden rounded-t-lg group" style="box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);">
        <img
            class="w-full h-48 object-cover transform transition-transform duration-300 group-hover:scale-105 cursor-pointer"
            :src="imageSrc"
            alt="{{ $employee->name }}"
            @click.prevent="editing ? $refs.fileInput.click() : null"
        />
        <input type="file" x-ref="fileInput" class="hidden" @change="uploadImage" accept="image/*">
        <template x-if="editing">
          <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 text-white text-lg font-bold pointer-events-none">{{ App::getLocale() === 'en' ? 'Change image' : 'Promeni sliku' }}</div>
        </template>
    </div>
    <div class="p-5 flex flex-col flex-grow justify-between" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1) inset;">
        <div>
            <a href="{{ route('employees.show', $employee->id) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);">
                    {{ $employee->name }}
                </h5>
            </a>

            <template x-if="!editing">
                <p class="mb-2 font-medium text-gray-700 dark:text-gray-300" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);" x-text="position"></p>
            </template>
            <template x-if="editing">
                <input
                  type="text"
                  x-model="position"
                  class="mb-2 w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                />
            </template>

            <template x-if="!editing">
                <p class="mb-4 font-normal text-gray-700 dark:text-gray-400" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);" x-text="biography"></p>
            </template>
            <template x-if="editing">
                <textarea x-model="biography" rows="4" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
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
                {{ App::getLocale() === 'en' ? 'Save' : 'Sačuvaj' }}
              </button>
              <button 
                @click.prevent="cancel()" 
                :disabled="saving"
                class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 disabled:opacity-50"
              >
                {{ App::getLocale() === 'en' ? 'Cancel' : 'Otkaži' }}
              </button>
            </div>
          </template>

          <a href="{{ route('employees.show', $employee->id) }}"
             class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);">
              {{ App::getLocale() === 'en' ? 'Show more' : 'Prikaži više' }}
              <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                   fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg>
          </a>
        </div>
    </div>
</div>
