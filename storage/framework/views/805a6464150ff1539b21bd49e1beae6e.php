<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Work Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        
        /* Added modern card hover effects and animations */
        .student-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
        }
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }
        
        /* Enhanced search and filter styling */
        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        
        /* Mobile responsive table improvements */
        @media (max-width: 768px) {
            .desktop-table { display: none; }
            .mobile-cards { display: block; }
        }
        @media (min-width: 769px) {
            .desktop-table { display: block; }
            .mobile-cards { display: none; }
        }
        
        /* Modern button and input styling */
        .modern-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
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
    </style>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 lg:p-6">
            <!-- Enhanced header with better spacing and modern styling -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Liste des étudiants</h1>
                        <p class="text-gray-600">Gérez et consultez les informations des étudiants</p>
                    </div>
                    <a href="<?php echo e(route('register')); ?>" class="bg-blue-800 text-white px-6 py-3 rounded-xl hover:bg-blue-900 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i>
                        <span class="font-medium">Nouvel étudiant</span>
                    </a>
                </div>
                
                <!-- Modern search and filter section -->
                <div class="search-container rounded-2xl p-6 mb-6 shadow-lg">
                    <form method="get" id="searchForm" onsubmit="return false;" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label for="searchInput" class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-search mr-2"></i>Rechercher des étudiants
                                </label>
                                <input type="text" 
                                       name="q" 
                                       id="searchInput" 
                                       placeholder="Nom, prénom, matricule, email..." 
                                       class="modern-input w-full px-4 py-3 rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-500"
                                       autocomplete="off" />
                            </div>
                            <div>
                                <label for="mention_id" class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-filter mr-2"></i>Filtrer par mention
                                </label>
                                <select name="mention_id" 
                                        id="mention_id" 
                                        class="modern-select modern-input w-full px-4 py-3 rounded-xl border-0 focus:ring-0 text-gray-900 appearance-none">
                                    <option value="">Toutes les mentions</option>
                                    <?php $__currentLoopData = $mentions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mention): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($mention->id); ?>"><?php echo e($mention->nom); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label for="academic_year" class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-calendar mr-2"></i>Année académique
                                </label>
                                <?php
                                    // Load academic years from DB so the select matches the seeded table
                                    $academicYears = \App\Models\AcademicYear::orderByDesc('date_debut')->get();
                                ?>
                                <select name="academic_year" 
                                        id="academic_year" 
                                        class="modern-select modern-input w-full px-4 py-3 rounded-xl border-0 focus:ring-0 text-gray-900 appearance-none">
                                    <option value="">Toutes les années</option>
                                    <?php $__currentLoopData = $academicYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ay->libelle); ?>"><?php echo e($ay->libelle); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Desktop table with improved styling -->
            <div class="desktop-table bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full" id="studentsTable">
                        <thead class="bg-blue-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Matricule</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Nom complet</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
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
                                            return '<a href="' . $url . '" class="hover:underline flex items-center text-white">' . $label . ' <span class="ml-2 text-xs">' . $icon . '</span></a>';
                                        }
                                    ?>
                                    <?php echo sort_link("Niveau d'étude", 'annee_etude'); ?>

                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Mention</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100" id="studentsTableBody">
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile cards layout for better mobile experience -->
            <div class="mobile-cards space-y-4" id="mobileCards">
                
            </div>

            <div id="pagination" class="flex justify-center items-center mt-6"></div>

            <script>
                // Add helper function at the top of the script section
                function getInitials(prenom, nom) {
                    const prenomInitial = prenom ? prenom.charAt(0) : '';
                    const nomInitial = nom ? nom.charAt(0) : '';
                    return (prenomInitial + nomInitial) || '?';
                }

                // Charger tous les étudiants dans une variable JS
                const students = <?php echo json_encode($studentsArray, 15, 512) ?>;
                const mentions = <?php echo json_encode($mentionsArray, 15, 512) ?>;

                function renderTable(filteredStudents) {
                    const tbody = document.getElementById('studentsTableBody');
                    const mobileContainer = document.getElementById('mobileCards');
                    
                    // Clear both containers
                    tbody.innerHTML = '';
                    mobileContainer.innerHTML = '';
                    
                    if (filteredStudents.length === 0) {
                        tbody.innerHTML = `<tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p>
                                    <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>`;
                        mobileContainer.innerHTML = `
                            <div class="text-center py-12">
                                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p>
                                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
                            </div>`;
                        return;
                    }
                    
                    filteredStudents.forEach(student => {
                        // Desktop table row
                        const tr = document.createElement('tr');
                        tr.className = "hover:bg-blue-50 transition-colors duration-200 cursor-pointer";
                        tr.onclick = () => window.location = `/superadmin/students/${student.id}`;
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-blue-800 bg-blue-50 px-2 py-1 rounded">${student.matricule}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        ${getInitials(student.prenom, student.nom)}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">${student.prenom ? student.prenom + ' ' : ''}${student.nom || ''}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${student.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ${student.year_level_label ?? '-'}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${student.mention_nom}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="/superadmin/students/${student.id}" class="text-blue-600 hover:text-blue-800 transition-colors" onclick="event.stopPropagation();" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/superadmin/finances?student_id=${student.id}" class="text-green-600 hover:text-green-800 transition-colors" onclick="event.stopPropagation();" title="Finances">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                    <button onclick="deleteStudent(${student.id}); event.stopPropagation();" class="text-red-600 hover:text-red-800 transition-colors" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(tr);
                        
                        // Mobile card
                        const card = document.createElement('div');
                        card.className = "student-card bg-white rounded-xl p-6 shadow-md cursor-pointer";
                        card.onclick = () => window.location = `/superadmin/students/${student.id}`;
                        card.innerHTML = `
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white font-semibold mr-4">
                                        ${getInitials(student.prenom, student.nom)}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">${student.prenom ? student.prenom + ' ' : ''}${student.nom || ''}</h3>
                                        <p class="text-sm text-gray-600">${student.email}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-blue-800 bg-blue-50 px-2 py-1 rounded">${student.matricule}</span>
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
                                <a href="/superadmin/students/${student.id}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center text-sm" onclick="event.stopPropagation();">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                <a href="/superadmin/finances?student_id=${student.id}" class="text-green-600 hover:text-green-800 transition-colors flex items-center text-sm" onclick="event.stopPropagation();">
                                    <i class="fas fa-money-bill-wave mr-1"></i> Finances
                                </a>
                                <button onclick="deleteStudent(${student.id}); event.stopPropagation();" class="text-red-600 hover:text-red-800 transition-colors flex items-center text-sm">
                                    <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                </button>
                            </div>
                        `;
                        mobileContainer.appendChild(card);
                    });
                }

                function deleteStudent(studentId) {
                    if (confirm('Voulez-vous vraiment supprimer cet étudiant ? Cette action est irréversible.')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/superadmin/students/${studentId}`;
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                }

                // Supprimer la pagination
                // let currentPage = 1;
                // const pageSize = 10;

                function filterStudents() {
                    const q = document.getElementById('searchInput').value.toLowerCase();
                    const mentionId = document.getElementById('mention_id').value;
                    const academicYear = document.getElementById('academic_year').value;
                    
                    let filtered = students.filter(student => {
                        let matchMention = !mentionId || student.mention_id == mentionId;
                        // Normalize values for comparison
                        const studentAY = (student.academic_year || '').toString().trim();
                        const selectedAY = (academicYear || '').toString().trim();
                        let matchYear = !selectedAY || studentAY === selectedAY;
                        let matchSearch = !q || (
                            student.matricule.toLowerCase().includes(q) ||
                            student.nom.toLowerCase().includes(q) ||
                            student.prenom.toLowerCase().includes(q) ||
                            student.email.toLowerCase().includes(q) ||
                            student.mention_nom.toLowerCase().includes(q)
                        );
                        return matchMention && matchSearch && matchYear;
                    });
                    renderTable(filtered);
                }

                document.getElementById('searchInput').addEventListener('input', filterStudents);
                document.getElementById('mention_id').addEventListener('change', filterStudents);
                document.getElementById('academic_year').addEventListener('change', filterStudents);

                // Initial render
                renderTable(students);
            </script>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/students/list.blade.php ENDPATH**/ ?>