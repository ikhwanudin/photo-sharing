<?php

namespace App\Domains\Photo\Jobs;

use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RemoveFilePhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Model $photo
    )
    {
    }

    public function handle()
    {
        Cache::forget(Photo::CACHE_KEY.'_'.$this->photo->id);
        Cache::forget(Photo::CACHE_KEY);
        Storage::delete($this->photo->path);
        $this->photo->delete();
    }
}
