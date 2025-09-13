<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cours - Université Adventiste Zurcher</title>
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
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Liste des cours</h1>
                <a href="{{ route('superadmin.courses.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouveau cours
                </a>
            </div>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sigle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom du cours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Crédits</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Professeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Mention</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($courses as $course)
                            <tr class="cursor-pointer hover:bg-blue-50 transition" onclick="window.location='{{ route('superadmin.courses.show', $course->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->sigle }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->nom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->credits }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->teacher->name ?? 'Non attribué' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $course->mention->nom ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('superadmin.courses.edit', $course->id) }}" class="text-blue-600 hover:underline flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('superadmin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun cours trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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