<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des enseignants - Université Adventiste Zurcher</title>
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
    @include('dean.components.sidebar')
    <div class="main-content min-h-screen">
        @include('dean.components.header')
        <main class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Liste des enseignants</h1>
                <a href="{{ route('dean.teachers.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouvel enseignant
                </a>
            </div>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Téléphone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Diplôme</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($teachers as $teacher)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->telephone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->diplome }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun enseignant trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
