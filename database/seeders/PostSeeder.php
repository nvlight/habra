<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sail artisan db:seed --class=PostSeeder
        $companies = Company::all();

        // Шаг 2. Создаю еще пользователей, каждый из них далет пост, при в случайном порядке выбирается представляет
        // ли пользователь какию-либо компанию, если да, то выбирается случайная компания.

        // использование state и замена user_id на author_id не работает, пришлось сделать через each()
//        User::factory(fake()->numberBetween(3,9))
//            ->has(
//                Post::factory()
//                    ->count(fake()->numberBetween(1,3))
//                    ->state(
//                        function (array $attributes, User $user) use($companies) {
//                            $companyId = null;
//
//                            if (random_int(0,1)){
//                                /** var Company $companies */
//                                if ($companies->count()){
//                                    $companyId = $companies->random()->id;
//                                }
//                            }
//
//                            return ['author_id' => $user->id, 'company_id' => $companyId];
//                        }
//                    )
//            )
//            ->create();

        User::factory(fake()->numberBetween(3,9))->create()->each(function ($user) use ($companies){

            Post::factory(fake()->numberBetween(1,3))
                ->state(
                    function (array $attributes) use($user, $companies) {
                        $companyId = null;

                        if (random_int(0,1)){
                            /** var Company $companies */
                            if ($companies->count()){
                                $companyId = $companies->random()->id;
                            }
                        }

                        return ['author_id' => $user->id, 'company_id' => $companyId];
                    }
                )->create();
        });

    }
}
