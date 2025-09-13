<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
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
    </style>
</head>
<body class="bg-gray-100">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Liste des étudiants</h1>
                <a href="{{ route('superadmin.students.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouvel étudiant
                </a>
            </div>
            <form method="get" class="mb-4 flex flex-wrap items-center space-x-2" id="searchForm" onsubmit="return false;">
                <label for="mention_id" class="font-medium">Filtrer par mention :</label>
                <select name="mention_id" id="mention_id" class="border rounded px-2 py-1">
                    <option value="">Toutes les mentions</option>
                    @foreach($mentions as $mention)
                        <option value="{{ $mention->id }}">
                            {{ $mention->nom }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="q" placeholder="Rechercher..." class="border rounded px-2 py-1 ml-2" id="searchInput" autocomplete="off" />
            </form>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="studentsTable">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Matricule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Prénom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                {{-- Ajout du tri par niveau d'étude --}}
                                @php
                                    function sort_link($label, $column) {
                                        $currentSort = request('sort', 'matricule');
                                        $currentDirection = request('direction', 'asc');
                                        $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                                        $icon = '';
                                        if ($currentSort === $column) {
                                            $icon = $currentDirection === 'asc' ? '▲' : '▼';
                                        }
                                        $query = array_merge(request()->except(['sort', 'direction']), ['sort' => $column, 'direction' => $newDirection]);
                                        $url = url()->current() . '?' . http_build_query($query);
                                        return '<a href="' . $url . '" class="hover:underline flex items-center">' . $label . ' <span class="ml-1 text-xs">' . $icon . '</span></a>';
                                    }
                                @endphp
                                {!! sort_link("Niveau d'étude", 'annee_etude') !!}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Mention</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="studentsTableBody">
                        {{-- Le contenu sera généré par JS --}}
                    </tbody>
                </table>
            </div>
            <script>
                // Charger tous les étudiants dans une variable JS
                const students = @json($studentsArray);
                const mentions = @json($mentionsArray);

                function renderTable(filteredStudents) {
                    const tbody = document.getElementById('studentsTableBody');
                    tbody.innerHTML = '';
                    if (filteredStudents.length === 0) {
                        tbody.innerHTML = `<tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun étudiant trouvé.</td>
                        </tr>`;
                        return;
                    }
                    filteredStudents.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.className = "cursor-pointer hover:bg-blue-50 transition";
                        tr.onclick = () => window.location = `/superadmin/students/${student.id}`;
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">${student.matricule}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${student.nom}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${student.prenom}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${student.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${student.annee_etude ?? '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${student.mention_nom}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                <form action="/superadmin/students/${student.id}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet étudiant ?');">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:underline flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }

                function filterStudents() {
                    const q = document.getElementById('searchInput').value.toLowerCase();
                    const mentionId = document.getElementById('mention_id').value;
                    let filtered = students.filter(student => {
                        let matchMention = !mentionId || student.mention_id == mentionId;
                        let matchSearch = !q || (
                            student.matricule.toLowerCase().includes(q) ||
                            student.nom.toLowerCase().includes(q) ||
                            student.prenom.toLowerCase().includes(q) ||
                            student.email.toLowerCase().includes(q) ||
                            student.mention_nom.toLowerCase().includes(q)
                        );
                        return matchMention && matchSearch;
                    });
                    renderTable(filtered);
                }

                document.getElementById('searchInput').addEventListener('input', filterStudents);
                document.getElementById('mention_id').addEventListener('change', filterStudents);

                // Initial render
                renderTable(students);
            </script>
        </main>
    </div>
</body>
</html>
