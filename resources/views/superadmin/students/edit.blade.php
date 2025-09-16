<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'étudiant - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e3a8a',
                            900: '#1e40af'
                        }
                    },
                    fontFamily: {
                        'heading': ['Work Sans', 'sans-serif'],
                        'body': ['Open Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        
    /* Harmonisation des styles de cartes et effets visuels */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);
    }
    
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.1), 0 10px 10px -5px rgba(30, 58, 138, 0.04);
    }
    
    /* Styles cohérents pour les sections */
    .form-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(30, 58, 138, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(30, 58, 138, 0.08);
    }
    
    .section-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }
    
    /* Headers de section unifiés */
    .section-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 1rem 1rem 0 0;
    }
    
    /* Inputs cohérents */
    .form-input {
        border: 2px solid #e5e7eb;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: rgba(255, 255, 255, 1);
    }
    
    /* Boutons cohérents */
    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    }
    
    .btn-secondary {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 2px solid #d1d5db;
    }
    
    .btn-secondary:hover {
        background: rgba(107, 114, 128, 0.2);
        border-color: #9ca3af;
    }
    
    /* Animations cohérentes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
    
    /* Photo preview cohérente */
    .photo-preview {
        border: 4px solid rgba(59, 130, 246, 0.2);
        transition: all 0.3s ease;
    }
    
    .photo-preview:hover {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
    }
    
    /* Sous-sections cohérentes */
    .sub-section {
        background: rgba(248, 250, 252, 0.8);
        border: 1px solid rgba(30, 58, 138, 0.05);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .sub-section h3 {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-blue-100 min-h-screen font-body">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6">
            <!-- Hero section harmonisée -->
            <div class="max-w-7xl mx-auto mb-8">
                <div class="gradient-bg rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-32 translate-x-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex items-center space-x-6">
                            <div class="relative group">
                                <div class="w-24 h-24 rounded-3xl overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl cursor-pointer transition-all duration-300 hover:scale-105 shadow-xl border border-white/20">
                                    <label for="image" class="cursor-pointer block absolute inset-0 w-full h-full z-10 opacity-0 group-hover:opacity-100 transition-opacity"></label>
                                    @if($student->image)
                                        <img id="photo-preview" src="{{ asset($student->image) }}" alt="Photo de profil" class="object-cover w-full h-full rounded-3xl">
                                    @else
                                        <span id="profile-initials" class="font-heading">{{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}</span>
                                    @endif
                                </div>
                                <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                            </div>
                            <div>
                                <h1 class="text-4xl font-heading font-bold mb-3 text-balance">{{ $student->prenom }} {{ $student->nom }}</h1>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium border border-white/20">
                                        Matricule: {{ $student->matricule }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('superadmin.students.show', $student->id) }}"
                               class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-5 py-3 rounded-2xl transition-all duration-200 flex items-center space-x-2 border border-white/30 font-medium">
                                <i class="fas fa-arrow-left"></i>
                                <span>Retour</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire avec sections regroupées et modernisées -->
            <div class="max-w-6xl mx-auto">
                <form action="{{ route('superadmin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Regroupement des sections en colonnes pour une meilleure organisation -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Colonne gauche -->
                        <div class="space-y-8">
                            
                            <!-- Section photo avec design moderne -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-camera text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Photo de profil</h2>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="photo-container mb-4 relative group">
                                        <label for="image" class="cursor-pointer block">
                                            <img id="photo-preview" src="{{ $student->image ? asset($student->image) : asset('photo_profil/default.png') }}" 
                                                 alt="Photo de profil" class="photo-preview w-32 h-32 rounded-full object-cover transition-all duration-300 group-hover:scale-105 shadow-lg">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <i class="fas fa-camera text-white text-2xl"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                                    @error('image')<div class="text-red-500 text-sm mt-1 font-medium">{{ $message }}</div>@enderror
                                    <p class="text-gray-600 text-sm font-medium text-center">Cliquez sur la photo pour choisir une image</p>
                                </div>
                            </div>

                            <!-- Section informations personnelles avec espacement cohérent -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-user text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Informations personnelles</h2>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Nom</label>
                                            <input type="text" id="nom" name="nom" value="{{ old('nom', $student->nom) }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('nom')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Prénom</label>
                                            <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $student->prenom) }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('prenom')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Sexe</label>
                                            <select id="sexe" name="sexe" class="form-input w-full rounded-lg px-4 py-3" required>
                                                <option value="">Sélectionnez le sexe</option>
                                                <option value="M" {{ old('sexe', $student->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                                <option value="F" {{ old('sexe', $student->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                            </select>
                                            @error('sexe')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Date de naissance</label>
                                            <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $student->date_naissance ? $student->date_naissance->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('date_naissance')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Lieu de naissance</label>
                                            <input type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $student->lieu_naissance) }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('lieu_naissance')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Nationalité</label>
                                            <input type="text" id="nationalite" name="nationalite" value="{{ old('nationalite', $student->nationalite) }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('nationalite')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Religion</label>
                                            <input type="text" id="religion" name="religion" value="{{ old('religion', $student->religion) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            @error('religion')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">État civil</label>
                                            <select id="etat_civil" name="etat_civil" class="form-input w-full rounded-lg px-4 py-3" required>
                                                <option value="">Sélectionnez l'état civil</option>
                                                <option value="célibataire" {{ old('etat_civil', $student->etat_civil) == 'célibataire' ? 'selected' : '' }}>Célibataire</option>
                                                <option value="marié" {{ old('etat_civil', $student->etat_civil) == 'marié' ? 'selected' : '' }}>Marié(e)</option>
                                                <option value="divorcé" {{ old('etat_civil', $student->etat_civil) == 'divorcé' ? 'selected' : '' }}>Divorcé(e)</option>
                                                <option value="veuf" {{ old('etat_civil', $student->etat_civil) == 'veuf' ? 'selected' : '' }}>Veuf(ve)</option>
                                            </select>
                                            @error('etat_civil')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section coordonnées avec design cohérent -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-address-book text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Coordonnées & Contact</h2>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Téléphone</label>
                                            <input type="text" name="telephone" value="{{ old('telephone', $student->telephone) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Email</label>
                                            <input type="email" name="email" value="{{ old('email', $student->email) }}" class="form-input w-full rounded-lg px-4 py-3" required>
                                            @error('email')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-gray-800 font-semibold mb-3 font-body">Adresse</label>
                                        <input type="text" name="adresse" value="{{ old('adresse', $student->adresse) }}" class="form-input w-full rounded-lg px-4 py-3">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Région</label>
                                            <input type="text" name="region" value="{{ old('region', $student->region) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">District</label>
                                            <input type="text" name="district" value="{{ old('district', $student->district) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section famille avec design unifié -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-users text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Famille & Conjoint</h2>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Nom conjoint</label>
                                            <input type="text" name="nom_conjoint" value="{{ old('nom_conjoint', $student->nom_conjoint) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Nombre d'enfants</label>
                                            <input type="number" name="nb_enfant" value="{{ old('nb_enfant', $student->nb_enfant) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite -->
                        <div class="space-y-8">
                            
                            <!-- Section documents avec sous-sections cohérentes -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.5s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-id-card text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Documents d'identité</h2>
                                    </div>
                                </div>
                                
                                <!-- Sous-section Passeport avec design cohérent -->
                                <div class="sub-section">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center font-heading">
                                        <i class="fas fa-passport text-blue-600 mr-3"></i>
                                        Passeport
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" name="passport_status" value="1" @if(old('passport_status', $student->passport_status)) checked @endif class="w-5 h-5 text-blue-800 rounded">
                                            <label class="text-gray-800 font-semibold font-body">Possède un passeport</label>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Numéro passeport</label>
                                                <input type="text" name="passport_numero" value="{{ old('passport_numero', $student->passport_numero) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Pays émission</label>
                                                <input type="text" name="passport_pays_emission" value="{{ old('passport_pays_emission', $student->passport_pays_emission) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Date émission</label>
                                                <input type="date" name="passport_date_emission" value="{{ old('passport_date_emission', $student->passport_date_emission ? $student->passport_date_emission->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Date expiration</label>
                                                <input type="date" name="passport_date_expiration" value="{{ old('passport_date_expiration', $student->passport_date_expiration ? $student->passport_date_expiration->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sous-section CIN avec design cohérent -->
                                <div class="sub-section">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center font-heading">
                                        <i class="fas fa-address-card text-green-600 mr-3"></i>
                                        Carte d'identité nationale
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Numéro CIN</label>
                                                <input type="text" name="cin_numero" value="{{ old('cin_numero', $student->cin_numero) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Date délivrance</label>
                                                <input type="date" name="cin_date_delivrance" value="{{ old('cin_date_delivrance', $student->cin_date_delivrance ? $student->cin_date_delivrance->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-medium mb-2 font-body">Lieu délivrance</label>
                                            <input type="text" name="cin_lieu_delivrance" value="{{ old('cin_lieu_delivrance', $student->cin_lieu_delivrance) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section scolarité avec espacement unifié -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.6s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-graduation-cap text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Scolarité & Formation</h2>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Série Bac</label>
                                            <input type="text" name="bacc_serie" value="{{ old('bacc_serie', $student->bacc_serie) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Date obtention Bac</label>
                                            <input type="date" name="bacc_date_obtention" value="{{ old('bacc_date_obtention', $student->bacc_date_obtention ? $student->bacc_date_obtention->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="bursary_status" value="1" @if(old('bursary_status', $student->bursary_status)) checked @endif class="w-5 h-5 text-blue-800 rounded">
                                        <label class="text-gray-800 font-semibold font-body">Boursier</label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Niveau d'étude</label>
                                            <select id="annee_etude" name="annee_etude" required class="form-input w-full rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                                <option value="">Sélectionnez l'année</option>
                                                <option value="L1" @if(old('annee_etude', $student->annee_etude)=="L1") selected @endif>Licence 1</option>
                                                <option value="L2" @if(old('annee_etude', $student->annee_etude)=="L2") selected @endif>Licence 2</option>
                                                <option value="L3" @if(old('annee_etude', $student->annee_etude)=="L3") selected @endif>Licence 3</option>
                                                <option value="M1" @if(old('annee_etude', $student->annee_etude)=="M1") selected @endif>Master 1</option>
                                                <option value="M2" @if(old('annee_etude', $student->annee_etude)=="M2") selected @endif>Master 2</option>
                                            </select>
                                            @error('annee_etude')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-800 font-semibold mb-3 font-body">Mention envisagée</label>
                                            <select id="mention_id" name="mention_id" class="form-input w-full rounded-lg px-4 py-3" required>
                                                <option value="">Sélectionnez la mention</option>
                                                @foreach($mentions as $mention)
                                                    <option value="{{ $mention->id }}" @if(old('mention_id', $student->mention_id) == $mention->id) selected @endif>{{ $mention->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error('mention_id')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-gray-800 font-semibold mb-3 font-body">Parcours</label>
                                        <select id="parcours_id" name="parcours_id" class="form-input w-full rounded-lg px-4 py-3" required>
                                            <option value="">Sélectionnez le parcours</option>
                                            @php if(!isset($parcours)) { $parcours = []; } @endphp
                                            @foreach($parcours as $parc)
                                                <option value="{{ $parc->id }}" {{ old('parcours_id', $student->parcours_id) == $parc->id ? 'selected' : '' }}>{{ $parc->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('parcours_id')<div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section parents et sponsor avec sous-sections cohérentes -->
                            <div class="form-section section-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.7s;">
                                <div class="section-header mb-6">
                                    <div class="flex items-center text-white">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-home text-lg"></i>
                                        </div>
                                        <h2 class="text-xl font-bold font-heading">Parents & Sponsor</h2>
                                    </div>
                                </div>
                                
                                <!-- Sous-section Parents avec design cohérent -->
                                <div class="sub-section">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center font-heading">
                                        <i class="fas fa-users text-purple-600 mr-3"></i>
                                        Informations des parents
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Nom père</label>
                                                <input type="text" name="nom_pere" value="{{ old('nom_pere', $student->nom_pere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Profession père</label>
                                                <input type="text" name="profession_pere" value="{{ old('profession_pere', $student->profession_pere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Contact père</label>
                                                <input type="text" name="contact_pere" value="{{ old('contact_pere', $student->contact_pere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Nom mère</label>
                                                <input type="text" name="nom_mere" value="{{ old('nom_mere', $student->nom_mere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Profession mère</label>
                                                <input type="text" name="profession_mere" value="{{ old('profession_mere', $student->profession_mere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Contact mère</label>
                                                <input type="text" name="contact_mere" value="{{ old('contact_mere', $student->contact_mere) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-medium mb-2 font-body">Adresse parents</label>
                                            <input type="text" name="adresse_parents" value="{{ old('adresse_parents', $student->adresse_parents) }}" class="form-input w-full rounded-lg px-4 py-3">
                                        </div>
                                    </div>
                                </div>

                                <!-- Sous-section Sponsor avec design cohérent -->
                                <div class="sub-section">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center font-heading">
                                        <i class="fas fa-handshake text-orange-600 mr-3"></i>
                                        Informations du sponsor
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Nom sponsor</label>
                                                <input type="text" name="sponsor_nom" value="{{ old('sponsor_nom', $student->sponsor_nom) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Prénom sponsor</label>
                                                <input type="text" name="sponsor_prenom" value="{{ old('sponsor_prenom', $student->sponsor_prenom) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Téléphone sponsor</label>
                                                <input type="text" name="sponsor_telephone" value="{{ old('sponsor_telephone', $student->sponsor_telephone) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-medium mb-2 font-body">Adresse sponsor</label>
                                                <input type="text" name="sponsor_adresse" value="{{ old('sponsor_adresse', $student->sponsor_adresse) }}" class="form-input w-full rounded-lg px-4 py-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action avec styles cohérents -->
                    <div class="flex justify-center mt-12 gap-6 animate-fade-in-up" style="animation-delay: 0.8s;">
                        <a href="{{ route('superadmin.students.show', $student->id) }}" class="btn-secondary px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:scale-105 flex items-center font-heading">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn-primary text-white px-10 py-4 rounded-xl font-semibold text-lg flex items-center transition-all duration-300 hover:scale-105 shadow-lg font-heading">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </main>

    </div>

    <script>
        function previewPhoto(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('photo-preview').src = URL.createObjectURL(file);
            }
        }

        // --- Chargement dynamique des parcours selon la mention sélectionnée (logique register.blade.php) ---
        document.addEventListener('DOMContentLoaded', function() {
            const mentionSelect = document.getElementById('mention_id');
            const parcoursSelect = document.getElementById('parcours_id');
            const currentParcoursId = '{{ old('parcours_id', $student->parcours_id) }}';

            function updateParcoursOptions(mentionId, selectedParcoursId = null) {
                parcoursSelect.innerHTML = '<option value="">Chargement...</option>';
                if (!mentionId) {
                    parcoursSelect.innerHTML = '<option value="">Sélectionnez le parcours</option>';
                    return;
                }
                fetch(`/parcours/by-mention/${mentionId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Sélectionnez le parcours</option>';
                        data.forEach(parc => {
                            const selected = (selectedParcoursId && selectedParcoursId == parc.id) ? 'selected' : '';
                            options += `<option value="${parc.id}" ${selected}>${parc.nom}</option>`;
                        });
                        parcoursSelect.innerHTML = options;
                    })
                    .catch(() => {
                        parcoursSelect.innerHTML = '<option value="">Aucun parcours trouvé</option>';
                    });
            }

            mentionSelect.addEventListener('change', function() {
                updateParcoursOptions(this.value);
            });

            // Initialisation au chargement de la page
            if (mentionSelect.value) {
                updateParcoursOptions(mentionSelect.value, currentParcoursId);
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            // Pour éviter le comportement par défaut et rediriger après la soumission
            this.addEventListener('submit', function(ev) {
                ev.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        window.location.href = "{{ route('superadmin.students.show', $student->id) }}";
                    }
                })
                .catch(() => {
                    window.location.href = "{{ route('superadmin.students.show', $student->id) }}";
                });
            }, { once: true });
        });
    </script>
</body>
</html>
