<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Doyen - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
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

        /* Enhanced card styles with better shadows and hover effects */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Improved registration item styles */
        .registration-item {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
            border: 1px solid rgba(226, 232, 240, 0.6);
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out forwards;
            animation-delay: calc(var(--item-index) * 0.1s);
            opacity: 0;
        }

        .registration-item:hover {
            background: linear-gradient(135deg, rgba(239, 246, 255, 0.9) 0%, rgba(219, 234, 254, 0.9) 100%);
            transform: translateX(8px);
            border-color: rgba(59, 130, 246, 0.3);
        }

        /* Enhanced icon containers */
        .icon-container {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.2) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .avatar-container {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.2) 100%);
            border: 2px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
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
        <!-- Sidebar -->
        <div class="sidebar">
            <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header sticky top-0 z-50">
                <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

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
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Desktop table with improved styling -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
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
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100" id="studentsTableBody">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="pagination" class="flex justify-center items-center mt-6"></div>

                <script>
                    // Add helper function at the top of the script section
                    function getInitials(prenom, nom) {
                        const prenomInitial = prenom ? prenom.charAt(0) : '';
                        const nomInitial = nom ? nom.charAt(0) : '';
                        return (prenomInitial + nomInitial) || '?';
                    }

                    // Charger tous les étudiants dans une variable JS avec déduplication
                    let rawStudents = <?php echo json_encode($studentsArray, 15, 512) ?>;
                    
                    // Remove duplicates based on student ID
                    const students = rawStudents.filter((student, index, self) => 
                        index === self.findIndex(s => s.id === student.id)
                    );
                    
                    const mentions = <?php echo json_encode($mentions, 15, 512) ?>;
        
                    function filterStudents() {
                        const q = document.getElementById('searchInput').value.toLowerCase();
                        let filtered = students.filter(student => {
                            // Remove mention filtering since dean can only see their mention
                            return !q || (
                                student.matricule.toLowerCase().includes(q) ||
                                student.nom.toLowerCase().includes(q) ||
                                student.prenom.toLowerCase().includes(q) ||
                                student.email.toLowerCase().includes(q)
                            );
                        });
                        renderTable(filtered);
                    }
        
                    function renderTable(filteredStudents) {
                        const tbody = document.getElementById('studentsTableBody');
                        tbody.innerHTML = '';
        
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
                            return;
                        }
                        
                        filteredStudents.forEach(student => {
                            const tr = document.createElement('tr');
                            tr.className = "hover:bg-blue-50 transition-colors duration-200 cursor-pointer";
                            tr.onclick = () => window.location = `/dean/students/${student.id}`;
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
                            `;
                            tbody.appendChild(tr);
                        });
                    }

                    let searchTimeout;
                    document.getElementById('searchInput').addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(filterStudents, 300);
                    });

                    console.log(`[v0] Loaded ${students.length} unique students (filtered from ${rawStudents.length} raw entries)`);

                    // Initial render
                    renderTable(students);
                </script>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate numbers
            const counters = document.querySelectorAll('.number-counter');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            });

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
</body>
</html>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate numbers
            const counters = document.querySelectorAll('.number-counter');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            });

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
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/students/index.blade.php ENDPATH**/ ?>