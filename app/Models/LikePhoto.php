<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePhoto extends Model
{
    use HasFactory;

    const CACHE_KEY = 'LIKES';

    protected $guarded = [];
}
