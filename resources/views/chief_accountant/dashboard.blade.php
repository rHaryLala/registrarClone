<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Comptable - Tableau de bord</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) { .sidebar { margin-left: -260px; } .main-content { margin-left: 0; } .sidebar.active { margin-left: 0; } }
        .nav-item:hover { background-color: rgba(255,255,255,0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        /* Reuse a few animations from chief_accountant dashboard */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .stats-card { animation: fadeInUp 0.6s ease-out; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar (reuse chief_accountant sidebar if available) -->
    @includeIf('chief_accountant.components.sidebar')

    <div class="main-content min-h-screen">
        @includeIf('chief_accountant.components.header')

        <main class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Bonjour, {{ $user->name ?? 'Utilisateur' }}.</h1>
                </div>
                <div class="text-sm text-gray-700">
                    Année académique active : <span class="font-semibold">{{ $activeAcademicYear ? $activeAcademicYear->libelle : 'Aucune' }}</span>
                </div>
            </div>

            <!-- Statistiques des étudiants -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Étudiants (Total)</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $counts['total'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-green-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-green-100 to-green-200 text-green-600 mr-4">
                            <i class="fas fa-user-friends text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Interne</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $counts['interne'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                            <i class="fas fa-user-tag text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Externe</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $counts['externe'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-orange-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 text-orange-600 mr-4">
                            <i class="fas fa-hand-holding-usd text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Boursiers</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800">{{ $counts['boursier'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé + derniers étudiants inscrits -->
                 <div class="content-card rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-slate-800">Derniers étudiants inscrits</h3>
                        <!-- Optionally add a link to the full students list if route exists -->
                        @if (Route::has('chief.accountant.students.list'))
                            <a href="{{ route('chief.accountant.students.list') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-200 flex items-center">Voir tous <i class="fas fa-arrow-right ml-2"></i></a>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @if($recentStudents->isEmpty())
                            <p class="text-sm text-gray-500">Aucun étudiant récent pour l'année académique active.</p>
                        @else
                            @foreach($recentStudents as $index => $s)
                                <div class="registration-item flex items-center justify-between p-6 rounded-2xl" style="--item-index: {{ $index }}">
                                    <div class="flex items-center space-x-6">
                                        <div class="avatar-container w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm">
                                            <span class="text-blue-600 font-bold text-lg">{{ strtoupper(substr($s->prenom ?? '', 0, 1) . substr($s->nom ?? '', 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-lg">{{ ($s->nom ?? '') . ' ' . ($s->prenom ?? '') }}</p>
                                            <p class="text-slate-500 font-medium">{{ $s->matricule ?? '-' }} • {{ $s->mention?->nom ?? '-' }} • {{ $s->yearLevel?->code ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-slate-500">{{ ($s->bursary_status) ? 'Boursier' : 'Non boursier' }}</p>
                                        <p class="text-sm text-slate-400">{{ $s->created_at ? $s->created_at->format('d/m/Y') : '-' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile (if the included sidebar uses the same id)
        const toggle = document.getElementById('sidebarToggle');
        if (toggle) {
            toggle.addEventListener('click', function() {
                const sb = document.querySelector('.sidebar');
                if (sb) sb.classList.toggle('active');
            });
        }
    </script>
</body>
</html>