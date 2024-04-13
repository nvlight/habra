<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
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
            'age_date' => fake()->date('Y_m_d'), // random date
            'numbers' => fake()->numberBetween(1,10000),
            'location' => 'Moskow', // later change this
            'spokesperson_id' => null, // later change this too
        ];
    }
}
