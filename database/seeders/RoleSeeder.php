<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles básicos del sistema
        $roles = [
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Acceso completo a todas las funcionalidades del sistema'
            ],
            [
                'name' => 'Gerente',
                'slug' => 'manager',
                'description' => 'Acceso a la gestión de usuarios y contenido'
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Puede crear y editar contenido del sistema'
            ],
            [
                'name' => 'Usuario',
                'slug' => 'user',
                'description' => 'Usuario estándar con acceso básico'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
