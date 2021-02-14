<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Answer;

class AnswerLikeController extends Controller
{
    public function store(Answer $answer)
    {
        $answer->dislikes()->where('user_id', auth()->id())->delete();

        $likes = $answer->likes()->where('user_id', auth()->id())->get();

        if($likes->count() > 0){
            $answer->likes()->where('user_id', auth()->id())->delete();
        }
        
        if($likes->count() == 0){
            $answer->likes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return response([], 200);
    }
   
}