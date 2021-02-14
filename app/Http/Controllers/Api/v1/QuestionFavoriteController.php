<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionFavoriteController extends Controller
{
    public function store(Question $question)
    {
        $favorites = $question->favorites()->where('user_id', auth()->id())->get();

        if($favorites->count() > 0){
            $question->favorites()->where('user_id', auth()->id())->delete();
        }
        
        if($favorites->count() == 0){
            $favorite = $question->favorites()->create([
                'user_id' => auth()->id()
            ]);

            $favorite->sendNotification();
        }
        
        return response([], 200);
    }
   
}