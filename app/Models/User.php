<?php

namespace App\Models;

use App\Enums\Role;
use App\Models\FMS\Settings as FmsSettings;
use App\Models\FMS\Transaction as FmsTransaction;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(Usermeta::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role == Role::Administrator;
    }

    public function isEditor(): bool
    {
        return $this->role == Role::Editor;
    }

    public function isAuthor(): bool
    {
        return $this->role == Role::Author;
    }

    public function fmsSettings(): HasOne
    {
        return $this->hasOne(FmsSettings::class);
    }

    public function fmsTransactions(): HasMany
    {
        return $this->hasMany(FmsTransaction::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }
}
