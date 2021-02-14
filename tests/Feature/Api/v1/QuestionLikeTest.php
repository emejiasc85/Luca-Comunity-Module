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
        $user = $this->signIn();

        $question = Question::factory()->create();

        $this->postJson('api/v1/question/'.$question->id.'/likes')
            ->assertStatus(200);

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

        $this->postJson('api/v1/question/'.$question->id.'/likes')
            ->assertStatus(200);

        $this->assertDatabaseHas('question_likes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
        
        $this->assertDatabaseMissing('question_dislikes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
    }
    
    
    function test_an_user_can_toggle_like_a_question()
    {

        $user = $this->signIn();
        
        $question = Question::factory()->create();

        $like = QuestionLike::factory([
            'user_id'     => $user->id,
            'question_id' => $question->id
        ])->create();

        $this->postJson('api/v1/question/'.$question->id.'/likes')
            ->assertStatus(200);
        
        $this->assertDatabaseMissing('question_likes', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);


    }

}