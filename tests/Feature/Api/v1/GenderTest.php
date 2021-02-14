<?php

namespace Tests\Feature\Api\v1;

use App\Models\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenderTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_genders()
    {

        $user = $this->signIn();

        $this->getJson('api/v1/genders')
            ->assertStatus(200)
            ->assertJson([ 'data' => [
                    0 => [
                        'id'   => $user->gender->id,
                        'name' => $user->gender->name,
                    ]
                ]
            ]);
    }
    

}