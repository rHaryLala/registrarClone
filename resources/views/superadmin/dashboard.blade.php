<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SuperAdmin - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .sidebar {
            width: 260px;
            transition: all 0.3s;
        }
        .main-content {
            margin-left: 260px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.active {
                margin-left: 0;
            }
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .stats-card {
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('superadmin.components.sidebar')

    <!-- Main Content -->
    <div class="main-content min-h-screen">
        <!-- Header -->
        @include('superadmin.components.header')

    <!-- Content -->
    <main class="p-6">
        <!-- Ajout d'animations CSS modernes et d'effets visuels -->
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }

            @keyframes growBar {
                from {
                    height: 0;
                }
                to {
                    height: var(--bar-height);
                }
            }

            .stats-card {
                animation: fadeInUp 0.6s ease-out;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .stats-card:nth-child(1) { animation-delay: 0.1s; }
            .stats-card:nth-child(2) { animation-delay: 0.2s; }
            .stats-card:nth-child(3) { animation-delay: 0.3s; }
            .stats-card:nth-child(4) { animation-delay: 0.4s; }

            .stats-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                transition: left 0.5s;
            }

            .stats-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }

            .stats-card:hover::before {
                left: 100%;
            }

            .icon-container {
                transition: all 0.3s ease;
            }

            .stats-card:hover .icon-container {
                transform: scale(1.1) rotate(5deg);
            }

            .chart-container {
                animation: slideInLeft 0.8s ease-out 0.5s both;
            }

            .chart-bar {
                animation: growBar 1s ease-out;
                animation-delay: calc(var(--bar-index) * 0.1s);
                transition: all 0.3s ease;
            }

            .chart-bar:hover {
                background: linear-gradient(to top, #1e40af, #3b82f6) !important;
                transform: scale(1.1);
            }

            .registration-item {
                animation: fadeInUp 0.5s ease-out;
                animation-delay: calc(var(--item-index) * 0.1s);
                transition: all 0.3s ease;
            }

            .registration-item:hover {
                transform: translateX(10px);
                background: linear-gradient(135deg, #f8fafc, #e2e8f0) !important;
            }

            .quick-action {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .quick-action::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: radial-gradient(circle, rgba(59, 130, 246, 0.1), transparent);
                transition: all 0.4s ease;
                transform: translate(-50%, -50%);
                border-radius: 50%;
            }

            .quick-action:hover::before {
                width: 300px;
                height: 300px;
            }

            .quick-action:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            }

            .number-counter {
                transition: all 0.3s ease;
            }

            .stats-card:hover .number-counter {
                color: #1e40af;
                transform: scale(1.1);
            }

            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                <div class="flex items-center">
                    <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Utilisateurs</p>
                        <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $usersCount }}</h3>
                    </div>
                </div>
                <!-- Statistiques dynamiques à implémenter -->
            </div>

            <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-green-200">
                <div class="flex items-center">
                    <div class="icon-container p-3 rounded-full bg-gradient-to-br from-green-100 to-green-200 text-green-600 mr-4">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Étudiants</p>
                        <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $studentsCount }}</h3>
                    </div>
                </div>
                <!-- Statistiques dynamiques à implémenter -->
            </div>

            <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                <div class="flex items-center">
                    <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Enseignants</p>
                        <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $teachersCount }}</h3>
                    </div>
                </div>
                <!-- Statistiques dynamiques à implémenter -->
            </div>

            <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-orange-200">
                <div class="flex items-center">
                    <div class="icon-container p-3 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 text-orange-600 mr-4">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Cours</p>
                        <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $coursesCount }}</h3>
                    </div>
                </div>
                <!-- Statistiques dynamiques à implémenter -->
            </div>
        </div>

        <!-- Graphiques et tableaux -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Graphique d'inscriptions -->
            @php
                $days = [];
                $counts = [];
                $maxBarHeight = 150;
                $maxCount = 1;
                for ($i = 6; $i >= 0; $i--) {
                    $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                    $days[] = \Carbon\Carbon::parse($date)->format('d/m');
                    $counts[] = $dailyRegistrations[$date] ?? 0;
                    if (($dailyRegistrations[$date] ?? 0) > $maxCount) $maxCount = $dailyRegistrations[$date] ?? 0;
                }
            @endphp
            <div class="chart-container bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-6 text-gray-800">Inscriptions des 7 derniers jours</h3>
                <div class="h-64 flex justify-between items-end">
                    @foreach($days as $i => $day)
                        @php
                            $count = $counts[$i];
                            $barHeight = ($count > 0 && $maxCount > 0) ? max(8, ($count / $maxCount) * $maxBarHeight) : 0;
                        @endphp
                        <div class="flex flex-col items-center" style="width: 24px;">
                            @if($count > 0)
                                <div class="chart-bar bg-gradient-to-t from-blue-600 to-blue-400 w-3 rounded-t-lg shadow-sm" 
                                    style="--bar-height: {{ $barHeight }}px; --bar-index: {{ $i }}; height: {{ $barHeight }}px; max-height: {{ $maxBarHeight }}px"></div>
                            @else
                                <div style="height: 0px;"></div>
                            @endif
                            <span class="text-xs mt-2 font-medium text-gray-600">{{ $day }}</span>
                            <span class="text-xs text-blue-600 font-semibold">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dernières inscriptions -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-6 text-gray-800">Dernières inscriptions</h3>
                <div class="space-y-4">
                    @foreach($latestRegistrations as $index => $registration)
                        <div class="registration-item flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-100" 
                            style="--item-index: {{ $index }}">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $registration->name ?? $registration->nom ?? '' }}</p>
                                    <p class="text-sm text-gray-600">{{ $registration->email ?? $registration->mention_envisagee ?? '' }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-blue-600 font-medium">{{ $registration->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold mb-6 text-gray-800">Actions rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('register')}}" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-blue-300 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Nouvel étudiant</p>
                </a>

                <a href="{{ route('superadmin.students.list') }}" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-green-300 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Voir étudiants</p>
                </a>

                <a href="#" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-blue-300 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Rapports</p>
                </a>

                <a href="{{ route('superadmin.settings') }}" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-orange-300 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-cog text-orange-600 text-xl"></i>
                    </div>
                    <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Paramètres</p>
                </a>
            </div>
        </div>
    </main>

    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>