<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->sentences( fake()->numberBetween(1,3), true ),
            'user_id' => User::query()->inRandomOrder()->first() ?? User::factory()->create()->id,
            'post_id' => Post::query()->inRandomOrder()->first() ?? Post::factory()->create()->id,
        ];
    }
}
