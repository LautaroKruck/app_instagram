<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario administrador

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123@'),
        ]);

        User::create([
            'name' => 'Lautaro',
            'email' => 'lautaro@gmail.com',
            'password' => Hash::make('Lautaro123@'),
        ]);

        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@gmail.com',
            'password' => Hash::make('Pepe123@'),
        ]);

        User::create([
            'name' => 'Luis',
            'email' => 'luis@gmail.com',
            'password' => Hash::make('Luis123@'),
        ]);

        // Crear varios usuarios de prueba
        User::factory(10)->create();
    }
}