<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'cedula' => '12345678901',
            'fecha_nacimiento' => now()->subYears(30), // Agrega un valor de ejemplo para fecha_nacimiento
            'codigo_ciudad' => 123,
        ]);

        // Crear algunos usuarios normales
        User::factory(20)->create();
    }
}
