<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 text-center">
        <style>
            .glass {
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem; 
                box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                color: inherit;
            }
            .dark .glass {
                border-color: rgba(255, 255, 255, 0.15);
            }
            .glass:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            }
        </style>
        <div class="relative flex items-center justify-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'RELOF INDEX' : (App::getLocale() === 'sr-Cyrl' ? 'РЕЛОФ ИНДЕКС' : 'RELOF INDEKS') }}
            </h1>
            <div class="absolute right-0">
                <button 
                    id="help-btn" 
                    onclick="toggleHelpModal()"
                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 17l0 .01" />
                        <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                    </svg>
                    <span class="ml-3">
                        {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                    </span>
                </button>
            </div>
        </div>
        <div class="mb-8 flex justify-center">
            <div class="w-[100px] h-[100px]">
                <canvas id="relofChart" class="w-full h-full"></canvas>
            </div>
        </div>
        <div class="shadow glass mb-8 bg-red-100 dark:bg-red-700/40 p-6 rounded-lg shadow">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'How to improve Relof index' : (App::getLocale() === 'sr-Cyrl' ? 'Како побољшати Релоф индекс' : 'Kako poboljšati Relof indeks') }}
            </h2>
            <h3 class="font-semibold mb-4 text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'Documents that are missing:' : (App::getLocale() === 'sr-Cyrl' ? 'Документи који нису објављени:' : 'Dokumenta koja nisu objavljena:') }}
            </h3>
            <ul class="text-left list-disc list-inside text-gray-900 dark:text-white space-y-2">
                <li><a href="{{ route('procurements.store') }}" class="underline hover:text-red-600 dark:hover:text-red-400">
                    {{ App::getLocale() === 'en' ? 'Public Procurement Plan for 2025' : (App::getLocale() === 'sr-Cyrl' ? 'План јавних набавки за 2025.' : 'Plan javnih nabavki za 2025.') }}
                </a></li>
                <li><a href="{{ route('documents.index', ['category' => 'Godišnji planovi']) }}" class="underline hover:text-red-600 dark:hover:text-red-400">
                    {{ App::getLocale() === 'en' ? 'Annual Work Plan 2025' : (App::getLocale() === 'sr-Cyrl' ? 'Годишњи план рада за 2025.' : 'Godišnji plan rada za 2025. godinu') }}
                </a></li>
                <li><a href="{{ route('documents.index', ['category' => 'Izveštaji o radu']) }}" class="underline hover:text-red-600 dark:hover:text-red-400">
                    {{ App::getLocale() === 'en' ? 'Supervisory Board Report' : (App::getLocale() === 'sr-Cyrl' ? 'Извештај надзорног одбора' : 'Izveštaj o radu nadzornog odbora') }}
                </a></li>
            </ul>
        </div>
        <div class="grid mb-8 grid-cols-1 sm:grid-cols-2 gap-4 bg-blue-100 dark:bg-blue-700/40 p-6 rounded-lg shadow glass">
            <div class="p-4">
                <p class="text-lg text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Published documents' : (App::getLocale() === 'sr-Cyrl' ? 'Објављени документи' : 'Objavljenih dokumenata') }}
                </p>
                <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">42</p>
            </div>
            <div class="p-4">
                <p class="text-lg text-gray-900 dark:text-white">
                    {{ App::getLocale() === 'en' ? 'Unpublished documents' : (App::getLocale() === 'sr-Cyrl' ? 'Необјављени документи' : 'Neobjavljenih dokumenata') }}
                </p>
                <p class="text-3xl font-bold text-red-700 dark:text-red-300">3</p>
            </div>
        </div>
        <div class="mb-8 bg-blue-100 dark:bg-blue-700/40 p-6 rounded-lg shadow glass">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'Data Timeliness' : (App::getLocale() === 'sr-Cyrl' ? 'Ажурност података' : 'Ažurnost podataka') }}
            </h2>
            <h3 class="font-semibold mb-4 text-gray-900 dark:text-white">
                {{ App::getLocale() === 'en' ? 'Next item scheduled for publication:' : (App::getLocale() === 'sr-Cyrl' ? 'Следеће што треба објавити:' : 'Sledeće što treba da objavite na stranicu, prema rasporedu') }}
            </h3>
            <ul class="text-left list-disc list-inside text-blue-700 dark:text-blue-200 space-y-2">
                <li>
                    <a href="{{ route('news.store') }}" class="underline hover:text-blue-600 dark:hover:text-blue-400">
                        {{ App::getLocale() === 'en' ? 'Reading Night at the Library' : (App::getLocale() === 'sr-Cyrl' ? 'Читалачко вече у нашој библиотеци' : 'Čitalačko veče u našoj biblioteci') }}
                    </a>
                    <span class="block text-sm text-gray-600 dark:text-gray-400">
                        {{ App::getLocale() === 'en' ? 'Scheduled for: Monday 6.7.2025.' : (App::getLocale() === 'sr-Cyrl' ? 'Заказано за: понедељак 6.7.2025.' : 'Zakazano za: ponedeljak 6.7.2025.') }}
                    </span>
                </li>
            </ul>
        </div>
        <div id="helpModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <button onclick="toggleHelpModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl font-bold">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                    {{ App::getLocale() === 'en' ? 'Help' : (App::getLocale() === 'sr-Cyrl' ? 'Помоћ' : 'Pomoć') }}
                </h2>
                <p class="text-gray-700 dark:text-gray-300 space-y-2">
                    {!! App::getLocale() === 'en'
                        ? 'Relof index measures <strong>transparency</strong> and <strong>timeliness</strong> of data on your page.
                        <br>It is a good practice to strive for a <strong>high Relof index</strong>.
                        <br>In the <strong>"How to improve Relof index"</strong> section, documents that are not yet published will be listed. By publishing them, you directly increase your Relof index.
                        <br>Also, in the <strong>"Data Timeliness"</strong> section, you can check what the next item is scheduled for publication and the date it is planned.'
                        : (App::getLocale() === 'sr-Cyrl'
                            ? 'Релоф индекс мери <strong>транспарентност</strong> и <strong>ажурност</strong> података на Вашој страници.
                            <br>Добра је пракса настојати да <strong>Релоф индекс буде што виши</strong>.
                            <br>У секцији <strong>"Како побољшати Релоф индекс"</strong> биће приказана, уколико постоје, документа која нису објављена. Њиховом објавом директно повећавате Ваш Релоф индекс.
                            <br>Такође, у секцији <strong>"Ажурност података"</strong>, можете погледати шта је по календару наредна ставка за објаву и датум када је планирана.'
                            : 'Relof indeks meri <strong>transparentnost</strong> i <strong>ažurnost</strong> podataka na Vašoj stranici.
                            <br>Dobra je praksa nastojati da <strong>Relof indeks bude što viši</strong>.
                            <br>U sekciji <strong>"Kako poboljšati Relof indeks"</strong> biće prikazana, ukoliko postoje, dokumenta koja nisu objavljena na stranici. Objavom tih dokumenata direktno povećavate Vaš Relof indeks.
                            <br>Takođe, u sekciji <strong>"Ažurnost podataka"</strong>, možete pogledati šta je po kalendaru naredna stavka koju treba objaviti na sajtu, kao i datum kada je planirana objava.')
                    !!}
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height } = chart;
                const ctx = chart.ctx;
                ctx.restore();
                const fontSize = (height / 5).toFixed(2);
                ctx.font = `${fontSize}px Arial`;
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#10B981";
                const text = "72%";
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        };
        const ctx = document.getElementById('relofChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Indeks', 'Preostalo'],
                datasets: [{
                    data: [72, 28],
                    backgroundColor: ['#10B981', '#E5E7EB'],
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    tooltip: { enabled: false },
                    legend: { display: false }
                }
            },
            plugins: [centerTextPlugin]
        });

        function toggleHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>