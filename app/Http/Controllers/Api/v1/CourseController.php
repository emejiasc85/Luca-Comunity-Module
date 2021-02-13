<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CourseStoreRequest;
use App\Http\Requests\Api\v1\CourseUpdateRequest;
use App\Http\Resources\Api\v1\CourseResource;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $course = Course::query()
            ->search()
            ->paginate();

        return CourseResource::collection($course);
    }
    
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    public function store(CourseStoreRequest $request)
    {
        $course = Course::create($request->only([
            'name',
        ]));

        return new CourseResource($course);
    }
    
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course->update($request->only([
            'name',
        ]));

        return new CourseResource($course);
    }
    
    public function destroy(Course $course)
    {
        $course->delete();

        return response([],204);
    }
}
