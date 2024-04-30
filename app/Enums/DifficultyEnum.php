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
        return Arr::random(self::cases())->value;
    }
}
