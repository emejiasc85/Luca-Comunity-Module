<?php

namespace Tests\Feature\Api\v1;

use App\Models\SchoolGrade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolGradeTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_school_grades()
    {
        $this->signIn();

        $schoolGrade = SchoolGrade::factory()->create();

        $this->getJson('api/v1/school-grades')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'    => $schoolGrade->id,
                        'name'  => $schoolGrade->name,
                        'level' => [
                            'id'   => $schoolGrade->level_id,
                            'name' => $schoolGrade->level->name,
                        ],
                    ]
                ]
            ]);
    }
    
    function test_filter_school_grades_by_keyword()
    {
        $this->signIn();

        $schoolGrade      = SchoolGrade::factory()->create(['name' => 'First Grade']);
        $otherSchoolGrade = SchoolGrade::factory()->create(['name' => 'Second Grade']);

        $parameters = [
            'search' =>  $otherSchoolGrade->name
        ];

        $this->call('GET','api/v1/school-grades', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $otherSchoolGrade->id,
                        'name' => $otherSchoolGrade->name,
                        'level' => [
                            'id'   => $otherSchoolGrade->level_id,
                            'name' => $otherSchoolGrade->level->name,
                        ],
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    0 => [
                        'id'   => $schoolGrade->id,
                        'name' => $schoolGrade->name,
                    ]
                ]
            ]);
    }
    
    function test_show_school_grade()
    {
        $this->signIn();

        $schoolGrade = SchoolGrade::factory()->create();

        $this->getJson('api/v1/school-grades/'.$schoolGrade->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $schoolGrade->id,
                    'name' => $schoolGrade->name,
                    'level' => [
                        'id'   => $schoolGrade->level_id,
                        'name' => $schoolGrade->level->name,
                    ],
                ]
            ]);
    }
    
    function test_store_a_school_grade()
    {
        $this->signIn();

        $data = SchoolGrade::factory()->make();

        $parameters = [
            'name'     => $data->name,
            'level_id' => $data->level_id,
        ];

        $this->postJson('api/v1/school-grades/', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('school_grades', [
            'name'     => $data->name,
            'level_id' => $data->level_id,
        ]);
    }
    
    
    function test_validate_before_store_a_school_grade()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/school-grades/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name'     => ['El campo nombre es obligatorio.'],
                    'level_id' => ['El campo nivel escolar es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_school_grade()
    {
        $this->signIn();

        $schoolGrade = SchoolGrade::factory()->create();
        $data        = SchoolGrade::factory()->make();

        $parameters = [
            'name'     => $data->name,
            'level_id' => $data->level_id
        ];

        $this->putJson('api/v1/school-grades/'.$schoolGrade->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $schoolGrade->id,
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('school_grades', [
            'id'       => $schoolGrade->id,
            'name'     => $data->name,
            'level_id' => $data->level_id
        ]);
    }
    
    function test_validate_before_update_a_school_grade()
    {
        $this->signIn();

        $schoolGrade = SchoolGrade::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/school-grades/'.$schoolGrade->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name'     => ['El campo nombre es obligatorio.'],
                    'level_id' => ['El campo nivel escolar es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_school_grade()
    {
        $this->signIn();

        $schoolGrade = SchoolGrade::factory()->create();

        $this->deleteJson('api/v1/school-grades/'.$schoolGrade->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('school_grades', [
            'id' => $schoolGrade->id
        ]);
    }

}