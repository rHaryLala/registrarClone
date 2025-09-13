<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours de {{ $student->prenom }} {{ $student->nom }} - Université Adventiste Zurcher</title>
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
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-semibold text-gray-900">Cours de {{ $student->prenom }} {{ $student->nom }}</h1>
                <a href="{{ route('superadmin.students.courses.add', $student->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un cours</span>
                </a>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Sigle</th>
                                <th class="px-4 py-2">Nom</th>
                                <th class="px-4 py-2">Date d'ajout</th>
                                <th class="px-4 py-2">Date de retrait</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->courses()->withPivot('added_at', 'created_at', 'deleted_at')->get() as $course)
                                <tr @if($course->pivot->deleted_at) class="bg-red-50" @endif>
                                    <td class="px-4 py-2">{{ $course->sigle }}</td>
                                    <td class="px-4 py-2">{{ $course->nom }}</td>
                                    <td class="px-4 py-2">{{ $course->pivot->added_at ? \Carbon\Carbon::parse($course->pivot->added_at)->format('d/m/Y H:i') : '-' }}</td>
                                    <td class="px-4 py-2">
                                        @if($course->pivot->deleted_at)
                                            {{ \Carbon\Carbon::parse($course->pivot->deleted_at)->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if(!$course->pivot->deleted_at)
                                            <form action="{{ route('superadmin.students.courses.remove', [$student->id, $course->id]) }}" method="POST" onsubmit="return confirm('Retirer ce cours ?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:underline">Retirer</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Retiré</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
