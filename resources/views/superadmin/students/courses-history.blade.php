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
        @import url('https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap');
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-row {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .animate-fade-in { animation: fade-in 0.8s ease-out; }
        .animate-fade-in-up { animation: fade-in-up 1s ease-out; }
        .animate-fade-in-row { animation: fade-in-row 0.6s ease-out forwards; opacity: 0; }
        .animate-slide-in-left { animation: slide-in-left 0.8s ease-out; }
        .animate-slide-in-right { animation: slide-in-right 0.8s ease-out; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 6s ease-in-out infinite 3s; }
    </style>
</head>
<body class="bg-gray-100">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')

        <main class="p-6 max-w-6xl mx-auto">
            <!-- Header avec gradient et animations -->
            <div class="bg-gradient-to-r from-blue-800 via-blue-700 to-blue-600 rounded-xl shadow-2xl p-8 mb-8 relative overflow-hidden animate-fade-in">
                <!-- Formes flottantes animées -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16 animate-float"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/5 rounded-full translate-x-12 translate-y-12 animate-float-delayed"></div>
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 relative z-10">
                    <div class="animate-slide-in-left">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 font-['Work_Sans']">
                            Cours de {{ $student->prenom }} {{ $student->nom }}
                        </h1>
                        <p class="text-blue-100 text-lg font-['Open_Sans']">Gestion des inscriptions aux cours</p>
                    </div>
                    
                    <div class="animate-slide-in-right flex items-center gap-3">
                        <a href="{{ route('superadmin.students.courses.add', $student->id) }}" 
                        class="inline-flex items-center space-x-3 bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 transform hover:scale-105 hover:shadow-xl border border-white/20 group">
                            <i class="fas fa-plus text-lg group-hover:rotate-90 transition-transform duration-300"></i>
                            <span class="font-semibold">Ajouter un cours</span>
                        </a>
                        <a href="{{ route('superadmin.students.show', $student->id) }}" 
                        class="inline-flex items-center space-x-3 bg-white/10 text-white px-4 py-2 rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/10">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modernisation du tableau avec animations et effets visuels -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/20 overflow-hidden animate-fade-in-up">
                <!-- Version Desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full table-fixed">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
                                <th class="w-1/5 px-6 py-4 text-left text-sm font-bold text-blue-900 uppercase tracking-wider font-['Work_Sans']">Sigle</th>
                                <th class="w-2/5 px-6 py-4 text-left text-sm font-bold text-blue-900 uppercase tracking-wider font-['Work_Sans']">Nom</th>
                                <th class="w-1/5 px-6 py-4 text-left text-sm font-bold text-blue-900 uppercase tracking-wider font-['Work_Sans']">Date d'ajout</th>
                                <th class="w-1/5 px-6 py-4 text-left text-sm font-bold text-blue-900 uppercase tracking-wider font-['Work_Sans']">Date de retrait</th>
                                <th class="w-1/5 px-6 py-4 text-left text-sm font-bold text-blue-900 uppercase tracking-wider font-['Work_Sans']">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($student->courses()->withPivot('added_at', 'created_at', 'deleted_at')->get() as $index => $course)
                                <tr class="hover:bg-blue-50/50 transition-all duration-300 transform hover:scale-[1.01] animate-fade-in-row @if($course->pivot->deleted_at) bg-red-50/80 @endif" 
                                    style="animation-delay: {{ $index * 0.1 }}s">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm mr-3 shadow-lg">
                                                {{ substr($course->sigle, 0, 2) }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900 font-['Open_Sans']">{{ $course->sigle }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 font-['Open_Sans']">{{ $course->nom }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 font-['Open_Sans']">
                                            {{ $course->pivot->added_at ? \Carbon\Carbon::parse($course->pivot->added_at)->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 font-['Open_Sans']">
                                            @if($course->pivot->deleted_at)
                                                {{ \Carbon\Carbon::parse($course->pivot->deleted_at)->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!$course->pivot->deleted_at)
                                            <form action="{{ route('superadmin.students.courses.remove', [$student->id, $course->id]) }}" method="POST" 
                                                onsubmit="return confirm('Retirer ce cours ?');" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-300 transform hover:scale-105 text-sm font-medium group">
                                                    <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                                                    Retirer
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-500 rounded-lg text-sm font-medium">
                                                <i class="fas fa-check mr-2"></i>
                                                Retiré
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Version Mobile responsive avec cartes -->
                <div class="md:hidden p-4 space-y-4">
                    @foreach($student->courses()->withPivot('added_at', 'created_at', 'deleted_at')->get() as $index => $course)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 transform hover:scale-[1.02] transition-all duration-300 animate-fade-in-up @if($course->pivot->deleted_at) bg-red-50 border-red-200 @endif"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold mr-3 shadow-lg">
                                        {{ substr($course->sigle, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 font-['Work_Sans']">{{ $course->sigle }}</h3>
                                        <p class="text-sm text-gray-600 font-['Open_Sans']">{{ $course->nom }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                                <div>
                                    <span class="text-gray-500 font-medium">Date d'ajout:</span>
                                    <p class="text-gray-900 font-['Open_Sans']">
                                        {{ $course->pivot->added_at ? \Carbon\Carbon::parse($course->pivot->added_at)->format('d/m/Y H:i') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">Date de retrait:</span>
                                    <p class="text-gray-900 font-['Open_Sans']">
                                        @if($course->pivot->deleted_at)
                                            {{ \Carbon\Carbon::parse($course->pivot->deleted_at)->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                @if(!$course->pivot->deleted_at)
                                    <form action="{{ route('superadmin.students.courses.remove', [$student->id, $course->id]) }}" method="POST" 
                                        onsubmit="return confirm('Retirer ce cours ?');" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-300 transform hover:scale-105 text-sm font-medium group">
                                            <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                                            Retirer
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 rounded-lg text-sm font-medium">
                                        <i class="fas fa-check mr-2"></i>
                                        Retiré
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

    </div>
</body>
</html>
