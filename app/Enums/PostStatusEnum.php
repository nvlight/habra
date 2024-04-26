<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum PostStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';
    case ON_INSPECTION = 'on_inspection';

    public static function getRandomValue()
    {
        $values = [
            PostStatusEnum::DRAFT,
            PostStatusEnum::PUBLISHED,
            PostStatusEnum::REJECTED,
            PostStatusEnum::ON_INSPECTION,
        ];

        return Arr::random($values);
    }
}
