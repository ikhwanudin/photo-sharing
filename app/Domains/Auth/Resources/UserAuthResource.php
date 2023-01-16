<?php

namespace App\Domains\Auth\Resources;

use App\Domains\Utils\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return Response::success([
            'name' => $this->name,
            'email' => $this->email,
            'access_token' => $this->token,
            'token_type' => 'Bearer'
        ]);
    }
}
