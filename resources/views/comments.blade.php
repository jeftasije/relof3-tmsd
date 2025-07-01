<x-guest-layout>
    <div class="bg-white/70 dark:bg-gray-900/80 rounded-lg shadow-lg p-8 max-w-7xl mx-auto">
        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center w-full sm:mb-4 md:mb-6"
                style="color: var(--primary-text); font-family: var(--font-title);">
                @switch(App::getLocale())
                @case('en') Blog @break
                @case('sr-Cyrl') Блог @break
                @default Blog
                @endswitch
            </h1>
            <p class="mb-2 sm:mb-4 md:mb-6 text-sm sm:text-base md:text-lg text-center max-w-2xl sm:max-w-3xl md:max-w-4xl mx-auto"
                style="color: var(--secondary-text); font-family: var(--font-body);">
                @switch(App::getLocale())
                @case('en')
                We invite you to explore our blog, share your thoughts, and read comments from the community.<br>
                Your voice matters—join the conversation!
                @break

                @case('sr-Cyrl')
                Позивамо Вас да прегледате наш блог, поделите своје мишљење и прочитате коментаре заједнице.<br>
                Ваш глас је важан — укључите се у разговор!
                @break

                @default
                Pozivamo Vas da pregledate naš blog, podelite svoje mišljenje i pročitate komentare zajednice.<br>
                Vaš glas je važan — uključite se u razgovor!
                @endswitch
            </p>
        </div>
        @php
        $isLogged = auth()->check();
        @endphp

        <form method="POST" action="{{ route('comments.store') }}" class="space-y-6 mb-10">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($isLogged === true)
                <div class="relative group">
                    <input type="text"
                        name="name"
                        value="{{ $libary_name }}"
                        required
                        readonly
                        class="w-full p-3 shadow-sm bg-gray-100 dark:bg-gray-700 dark:text-gray-400 text-gray-500 border border-gray-300 dark:border-gray-600 text-sm rounded-lg cursor-not-allowed"
                        aria-describedby="name-tooltip">

                    <div id="name-tooltip"
                        class="absolute top-full mt-1 left-0 w-max max-w-s px-2 py-1 text-s text-white bg-gray-800 rounded shadow opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        @switch(App::getLocale())
                        @case('en') This name is automatically set to the institution name. @break
                        @case('sr-Cyrl') Име је аутоматски подешено на назив установе. @break
                        @default Ime je automatski podešeno na naziv ustanove.
                        @endswitch
                    </div>
                </div>
                @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
                @else
                <input type="text" name="name" placeholder="{{ App::getLocale() === 'en' ? 'First and Last name' : 'Ime i prezime' }}"
                    value="{{ old('name') }}" required
                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200">
                @error('name') <p class="text-red-500 text-sm col-span-2">{{ $message }}</p> @enderror
                @endif
            </div>

            <div>
                <textarea name="comment" rows="4"
                    class="w-full p-3 shadow-sm bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-grey-200"
                    placeholder="{{ App::getLocale() === 'en' ? 'Write a comment...' : 'Napiši komentar...' }}"
                    required>{{ old('comment') }}</textarea>
                @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit"
                    class="px-5 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    @switch(App::getLocale())
                    @case('en') Send comment @break
                    @case('sr-Cyrl') Пошаљи коментар @break
                    @default Pošalji komentar
                    @endswitch
                </button>
            </div>
        </form>

        <p class="text-center mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-300"
            style="font-family: var(--font-title);">
            @switch(App::getLocale())
            @case('en')
            User Comments @break
            @case('sr-Cyrl')
            Коментари корисника @break
            @default
            Komentari korisnika
            @endswitch
        </p>

        @foreach($comments->whereNull('parent_id') as $comment)
        @include('components.comment', ['comment' => $comment])
        @endforeach

        <div class="flex justify-center mt-6">
            {{ $comments->links() }}
        </div>

        @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded fixed top-5 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <div
        id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden"
        aria-hidden="true">
        <div class="bg-white dark:bg-gray-700 rounded-lg p-6 max-w-md w-full shadow-lg">
            <p class="mb-4 text-lg font-semibold">
                @switch(App::getLocale())
                @case('en') Are you sure you want to delete this comment? @break
                @case('sr-Cyrl') Да ли сте сигурни да желите да обришете овај коментар? @break
                @default Da li ste sigurni da želite da obrišete ovaj komentar?
                @endswitch
            </p>

            <div class="flex justify-end space-x-4">
                <button
                    id="cancel-delete-btn"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-6000">
                    @switch(App::getLocale())
                    @case('en') Cancel @break
                    @case('sr-Cyrl') Откажи @break
                    @default Otkaži
                    @endswitch
                </button>
                <button
                    id="confirm-delete-btn"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    @switch(App::getLocale())
                    @case('en') Confirm @break
                    @case('sr-Cyrl') Потврди @break
                    @default Potvrdi
                    @endswitch
                </button>
            </div>
        </div>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteBtns = document.querySelectorAll('.delete-comment-btn');
        const modal = document.getElementById('delete-modal');
        const cancelBtn = document.getElementById('cancel-delete-btn');
        const confirmBtn = document.getElementById('confirm-delete-btn');

        let commentId = null;

        deleteBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                commentId = btn.getAttribute('data-comment-id');
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            commentId = null;
        });

        confirmBtn.addEventListener('click', () => {
            if (!commentId) return;

            fetch(`/komentari/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        return response.json().then(data => {
                            alert(data.message || 'Failed to delete comment');
                        });
                    }
                })
                .catch(() => {
                    alert('Network error');
                })
                .finally(() => {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    commentId = null;
                });
        });
    });
</script>