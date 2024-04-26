<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    protected $fillable = [
        'text',
        'user_id',
        'post_id',
        'parent_id',
    ];

    use HasFactory;

    protected static function booted()
    {
        static::saving(function (Comment $comment){
            $comment->user_id = $comment->user_id ?: auth()->id();

            if ($comment->parent_id){
                $comment->post_id = Comment::query()->find($comment->parent_id)->post_id;
            }
        });
    }

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

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

}
