<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => \App\Policies\UserPolicy::class,
        // Ajoutez d'autres modèles et policies ici si nécessaire
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Définition des gates (permissions) basées sur les rôles
        Gate::define('superadmin', function (User $user) {
            return $user->isSuperAdmin();
        });

        Gate::define('admin', function (User $user) {
            return $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('employe', function (User $user) {
            return $user->isEmploye() || $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('teacher', function (User $user) {
            return $user->isTeacher() || $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('student', function (User $user) {
            return $user->isStudent() || $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('parent', function (User $user) {
            return $user->isParent() || $user->isAdmin() || $user->isSuperAdmin();
        });

        // Gates spécifiques pour les opérations utilisateur
        Gate::define('view-user', function (User $user, User $model) {
            return $user->id === $model->id || $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('update-user', function (User $user, User $model) {
            return $user->id === $model->id || $user->isAdmin() || $user->isSuperAdmin();
        });

        Gate::define('delete-user', function (User $user, User $model) {
            // Empêcher l'auto-suppression
            if ($user->id === $model->id) {
                return false;
            }
            return $user->isSuperAdmin();
        });

        // Gate pour la gestion des utilisateurs (création, listing)
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin() || $user->isSuperAdmin();
        });

        // Gate pour la gestion complète (superadmin seulement)
        Gate::define('manage-all', function (User $user) {
            return $user->isSuperAdmin();
        });
    }
}