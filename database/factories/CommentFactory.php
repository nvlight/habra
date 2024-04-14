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
    public function configure()
    {
        return $this->afterCreating(function (Comment $comment){
            if ($comment->replies()->exists()) {
                return;
            }

            $comment->parent()->associate($this->findRandomCommentToMakeParentOf($comment))->save();
        });
    }

    private function findRandomCommentToMakeParentOf(Comment $comment)
    {
        return $comment->post
            ->comments()
            ->doesntHave('parent')
            ->where('id', '<>', $comment->id)
            ->inRandomOrder()
            ->first();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->sentences( fake()->numberBetween(1,3), true ),
            'user_id' => User::query()->inRandomOrder()->first(),
            'post_id' => Post::query()->inRandomOrder()->first(),
        ];
    }
}
