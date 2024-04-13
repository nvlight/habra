<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $list = [
            // PHP - это "хаб", что это значит не знаю, но буду предпологать, что все ниже это теги
            'php', 'laravel', 'symfony', 'дайджест', 'yii', 'php-дайджест', 'api', 'docker', 'joomla', 'web-разработка',
            // JavaScript - hub
            'javascript', 'react', 'typescript', 'frontend', 'css', 'react.js', 'vue', 'node.js', 'html', 'angular',
        ];

        return [
            'name' => Arr::random($list),
        ];
    }
}
