<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AnswerStoreRequest;
use App\Http\Requests\Api\v1\AnswerUpdateRequest;
use App\Http\Resources\Api\v1\AnswerResource;
use App\Models\Answer;
use App\Models\Question;

class AnswerController extends Controller
{
    public function index(Question $question)
    {
        $answer = $question->answers()
            ->with(['user', 'question'])
            ->paginate();

        return AnswerResource::collection($answer);
    }

    public function store(AnswerStoreRequest $request, Question $question)
    {
        $request->merge(['user_id' => auth()->id()]);

        $answer = $question->answers()->create($request->only([
            'user_id',
            'description',
        ]));

        return new AnswerResource($answer);
    }
    
    public function update(AnswerUpdateRequest $request, $question, Answer $answer)
    {
        $answer->update($request->only([
            'description',
        ]));

        return new AnswerResource($answer);
    }
    
    public function destroy($question, Answer $answer)
    {
        $answer->delete();

        return response([],204);
    }
}