<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <style>
        /* Adding harmonized step styling */
        .step-container {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .step-container.active {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        
        .step-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.5rem;
        }
        
        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .form-section {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            border-color: #1e3a8a;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.1);
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        
        .section-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: #1e3a8a;
        }
        
        /* Passport form styling */
        .passport-form {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.3s ease;
            opacity: 0;
        }
        
        .passport-form.show {
            max-height: 600px;
            opacity: 1;
        }
        
        .passport-highlight {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        /* Enhanced toast notification styles with better animations and positioning */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
        }
        
        .toast {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-left: 4px solid #ef4444;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            opacity: 0;
            max-width: 100%;
            word-wrap: break-word;
        }
        
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .toast.success {
            border-left-color: #10b981;
        }
        
        .toast.error {
            border-left-color: #ef4444;
        }
        
        .toast.warning {
            border-left-color: #f59e0b;
        }
        
        .toast-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .toast-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .toast-icon {
            width: 1rem;
            height: 1rem;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 1.25rem;
            line-height: 1;
            padding: 0;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .toast-close:hover {
            color: #374151;
            background: #f3f4f6;
        }
        
        .toast-message {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        /* Responsive toast styles for mobile */
        @media (max-width: 640px) {
            .toast-container {
                left: 10px;
                right: 10px;
                top: 10px;
                max-width: none;
            }
            
            .toast {
                transform: translateY(-100%);
            }
            
            .toast.show {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-montserrat min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4">
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
                        <p class="text-sm text-gray-600">Formulaire d'inscription</p>
                    </div>
                </div>
                <!-- Bouton Retour à l'accueil -->
                <div>
                    <a href="/"
                        class="px-4 py-2 bg-[#1e3a8a] text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Progress Bar -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700" id="step-title">Informations personnelles</span>
                <span class="text-sm text-gray-500" id="step-counter">Étape 1 sur 5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-[#1e3a8a] h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 20%"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Enhanced toast container with better structure -->
        <div id="toast-container" class="toast-container"></div>

        <!-- Form -->
        <form id="inscription-form" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" method="POST" action="{{ route('register.store') }}">
            @csrf
            <!-- Étape 1: Informations personnelles -->
            <div id="step-1" class="step-content">
                <!-- Adding harmonized step container with header -->
                <div class="step-container active">
                    <div class="step-header">
                        <div class="flex items-center gap-3">
                            <div class="step-number">1</div>
                            <div>
                                <h3 class="text-lg font-semibold">Informations Personnelles</h3>
                                <p class="text-sm opacity-90">Renseignez vos informations de base</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Code d'accès *</label>
                            <input type="text" id="access_code" name="access_code" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                    placeholder="Insérer votre code d'accès">
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom *</label>
                                <input type="text" id="nom" name="nom" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Nom de famille">
                            </div>
                            <div class="space-y-2">
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" id="prenom" name="prenom"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Prénom">
                            </div>

                            <div class="space-y-2">
                                <label for="taille" class="block text-sm font-medium text-gray-700">Taille</label>
                                <select id="taille" name="taille"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez la taille</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="XXXL">XXXL</option>
                                </select>
                            </div>

                            <!-- Email généré automatiquement -->
                            {{-- <div id="email-preview" class="md:col-span-2 space-y-2 hidden">
                                <label class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Email généré automatiquement
                                </label>
                                <div class="p-3 border rounded-md bg-gray-50 text-sm" id="generated-email"></div>
                                <p class="text-xs text-gray-500">Format: nom.3premièresLettresPrenom@zurcher.edu.mg</p>
                            </div> --}}

                            <div class="space-y-2">
                                <label for="sexe" class="block text-sm font-medium text-gray-700">Sexe *</label>
                                <select id="sexe" name="sexe" required
                                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez le sexe</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance *</label>
                                <input type="date" id="date_naissance" name="date_naissance" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                <p id="age-display" class="text-sm text-gray-600 hidden"></p>
                            </div>

                            <div class="space-y-2">
                                <label for="lieu_naissance" class="block text-sm font-medium text-gray-700">Lieu de naissance *</label>
                                <input type="text" id="lieu_naissance" name="lieu_naissance" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Lieu de naissance">
                            </div>

                            <div class="space-y-2">
                                <label for="nationalite" class="block text-sm font-medium text-gray-700">Nationalité *</label>
                                <input type="text" id="nationalite" name="nationalite" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Nationalité" value="Malagasy">
                            </div>

                            <div class="space-y-2">
                                <label for="religion_select" class="block text-sm font-medium text-gray-700">Religion</label>
                                <select id="religion_select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez la religion</option>
                                    <option value="Adventiste du 7ème jour">Adventiste</option>
                                    <option value="Catholique">Catholique</option>
                                    <option value="Anglicane">Anglicane</option>
                                    <option value="Luthérienne">Luthérienne</option>
                                    <option value="Evangélique">Evangélique</option>
                                    <option value="Pentecôtiste">Pentecôtiste</option>
                                    <option value="Protestante">Protestante</option>
                                    <option value="Musulmane">Musulmane</option>
                                    <option value="Témoin de Jéhovah">Témoin de Jéhovah</option>
                                    <option value="Baptiste">Baptiste</option>
                                    <option value="Bouddhiste">Bouddhiste</option>
                                    <option value="Autre">Autre</option>
                                </select>

                                <!-- Visible only when 'Autre' is selected -->
                                <input type="text" id="religion_autre" name="religion_autre" placeholder="Précisez la religion"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent hidden mt-2">

                                <!-- Hidden final field sent to backend; keeps compatibility with existing server expecting 'religion' -->
                                <input type="hidden" id="religion" name="religion" value="Adventiste du 7ème jour">
                            </div>

                            <div class="space-y-2">
                                <label for="etat_civil" class="block text-sm font-medium text-gray-700">État civil *</label>
                                <select id="etat_civil" name="etat_civil" required
                                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez l'état civil</option>
                                    <option value="célibataire">Célibataire</option>
                                    <option value="marié">Marié(e)</option>
                                    <option value="divorcé">Divorcé(e)</option>
                                    <option value="veuf">Veuf/Veuve</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="statut_interne" class="block text-sm font-medium text-gray-700">Statut étudiant *</label>
                                <select id="statut_interne" name="statut_interne" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                    <option value="">Sélectionnez le statut</option>
                                    <option value="interne">Interne (résidant au dortoir)</option>
                                    <option value="externe">Externe (résidant hors du campus)</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-3 mt-6">
                                <input type="checkbox" id="abonne_caf" name="abonne_caf"
                                        class="rounded border-gray-300 text-[#1e3a8a] focus:ring-[#1e3a8a] w-5 h-5">
                                <label for="abonne_caf" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    Je veux être abonné(e) à la cafétéria
                                </label>
                            </div>

                            <!-- Adding passport checkbox and form in first step -->
                            <div class="md:col-span-2 mt-6">
                                <div class="form-section">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <input type="checkbox" id="passport_status" name="passport_status"
                                                class="rounded border-gray-300 text-[#1e3a8a] focus:ring-[#1e3a8a] w-5 h-5">
                                        <label for="passport_status" class="text-sm font-medium text-gray-700 cursor-pointer">
                                            J'ai un passeport
                                        </label>
                                    </div>
                                    
                                    <div id="passport-section" class="passport-form">
                                        <div class="passport-highlight">
                                            <h4 class="section-title">
                                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Informations du Passeport
                                            </h4>
                                            <p class="text-sm text-blue-600 mb-4">Veuillez renseigner les informations de votre passeport</p>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label for="passport_numero" class="block text-sm font-medium text-gray-700">Numéro de passeport *</label>
                                                <input type="text" id="passport_numero" name="passport_numero"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                                       placeholder="Ex: AB1234567">
                                            </div>
                                            <div class="space-y-2">
                                                <label for="passport_pays_emission" class="block text-sm font-medium text-gray-700">Pays d'émission *</label>
                                                <select id="passport_pays_emission" name="passport_pays_emission"
                                                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                                    <option value="">Sélectionner un pays</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="France">France</option>
                                                    <option value="États-Unis">États-Unis</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Royaume-Uni">Royaume-Uni</option>
                                                    <option value="Allemagne">Allemagne</option>
                                                    <option value="Italie">Italie</option>
                                                    <option value="Espagne">Espagne</option>
                                                    <!-- African countries -->
                                                    <option value="Afrique du Sud">Afrique du Sud</option>
                                                    <option value="Algérie">Algérie</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Bénin">Bénin</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cameroun">Cameroun</option>
                                                    <option value="Cap-Vert">Cap-Vert</option>
                                                    <option value="République centrafricaine">République centrafricaine</option>
                                                    <option value="Tchad">Tchad</option>
                                                    <option value="Comores">Comores</option>
                                                    <option value="Congo - Brazzaville">Congo - Brazzaville</option>
                                                    <option value="République démocratique du Congo">République démocratique du Congo</option>
                                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Égypte">Égypte</option>
                                                    <option value="Guinée équatoriale">Guinée équatoriale</option>
                                                    <option value="Érythrée">Érythrée</option>
                                                    <option value="Éthiopie">Éthiopie</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambie">Gambie</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Guinée">Guinée</option>
                                                    <option value="Guinée-Bissau">Guinée-Bissau</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Libéria">Libéria</option>
                                                    <option value="Libye">Libye</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Mauritanie">Mauritanie</option>
                                                    <option value="Maurice">Maurice</option>
                                                    <option value="Maroc">Maroc</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Namibie">Namibie</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Sao Tomé-et-Principe">Sao Tomé-et-Principe</option>
                                                    <option value="Sénégal">Sénégal</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Somalie">Somalie</option>
                                                    <option value="Soudan">Soudan</option>
                                                    <option value="Soudan du Sud">Soudan du Sud</option>
                                                    <option value="Eswatini">Eswatini</option>
                                                    <option value="Tanzanie">Tanzanie</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tunisie">Tunisie</option>
                                                    <option value="Ouganda">Ouganda</option>
                                                    <option value="Zambie">Zambie</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                    <!-- Nordic countries -->
                                                    <option value="Danemark">Danemark</option>
                                                    <option value="Suède">Suède</option>
                                                    <option value="Norvège">Norvège</option>
                                                    <option value="Finlande">Finlande</option>
                                                    <option value="Islande">Islande</option>
                                                </select>
                                            </div>
                                            <div class="space-y-2">
                                                <label for="passport_date_emission" class="block text-sm font-medium text-gray-700">Date d'émission *</label>
                                                <input type="date" id="passport_date_emission" name="passport_date_emission"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                            </div>
                                            <div class="space-y-2">
                                                <label for="passport_date_expiration" class="block text-sm font-medium text-gray-700">Date d'expiration *</label>
                                                <input type="date" id="passport_date_expiration" name="passport_date_expiration"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section conjoint (conditionnelle) -->
                            <div id="conjoint-section" class="md:col-span-2 space-y-4 hidden border-t pt-4">
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Informations du conjoint
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label for="nom_conjoint" class="block text-sm font-medium text-gray-700">Nom du/de la conjoint(e) *</label>
                                            <input type="text" id="nom_conjoint" name="nom_conjoint"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                                   placeholder="Nom complet du conjoint">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="nb_enfant" class="block text-sm font-medium text-gray-700">Nombre d'enfants</label>
                                            <input type="number" id="nb_enfant" name="nb_enfant" min="0" value="0"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section CIN (conditionnelle pour majeurs) -->
                            <div id="cin-section" class="md:col-span-2 space-y-4 hidden border-t pt-4">
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        Informations CIN (Carte d'Identité Nationale)
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="space-y-2">
                                            <label for="cin_numero" class="block text-sm font-medium text-gray-700">Numéro CIN *</label>
                                            <input type="text" id="cin_numero" name="cin_numero"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                                   placeholder="Numéro de CIN">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="cin_date_delivrance" class="block text-sm font-medium text-gray-700">Date de délivrance *</label>
                                            <input type="date" id="cin_date_delivrance" name="cin_date_delivrance"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="cin_lieu_delivrance" class="block text-sm font-medium text-gray-700">Lieu de délivrance *</label>
                                            <input type="text" id="cin_lieu_delivrance" name="cin_lieu_delivrance"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                                   placeholder="Lieu de délivrance">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 2: Informations des parents -->
            <div id="step-2" class="step-content hidden">
                <!-- Adding harmonized step container with header for step 2 -->
                <div class="step-container">
                    <div class="step-header">
                        <div class="flex items-center gap-3">
                            <div class="step-number">2</div>
                            <div>
                                <h3 class="text-lg font-semibold">Informations des Parents</h3>
                                <p class="text-sm opacity-90">Renseignez les informations de vos parents</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Informations du père -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="nom_pere" class="block text-sm font-medium text-gray-700">Nom du père *</label>
                                    <input type="text" id="nom_pere" name="nom_pere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="Nom complet du père">
                                </div>
                                <div class="space-y-2">
                                    <label for="profession_pere" class="block text-sm font-medium text-gray-700">Profession du père *</label>
                                    <input type="text" id="profession_pere" name="profession_pere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="Profession du père">
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label for="contact_pere" class="block text-sm font-medium text-gray-700">Contact du père *</label>
                                    <input type="tel" id="contact_pere" name="contact_pere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="032 12 345 67">
                                </div>
                            </div>
                        </div>

                        <!-- Informations de la mère -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="nom_mere" class="block text-sm font-medium text-gray-700">Nom de la mère *</label>
                                    <input type="text" id="nom_mere" name="nom_mere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="Nom complet de la mère">
                                </div>
                                <div class="space-y-2">
                                    <label for="profession_mere" class="block text-sm font-medium text-gray-700">Profession de la mère *</label>
                                    <input type="text" id="profession_mere" name="profession_mere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="Profession de la mère">
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label for="contact_mere" class="block text-sm font-medium text-gray-700">Contact de la mère *</label>
                                    <input type="tel" id="contact_mere" name="contact_mere" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="032 12 345 67">
                                </div>
                            </div>
                        </div>

                        <!-- Adresse des parents -->
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Adresse des parents
                            </h4>
                            <div class="space-y-2">
                                <label for="adresse_parents" class="block text-sm font-medium text-gray-700">Adresse complète des parents *</label>
                                <textarea id="adresse_parents" name="adresse_parents" required rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                        placeholder="Adresse complète des parents (village, commune, district, région)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 3: Coordonnées -->
            <div id="step-3" class="step-content hidden">
                <!-- Adding harmonized step container with header for step 3 -->
                <div class="step-container">
                    <div class="step-header">
                        <div class="flex items-center gap-3">
                            <div class="step-number">3</div>
                            <div>
                                <h3 class="text-lg font-semibold">Coordonnées</h3>
                                <p class="text-sm opacity-90">Renseignez vos informations de contact</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Informations de contact
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                    <input type="tel" id="telephone" name="telephone"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="032 12 345 67">
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" id="email" name="email" required readonly
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600"
                                           placeholder="Généré automatiquement">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Adresse
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2 md:col-span-2">
                                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse *</label>
                                    <input type="text" id="adresse" name="adresse" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="Adresse complète">
                                </div>

                                <div class="space-y-2">
                                    <label for="region" class="block text-sm font-medium text-gray-700">Région *</label>
                                    <select id="region" name="region" required
                                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        <option value="">Sélectionnez une région</option>
                                        <option value="Analamanga">Analamanga</option>
                                        <option value="Bongolava">Bongolava</option>
                                        <option value="Itasy">Itasy</option>
                                        <option value="Vakinankaratra">Vakinankaratra</option>
                                        <option value="Diana">Diana</option>
                                        <option value="Sava">Sava</option>
                                        <option value="Amoron'i Mania">Amoron'i Mania</option>
                                        <option value="Atsimo-Atsinanana">Atsimo-Atsinanana</option>
                                        <option value="Fitovinany">Fitovinany</option>
                                        <option value="Haute Matsiatra">Haute Matsiatra</option>
                                        <option value="Ihorombe">Ihorombe</option>
                                        <option value="Vatovavy">Vatovavy</option>
                                        <option value="Betsiboka">Betsiboka</option>
                                        <option value="Boeny">Boeny</option>
                                        <option value="Melaky">Melaky</option>
                                        <option value="Sofia">Sofia</option>
                                        <option value="Alaotra-Mangoro">Alaotra-Mangoro</option>
                                        <option value="Ambatosoa">Ambatosoa</option>
                                        <option value="Analanjirofoa">Analanjirofo</option>
                                        <option value="Atsinanana">Atsinanana</option>
                                        <option value="Androy">Androy</option>
                                        <option value="Anosy">Anosy</option>
                                        <option value="Atsimo-Andrefana">Atsimo-Andrefana</option>
                                        <option value="Menabe">Menabe</option>

                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="district" class="block text-sm font-medium text-gray-700">District *</label>
                                    <input type="text" id="district" name="district" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                           placeholder="District">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 4: Scolarité -->
            <div id="step-4" class="step-content hidden">
                <!-- Adding harmonized step container with header for step 4 -->
                <div class="step-container">
                    <div class="step-header">
                        <div class="flex items-center gap-3">
                            <div class="step-number">4</div>
                            <div>
                                <h3 class="text-lg font-semibold">Scolarité</h3>
                                <p class="text-sm opacity-90">Informations sur votre parcours scolaire</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                Informations du Baccalauréat
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="bacc_serie" class="block text-sm font-medium text-gray-700">Série du Baccalauréat</label>
                                    <select id="bacc_serie" name="bacc_serie"
                                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        <option value="">Sélectionnez la série</option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="D">D</option>
                                        <option value="C">C</option>
                                        <option value="S">S</option>
                                        <option value="L">L</option>
                                        <option value="OSE">OSE</option>
                                        <option value="Technique">Technique</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="bacc_date_obtention" class="block text-sm font-medium text-gray-700">Année d'obtention du Bac</label>
                                    <input type="number" id="bacc_date_obtention" name="bacc_date_obtention"
                                        min="2010" max="{{ date('Y')+1 }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                        placeholder="Ex: 2025">
                                </div>

                                <div class="flex items-center space-x-2 md:col-span-2">
                                    <input type="checkbox" id="bursary_status" name="bursary_status"
                                            class="rounded border-gray-300 text-[#1e3a8a] focus:ring-[#1e3a8a]">
                                    <label for="bursary_status" class="text-sm font-medium text-gray-700">Boursier/Sponsorisé</label>
                                </div>
                            </div>
                        </div>

                        <!-- Section sponsor (conditionnelle) -->
                        <div id="sponsor-section" class="form-section hidden">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informations du Sponsor
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="sponsor_nom" class="block text-sm font-medium text-gray-700">Nom du sponsor / Organisation *</label>
                                    <input type="text" id="sponsor_nom" name="sponsor_nom"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Nom du sponsor">
                                </div>

                                <div class="space-y-2">
                                    <label for="sponsor_prenom" class="block text-sm font-medium text-gray-700">Prénom du sponsor</label>
                                    <input type="text" id="sponsor_prenom" name="sponsor_prenom"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Prénom du sponsor">
                                </div>

                                <div class="space-y-2">
                                    <label for="sponsor_telephone" class="block text-sm font-medium text-gray-700">Téléphone du sponsor *</label>
                                    <input type="tel" id="sponsor_telephone" name="sponsor_telephone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="032 12 345 67">
                                </div>

                                <div class="space-y-2">
                                    <label for="sponsor_adresse" class="block text-sm font-medium text-gray-700">Adresse du sponsor *</label>
                                    <input type="text" id="sponsor_adresse" name="sponsor_adresse"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent"
                                       placeholder="Adresse complète du sponsor">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 5: Informations académiques -->
            <div id="step-5" class="step-content hidden">
                <!-- Adding harmonized step container with header for step 5 -->
                <div class="step-container">
                    <div class="step-header">
                        <div class="flex items-center gap-3">
                            <div class="step-number">5</div>
                            <div>
                                <h3 class="text-lg font-semibold">Informations Académiques</h3>
                                <p class="text-sm opacity-90">Finalisation de votre inscription</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="form-section">
                            <h4 class="section-title">
                                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Choix académique
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="year_level_id" class="block text-sm font-medium text-gray-700">Niveau d'étude *</label>
                                    <select id="year_level_id" name="year_level_id" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        <option value="">Sélectionnez l'année</option>
                                        @foreach($yearLevels as $level)
                                            <option value="{{ $level->id }}">{{ $level->label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label for="mention_id" class="block text-sm font-medium text-gray-700">Mention *</label>
                                    <select id="mention_id" name="mention_id" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        <option value="">Sélectionnez la mention</option>
                                        @foreach($mentions as $mention)
                                            <option value="{{ $mention->id }}">{{ $mention->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label for="parcours_id" class="block text-sm font-medium text-gray-700">Parcours</label>
                                    <select id="parcours_id" name="parcours_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent">
                                        <option value="">Sélectionnez le parcours</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-8">
                <button type="button" id="prev-btn"
                         class="hidden px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Précédent
                </button>

                <div class="flex gap-3 ml-auto">
                    <button type="button" id="next-btn"
                             class="px-6 py-2 text-sm font-medium text-white bg-[#1e3a8a] rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                        Suivant
                        <svg class="h-4 w-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <button type="submit" id="submit-btn"
                             class="hidden px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <span id="submit-text">Enregistrer</span>
                        <svg id="submit-spinner" class="hidden animate-spin h-4 w-4 ml-2 inline" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </main>

</body>

<script>
    // Variables globales
    let currentStep = 1;
    const totalSteps = 5;
    let age = 0;
    let isAccessCodeValid = false; // Variable pour suivre la validité du code d'accès

    // Éléments DOM
    const form = document.getElementById('inscription-form');
    const stepTitle = document.getElementById('step-title');
    const stepCounter = document.getElementById('step-counter');
    const progressBar = document.getElementById('progress-bar');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const errorContainer = document.getElementById('error-container'); // Ce conteneur est maintenant obsolète
    const errorList = document.getElementById('error-list'); // Ce conteneur est maintenant obsolète

    // Titres des étapes - Mis à jour avec la nouvelle étape
    const stepTitles = [
        'Informations personnelles',
        'Informations des parents',
        'Coordonnées',
        'Scolarité',
        'Informations académiques'
    ];

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        updateStepDisplay();
        setupEventListeners();
        // Initialiser les sections conditionnelles
        toggleConjointSection();
        toggleSponsorSection();
        togglePassportSection();
        calculateAge(); // Calculer l'âge initialement pour afficher/masquer la section CIN
    });

    // --- Fonctions de gestion des toasts ---
    function showToast(message, type = 'error', duration = 5000) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const toastId = 'toast-' + Date.now();
        toast.id = toastId;
        
        // Définir les icônes pour différents types de toasts
        const icons = {
            error: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            success: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            warning: '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'
        };
        
        const titles = {
            error: 'Erreur',
            success: 'Succès',
            warning: 'Attention'
        };
        
        toast.innerHTML = `
            <div class="toast-header">
                <span class="toast-title">
                    ${icons[type] || icons.error}
                    ${titles[type] || titles.error}
                </span>
                <button class="toast-close" onclick="closeToast('${toastId}')" aria-label="Fermer">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                        <path d="M6.94 6l3.53-3.53a.67.67 0 10-.94-.94L6 4.06 2.47.53a.67.67 0 10-.94.94L4.06 6 .53 9.53a.67.67 0 10.94.94L6 7.94l3.53 3.53a.67.67 0 10.94-.94L6.94 6z"/>
                    </svg>
                </button>
            </div>
            <div class="toast-message">${message}</div>
        `;
        
        container.appendChild(toast);
        
        // Déclencher l'animation avec un léger délai pour un meilleur effet
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Suppression automatique avec fondu
        setTimeout(() => {
            closeToast(toastId);
        }, duration);
        
        // Ajouter la fonctionnalité de fermeture au clic
        toast.addEventListener('click', () => {
            closeToast(toastId);
        });
    }
    
    function closeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 400);
        }
    }
    
    // Affichage des erreurs avec animations décalées et meilleurs messages
    function showErrors(errors) {
        if (errors.length === 1) {
            showToast(errors[0], 'error');
        } else {
            // Afficher un toast récapitulatif pour plusieurs erreurs
            showToast(`${errors.length} erreurs détectées dans le formulaire`, 'error', 3000);
            
            // Puis afficher les erreurs individuelles avec décalage
            errors.forEach((error, index) => {
                setTimeout(() => {
                    showToast(error, 'error', 4000);
                }, (index + 1) * 300);
            });
        }
    }
    
    function showSuccess(message) {
        showToast(message, 'success', 4000);
    }
    
    function showWarning(message) {
        showToast(message, 'warning', 4000);
    }

    // --- Fonctions de validation ---
    function validateStep(step) {
        const errors = [];
        
        switch(step) {
            case 1:
                // Validation du code d'accès
                if (!getValue('access_code')) {
                    errors.push('Le code d\'accès est obligatoire pour continuer');
                } else if (!isAccessCodeValid) {
                    errors.push('Veuillez entrer un code d\'accès valide avant de continuer');
                }
                
                // Validation des champs personnels
                if (!getValue('nom')) {
                    errors.push('Votre nom de famille est requis');
                }
                if (!getValue('sexe')) {
                    errors.push('Veuillez sélectionner votre sexe');
                }
                if (!getValue('date_naissance')) {
                    errors.push('Veuillez indiquer votre date de naissance');
                }
                if (!getValue('lieu_naissance')) {
                    errors.push('Le lieu de naissance doit être renseigné');
                }
                if (!getValue('nationalite')) {
                    errors.push('Votre nationalité est requise');
                }
                if (!getValue('etat_civil')) {
                    errors.push('L\'état civil doit être précisé');
                }
                if (!getValue('statut_interne')) {
                    errors.push('Veuillez choisir votre statut étudiant (interne/externe)');
                }
                
                // Validation conditionnelle pour les champs CIN (majeurs)
                const dateNaissance = getValue('date_naissance');
                if (dateNaissance) {
                    const calculatedAge = calculateAge(dateNaissance);
                    if (calculatedAge >= 18) {
                        if (!getValue('cin_numero')) {
                            errors.push('Le numéro de CIN est requis pour les étudiants majeurs');
                        }
                        if (!getValue('cin_date_delivrance')) {
                            errors.push('La date de délivrance du CIN est requise');
                        }
                        if (!getValue('cin_lieu_delivrance')) {
                            errors.push('Le lieu de délivrance du CIN est requis');
                        }
                    }
                }
                
                // Validation conditionnelle pour conjoint
                if (getValue('etat_civil') === 'marié' && !getValue('nom_conjoint')) {
                    errors.push('Le nom du conjoint est requis pour les personnes mariées');
                }
                break;
                
            case 2: // Informations des parents
                if (!getValue('nom_pere')) errors.push('Le nom du père est requis');
                if (!getValue('profession_pere')) errors.push('La profession du père est requise');
                if (!getValue('contact_pere')) errors.push('Le contact du père est requis');
                if (!getValue('nom_mere')) errors.push('Le nom de la mère est requis');
                if (!getValue('profession_mere')) errors.push('La profession de la mère est requise');
                if (!getValue('contact_mere')) errors.push('Le contact de la mère est requis');
                if (!getValue('adresse_parents')) errors.push('L\'adresse des parents est requise');
                break;
                
            case 3: // Coordonnées
                if (!getValue('email')) {
                    errors.push('Une adresse email est requise');
                } else if (!isValidEmail(getValue('email'))) {
                    errors.push('Veuillez saisir une adresse email valide');
                }
                if (!getValue('adresse')) {
                    errors.push('Votre adresse complète est requise');
                }
                if (!getValue('region')) {
                    errors.push('Veuillez sélectionner votre région');
                }
                if (!getValue('district')) {
                    errors.push('Le district doit être précisé');
                }
                break;
                
            case 4: // Scolarité
                if (!getValue('bacc_serie')) {
                    errors.push('Veuillez sélectionner la série de votre Baccalauréat');
                }
                if (!getValue('bacc_date_obtention')) {
                    errors.push('Veuillez indiquer l\'année d\'obtention de votre Baccalauréat');
                }
                
                // Validation conditionnelle pour le sponsor
                    if (document.getElementById('bursary_status').checked) {
                    if (!getValue('sponsor_nom')) errors.push('Le nom du sponsor est requis');
                    // Le prénom du sponsor peut être absent (certaines personnes n'en ont pas)
                    if (!getValue('sponsor_telephone')) errors.push('Le téléphone du sponsor est requis');
                    if (!getValue('sponsor_adresse')) errors.push('L\'adresse du sponsor est requise');
                }
                break;

            case 5: // Informations académiques
                if (!getValue('year_level_id')) {
                    errors.push('Veuillez sélectionner votre niveau d\'étude');
                }
                if (!getValue('mention_id')) {
                    errors.push('Veuillez choisir une mention');
                }
                break;
        }
        
        if (errors.length > 0) {
            showErrors(errors);
            return false;
        }
        
        return true;
    }
    
    // Fonctions utilitaires pour la validation
    function calculateAge(dateString) {
        const birthDate = new Date(dateString);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        return age;
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Mise à jour de l'affichage des étapes
    function updateStepDisplay() {
        // Masquer toutes les étapes
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.add('hidden');
        });

        // Afficher l'étape courante
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        // Mettre à jour le titre et le compteur
        stepTitle.textContent = stepTitles[currentStep - 1];
        stepCounter.textContent = `Étape ${currentStep} sur ${totalSteps}`;

        // Mettre à jour la barre de progression
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;

        // Gérer l'affichage des boutons
        prevBtn.classList.toggle('hidden', currentStep === 1);
        nextBtn.classList.toggle('hidden', currentStep === totalSteps);
        submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
    }

    // Navigation vers l'étape précédente
    function goToPreviousStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
            hideErrors(); // Masquer les erreurs lors de la navigation
        }
    }

    // Navigation vers l'étape suivante
    function goToNextStep() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
                hideErrors(); // Masquer les erreurs lors de la navigation
            }
        }
    }

    // Affichage des erreurs (obsolète, remplacé par showErrors avec toasts)
    function showErrors_old(errors) {
        errorList.innerHTML = errors.map(error => `<p>• ${error}</p>`).join('');
        errorContainer.classList.remove('hidden');
        window.scrollTo(0, 0);
    }

    // Masquer les erreurs (obsolète, remplacé par closeToast)
    function hideErrors() {
        // errorContainer.classList.add('hidden'); // Retiré car les toasts gèrent l'affichage
    }

    // Obtenir la valeur d'un champ
    function getValue(fieldName) {
        const field = document.getElementById(fieldName);
        if (!field) return '';
        return field.type === 'checkbox' ? field.checked : field.value.trim();
    }

    // Génération automatique de l'email
    function generateEmail() {
        const nom = getValue('nom');
        const prenom = getValue('prenom');
        if (nom) {
            // Normalize and strip spaces/diacritics/invalid chars from last name
            let nomFormatted = nom.toLowerCase().trim();
            // remove accents
            try {
                nomFormatted = nomFormatted.normalize('NFD').replace(/[,\u0300-\u036f]/g, '');
            } catch (e) {
                // normalize may not be supported; fall back to original
            }
            // remove any non-alphanumeric characters (including spaces)
            nomFormatted = nomFormatted.replace(/[^a-z0-9]/g, '');

            let email;
            if (!prenom) {
                // No first name: use normalized last name only
                email = `${nomFormatted}@zurcher.edu.mg`;
            } else {
                // Normalize first name and handle composed first names
                let prenomFormatted = prenom.toLowerCase().trim();
                try {
                    prenomFormatted = prenomFormatted.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                } catch (e) {}
                // take the first token of the first name (before any space)
                const premierPrenom = (prenomFormatted.split(/\s+/)[0] || prenomFormatted).replace(/[^a-z0-9]/g, '');
                const troisLettresPrenom = premierPrenom.slice(0, 3);
                email = `${nomFormatted}.${troisLettresPrenom}@zurcher.edu.mg`;
            }

            document.getElementById('email').value = email;
            const previewEl = document.getElementById('generated-email');
            if (previewEl) previewEl.textContent = email;
            const previewContainer = document.getElementById('email-preview');
            if (previewContainer) previewContainer.classList.remove('hidden');
        } else {
            const emailField = document.getElementById('email');
            if (emailField) emailField.value = '';
            const previewContainer = document.getElementById('email-preview');
            if (previewContainer) previewContainer.classList.add('hidden');
        }
    }

    // Calcul de l'âge et mise à jour de l'affichage
    function calculateAge() {
        const dateNaissance = getValue('date_naissance');
        if (!dateNaissance) {
            age = 0;
            document.getElementById('age-display').classList.add('hidden');
            return;
        }

        const birthDate = new Date(dateNaissance);
        const today = new Date();
        age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        const ageDisplay = document.getElementById('age-display');
        const isMajeur = age >= 18;
        ageDisplay.textContent = `Âge: ${age} ans ${isMajeur ? '(Majeur)' : '(Mineur)'}`;
        ageDisplay.classList.remove('hidden');

        // Afficher/masquer la section CIN selon l'âge
        const cinSection = document.getElementById('cin-section');
        if (isMajeur) {
            cinSection.classList.remove('hidden');
        } else {
            cinSection.classList.add('hidden');
            // Vider les champs CIN si la section est masquée
            document.getElementById('cin_numero').value = '';
            document.getElementById('cin_date_delivrance').value = '';
            document.getElementById('cin_lieu_delivrance').value = '';
        }
    }

    // Afficher/masquer la section conjoint
    function toggleConjointSection() {
        const etatCivil = getValue('etat_civil');
        const conjointSection = document.getElementById('conjoint-section');

        if (etatCivil === 'marié') {
            conjointSection.classList.remove('hidden');
        } else {
            conjointSection.classList.add('hidden');
            document.getElementById('nom_conjoint').value = '';
            document.getElementById('nb_enfant').value = '0';
        }
    }

    // Afficher/masquer la section sponsor
    function toggleSponsorSection() {
        const isBursary = document.getElementById('bursary_status').checked;
        const sponsorSection = document.getElementById('sponsor-section');

        if (isBursary) {
            sponsorSection.classList.remove('hidden');
            } else {
            sponsorSection.classList.add('hidden');
            document.getElementById('sponsor_nom').value = '';
            // Ne pas vider sponsor_prenom — certaines personnes peuvent ne pas en avoir
            // document.getElementById('sponsor_prenom').value = '';
            document.getElementById('sponsor_telephone').value = '';
            document.getElementById('sponsor_adresse').value = '';
        }
    }

    // Afficher/masquer la section passeport
    function togglePassportSection() {
        const isPassport = document.getElementById('passport_status').checked;
        const passportSection = document.getElementById('passport-section');

        if (isPassport) {
            passportSection.classList.add('show');
        } else {
            passportSection.classList.remove('show');
            // Vider les champs du passeport
            document.getElementById('passport_numero').value = '';
            document.getElementById('passport_pays_emission').value = '';
            document.getElementById('passport_date_emission').value = '';
            document.getElementById('passport_date_expiration').value = '';
        }
    }

    // Formatage du téléphone
    function formatPhone(e) {
        const value = e.target.value;
        const numbers = value.replace(/\D/g, '').slice(0, 10);
        e.target.value = numbers.replace(/(\d{3})(\d{2})(\d{3})(\d{2})/, '$1 $2 $3 $4');
    }

    // Formatage du téléphone du sponsor
    function formatSponsorPhone(e) {
        formatPhone(e);
    }

    // Génération du matricule (exemple basique)
    function generateMatricule() {
        const mention = getValue('mention_id');
        if (!mention) return;

        // Mapping basique des mentions aux préfixes de matricule
        const mentionPrefixMap = {
            '1': '1', // Exemple: ID 1 pour Théologie
            '2': '2', // Exemple: ID 2 pour Gestion
            '3': '3', // Exemple: ID 3 pour Informatique
            '4': '4', // Exemple: ID 4 pour Sciences infirmières
            '5': '5', // Exemple: ID 5 pour Éducation
            '6': '6', // Exemple: ID 6 pour Communication
            '9': '9'  // Exemple: ID 9 pour Droit
        };
        const prefix = mentionPrefixMap[mention] || '0';

        // Générer un numéro séquentiel simulé (à remplacer par une logique serveur si nécessaire)
        const randomNum = Math.floor(Math.random() * 9999).toString().padStart(4, '0');
        const matricule = `${prefix}${randomNum}`;

        // Assurez-vous que l'élément 'matricule' existe dans votre HTML
        const matriculeField = document.getElementById('matricule');
        if (matriculeField) {
            matriculeField.value = matricule;
        }
    }

    // Configuration des écouteurs d'événements
    function setupEventListeners() {
        // Navigation
        prevBtn.addEventListener('click', goToPreviousStep);
        nextBtn.addEventListener('click', goToNextStep);
        form.addEventListener('submit', handleSubmit);

        // Génération automatique d'email
        document.getElementById('nom').addEventListener('input', generateEmail);
        document.getElementById('prenom').addEventListener('input', generateEmail);

        // Calcul de l'âge
        document.getElementById('date_naissance').addEventListener('change', calculateAge);

        // Sections conditionnelles
        document.getElementById('etat_civil').addEventListener('change', toggleConjointSection);
        document.getElementById('bursary_status').addEventListener('change', toggleSponsorSection);
        document.getElementById('passport_status').addEventListener('change', togglePassportSection);

        // Formatage du téléphone
        document.getElementById('telephone').addEventListener('input', formatPhone);
        document.getElementById('sponsor_telephone').addEventListener('input', formatSponsorPhone);
        document.getElementById('contact_pere').addEventListener('input', formatPhone);
        document.getElementById('contact_mere').addEventListener('input', formatPhone);

        // Chargement dynamique des parcours selon la mention sélectionnée
        const mentionSelect = document.getElementById('mention_id');
        const parcoursSelect = document.getElementById('parcours_id');
        if (mentionSelect && parcoursSelect) {
            mentionSelect.addEventListener('change', function() {
                const mentionId = this.value;
                parcoursSelect.innerHTML = '<option value="">Chargement...</option>';
                if (!mentionId) {
                    parcoursSelect.innerHTML = '<option value="">Sélectionnez le parcours</option>';
                    return;
                }
                fetch(`/parcours/by-mention/${mentionId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Sélectionnez le parcours</option>';
                        data.forEach(function(parcours) {
                            options += `<option value="${parcours.id}">${parcours.nom}</option>`;
                        });
                        parcoursSelect.innerHTML = options;
                    })
                    .catch(() => {
                        parcoursSelect.innerHTML = '<option value="">Aucun parcours trouvé</option>';
                    });
            });
        }

        // Validation du code d'accès au départ du champ
        document.getElementById('access_code').addEventListener('blur', function() {
            const code = this.value;
            if (!code) {
                isAccessCodeValid = false; // Réinitialiser si le champ est vide
                return;
            }

            const upperCode = code.toUpperCase();
            
            // Afficher l'état de chargement
            this.style.opacity = '0.7';
            this.disabled = true;

            fetch('/check-access-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ access_code: upperCode })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau lors de la vérification du code');
                }
                return response.json();
            })
            .then(data => {
                console.log('Réponse du serveur:', data); // Pour le débogage
                isAccessCodeValid = data.valid;
                if (!data.valid) {
                    showToast('Code d\'accès invalide. Veuillez vérifier et réessayer.', 'error');
                    this.value = ''; // Vider le champ si invalide
                    this.focus();
                } else {
                    this.value = upperCode; // Conserver le code en majuscules
                    showToast('Code d\'accès validé avec succès !', 'success', 2000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('Impossible de vérifier le code d\'accès. Vérifiez votre connexion internet.', 'error');
                isAccessCodeValid = false; // Marquer comme invalide en cas d'erreur
            })
            .finally(() => {
                // Restaurer l'état de l'input
                this.style.opacity = '1';
                this.disabled = false;
            });
        });

        // Religion select + 'Autre' handling
        const religionSelect = document.getElementById('religion_select');
        const religionAutre = document.getElementById('religion_autre');
        const religionHidden = document.getElementById('religion');

        if (religionSelect && religionHidden) {
            // Initialize: if hidden has a default non-empty value, attempt to match select
            const current = religionHidden.value || '';
            if (current) {
                const found = Array.from(religionSelect.options).some(opt => opt.value === current);
                if (found) {
                    religionSelect.value = current;
                } else {
                    religionSelect.value = 'Autre';
                    religionAutre.classList.remove('hidden');
                    religionAutre.value = current;
                }
            }

            religionSelect.addEventListener('change', function() {
                const val = this.value;
                if (val === 'Autre') {
                    religionAutre.classList.remove('hidden');
                    religionAutre.focus();
                    religionHidden.value = religionAutre.value.trim();
                } else {
                    religionAutre.classList.add('hidden');
                    religionHidden.value = val;
                }
            });

            religionAutre.addEventListener('input', function() {
                religionHidden.value = this.value.trim();
            });
        }
    }

    // Soumission du formulaire
    function handleSubmit(e) {
        e.preventDefault();

        // Valider toutes les étapes avant la soumission finale
        let allStepsValid = true;
        for (let i = 1; i <= totalSteps; i++) {
            if (!validateStep(i)) {
                allStepsValid = false;
                // Si une étape n'est pas valide, on navigue vers elle et on arrête la validation
                currentStep = i;
                updateStepDisplay();
                break;
            }
        }

        if (!allStepsValid) {
            return; // Ne pas soumettre si une étape n'est pas valide
        }

        // Afficher le spinner et désactiver le bouton
        document.getElementById('submit-text').textContent = 'Enregistrement...';
        document.getElementById('submit-spinner').classList.remove('hidden');
        submitBtn.disabled = true;

        // Collecter toutes les données du formulaire
        const formData = new FormData(form);

        // Envoyer les données via AJAX
        fetch("{{ route('register.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Indique une requête AJAX
                'Accept': 'application/json', // Attendre une réponse JSON
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                // Si la réponse n'est pas OK (ex: 422 Unprocessable Entity pour les erreurs de validation)
                return response.json().then(data => { throw data; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Redirection vers la page de récapitulatif ou une autre page
                showSuccess('Inscription soumise avec succès !');
                setTimeout(() => {
                    window.location.href = data.redirect_url || '/'; // Utiliser l'URL de redirection ou une URL par défaut
                }, 2000); // Délai avant redirection
            } else {
                // Gérer les erreurs de validation du backend
                if (data.errors) {
                    const backendErrors = Object.values(data.errors).flat();
                    showErrors(backendErrors);
                } else {
                    // Gérer d'autres messages d'erreur du backend
                    showToast(data.message || 'Une erreur s\'est produite lors de l\'enregistrement.', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la soumission:', error);
            // Afficher les erreurs de validation du backend si disponibles
            if (error.errors) {
                const backendErrors = Object.values(error.errors).flat();
                showErrors(backendErrors);
            } else {
                // Afficher un message d'erreur générique
                showToast(error.message || 'Une erreur inattendue s\'est produite. Veuillez réessayer.', 'error');
            }
        })
        .finally(() => {
            // Réinitialiser le bouton et le spinner
            document.getElementById('submit-text').textContent = 'Enregistrer';
            document.getElementById('submit-spinner').classList.add('hidden');
            submitBtn.disabled = false;
        });
    }
</script>

</html>
