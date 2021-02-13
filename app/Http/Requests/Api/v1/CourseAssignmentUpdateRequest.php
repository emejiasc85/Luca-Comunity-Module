<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class CourseAssignmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'level_id'  => 'required|exists:school_levels,id',
            'grade_id'  => 'required|exists:school_grades,id',
            'course_id' => 'required|exists:courses,id',
            'user_id'   => 'required|exists:users,id',
        ];
    }
}
