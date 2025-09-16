<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finances - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        <main class="p-6 max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Ajouter une finance étudiante</h1>
            <div class="bg-white shadow rounded-lg p-8">
                <form action="{{ route('superadmin.finances.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Étudiant</label>
                        <select name="student_id" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="">Sélectionnez</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->prenom }} {{ $student->nom }} ({{ $student->matricule }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Type</label>
                        <input type="text" name="type" class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Montant</label>
                        <input type="number" name="montant" step="0.01" class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Statut</label>
                        <select name="status" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="pending">En attente</option>
                            <option value="paid">Payé</option>
                            <option value="overdue">Retard</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Cours (optionnel)</label>
                        <select name="course_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">Aucun</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->sigle }} - {{ $course->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Description</label>
                        <textarea name="description" class="w-full border rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800">Enregistrer</button>
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