<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\GenderResource;
use App\Models\Gender;

class GenderController extends Controller
{
    public function index()
    {
        $genders = Gender::all();

        return GenderResource::collection($genders);
    }
}
