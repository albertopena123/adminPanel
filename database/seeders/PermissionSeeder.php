<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permisos para la gestión de usuarios
        $userPermissions = [
            [
                'name' => 'Ver usuarios',
                'slug' => 'view-users',
                'description' => 'Permite ver la lista de usuarios del sistema'
            ],
            [
                'name' => 'Crear usuarios',
                'slug' => 'create-users',
                'description' => 'Permite crear nuevos usuarios en el sistema'
            ],
            [
                'name' => 'Editar usuarios',
                'slug' => 'edit-users',
                'description' => 'Permite modificar datos de usuarios existentes'
            ],
            [
                'name' => 'Eliminar usuarios',
                'slug' => 'delete-users',
                'description' => 'Permite eliminar usuarios del sistema'
            ],
        ];

        // Permisos para la gestión de roles
        $rolePermissions = [
            [
                'name' => 'Ver roles',
                'slug' => 'view-roles',
                'description' => 'Permite ver la lista de roles del sistema'
            ],
            [
                'name' => 'Crear roles',
                'slug' => 'create-roles',
                'description' => 'Permite crear nuevos roles en el sistema'
            ],
            [
                'name' => 'Editar roles',
                'slug' => 'edit-roles',
                'description' => 'Permite modificar roles existentes'
            ],
            [
                'name' => 'Eliminar roles',
                'slug' => 'delete-roles',
                'description' => 'Permite eliminar roles del sistema'
            ],
        ];

        // Permisos para el contenido
        $contentPermissions = [
            [
                'name' => 'Ver contenido',
                'slug' => 'view-content',
                'description' => 'Permite ver contenido del sistema'
            ],
            [
                'name' => 'Crear contenido',
                'slug' => 'create-content',
                'description' => 'Permite crear nuevo contenido'
            ],
            [
                'name' => 'Editar contenido',
                'slug' => 'edit-content',
                'description' => 'Permite modificar contenido existente'
            ],
            [
                'name' => 'Eliminar contenido',
                'slug' => 'delete-content',
                'description' => 'Permite eliminar contenido del sistema'
            ],
            [
                'name' => 'Publicar contenido',
                'slug' => 'publish-content',
                'description' => 'Permite publicar contenido para que sea visible'
            ],
        ];

        // Permisos para la configuración del sistema
        $systemPermissions = [
            [
                'name' => 'Configuración del sistema',
                'slug' => 'system-settings',
                'description' => 'Permite modificar la configuración global del sistema'
            ],
            [
                'name' => 'Ver registros',
                'slug' => 'view-logs',
                'description' => 'Permite ver los registros de actividad del sistema'
            ],
        ];

        // Unir todos los permisos
        $allPermissions = array_merge(
            $userPermissions,
            $rolePermissions,
            $contentPermissions,
            $systemPermissions
        );

        // Crear los permisos en la base de datos
        foreach ($allPermissions as $permission) {
            Permission::create($permission);
        }
    }
}
