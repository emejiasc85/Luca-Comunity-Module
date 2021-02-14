<?php

namespace Tests\Feature\Api\v1;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_courses()
    {
        $this->signIn();

        $course = Course::factory()->create();

        $this->getJson('api/v1/courses')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $course->id,
                        'name' => $course->name,
                    ]
                ]
            ]);
    }
    
    function test_filter_courses_by_keyword()
    {
        $this->signIn();

        $course      = Course::factory()->create();
        $otherCourse = Course::factory()->create();

        $parameters = [
            'search' =>  $otherCourse->name
        ];

        $this->call('GET','api/v1/courses', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $otherCourse->id,
                        'name' => $otherCourse->name,
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    0 => [
                        'id'   => $course->id,
                        'name' => $course->name,
                    ]
                ]
            ]);
    }
    
    function test_show_course()
    {
        $this->signIn();

        $course = Course::factory()->create();

        $this->getJson('api/v1/courses/'.$course->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $course->id,
                    'name' => $course->name
                ]
            ]);
    }
    
    function test_store_a_course()
    {
        $this->signIn();

        $data = Course::factory()->make();

        $parameters = [
            'name' => $data->name,
        ];

        $this->postJson('api/v1/courses/', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('courses', [
            'name' => $data->name,
        ]);
    }
    
    
    function test_validate_before_store_a_course()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/courses/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_course()
    {
        $this->signIn();

        $course = Course::factory()->create();
        $data   = Course::factory()->make();

        $parameters = [
            'name' => $data->name,
        ];

        $this->putJson('api/v1/courses/'.$course->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $course->id,
                    'name' => $data->name,
                ]
            ]);

        $this->assertDatabaseHas('courses', [
            'id'   => $course->id,
            'name' => $data->name,
        ]);
    }
    
    function test_validate_before_update_a_course()
    {
        $this->signIn();

        $course = Course::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/courses/'.$course->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_course()
    {
        $this->signIn();

        $course = Course::factory()->create();

        $this->deleteJson('api/v1/courses/'.$course->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('courses', [
            'id' => $course->id
        ]);
    }

}