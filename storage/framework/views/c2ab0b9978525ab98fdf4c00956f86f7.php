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
                <p class="text-sm text-blue-200/80 font-medium">Chef de mention</p>
            </div>
        </div>
    </div>

    <!-- Enhanced navigation with modern styling and better hover effects -->
    <nav class="p-4 flex-1 overflow-y-auto">
        <ul class="space-y-1">
            <li>
                <?php $dashboardActive = request()->routeIs('chief.accountant.dashboard'); ?>
                <a href="<?php echo e(route('chief.accountant.dashboard')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e($dashboardActive ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>"
                   <?php echo e($dashboardActive ? 'aria-current="page"' : ''); ?>>
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Tableau de bord</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e($dashboardActive ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <?php $studentsActive = request()->routeIs('dean.students.*'); ?>
                <a href="<?php echo e(route('dean.students.index')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e($studentsActive ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>"
                   <?php echo e($studentsActive ? 'aria-current="page"' : ''); ?>>
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Étudiants</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e($studentsActive ? 'opacity-100' : ''); ?>"></div>
                </a>
            </li>
            <li>
                <?php $settingsActive = request()->routeIs('dean.settings') || request()->routeIs('dean.settings.update'); ?>
                <a href="<?php echo e(route('dean.settings')); ?>"
                   class="nav-item group flex items-center space-x-3 p-3 rounded-xl transition-all duration-200 hover:bg-blue-700/50 hover:translate-x-1 <?php echo e($settingsActive ? 'bg-blue-900/80 text-blue-100 shadow-lg' : 'hover:text-blue-100'); ?>"
                   <?php echo e($settingsActive ? 'aria-current="page"' : ''); ?>>
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="fas fa-cog text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    </div>
                    <span class="font-medium">Paramètres</span>
                    <div class="ml-auto w-1 h-6 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 <?php echo e($settingsActive ? 'opacity-100' : ''); ?>"></div>
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
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/chief_accountant/components/sidebar.blade.php ENDPATH**/ ?>