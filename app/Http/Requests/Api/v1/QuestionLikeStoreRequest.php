<?php

namespace App\Http\Requests\Api\v1;

use App\Rules\QuestionLikeUnique;
use Illuminate\Foundation\Http\FormRequest;

class QuestionLikeStoreRequest extends FormRequest
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
            'like' => new QuestionLikeUnique()
        ];
    }
    
}
