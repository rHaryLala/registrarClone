<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
        'role',
        'mention_id',
        'lang',
        'notif_email',
        'notif_sms',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Méthodes de vérification des rôles
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isDean(): bool
    {
        return $this->role === 'dean';
    }

    public function isEmploye(): bool
    {
        return $this->role === 'employe';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    public function isChiefAccountant(): bool
    {
        return $this->role === 'chief_accountant';
    }

    public function isMultimedia(): bool
    {
        return $this->role === 'responsable_multimedia' || $this->role === 'multimedia';
    }

    // Vérification d'accès multiple
    public function hasRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }
}
