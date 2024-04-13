<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum PostStatusEnum
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const REJECTED = 'rejected';
    const ON_INSPECTION = 'on_inspection';

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
