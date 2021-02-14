<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id'          => $this->id,
            'question'    => $this->question,
            'description' => $this->description,
            'likes'       => $this->likes->count(),
            'dislikes'    => $this->dislikes->count(),
            'favorites'   => $this->favorites->count(),
            'follows'     => $this->follows->count(),
            'assignment'  => new CourseAssignmentResource($this->whenLoaded('assignment')),
            'user'        => new UserResource($this->whenLoaded('user')),
            'answers'     => AnswerResource::collection($this->whenLoaded('answer')),
        ];
    }
}
