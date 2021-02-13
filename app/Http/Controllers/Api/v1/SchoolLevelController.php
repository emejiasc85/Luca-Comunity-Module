<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SchoolLevelStoreRequest;
use App\Http\Requests\Api\v1\SchoolLevelUpdateRequest;
use App\Http\Resources\Api\v1\SchoolLevelResource;
use App\Models\SchoolLevel;

class SchoolLevelController extends Controller
{
    public function index()
    {
        $schoolLevel = SchoolLevel::query()
            ->search()
            ->paginate();

        return SchoolLevelResource::collection($schoolLevel);
    }
    
    public function show(SchoolLevel $schoolLevel)
    {
        return new SchoolLevelResource($schoolLevel);
    }

    public function store(SchoolLevelStoreRequest $request)
    {
        $schoolLevel = SchoolLevel::create($request->only([
            'name',
        ]));

        return new SchoolLevelResource($schoolLevel);
    }
    
    public function update(SchoolLevelUpdateRequest $request, SchoolLevel $schoolLevel)
    {
        $schoolLevel->update($request->only([
            'name',
        ]));

        return new SchoolLevelResource($schoolLevel);
    }
    
    public function destroy(SchoolLevel $schoolLevel)
    {
        $schoolLevel->delete();

        return response([],204);
    }
}
