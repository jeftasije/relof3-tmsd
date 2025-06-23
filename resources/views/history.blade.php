<x-guest-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 text-gray-900 dark:text-white">

        <h1 class="text-center text-5xl font-extrabold mb-6">
            @switch(App::getLocale())
                @case('en') History @break
                @case('sr-Cyrl') Историјат @break
                @default Istorijat
            @endswitch
        </h1>

        @if(session('success'))
            <div class="mb-6 text-green-800 bg-green-100 border border-green-300 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @auth
            <form action="{{ route('history.update') }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="content" rows="15"
                    class="w-full p-4 bg-white dark:bg-gray-800  border rounded shadow-sm focus:ring focus:outline-none dark:text-white">{{ old('content', $history->content) }}</textarea>

                <div class="flex justify-end gap-4">
                    <button type="button" data-modal-target="submitModal" data-modal-toggle="submitModal"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        @switch(App::getLocale())
                            @case('en') Save changes @break
                            @case('sr-Cyrl') Сачувај промене @break
                            @default Sačuvaj promene
                        @endswitch
                    </button>

                    <!-- Confirm Submission Modal -->
                    <div id="submitModal" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full mx-auto">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        @switch(App::getLocale())
                                            @case('en') Are you sure you want to save the changes? @break
                                            @case('sr-Cyrl') Да ли сте сигурни да желите да сачувате измене? @break
                                            @default Da li ste sigurni da želite da sačuvate izmene?
                                        @endswitch
                                    </h3>
                                    <button id="confirmSubmitBtn" type="button"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                        @switch(App::getLocale())
                                            @case('en') Save @break
                                            @case('sr-Cyrl') Сачувај @break
                                            @default Sačuvaj
                                        @endswitch
                                    </button>
                                    <button data-modal-hide="submitModal" type="button"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        @switch(App::getLocale())
                                            @case('en') Cancel @break
                                            @case('sr-Cyrl') Откажи @break
                                            @default Otkaži
                                        @endswitch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        @else
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($history->content)) !!}
            </div>
        @endauth

    </div>
</x-guest-layout>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const openModalBtn = document.querySelector('button[data-modal-toggle="submitModal"]');
    const confirmBtn = document.getElementById('confirmSubmitBtn');
    const modal = document.getElementById('submitModal');
    const form = document.querySelector('form[action="{{ route('history.update') }}"]');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    confirmBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.submit();
    });

    document.querySelectorAll('[data-modal-hide="submitModal"]').forEach((el) => {
        el.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
});
</script>
