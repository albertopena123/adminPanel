<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * The permissions that are directly assigned to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string|array|\Illuminate\Database\Eloquent\Collection $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role) ||
                $this->roles->contains('slug', $role);
        }

        if (is_array($role)) {
            return $this->roles->whereIn('name', $role)->count() ||
                $this->roles->whereIn('slug', $role)->count();
        }

        return (bool) $role->intersect($this->roles)->count();
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param string|array|\Illuminate\Database\Eloquent\Collection $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        // Check direct permissions
        if (is_string($permission)) {
            if (
                $this->permissions->contains('name', $permission) ||
                $this->permissions->contains('slug', $permission)
            ) {
                return true;
            }

            // Check permissions through roles
            foreach ($this->roles as $role) {
                if (
                    $role->permissions->contains('name', $permission) ||
                    $role->permissions->contains('slug', $permission)
                ) {
                    return true;
                }
            }

            return false;
        }

        if (is_array($permission)) {
            // Check if user has any of the permissions directly
            if (
                $this->permissions->whereIn('name', $permission)->count() ||
                $this->permissions->whereIn('slug', $permission)->count()
            ) {
                return true;
            }

            // Check permissions through roles
            foreach ($this->roles as $role) {
                if (
                    $role->permissions->whereIn('name', $permission)->count() ||
                    $role->permissions->whereIn('slug', $permission)->count()
                ) {
                    return true;
                }
            }

            return false;
        }

        // If a collection was passed, check if the user has any of those permissions
        return (bool) $permission->intersect($this->permissions)->count();
    }
}
