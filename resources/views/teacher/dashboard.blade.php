<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard enseignant - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ url('public/favicon.png') }}" type="image/png">
    <style>
        * { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="dashboard-container flex">
        <!-- Sidebar -->
        <aside class="w-72">
            @include('teacher.components.sidebar')
        </aside>

        <div class="flex-1">
            <!-- Header -->
            <header class="sticky top-0 z-50">
                @include('teacher.components.header')
            </header>

            <main class="p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">Tableau de bord — Enseignant</h1>
                    <p class="text-slate-600">Bienvenue, {{ $user->name ?? $teacher->name }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <div class="flex items-center">
                            <div class="p-4 rounded-xl bg-blue-50 text-blue-600 mr-4">
                                <i class="fas fa-book text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 uppercase font-semibold">Cours enseignés</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalCourses ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <div class="flex items-center">
                            <div class="p-4 rounded-xl bg-green-50 text-green-600 mr-4">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 uppercase font-semibold">Étudiants concernés</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalStudents ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content-card bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4">Cours ({{ $totalCourses ?? 0 }})</h2>
                    <div class="space-y-4">
                        @foreach($courses as $course)
                            <div class="flex items-center justify-between p-4 rounded-lg border border-gray-100">
                                <div>
                                    <p class="font-semibold">{{ $course->nom }} <span class="text-gray-500">({{ $course->sigle }})</span></p>
                                    <p class="text-sm text-gray-500">{{ $course->students->count() }} étudiants</p>
                                </div>
                                <a href="#" class="text-blue-600 hover:underline">Voir</a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
