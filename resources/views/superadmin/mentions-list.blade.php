<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des mentions - Université Adventiste Zurcher</title>
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
                <h1 class="text-2xl font-bold">Liste des mentions</h1>
                <a href="{{ route('superadmin.mentions.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouvelle mention
                </a>
            </div>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($mentions as $mention)
                            <tr class="cursor-pointer hover:bg-blue-50 transition" onclick="window.location='{{ route('superadmin.mentions.show', $mention->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $mention->nom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $mention->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('superadmin.mentions.edit', $mention->id) }}" class="text-blue-600 hover:underline flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('superadmin.mentions.destroy', $mention->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette mention ?');">
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
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune mention trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
