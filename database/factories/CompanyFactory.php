<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(fake()->numberBetween(1,5), true),
            'title' => fake()->words(fake()->numberBetween(3,9), true),
            'site' => fake()->domainName(),
            'age_date' => fake()->date('Y-m-d'), // random date
            'numbers' => fake()->numberBetween(1,10000),
            'location' => 'Moskow', // later change this
            'spokesperson_id' => null, // later change this too
        ];
    }
}
