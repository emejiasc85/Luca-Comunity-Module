<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($data = [])
    {
        $user = User::factory()->create($data);

        Sanctum::actingAs(
            $user,
            []
        );

        return $user;
    }


}
