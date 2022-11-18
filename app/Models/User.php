<?php

namespace App\Models;

use App\Constant\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(Usermeta::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role == Role::Administrator->value;
    }

    public function isEditor(): bool
    {
        return $this->role == Role::Editor->value;
    }

    public function isAuthor(): bool
    {
        return $this->role == Role::Author->value;
    }
}
