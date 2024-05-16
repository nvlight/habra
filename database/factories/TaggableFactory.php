<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Taggable>
 */
class TaggableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $taggableId = Post::query()->inRandomOrder()->first()
            ?? Post::factory()->create(['author_id' => $user->id])->id;
        $taggableType = Post::class;

        return [
            "tag_id" => Tag::query()->inRandomOrder()->first() ?? Tag::factory()->create()->id,
            "taggable_id" => $taggableId,
            "taggable_type" => $taggableType,
        ];
    }
}
