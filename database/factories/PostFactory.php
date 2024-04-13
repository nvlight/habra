<?php

namespace Database\Factories;

use App\Enums\DifficultyEnum;
use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = PostStatusEnum::getRandomValue();

        $publishedAt = $status === PostStatusEnum::PUBLISHED
            ? fake()->date('Y-m-d') . ' ' . fake()->time('H:i:s')
            : null;

        return [
            'title' => fake()->words(fake()->numberBetween(3,9), true),
            'content' => fake()->paragraphs(fake()->numberBetween(3,9), true),
            'difficulty' => DifficultyEnum::getRandomValue(),
            'views' => fake()->numberBetween(0,100000),
            'read_time' => fake()->numberBetween(0,180),
            'likes' => fake()->numberBetween(0,100000),
            'status' => $status,
            'published_at' => $publishedAt, // 2024-04-13 02:53:13
        ];
    }
}
