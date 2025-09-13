<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours à l'étudiant</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6">
            <div class="max-w-2xl mx-auto mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Ajouter un cours à {{ $student->prenom }} {{ $student->nom }}</h1>
                    <a href="{{ route('superadmin.students.show', $student->id) }}" class="text-blue-800 hover:text-blue-900 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour</span>
                    </a>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <form action="{{ route('superadmin.students.courses.store', $student->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Sélectionnez les cours à ajouter :</h2>
                            <ul class="space-y-2">
                                @foreach($courses as $course)
                                    <li class="flex items-center gap-3">
                                        <input type="checkbox" name="course_id[]" value="{{ $course->id }}" id="course_{{ $course->id }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded">
                                        <label for="course_{{ $course->id }}" class="font-medium text-gray-800">{{ $course->sigle }} - {{ $course->nom }} ({{ $course->mention->nom ?? '-' }})</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded-lg hover:bg-blue-900 transition flex items-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
