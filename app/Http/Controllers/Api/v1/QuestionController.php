<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\QuestionStoreRequest;
use App\Http\Requests\Api\v1\QuestionUpdateRequest;
use App\Http\Resources\Api\v1\QuestionResource;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::query()
            ->search()
            ->with(['user', 'assignment.level', 'assignment.grade', 'assignment.course', 'answers.user', ])
            ->onlyFollowed()
            ->popularity()
            ->ordered()
            ->paginate();

        return QuestionResource::collection($questions);
    }
    
    public function show(Question $question)
    {
        $question->load(['user', 'assignment.level', 'assignment.grade', 'assignment.course', 'answers.user']);
        return new QuestionResource($question);
    }

    public function store(QuestionStoreRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);

        $question = Question::create($request->only([
            'assignment_id',
            'user_id',
            'question',
            'description',
        ]));

        return new QuestionResource($question);
    }
    
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->update($request->only([
            'assignment_id',
            'user_id',
            'question',
            'description',
        ]));

        return new QuestionResource($question);
    }
    
    public function destroy(Question $question)
    {
        $question->delete();

        return response([],204);
    }
}