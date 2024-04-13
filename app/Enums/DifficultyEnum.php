<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum DifficultyEnum
{
    const EASY = 'easy';
    const MEDIUM = 'medium';
    const DIFFICULT = 'difficult';

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
