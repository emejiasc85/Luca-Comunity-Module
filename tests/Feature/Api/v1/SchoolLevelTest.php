<?php

namespace Tests\Feature\Api\v1;

use App\Models\SchoolLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolLevelTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_school_levels()
    {
        $this->signIn();

        $schoolLevel = SchoolLevel::factory()->create();

        $this->getJson('api/v1/school-levels')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $schoolLevel->id,
                        'name' => $schoolLevel->name,
                    ]
                ]
            ]);
    }
    
    function test_filter_school_levels_by_keyword()
    {
        $this->signIn();

        $schoolLevel      = SchoolLevel::factory()->create(['name' => 'Secundary']);
        $otherSchoolLevel = SchoolLevel::factory()->create(['name' => 'Primary']);

        $parameters = [
            'search' =>  $otherSchoolLevel->name
        ];

        $this->call('GET','api/v1/school-levels', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $otherSchoolLevel->id,
                        'name' => $otherSchoolLevel->name,
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    0 => [
                        'id'   => $schoolLevel->id,
                        'name' => $schoolLevel->name,
                    ]
                ]
            ]);
    }
    
    function test_show_school_level()
    {
        $this->signIn();

        $schoolLevel = SchoolLevel::factory()->create();

        $this->getJson('api/v1/school-levels/'.$schoolLevel->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $schoolLevel->id,
                    'name' => $schoolLevel->name,
                ]
            ]);
    }
    
    function test_store_a_school_level()
    {
        $this->signIn();

        $data = SchoolLevel::factory()->make();

        $parameters = [
            'name' => $data->name,
        ];

        $this->postJson('api/v1/school-levels/', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('school_levels', [
            'name' => $data->name,
        ]);
    }
    
    
    function test_validate_before_store_a_school_level()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/school-levels/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_school_level()
    {
        $this->signIn();

        $schoolLevel = SchoolLevel::factory()->create();
        $data        = SchoolLevel::factory()->make();

        $parameters = [
            'name' => $data->name,
        ];

        $this->putJson('api/v1/school-levels/'.$schoolLevel->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('school_levels', [
            'id'   => $schoolLevel->id,
            'name' => $data->name,
        ]);
    }
    
    function test_validate_before_update_a_school_level()
    {
        $this->signIn();

        $schoolLevel = SchoolLevel::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/school-levels/'.$schoolLevel->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_school_level()
    {
        $this->signIn();

        $schoolLevel = SchoolLevel::factory()->create();


        $this->deleteJson('api/v1/school-levels/'.$schoolLevel->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('school_levels', [
            'id' => $schoolLevel->id
        ]);
    }

}