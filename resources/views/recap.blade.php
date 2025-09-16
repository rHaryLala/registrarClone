<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <style>
        .section-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .section-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: #1e3a8a;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
        
        .info-item {
            margin-bottom: 0.75rem;
        }
        
        .info-label {
            font-weight: 500;
            color: #4b5563;
            font-size: 0.875rem;
        }
        
        .info-value {
            font-weight: 600;
            color: #1f2937;
            margin-top: 0.25rem;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body class="bg-gray-50 font-montserrat">

<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo + Texte -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center overflow-hidden">
                    <img src="https://yt3.googleusercontent.com/ytc/AGIKgqMrYnDBtikTA3sE31ur77qAnb56zLrCpKXqfFCB=s900-c-k-c0x00ffffff-no-rj"
                         alt="Logo UAZ"
                         class="w-full h-full object-cover rounded-lg">
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Université Adventiste Zurcher</h1>
                    <p class="text-sm text-gray-600">Récapitulatif de l'inscription</p>
                </div>
            </div>
            <!-- Bouton Retour à l'accueil -->
            <div>
                <a href="/"
                    class="px-4 py-2 bg-[#1e3a8a] text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Félicitations !</h2>
                <p class="text-gray-600">Votre inscription a été enregistrée avec succès.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Numéro de matricule</p>
                <p class="text-xl font-bold text-[#1e3a8a]">{{ $student->matricule }}</p>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Inscription validée</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Votre inscription a été enregistrée avec succès.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations personnelles -->
        <div class="section-card">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informations Personnelles
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Nom complet</p>
                    <p class="info-value">{{ $student->prenom }} {{ $student->nom }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Sexe</p>
                    <p class="info-value">{{ $student->sexe == 'M' ? 'Masculin' : 'Féminin' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date de naissance</p>
                    <p class="info-value">{{ \Carbon\Carbon::parse($student->date_naissance)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($student->date_naissance)->age }} ans)</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Lieu de naissance</p>
                    <p class="info-value">{{ $student->lieu_naissance }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Nationalité</p>
                    <p class="info-value">{{ $student->nationalite }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Religion</p>
                    <p class="info-value">{{ $student->religion ?? 'Non spécifié' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">État civil</p>
                    <p class="info-value">{{ ucfirst($student->etat_civil) }}</p>
                </div>
                @if($student->etat_civil === 'marié')
                <div class="info-item">
                    <p class="info-label">Nom du conjoint</p>
                    <p class="info-value">{{ $student->nom_conjoint }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Nombre d'enfants</p>
                    <p class="info-value">{{ $student->nb_enfant }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="section-card">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Coordonnées
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Email</p>
                    <p class="info-value">{{ $student->email }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Téléphone</p>
                    <p class="info-value">{{ $student->telephone ?? 'Non spécifié' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Adresse</p>
                    <p class="info-value">{{ $student->adresse }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Région</p>
                    <p class="info-value">{{ $student->region }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">District</p>
                    <p class="info-value">{{ $student->district }}</p>
                </div>
            </div>
        </div>

        <!-- Informations des parents -->
        <div class="section-card">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Informations des Parents
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Nom du père</p>
                    <p class="info-value">{{ $student->nom_pere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Profession du père</p>
                    <p class="info-value">{{ $student->profession_pere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Contact du père</p>
                    <p class="info-value">{{ $student->contact_pere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Nom de la mère</p>
                    <p class="info-value">{{ $student->nom_mere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Profession de la mère</p>
                    <p class="info-value">{{ $student->profession_mere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Contact de la mère</p>
                    <p class="info-value">{{ $student->contact_mere }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Adresse des parents</p>
                    <p class="info-value">{{ $student->adresse_parents }}</p>
                </div>
            </div>
        </div>

        <!-- Informations académiques -->
        <div class="section-card">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                Informations Académiques & Administratives
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Matricule</p>
                    <p class="info-value">{{ $student->matricule }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Niveau d'étude</p>
                    <p class="info-value">
                        @if($student->yearLevel)
                            {{ $student->yearLevel->label }} ({{ $student->yearLevel->code }})
                        @elseif($student->annee_etude)
                            @switch($student->annee_etude)
                                @case('L1') Licence 1 (L1) @break
                                @case('L2') Licence 2 (L2) @break
                                @case('L3') Licence 3 (L3) @break
                                @case('M1') Master 1 (M1) @break
                                @case('M2') Master 2 (M2) @break
                                @default {{ $student->annee_etude }}
                            @endswitch
                        @else
                            Non spécifié
                        @endif
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Mention</p>
                    <p class="info-value">{{ $student->mention ? $student->mention->nom : 'Non spécifié' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Année académique</p>
                    <p class="info-value">
                        {{ $student->semester && $student->semester->academicYear ? $student->semester->academicYear->libelle : ($student->academic_year_id ?? 'Non spécifié') }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Semestre</p>
                    <p class="info-value">
                        {{ $student->semester ? $student->semester->nom : 'Non spécifié' }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date début semestre</p>
                    <p class="info-value">
                        {{ $student->semester && $student->semester->date_debut ? \Carbon\Carbon::parse($student->semester->date_debut)->format('d/m/Y') : 'Non spécifié' }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date fin semestre</p>
                    <p class="info-value">
                        {{ $student->semester && $student->semester->date_fin ? \Carbon\Carbon::parse($student->semester->date_fin)->format('d/m/Y') : 'Non spécifié' }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Statut étudiant</p>
                    <p class="info-value">{{ ucfirst($student->statut_interne) }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Parcours</p>
                    <p class="info-value">{{ $student->parcours ? $student->parcours->nom : 'Non spécifié' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Image de profil</p>
                    <p class="info-value">
                        @if($student->image)
                            <img src="{{ asset($student->image) }}" alt="Photo de profil" style="max-width:100px;max-height:100px;">
                        @else
                            Non spécifié
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="section-card">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Informations Complémentaires
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Passeport</p>
                    <p class="info-value">
                        @if($student->passport_status)
                            <span class="badge badge-success">Oui</span>
                        @else
                            <span class="badge badge-warning">Non</span>
                        @endif
                    </p>
                </div>
                @if($student->passport_status)
                <div class="info-item">
                    <p class="info-label">Numéro de passeport</p>
                    <p class="info-value">{{ $student->passport_numero }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Pays d'émission</p>
                    <p class="info-value">{{ $student->passport_pays_emission }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date d'émission</p>
                    <p class="info-value">{{ \Carbon\Carbon::parse($student->passport_date_emission)->format('d/m/Y') }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date d'expiration</p>
                    <p class="info-value">{{ \Carbon\Carbon::parse($student->passport_date_expiration)->format('d/m/Y') }}</p>
                </div>
                @endif
                
                <div class="info-item">
                    <p class="info-label">Carte d'Identité Nationale</p>
                    <p class="info-value">
                        @if($student->cin_numero)
                            <span class="badge badge-success">Enregistrée</span>
                        @else
                            <span class="badge badge-warning">Non enregistrée</span>
                        @endif
                    </p>
                </div>
                @if($student->cin_numero)
                <div class="info-item">
                    <p class="info-label">Numéro CIN</p>
                    <p class="info-value">{{ $student->cin_numero }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Date de délivrance</p>
                    <p class="info-value">{{ \Carbon\Carbon::parse($student->cin_date_delivrance)->format('d/m/Y') }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Lieu de délivrance</p>
                    <p class="info-value">{{ $student->cin_lieu_delivrance }}</p>
                </div>
                @endif
                
                <div class="info-item">
                    <p class="info-label">Boursier/Sponsorisé</p>
                    <p class="info-value">
                        @if($student->bursary_status)
                            <span class="badge badge-success">Oui</span>
                        @else
                            <span class="badge badge-warning">Non</span>
                        @endif
                    </p>
                </div>
                @if($student->bursary_status)
                <div class="info-item">
                    <p class="info-label">Nom du sponsor</p>
                    <p class="info-value">{{ $student->sponsor_nom }} {{ $student->sponsor_prenom }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Téléphone du sponsor</p>
                    <p class="info-value">{{ $student->sponsor_telephone }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Adresse du sponsor</p>
                    <p class="info-value">{{ $student->sponsor_adresse }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-center gap-4">
        <a href="{{ route('register') }}" class="px-6 py-3 bg-[#1e3a8a] text-white rounded-lg shadow hover:bg-blue-700 transition">
            Nouvelle inscription
        </a>
        <button onclick="window.print()" class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
            Imprimer ce récapitulatif
        </button>
    </div>
</main>

<footer class="bg-gray-100 border-t border-gray-200 mt-12 py-6">
    <div class="max-w-6xl mx-auto px-4 text-center text-gray-600 text-sm">
        <p>© {{ date('Y') }} Université Adventiste Zurcher. Tous droits réservés.</p>
        <p class="mt-2">
            Votre inscription a été enregistrée le {{ $student->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>
</footer>

</body>
</html>