<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" class="text-gray-900 dark:text-gray-100 transition-colors duration-300">
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
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'Published Documents' : 'Objavljena dokumenta' }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">1,245</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+12%</span> {{ App::getLocale() === 'en' ? ' this month' : ' ovog meseca' }} </p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'Avg Time on Site' : 'Prosečno vreme na sajtu' }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">4m 32s</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+8%</span>{{ App::getLocale() === 'en' ? ' this month' : ' ovog meseca' }} </p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ App::getLocale() === 'en' ? 'User Growth' : 'Priliv korisnika' }}</h3>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">3,890</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><span class="text-success">+15%</span> {{ App::getLocale() === 'en' ? ' this month' : ' ovog meseca' }}</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl flex flex-col items-center justify-center text-center">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Relof index' : 'Relof indeks' }}</h3>
                        <div class="w-48 h-48 relative">
                            <canvas id="reliefChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center text-3xl font-extrabold text-success">
                                82%
                            </div>
                            <a href="#" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'Learn more' : 'Saznaj više' }}</a>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4 text-center">{{ App::getLocale() === 'en' ? 'User Growth' : 'Priliv korisnika' }}</h3>
                        <div class="w-full h-72">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>

                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4 text-center">{{ App::getLocale() === 'en' ? 'Traffic Sources' : 'Izvori saobraćaja' }}</h3>
                        <div class="w-full h-72">
                            <canvas id="trafficSourcesChart"></canvas>
                        </div>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited News' : 'Najposećenija vest' }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ App::getLocale() === 'en' ? 'New Budget Plan Approved' : 'Odobren novi plan budžeta' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '12,345 views' : '12,345 pregleda' }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited Employee' : 'Najposećeniji zaposleni' }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Ana Petrović</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '8,230 profile views' : '8,230 poseta profilu' }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Visited Page' : 'Najposećenija stranica' }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">/vesti</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '15,678 visits' : '15,678 poseta' }}</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Recent Complaints' : 'Skorašnje žalbe' }}</h3>
                        <ul class="space-y-3">
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Website too slow" - Anonymous' : '"Vrlo spor sajt" - Anoniman korisnik' }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(2 days ago)' : '(pre 2 dana)' }}</span></li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Document not found" - Jovan M.' : '"Dokument nije pronađen" - Jovan M.' }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(3 days ago)' : '(pre 3 dana)' }}</span></li>
                        </ul>
                        <a href="#" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : 'Pogledaj sve' }}</a>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Testimonials' : 'Pohvale' }}</h3>
                        <ul class="space-y-3">
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Great service!" - Marija S.' : '"Odlična usluga!" - Marija S.' }}</li>
                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? '"Very transparent." - Nikola T.' : '"Vrlo transparentno." - Nikola T.' }}</li>
                        </ul>
                        <a href="#" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : 'Pogledaj sve' }}</a>
                    </div>
                </section>

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12 animate-fade-in">
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-blue-400 text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Most Downloaded Document' : 'Najviše puta pogledan dokument' }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Plan javnih nabavki 2024.pdf</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? '5,432 downloads' : '5,432 preuzimanja' }}</p>
                    </div>
                    <div class="glass p-6 rounded-2xl shadow-xl">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">{{ App::getLocale() === 'en' ? 'Document to Publish' : 'Dokument za objavljivanje' }}</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Plan budžeta 2025.pdf</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ App::getLocale() === 'en' ? 'Scheduled: Jun 20, 2025' : 'zakazano: Jun 20, 2025' }}</p>
                    </div>
                </section>

                <section class="glass p-6 rounded-2xl shadow-xl mb-12 animate-fade-in">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-4">{{ App::getLocale() === 'en' ? 'Recent Activity' : 'Poslednje aktivnosti' }}</h3>
                    <ul class="space-y-3">
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Document "Plan budžeta 2025.pdf" uploaded by Jovan' : 'Dokument "Plan budžeta 2025.pdf" objavio Jovan' }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(1 hour ago)' : '(pre 1 sat)' }}</span></li>
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Document "javne nabavke 2025.pdf" uploaded by Anđela' : 'Dokument "javne nabavke 2025.pdf" objavila Anđela' }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(2 hours ago)y' : '(pre 2 sata)' }}</span></li>
                        <li class="text-sm text-gray-700 dark:text-gray-300">{{ App::getLocale() === 'en' ? 'Complaint filed by Jovan M.' : 'Žalba korisnika Jovan M.' }} <span class="text-gray-500 dark:text-gray-400 text-xs">{{ App::getLocale() === 'en' ? '(3 days ago)' : '(pre 3 dana)' }}</span></li>
                    </ul>
                    <a href="#" class="text-blue-400 text-primary text-sm font-medium hover:underline mt-4 inline-block">{{ App::getLocale() === 'en' ? 'View All' : 'Pogledaj sve' }}</a>
                </section>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                const reliefCtx = document.getElementById('reliefChart').getContext('2d');
                new Chart(reliefCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Relief Index', 'Remaining'],
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
                                    '{{ App::getLocale() === "en" ? "Jan" : "Jan" }}',
                                    '{{ App::getLocale() === "en" ? "Feb" : "Feb" }}',
                                    '{{ App::getLocale() === "en" ? "Mar" : "Mar" }}',
                                    '{{ App::getLocale() === "en" ? "Apr" : "Apr" }}',
                                    '{{ App::getLocale() === "en" ? "May" : "Maj" }}',
                                    '{{ App::getLocale() === "en" ? "Jun" : "Jun" }}'
                                ],
                        datasets: [{
                            label: 'Users',
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
                            '{{ App::getLocale() === "en" ? "Organic" : "Organski" }}',
                            '{{ App::getLocale() === "en" ? "Social" : "Socijalni" }}',
                            '{{ App::getLocale() === "en" ? "Direct" : "Direktni" }}',
                            '{{ App::getLocale() === "en" ? "Referral" : "Preporuka" }}'
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
                                labels: { color: '#6b7280', font: { size: 12 } }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>