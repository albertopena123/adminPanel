<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de ejemplo
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $manager = User::create([
            'name' => 'Gerente',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'Usuario',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Asignar roles a los usuarios
        $admin->roles()->attach(Role::where('slug', 'admin')->first()->id);
        $manager->roles()->attach(Role::where('slug', 'manager')->first()->id);
        $editor->roles()->attach(Role::where('slug', 'editor')->first()->id);
        $user->roles()->attach(Role::where('slug', 'user')->first()->id);

        // Usuario con múltiples roles (para pruebas)
        $multiRole = User::create([
            'name' => 'Usuario Multi-Rol',
            'email' => 'multi@example.com',
            'password' => Hash::make('password'),
        ]);

        $multiRole->roles()->attach([
            Role::where('slug', 'editor')->first()->id,
            Role::where('slug', 'user')->first()->id,
        ]);
    }
}
