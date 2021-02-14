<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\QuestionDislikeStoreRequest;
use App\Models\Question;

class QuestionDislikeController extends Controller
{
    public function store(QuestionDislikeStoreRequest $request, Question $question)
    {
        $question->likes()->where('user_id', auth()->id())->delete();
        
        $question->dislikes()->create([
            'user_id' => auth()->id()
        ]);

        return response([], 201);
    }
   
}