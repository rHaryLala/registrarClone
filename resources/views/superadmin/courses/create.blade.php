<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours - Université Adventiste Zurcher</title>
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
        <main class="p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Ajouter un cours</h1>
            <div class="bg-white shadow rounded-lg p-8">
                <form action="{{ route('superadmin.courses.store') }}" method="POST">
                    @csrf
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                            <strong>Erreur :</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Sigle</label>
                        <input type="text" name="sigle" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nom du cours</label>
                        <input type="text" name="nom" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Crédits</label>
                        <input type="number" name="credits" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Professeur</label>
                        <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Sélectionner --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Mention(s)</label>
                        <select name="mention_ids[]" class="w-full border border-gray-300 rounded-lg px-3 py-2" multiple size="4">
                            @foreach($mentions as $mention)
                                <option value="{{ $mention->id }}" @if(is_array(old('mention_ids', [])) && in_array($mention->id, old('mention_ids', []))) selected @endif>{{ $mention->nom }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs mentions.</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Niveau(x) d'étude</label>
                        <select name="year_level_ids[]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" multiple size="4" required>
                            @foreach($yearLevels as $level)
                                <option value="{{ $level->id }}" @if(is_array(old('year_level_ids', [])) && in_array($level->id, old('year_level_ids', []))) selected @endif>{{ $level->label }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs niveaux.</p>
                    </div>
                    <div class="flex justify-end">
                        <div class="mr-4">
                            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
                            <select name="categorie" class="border border-gray-300 rounded-lg px-3 py-2">
                                <option value="général" @if(old('categorie') == 'général') selected @endif>général</option>
                                <option value="majeur" @if(old('categorie') == 'majeur') selected @endif>majeur</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
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
