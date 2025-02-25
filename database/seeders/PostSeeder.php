<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los usuarios
        $users = User::all();

        // Verificar que hay usuarios antes de crear posts
        if ($users->isEmpty()) {
            $this->command->info('No users found, running UserSeeder first...');
            $this->call(UserSeeder::class);
            $users = User::all();
        }

        // Crear 20 posts aleatorios
        Post::factory(20)->create([
            'user_id' => $users->random()->id, // Asignar un usuario aleatorio
        ]);
    }
}
