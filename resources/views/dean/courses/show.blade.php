<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du cours - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ url('public/favicon.png') }}" type="image/png">
    <style>
        body { 
            font-family: 'Work Sans', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        
        /* Added modern animations and effects */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .fade-in-delay-1 { animation-delay: 0.1s; }
        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .info-item {
            transition: all 0.3s ease;
            padding: 1rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 197, 253, 0.05) 100%);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        
        .info-item:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.1) 100%);
            transform: scale(1.02);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        .table-row {
            transition: all 0.3s ease;
        }
        
        .table-row:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 197, 253, 0.05) 100%);
            transform: translateX(5px);
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        
        .floating-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.1) 100%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    @include('dean.components.sidebar')
    <div class="main-content min-h-screen relative z-10">
        @include('dean.components.header')
        <main class="p-6 max-w-6xl mx-auto">
            <!-- Modernized header with gradient and animations -->
            <div class="mb-8 fade-in">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 p-8 text-white">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h1 class="text-3xl font-bold mb-2 font-['Work_Sans']">Détail du cours</h1>
                                <p class="text-blue-100 font-['Open_Sans']">Informations complètes et étudiants inscrits</p>
                            </div>
                            <a href="{{ route('dean.courses.list') }}" 
                               class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm border border-white/20">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span class="font-medium">Retour à la liste</span>
                            </a>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-transparent"></div>
                </div>
            </div>

            <!-- Modernized course information card -->
            <div class="glass-card rounded-2xl p-8 mb-8 fade-in fade-in-delay-1">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 font-['Work_Sans']">Informations sur le cours</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-item">
                        <div class="flex items-center">
                            <i class="fas fa-tag text-blue-600 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-500 font-['Open_Sans']">Sigle</span>
                                <div class="font-semibold text-gray-800 font-['Work_Sans']">{{ $course->sigle }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-500 font-['Open_Sans']">Nom du cours</span>
                                <div class="font-semibold text-gray-800 font-['Work_Sans']">{{ $course->nom }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="flex items-center">
                            <i class="fas fa-star text-blue-600 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-500 font-['Open_Sans']">Crédits</span>
                                <div class="font-semibold text-gray-800 font-['Work_Sans']">{{ $course->credits }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="flex items-center">
                            <i class="fas fa-user-tie text-blue-600 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-500 font-['Open_Sans']">Professeur</span>
                                <div class="font-semibold text-gray-800 font-['Work_Sans']">{{ $course->teacher->name ?? 'Non attribué' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modernized students table -->
            <div class="glass-card rounded-2xl p-8 fade-in fade-in-delay-2">
                <div class="flex items-center mb-6 justify-between">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 font-['Work_Sans']">
                        Étudiants inscrits
                        <span class="inline-block ml-3 text-base md:text-lg bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                            {{ optional($course->students)->count() ?? 0 }}
                        </span>
                    </h2>
                    <div class="ml-4">
                        <a href="{{ route('dean.courses.export', $course->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-file-pdf mr-2"></i>Exporter
                        </a>
                    </div>
                </div>
                
                @if($course->students && count($course->students))
                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-hidden rounded-xl border border-gray-200">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider font-['Work_Sans']">
                                        <i class="fas fa-id-card mr-2"></i>Matricule
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider font-['Work_Sans']">
                                        <i class="fas fa-user mr-2"></i>Nom
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider font-['Work_Sans']">
                                        <i class="fas fa-user mr-2"></i>Prénom
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider font-['Work_Sans']">
                                        <i class="fas fa-envelope mr-2"></i>Email
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($course->students as $index => $student)
                                    <tr class="table-row border-b border-gray-100 fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s">
                                        <td class="px-6 py-4 whitespace-nowrap font-['Open_Sans'] font-medium text-gray-900">
                                            {{ $student->matricule }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-['Open_Sans'] text-gray-700">
                                            {{ $student->nom }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-['Open_Sans'] text-gray-700">
                                            {{ $student->prenom }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-['Open_Sans'] text-blue-600">
                                            <a href="mailto:{{ $student->email }}" class="hover:underline">
                                                {{ $student->email }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        @foreach($course->students as $index => $student)
                            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 font-['Work_Sans']">{{ $student->prenom }} {{ $student->nom }}</h3>
                                        <p class="text-sm text-gray-500 font-['Open_Sans']">{{ $student->matricule }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-blue-600">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <a href="mailto:{{ $student->email }}" class="hover:underline font-['Open_Sans']">
                                        {{ $student->email }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-['Open_Sans'] text-lg">Aucun étudiant inscrit à ce cours.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
