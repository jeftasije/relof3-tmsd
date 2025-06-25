<div 
  class="relative max-w-sm h-full rounded-lg shadow-lg flex flex-col"
  style="background: var(--primary-bg) !important; border: 1px solid var(--secondary-text) !important; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);"
  x-data="{
    editing: false,
    // name je i dalje u stanju, ali se ne edituje!
    name: @js($employee->translate('name')),
    biography: @js($employee->translated_biography),
    position: @js($employee->translated_position),
    originalBiography: @js($employee->translated_biography),
    originalPosition: @js($employee->translated_position),
    imageSrc: '{{ asset($employee->image_path) }}',
    saving: false,
    uploading: false,
    showDeleteModal: false,
    confirmDeleteUrl: '',
    showSuccess: false,
    successMessage: '',
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
        // Prikaz toast poruke
        const locale = '{{ App::getLocale() }}';
        if (locale === 'en') {
          this.successMessage = 'Successfully saved changes!';
        } else if (locale === 'sr-Cyrl') {
          this.successMessage = 'Успешно сте сачували измене!';
        } else {
          this.successMessage = 'Uspešno ste sačuvali izmene!';
        }
        this.showSuccess = true;
        setTimeout(() => this.showSuccess = false, 1800);
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
    <!-- TOAST PORUKA - centar gore -->
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
    >
    </div>
    @auth
    <div class="absolute bottom-2 right-2 z-10">
        <template x-if="!editing">
          <div x-data="{ open: false }">
            <button @click="open = !open" class="focus:outline-none" style="color: var(--secondary-text) !important;">
                <svg class="w-6 h-6 transform" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" 
                class="absolute bottom-full right-0 mb-2 w-32 rounded-md shadow-lg"
                style="background: var(--primary-bg) !important; border: 1px solid var(--secondary-text) !important;">
                <button 
                  @click.prevent="editing = true; open = false" 
                  class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                  style="color: var(--primary-text) !important;"
                >
                    {{ App::getLocale() === 'en' ? 'Edit' : (App::getLocale() === 'sr-Cyrl' ? 'Измени' : 'Izmeni') }}
                </button>
                <button 
                  @click.prevent="openDeleteModal('{{ route('employees.destroy', $employee->id) }}'); open = false"
                  class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                  style="color: #dc2626 !important;"
                >
                    {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
                </button>
            </div>
          </div>
        </template>
    </div>
    @endauth

    <div class="relative overflow-hidden rounded-t-lg group" style="box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);">
        <img
            class="w-full h-48 object-cover transform transition-transform duration-300 group-hover:scale-105 cursor-pointer"
            :src="imageSrc"
            alt="{{ $employee->translate('name') }}"
            :class="editing ? 'filter blur-sm brightness-90' : ''"
            @click.prevent="editing ? $refs.fileInput.click() : null"
        />
        <input type="file" x-ref="fileInput" class="hidden" @change="uploadImage" accept="image/*">
        <template x-if="editing">
          <div class="absolute inset-0 flex items-center justify-center"
                style="background: rgba(30,70,170,0.18); color: #fff; font-size: 1.125rem; font-weight: bold; pointer-events: none; backdrop-filter: blur(6px);">
            {{ App::getLocale() === 'en' ? 'Change image' : (App::getLocale() === 'sr-Cyrl' ? 'Промени слику' : 'Promeni sliku') }}
          </div>
        </template>
    </div>
    <div class="p-5 flex flex-col flex-grow justify-between" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1) inset; background: var(--primary-bg) !important;">
        <div>
            <a href="{{ route('employees.show', $employee->id) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight"
                    style="color: var(--primary-text) !important; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);">
                    {{ $employee->translate('name') }}
                </h5>
            </a>
            <!-- Više nema inputa za ime ni u jednom modu! -->

            <template x-if="!editing">
                <p class="mb-2 font-medium"
                   style="color: var(--secondary-text) !important; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);"
                   x-text="position"></p>
            </template>
            <template x-if="editing">
                <input
                  type="text"
                  x-model="position"
                  class="mb-2 w-full p-2 border rounded"
                  style="background: var(--primary-bg) !important; color: var(--primary-text) !important;"
                />
            </template>

            <template x-if="!editing">
                <p class="mb-4 font-normal"
                   style="color: var(--primary-text) !important; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);"
                   x-text="biography"></p>
            </template>
            <template x-if="editing">
                <textarea x-model="biography" rows="4" class="w-full p-2 border rounded"
                          style="background: var(--primary-bg) !important; color: var(--primary-text) !important;"></textarea>
            </template>
        </div>

        <div class="mt-4 flex justify-between items-center">
          <template x-if="editing">
            <div class="flex space-x-2">
              <button 
                @click.prevent="save()" 
                :disabled="saving"
                class="px-3 py-1 rounded hover:bg-blue-700 disabled:opacity-50"
                style="background: #2563eb !important; color: #fff !important;"
              >
                {{ App::getLocale() === 'en' ? 'Save' : (App::getLocale() === 'sr-Cyrl' ? 'Сачувај' : 'Sačuvaj') }}
              </button>
              <button 
                @click.prevent="cancel()" 
                :disabled="saving"
                class="px-3 py-1 rounded hover:bg-gray-500 disabled:opacity-50"
                style="background: #cbd5e1 !important; color: var(--primary-text) !important;"
              >
                {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
              </button>
            </div>
          </template>

          <a href="{{ route('employees.show', $employee->id) }}"
             class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg focus:ring-4 focus:outline-none"
             style="background: var(--accent); color: #fff; box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);">
              {{ App::getLocale() === 'en' ? 'Show more' : (App::getLocale() === 'sr-Cyrl' ? 'Прикажи више' : 'Prikaži više') }}
              <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
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
                {{ App::getLocale() === 'en' ? 'Are you sure you want to delete this employee?' : (App::getLocale() === 'sr-Cyrl' ? 'Да ли сте сигурни да желите да обришете овог запосленог?' : 'Da li ste sigurni da želite da obrišete ovog zaposlenog?') }}
            </p>
            <div class="flex justify-end gap-2">
                <button @click="closeDeleteModal()" class="px-4 py-2 rounded"
                  style="background: #cbd5e1 !important; color: var(--primary-text) !important;">
                    {{ App::getLocale() === 'en' ? 'Cancel' : (App::getLocale() === 'sr-Cyrl' ? 'Откажи' : 'Otkaži') }}
                </button>
                <form :action="confirmDeleteUrl" method="POST" x-ref="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded"
                            style="background: #dc2626 !important; color: #fff !important;">
                        {{ App::getLocale() === 'en' ? 'Delete' : (App::getLocale() === 'sr-Cyrl' ? 'Обриши' : 'Obriši') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>