<?php

namespace Tests\Feature\Api\v1;

use App\Models\Question;
use App\Models\QuestionDislike;
use App\Models\QuestionLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionDislikeTest extends TestCase{
    
    use RefreshDatabase;
    
    function test_an_user_can_dislike_a_question()
    {
        $user = $this->signIn();

        $question = Question::factory()->create();

        $this->postJson('api/v1/question/'.$question->id.'/dislikes')
            ->assertStatus(200);

        $this->assertDatabaseHas('question_dislikes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
    }
    
    function test_an_user_can_dislike_a_question_after_like()
    {
        $user = $this->signIn();

        $question = Question::factory()->create();

        $dislike = QuestionLike::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();

        $this->postJson('api/v1/question/'.$question->id.'/dislikes')
            ->assertStatus(200);

        $this->assertDatabaseHas('question_dislikes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
        
        $this->assertDatabaseMissing('question_likes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
        
    }
    
    function test_an_user_can_toggle_dislike_a_question()
    {
        $user = $this->signIn();

        $question = Question::factory()->create();

        $dislike = QuestionDislike::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();

        $this->postJson('api/v1/question/'.$question->id.'/dislikes')
            ->assertStatus(200);

            $this->assertDatabaseMissing('question_dislikes', [
                'question_id' => $question->id,
                'user_id'     => $user->id,
            ]);

        
    }

}