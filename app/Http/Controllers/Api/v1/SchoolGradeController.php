<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SchoolGradeStoreRequest;
use App\Http\Requests\Api\v1\SchoolGradeUpdateRequest;
use App\Http\Resources\Api\v1\SchoolGradeResource;
use App\Models\SchoolGrade;

class SchoolGradeController extends Controller
{
    public function index()
    {
        $schoolGrade = SchoolGrade::query()
            ->search()
            ->levelId()
            ->with(['level'])
            ->paginate();

        return SchoolGradeResource::collection($schoolGrade);
    }
    
    public function show(SchoolGrade $schoolGrade)
    {
        $schoolGrade->load(['level']);
        return new SchoolGradeResource($schoolGrade);
    }

    public function store(SchoolGradeStoreRequest $request)
    {
        $schoolGrade = SchoolGrade::create($request->only([
            'name',
            'level_id'
        ]));

        return new SchoolGradeResource($schoolGrade);
    }
    
    public function update(SchoolGradeUpdateRequest $request, SchoolGrade $schoolGrade)
    {
        $schoolGrade->update($request->only([
            'name',
            'level_id'
        ]));

        return new SchoolGradeResource($schoolGrade);
    }
    
    public function destroy(SchoolGrade $schoolGrade)
    {
        $schoolGrade->delete();

        return response([],204);
    }
}