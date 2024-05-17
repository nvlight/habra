<?php

namespace Database\Seeders;

use App\Models\Imagable;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sail artisan db:seed --class=ImagableSeeder
        $postsCount = Post::all()->count();
        $imagesCount = Image::all()->count();

        if (!$postsCount && !$imagesCount) {
            return;
        }

        $posts = Post::query()->pluck('id');
        $images = Image::query()->pluck('id');

        $pv = Post::query()->inRandomOrder()->first()->id;
        //foreach($posts as $pv){

            foreach($images as $tv){

                if (random_int(0, 1)){
                    continue;
                }

                Imagable::query()->create([
                    'image_id' => $tv,
                    'imagable_id' => $pv,
                    'imagable_type' => Post::class,
                ]);
            }
        //}
    }
}
