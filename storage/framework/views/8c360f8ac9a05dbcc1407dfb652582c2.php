<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        
        /* Added modern animations and hover effects */
        .user-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }
        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .role-badge {
            transition: all 0.2s ease;
        }
        .role-badge:hover {
            transform: scale(1.05);
        }
        .action-btn {
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        /* Mobile responsive table cards */
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
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 md:p-6 lg:p-8">
            <!-- Enhanced header with gradient background and better typography -->
            <div class="search-container rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Liste des utilisateurs</h1>
                        <p class="text-blue-100">Gérez les utilisateurs de votre système</p>
                    </div>
                    <a href="<?php echo e(route('superadmin.users.create')); ?>" class="bg-white text-blue-800 px-6 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 flex items-center justify-center md:justify-start font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i> Nouvel utilisateur
                    </a>
                </div>
                
                <!-- Added search and filter functionality -->
                <div class="mt-6 flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher par nom ou email..." 
                                   class="w-full px-4 py-3 pl-12 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/30">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <select id="roleFilter" class="px-4 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-white/30">
                            <option value="">Tous les rôles</option>
                            <option value="admin">Admin</option>
                            <option value="user">Utilisateur</option>
                            <option value="moderator">Modérateur</option>
                        </select>
                        <button onclick="clearFilters()" class="px-4 py-3 bg-white/20 rounded-xl hover:bg-white/30 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desktop table with modern styling -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden desktop-table">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-blue-800 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user text-blue-200"></i>
                                    Nom
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-blue-200"></i>
                                    Email
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-blue-200"></i>
                                    Rôle
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cogs text-blue-200"></i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="userTableBody">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="user-card hover:bg-blue-50/50 transition-all duration-300" data-name="<?php echo e(strtolower($user->name)); ?>" data-email="<?php echo e(strtolower($user->email)); ?>" data-role="<?php echo e(strtolower($user->role)); ?>">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold mr-4">
                                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900"><?php echo e($user->name); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-600"><?php echo e($user->email); ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="role-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                                        <?php elseif($user->role === 'moderator'): ?> bg-yellow-100 text-yellow-800
                                        <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-3">
                                        <a href="<?php echo e(route('superadmin.users.edit', $user->id)); ?>" 
                                           class="action-btn bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition-all duration-200 flex items-center text-sm font-medium">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </a>
                                        <form action="<?php echo e(route('superadmin.users.destroy', $user->id)); ?>" method="POST" 
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="action-btn bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition-all duration-200 flex items-center text-sm font-medium">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-users text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucun utilisateur trouvé</p>
                                        <p class="text-sm">Commencez par ajouter votre premier utilisateur</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile cards layout -->
            <div class="mobile-cards space-y-4" id="mobileUserCards">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="user-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100" 
                         data-name="<?php echo e(strtolower($user->name)); ?>" data-email="<?php echo e(strtolower($user->email)); ?>" data-role="<?php echo e(strtolower($user->role)); ?>">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-lg"><?php echo e($user->name); ?></h3>
                                    <p class="text-gray-600 text-sm"><?php echo e($user->email); ?></p>
                                </div>
                            </div>
                            <span class="role-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                                <?php elseif($user->role === 'moderator'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </div>
                        
                        <div class="flex gap-3 pt-4 border-t border-gray-100">
                            <a href="<?php echo e(route('superadmin.users.edit', $user->id)); ?>" 
                               class="action-btn flex-1 bg-blue-100 text-blue-700 px-4 py-3 rounded-xl hover:bg-blue-200 transition-all duration-200 flex items-center justify-center font-medium">
                                <i class="fas fa-edit mr-2"></i> Modifier
                            </a>
                            <form action="<?php echo e(route('superadmin.users.destroy', $user->id)); ?>" method="POST" 
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="action-btn w-full bg-red-100 text-red-700 px-4 py-3 rounded-xl hover:bg-red-200 transition-all duration-200 flex items-center justify-center font-medium">
                                    <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <div class="text-gray-400">
                            <i class="fas fa-users text-6xl mb-6"></i>
                            <h3 class="text-xl font-semibold mb-2">Aucun utilisateur trouvé</h3>
                            <p class="text-gray-500">Commencez par ajouter votre premier utilisateur</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Added JavaScript for search and filter functionality -->
    <script>
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
            
            // Filter desktop table
            const tableRows = document.querySelectorAll('#userTableBody tr[data-name]');
            tableRows.forEach(row => {
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const role = row.getAttribute('data-role');
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !roleFilter || role === roleFilter;
                
                if (matchesSearch && matchesRole) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Filter mobile cards
            const mobileCards = document.querySelectorAll('#mobileUserCards .user-card[data-name]');
            mobileCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');
                const role = card.getAttribute('data-role');
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !roleFilter || role === roleFilter;
                
                if (matchesSearch && matchesRole) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('roleFilter').value = '';
            filterUsers();
        }
        
        // Event listeners
        document.getElementById('searchInput').addEventListener('input', filterUsers);
        document.getElementById('roleFilter').addEventListener('change', filterUsers);
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            filterUsers();
        });
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/users/list.blade.php ENDPATH**/ ?>