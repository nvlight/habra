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
        Post::query()->get()->each(
            fn(Post $post) => Comment::factory(fake()->numberBetween(11, 21))->create(['post_id' => $post->id])
        );
    }

}
