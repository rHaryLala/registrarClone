<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'enseignant - Université Adventiste Zurcher</title>
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
        <main class="p-6 flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8 relative">
                    <h2 class="text-xl font-bold mb-6">Modifier l'enseignant</h2>
                    <form action="{{ route('superadmin.teachers.update', $teacher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                            <input type="text" name="name" value="{{ old('name', $teacher->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $teacher->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone', $teacher->telephone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Diplôme</label>
                            <input type="text" name="diplome" value="{{ old('diplome', $teacher->diplome) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('superadmin.teachers.list') }}" class="mr-4 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Annuler</a>
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
