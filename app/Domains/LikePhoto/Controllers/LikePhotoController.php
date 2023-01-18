<?php

namespace App\Domains\LikePhoto\Controllers;

use App\Domains\LikePhoto\Actions\LikeUnlikePhotoAction;
use App\Domains\Photo\Actions\GetPhotoByIdAction;
use App\Domains\Photo\Resources\PhotoResource;
use App\Models\LikePhoto;
use Illuminate\Support\Facades\Auth;

class LikePhotoController
{
    private function main(string $id, bool $is_liked){
        $user_id = Auth::id();
        $photo = (new GetPhotoByIdAction)($id);

        if(!empty($photo->id)){
            return (new LikeUnlikePhotoAction)(
                user_id: $user_id,
                photo_id: $photo->id,
                is_liked: $is_liked
            );
        }

        return $photo;
    }

    public function like($id)
    {
        $photo = $this->main($id, true);
        return new PhotoResource($photo);
    }

    public function unlike($id)
    {
        $photo = $this->main($id, false);
        return new PhotoResource($photo);
    }
}
