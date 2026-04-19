<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'rol',
        'activo',
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Campos adicionales
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    // 🔹 RELACIONES
    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'user_id');
    }

    // 🔹 HELPERS DE ROL
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function isEnfermero(): bool
    {
        return $this->rol === 'enfermero';
    }

    // 🔹 ACCESSOR
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->name} {$this->apellidos}";
    }
}