<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionLikeController extends Controller
{
    public function store(Question $question)
    {
        $question->dislikes()->where('user_id', auth()->id())->delete();

        $likes = $question->likes()->where('user_id', auth()->id())->get();

        if($likes->count() > 0){
            $question->likes()->where('user_id', auth()->id())->delete();
        }
        
        if($likes->count() == 0){
            $question->likes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return response([], 200);
    }
   
}