<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'spokesperson_id',
        'title',
        'site',
        'numbers',
        'location',
        'age_date',
    ];

    public function spokesperson(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOwnedBy(User $user): bool
    {
        //Log::info('$user: ' . $user->id);
        //Log::info('author_id: ' . $this->author_id);

        return $this->spokesperson_id === $user->id;
    }
}
