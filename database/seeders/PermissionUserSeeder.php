<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionUserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario normal con permisos especiales directos
        $user = User::where('email', 'user@example.com')->first();

        // Asignar algunos permisos directamente al usuario estándar
        $specialPermissions = Permission::whereIn('slug', [
            'create-content',  // Normalmente solo usuarios con rol editor pueden crear contenido
            'edit-content'     // Le damos permiso especial a este usuario
        ])->get();

        $user->permissions()->attach($specialPermissions->pluck('id')->toArray());

        // Usuario multi-rol con permisos adicionales directos
        $multiRoleUser = User::where('email', 'multi@example.com')->first();

        // Asignar permisos directos al usuario con múltiples roles
        $additionalPermissions = Permission::whereIn('slug', [
            'publish-content',  // Un permiso que normalmente no tendría con sus roles
            'view-logs'         // Un permiso adicional para pruebas
        ])->get();

        $multiRoleUser->permissions()->attach($additionalPermissions->pluck('id')->toArray());
    }
}
