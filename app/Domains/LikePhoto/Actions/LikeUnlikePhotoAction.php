<?php

namespace App\Domains\LikePhoto\Actions;

use App\Domains\Photo\Actions\GetPhotoByIdAction;
use App\Models\LikePhoto;
use App\Models\Photo;
use Illuminate\Support\Facades\Cache;

class LikeUnlikePhotoAction
{
    public function __invoke(
        string $user_id,
        string $photo_id,
        bool   $is_liked
    )
    {
        $cache_key = LikePhoto::CACHE_KEY . '_' . $photo_id;
        $liked_cache = Cache::get($cache_key);

        if ($liked_cache == null && $is_liked == true) {
            Cache::forget(Photo::CACHE_KEY . '_' . $photo_id);
            try {
                Cache::rememberForever(
                    key: $cache_key,
                    callback: function () use ($user_id, $photo_id, $is_liked) {
                        return LikePhoto::create([
                            'user_id' => $user_id,
                            'photo_id' => $photo_id,
                            'isLiked' => $is_liked
                        ]);
                    });
            } catch (\ErrorException $th) {
                //todo: "add error log here";
                //handle ketika data ternyata sudah ada cache belum ada / mgengalami trouble
            }

        } else if ($liked_cache !== null && $is_liked == false) {
            Cache::forget($cache_key);
            Cache::forget(Photo::CACHE_KEY . '_' . $photo_id);
            LikePhoto::where('photo_id', $photo_id)->where('user_id', $user_id)->delete();
        }

        return (new GetPhotoByIdAction)($photo_id);
    }
}
