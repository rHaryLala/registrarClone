<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'étudiant - Université Adventiste Zurcher</title>
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
            <div class="max-w-4xl mx-auto mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                            {{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $student->prenom }} {{ $student->nom }}</h1>
                            <p class="text-gray-600">Matricule: {{ $student->matricule }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('superadmin.students.show', $student->id) }}" class="text-blue-800 hover:text-blue-900 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="max-w-4xl mx-auto bg-white rounded-lg border border-gray-200 p-8">
                <form action="{{ route('superadmin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center mb-6">
                        <label for="image" class="cursor-pointer w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 bg-gray-100 flex items-center justify-center mb-4">
                            <img id="photo-preview" src="{{ $student->image ? asset($student->image) : asset('photo_profil/default.png') }}" alt="Photo de profil" class="object-cover w-full h-full">
                        </label>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                        @error('image')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <span class="text-xs text-gray-500 mt-2">Cliquez sur la photo pour choisir une image</span>
                    </div>
                    <script>
                        function previewPhoto(event) {
                            const [file] = event.target.files;
                            if (file) {
                                document.getElementById('photo-preview').src = URL.createObjectURL(file);
                            }
                        }
                    </script>

                    <!-- Informations personnelles -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                                <input type="text" name="nom" value="{{ old('nom', $student->nom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                @error('nom')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Prénom</label>
                                <input type="text" name="prenom" value="{{ old('prenom', $student->prenom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                @error('prenom')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Sexe</label>
                                <input type="text" name="sexe" value="{{ old('sexe', $student->sexe) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('sexe')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Date de naissance</label>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance', $student->date_naissance ? $student->date_naissance->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('date_naissance')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Lieu de naissance</label>
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $student->lieu_naissance) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('lieu_naissance')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nationalité</label>
                                <input type="text" name="nationalite" value="{{ old('nationalite', $student->nationalite) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('nationalite')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Religion</label>
                                <input type="text" name="religion" value="{{ old('religion', $student->religion) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('religion')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">État civil</label>
                                <input type="text" name="etat_civil" value="{{ old('etat_civil', $student->etat_civil) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                @error('etat_civil')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Coordonnées -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-address-book text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Coordonnées</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Téléphone</label>
                                <input type="text" name="telephone" value="{{ old('telephone', $student->telephone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Adresse</label>
                                <input type="text" name="adresse" value="{{ old('adresse', $student->adresse) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Région</label>
                                <input type="text" name="region" value="{{ old('region', $student->region) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">District</label>
                                <input type="text" name="district" value="{{ old('district', $student->district) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Passeport -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-passport text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Passeport</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="passport_status" value="1" @if(old('passport_status', $student->passport_status)) checked @endif>
                                <label class="block text-gray-700 font-semibold">Statut passeport</label>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Numéro passeport</label>
                                <input type="text" name="passport_numero" value="{{ old('passport_numero', $student->passport_numero) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Pays émission passeport</label>
                                <input type="text" name="passport_pays_emission" value="{{ old('passport_pays_emission', $student->passport_pays_emission) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Date émission passeport</label>
                                <input type="date" name="passport_date_emission" value="{{ old('passport_date_emission', $student->passport_date_emission ? $student->passport_date_emission->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Date expiration passeport</label>
                                <input type="date" name="passport_date_expiration" value="{{ old('passport_date_expiration', $student->passport_date_expiration ? $student->passport_date_expiration->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- CIN -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-id-card text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Carte d'identité</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Numéro CIN</label>
                                <input type="text" name="cin_numero" value="{{ old('cin_numero', $student->cin_numero) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Date délivrance CIN</label>
                                <input type="date" name="cin_date_delivrance" value="{{ old('cin_date_delivrance', $student->cin_date_delivrance ? $student->cin_date_delivrance->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Lieu délivrance CIN</label>
                                <input type="text" name="cin_lieu_delivrance" value="{{ old('cin_lieu_delivrance', $student->cin_lieu_delivrance) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Famille -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Famille</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nom conjoint</label>
                                <input type="text" name="nom_conjoint" value="{{ old('nom_conjoint', $student->nom_conjoint) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nombre d'enfants</label>
                                <input type="number" name="nb_enfant" value="{{ old('nb_enfant', $student->nb_enfant) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Scolarité -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Scolarité</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Série Bac</label>
                                <input type="text" name="bacc_serie" value="{{ old('bacc_serie', $student->bacc_serie) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Date obtention Bac</label>
                                <input type="date" name="bacc_date_obtention" value="{{ old('bacc_date_obtention', $student->bacc_date_obtention ? $student->bacc_date_obtention->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="bursary_status" value="1" @if(old('bursary_status', $student->bursary_status)) checked @endif>
                                <label class="block text-gray-700 font-semibold">Boursier</label>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Année d'étude</label>
                                <select id="annee_etude" name="annee_etude" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez l'année</option>
                                    <option value="L1" @if(old('annee_etude', $student->annee_etude)=="L1") selected @endif>Licence 1</option>
                                    <option value="L2" @if(old('annee_etude', $student->annee_etude)=="L2") selected @endif>Licence 2</option>
                                    <option value="L3" @if(old('annee_etude', $student->annee_etude)=="L3") selected @endif>Licence 3</option>
                                    <option value="M1" @if(old('annee_etude', $student->annee_etude)=="M1") selected @endif>Master 1</option>
                                    <option value="M2" @if(old('annee_etude', $student->annee_etude)=="M2") selected @endif>Master 2</option>
                                </select>
                                @error('annee_etude')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Mention envisagée</label>
                                <select name="mention_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                    <option value="">Sélectionnez la mention</option>
                                    @foreach($mentions as $mention)
                                        <option value="{{ $mention->id }}" @if(old('mention_id', $student->mention_id) == $mention->id) selected @endif>{{ $mention->nom }}</option>
                                    @endforeach
                                </select>
                                @error('mention_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Matricule</label>
                                <input type="text" name="matricule" value="{{ old('matricule', $student->matricule) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Parents -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-home text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Parents</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nom père</label>
                                <input type="text" name="nom_pere" value="{{ old('nom_pere', $student->nom_pere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Profession père</label>
                                <input type="text" name="profession_pere" value="{{ old('profession_pere', $student->profession_pere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Contact père</label>
                                <input type="text" name="contact_pere" value="{{ old('contact_pere', $student->contact_pere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nom mère</label>
                                <input type="text" name="nom_mere" value="{{ old('nom_mere', $student->nom_mere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Profession mère</label>
                                <input type="text" name="profession_mere" value="{{ old('profession_mere', $student->profession_mere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Contact mère</label>
                                <input type="text" name="contact_mere" value="{{ old('contact_mere', $student->contact_mere) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Adresse parents</label>
                                <input type="text" name="adresse_parents" value="{{ old('adresse_parents', $student->adresse_parents) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Sponsor -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-handshake text-white text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Sponsor</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nom sponsor</label>
                                <input type="text" name="sponsor_nom" value="{{ old('sponsor_nom', $student->sponsor_nom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Prénom sponsor</label>
                                <input type="text" name="sponsor_prenom" value="{{ old('sponsor_prenom', $student->sponsor_prenom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Téléphone sponsor</label>
                                <input type="text" name="sponsor_telephone" value="{{ old('sponsor_telephone', $student->sponsor_telephone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Adresse sponsor</label>
                                <input type="text" name="sponsor_adresse" value="{{ old('sponsor_adresse', $student->sponsor_adresse) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 gap-4">
                        <a href="{{ route('superadmin.students.show', $student->id) }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Annuler</a>
                        <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded-lg hover:bg-blue-900 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
