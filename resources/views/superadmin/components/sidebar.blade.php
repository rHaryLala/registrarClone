<div class="sidebar fixed inset-y-0 left-0 bg-blue-800 text-white z-50">
    <div class="p-4 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg overflow-hidden">
                <img src="https://yt3.googleusercontent.com/ytc/AGIKgqMrYnDBtikTA3sE31ur77qAnb56zLrCpKXqfFCB=s900-c-k-c0x00ffffff-no-rj"
                     alt="Logo UAZ" class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="font-bold">REGISTRAR Admin</h2>
                <p class="text-xs text-blue-200">Super Admin</p>
            </div>
        </div>
    </div>

    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('superadmin.dashboard') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.users.list') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.users.*') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.students.list') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.students.*') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-graduation-cap w-5"></i>
                    <span>Étudiants</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.mentions.list') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.mentions.*') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-certificate w-5"></i>
                    <span>Mentions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.teachers.list') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.teachers.*') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-chalkboard-teacher w-5"></i>
                    <span>Enseignants</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.courses.list') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.courses.*') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-book w-5"></i>
                    <span>Cours</span>
                </a>
            </li>
            <li>
                <a href="{{ route('superadmin.settings') }}"
                   class="nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('superadmin.settings') || request()->routeIs('superadmin.settings.update') ? 'bg-blue-900 text-blue-100' : '' }}">
                    <i class="fas fa-cog w-5"></i>
                    <span>Paramètres</span>
                </a>
            </li>
        </ul>

        <div class="mt-8 pt-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item flex items-center space-x-3 p-3 rounded-lg w-full text-left">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </nav>
</div>
