<?php

namespace Tests\Feature\Api\v1;

use App\Models\Question;
use App\Models\QuestionFollow;
use App\Models\QuestionLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_questions()
    {
       
        $this->signIn();

        $question = Question::factory()->create();

        $this->getJson('api/v1/questions')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $question->id,
                        'question' => $question->question,
                        'description' => $question->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $question->assignment->level_id,
                                'name' => $question->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $question->assignment->grade_id,
                                'name' => $question->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $question->assignment->course_id,
                                'name' => $question->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $question->user_id,
                            'name' => $question->user->name,
                        ],
                    ]
                ]
            ]);
    }
    
    function test_list_questions_order_by_popularity()
    {
        $this->signIn();

        $question = Question::factory()->create();
        QuestionLike::factory()->times(4)->create(['question_id' => $question->id]);
        
        $otherQuestion = Question::factory()->create();
        QuestionLike::factory()->times(2)->create(['question_id' => $otherQuestion->id]);

        $parameters = [
            'popularity' => true,
        ];

        $this->call('GET','api/v1/questions', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $question->id,
                        'question' => $question->question,
                        'description' => $question->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $question->assignment->level_id,
                                'name' => $question->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $question->assignment->grade_id,
                                'name' => $question->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $question->assignment->course_id,
                                'name' => $question->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $question->user_id,
                            'name' => $question->user->name,
                        ],
                    ],
                    1 => [
                        'id'   => $otherQuestion->id,
                        'question' => $otherQuestion->question,
                        'description' => $otherQuestion->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $otherQuestion->assignment->level_id,
                                'name' => $otherQuestion->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $otherQuestion->assignment->grade_id,
                                'name' => $otherQuestion->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $otherQuestion->assignment->course_id,
                                'name' => $otherQuestion->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $otherQuestion->user_id,
                            'name' => $otherQuestion->user->name,
                        ],
                    ]
                ]
            ]);
    }
    
    function test_list_questions_order_by_newest()
    {
        $this->signIn();

        $question = Question::factory()->create();
        $otherQuestion = Question::factory()->create();

        $parameters = [
            'order_by' => 'created_at',
            'order'    => 'Desc',
        ];

        $this->getJson('api/v1/questions', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $question->id,
                        'question' => $question->question,
                        'description' => $question->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $question->assignment->level_id,
                                'name' => $question->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $question->assignment->grade_id,
                                'name' => $question->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $question->assignment->course_id,
                                'name' => $question->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $question->user_id,
                            'name' => $question->user->name,
                        ],
                    ],
                    1 => [
                        'id'   => $otherQuestion->id,
                        'question' => $otherQuestion->question,
                        'description' => $otherQuestion->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $otherQuestion->assignment->level_id,
                                'name' => $otherQuestion->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $otherQuestion->assignment->grade_id,
                                'name' => $otherQuestion->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $otherQuestion->assignment->course_id,
                                'name' => $otherQuestion->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $otherQuestion->user_id,
                            'name' => $otherQuestion->user->name,
                        ],
                    ]
                ]
            ]);
    }
    
    function test_list_questions_order_by_followed_user()
    {
        $user = $this->signIn();

        $question = Question::factory()->create();
        $otherQuestion = Question::factory()->create();

        $follow = QuestionFollow::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();

        $parameters = [
            'followed' => true,
            'order_by' => 'created_at',
            'order'    => 'Desc',
        ];

        $this->getJson('api/v1/questions', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'   => $question->id,
                        'question' => $question->question,
                        'description' => $question->description,
                        'assignment' => [
                            'level' => [
                                'id'   => $question->assignment->level_id,
                                'name' => $question->assignment->level->name,
                            ],
                            'grade' => [
                                'id'   => $question->assignment->grade_id,
                                'name' => $question->assignment->grade->name,
                            ],
                            'course' => [
                                'id'   => $question->assignment->course_id,
                                'name' => $question->assignment->course->name,
                            ],
                        ],
                        'user' => [
                            'id'   => $question->user_id,
                            'name' => $question->user->name,
                        ],
                    ],
                ]
            ]);
    }
    
    function test_show_question_details()
    {
        $this->signIn();

        $question = Question::factory()->create();

        $this->getJson('api/v1/questions/'.$question->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $question->id,
                    'question' => $question->question,
                    'description' => $question->description,
                    'assignment' => [
                        'level' => [
                            'id'   => $question->assignment->level_id,
                            'name' => $question->assignment->level->name,
                        ],
                        'grade' => [
                            'id'   => $question->assignment->grade_id,
                            'name' => $question->assignment->grade->name,
                        ],
                        'course' => [
                            'id'   => $question->assignment->course_id,
                            'name' => $question->assignment->course->name,
                        ],
                    ],
                    'user' => [
                        'id'   => $question->user_id,
                        'name' => $question->user->name,
                    ],
                ]
            ]);
    }
    
    function test_store_a_question()
    {

        $user = $this->signIn();

        $data = Question::factory()->make();

        $parameters = [
            'assignment_id' => $data->assignment_id,
            'question'      => $data->question,
            'description'   => $data->description,
        ];

        $this->postJson('api/v1/questions/', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'question'    => $data->question,
                    'description' => $data->description,
                ]
            ]);

        $this->assertDatabaseHas('questions', [
            'assignment_id' => $data->assignment_id,
            'user_id'       => $user->id,
            'question'      => $data->question,
            'description'   => $data->description,
        ]);
    }
    
    function test_validate_before_store_a_question()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/questions/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'assignment_id' => ['El campo curso asignado es obligatorio.'],
                    'question'      => ['El campo pregunta es obligatorio.'],
                    'description'   => ['El campo descripción es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_question()
    {
        $user = $this->signIn();

        $question  = Question::factory()->create([
            'user_id' => $user->id 
        ]);

        $data = Question::factory()->make();

        $parameters = [
            'assignment_id' => $data->assignment_id,
            'question'      => $data->question,
            'description'   => $data->description,
        ];

        $this->putJson('api/v1/questions/'.$question->id, $parameters)
            ->assertStatus(200)->assertJson([
                'data' => [
                    'id'          => $question->id,
                    'question'    => $data->question,
                    'description' => $data->description,
                ]
            ]);

        $this->assertDatabaseHas('questions', [
            'id'            => $question->id,
            'user_id'       => $user->id,
            'assignment_id' => $data->assignment_id,
            'question'      => $data->question,
            'description'   => $data->description,

        ]);
    }
    
    function test_validate_before_update_a_question()
    {
        $this->signIn();

        $question = Question::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/questions/'.$question->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'assignment_id' => ['El campo curso asignado es obligatorio.'],
                    'question'      => ['El campo pregunta es obligatorio.'],
                    'description'   => ['El campo descripción es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_question()
    {
        $this->signIn();

        $question = Question::factory()->create();

        $this->deleteJson('api/v1/questions/'.$question->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('questions', [
            'id' => $question->id
        ]);
    }

}