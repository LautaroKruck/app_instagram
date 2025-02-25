<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(4),
            'image' => 'posts/default.jpg', // Puedes cambiarlo si tienes imágenes
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
