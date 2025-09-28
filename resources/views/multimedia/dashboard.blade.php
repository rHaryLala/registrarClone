<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Multimedia - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Added consistent layout styles for sidebar and main content */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1954b4 0%, #0b2d5c 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            background: transparent;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Modern table styles and search styling borrowed from superadmin list view */
        .modern-table {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .modern-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: white;
        }
        .modern-input:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .modern-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .student-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
        }
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.3);
        }

        .table-row:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.02) 0%, rgba(147, 197, 253, 0.05) 100%);
            transform: translateX(4px);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        /* Modern checkbox styles */
        .modern-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .modern-checkbox:checked {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-color: #3b82f6;
        }

        .modern-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .modern-checkbox:hover {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 32px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            transition: all 0.3s ease;
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        /* Badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-verified {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border: 1px solid #22c55e;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        /* Responsive design improvements */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }

            .modern-table {
                margin: 0 -16px;
                border-radius: 0;
            }
        }

        /* Added smooth scrolling and better typography */
        html {
            scroll-behavior: smooth;
        }

        .page-title {
            background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="dashboard-container">
        <div class="sidebar">
            @include('multimedia.components.sidebar')
        </div>

        <div class="main-content">
            <div class="header sticky top-0 z-50">
                @include('multimedia.components.header')
            </div>

            <main class="p-8 space-y-8">
                        <div class="mb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Liste des étudiants</h1>
                                    <p class="text-gray-600">Gestion des frais de scolarité et vérifications</p>
                                </div>
                            </div>
                            <!-- Modern search and filter section (matches superadmin appearance) -->
                            <div class="search-container rounded-2xl p-6 mb-6 shadow-lg">
                                <form method="get" id="searchForm" onsubmit="return false;" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2">
                                            <label for="searchInputmultimedia" class="block text-sm font-medium text-white mb-2">
                                                <i class="fas fa-search mr-2"></i>Rechercher des étudiants
                                            </label>
                                            <input type="text" 
                                                   name="q" 
                                                   id="searchInputmultimedia" 
                                                   placeholder="Nom, prénom, matricule, email..." 
                                                   class="modern-input w-full px-4 py-3 rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-500"
                                                   autocomplete="off" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                <div class="desktop-table bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full" id="studentsTable">
                            <thead class="bg-blue-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Matricule</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Prénom</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody" class="bg-white divide-y divide-slate-100">
                                <!-- Rows will be rendered client-side from studentsArray -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile cards layout like superadmin list -->
                <div class="mobile-cards space-y-4" id="mobileCards">
                    {{-- Mobile cards will be generated by client-side filter if needed --}}
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Mobile sidebar toggle (if needed)
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            }
        });
    </script>

    <script>
        // Client-side renderer similar to superadmin.students.list
        (function() {
            // Data injected from controller
            const students = @json($studentsArray ?? []);
            const mentions = @json($mentionsArray ?? []);

            function getInitials(prenom, nom) {
                const prenomInitial = prenom ? prenom.charAt(0) : '';
                const nomInitial = nom ? nom.charAt(0) : '';
                return (prenomInitial + nomInitial) || '?';
            }

            const input = document.getElementById('searchInputmultimedia');
            const clearBtn = document.getElementById('clearSearchBtn');
            const tableBody = document.getElementById('studentsTableBody');
            const mobileContainer = document.getElementById('mobileCards');

            function renderTable(filteredStudents) {
                tableBody.innerHTML = '';
                mobileContainer.innerHTML = '';

                if (!filteredStudents || filteredStudents.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-12 text-center"><div class="flex flex-col items-center"><i class="fas fa-users text-4xl text-gray-300 mb-4"></i><p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p><p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p></div></td></tr>`;
                    mobileContainer.innerHTML = `<div class="text-center py-12"><i class="fas fa-users text-4xl text-gray-300 mb-4"></i><p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p><p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p></div>`;
                    return;
                }

                filteredStudents.forEach(student => {
                    // Desktop row
                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-blue-50 transition-colors duration-200 cursor-pointer";
                    tr.onclick = () => window.location = `/multimedia/students/${student.id}`;

                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono text-blue-800 bg-blue-50 px-2 py-1 rounded">${student.matricule || '-'}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-3">${getInitials(student.prenom, student.nom)}</div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">${student.nom || ''}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${student.prenom || ''}</td>
                    `;

                    tableBody.appendChild(tr);

                    // Mobile card
                    const card = document.createElement('div');
                    card.className = "student-card bg-white rounded-xl p-6 shadow-md cursor-pointer";
                    card.onclick = () => window.location = `/multimedia/students/${student.id}`;
                    card.innerHTML = `
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white font-semibold mr-4">${getInitials(student.prenom, student.nom)}</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">${student.prenom ? student.prenom + ' ' : ''}${student.nom || ''}</h3>
                                    <p class="text-sm text-gray-600">${student.email || ''}</p>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-blue-800 bg-blue-50 px-2 py-1 rounded">${student.matricule || '-'}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Niveau d'étude</p>
                                <p class="text-sm font-medium text-gray-900">${student.year_level_label ?? '-'}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Mention</p>
                                <p class="text-sm font-medium text-gray-900">${student.mention_nom}</p>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 pt-4 border-t border-gray-100">
                            <a href="/multimedia/students/${student.id}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center text-sm" onclick="event.stopPropagation();"><i class="fas fa-eye mr-1"></i> Voir</a>
                        </div>
                    `;
                    mobileContainer.appendChild(card);
                });
            }

            function filterStudents() {
                const q = (input?.value || '').toLowerCase().trim();
                const filtered = students.filter(student => {
                    return !q || (
                        (student.matricule || '').toLowerCase().includes(q) ||
                        (student.nom || '').toLowerCase().includes(q) ||
                        (student.prenom || '').toLowerCase().includes(q) ||
                        (student.email || '').toLowerCase().includes(q)
                    );
                });
                renderTable(filtered);
            }

            if (input) input.addEventListener('input', filterStudents);
            if (clearBtn) clearBtn.addEventListener('click', function() { if (input) { input.value = ''; input.focus(); } filterStudents(); });

            // Initial render
            renderTable(students);
        })();
    </script>
</body>
</html>
