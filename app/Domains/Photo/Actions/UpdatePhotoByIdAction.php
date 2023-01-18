<?php

namespace App\Domains\Photo\Actions;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UpdatePhotoByIdAction
{
    public function __invoke(
        Request $request,
        string $id,
        array $field_to_be_edit
    )
    {
        //update photo
        $is_photo_updated = Photo::where('id', $id)
            ->update($field_to_be_edit);

        if($is_photo_updated == false){
            return (object) [
                'httpcode' => '500',
                'message' => 'couldnt update photo'
            ];
        }

        //remove old cache first, before update the cache
        Cache::forget(Photo::CACHE_KEY .'_'. $id);
        Cache::forget(Photo::CACHE_KEY);

        //return new photo collection if success edited
        return (new GetPhotoByIdAction)($id);
    }
}
