<?php

namespace Tests\Feature\Api\v1;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_answers()
    {
        $this->signIn();

        $answer = Answer::factory()->create();

        $this->getJson('api/v1/question/'.$answer->question_id.'/answers')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'          => $answer->id,
                        'description' => $answer->description,
                    ]
                ]
            ]);
    }
    
    function test_store_a_answer()
    {

        $user = $this->signIn();

        $data = Answer::factory()->make();

        $parameters = [
            'question_id' => $data->question_id,
            'description' => $data->description,
        ];

        $this->postJson('api/v1/question/'.$data->question_id.'/answers', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'description' => $data->description,
                ]
            ]);

        $this->assertDatabaseHas('answers', [
            'question_id' => $data->question_id,
            'user_id'     => $user->id,
            'description' => $data->description,
        ]);
    }
    
    function test_validate_before_store_a_answer()
    {
        $this->signIn();

        $question = Question::factory()->create();

        $parameters = [];

        $this->postJson('api/v1/question/'.$question->id.'/answers', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'description' => ['El campo respuesta es obligatorio.'],
                ]
            ]);
    }
    
    function test_update_a_answer()
    {
        $user = $this->signIn();

        $answer  = Answer::factory()->create([
            'user_id' => $user->id 
        ]);

        $data = Answer::factory()->make();

        $parameters = [
            'description' => $data->description,
        ];

        $this->putJson('api/v1/question/'.$answer->question_id.'/answers/'.$answer->id, $parameters)
            ->assertStatus(200)->assertJson([
                'data' => [
                    'id'          => $answer->id,
                    'description' => $data->description,
                ]
            ]);

        $this->assertDatabaseHas('answers', [
            'id'            => $answer->id,
            'user_id'       => $user->id,
            'question_id'   => $answer->question_id,
            'description'   => $data->description,
        ]);
    }
    
    function test_validate_before_update_a_answer()
    {
        $this->signIn();

        $answer = Answer::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/question/'.$answer->question_id.'/answers/'.$answer->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'description'   => ['El campo respuesta es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_a_answer()
    {
        $this->signIn();

        $answer = Answer::factory()->create();

        $this->deleteJson('api/v1/question/'.$answer->question_id.'/answers/'.$answer->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('answers', [
            'id' => $answer->id
        ]);
    }

}