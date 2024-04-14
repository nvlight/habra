<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function createRandomComments()
    {
//        $comments = Comment::factory(fake()->numberBetween(11, 21))->create();
//        $this->comments()->saveMany($comments);
//        return $comments;

        // делает тоже самое что и верхние 3 строки!! Проверю же!
        return Comment::factory(fake()->numberBetween(11, 21))->create(['post_id' => $this->id]);
    }
}
