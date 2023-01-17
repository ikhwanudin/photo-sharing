<?php

namespace App\Domains\Photo\Actions;

use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UploadNewPhotoAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Authenticatable $user,
        public array $request,
        public string $path,
        public string $photo_id
    ) {
    }

    public function handle()
    {
        Cache::forget(Photo::CACHE_KEY);

        $photo = new Photo([
            'id' => $this->photo_id,
            'title' => $this->request['title'],
            'description' => $this->request['description'] ?? null,
            'path' => $this->path,
        ]);

        $this->user->photos()->save($photo);
    }
}
