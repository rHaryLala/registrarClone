<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finances - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
        }
        .sidebar {
            width: 260px;
            transition: all 0.3s;
        }
        .main-content {
            margin-left: 260px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.active {
                margin-left: 0;
            }
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Ajout d'animations modernes et effets visuels sophistiqués */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .finance-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
        }
        
        .finance-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-left-color: #1e40af;
        }
        
        .status-badge {
            transition: all 0.2s ease;
        }
        
        .status-badge:hover {
            transform: scale(1.05);
        }
        
        .action-btn {
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .search-container {
            position: relative;
        }
        
        .search-input {
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn:hover {
            background-color: #1e40af;
            transform: scale(1.05);
        }
        
        .table-row {
            /* remove transition/hover animation to keep table stable on hover */
            transition: none;
        }

        .table-row:hover {
            /* neutral hover: no background change and no transform */
            background-color: transparent;
            transform: none;
        }
        
        .amount-highlight {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }
    .payment-table td { font-size: 1rem; }
    .payment-table th { font-size: 0.95rem; }
    .date-text { font-size: 1rem; font-weight: 600; color: #374151; }
    /* Details (left column) sizing */
    .details-table td { font-size: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .bg-gray-50 h3 { font-size: 1.05rem; }
    .details-table tr.border-t td { font-size: 1.05rem; font-weight: 700; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Sidebar -->
    @include('chief_accountant.components.sidebar')

    <!-- Main Content -->
    <div class="main-content min-h-screen">
        <!-- Header -->
        @include('chief_accountant.components.header')

        {{-- Last change toast (show who modified most recently) --}}
        @if(isset($lastChangedBy) && $lastChangedBy)
            @php
                $lcName = '-';
                if (is_object($lastChangedBy) && isset($lastChangedBy->name)) {
                    $lcName = $lastChangedBy->name;
                } elseif (!is_object($lastChangedBy)) {
                    $lcName = $lastChangedBy;
                }
                // Show exact datetime (local format) instead of relative 'ago'
                $lcWhen = (isset($lastChangedAt) && $lastChangedAt) ? \Carbon\Carbon::parse($lastChangedAt)->format('d/m/Y H:i') : null;
            @endphp
            <div id="last-change-toast" class="fixed top-4 right-4 z-50 bg-white border border-gray-200 shadow-lg rounded-lg px-4 py-3 flex items-start gap-3" role="status" aria-live="polite">
                <div class="text-blue-600 mt-1"><i class="fas fa-user-edit"></i></div>
                <div>
                    <div class="font-semibold text-gray-900">Dernière modification</div>
                    <div class="text-sm text-gray-600">Par {{ $lcName }}@if($lcWhen) • {{ $lcWhen }}@endif</div>
                </div>

                {{-- payment preview removed from toast (moved below) --}}
                <button id="last-change-toast-close" class="ml-3 text-gray-400 hover:text-gray-600" aria-label="Fermer">&times;</button>
            </div>
            <script>
            (function() {
                const toast = document.getElementById('last-change-toast');
                if (!toast) return;
                const closeBtn = document.getElementById('last-change-toast-close');
                const hide = () => { toast.style.transition = 'opacity 0.4s'; toast.style.opacity = 0; setTimeout(() => toast.remove(), 500); };
                setTimeout(hide, 8000);
                if (closeBtn) closeBtn.addEventListener('click', hide);
            })();
            </script>
        @endif

        <main class="p-6 max-w-7xl mx-auto">
            <!-- Back button + Header moderne avec gradient et fonctionnalités de recherche -->
            <div class="mb-4">
                <button type="button" onclick="history.back()" aria-label="Retour" class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span class="font-medium">Retour</span>
                </button>
            </div>
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-2xl p-8 mb-8 text-white shadow-2xl fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Gestion des Finances Étudiantes</h1>
                        <p class="text-blue-100 text-lg">Gérez les paiements et frais de scolarité</p>
                    </div>
                
                </div>
            </div>

            <!-- Version desktop avec tableau moderne -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-xl overflow-hidden slide-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Étudiant</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Matricule</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Mode de paiement</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="financeTableBody">
                            @foreach($finances as $index => $finance)
                            <tr class="table-row finance-row stagger-{{ ($index % 4) + 1 }}" 
                                data-student="{{ strtolower($finance->student->prenom ?? '') }} {{ strtolower($finance->student->nom ?? '') }}"
                                data-type="{{ strtolower($finance->plan ?? '') }}"
                                data-status="{{ strtolower(($finance->total_payment ?? '0') != '0' ? 'payé' : 'en_attente') }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold mr-3">
                                            {{ substr($finance->student->prenom ?? 'U', 0, 1) }}{{ substr($finance->student->nom ?? 'N', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $finance->student->prenom ?? '' }} {{ $finance->student->nom ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $finance->student->matricule ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell" data-finance-id="{{ $finance->id }}" title="Double-cliquer pour modifier">
                                        {{ $finance->plan ?? '-' }}
                                    </span>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Payment plan block shown at the bottom for the first finance's student (if available) --}}
                @php
                    $firstFinance = $finances->first() ?? null;
                    $studentForPlan = $firstFinance->student ?? null;
                    $computed = $firstFinance->computed ?? null;
                    $Montant_sans_frais_Generaux = 0;
                    // montant de base pour le calcul des tranches: Ecolage + Labo* + Dortoir + Cantine
                    $Montant_tranche_base = 0;
                    $modeP = $firstFinance->plan ?? 'A';
                    if ($studentForPlan && $computed) {
                        $Montant_sans_frais_Generaux = max(0, ($computed->total_due ?? 0) - ($computed->frais_generaux ?? 0));
                        $Montant_tranche_base = (
                            ($computed->ecolage ?? 0) +
                            ($computed->labo_info ?? 0) +
                            ($computed->labo_comm ?? 0) +
                            ($computed->labo_langue ?? 0) +
                            ($computed->dortoir ?? 0) +
                            ($computed->cantine ?? 0)
                        );
                        $modeP = \App\Models\Finance::where('student_id', $studentForPlan->matricule)
                                    ->orderByDesc('date_entry')
                                    ->value('plan') ?? $modeP;
                    }
                @endphp

                @if($studentForPlan)
                    <div class="bg-white rounded-2xl shadow-md p-6 mt-6">

                        {{-- expose montant to JS so we can rebuild the payment table dynamically --}}
                        <input type="hidden" id="montant-sans-frais" value="{{ $Montant_sans_frais_Generaux }}">
                        {{-- base pour tranches = ecolage + labos + dortoir + cantine --}}
                        <input type="hidden" id="montant-tranche-base" value="{{ $Montant_tranche_base }}">

                        <div class="flex flex-col lg:flex-row gap-6 mt-4 items-start">
                            {{-- Left column: breakdown from student_semester_fees (via $computed)
                                 Right column: payment table (tranches) --}}
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <h3 class="font-semibold mb-3">Détails</h3>
                                <table class="w-full text-sm text-gray-700 details-table">
                                    <tbody>
                                        <tr>
                                            <td class="py-2">Frais généraux</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->frais_generaux ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Dortoir</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->dortoir ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Cantine</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->cantine ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Labo info</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->labo_info ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Labo comm</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->labo_comm ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Labo langue</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->labo_langue ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Ecolage</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->ecolage ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Voyage d'étude</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->voyage_etude ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Colloque</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->colloque ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Frais costume</td>
                                            <td class="py-2 text-right font-medium">{{ number_format($computed->frais_costume ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                        <tr class="border-t mt-2">
                                            <td class="py-3 font-semibold">Total</td>
                                            <td class="py-3 text-right font-semibold">{{ number_format($computed->total_amount ?? $computed->total_due ?? 0, 0, ',', ' ') }} ar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- vertical separator on large screens --}}
                            <div class="hidden lg:block w-px bg-gray-200"></div>

                            {{-- Right column: payment plan card --}}
                            <div class="w-full lg:w-1/2">
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                    <div class="mb-3 flex items-center justify-between">
                                        <div>
                                            <h4 id="planHeader" class="font-semibold text-lg">Plan de paiement — TYPE {{ $modeP }}</h4>
                                            <div id="planAmount" class="text-sm text-gray-500">Montant: {{ number_format($Montant_tranche_base, 0, ',', ' ') }} ar</div>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-100 payment-table" style="text-align:left; table-layout:fixed;">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-sm font-medium text-gray-700" style="width:25%">Tranche</th>
                                                    <th class="px-3 py-2 text-right pr-6 text-sm font-medium text-gray-700" style="width:25%">Montant</th>
                                                    <th class="px-3 py-2 pl-6 text-left text-sm font-medium text-gray-700" style="width:50%">Échéance</th>
                                                </tr>
                                            </thead>
                                                <tbody id="paymentTableBody" class="bg-white divide-y divide-gray-100">
                                @if($modeP === 'A')
                                    <tr>
                                        <td class="px-3 py-2">100 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format($Montant_tranche_base, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">3 octobre 2025</span></td>
                                    </tr>
                                @elseif($modeP === 'B')
                                    <tr>
                                        <td class="px-3 py-2">50 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">3 octobre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">50 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">30 janvier 2026</span></td>
                                    </tr>
                                @elseif($modeP === 'C')
                                    <tr>
                                        <td class="px-3 py-2">50 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 50) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">3 octobre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">19 décembre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">30 janvier 2026</span></td>
                                    </tr>
                                @elseif($modeP === 'D')
                                    <tr>
                                        <td class="px-3 py-2">75 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 75) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">3 octobre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">30 janvier 2026</span></td>
                                    </tr>
                                @elseif($modeP === 'E')
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">24 octobre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_tranche_base * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">28 novembre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">19 décembre 2025</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2">25 %</td>
                                        <td class="px-3 py-2 text-right pr-6">{{ number_format(($Montant_sans_frais_Generaux * 25) / 100, 0, ',', ' ') }} ar</td>
                                        <td class="px-3 py-2 pl-6"><span class="date-text text-sm text-gray-700">30 janvier 2026</span></td>
                                    </tr>
                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endif

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const financeRows = document.querySelectorAll('.finance-row');
            
            // Fonction de recherche
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                financeRows.forEach(row => {
                    const studentName = row.dataset.student || '';
                    const type = row.dataset.type || '';
                    const status = row.dataset.status || '';
                    
                    const isVisible = studentName.includes(searchTerm) || 
                                    type.includes(searchTerm) || 
                                    status.includes(searchTerm);
                    
                    if (isVisible) {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Animation d'apparition des éléments
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observer tous les éléments avec animation
            document.querySelectorAll('.stagger-1, .stagger-2, .stagger-3, .stagger-4').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                observer.observe(el);
            });
        });

        // Toggle sidebar on mobile (guard if toggle element is missing)
        const sidebarToggleBtn = document.getElementById('sidebarToggle');
        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function() {
                document.querySelector('.sidebar')?.classList.toggle('active');
            });
        }

        // Close sidebar when clicking outside on mobile (guard elements)
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (!sidebar || !toggle) return;

            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Double-click to edit plan (A..E)
        function makePlanEditable(el) {
            const financeId = el.dataset.financeId;
            const current = (el.textContent || el.innerText).trim();
            const options = ['A','B','C','D','E'];

            const select = document.createElement('select');
            select.className = 'px-2 py-1 rounded bg-white border';
            options.forEach(opt => {
                const o = document.createElement('option');
                o.value = opt; o.text = opt; if (opt === current) o.selected = true;
                select.appendChild(o);
            });

            el.replaceWith(select);
            select.focus();

            const finish = (save) => {
                if (save) {
                    fetch(`{{ url('/chief-accountant/finances') }}/${financeId}/plan`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ plan: select.value })
                    }).then(r => r.json()).then(data => {
                        const newPlan = data.plan || select.value;
                        const span = document.createElement('span');
                        span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell';
                        span.dataset.financeId = financeId;
                        span.textContent = newPlan;
                        select.replaceWith(span);
                        // reattach dblclick
                        span.addEventListener('dblclick', () => makePlanEditable(span));

                        // Rebuild the payment table for the student if montant is present
                        try {
                            const montantInput = document.getElementById('montant-sans-frais');
                            const montant = montantInput ? parseFloat(montantInput.value) : null;
                            if (montant !== null && !isNaN(montant)) {
                                buildPaymentTable(newPlan, montant);
                            }

                            // Update the header and amount display so the payment block reflects the new plan immediately
                            const header = document.getElementById('planHeader');
                            if (header) header.textContent = `Plan de paiement — TYPE ${newPlan}`;

                            const amountDiv = document.getElementById('planAmount');
                            const trancheBaseInput = document.getElementById('montant-tranche-base');
                            const trancheBase = trancheBaseInput ? Number(trancheBaseInput.value) : null;
                            if (amountDiv && trancheBase !== null && !isNaN(trancheBase)) {
                                amountDiv.textContent = 'Montant: ' + trancheBase.toLocaleString('fr-FR', {maximumFractionDigits:0}) + ' ar';
                            }
                        } catch (e) {
                            // silent fail — table will remain as-is
                            console.error('Failed to rebuild payment table or update header:', e);
                        }

                    }).catch(err => {
                        // revert on error
                        const span = document.createElement('span');
                        span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell';
                        span.dataset.financeId = financeId;
                        span.textContent = current;
                        select.replaceWith(span);
                        span.addEventListener('dblclick', () => makePlanEditable(span));
                    });
                } else {
                    const span = document.createElement('span');
                    span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell';
                    span.dataset.financeId = financeId;
                    span.textContent = current;
                    select.replaceWith(span);
                    span.addEventListener('dblclick', () => makePlanEditable(span));
                }
            };

            select.addEventListener('blur', () => finish(true));
            select.addEventListener('keydown', (ev) => {
                if (ev.key === 'Enter') { ev.preventDefault(); finish(true); }
                if (ev.key === 'Escape') { ev.preventDefault(); finish(false); }
            });
        }

        // Attach dblclick handlers to initial plan cells
        document.querySelectorAll('.plan-cell').forEach(el => {
            el.addEventListener('dblclick', () => makePlanEditable(el));
        });

        // Rebuilds the payment table tbody (#paymentTableBody) according to mode and montant
        function buildPaymentTable(mode, montant) {
            const tbody = document.getElementById('paymentTableBody');
            if (!tbody) return;
            // prefer the tranche base if provided by the server
            const trancheBaseInput = document.getElementById('montant-tranche-base');
            const trancheBase = trancheBaseInput ? Number(trancheBaseInput.value) : null;
            montant = Number(trancheBase !== null && !isNaN(trancheBase) && trancheBase > 0 ? trancheBase : montant) || 0;
            const fmt = (v) => v.toLocaleString('fr-FR', {maximumFractionDigits:0});
            const rows = [];

            if (mode === 'A') {
                rows.push([ '100 %', `${fmt(montant)} ar`, '<span class="date-text">3 octobre 2025</span>' ]);
            } else if (mode === 'B') {
                const v = Math.round(montant * 0.5);
                rows.push([ '50 %', `${fmt(v)} ar`, '<span class="date-text">3 octobre 2025</span>' ]);
                rows.push([ '50 %', `${fmt(v)} ar`, '<span class="date-text">30 janvier 2026</span>' ]);
            } else if (mode === 'C') {
                const v1 = Math.round(montant * 0.5);
                const v2 = Math.round(montant * 0.25);
                rows.push([ '50 %', `${fmt(v1)} ar`, '<span class="date-text">3 octobre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v2)} ar`, '<span class="date-text">19 décembre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v2)} ar`, '<span class="date-text">30 janvier 2026</span>' ]);
            } else if (mode === 'D') {
                const v1 = Math.round(montant * 0.75);
                const v2 = Math.round(montant * 0.25);
                rows.push([ '75 %', `${fmt(v1)} ar`, '<span class="date-text">3 octobre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v2)} ar`, '<span class="date-text">30 janvier 2026</span>' ]);
            } else if (mode === 'E') {
                const v = Math.round(montant * 0.25);
                rows.push([ '25 %', `${fmt(v)} ar`, '<span class="date-text">24 octobre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v)} ar`, '<span class="date-text">28 novembre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v)} ar`, '<span class="date-text">19 décembre 2025</span>' ]);
                rows.push([ '25 %', `${fmt(v)} ar`, '<span class="date-text">30 janvier 2026</span>' ]);
            }

            // build html
            tbody.innerHTML = '';
            rows.forEach(r => {
                const tr = document.createElement('tr');
                const td1 = document.createElement('td'); td1.className = 'px-3 py-2'; td1.innerText = r[0];
                const td2 = document.createElement('td'); td2.className = 'px-3 py-2 text-right pr-6'; td2.innerHTML = r[1];
                const td3 = document.createElement('td'); td3.className = 'px-3 py-2 pl-6';
                // create a container for the date input to ensure full-width alignment
                const wrapper = document.createElement('div'); wrapper.style.width = '100%';
                // if r[2] is an input html string, set innerHTML safely
                wrapper.innerHTML = r[2];
                const input = wrapper.querySelector('input');
                if (input) {
                    input.classList.add('w-full','text-left','border','rounded','px-2','py-1');
                    // ensure input stretches
                    input.style.boxSizing = 'border-box';
                }
                td3.appendChild(wrapper);
                tr.appendChild(td1); tr.appendChild(td2); tr.appendChild(td3);
                tbody.appendChild(tr);
            });
        }

        // initialize payment table on page load using server mode and montant
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const montantInput = document.getElementById('montant-sans-frais');
                const montant = montantInput ? Number(montantInput.value) : 0;
                const serverMode = '{{ $modeP ?? 'A' }}';
                if (montant && serverMode) buildPaymentTable(serverMode, montant);
            } catch (e) {
                // ignore
            }
        });
    </script>
</body>
</html>
