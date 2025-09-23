{{-- ...votre code de liste des mentions ici... --}}
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
        <!-- Modernized main section with improved design, better spacing, and contemporary styling -->
        <main class="p-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
            <!-- Header section with improved typography and spacing -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Liste des mentions</h1>
                    <p class="text-gray-600 text-sm">Gérez les mentions de votre université</p>
                </div>
                <a href="{{ route('superadmin.mentions.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <i class="fas fa-plus mr-2"></i> Nouvelle mention
                </a>
            </div>

            <!-- Modern card container with enhanced styling -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <!-- Table header with gradient background -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg flex items-center">
                        <i class="fas fa-list-ul mr-3"></i>
                        Mentions disponibles
                    </h2>
                </div>

                <!-- Responsive table wrapper -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-tag mr-2 text-gray-500"></i>
                                        Nom
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-align-left mr-2 text-gray-500"></i>
                                        Description
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-cogs mr-2 text-gray-500"></i>
                                        Actions
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($mentions as $mention)
                                <tr class="cursor-pointer hover:bg-blue-50 transition-all duration-200 group" 
                                    onclick="window.location='{{ route('superadmin.mentions.show', $mention->id) }}'">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mr-4 group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-200">
                                                <i class="fas fa-graduation-cap text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $mention->nom }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-700 max-w-xs truncate">{{ $mention->description }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('superadmin.mentions.edit', $mention->id) }}" 
                                               class="inline-flex items-center px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-all duration-200 hover:shadow-md">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </a>
                                            <form action="{{ route('superadmin.mentions.destroy', $mention->id) }}" method="POST" 
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette mention ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-all duration-200 hover:shadow-md">
                                                    <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune mention trouvée</h3>
                                            <p class="text-gray-500 text-sm mb-6">Commencez par créer votre première mention</p>
                                            <a href="{{ route('superadmin.mentions.create') }}" 
                                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium">
                                                <i class="fas fa-plus mr-2"></i> Créer une mention
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
