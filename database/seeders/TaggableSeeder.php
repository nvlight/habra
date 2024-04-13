<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaggableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sail artisan db:seed --class=TaggableSeeder
        $postsCount = Post::all()->count();
        $tagsCount  = Tag::all()->count();

        if (!$postsCount && !$tagsCount) {
            return;
        }

        $posts = Post::query()->pluck('id');
        $tags  = Tag::query()->pluck('id');

        foreach($posts as $pv){

            foreach($tags as $tv){

                if (random_int(0, 1)){
                    continue;
                }

                Taggable::query()->create([
                    'tag_id' => $tv,
                    'taggable_id' => $pv,
                    'taggable_type' => Post::class,
                ]);
            }
        }

    }
}
