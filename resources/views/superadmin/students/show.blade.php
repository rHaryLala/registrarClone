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
        @if(isset($student) && $student->lastChangedBy)
            <div id="last-change-toast" class="fixed top-4 right-4 z-50 bg-white border border-gray-200 shadow-lg rounded-lg px-4 py-3 flex items-start gap-3" role="status" aria-live="polite">
                <div class="text-blue-600 mt-1"><i class="fas fa-user-edit"></i></div>
                <div>
                    <div class="font-semibold text-sm">Dernière modification</div>
                    <div class="text-sm text-gray-700">
                        {{ $student->lastChangedBy->name }}@if($student->lastChangedBy->email) &nbsp;({{ $student->lastChangedBy->email }})@endif
                        <div class="text-xs text-gray-500">{{ $student->last_change_datetime ? \Carbon\Carbon::parse($student->last_change_datetime)->locale('fr')->isoFormat('D MMMM YYYY HH:mm') : '' }}</div>
                    </div>
                </div>
                <button id="last-change-toast-close" class="ml-3 text-gray-400 hover:text-gray-600" aria-label="Fermer">&times;</button>
            </div>
        @endif

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
                          <a href="{{ url('/preview') }}?ptype=Fiche_inscription&student_id={{ $student->id }}" target="_blank"
                              class="bg-blue-700 text-white px-6 py-4 rounded-2xl transition-all duration-300 flex items-center space-x-3 border border-blue-800 font-semibold hover:bg-blue-800 hover:scale-105 hover:shadow-xl">
                        <i class="fas fa-file-pdf text-lg"></i>
                        <span>Fiche d'inscription PDF</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="sexe">{{ $student->sexe ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-birthday-cake text-blue-600 mr-3"></i>Date de naissance</span>
                        <span class="font-bold text-gray-900 editable" data-field="date_naissance">
                            {{ $student->date_naissance ? \Carbon\Carbon::parse($student->date_naissance)->format('Y-m-d') : '-' }}
                        </span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>Lieu de naissance</span>
                        <span class="font-bold text-gray-900 editable" data-field="lieu_naissance">{{ $student->lieu_naissance ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-flag text-blue-600 mr-3"></i>Nationalité</span>
                        <span class="font-bold text-gray-900 editable" data-field="nationalite">{{ $student->nationalite ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-pray text-blue-600 mr-3"></i>Religion</span>
                        <span class="font-bold text-gray-900 editable" data-field="religion">{{ $student->religion ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-tshirt text-blue-600 mr-3"></i>Taille</span>
                        <span class="font-bold text-gray-900 editable" data-field="taille">{{ $student->taille ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-heart text-blue-600 mr-3"></i>État civil</span>
                        @php
                            $etatMap = [
                                'célibataire' => 'Célibataire',
                                'marié' => 'Marié(e)',
                                'divorcé' => 'Divorcé(e)',
                                'veuf' => 'Veuf(ve)'
                            ];
                            $displayEtat = $student->etat_civil ? ($etatMap[$student->etat_civil] ?? ucfirst($student->etat_civil)) : '-';
                        @endphp
                        <span class="font-bold text-gray-900 editable" data-field="etat_civil">{{ $displayEtat }}</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="telephone">{{ $student->telephone ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-envelope text-blue-600 mr-3"></i>Email</span>
                        <span class="font-bold text-gray-900 break-all editable" data-field="email">{{ $student->email ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-home text-blue-600 mr-3"></i>Adresse</span>
                        <span class="font-bold text-gray-900 text-right editable" data-field="adresse">{{ $student->adresse ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-globe text-blue-600 mr-3"></i>Région</span>
                        <span class="font-bold text-gray-900 editable" data-field="region">{{ $student->region ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map text-blue-600 mr-3"></i>District</span>
                        <span class="font-bold text-gray-900 editable" data-field="district">{{ $student->district ?: '-' }}</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="bacc_serie">{{ $student->bacc_serie ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-calendar text-blue-600 mr-3"></i>Date obtention Bac</span>
                        <span class="font-bold text-gray-900 editable" data-field="bacc_date_obtention">{{ $student->bacc_date_obtention ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-level-up-alt text-blue-600 mr-3"></i>Niveau d'étude</span>
                        <span class="font-bold text-gray-900 editable" data-field="year_level_id">{{ $student->yearLevel ? $student->yearLevel->label : '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-trophy text-blue-600 mr-3"></i>Mention</span>
                        <span class="font-bold text-gray-900 " data-field="mention_id">{{ $student->mention->nom ?? '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-route text-blue-600 mr-3"></i>Parcours</span>
                        <span class="font-bold text-gray-900 " data-field="parcours_id">{{ $student->parcours ? $student->parcours->nom : '-' }}</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="passport_numero">{{ $student->passport_numero ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Pays émission</span>
                        <span class="font-bold text-gray-900 editable" data-field="passport_pays_emission">{{ $student->passport_pays_emission ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date émission</span>
                        <span class="font-bold text-gray-900 editable" data-field="passport_date_emission">{{ $student->passport_date_emission ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date expiration</span>
                        <span class="font-bold text-gray-900 editable" data-field="passport_date_expiration">{{ $student->passport_date_expiration ?: '-' }}</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="cin_numero">{{ $student->cin_numero ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Date délivrance</span>
                        <span class="font-bold text-gray-900 editable" data-field="cin_date_delivrance">{{ $student->cin_date_delivrance ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Lieu délivrance</span>
                        <span class="font-bold text-gray-900 editable" data-field="cin_lieu_delivrance">{{ $student->cin_lieu_delivrance ?: '-' }}</span>
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
                        <span class="font-bold text-gray-900 editable" data-field="nom_conjoint">{{ $student->nom_conjoint ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold">Nombre d'enfants</span>
                        <span class="font-bold text-gray-900 editable" data-field="nb_enfant">{{ ($student->nb_enfant !== null && $student->nb_enfant !== '') ? $student->nb_enfant : '-' }}</span>
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
                                <span class="font-bold text-gray-900 editable" data-field="nom_pere">{{ $student->nom_pere ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-briefcase text-blue-600 mr-3"></i>Profession</span>
                                <span class="font-bold text-gray-900 editable" data-field="profession_pere">{{ $student->profession_pere ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Contact</span>
                                <span class="font-bold text-gray-900 editable" data-field="contact_pere">{{ $student->contact_pere ?: '-' }}</span>
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
                                <span class="font-bold text-gray-900 editable" data-field="nom_mere">{{ $student->nom_mere ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-briefcase text-blue-600 mr-3"></i>Profession</span>
                                <span class="font-bold text-gray-900 editable" data-field="profession_mere">{{ $student->profession_mere ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between items-center bg-white/70 p-4 rounded-xl">
                                <span class="text-gray-700 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Contact</span>
                                <span class="font-bold text-gray-900 editable" data-field="contact_mere">{{ $student->contact_mere ?: '-' }}</span>
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
                        <span class="font-bold text-gray-900 text-right max-w-md text-lg editable" data-field="adresse_parents">{{ $student->adresse_parents ?: '-' }}</span>
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
                        <span class="font-bold text-gray-900 text-lg editable" data-field="sponsor_nom">{{ $student->sponsor_nom ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-user text-blue-600 mr-3"></i>Prénom</span>
                        <span class="font-bold text-gray-900 text-lg editable" data-field="sponsor_prenom">{{ $student->sponsor_prenom ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Téléphone</span>
                        <span class="font-bold text-gray-900 text-lg editable" data-field="sponsor_telephone">{{ $student->sponsor_telephone ?: '-' }}</span>
                    </div>
                    <div class="info-item flex justify-between items-center py-5 px-4">
                        <span class="text-gray-700 font-bold flex items-center"><i class="fas fa-home text-blue-600 mr-3"></i>Adresse</span>
                        <span class="font-bold text-gray-900 text-right text-lg editable" data-field="sponsor_adresse">{{ $student->sponsor_adresse ?: '-' }}</span>
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
    to { opacity: 1, transform: translateX(0); }
}

@keyframes slide-in-right {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1, transform: translateX(0); }
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
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.image_url) {
                    // Mettre à jour l'image affichée
                    const img = document.getElementById('profile-photo');
                    const initials = document.getElementById('profile-initials');
                    
                    if (img) {
                        img.src = data.image_url;
                        img.style.display = 'block';
                        if (initials) initials.style.display = 'none';
                    } else {
                        // Recharger la page si l'élément img n'existe pas encore
                        location.reload();
                    }
                } else {
                    alert('Erreur lors du téléchargement de l\'image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors du téléchargement de l\'image');
            });
        }
    }

    function displayEtatLabel(val) {
        if (!val) return '-';
        const m = {
            'célibataire': 'Célibataire',
            'marié': 'Marié(e)',
            'divorcé': 'Divorcé(e)',
            'veuf': 'Veuf(ve)'
        };
        return m[val] || val;
    }

    document.querySelectorAll('.editable').forEach(function(span) {
    span.addEventListener('dblclick', function() {
        if (span.querySelector('input,select')) return; // Already editing

        const field = span.dataset.field;
        // Treat '-' or 'N/A' as empty for editing convenience
        const rawValue = span.textContent.trim();
        const value = (rawValue === '-' || rawValue === 'N/A') ? '' : rawValue;
        let input;

        // Simple example: use input for all, adapt as needed for select/date
        if (field === 'sexe') {
            input = document.createElement('select');
            input.innerHTML = '<option value="M">M</option><option value="F">F</option>';
            input.value = value;
        } else if (field === 'etat_civil') {
            input = document.createElement('select');
            // Option values are normalized to DB enum (lowercase, no parenthesis)
            input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                '<option value="célibataire">Célibataire</option>' +
                '<option value="marié">Marié(e)</option>' +
                '<option value="divorcé">Divorcé(e)</option>' +
                '<option value="veuf">Veuf(ve)</option>';
            if (value) input.value = value.toLowerCase();
        } else if (field === 'taille') {
            input = document.createElement('select');
            input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                '<option value="S">S</option>' +
                '<option value="M">M</option>' +
                '<option value="L">L</option>' +
                '<option value="XL">XL</option>' +
                '<option value="XXL">XXL</option>' +
                '<option value="XXXL">XXXL</option>';
            if (value) input.value = value;
        } else if (field === 'region') {
            input = document.createElement('select');
            input.innerHTML = '<option value="">Sélectionnez une région</option>' +
                '<option value="Analamanga">Analamanga</option>' +
                '<option value="Bongolava">Bongolava</option>' +
                '<option value="Itasy">Itasy</option>' +
                '<option value="Vakinankaratra">Vakinankaratra</option>' +
                '<option value="Diana">Diana</option>' +
                '<option value="Sava">Sava</option>' +
                '<option value="Amoron\'i Mania">Amoron\'i Mania</option>' +
                '<option value="Atsimo-Atsinanana">Atsimo-Atsinanana</option>' +
                '<option value="Fitovinany">Fitovinany</option>' +
                '<option value="Haute Matsiatra">Haute Matsiatra</option>' +
                '<option value="Ihorombe">Ihorombe</option>' +
                '<option value="Vatovavy">Vatovavy</option>' +
                '<option value="Betsiboka">Betsiboka</option>' +
                '<option value="Boeny">Boeny</option>' +
                '<option value="Melaky">Melaky</option>' +
                '<option value="Sofia">Sofia</option>' +
                '<option value="Alaotra-Mangoro">Alaotra-Mangoro</option>' +
                '<option value="Ambatosoa">Ambatosoa</option>' +
                '<option value="Analanjirofo">Analanjirofo</option>' +
                '<option value="Atsinanana">Atsinanana</option>' +
                '<option value="Androy">Androy</option>' +
                '<option value="Anosy">Anosy</option>' +
                '<option value="Atsimo-Andrefana">Atsimo-Andrefana</option>' +
                '<option value="Menabe">Menabe</option>';
            if (value) input.value = value;
        } else if (field === 'bacc_serie') {
            input = document.createElement('select');
            input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                '<option value="A1">A1</option>' +
                '<option value="A2">A2</option>' +
                '<option value="D">D</option>' +
                '<option value="C">C</option>' +
                '<option value="L">L</option>' +
                '<option value="S">S</option>' +
                '<option value="OSE">OSE</option>' +
                '<option value="TECHNIQUE">TECHNIQUE</option>';
            if (value) input.value = value;
        } else if (field === 'date_naissance') {
            input = document.createElement('input');
            input.type = 'date';
            input.value = value;
        } else {
            input = document.createElement('input');
            input.type = 'text';
            input.value = value;
        }
        input.className = 'border rounded px-2 py-1';
        span.textContent = '';
        span.appendChild(input);
        input.focus();

        function save() {
            const newValue = input.value;
            // If both old and new are empty, render '-' and do nothing
            if (newValue === value) {
                span.textContent = (newValue === '' ? '-' : newValue);
                return;
            }
            // Appel AJAX pour sauvegarder la modification
            const formPayload = new URLSearchParams();
            formPayload.append('_method', 'PUT');
            formPayload.append('_token', '{{ csrf_token() }}');
            formPayload.append(field, newValue);

            fetch("{{ route('superadmin.students.update', $student->id) }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formPayload
            })
            .then(async r => {
                if (r.status === 422) {
                    const err = await r.json().catch(() => null);
                    const first = err && err.errors ? (Object.values(err.errors)[0][0] || 'Erreur de validation') : (err && err.message ? err.message : 'Erreur de validation');
                    throw new Error(first);
                }
                return r.json();
            })
            .then(data => {
                if (data && data.success) {
                    if (field === 'etat_civil') {
                        span.textContent = displayEtatLabel(newValue);
                    } else {
                        span.textContent = (newValue === '' ? '-' : newValue);
                    }
                    // Recompute semester fees after a successful inline update
                    try { recomputeSemesterFee(); } catch(e) { console.error(e); }
                } else {
                    span.textContent = (value === '' ? '-' : value);
                    alert(data && data.message ? data.message : 'Erreur lors de la sauvegarde');
                }
            })
            .catch(err => {
                span.textContent = (value === '' ? '-' : value);
                alert(err && err.message ? err.message : 'Erreur lors de la sauvegarde');
            });
        }

        input.addEventListener('blur', function() {
            // Prevent sending empty for fields that are required on the server (etat_civil, taille, region, bacc_serie)
            if ((field === 'etat_civil' || field === 'taille' || field === 'region' || field === 'bacc_serie') && (input.value === null || input.value === '')) {
                // restore previous display and inform user
                span.textContent = (value === '' ? '-' : value);
                let fieldLabel = 'Le champ';
                if (field === 'etat_civil') fieldLabel = 'L\'état civil';
                else if (field === 'taille') fieldLabel = 'La taille';
                else if (field === 'region') fieldLabel = 'La région';
                else if (field === 'bacc_serie') fieldLabel = 'La série Bac';
                alert(fieldLabel + ' ne peut pas être vide. Veuillez choisir une valeur valide.');
                return;
            }
            save();
        });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                input.blur();
            } else if (e.key === 'Escape') {
                span.textContent = (value === '' ? '-' : value);
            }
        });
    });
});
    </script>
    <script>
    // yearLevels from backend for inline select (id + label)
    const YEAR_LEVELS = @json($yearLevels ?? []);

    // Helper to fetch parcours for a given mention id (returns [{id, nom}])
    async function fetchParcoursByMention(mentionId) {
        if (!mentionId) return [];
        try {
            const res = await fetch(`/parcours/by-mention/${mentionId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return [];
            const data = await res.json();
            return Array.isArray(data) ? data : [];
        } catch (e) {
            console.error('Erreur fetch parcours:', e);
            return [];
        }
    }

    document.querySelectorAll('.editable').forEach(function(span) {
    span.addEventListener('dblclick', function() {
        if (span.querySelector('input,select')) return; // Already editing

        const field = span.dataset.field;
        // Treat '-' or 'N/A' as empty for editing convenience
        const rawValue = span.textContent.trim();
        const value = (rawValue === '-' || rawValue === 'N/A') ? '' : rawValue;
        let input;

        // Use styled select built from YEAR_LEVELS for year_level_id
        if (field === 'year_level_id') {
            input = document.createElement('select');
            // Apply the same classes as the form select for consistent styling
            input.id = 'year_level_id';
            input.name = 'year_level_id';
            input.required = true;
            input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent';

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Sélectionnez l\'année';
            input.appendChild(placeholder);

            YEAR_LEVELS.forEach(l => {
                const o = document.createElement('option');
                o.value = l.id;
                o.textContent = l.label;
                input.appendChild(o);
            });

            // Try to preselect by id (if current span contains an id value) or by label
            if (value) {
                // If the span currently shows a label, find matching label and select its id
                const byLabel = YEAR_LEVELS.find(y => (y.label || '').toLowerCase() === value.toLowerCase());
                if (byLabel) {
                    input.value = byLabel.id;
                } else {
                    // If the span contained an id (unlikely), try to select by id
                    const byId = YEAR_LEVELS.find(y => String(y.id) === String(value));
                    if (byId) input.value = byId.id;
                }
            }
        } else {
            // ...existing code for other fields...
            if (field === 'parcours_id') {
                input = document.createElement('select');
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = '-- Sélectionner --';
                input.appendChild(placeholder);

                const STUDENT_MENTION_ID = {{ $student->mention_id ?? 'null' }};
                fetchParcoursByMention(STUDENT_MENTION_ID).then(list => {
                    list.forEach(p => {
                        const o = document.createElement('option');
                        o.value = p.id;
                        o.textContent = p.nom;
                        input.appendChild(o);
                    });
                    // try to preselect by matching label
                    if (value) {
                        const found = Array.from(input.options).find(opt => opt.textContent.toLowerCase() === value.toLowerCase());
                        if (found) input.value = found.value;
                    }
                }).catch(err => console.error(err));
            } else if (field === 'sexe') {
                input = document.createElement('select');
                input.innerHTML = '<option value="M">M</option><option value="F">F</option>';
                input.value = value;
            } else if (field === 'etat_civil') {
                input = document.createElement('select');
                input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                    '<option value="célibataire">Célibataire</option>' +
                    '<option value="marié">Marié(e)</option>' +
                    '<option value="divorcé">Divorcé(e)</option>' +
                    '<option value="veuf">Veuf(ve)</option>';
                if (value) input.value = value.toLowerCase();
            } else if (field === 'taille') {
                input = document.createElement('select');
                input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                    '<option value="S">S</option>' +
                    '<option value="M">M</option>' +
                    '<option value="L">L</option>' +
                    '<option value="XL">XL</option>' +
                    '<option value="XXL">XXL</option>' +
                    '<option value="XXXL">XXXL</option>';
                if (value) input.value = value;
            } else if (field === 'region') {
                input = document.createElement('select');
                input.innerHTML = '<option value="">Sélectionnez une région</option>' +
                    '<option value="Analamanga">Analamanga</option>' +
                    '<option value="Bongolava">Bongolava</option>' +
                    '<option value="Itasy">Itasy</option>' +
                    '<option value="Vakinankaratra">Vakinankaratra</option>' +
                    '<option value="Diana">Diana</option>' +
                    '<option value="Sava">Sava</option>' +
                    '<option value="Amoron\'i Mania">Amoron\'i Mania</option>' +
                    '<option value="Atsimo-Atsinanana">Atsimo-Atsinanana</option>' +
                    '<option value="Fitovinany">Fitovinany</option>' +
                    '<option value="Haute Matsiatra">Haute Matsiatra</option>' +
                    '<option value="Ihorombe">Ihorombe</option>' +
                    '<option value="Vatovavy">Vatovavy</option>' +
                    '<option value="Betsiboka">Betsiboka</option>' +
                    '<option value="Boeny">Boeny</option>' +
                    '<option value="Melaky">Melaky</option>' +
                    '<option value="Sofia">Sofia</option>' +
                    '<option value="Alaotra-Mangoro">Alaotra-Mangoro</option>' +
                    '<option value="Ambatosoa">Ambatosoa</option>' +
                    '<option value="Analanjirofo">Analanjirofo</option>' +
                    '<option value="Atsinanana">Atsinanana</option>' +
                    '<option value="Androy">Androy</option>' +
                    '<option value="Anosy">Anosy</option>' +
                    '<option value="Atsimo-Andrefana">Atsimo-Andrefana</option>' +
                    '<option value="Menabe">Menabe</option>';
                if (value) input.value = value;
            } else if (field === 'bacc_serie') {
                input = document.createElement('select');
                input.innerHTML = '<option value="">-- Sélectionner --</option>' +
                    '<option value="A1">A1</option>' +
                    '<option value="A2">A2</option>' +
                    '<option value="D">D</option>' +
                    '<option value="C">C</option>' +
                    '<option value="L">L</option>' +
                    '<option value="S">S</option>' +
                    '<option value="OSE">OSE</option>' +
                    '<option value="TECHNIQUE">TECHNIQUE</option>';
                if (value) input.value = value;
            } else if (field === 'date_naissance') {
                input = document.createElement('input');
                input.type = 'date';
                input.value = value;
            } else {
                input = document.createElement('input');
                input.type = 'text';
                input.value = value;
            }
        }
        input.className = 'border rounded px-2 py-1';
        span.textContent = '';
        span.appendChild(input);
        input.focus();

        function save() {
            let newValue = input.value;
            // For year_level_id we need to send id; also find label for display
            const payloadValue = (field === 'year_level_id') ? newValue : newValue;
            // If both old and new are empty, render '-' and do nothing
            if (payloadValue === (field === 'year_level_id' ? (value ? value : '') : value)) {
                span.textContent = (newValue === '' ? '-' : (field === 'year_level_id' && newValue ? (YEAR_LEVELS.find(y => y.id == newValue)||{}).label || newValue : newValue));
                return;
            }
            // Appel AJAX pour sauvegarder la modification
            const formPayload = new URLSearchParams();
            formPayload.append('_method', 'PUT');
            formPayload.append('_token', '{{ csrf_token() }}');
            formPayload.append(field, payloadValue);

            fetch("{{ route('superadmin.students.update', $student->id) }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formPayload
            })
            .then(async r => {
                if (r.status === 422) {
                    const err = await r.json().catch(() => null);
                    const first = err && err.errors ? (Object.values(err.errors)[0][0] || 'Erreur de validation') : (err && err.message ? err.message : 'Erreur de validation');
                    throw new Error(first);
                }
                return r.json();
            })
            .then(data => {
                if (data && data.success) {
                    if (field === 'etat_civil') {
                        span.textContent = displayEtatLabel(newValue);
                    } else if (field === 'year_level_id') {
                        const found = YEAR_LEVELS.find(y => y.id == newValue);
                        span.textContent = found ? found.label : (newValue === '' ? '-' : newValue);
                    } else if (field === 'parcours_id') {
                        // Try to find in the currently loaded options
                        const opt = input.querySelector(`option[value="${newValue}"]`);
                        if (opt) span.textContent = opt.textContent;
                        else span.textContent = (newValue === '' ? '-' : newValue);
                    } else {
                        span.textContent = (newValue === '' ? '-' : newValue);
                    }
                    // Recompute semester fees after a successful inline update
                    try { recomputeSemesterFee(); } catch(e) { console.error(e); }
                } else {
                    span.textContent = (value === '' ? '-' : value);
                    alert(data && data.message ? data.message : 'Erreur lors de la sauvegarde');
                }
            })
            .catch(err => {
                span.textContent = (value === '' ? '-' : value);
                alert(err && err.message ? err.message : 'Erreur lors de la sauvegarde');
            });
        }

        input.addEventListener('blur', function() {
            // Prevent sending empty for fields that are required on the server (etat_civil, taille, region, bacc_serie)
            if ((field === 'etat_civil' || field === 'taille' || field === 'region' || field === 'bacc_serie' || field === 'year_level_id') && (input.value === null || input.value === '')) {
                // restore previous display and inform user
                span.textContent = (value === '' ? '-' : value);
                let fieldLabel = 'Le champ';
                if (field === 'etat_civil') fieldLabel = 'L\'état civil';
                else if (field === 'taille') fieldLabel = 'La taille';
                else if (field === 'region') fieldLabel = 'La région';
                else if (field === 'bacc_serie') fieldLabel = 'La série Bac';
                else if (field === 'year_level_id') fieldLabel = 'Le niveau d\'étude';
                alert(fieldLabel + ' ne peut pas être vide. Veuillez choisir une valeur valide.');
                return;
            }
            save();
        });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                input.blur();
            } else if (e.key === 'Escape') {
                span.textContent = (value === '' ? '-' : value);
            }
        });
    });
});
    </script>
    <script>
    // Recompute StudentSemesterFee via AJAX and show a small notification
    async function recomputeSemesterFee() {
        try {
            const res = await fetch("{{ url('/superadmin/students/' . $student->id . '/recompute-semester-fee') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({'_token': '{{ csrf_token() }}'})
            });
            if (!res.ok) {
                const txt = await res.text().catch(()=>null);
                console.warn('Recompute returned not-ok', res.status, txt);
                return;
            }
            const data = await res.json().catch(()=>null);
            if (!data || !data.success) {
                console.warn('Recompute failed', data);
                return;
            }
            // Show a lightweight toast if totals changed
            const beforeTotal = data.before ? (data.before.total_amount || 0) : 0;
            const afterTotal = data.after ? (data.after.total_amount || 0) : 0;
            if (beforeTotal !== afterTotal) {
                console.info('Les frais semestriels ont changé: ' + beforeTotal + ' → ' + afterTotal);
            } else {
                console.info('Recompute done, no change in student semester fee total');
            }
        } catch (e) {
            console.error('Erreur lors du recalcul des frais semestriels:', e);
        }
    }

    (function() {
        const toast = document.getElementById('last-change-toast');
        if (!toast) return;
        const closeBtn = document.getElementById('last-change-toast-close');
        const hide = () => { toast.style.transition = 'opacity 0.4s'; toast.style.opacity = 0; setTimeout(() => toast.remove(), 500); };
        setTimeout(hide, 8000);
        if (closeBtn) closeBtn.addEventListener('click', hide);
    })();
    </script>
</body>
</html>
