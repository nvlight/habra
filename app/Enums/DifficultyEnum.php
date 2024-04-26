<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum DifficultyEnum: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case DIFFICULT = 'difficult';

    public static function getRandomValue()
    {
        $values = [
            DifficultyEnum::EASY,
            DifficultyEnum::MEDIUM,
            DifficultyEnum::DIFFICULT,
        ];

        return Arr::random($values);
    }
}
