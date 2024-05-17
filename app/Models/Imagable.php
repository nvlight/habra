<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagable extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'imagable_id',
        'imagable_type',
    ];
}
