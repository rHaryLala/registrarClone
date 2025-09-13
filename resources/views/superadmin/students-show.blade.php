<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche étudiant - Université Adventiste Zurcher</title>
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
            <!-- Header Section -->
            <div class="max-w-4xl mx-auto mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-blue-800 flex items-center justify-center text-white font-semibold text-lg cursor-pointer relative group">
                            <form id="photo-upload-form" action="{{ route('superadmin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 w-full h-full z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('PUT')
                                <input type="file" id="profile-photo-input" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadProfilePhoto(event)">
                            </form>
                            @if($student->image)
                                <img id="profile-photo" src="{{ asset($student->image) }}" alt="Photo de profil" class="object-cover w-full h-full">
                            @else
                                <span id="profile-initials">{{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}</span>
                            @endif
                            <span class="absolute bottom-0 right-0 bg-white text-blue-800 rounded-full p-1 text-xs opacity-80 group-hover:opacity-100 transition-opacity"><i class="fas fa-camera"></i></span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $student->prenom }} {{ $student->nom }}</h1>
                            <p class="text-gray-600">Matricule: {{ $student->matricule }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('superadmin.students.courses.add', $student->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                            <i class="fas fa-plus"></i>
                            <span>Ajouter un cours</span>
                        </a>
                        <a href="{{ route('superadmin.students.edit', $student->id) }}" 
                           class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition flex items-center space-x-2">
                            <i class="fas fa-edit"></i>
                            <span>Modifier</span>
                        </a>
                        <a href="{{ route('superadmin.students.courses.history', $student->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                            <i class="fas fa-book"></i>
                            <span>Cours</span>
                        </a>
                        <a href="{{ route('superadmin.students.list') }}" 
                           class="text-blue-800 hover:text-blue-900 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Informations personnelles -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sexe</span>
                            <span class="font-medium">{{ $student->sexe }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date de naissance</span>
                            <span class="font-medium">{{ $student->date_naissance }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lieu de naissance</span>
                            <span class="font-medium">{{ $student->lieu_naissance }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nationalité</span>
                            <span class="font-medium">{{ $student->nationalite }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Religion</span>
                            <span class="font-medium">{{ $student->religion }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">État civil</span>
                            <span class="font-medium">{{ $student->etat_civil }}</span>
                        </div>
                    </div>
                </div>

                <!-- Coordonnées -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-address-book text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Coordonnées</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone</span>
                            <span class="font-medium">{{ $student->telephone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium">{{ $student->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Adresse</span>
                            <span class="font-medium">{{ $student->adresse }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Région</span>
                            <span class="font-medium">{{ $student->region }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">District</span>
                            <span class="font-medium">{{ $student->district }}</span>
                        </div>
                    </div>
                </div>

                <!-- Passeport -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-passport text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Passeport</h2>
                        @if($student->passport_status)
                            <span class="ml-auto bg-blue-800 text-white px-2 py-1 rounded text-xs">Actif</span>
                        @endif
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro</span>
                            <span class="font-medium">{{ $student->passport_numero ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pays émission</span>
                            <span class="font-medium">{{ $student->passport_pays_emission ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date émission</span>
                            <span class="font-medium">{{ $student->passport_date_emission ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date expiration</span>
                            <span class="font-medium">{{ $student->passport_date_expiration ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- CIN -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Carte d'identité</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro</span>
                            <span class="font-medium">{{ $student->cin_numero }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date délivrance</span>
                            <span class="font-medium">{{ $student->cin_date_delivrance }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lieu délivrance</span>
                            <span class="font-medium">{{ $student->cin_lieu_delivrance }}</span>
                        </div>
                    </div>
                </div>

                <!-- Famille -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Famille</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nom conjoint</span>
                            <span class="font-medium">{{ $student->nom_conjoint ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre d'enfants</span>
                            <span class="font-medium">{{ $student->nb_enfant ?: '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Scolarité -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Scolarité</h2>
                        @if($student->bursary_status)
                            <span class="ml-auto bg-blue-800 text-white px-2 py-1 rounded text-xs">Boursier</span>
                        @endif
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Série Bac</span>
                            <span class="font-medium">{{ $student->bacc_serie }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date obtention Bac</span>
                            <span class="font-medium">{{ $student->bacc_date_obtention }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Année d'étude</span>
                            <span class="font-medium">{{ $student->annee_etude }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mention envisagée</span>
                            <span class="font-medium">{{ $student->mention->nom ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parents Section (Full Width) -->
            <div class="max-w-4xl mx-auto mt-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Parents</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Père -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">Père</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nom</span>
                                    <span class="font-medium">{{ $student->nom_pere }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Profession</span>
                                    <span class="font-medium">{{ $student->profession_pere }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Contact</span>
                                    <span class="font-medium">{{ $student->contact_pere }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mère -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">Mère</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nom</span>
                                    <span class="font-medium">{{ $student->nom_mere }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Profession</span>
                                    <span class="font-medium">{{ $student->profession_mere }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Contact</span>
                                    <span class="font-medium">{{ $student->contact_mere }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Adresse parents</span>
                            <span class="font-medium">{{ $student->adresse_parents }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsor Section (Full Width) -->
            <div class="max-w-4xl mx-auto mt-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-handshake text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Sponsor</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nom</span>
                            <span class="font-medium">{{ $student->sponsor_nom ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prénom</span>
                            <span class="font-medium">{{ $student->sponsor_prenom ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone</span>
                            <span class="font-medium">{{ $student->sponsor_telephone ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Adresse</span>
                            <span class="font-medium">{{ $student->sponsor_adresse ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
