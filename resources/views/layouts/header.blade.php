<nav class="fixed top-0 w-full bg-blue-800/95 backdrop-blur-sm border-b border-blue-700 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et titre -->
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-university text-blue-800 text-lg"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wide">REGISTRAIRE</h1>
                    </div>
                </div>
            </div>

            <!-- Navigation desktop -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-6">
                    <a href="/" class="text-blue-100 hover:text-white px-3 py-2 text-sm font-medium transition-all duration-200 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="#programmes" class="text-blue-100 hover:text-white px-3 py-2 text-sm font-medium transition-all duration-200 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-book mr-2"></i>Programmes
                    </a>
                    <a href="#campus" class="text-blue-100 hover:text-white px-3 py-2 text-sm font-medium transition-all duration-200 hover:bg-blue-700 rounded-lg">
                        <i class="fas fa-building mr-2"></i>Campus
                    </a>
                    <a href="#admissions" class="bg-white text-blue-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-50 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-2"></i>Admissions
                    </a>
                </div>
            </div>

            <!-- Actions utilisateur et menu mobile -->
            <div class="flex items-center space-x-4">
                <!-- Barre de recherche (desktop uniquement) -->
                <div class="hidden lg:block">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher..." 
                               class="bg-blue-700/50 text-white placeholder-blue-200 px-4 py-2 pl-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-white/20 focus:bg-blue-700/70 transition-all duration-200 w-64">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-200"></i>
                    </div>
                </div>

                <!-- Notifications -->
                <button class="relative p-2 text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition-all duration-200">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>

                <!-- Profil utilisateur -->
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-2 p-2 text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition-all duration-200">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-800 text-sm"></i>
                        </div>
                        <span class="hidden sm:block text-sm font-medium">Admin</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <!-- Menu déroulant utilisateur -->
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <a href="#profile" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                            <i class="fas fa-user-circle mr-3"></i>Mon Profil
                        </a>
                        <a href="#settings" class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                            <i class="fas fa-cog mr-3"></i>Paramètres
                        </a>
                        <hr class="my-2 border-gray-200">
                        <a href="#logout" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt mr-3"></i>Déconnexion
                        </a>
                    </div>
                </div>

                <!-- Bouton menu mobile -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition-all duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="hidden md:hidden bg-blue-800 border-t border-blue-700">
        <div class="px-4 py-4 space-y-2">
            <!-- Barre de recherche mobile -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" placeholder="Rechercher..." 
                           class="w-full bg-blue-700/50 text-white placeholder-blue-200 px-4 py-2 pl-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-white/20 focus:bg-blue-700/70 transition-all duration-200">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-200"></i>
                </div>
            </div>
            
            <!-- Navigation mobile -->
            <a href="/" class="flex items-center text-blue-100 hover:text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition-all duration-200">
                <i class="fas fa-home mr-3"></i>Accueil
            </a>
            <a href="#programmes" class="flex items-center text-blue-100 hover:text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition-all duration-200">
                <i class="fas fa-book mr-3"></i>Programmes
            </a>
            <a href="#campus" class="flex items-center text-blue-100 hover:text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition-all duration-200">
                <i class="fas fa-building mr-3"></i>Campus
            </a>
            <a href="#admissions" class="flex items-center bg-white text-blue-800 hover:bg-blue-50 px-3 py-3 rounded-lg text-base font-semibold transition-all duration-200 mt-2">
                <i class="fas fa-user-plus mr-3"></i>Admissions
            </a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    }

    function toggleUserMenu() {
        const userMenu = document.getElementById('userMenu');
        userMenu.classList.toggle('hidden');
    }

    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('userMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (!event.target.closest('[onclick="toggleUserMenu()"]') && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
        
        if (!event.target.closest('[onclick="toggleMobileMenu()"]') && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.getElementById('mobileMenu').classList.add('hidden');
        }
    });
</script>
