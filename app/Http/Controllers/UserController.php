<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        // Appliquer l'authentification à toutes les méthodes
        $this->middleware('auth');
        
        // Restrictions spécifiques par rôle
        $this->middleware('superadmin')->only(['destroy']);
        $this->middleware('admin')->except(['show', 'edit', 'update', 'profile']);
        
        // Middleware pour l'édition (seul l'utilisateur ou admin peut éditer)
        $this->middleware(function ($request, $next) {
            if ($request->route('user')) {
                $user = User::findOrFail($request->route('user'));
                if (!Gate::allows('update-user', $user)) {
                    abort(403, 'Accès non autorisé');
                }
            }
            return $next($request);
        })->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        
        // Filtrer selon les permissions
        if (auth()->user()->isSuperAdmin()) {
            // SuperAdmin voit tous les utilisateurs
            $users = User::orderBy('name')->get();
        } elseif (auth()->user()->isAdmin()) {
            // Admin voit tous sauf les superadmins
            $users = User::where('role', '!=', 'superadmin')
                        ->orderBy('name')
                        ->get();
        } else {
            // Les autres voient seulement leur propre profil
            $users = collect([auth()->user()]);
        }
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->getAvailableRoles();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:' . implode(',', $this->getAllowedRoles()),
            'plain_password' => 'sometimes|string|nullable',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'plain_password' => $validated['plain_password'] ?? $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        // Vérifier les permissions
        if (!Gate::allows('view-user', $user)) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = $this->getAvailableRoles();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ];
        
        // Seul SuperAdmin peut changer le rôle
        if (auth()->user()->isSuperAdmin()) {
            $validationRules['role'] = 'required|in:' . implode(',', $this->getAllowedRoles());
        }
        
        // Validation conditionnelle pour le mot de passe
        if ($request->filled('password')) {
            $validationRules['password'] = 'min:8|confirmed';
        }
        
        $validated = $request->validate($validationRules);
        
        // Préparation des données
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        
        // Mise à jour du rôle (seulement pour SuperAdmin)
        if (auth()->user()->isSuperAdmin() && isset($validated['role'])) {
            $data['role'] = $validated['role'];
        }
        
        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
            $data['plain_password'] = $validated['password'];
        }
        
        $user->update($data);
        
        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Empêcher l'auto-suppression
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur supprimé avec succès');
    }

    /**
     * Afficher le profil de l'utilisateur connecté
     */
    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    /**
     * Mettre à jour le profil de l'utilisateur connecté
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($request->password),
                'plain_password' => $request->password,
            ]);
        } else {
            $user->update($validated);
        }
        
        return redirect()->route('profile')
                         ->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Obtenir les rôles disponibles selon le rôle de l'utilisateur connecté
     */
    private function getAvailableRoles(): array
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return ['superadmin', 'admin', 'employe', 'teacher', 'student', 'parent'];
        }
        
        if ($user->isAdmin()) {
            return ['admin', 'employe', 'teacher', 'student', 'parent'];
        }
        
        return [];
    }

    /**
     * Obtenir tous les rôles autorisés pour validation
     */
    private function getAllowedRoles(): array
    {
        return ['superadmin', 'admin', 'employe', 'teacher', 'student', 'parent'];
    }
}