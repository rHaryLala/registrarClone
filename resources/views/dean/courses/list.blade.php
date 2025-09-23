<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cours - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Updated fonts to match user list design -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        <!-- Updated typography and added modern animations -->
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Work Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        
        <!-- Added modern course card animations and hover effects -->
        .course-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }
        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .credit-badge {
            transition: all 0.2s ease;
        }
        .credit-badge:hover {
            transform: scale(1.05);
        }
        .action-btn {
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        <!-- Added responsive design for mobile cards -->
        @media (max-width: 768px) {
            .desktop-table { display: none; }
            .mobile-cards { display: block; }
        }
        @media (min-width: 769px) {
            .desktop-table { display: table; }
            .mobile-cards { display: none; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('dean.components.sidebar')
    <div class="main-content min-h-screen">
        @include('dean.components.header')
        <main class="p-4 md:p-6 lg:p-8">
            <!-- Enhanced header with gradient background and search functionality -->
            <div class="search-container rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Liste des cours</h1>
                        <p class="text-blue-100">Gérez les cours de votre université</p>
                    </div>
                    {{-- <a href="{{ route('dean.courses.create') }}" class="bg-white text-blue-800 px-6 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 flex items-center justify-center md:justify-start font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i> Nouveau cours
                    </a> --}}
                </div>
                
                <!-- Added search and filter functionality -->
                <div class="mt-6 flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher par sigle ou nom du cours..." 
                                   class="w-full px-4 py-3 pl-12 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/30">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop table with modern styling -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden desktop-table">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-blue-800 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider" data-sort="sigle" data-direction="asc">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-code text-blue-200"></i>
                                    Sigle
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-book text-blue-200"></i>
                                    Nom du cours
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-star text-blue-200"></i>
                                    Crédits
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chalkboard-teacher text-blue-200"></i>
                                    Professeur
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-graduation-cap text-blue-200"></i>
                                    Mention
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-blue-200"></i>
                                    Catégorie
                                </div>
                            </th>
                            {{-- <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cogs text-blue-200"></i>
                                    Actions
                                </div>
                            </th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="courseTableBody">
                        @forelse($courses as $course)
                            <tr class="cursor-pointer course-card hover:bg-blue-50/50 transition-all duration-300" onclick="window.location='{{ route('dean.courses.show', $course->id) }}'"> 
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold mr-4">
                                            {{ strtoupper(substr($course->sigle, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $course->sigle }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-gray-900">{{ $course->nom }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="credit-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $course->credits }} crédits
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-600">{{ $course->teacher->name ?? 'Non attribué' }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($course->mention)
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $course->mention->nom }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $course->categorie }}
                                    </span>
                                </td>
                                {{-- <td class="px-6 py-5">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('dean.courses.edit', $course->id) }}" 
                                           class="action-btn bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition-all duration-200 flex items-center text-sm font-medium">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </a>
                                        <form action="{{ route('dean.courses.destroy', $course->id) }}" method="POST" 
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition-all duration-200 flex items-center text-sm font-medium">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-book text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucun cours trouvé</p>
                                        <p class="text-sm">Commencez par ajouter votre premier cours</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Added mobile cards layout -->
            <div class="mobile-cards space-y-4" id="mobileCourseCards">
                @forelse($courses as $course)
                    <div class="course-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100" 
                         data-sigle="{{ strtolower($course->sigle) }}" 
                         data-nom="{{ strtolower($course->nom) }}" 
                         data-mention="{{ strtolower($course->mention->nom ?? '') }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ strtoupper(substr($course->sigle, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $course->sigle }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $course->nom }}</p>
                                </div>
                            </div>
                            <span class="credit-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $course->credits }} crédits
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Professeur</p>
                                <p class="text-sm font-medium text-gray-900">{{ $course->teacher->name ?? 'Non attribué' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Mention</p>
                                @if($course->mention)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $course->mention->nom }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Catégorie</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $course->categorie }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- <div class="flex gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('dean.courses.edit', $course->id) }}" 
                               class="action-btn flex-1 bg-blue-100 text-blue-700 px-4 py-3 rounded-xl hover:bg-blue-200 transition-all duration-200 flex items-center justify-center font-medium">
                                <i class="fas fa-edit mr-2"></i> Modifier
                            </a>
                            <form action="{{ route('dean.courses.destroy', $course->id) }}" method="POST" 
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="action-btn w-full bg-red-100 text-red-700 px-4 py-3 rounded-xl hover:bg-red-200 transition-all duration-200 flex items-center justify-center font-medium">
                                    <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                </button>
                            </form>
                        </div> --}}
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-gray-400">
                            <i class="fas fa-book text-6xl mb-6"></i>
                            <h3 class="text-xl font-semibold mb-2">Aucun cours trouvé</h3>
                            <p class="text-gray-500">Commencez par ajouter votre premier cours</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Added JavaScript for search and filter functionality -->
    <script>
        function filterCourses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const mentionFilter = document.getElementById('mentionFilter') ? document.getElementById('mentionFilter').value.toLowerCase() : '';

            // Desktop table
            const tableRows = document.querySelectorAll('#courseTableBody tr');
            tableRows.forEach(row => {
                // Récupère les valeurs à partir du contenu des cellules
                const sigle = (row.querySelector('td:nth-child(1) .text-sm.font-semibold')?.textContent || '').toLowerCase();
                const nom = (row.querySelector('td:nth-child(2) .text-sm.font-medium')?.textContent || '').toLowerCase();
                const mention = (row.querySelector('td:nth-child(5) span')?.textContent || '').toLowerCase();

                const matchesSearch = sigle.includes(searchTerm) || nom.includes(searchTerm);
                const matchesMention = !mentionFilter || mention === mentionFilter;

                if (matchesSearch && matchesMention) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Mobile cards
            const mobileCards = document.querySelectorAll('#mobileCourseCards .course-card');
            mobileCards.forEach(card => {
                const sigle = (card.querySelector('h3')?.textContent || '').toLowerCase();
                const nom = (card.querySelector('p.text-gray-600')?.textContent || '').toLowerCase();
                const mention = (card.querySelector('span.bg-purple-100')?.textContent || '').toLowerCase();

                const matchesSearch = sigle.includes(searchTerm) || nom.includes(searchTerm);
                const matchesMention = !mentionFilter || mention === mentionFilter;

                if (matchesSearch && matchesMention) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            if (document.getElementById('mentionFilter')) document.getElementById('mentionFilter').value = '';
            filterCourses();
        }

        document.getElementById('searchInput').addEventListener('input', filterCourses);
        if (document.getElementById('mentionFilter')) {
            document.getElementById('mentionFilter').addEventListener('change', filterCourses);
        }

        document.addEventListener('DOMContentLoaded', function() {
            filterCourses();
        });

        // --- SORTING ---
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.style.cursor = 'pointer';
            th.addEventListener('click', function() {
                const sortKey = th.getAttribute('data-sort');
                const tableBody = document.getElementById('courseTableBody');
                const rows = Array.from(tableBody.querySelectorAll('tr[data-sigle]'));
                const direction = th.getAttribute('data-direction') === 'desc' ? 'asc' : 'desc';
                th.setAttribute('data-direction', direction);

                rows.sort((a, b) => {
                    let aVal = (a.getAttribute('data-' + sortKey) || '').toLowerCase();
                    let bVal = (b.getAttribute('data-' + sortKey) || '').toLowerCase();
                    if (aVal < bVal) return direction === 'asc' ? -1 : 1;
                    if (aVal > bVal) return direction === 'asc' ? 1 : -1;
                    return 0;
                });

                rows.forEach(row => tableBody.appendChild(row));
            });
        });

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
