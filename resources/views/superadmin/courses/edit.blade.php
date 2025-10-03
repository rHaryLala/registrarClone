<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le cours - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ url('public/favicon.png') }}" type="image/png">
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
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6 flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8 relative">
                    <h2 class="text-xl font-bold mb-6">Modifier le cours</h2>
                    <form action="{{ route('superadmin.courses.update', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Sigle</label>
                            <input type="text" name="sigle" value="{{ old('sigle', $course->sigle) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Nom du cours</label>
                            <input type="text" name="nom" value="{{ old('nom', $course->nom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Crédits</label>
                            <input type="number" name="credits" min="1" value="{{ old('credits', $course->credits) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Professeur</label>
                            <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Sélectionner --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @if(old('teacher_id', $course->teacher_id) == $teacher->id) selected @endif>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Mentions (sélection multiple possible)</label>
                            <select name="mention_ids[]" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2" size="5">
                                @foreach($mentions as $mention)
                                    <option value="{{ $mention->id }}" @if(in_array($mention->id, old('mention_ids', $course->mentions()->pluck('mentions.id')->toArray()))) selected @endif>{{ $mention->nom }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs mentions.</p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Niveaux (sélection multiple possible)</label>
                            <select name="year_level_ids[]" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" size="5" required>
                                @foreach($yearLevels as $level)
                                    <option value="{{ $level->id }}" @if(in_array($level->id, old('year_level_ids', $course->yearLevels()->pluck('year_levels.id')->toArray()))) selected @endif>{{ $level->label }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs niveaux.</p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
                            <select name="categorie" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="général" @if(old('categorie', $course->categorie) == 'général') selected @endif>Général</option>
                                <option value="majeur" @if(old('categorie', $course->categorie) == 'majeur') selected @endif>Majeur</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('superadmin.courses.list') }}" class="mr-4 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Annuler</a>
                            <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
