<?php

namespace App\Rules;

use App\Models\QuestionLike;
use Illuminate\Contracts\Validation\Rule;

class QuestionLikeUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $likes = QuestionLike::query()
            ->where('user_id', auth()->id())
            ->where('question_id', request()->route()->question->id)
            ->count();


        return $likes == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ya has registrado un like a esta pregunta.';
    }
}
