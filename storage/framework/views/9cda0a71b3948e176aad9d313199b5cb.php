<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cours - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Updated fonts to match user list design -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?php echo e(url('public/favicon.png')); ?>" type="image/png">
    <style>
        <!-- Updated typography and added modern animations -->
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Work Sans', sans-serif; }
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
        
        <!-- Added modern course card animations and hover effects -->
        .course-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }
        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .credit-badge {
            transition: all 0.2s ease;
        }
        .credit-badge:hover {
            transform: scale(1.05);
        }
        .action-btn {
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        <!-- Added responsive design for mobile cards -->
        @media (max-width: 768px) {
            .desktop-table { display: none; }
            .mobile-cards { display: block; }
        }
        @media (min-width: 769px) {
            .desktop-table { display: table; }
            .mobile-cards { display: none; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 md:p-6 lg:p-8">
            <!-- Enhanced header with gradient background and search functionality -->
            <div class="search-container rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Liste des cours</h1>
                        <p class="text-blue-100">Gérez les cours de votre université</p>
                        <p class="text-blue-100 text-sm mt-2">Total des cours: <span id="totalCourses"><?php echo e($courses->count()); ?></span>
                            — Affichés: <span id="visibleCount"><?php echo e($courses->count()); ?></span>
                        </p>
                    </div>
                    
                </div>
                
                <!-- Added search and filter functionality -->
                <div class="mt-6 flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher par sigle ou nom du cours..." 
                                   class="w-full px-4 py-3 pl-12 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/30">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop table with modern styling -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden desktop-table">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-blue-800 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider" data-sort="sigle" data-direction="asc">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-code text-blue-200"></i>
                                    Sigle
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-book text-blue-200"></i>
                                    Nom du cours
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-star text-blue-200"></i>
                                    Crédits
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chalkboard-teacher text-blue-200"></i>
                                    Professeur
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-blue-200"></i>
                                    Catégorie
                                </div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="courseTableBody">
                        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="cursor-pointer course-card hover:bg-blue-50/50 transition-all duration-300" onclick="window.location='<?php echo e(route('dean.courses.show', $course->id)); ?>'"> 
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold mr-4">
                                            <?php echo e(strtoupper(substr($course->sigle, 0, 2))); ?>

                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900"><?php echo e($course->sigle); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($course->nom); ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="credit-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo e($course->credits); ?> crédits
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-600"><?php echo e($course->teacher->name ?? 'Non attribué'); ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <?php echo e($course->categorie); ?>

                                    </span>
                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-book text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucun cours trouvé</p>
                                        <p class="text-sm">Commencez par ajouter votre premier cours</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Added mobile cards layout -->
            <div class="mobile-cards space-y-4" id="mobileCourseCards">
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="course-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100" 
                         data-sigle="<?php echo e(strtolower($course->sigle)); ?>" 
                         data-nom="<?php echo e(strtolower($course->nom)); ?>" 
                         data-mention="<?php echo e(strtolower($course->mentions && $course->mentions->count() ? $course->mentions->pluck('nom')->join(', ') : ($course->mention->nom ?? ''))); ?>">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    <?php echo e(strtoupper(substr($course->sigle, 0, 2))); ?>

                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-lg"><?php echo e($course->sigle); ?></h3>
                                    <p class="text-gray-600 text-sm"><?php echo e($course->nom); ?></p>
                                </div>
                            </div>
                            <span class="credit-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e($course->credits); ?> crédits
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Professeur</p>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($course->teacher->name ?? 'Non attribué'); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Mention</p>
                                <?php if($course->mention): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <?php if(isset($course->mentions) && $course->mentions->count()): ?>
                                            <?php echo e($course->mentions->pluck('nom')->join(', ')); ?>

                                        <?php else: ?>
                                            <?php echo e($course->mention->nom ?? 'Mention non définie'); ?>

                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">-</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Catégorie</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <?php echo e($course->categorie); ?>

                                </span>
                            </div>
                        </div>
                        
                        
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <div class="text-gray-400">
                            <i class="fas fa-book text-6xl mb-6"></i>
                            <h3 class="text-xl font-semibold mb-2">Aucun cours trouvé</h3>
                            <p class="text-gray-500">Commencez par ajouter votre premier cours</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Added JavaScript for search and filter functionality -->
    <script>
        function filterCourses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const mentionFilter = document.getElementById('mentionFilter') ? document.getElementById('mentionFilter').value.toLowerCase() : '';

            // Desktop table
            const tableRows = document.querySelectorAll('#courseTableBody tr');
            tableRows.forEach(row => {
                // Récupère les valeurs à partir du contenu des cellules
                const sigle = (row.querySelector('td:nth-child(1) .text-sm.font-semibold')?.textContent || '').toLowerCase();
                const nom = (row.querySelector('td:nth-child(2) .text-sm.font-medium')?.textContent || '').toLowerCase();
                const mention = (row.querySelector('td:nth-child(5) span')?.textContent || '').toLowerCase();

                const matchesSearch = sigle.includes(searchTerm) || nom.includes(searchTerm);
                const matchesMention = !mentionFilter || mention === mentionFilter;

                if (matchesSearch && matchesMention) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Mobile cards
            const mobileCards = document.querySelectorAll('#mobileCourseCards .course-card');
            mobileCards.forEach(card => {
                const sigle = (card.querySelector('h3')?.textContent || '').toLowerCase();
                const nom = (card.querySelector('p.text-gray-600')?.textContent || '').toLowerCase();
                const mention = (card.querySelector('span.bg-purple-100')?.textContent || '').toLowerCase();

                const matchesSearch = sigle.includes(searchTerm) || nom.includes(searchTerm);
                const matchesMention = !mentionFilter || mention === mentionFilter;

                if (matchesSearch && matchesMention) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            if (document.getElementById('mentionFilter')) document.getElementById('mentionFilter').value = '';
            filterCourses();
        }

        document.getElementById('searchInput').addEventListener('input', filterCourses);
        if (document.getElementById('mentionFilter')) {
            document.getElementById('mentionFilter').addEventListener('change', filterCourses);
        }

        document.addEventListener('DOMContentLoaded', function() {
            filterCourses();
        });

        // --- SORTING ---
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.style.cursor = 'pointer';
            th.addEventListener('click', function() {
                const sortKey = th.getAttribute('data-sort');
                const tableBody = document.getElementById('courseTableBody');
                const rows = Array.from(tableBody.querySelectorAll('tr[data-sigle]'));
                const direction = th.getAttribute('data-direction') === 'desc' ? 'asc' : 'desc';
                th.setAttribute('data-direction', direction);

                rows.sort((a, b) => {
                    let aVal = (a.getAttribute('data-' + sortKey) || '').toLowerCase();
                    let bVal = (b.getAttribute('data-' + sortKey) || '').toLowerCase();
                    if (aVal < bVal) return direction === 'asc' ? -1 : 1;
                    if (aVal > bVal) return direction === 'asc' ? 1 : -1;
                    return 0;
                });

                rows.forEach(row => tableBody.appendChild(row));
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
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/courses/list.blade.php ENDPATH**/ ?>