<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Imagable>
 */
class ImagableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $imagableId = Post::query()->inRandomOrder()->first()
            ?? Post::factory()->create(['author_id' => $user->id])->id;
        $imagableType = Post::class;

        return [
            "image_id" => Image::query()->inRandomOrder()->first() ?? Image::factory()->create()->id,
            "imagable_id" => $imagableId,
            "imagable_type" => $imagableType,
        ];
    }
}
