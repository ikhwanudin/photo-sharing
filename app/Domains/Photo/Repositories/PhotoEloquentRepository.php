<?php

namespace App\Domains\Photo\Repositories;

use App\Models\Photo;

class PhotoEloquentRepository
{
    public function main()
    {
        return Photo::query()
            ->withCount('like')
            ->with('user');
    }

    public function getAllPhotos()
    {
        return $this->main()
            ->orderByDesc('created_at');
    }

    public function getPhotoById(string $id)
    {
        return $this->main()
            ->where('id', $id);
    }
}
