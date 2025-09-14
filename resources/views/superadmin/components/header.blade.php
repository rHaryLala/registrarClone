<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
            <button id="sidebarToggle" class="md:hidden text-gray-500 mr-4">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-semibold text-gray-900">Tableau de bord SuperAdmin</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="text-gray-500">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                </button>
            </div>
            
            <div class="relative">
                <button class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="hidden md:block">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down hidden md:block"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn && sidebar && mainContent) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('active');
            });
        }
    });
</script>