<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\QuestionLikeStoreRequest;
use App\Models\Question;

class QuestionLikeController extends Controller
{
    public function store(QuestionLikeStoreRequest $request, Question $question)
    {
        $question->likes()->create([
            'user_id' => auth()->id()
        ]);

        return response([], 201);
    }
   
}