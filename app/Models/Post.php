<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'company_id',
        'title',
        'content',
        'difficulty',
        'views',
        'read_time',
        'likes',
        'status',
        'published_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imagable');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isOwnedBy(User $user): bool
    {
        //Log::info('$user: ' . $user->id);
        //Log::info('author_id: ' . $this->author_id);

        return $this->author_id === $user->id;
    }
}
