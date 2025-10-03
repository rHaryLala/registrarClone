<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?php echo e(url('public/favicon.png')); ?>" type="image/png">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        /* Enhanced layout with modern background */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4ff 0%, #e8eeff 50%, #f5f7ff 100%);
            position: relative;
        }

        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 400px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 197, 253, 0.05) 100%);
            z-index: 0;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 50%, #1e293b 100%);
            box-shadow: 4px 0 24px rgba(30, 64, 175, 0.15);
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            background: transparent;
            position: relative;
            z-index: 1;
        }

        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        }

        /* Enhanced search container with animated gradient */
        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* Modern input styling */
        .modern-input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            background: white;
        }

        .modern-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .modern-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
            padding-right: 2.75rem;
        }

        /* Enhanced table styling */
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        .table-row {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .table-row:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.03) 0%, rgba(147, 197, 253, 0.05) 100%);
            transform: translateX(4px);
            box-shadow: inset 4px 0 0 #3b82f6;
        }

        .table-row:nth-child(even) {
            background: rgba(248, 250, 252, 0.5);
        }

        .table-row:nth-child(even):hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.03) 0%, rgba(147, 197, 253, 0.05) 100%);
        }

        /* Enhanced avatar with gradient border */
        .avatar-container {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            position: relative;
        }

        .avatar-container::after {
            content: '';
            position: absolute;
            inset: 2px;
            background: inherit;
            border-radius: inherit;
        }

        /* Enhanced badge styling */
        .badge {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(74, 222, 128, 0.15) 100%);
            border: 1px solid rgba(34, 197, 94, 0.2);
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.1);
        }

        .matricule-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.15) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
        }

        /* Enhanced pagination */
        .pagination-btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .pagination-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
        }

        .pagination-btn:not(:disabled):active {
            transform: translateY(0);
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        /* Enhanced action buttons */
        .action-btn {
            transition: all 0.2s ease;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .action-btn:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: scale(1.1);
        }

        /* Total count badge enhancement */
        .total-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced button styling */
        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        /* Responsive design */
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
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading skeleton animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .skeleton {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="dashboard-container">
        <div class="sidebar">
            <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="main-content">
            <div class="header sticky top-0 z-50">
                <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <main class="p-4 lg:p-8">
                <div class="mb-8 animate-[fadeInUp_0.6s_ease-out]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-2 bg-gradient-to-r from-blue-900 to-blue-600 bg-clip-text text-transparent">
                                Liste des étudiants
                            </h1>
                            <p class="text-gray-600 text-lg">Gérez et consultez les informations des étudiants</p>
                        </div>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary text-white px-8 py-4 rounded-2xl flex items-center justify-center gap-3 font-semibold text-base">
                            <i class="fas fa-plus text-lg"></i>
                            <span>Nouvel étudiant</span>
                        </a>
                    </div>
                    
                    <div class="search-container rounded-3xl p-8 mb-8 shadow-2xl animate-[fadeInUp_0.8s_ease-out]">
                        <form method="get" id="searchForm" onsubmit="return false;" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label for="searchInput" class="block text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                        <i class="fas fa-search"></i>
                                        <span>Rechercher des étudiants</span>
                                    </label>
                                    <input type="text" 
                                           name="q" 
                                           id="searchInput" 
                                           placeholder="Nom, prénom, matricule, email..." 
                                           class="modern-input w-full px-5 py-4 rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-400 font-medium"
                                           autocomplete="off" />
                                </div>
                                <div>
                                    <label for="year_level_id" class="block text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>Niveau d'étude</span>
                                    </label>
                                    <?php
                                        $yearLevels = collect($studentsArray)
                                            ->map(function($s){
                                                return [
                                                    'id' => $s['year_level_id'] ?? null,
                                                    'label' => $s['year_level_label'] ?? null,
                                                ];
                                            })
                                            ->unique('id')
                                            ->filter(function($y){ return !empty($y['id']); })
                                            ->values();
                                    ?>
                                    <select name="year_level_id" 
                                            id="year_level_id" 
                                            class="modern-select modern-input w-full px-5 py-4 rounded-xl border-0 focus:ring-0 text-gray-900 appearance-none font-medium">
                                        <option value="">Tous les niveaux</option>
                                        <?php $__currentLoopData = $yearLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($yl['id']); ?>"><?php echo e($yl['label']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            <?php $uniqueCount = collect($studentsArray)->unique('id')->count(); ?>
                            <div class="flex items-center justify-end mt-6">
                                <div class="total-badge px-8 py-4 rounded-2xl text-right">
                                    <div class="text-sm text-white font-semibold uppercase tracking-wider opacity-90 mb-1">Total des étudiants</div>
                                    <div id="totalCountAllContainer" class="text-5xl font-extrabold text-white"><?php echo e($uniqueCount); ?></div>
                                    <div id="filteredCountBadge" class="text-sm text-gray-600"><br> Affichés : 0 / 0</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-container rounded-3xl overflow-hidden animate-[fadeInUp_1s_ease-out]">
                    <div class="overflow-x-auto">
                        <table class="min-w-full" id="studentsTable">
                            <thead class="bg-gradient-to-r from-blue-900 to-blue-700">
                                <tr>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-id-card text-blue-200"></i>
                                            <span>Matricule</span>
                                        </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user text-blue-200"></i>
                                            <span>Nom complet</span>
                                        </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-envelope text-blue-200"></i>
                                            <span>Email</span>
                                        </div>
                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        <?php
                                            function sort_link($label, $column) {
                                                $currentSort = request('sort', 'matricule');
                                                $currentDirection = request('direction', 'asc');
                                                $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                                                $icon = '';
                                                if ($currentSort === $column) {
                                                    $icon = $currentDirection === 'asc' ? '▲' : '▼';
                                                }
                                                $query = array_merge(request()->except(['sort', 'direction']), ['sort' => $column, 'direction' => $newDirection]);
                                                $url = url()->current() . '?' . http_build_query($query);
                                                return '<a href="' . $url . '" class="hover:underline flex items-center gap-2 text-white"><i class="fas fa-graduation-cap text-blue-200"></i><span>' . $label . '</span><span class="ml-2 text-xs">' . $icon . '</span></a>';
                                            }
                                        ?>
                                        <?php echo sort_link("Niveau d'étude", 'annee_etude'); ?>

                                    </th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-book text-blue-200"></i>
                                            <span>Mention</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100" id="studentsTableBody">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">>
                    <div id="pagination" class="flex justify-center items-center mt-0"></div>
                </div>

                <script>
                    function getInitials(prenom, nom) {
                        const prenomInitial = prenom ? prenom.charAt(0) : '';
                        const nomInitial = nom ? nom.charAt(0) : '';
                        return (prenomInitial + nomInitial) || '?';
                    }

                    let rawStudents = <?php echo json_encode($studentsArray, 15, 512) ?>;
                    const students = rawStudents.filter((student, index, self) => 
                        index === self.findIndex(s => s.id === student.id)
                    );
                    const mentions = <?php echo json_encode($mentions, 15, 512) ?>;

                    let currentPage = 1;
                    const pageSize = 15;
                    let filteredStudents = [...students];

                    function filterStudents() {
                        const qInput = document.getElementById('searchInput');
                        const q = (qInput && qInput.value) ? qInput.value.toLowerCase() : '';
                        const yearLevelSelect = document.getElementById('year_level_id');
                        const selectedYear = yearLevelSelect ? String(yearLevelSelect.value) : '';

                        filteredStudents = students.filter(student => {
                            const matricule = (student.matricule || '').toString().toLowerCase();
                            const nom = (student.nom || '').toString().toLowerCase();
                            const prenom = (student.prenom || '').toString().toLowerCase();
                            const email = (student.email || '').toString().toLowerCase();
                            const matchesQuery = !q || (
                                matricule.includes(q) ||
                                nom.includes(q) ||
                                prenom.includes(q) ||
                                email.includes(q)
                            );
                            const studentYear = (student.year_level_id || '').toString();
                            const matchesYear = !selectedYear || studentYear === selectedYear;
                            return matchesQuery && matchesYear;
                        });

                        currentPage = 1;
                        updateDisplay();
                    }
        
                    function renderTable(filteredStudents) {
                        const tbody = document.getElementById('studentsTableBody');
                        tbody.innerHTML = '';
        
                        if (filteredStudents.length === 0) {
                            tbody.innerHTML = `<tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mb-6">
                                            <i class="fas fa-users text-5xl text-blue-400"></i>
                                        </div>
                                        <p class="text-gray-700 text-xl font-semibold mb-2">Aucun étudiant trouvé</p>
                                        <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
                                    </div>
                                </td>
                            </tr>`;
                            return;
                        }
                        
                        filteredStudents.forEach(student => {
                            const tr = document.createElement('tr');
                            tr.className = "table-row cursor-pointer";
                            tr.onclick = () => window.location = `/dean/students/${student.id}`;
                            tr.innerHTML = `
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="matricule-badge text-sm font-mono font-semibold text-blue-700 px-3 py-2 rounded-lg">${student.matricule}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="avatar-container w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base">
                                            ${getInitials(student.prenom, student.nom)}
                                        </div>
                                        <div>
                                            <div class="text-base font-semibold text-gray-900">${student.prenom ? student.prenom + ' ' : ''}${student.nom || ''}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                        <span class="text-sm font-medium">${student.email}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="badge inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-green-700">
                                        <i class="fas fa-graduation-cap text-green-600"></i>
                                        ${student.year_level_label ?? '-'}
                                    </span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-700">${student.mention_nom}</span>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }

                    let searchTimeout;
                    document.getElementById('searchInput').addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(filterStudents, 300);
                    });
                    
                    const yearLevelSelect = document.getElementById('year_level_id');
                    if (yearLevelSelect) {
                        yearLevelSelect.addEventListener('change', filterStudents);
                    }

                    function renderPagination() {
                        const paginationContainer = document.getElementById('pagination');
                        if (!paginationContainer) return;

                        const totalPages = Math.max(1, Math.ceil(filteredStudents.length / pageSize));
                        if (totalPages <= 1) {
                            paginationContainer.innerHTML = '';
                            return;
                        }

                        let paginationHTML = '<div class="flex items-center justify-center gap-3 flex-wrap">';
                        
                        // Previous button
                        paginationHTML += `
                            <button onclick="goToPage(${currentPage - 1})" 
                                    ${currentPage === 1 ? 'disabled' : ''} 
                                    class="pagination-btn px-5 py-3 rounded-xl border-2 ${currentPage === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200' : 'bg-white text-blue-700 hover:bg-blue-50 border-blue-200'} font-semibold">
                                <i class="fas fa-chevron-left"></i>
                            </button>`;

                        const maxVisiblePages = 7;
                        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                        if (endPage - startPage < maxVisiblePages - 1) {
                            startPage = Math.max(1, endPage - maxVisiblePages + 1);
                        }

                        if (startPage > 1) {
                            paginationHTML += `
                                <button onclick="goToPage(1)" 
                                        class="pagination-btn px-5 py-3 rounded-xl border-2 bg-white text-blue-700 hover:bg-blue-50 border-blue-200 font-semibold">1</button>`;
                            if (startPage > 2) paginationHTML += '<span class="px-2 text-gray-400 font-bold">...</span>';
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            paginationHTML += `
                                <button onclick="goToPage(${i})" 
                                        class="pagination-btn px-5 py-3 rounded-xl border-2 ${i === currentPage ? 'active text-white border-blue-600' : 'bg-white text-blue-700 hover:bg-blue-50 border-blue-200'} font-semibold">${i}</button>`;
                        }

                        if (endPage < totalPages) {
                            if (endPage < totalPages - 1) paginationHTML += '<span class="px-2 text-gray-400 font-bold">...</span>';
                            paginationHTML += `
                                <button onclick="goToPage(${totalPages})" 
                                        class="pagination-btn px-5 py-3 rounded-xl border-2 bg-white text-blue-700 hover:bg-blue-50 border-blue-200 font-semibold">${totalPages}</button>`;
                        }

                        // Next button
                        paginationHTML += `
                            <button onclick="goToPage(${currentPage + 1})" 
                                    ${currentPage === totalPages ? 'disabled' : ''} 
                                    class="pagination-btn px-5 py-3 rounded-xl border-2 ${currentPage === totalPages ? 'bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200' : 'bg-white text-blue-700 hover:bg-blue-50 border-blue-200'} font-semibold">
                                <i class="fas fa-chevron-right"></i>
                            </button>`;

                        paginationHTML += '</div>';

                        const startResult = (currentPage - 1) * pageSize + 1;
                        const endResult = Math.min(currentPage * pageSize, filteredStudents.length);
                        paginationHTML += `
                            <div class="text-center mt-6 text-base text-gray-600">
                                Affichage de <span class="font-bold text-blue-700">${startResult}</span> à 
                                <span class="font-bold text-blue-700">${endResult}</span> sur 
                                <span class="font-bold text-blue-700">${filteredStudents.length}</span> étudiants
                            </div>`;

                        paginationContainer.innerHTML = paginationHTML;
                    }

                    function goToPage(page) {
                        const totalPages = Math.max(1, Math.ceil(filteredStudents.length / pageSize));
                        if (page < 1 || page > totalPages) return;
                        currentPage = page;
                        updateDisplay();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }

                    function updateDisplay() {
                        const startIndex = (currentPage - 1) * pageSize;
                        const endIndex = startIndex + pageSize;
                        const studentsToDisplay = filteredStudents.slice(startIndex, endIndex);
                            renderTable(studentsToDisplay);
                            renderPagination();
                            // Update filtered / displayed badge
                            const filteredBadge = document.getElementById('filteredCountBadge');
                            if (filteredBadge) {
                                const displayedCount = studentsToDisplay.length;
                                const filteredTotal = filteredStudents.length;
                                filteredBadge.textContent = `Affichés : ${displayedCount} / ${filteredTotal}`;
                            }
                    }

                    filteredStudents = [...students];
                    updateDisplay();
                </script>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            }
        });
    </script>
</body>
</html><?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/students/index.blade.php ENDPATH**/ ?>