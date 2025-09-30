<div class="sidebar fixed inset-y-0 left-0 bg-blue-800 text-white z-50 shadow-2xl">
    <!-- Enhanced header with better spacing and modern styling -->
    <div class="p-6 border-b border-blue-700/50">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl overflow-hidden ring-2 ring-blue-600/30 transition-all duration-300 hover:ring-blue-500/50">
                <img src="https://yt3.googleusercontent.com/ytc/AGIKgqMrYnDBtikTA3sE31ur77qAnb56zLrCpKXqfFCB=s900-c-k-c0x00ffffff-no-rj"
                     alt="Logo UAZ" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <h2 class="font-bold text-lg text-white">REGISTRAR</h2>
                <p class="text-sm text-blue-200/80 font-medium">Super Admin</p>
            </div>
        </div>
    </div>

    <!-- Enhanced navigation with modern styling and better hover effects -->
    <nav class="p-4 flex-1 overflow-y-auto">
        <ul class="space-y-1">
            <li>
                <a href="<?php echo e(route('superadmin.dashboard')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.dashboard') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Tableau de bord</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.dashboard') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.users.list')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.users.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-users text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Utilisateurs</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.users.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.students.list')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.students.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Étudiants</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.students.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.mentions.list')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.mentions.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-certificate text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Mentions</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.mentions.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.teachers.list')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.teachers.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Enseignants</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.teachers.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.courses.list')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.courses.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-book text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Cours</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.courses.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.financedetails.index')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.finances.financedetails.*') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Détails Finances</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.finances.financedetails.*') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('superadmin.settings')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e(request()->routeIs('superadmin.settings') || request()->routeIs('superadmin.settings.update') ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-cog text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Paramètres</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e(request()->routeIs('superadmin.settings') || request()->routeIs('superadmin.settings.update') ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
        </ul>

        <!-- Enhanced logout section with modern styling -->
        <div class="mt-8 pt-6 border-t border-blue-700/50">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="cursor-pointer nav-item group flex items-center space-x-3 p-3 rounded-xl w-full text-left transition-all duration-200 hover:bg-red-600/20 hover:text-red-200 text-blue-200">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Déconnexion</span>
                    <div class="ml-auto">
                        <i class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                    </div>
                </button>
            </form>
        </div>
    </nav>
</div>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/components/sidebar.blade.php ENDPATH**/ ?>