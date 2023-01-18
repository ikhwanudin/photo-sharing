<?php

namespace App\Domains\Photo\Actions;

use App\Domains\Photo\Repositories\PhotoEloquentRepository;
use App\Models\Photo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class GetPhotoByIdAction
{
    public function __invoke(string $id)
    {
        try {
            return Cache::remember(
                Photo::CACHE_KEY.'_'.$id,
                86400,
                fn () => (new PhotoEloquentRepository)->getPhotoById($id)->firstOrFail()
            );
        } catch (ModelNotFoundException) {
            return (object) [
                'message' => 'Photo Not Found',
                'httpcode' => '404',
                'httpmessage' => 'Not Found'
            ];
        }
    }
}
