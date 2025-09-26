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
            transition: all 0.2s ease;
        }
        
        .table-row:hover {
            background-color: #f8fafc;
            transform: translateX(4px);
        }
        
        .amount-highlight {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Sidebar -->
    @include('superadmin.components.sidebar')

    <!-- Main Content -->
    <div class="main-content min-h-screen">
        <!-- Header -->
        @include('superadmin.components.header')

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
            <!-- Header moderne avec gradient et fonctionnalités de recherche -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-2xl p-8 mb-8 text-white shadow-2xl fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Gestion des Finances Étudiantes</h1>
                        <p class="text-blue-100 text-lg">Gérez les paiements et frais de scolarité</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="search-container">
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput" 
                                       placeholder="Rechercher un étudiant..." 
                                       class="search-input w-full sm:w-80 px-4 py-3 pl-12 rounded-xl border-0 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
            
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
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Crédits totaux</th>
                                   <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Montant dû</th>
                                   <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Détails</th>
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
                                            <div class="text-sm text-gray-500">ID: {{ $finance->student->matricule ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell" data-finance-id="{{ $finance->id }}" title="Double-cliquer pour modifier">
                                        {{ $finance->plan ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 font-medium">{{ $finance->total_credit ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="amount-highlight text-lg font-bold">{{ $finance->total_payment ?? '0' }}</span>
                                </td>
                            </tr>

                            {{-- Installments row (desktop): show student_installments for this finance's student --}}
                            @php
                                // Use the eager-loaded installments where possible. If student relation is missing,
                                // try to resolve by matricule as a fallback and load installments ordered by sequence.
                                $installments = collect();
                                if (!empty($finance->student)) {
                                    $installments = $finance->student->installments ?? collect();
                                } elseif (!empty($finance->student_id)) {
                                    $fallbackStudent = \App\Models\Student::where('matricule', $finance->student_id)->first();
                                    if ($fallbackStudent) {
                                        $installments = $fallbackStudent->installments()->orderBy('sequence')->get();
                                    }
                                }
                            @endphp
                            @if($installments->count())
                            <tr class="bg-gray-50">
                                <td colspan="5" class="px-6 py-3">
                                    <div class="text-sm font-medium text-gray-700 mb-2">Échéances pour {{ $finance->student->prenom ?? '-' }} {{ $finance->student->nom ?? '-' }}</div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm">
                                            <thead>
                                                <tr class="text-left text-gray-600 text-xs uppercase">
                                                    <th class="px-2 py-1">#</th>
                                                    <th class="px-2 py-1">Montant dû</th>
                                                    <th class="px-2 py-1">Montant payé</th>
                                                    <th class="px-2 py-1">Échéance</th>
                                                    <th class="px-2 py-1">Statut</th>
                                                    <th class="px-2 py-1">Référence</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($installments as $inst)
                                                <tr class="border-t">
                                                    <td class="px-2 py-1">{{ $inst->sequence }}</td>
                                                    <td class="px-2 py-1">{{ number_format($inst->amount_due, 2, ',', ' ') }} FCFA</td>
                                                    <td class="px-2 py-1">{{ number_format($inst->amount_paid, 2, ',', ' ') }} FCFA</td>
                                                    <td class="px-2 py-1">{{ $inst->due_at ? \Carbon\Carbon::parse($inst->due_at)->format('d/m/Y') : '-' }}</td>
                                                    <td class="px-2 py-1">{{ ucfirst($inst->status) }}</td>
                                                    <td class="px-2 py-1">{{ $inst->reference ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- duplicate desktop installments block removed (installments are rendered inline inside the table loop) --}}

            <!-- Version mobile avec cartes -->
            <div class="lg:hidden space-y-4" id="financeCardsContainer">
                @foreach($finances as $index => $finance)
             <div class="finance-card bg-white rounded-xl p-6 shadow-lg stagger-{{ ($index % 4) + 1 }} finance-row"
                 data-student="{{ strtolower($finance->student->prenom ?? '') }} {{ strtolower($finance->student->nom ?? '') }}"
                 data-type="{{ strtolower($finance->plan ?? '') }}"
                 data-status="{{ strtolower(($finance->total_payment ?? '0') != '0' ? 'payé' : 'en_attente') }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold mr-4">
                                {{ substr($finance->student->prenom ?? 'U', 0, 1) }}{{ substr($finance->student->nom ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $finance->student->prenom ?? '' }} {{ $finance->student->nom ?? '' }}</h3>
                                <p class="text-gray-500 text-sm">ID: {{ $finance->student->id ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($finance->status == 'payé') bg-green-100 text-green-800
                            @elseif($finance->status == 'en_attente') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            {{ ucfirst(str_replace('_', ' ', $finance->status)) }}
                        </span>
                        <div class="ml-4 text-right">
                            <div><span class="amount-highlight text-lg font-bold">{{ number_format($finance->computed->total_due ?? 0, 0, ',', ' ') }} Ar</span></div>
                            <div class="text-sm text-gray-600">
                                <div>Frais généraux: {{ number_format($finance->computed->frais_generaux ?? 0, 0, ',', ' ') }} Ar</div>
                                <div>Écolage: {{ number_format($finance->computed->ecolage ?? 0, 0, ',', ' ') }} Ar</div>
                                <div>Cantine: {{ number_format($finance->computed->cantine ?? 0, 0, ',', ' ') }} Ar</div>
                                <div>Dortoir: {{ number_format($finance->computed->dortoir ?? 0, 0, ',', ' ') }} Ar</div>
                            </div>
                        </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Type</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $finance->type }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Montant</p>
                            <p class="amount-highlight text-xl font-bold">{{ number_format($finance->montant, 2) }} Ar</p>
                        </div>
                    </div>
                    
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Matricule</p>
                            <p class="text-gray-900 font-medium">{{ $finance->student->matricule ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Plan</p>
                            <p class="text-gray-900 font-medium plan-cell" data-finance-id="{{ $finance->id }}">{{ $finance->plan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Crédits totaux</p>
                            <p class="text-gray-900 font-medium">{{ $finance->total_credit ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Total payé</p>
                            <p class="text-gray-900 font-medium">{{ $finance->total_payment ?? '0' }}</p>
                        </div>
                    </div>
                    
                    {{-- Installments (mobile card) --}}
                    @php
                        $installments = collect();
                        if (!empty($finance->student)) {
                            $installments = $finance->student->installments ?? collect();
                        } elseif (!empty($finance->student_id)) {
                            $fallbackStudent = \App\Models\Student::where('matricule', $finance->student_id)->first();
                            if ($fallbackStudent) {
                                $installments = $fallbackStudent->installments()->orderBy('sequence')->get();
                            }
                        }
                    @endphp
                    @if($installments && $installments->count())
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-600 mb-2">Échéances</h4>
                            <div class="space-y-2 text-sm text-gray-700">
                                @foreach($installments as $inst)
                                    <div class="flex items-center justify-between bg-gray-50 rounded px-3 py-2">
                                        <div class="flex items-center gap-3">
                                            <div class="font-medium">#{{ $inst->sequence }}</div>
                                            <div class="text-gray-600">{{ number_format($inst->amount_due, 2, ',', ' ') }} FCFA</div>
                                        </div>
                                        <div class="text-right text-sm">
                                            <div class="text-gray-700">{{ $inst->due_at ? \Carbon\Carbon::parse($inst->due_at)->format('d/m/Y') : '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ ucfirst($inst->status) }} • {{ $inst->reference ?? '-' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        {{-- <a href="{{ route('superadmin.finances.show', $finance->id) }}" 
                           class="action-btn bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            <span>Voir</span>
                        </a> --}}
                        <a href="{{ route('superadmin.finances.edit', $finance->id) }}" 
                           class="action-btn bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg hover:bg-yellow-200 flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Modifier</span>
                        </a>
                        <form action="{{ route('superadmin.finances.destroy', $finance->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette finance ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 flex items-center gap-2">
                                <i class="fas fa-trash"></i>
                                <span>Supprimer</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
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

        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
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
                    fetch(`{{ url('/superadmin/finances') }}/${financeId}/plan`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ plan: select.value })
                    }).then(r => r.json()).then(data => {
                        const span = document.createElement('span');
                        span.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 plan-cell';
                        span.dataset.financeId = financeId;
                        span.textContent = data.plan || select.value;
                        select.replaceWith(span);
                        // reattach dblclick
                        span.addEventListener('dblclick', () => makePlanEditable(span));
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
    </script>
</body>
</html>
