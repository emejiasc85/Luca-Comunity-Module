<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionDislikeController extends Controller
{
    public function store(Question $question)
    {
        $question->likes()->where('user_id', auth()->id())->delete();
        
        $dislikes = $question->dislikes()->where('user_id', auth()->id())->get();

        if($dislikes->count() > 0){
            $question->dislikes()->where('user_id', auth()->id())->delete();
        }
        
        if($dislikes->count() == 0){
            $question->dislikes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return response([], 200);
    }
   
}