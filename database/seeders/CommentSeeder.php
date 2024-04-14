<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sail artisan db:seed --class=CommentSeeder

        Post::query()->take(2)
            ->get()
            ->flatMap(fn (Post $post) => $this->forPost($post) )
            ->flatMap(fn (Comment $comment) => $this->repliesOf($comment))
            ->flatMap(fn (Comment $comment) => $this->repliesOf($comment))
            ->flatMap(fn (Comment $comment) => $this->repliesOf($comment))
        ;
    }

    private function forPost(Post $post)
    {
        return Comment::factory(fake()->numberBetween(1,2))
            ->for($post)
            ->create();
    }

    private function repliesOf(Comment $comment)
    {
        return Comment::factory(fake()->numberBetween(1,2))
            ->for($comment->post)
            ->for($comment, 'parent')
            ->create();
    }
}
