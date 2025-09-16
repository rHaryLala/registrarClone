<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche étudiant - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Open Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        /* Harmonized glass card and gradient styles with consistent blue theme */
        .glass-card {
            background: rgba(30, 58, 138, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 58, 138, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15), 0 10px 20px -5px rgba(30, 58, 138, 0.08);
        }
        /* Added consistent animation system */
        .section-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);
        }
        .info-item {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        .info-item:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: translateX(4px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-blue-100 min-h-screen font-body">
    @include('superadmin.components.sidebar')
    
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        
<main class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Enhanced hero section with floating elements and improved animations -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="gradient-bg rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden animate-fade-in">
            <!-- Enhanced decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32 animate-float"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-24 -translate-x-24 animate-float-delayed"></div>
            <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white/5 rounded-full animate-pulse"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-3xl overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl cursor-pointer transition-all duration-500 hover:scale-110 hover:rotate-3 shadow-2xl border-2 border-white/30 hover:border-white/50">
                            <form id="photo-upload-form" action="{{ route('superadmin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 w-full h-full z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('PUT')
                                <input type="file" id="profile-photo-input" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadProfilePhoto(event)">
                            </form>
                            @if($student->image)
                                <img id="profile-photo" src="{{ asset($student->image) }}" alt="Photo de profil" class="object-cover w-full h-full rounded-3xl">
                            @else
                                <span id="profile-initials" class="font-heading text-4xl">{{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}</span>
                            @endif
                            <div class="absolute -bottom-4 -right-4 bg-white text-primary-800 rounded-full p-4 text-lg opacity-0 group-hover:opacity-100 transition-all duration-500 shadow-2xl transform group-hover:scale-110">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                    </div>
                    <div class="animate-slide-in-left">
                        <h1 class="text-5xl font-heading font-bold mb-4 text-balance bg-gradient-to-r from-white to-blue-100 bg-clip-text">{{ $student->prenom }} {{ $student->nom }}</h1>
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="bg-white/25 backdrop-blur-sm px-5 py-3 rounded-full text-sm font-semibold border border-white/30 hover:bg-white/35 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-id-badge mr-2 text-blue-200"></i>Matricule: {{ $student->matricule }}
                            </span>
                            @if($student->bursary_status)
                                <span class="bg-gradient-to-r from-yellow-400 to-amber-400 text-yellow-900 px-5 py-3 rounded-full text-sm font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-star mr-2 animate-pulse"></i>Boursier
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-4 animate-slide-in-right">
                    <a href="{{ route('superadmin.students.edit', $student->id) }}"
                       class="bg-white/25 backdrop-blur-sm hover:bg-white/40 text-white px-6 py-4 rounded-2xl transition-all duration-300 flex items-center space-x-3 border border-white/40 font-semibold hover:scale-105 hover:shadow-xl">
                        <i class="fas fa-edit text-lg"></i>
                        <span>Modifier</span>
                    </a>
                    <a href="{{ route('superadmin.students.courses.history', $student->id) }}" 
                       class="bg-white/25 backdrop-blur-sm hover:bg-white/40 text-white px-6 py-4 rounded-2xl transition-all duration-300 flex items-center space-x-3 border border-white/40 font-semibold hover:scale-105 hover:shadow-xl">
                        <i class="fas fa-book text-lg"></i>
                        <span>Cours</span>
                    </a>
                    <a href="{{ route('superadmin.finances.list') }}?student_id={{ $student->id }}" 
                       class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-6 py-4 rounded-2xl transition-all duration-300 flex items-center space-x-3 shadow-xl hover:shadow-2xl hover:scale-110 font-semibold">
                        <i class="fas fa-money-bill-wave text-lg"></i>
                        <span>Finances</span>
                    </a>
                    <a href="{{ route('superadmin.students.list') }}"
                       class="text-white hover:text-blue-100 flex items-center space-x-3 px-6 py-4 rounded-2xl hover:bg-white/15 transition-all duration-300 font-semibold hover:scale-105">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span>Retour</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced main content grid with staggered animations -->
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Standardized all section headers with consistent gradient and spacing -->
            <!-- Personal Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Informations personnelles</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <!-- Standardized all info items with consistent hover effects and spacing -->
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-venus-mars text-blue-600 mr-3"></i>Sexe</span>
                        <span class="font-bold text-gray-900">{{ $student->sexe }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-birthday-cake text-blue-600 mr-3"></i>Date de naissance</span>
                        <span class="font-bold text-gray-900">{{ $student->date_naissance }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>Lieu de naissance</span>
                        <span class="font-bold text-gray-900">{{ $student->lieu_naissance }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-flag text-blue-600 mr-3"></i>Nationalité</span>
                        <span class="font-bold text-gray-900">{{ $student->nationalite }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-pray text-blue-600 mr-3"></i>Religion</span>
                        <span class="font-bold text-gray-900">{{ $student->religion }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-heart text-blue-600 mr-3"></i>État civil</span>
                        <span class="font-bold text-gray-900">{{ $student->etat_civil }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-address-book text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Coordonnées</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Téléphone</span>
                        <span class="font-bold text-gray-900">{{ $student->telephone }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-envelope text-blue-600 mr-3"></i>Email</span>
                        <span class="font-bold text-gray-900 break-all">{{ $student->email }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-home text-blue-600 mr-3"></i>Adresse</span>
                        <span class="font-bold text-gray-900 text-right">{{ $student->adresse }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-globe text-blue-600 mr-3"></i>Région</span>
                        <span class="font-bold text-gray-900">{{ $student->region }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map text-blue-600 mr-3"></i>District</span>
                        <span class="font-bold text-gray-900">{{ $student->district }}</span>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Scolarité</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-certificate text-blue-600 mr-3"></i>Série Bac</span>
                        <span class="font-bold text-gray-900">{{ $student->bacc_serie }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-calendar text-blue-600 mr-3"></i>Date obtention Bac</span>
                        <span class="font-bold text-gray-900">{{ $student->bacc_date_obtention }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-level-up-alt text-blue-600 mr-3"></i>Année d'étude</span>
                        <span class="font-bold text-gray-900">{{ $student->annee_etude }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-trophy text-blue-600 mr-3"></i>Mention envisagée</span>
                        <span class="font-bold text-gray-900">{{ $student->mention->nom ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced documents row with improved animations and visual effects -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Standardized document cards with consistent blue theme -->
            <!-- Passport -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="flex items-center justify-between text-white relative z-10">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-passport text-xl"></i>
                            </div>
                            <h2 class="text-xl font-heading font-bold">Passeport</h2>
                        </div>
                        @if($student->passport_status)
                            <span class="bg-emerald-400 text-emerald-900 px-4 py-2 rounded-full text-xs font-bold shadow-lg animate-pulse">
                                <i class="fas fa-check mr-1"></i>Actif
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Numéro</span>
                        <span class="font-bold text-gray-900">{{ $student->passport_numero ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Pays émission</span>
                        <span class="font-bold text-gray-900">{{ $student->passport_pays_emission ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date émission</span>
                        <span class="font-bold text-gray-900">{{ $student->passport_date_emission ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date expiration</span>
                        <span class="font-bold text-gray-900">{{ $student->passport_date_expiration ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- ID Card -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-id-card text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Carte d'identité</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Numéro</span>
                        <span class="font-bold text-gray-900">{{ $student->cin_numero }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date délivrance</span>
                        <span class="font-bold text-gray-900">{{ $student->cin_date_delivrance }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Lieu délivrance</span>
                        <span class="font-bold text-gray-900">{{ $student->cin_lieu_delivrance }}</span>
                    </div>
                </div>
            </div>

            <!-- Family -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.6s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Famille</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Nom conjoint</span>
                        <span class="font-bold text-gray-900">{{ $student->nom_conjoint ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Nombre d'enfants</span>
                        <span class="font-bold text-gray-900">{{ $student->nb_enfant ?: '0' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced parents section with improved visual hierarchy and animations -->
        <!-- Harmonized parents section with consistent blue theme and spacing -->
        <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 mb-8 animate-fade-in-up" style="animation-delay: 0.7s">
            <div class="section-header p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                <div class="flex items-center text-white relative z-10">
                    <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mr-6 hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-home text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-heading font-bold">Informations des Parents</h2>
                </div>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Standardized parent cards with consistent blue theme -->
                    <!-- Father -->
                    <div class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 rounded-3xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <h3 class="font-heading font-bold text-blue-900 mb-6 pb-4 border-b-2 border-blue-300 flex items-center text-xl">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-male text-lg"></i>
                            </div>
                            Père
                        </h3>
                        <div class="space-y-4">
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-user text-blue-600 mr-3"></i>Nom</span>
                                <span class="font-bold text-gray-900">{{ $student->nom_pere }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-briefcase text-blue-600 mr-3"></i>Profession</span>
                                <span class="font-bold text-gray-900">{{ $student->profession_pere }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Contact</span>
                                <span class="font-bold text-gray-900">{{ $student->contact_pere }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mother -->
                    <div class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 rounded-3xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <h3 class="font-heading font-bold text-blue-900 mb-6 pb-4 border-b-2 border-blue-300 flex items-center text-xl">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-female text-lg"></i>
                            </div>
                            Mère
                        </h3>
                        <div class="space-y-4">
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-user text-blue-600 mr-3"></i>Nom</span>
                                <span class="font-bold text-gray-900">{{ $student->nom_mere }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-briefcase text-blue-600 mr-3"></i>Profession</span>
                                <span class="font-bold text-gray-900">{{ $student->profession_mere }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Contact</span>
                                <span class="font-bold text-gray-900">{{ $student->contact_mere }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-200 rounded-3xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-bold flex items-center text-lg">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            Adresse parents
                        </span>
                        <span class="font-bold text-gray-900 text-right max-w-md text-lg">{{ $student->adresse_parents }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced sponsor section with improved styling -->
        <!-- Harmonized sponsor section with consistent blue theme -->
        <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.8s">
            <div class="section-header p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="flex items-center text-white relative z-10">
                    <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mr-6 hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-heading font-bold">Informations du Sponsor</h2>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-user text-blue-600 mr-3"></i>Nom</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $student->sponsor_nom ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-user text-blue-600 mr-3"></i>Prénom</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $student->sponsor_prenom ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Téléphone</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $student->sponsor_telephone ?: 'N/A' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-home text-blue-600 mr-3"></i>Adresse</span>
                        <span class="font-bold text-gray-900 text-right text-lg">{{ $student->sponsor_adresse ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Enhanced and harmonized animations with consistent timing */
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-in-left {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slide-in-right {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

.animate-fade-in { animation: fade-in 0.8s ease-out forwards; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
.animate-slide-in-left { animation: slide-in-left 0.8s ease-out forwards; }
.animate-slide-in-right { animation: slide-in-right 0.8s ease-out forwards; }
.animate-float { animation: float 6s ease-in-out infinite; }
.animate-float-delayed { animation: float-delayed 8s ease-in-out infinite; }

/* Consistent hover effects across all cards */
.card-hover {
    transition: all 0.4s ease;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
}

/* Unified gradient background */
.gradient-bg, .section-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
}
</style>

    </div>

    <script>
    function uploadProfilePhoto(event) {
        const form = document.getElementById('photo-upload-form');
        const input = event.target;
        if (input.files && input.files[0]) {
            const formData = new FormData(form);
            formData.append('_method', 'PUT');
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.image_url) {
                    document.getElementById('profile-photo').src = data.image_url;
                } else {
                    location.reload();
                }
            })
            .catch(() => location.reload());
        }
    }
    </script>
</body>
</html>
