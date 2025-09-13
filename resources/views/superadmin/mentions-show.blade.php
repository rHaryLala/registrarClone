<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la mention - Université Adventiste Zurcher</title>
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
    </style>
</head>
<body class="bg-gray-100">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6 max-w-4xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Détail de la mention</h1>
                <a href="{{ route('superadmin.mentions.list') }}" class="text-blue-700 hover:underline flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
                </a>
            </div>
            <div class="bg-white shadow rounded-lg p-8 mb-8">
                <h2 class="text-xl font-semibold mb-4">Informations sur la mention</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div><span class="font-semibold">Nom :</span> {{ $mention->nom }}</div>
                    <div><span class="font-semibold">Description :</span> {{ $mention->description }}</div>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg p-8">
                <h2 class="text-xl font-semibold mb-4">Étudiants de la mention</h2>
                @if($mention->students && count($mention->students))
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Matricule</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($mention->students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->matricule }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->nom }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->prenom }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">Aucun étudiant dans cette mention.</p>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
