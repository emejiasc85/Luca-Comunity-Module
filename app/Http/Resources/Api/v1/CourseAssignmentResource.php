<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseAssignmentResource extends JsonResource
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
            'id'     => $this->id,
            'level'  => new SchoolLevelResource($this->whenLoaded('level')),
            'grade'  => new SchoolGradeResource($this->whenLoaded('grade')),
            'course' => new CourseResource($this->whenLoaded('course')),
            'user'   => new UserResource($this->whenLoaded('user')),
        ];
    }
}
