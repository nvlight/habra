<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function associateParentComment()
    {
        if ($this->replies()->exists()) return;

        //$this->parent()->associate(static::findRandomToMakeParent())->save();
        $this->parent()->associate($this->findRandomToMakeParent())->save();
    }

    private function findRandomToMakeParent()
    {
        return $this->post
            ->comments()
            ->doesntHave('parent')
            ->where('id', '<>', $this->id)
            ->inRandomOrder()
            ->first();
    }
}
