<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id, 
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'api_token' => $this->createToken(request()->device_name)->plainTextToken
        ];
    }
}
