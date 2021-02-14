<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionFollowController extends Controller
{
    public function store(Question $question)
    {
        $follows = $question->follows()->where('user_id', auth()->id())->get();

        if($follows->count() > 0){
            $question->follows()->where('user_id', auth()->id())->delete();
        }
        
        if($follows->count() == 0){
            $follow = $question->follows()->create([
                'user_id' => auth()->id()
            ]);

            $follow->sendNotification();
        }
        
        return response([], 200);
    }
   
}