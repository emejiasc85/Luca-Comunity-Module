<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ApiLoginRequest;
use App\Http\Resources\Api\v1\UserApiResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function __invoke(ApiLoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Estas credenciales no coinciden con nuestros registros.'],
            ]);
        }

        return new UserApiResource($user);

    }

}
