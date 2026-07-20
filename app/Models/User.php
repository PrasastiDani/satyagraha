<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi melalui mass assignment.
     *
     * role_id dan google_id sengaja tidak dimasukkan karena keduanya
     * sebaiknya hanya diatur oleh sistem, bukan dari request pengguna.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
    ];

    /**
     * Field yang disembunyikan ketika model diubah menjadi array atau JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role yang dimiliki user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Periksa apakah user memiliki role tertentu.
     *
     * Contoh:
     * $user->hasRole('admin');
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->slug === $role;
    }

    /**
     * Periksa apakah user memiliki salah satu role.
     *
     * Contoh:
     * $user->hasAnyRole(['admin', 'editor']);
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role?->slug, $roles, true);
    }

    /**
     * Shortcut untuk memeriksa administrator.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function createdJobVacancies(): HasMany
    {
        return $this->hasMany(JobVacancy::class, 'created_by');
    }
}
