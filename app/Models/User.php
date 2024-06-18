<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == "ADMIN" || $this->role == "SUPERADMIN";
    }

    protected $fillable = [
        'name',
        'username',
        'avatar',
        'email',
        'password',
        'phone',
        'role',
    ];

    public static function role_types()
    {
        return ["USER", "ADMIN", "SUPERADMIN"];
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'users_id', 'id');
    }
}
