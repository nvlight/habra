<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Шаг 1. Создаю пользователей и для каждого из них создаю несколько компаний, объявив их как представителей.
        User::factory( fake()->numberBetween(9,15) )->create()->each(function ($user){

            for($i=1; $i <= fake()->numberBetween(1,3); $i++){
                Company::factory()->create([
                    'spokesperson_id' => $user->id,
                ]);
            }
        });
    }
}
