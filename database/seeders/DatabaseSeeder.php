<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Usar Faker para generar datos aleatorios
        $faker = Faker::create();

        // Crear un usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123@'),
        ]);

        // Crear varios usuarios (puedes personalizar esta cantidad)
        $users = User::factory(5)->create(); // Genera 5 usuarios aleatorios

        // Crear 20 posts aleatorios con diferentes usuarios
        foreach ($users as $user) {
            // Crear varios posts para cada usuario
            for ($i = 0; $i < 2; $i++) {
                Post::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence, // Título aleatorio
                    'description' => $faker->paragraph, // Descripción aleatoria
                    'image' => 'posts/default.jpg', // Imagen aleatoria
                ]);
            }
        }

        // También puedes agregar más datos específicos si es necesario
        // Ejemplo de un post adicional para el admin:
        Post::create([
            'user_id' => 1, // Usuario admin (id=1)
            'title' => 'Post de Admin',
            'description' => 'Este es un post de ejemplo para el usuario Admin.',
            'image' => 'posts/default.jpg',
        ]);
    }
}
