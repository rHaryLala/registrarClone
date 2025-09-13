<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SuperAdmin - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stats-card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Utilisateurs</p>
                            <h3 class="text-2xl font-bold">{{ $usersCount }}</h3>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-green-600 text-sm flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 12% depuis le mois dernier
                        </p>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Étudiants</p>
                            <h3 class="text-2xl font-bold">{{ $studentsCount }}</h3>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-green-600 text-sm flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8% depuis le mois dernier
                        </p>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Enseignants</p>
                            <h3 class="text-2xl font-bold">{{ $teachersCount }}</h3>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-red-600 text-sm flex items-center">
                            <i class="fas fa-arrow-down mr-1"></i> 2% depuis le mois dernier
                        </p>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Cours</p>
                            <h3 class="text-2xl font-bold">{{ $coursesCount }}</h3>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-green-600 text-sm flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 5% depuis le mois dernier
                        </p>
                    </div>
                </div>
            </div>

            <!-- Graphiques et tableaux -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Graphique d'inscriptions -->
                @php
                    $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                @endphp
                <div class="h-64 flex items-end space-x-2">
                    @foreach($months as $i => $month)
                        @php $count = $monthlyRegistrations[$i+1] ?? 0; @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="bg-blue-500 w-3/4 rounded-t" style="height: {{ $count * 2 }}px"></div>
                            <span class="text-xs mt-2">{{ $month }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Dernières inscriptions -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Dernières inscriptions</h3>
                    <div class="space-y-4">
                        @foreach($latestRegistrations as $registration)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $registration->name ?? $registration->nom ?? '' }}</p>
                                        <p class="text-sm text-gray-500">{{ $registration->email ?? $registration->mention_envisagee ?? '' }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $registration->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('users.create') }}" class="p-4 border border-gray-200 rounded-lg text-center hover:bg-blue-50 transition">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                        </div>
                        <p class="font-medium">Nouvel utilisateur</p>
                    </a>

                    <a href="{{ route('students.index') }}" class="p-4 border border-gray-200 rounded-lg text-center hover:bg-green-50 transition">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                        </div>
                        <p class="font-medium">Voir étudiants</p>
                    </a>

                    <a href="#" class="p-4 border border-gray-200 rounded-lg text-center hover:bg-purple-50 transition">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <p class="font-medium">Rapports</p>
                    </a>

                    <a href="#" class="p-4 border border-gray-200 rounded-lg text-center hover:bg-orange-50 transition">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-cog text-orange-600 text-xl"></i>
                        </div>
                        <p class="font-medium">Paramètres</p>
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