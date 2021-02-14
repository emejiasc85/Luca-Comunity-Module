<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Answer;

class AnswerDislikeController extends Controller
{
    public function store(Answer $answer)
    {
        $answer->likes()->where('user_id', auth()->id())->delete();

        $dislikes = $answer->dislikes()->where('user_id', auth()->id())->get();

        if($dislikes->count() > 0){
            $answer->dislikes()->where('user_id', auth()->id())->delete();
        }
        
        if($dislikes->count() == 0){
            $answer->dislikes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return response([], 200);
    }
   
}