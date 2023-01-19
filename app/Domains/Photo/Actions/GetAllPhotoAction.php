<?php

namespace App\Domains\Photo\Actions;


use App\Domains\Photo\Repositories\PhotoEloquentRepository;
use App\Models\Photo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class GetAllPhotoAction
{
    public int $paginate_number = 15;

    public function __invoke(string $cache_key = null): LengthAwarePaginator
    {
        //todo: get photo by tagging

        return Cache::remember(
            $cache_key ?: Photo::CACHE_KEY,
            86400,
            function () {
                return (new PhotoEloquentRepository())
                    ->getAllPhotos()
                    ->paginate($this->paginate_number);
            }
        );
    }
}
