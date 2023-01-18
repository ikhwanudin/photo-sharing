<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory, HasUuids;

    const CACHE_KEY = 'photos';

    protected $primaryKey = 'secret_id';

    protected $guarded = [];

    protected $hidden = [
        'secret_key',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like()
    {
        return $this->hasMany(LikePhoto::class, 'photo_id', 'id');
    }
}
