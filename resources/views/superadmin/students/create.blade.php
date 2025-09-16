<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant - Université Adventiste Zurcher</title>
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
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        .step-container { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 2px solid #e2e8f0; border-radius: 16px; transition: all 0.3s ease; margin-bottom: 1.5rem; }
        .step-container.active { border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }
        .step-header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; border-radius: 12px 12px 0 0; padding: 1rem 1.5rem; }
        .step-number { width: 32px; height: 32px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .form-section { background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem; transition: all 0.3s ease; }
        .form-section:hover { border-color: #1e3a8a; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.1); }
        .section-title { display: flex; align-items: center; gap: 0.75rem; font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem; }
        .section-icon { width: 1.25rem; height: 1.25rem; color: #1e3a8a; }
        .passport-form { max-height: 0; overflow: hidden; transition: max-height 0.5s ease, opacity 0.3s ease; opacity: 0; }
        .passport-form.show { max-height: 600px; opacity: 1; }
        .passport-highlight { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 2px solid #3b82f6; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
    </style>
</head>
<body class="bg-gray-100">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-6 max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Ajouter un étudiant</h1>
            <div class="bg-white shadow rounded-lg p-8">
                <form id="inscription-form" method="POST" action="{{ route('superadmin.students.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col items-center mb-6">
                        <label for="image" class="cursor-pointer w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 bg-gray-100 flex items-center justify-center mb-4">
                            <img id="photo-preview" src="{{ old('image') ? asset(old('image')) : asset('photo_profil/default.png') }}" alt="Photo de profil" class="object-cover w-full h-full">
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
                    <!-- Étape 1: Informations personnelles -->
                    <div id="step-1" class="step-content">
                        <div class="step-container active">
                            <div class="step-header">
                                <div class="flex items-center gap-3">
                                    <div class="step-number">1</div>
                                    <div>
                                        <h3 class="text-lg font-semibold">Informations Personnelles</h3>
                                        <p class="text-sm opacity-90">Renseignez les informations de base</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                                    <input type="text" name="nom" value="{{ old('nom') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required maxlength="255">
                                    @error('nom')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Prénom</label>
                                    <input type="text" name="prenom" value="{{ old('prenom') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required maxlength="255">
                                    @error('prenom')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Sexe</label>
                                    <select name="sexe" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                        <option value="">Sélectionnez</option>
                                        <option value="M" @if(old('sexe')=='M') selected @endif>Masculin</option>
                                        <option value="F" @if(old('sexe')=='F') selected @endif>Féminin</option>
                                        <option value="Autre" @if(old('sexe')=='Autre') selected @endif>Autre</option>
                                    </select>
                                    @error('sexe')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Date de naissance</label>
                                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                    @error('date_naissance')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Lieu de naissance</label>
                                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nationalité</label>
                                    <input type="text" name="nationalite" value="{{ old('nationalite') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Religion</label>
                                    <input type="text" name="religion" value="{{ old('religion') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">État civil</label>
                                    <input type="text" name="etat_civil" value="{{ old('etat_civil') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Statut passeport</label>
                                    <input type="checkbox" name="passport_status" value="1" @if(old('passport_status')) checked @endif>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Numéro passeport</label>
                                    <input type="text" name="passport_numero" value="{{ old('passport_numero') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Pays émission passeport</label>
                                    <input type="text" name="passport_pays_emission" value="{{ old('passport_pays_emission') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Date émission passeport</label>
                                    <input type="date" name="passport_date_emission" value="{{ old('passport_date_emission') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Date expiration passeport</label>
                                    <input type="date" name="passport_date_expiration" value="{{ old('passport_date_expiration') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom conjoint</label>
                                    <input type="text" name="nom_conjoint" value="{{ old('nom_conjoint') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nombre d'enfants</label>
                                    <input type="number" name="nb_enfant" value="{{ old('nb_enfant') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Numéro CIN</label>
                                    <input type="text" name="cin_numero" value="{{ old('cin_numero') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Date délivrance CIN</label>
                                    <input type="date" name="cin_date_delivrance" value="{{ old('cin_date_delivrance') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Lieu délivrance CIN</label>
                                    <input type="text" name="cin_lieu_delivrance" value="{{ old('cin_lieu_delivrance') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom père</label>
                                    <input type="text" name="nom_pere" value="{{ old('nom_pere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Profession père</label>
                                    <input type="text" name="profession_pere" value="{{ old('profession_pere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Contact père</label>
                                    <input type="text" name="contact_pere" value="{{ old('contact_pere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom mère</label>
                                    <input type="text" name="nom_mere" value="{{ old('nom_mere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Profession mère</label>
                                    <input type="text" name="profession_mere" value="{{ old('profession_mere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Contact mère</label>
                                    <input type="text" name="contact_mere" value="{{ old('contact_mere') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Adresse parents</label>
                                    <input type="text" name="adresse_parents" value="{{ old('adresse_parents') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Téléphone</label>
                                    <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                    @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Adresse</label>
                                    <input type="text" name="adresse" value="{{ old('adresse') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Région</label>
                                    <input type="text" name="region" value="{{ old('region') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">District</label>
                                    <input type="text" name="district" value="{{ old('district') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Série Bac</label>
                                    <input type="text" name="bacc_serie" value="{{ old('bacc_serie') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Date obtention Bac</label>
                                    <input type="date" name="bacc_date_obtention" value="{{ old('bacc_date_obtention') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Boursier</label>
                                    <input type="checkbox" name="bursary_status" value="1" @if(old('bursary_status')) checked @endif>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom sponsor</label>
                                    <input type="text" name="sponsor_nom" value="{{ old('sponsor_nom') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Prénom sponsor</label>
                                    <input type="text" name="sponsor_prenom" value="{{ old('sponsor_prenom') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Téléphone sponsor</label>
                                    <input type="text" name="sponsor_telephone" value="{{ old('sponsor_telephone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Adresse sponsor</label>
                                    <input type="text" name="sponsor_adresse" value="{{ old('sponsor_adresse') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Année d'étude</label>
                                    <input type="number" name="annee_etude" value="{{ old('annee_etude') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Mention envisagée</label>
                                    <select name="mention_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                        <option value="">Sélectionnez la mention</option>
                                        @foreach($mentions as $mention)
                                            <option value="{{ $mention->id }}" @if(old('mention_id') == $mention->id) selected @endif>{{ $mention->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('mention_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Matricule</label>
                                    <input type="text" name="matricule" value="{{ old('matricule') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Photo (URL)</label>
                                    <input type="text" name="image" value="{{ old('image') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="https://...">
                                    @error('image')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8">
                        <a href="{{ route('superadmin.students.list') }}" class="mr-4 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Annuler</a>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
