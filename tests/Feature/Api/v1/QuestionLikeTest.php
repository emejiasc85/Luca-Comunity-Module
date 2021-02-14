<?php

namespace Tests\Feature\Api\v1;

use App\Models\Question;
use App\Models\QuestionDislike;
use App\Models\QuestionLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionLikeTest extends TestCase{
    
    use RefreshDatabase;
    
    function test_an_user_can_like_a_question()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $question = Question::factory()->create();

        $parameters = [
            'like' => true
        ];

        $this->postJson('api/v1/question/'.$question->id.'/likes', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('question_likes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
    }
    
    function test_an_user_can_like_a_question_after_dislike()
    {
        $user = $this->signIn();

        $question = Question::factory()->create();

        $like = QuestionDislike::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();

        $parameters = [
            'like' => true
        ];

        $this->postJson('api/v1/question/'.$question->id.'/likes', $parameters)
            ->assertStatus(201);

        $this->assertDatabaseHas('question_likes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
        
        $this->assertDatabaseMissing('question_dislikes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
    }
    
    
    function test_an_user_can_like_a_question_once()
    {
        $user = $this->signIn();

        
        $question = Question::factory()->create();

        $like = QuestionLike::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();
        
        $parameters = [
            'like' => true
        ];

        $this->postJson('api/v1/question/'.$question->id.'/likes', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'like' => ['Ya has registrado que te gusta esta pregunta.']
                ],
            ]);
    }

}