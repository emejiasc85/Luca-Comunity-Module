<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CourseAssignmentStoreRequest;
use App\Http\Requests\Api\v1\CourseAssignmentUpdateRequest;
use App\Http\Resources\Api\v1\CourseAssignmentResource;
use App\Models\CourseAssignment;

class CourseAssignmentController extends Controller
{
    public function index()
    {
        $courseAssignments = CourseAssignment::query()
            ->with([
                'level',
                'grade',
                'course',
                'user'
            ])
            ->paginate();

        return CourseAssignmentResource::collection($courseAssignments);
    }
    
    public function show(CourseAssignment $courseAssignment)
    {
        return new CourseAssignmentResource($courseAssignment);
    }

    public function store(CourseAssignmentStoreRequest $request)
    {
        $courseAssignment = CourseAssignment::create($request->only([
            'level_id',
            'grade_id',
            'course_id',
            'user_id',
        ]));
        

        return new CourseAssignmentResource($courseAssignment);
    }
    
    public function update(CourseAssignmentUpdateRequest $request, CourseAssignment $courseAssignment)
    {
        $courseAssignment->update($request->only([
            'level_id',
            'grade_id',
            'course_id',
            'user_id',
        ]));

        return new CourseAssignmentResource($courseAssignment);
    }
    
    public function destroy(CourseAssignment $courseAssignment)
    {
        $courseAssignment->delete();

        return response([],204);
    }
}
