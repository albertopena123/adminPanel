<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador: todos los permisos
        $adminRole = Role::where('slug', 'admin')->first();
        $allPermissions = Permission::all();
        $adminRole->permissions()->attach($allPermissions->pluck('id')->toArray());

        // Gerente: permisos de usuarios y contenido
        $managerRole = Role::where('slug', 'manager')->first();
        $managerPermissions = Permission::whereIn('slug', [
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'view-content',
            'create-content',
            'edit-content',
            'publish-content',
            'view-logs',
        ])->get();
        $managerRole->permissions()->attach($managerPermissions->pluck('id')->toArray());

        // Editor: permisos de contenido
        $editorRole = Role::where('slug', 'editor')->first();
        $editorPermissions = Permission::whereIn('slug', [
            'view-content',
            'create-content',
            'edit-content',
        ])->get();
        $editorRole->permissions()->attach($editorPermissions->pluck('id')->toArray());

        // Usuario estándar: permisos básicos
        $userRole = Role::where('slug', 'user')->first();
        $userPermissions = Permission::whereIn('slug', [
            'view-content',
        ])->get();
        $userRole->permissions()->attach($userPermissions->pluck('id')->toArray());
    }
}
