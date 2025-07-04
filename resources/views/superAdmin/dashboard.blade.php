<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" class="text-gray-900 dark:text-gray-100 transition-colors duration-300" style="font-family: 'Roboto', sans-serif;">
                <style>
                    :root {
                        --primary: #3b82f6;
                        --success: #10b981;
                        --danger: #ef4444;
                        --warning: #f59e0b;
                    }
                    .glass {
                        background: rgba(255, 255, 255, 0.15);
                        backdrop-filter: blur(12px);
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        transition: transform 0.2s ease, box-shadow 0.2s ease;
                    }
                    .dark .glass {
                        background: rgba(17, 24, 39, 0.4);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }
                    .glass:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                    }
                    ::-webkit-scrollbar {
                        width: 6px;
                    }
                    ::-webkit-scrollbar-track {
                        background: transparent;
                    }
                    ::-webkit-scrollbar-thumb {
                        background: #6b7280;
                        border-radius: 3px;
                    }
                    .dark ::-webkit-scrollbar-thumb {
                        background: #9ca3af;
                    }
                    .animate-fade-in {
                        animation: fadeIn 0.5s ease-in-out;
                    }
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    .btn-primary {
                        background: var(--primary);
                        transition: background 0.2s ease;
                    }
                    .btn-primary:hover {
                        background: #2563eb;
                    }
                </style>

                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'Published Documents' : (App::getLocale() === 'sr-Cyrl' ? 'Објављена документа' : 'Objavljena dokumenta') }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">1,245</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+12%</span> {{ App::getLocale() === 'en' ? 'this month' : (App::getLocale() === 'sr-Cyrl' ? 'овог месеца' : 'ovog meseca') }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'Avg Time on Site' : (App::getLocale() === 'sr-Cyrl' ? 'Просечно време на сајту' : 'Prosečno vreme na sajtu') }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">4м 32с</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+8%</span> {{ App::getLocale() === 'en' ? 'this month' : (App::getLocale() === 'sr-Cyrl' ? 'овог месеца' : 'ovog meseca') }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'User Growth' : (App::getLocale() === 'sr-Cyrl' ? 'Прилив корисника' : 'Priliv korisnika') }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">3,890</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+15%</span> {{ App::getLocale() === 'en' ? 'this month' : (App::getLocale() === 'sr-Cyrl' ? 'овог месеца' : 'ovog meseca') }}</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl flex flex-col items-center justify-center text-center">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Relof Index' : (App::getLocale() === 'sr-Cyrl' ? 'Релоф индекс' : 'Relof indeks') }}</h3>
                        <div class="w-48 h-48 relative">
                            <canvas id="reliefChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center text-3xl font-extrabold text-success">
                                82%
                            </div>
                            <a href="{{route('relofIndex')}}" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'Learn more' : (App::getLocale() === 'sr-Cyrl' ? 'Сазнај више' : 'Saznaj više') }}</a>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4 text-center">{{ App::getLocale() === 'en' ? 'User Growth' : (App::getLocale() === 'sr-Cyrl' ? 'Прилив корисника' : 'Priliv korisnika') }}</h3>
                        <div class="w-full h-72">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4 text-center">{{ App::getLocale() === 'en' ? 'Traffic Sources' : (App::getLocale() === 'sr-Cyrl' ? 'Извори саобраћаја' : 'Izvori saobraćaja') }}</h3>
                        <div class="w-full h-72">
                            <canvas id="trafficSourcesChart"></canvas>
                        </div>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited News' : (App::getLocale() === 'sr-Cyrl' ? 'Најпосећенија вест' : 'Najposećenija vest') }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'New Budget Plan Approved' : (App::getLocale() === 'sr-Cyrl' ? 'Одобрен нови план буџета' : 'Odobren novi plan budžeta') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '12,345 views' : (App::getLocale() === 'sr-Cyrl' ? '12,345 прегледа' : '12,345 pregleda') }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited Employee' : (App::getLocale() === 'sr-Cyrl' ? 'Најпосећенији запослени' : 'Najposećeniji zaposleni') }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Ana Petrović' : (App::getLocale() === 'sr-Cyrl' ? 'Ана Петровић' : 'Ana Petrović') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '8,230 profile views' : (App::getLocale() === 'sr-Cyrl' ? '8,230 посета профилу' : '8,230 poseta profilu') }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited Page' : (App::getLocale() === 'sr-Cyrl' ? 'Најпосећенија страница' : 'Najposećenija stranica') }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">/vesti</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '15,678 visits' : (App::getLocale() === 'sr-Cyrl' ? '15,678 посета' : '15,678 poseta') }}</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Recent Contacts' : (App::getLocale() === 'sr-Cyrl' ? 'Скорашње контактирања' : 'Skorašnje kontaktiranja') }}</h3>
                        <ul class="space-y-3">
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Sava R. - 7 days ago' : (App::getLocale() === 'sr-Cyrl' ? 'Сава Р. - пре 7 дана' : 'Sava R. - pre 7 dana') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(2 days ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 2 дана)' : '(pre 2 dana)') }}</span></li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Jovan M. - 2 days ago' : (App::getLocale() === 'sr-Cyrl' ? 'Јован М. - пре 2 дана' : 'Jovan M. - pre 2 dana') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(3 days ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 3 дана)' : '(pre 3 dana)') }}</span></li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Milica K. - 2 days ago' : (App::getLocale() === 'sr-Cyrl' ? 'Милица К. - пре 2 дана' : 'Milica K. - pre 2 dana') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(4 days ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 4 дана)' : '(pre 4 dana)') }}</span></li>
                        </ul>
                        <a href="{{route('contact.answerPage')}}" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : (App::getLocale() === 'sr-Cyrl' ? 'Погледај све' : 'Pogledaj sve') }}</a>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Recent questions' : (App::getLocale() === 'sr-Cyrl' ? 'Скорашња питања' : 'Skorašnja pitanja') }}</h3>
                        <ul class="space-y-3">
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Is the book "The Bridge on the Drina" available?" - Marija S.' : (App::getLocale() === 'sr-Cyrl' ? '"Да ли је доступна књига "На Дрини ћуприја?" - Марија С.' : '"Da li je dostupna knjiga "Na Drini ćuprija?" - Marija S.') }}</li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"When will the next literary evening take place?" - Nikola T.' : (App::getLocale() === 'sr-Cyrl' ? '"Када ће се следећи пут одржати књижевно вече?" - Никола Т.' : '"Kada će se sledeći put održati književno veče?" - Nikola T.') }}</li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Can someone recommend a good novel?" - Stefan P.' : (App::getLocale() === 'sr-Cyrl' ? '"Може ли неко да ми препоручи добар роман?" - Стефан П.' : '"Može li neko da mi preporuči dobar roman?" - Stefan P.') }}</li>
                        </ul>
                        <a href="{{route('comments.index')}}" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : (App::getLocale() === 'sr-Cyrl' ? 'Погледај све' : 'Pogledaj sve') }}</a>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Downloaded Document' : (App::getLocale() === 'sr-Cyrl' ? 'Највише пута преузет документ' : 'Najviše puta preuzet dokument') }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Public Procurement Plan 2024.pdf' : (App::getLocale() === 'sr-Cyrl' ? 'План јавних набавки 2024.pdf' : 'Plan javnih nabavki 2024.pdf') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '5,432 downloads' : (App::getLocale() === 'sr-Cyrl' ? '5,432 преузимања' : '5,432 preuzimanja') }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Document to Publish' : (App::getLocale() === 'sr-Cyrl' ? 'Документ за објављивање' : 'Dokument za objavljivanje') }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'Budget Plan 2025.pdf' : (App::getLocale() === 'sr-Cyrl' ? 'План буџета 2025.pdf' : 'Plan budžeta 2025.pdf') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? 'Scheduled: Jun 20, 2025' : (App::getLocale() === 'sr-Cyrl' ? 'Заказано: 20. јун 2025.' : 'Zakazano: 20. jun 2025.') }}</p>
                    </div>
                </section>

                <section class="glass p-6 rounded-2xl shadow-xl mb-12 animate-fade-in">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Recent Activity' : (App::getLocale() === 'sr-Cyrl' ? 'Недавне активности' : 'Nedavne aktivnosti') }}</h3>
                    <ul class="space-y-3">
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Document "Budget Plan 2025.pdf" uploaded by Jovan' : (App::getLocale() === 'sr-Cyrl' ? 'Документ "План буџета 2025.pdf" поставио Јован' : 'Dokument "Plan budžeta 2025.pdf" postavio Jovan') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(1 hour ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 1 сат)' : '(pre 1 sat)') }}</span></li>
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Document "Public Procurement 2025.pdf" uploaded by Anđela' : (App::getLocale() === 'sr-Cyrl' ? 'Документ "Јавне набавке 2025.pdf" поставила Анђела' : 'Dokument "Javne nabavke 2025.pdf" postavila Anđela') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(2 hours ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 2 сата)' : '(pre 2 sata)') }}</span></li>
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Complaint filed by Jovan M.' : (App::getLocale() === 'sr-Cyrl' ? 'Жалба поднета од стране Јована М.' : 'Žalba podneta od strane Jovana M.') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(3 days ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 3 дана)' : '(pre 3 dana)') }}</span></li>
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'New user registered: Marko R.' : (App::getLocale() === 'sr-Cyrl' ? 'Нови корисник регистрован: Марко Р.' : 'Novi korisnik registrovan: Marko R.') }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(4 days ago)' : (App::getLocale() === 'sr-Cyrl' ? '(пре 4 дана)' : '(pre 4 dana)') }}</span></li>
                    </ul>
                    <a href="#" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : (App::getLocale() === 'sr-Cyrl' ? 'Погледај све' : 'Pogledaj sve') }}</a>
                </section>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                const reliefCtx = document.getElementById('reliefChart').getContext('2d');
                new Chart(reliefCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['{{ App::getLocale() === "en" ? "Relief Index" : (App::getLocale() === "sr-Cyrl" ? "Релоф индекс" : "Relof indeks") }}', '{{ App::getLocale() === "en" ? "Remaining" : (App::getLocale() === "sr-Cyrl" ? "Остатак" : "Ostatak") }}'],
                        datasets: [{
                            data: [82, 18],
                            backgroundColor: ['#10b981', '#e5e7eb'],
                            borderWidth: 0,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        cutout: '80%',
                        plugins: { legend: { display: false } },
                        animation: { animateRotate: true, animateScale: true }
                    }
                });

                const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
                new Chart(userGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: [
                            '{{ App::getLocale() === "en" ? "Jan" : (App::getLocale() === "sr-Cyrl" ? "Јан" : "Jan") }}',
                            '{{ App::getLocale() === "en" ? "Feb" : (App::getLocale() === "sr-Cyrl" ? "Феб" : "Feb") }}',
                            '{{ App::getLocale() === "en" ? "Mar" : (App::getLocale() === "sr-Cyrl" ? "Мар" : "Mar") }}',
                            '{{ App::getLocale() === "en" ? "Apr" : (App::getLocale() === "sr-Cyrl" ? "Апр" : "Apr") }}',
                            '{{ App::getLocale() === "en" ? "May" : (App::getLocale() === "sr-Cyrl" ? "Мај" : "Maj") }}',
                            '{{ App::getLocale() === "en" ? "Jun" : (App::getLocale() === "sr-Cyrl" ? "Јун" : "Jun") }}'
                        ],
                        datasets: [{
                            label: '{{ App::getLocale() === "en" ? "Users" : (App::getLocale() === "sr-Cyrl" ? "Корисници" : "Korisnici") }}',
                            data: [2000, 2200, 2500, 2800, 3200, 3890],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                const trafficSourcesCtx = document.getElementById('trafficSourcesChart').getContext('2d');
                new Chart(trafficSourcesCtx, {
                    type: 'pie',
                    data: {
                        labels: [
                            '{{ App::getLocale() === "en" ? "Organic" : (App::getLocale() === "sr-Cyrl" ? "Органски" : "Organski") }}',
                            '{{ App::getLocale() === "en" ? "Social" : (App::getLocale() === "sr-Cyrl" ? "Социјални" : "Socijalni") }}',
                            '{{ App::getLocale() === "en" ? "Direct" : (App::getLocale() === "sr-Cyrl" ? "Директни" : "Direktni") }}',
                            '{{ App::getLocale() === "en" ? "Referral" : (App::getLocale() === "sr-Cyrl" ? "Препорука" : "Preporuka") }}'
                        ],
                        datasets: [{
                            data: [50, 20, 15, 15],
                            backgroundColor: ['#10b981', '#3b82f6', '#ef4444', '#f59e0b'],
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#6b7280', font: { size: 12, family: 'Roboto' } }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>