<?php

namespace App\Domains\Photo\Actions;

use App\Domains\Photo\Jobs\SaveNewPhotoJob;
use App\Domains\Photo\Requests\StorePhotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UploadNewPhotoAction
{
    public function __invoke(StorePhotoRequest $request)
    {
        $user = Auth::user();

        $path = $request->file('photo')->store($user->id);
        $photo_id = Str::uuid();

        dispatch(new SaveNewPhotoJob(
            user: $user,
            request: $request->only('title', 'description'),
            path: $path,
            photo_id: $photo_id)
        );

        return (object) [
            'id' => $photo_id,
            'title' => $request['title'],
            'path' => $path,
            'description' => $request['description'] ?? null,
            'user' => $user,
        ];
    }
}
