<!-- Updated header for admin dashboard with enhanced functionality and notifications -->
<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left section: Sidebar toggle and title -->
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="md:hidden p-2 text-gray-500 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-semibold text-gray-900 hidden sm:block">Tableau de bord | chef comptable</h1>
                <h1 class="text-lg font-semibold text-gray-900 sm:hidden">Chef comptable</h1>
            </div>
        </div>
        
        <!-- Right section: Search, notifications, and user menu -->
        <div class="flex items-center space-x-4">
            
            <!-- User menu -->
            <div class="relative">
                <button id="userMenuBtn" class="flex items-center space-x-2 p-2 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <div class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center text-white font-semibold text-sm">
                        <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name ?? 'Dean'); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e(auth()->user()->role); ?></p>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block"></i>
                </button>
                
                <!-- User dropdown -->
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-90 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center text-white font-semibold">
                                <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name ?? 'Dean'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e(auth()->user()->email ?? 'dean@zurcher.edu.mg'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <a href="#profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                            <i class="fas fa-user-circle mr-3 w-4"></i>Mon Profil
                        </a>
                        <a href="#settings" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                            <i class="fas fa-cog mr-3 w-4"></i>Paramètres
                        </a>
                        <a href="#help" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                            <i class="fas fa-question-circle mr-3 w-4"></i>Aide
                        </a>
                        <hr class="my-2 border-gray-200">
                        <a href="<?php echo e(route('logout')); ?>"
                            class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-3 w-4"></i>Déconnexion
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile search toggle -->
            <button id="mobileSearchBtn" class="lg:hidden p-2 text-gray-500 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                <i class="fas fa-search text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Mobile search bar -->
    <div id="mobileSearch" class="hidden lg:hidden border-t border-gray-200 p-4">
        <div class="relative">
            <input type="text" 
                   placeholder="Rechercher des étudiants, cours..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all duration-200 text-sm">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle functionality
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (toggleBtn && sidebar && mainContent) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
        });
    }

    // Notification dropdown
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    
    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            // Close user dropdown if open
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) userDropdown.classList.add('hidden');
        });
    }

    // User menu dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
            // Close notification dropdown if open
            if (notificationDropdown) notificationDropdown.classList.add('hidden');
        });
    }

    // Mobile search toggle
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearch = document.getElementById('mobileSearch');
    
    if (mobileSearchBtn && mobileSearch) {
        mobileSearchBtn.addEventListener('click', function() {
            mobileSearch.classList.toggle('hidden');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (notificationDropdown && !notificationDropdown.contains(event.target) && !notificationBtn.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
        if (userDropdown && !userDropdown.contains(event.target) && !userMenuBtn.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
    });

    // Close mobile search on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024 && mobileSearch) {
            mobileSearch.classList.add('hidden');
        }
    });
});
</script>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/chief_accountant/components/header.blade.php ENDPATH**/ ?>