<?php

namespace App\Domains\Photo\Resources;

use App\Domains\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (empty($this->id)) {
            return [
                'message' => $this->message,
                'data' => [],
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => $this->path,
            'description' => $this->description,
            'user' => new UserResource($this->user),
        ];
    }

    public function withResponse($request, $response)
    {
        if (empty($this->id)) {
            $response->setStatusCode(404, 'Photo Not Found');
        }
    }
}
