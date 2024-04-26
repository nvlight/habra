<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::query()->take(1)->get();

        $this->call([
            CompanySeeder::class,
            PostSeeder::class,
            TagSeeder::class,
            TaggableSeeder::class,
            CommentSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
