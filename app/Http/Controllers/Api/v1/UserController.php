<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UserStoreRequest;
use App\Http\Requests\Api\v1\UserUpdateRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->search()
            ->with(['gender'])
            ->paginate();

        return UserResource::collection($users);
    }
    
    public function show(User $user)
    {
        $user->load(['gender']);

        return new UserResource($user);
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->only([
            'name',
            'age',
            'email',
            'gender_id',
            'password'
        ]));

        return new UserResource($user);
    }
    
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->only([
            'name',
            'age',
            'email',
            'gender_id',
        ]));

        return new UserResource($user);
    }
    
    public function destroy(User $user)
    {
        $user->delete();

        return response([],204);
    }
}
