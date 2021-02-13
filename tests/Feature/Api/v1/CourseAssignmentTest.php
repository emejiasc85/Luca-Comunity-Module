<?php

namespace Tests\Feature\Api\v1;

use App\Models\CourseAssignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseAssignmentTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_course_assignment_assignments()
    {
        $this->signIn();

        $assignment = CourseAssignment::factory()->create();

        $this->getJson('api/v1/course-assignments')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $assignment->id,
                        'level' => [
                            'id'   => $assignment->level_id,
                            'name' => $assignment->level->name,
                        ],
                        'grade' => [
                            'id'   => $assignment->grade_id,
                            'name' => $assignment->grade->name,
                        ],
                        'course' => [
                            'id'   => $assignment->course_id,
                            'name' => $assignment->course->name,
                        ],
                        'user' => [
                            'id'   => $assignment->user_id,
                            'name' => $assignment->user->name,
                        ],
                    ]
                ]
            ]);
    }
    
    function test_store_a_course_assignment()
    {
        $this->signIn();

        $data = CourseAssignment::factory()->make();

        $parameters = [
            'level_id'  => $data->level_id,
            'grade_id'  => $data->grade_id,
            'course_id' => $data->course_id,
            'user_id'   => $data->user_id,
        ];

        $this->postJson('api/v1/course-assignments/', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('course_assignments', [
            'level_id'  => $data->level_id,
            'grade_id'  => $data->grade_id,
            'course_id' => $data->course_id,
            'user_id'   => $data->user_id,
        ]);
    }
    
    function test_validate_before_store_a_course_assignment()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/course-assignments/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'level_id'  => ['El campo nivel escolar es obligatorio.'],
                    'grade_id'  => ['El campo grado escolar es obligatorio.'],
                    'course_id' => ['El campo curso es obligatorio.'],
                    'user_id'   => ['El campo usuario es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_course_assignment()
    {
        $this->signIn();

        $assignment = CourseAssignment::factory()->create();
        $data      = CourseAssignment::factory()->make();

        $parameters = [
            'level_id'  => $data->level_id,
            'grade_id'  => $data->grade_id,
            'course_id' => $data->course_id,
            'user_id'   => $data->user_id,
        ];

        $this->putJson('api/v1/course-assignments/'.$assignment->id, $parameters)
            ->assertStatus(200);

        $this->assertDatabaseHas('course_assignments', [
            'id'        => $assignment->id,
            'level_id'  => $data->level_id,
            'grade_id'  => $data->grade_id,
            'course_id' => $data->course_id,
            'user_id'   => $data->user_id,
        ]);
    }
    
    function test_validate_before_update_a_course_assignment()
    {
        $this->signIn();

        $assignment = CourseAssignment::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/course-assignments/'.$assignment->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'level_id'  => ['El campo nivel escolar es obligatorio.'],
                    'grade_id'  => ['El campo grado escolar es obligatorio.'],
                    'course_id' => ['El campo curso es obligatorio.'],
                    'user_id'   => ['El campo usuario es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_course_assignment()
    {
        $this->signIn();

        $assignment = CourseAssignment::factory()->create();

        $this->deleteJson('api/v1/course-assignments/'.$assignment->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('course_assignments', [
            'id' => $assignment->id
        ]);
    }

}