<?php

namespace Tests\Feature\Api\v1;

use App\Models\Answer;
use App\Models\AnswerDislike;
use App\Models\AnswerLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerLikeTest extends TestCase{
    
    use RefreshDatabase;
    
    function test_an_user_can_like_a_answer()
    {
        $user = $this->signIn();

        $answer = Answer::factory()->create();

        $this->postJson('api/v1/answer/'.$answer->id.'/likes')
            ->assertStatus(200);

        $this->assertDatabaseHas('answer_likes', [
            'answer_id'   => $answer->id,
            'user_id'     => $user->id,
        ]);
    }
    
    function test_an_user_can_like_a_answer_after_dislike()
    {
        $user = $this->signIn();

        $answer = Answer::factory()->create();

        $like = AnswerDislike::factory([
            'user_id'   => $user->id,
            'answer_id' => $answer->id
        ])->create();

        $this->postJson('api/v1/answer/'.$answer->id.'/likes')
            ->assertStatus(200);

        $this->assertDatabaseHas('answer_likes', [
            'answer_id' => $answer->id,
            'user_id'     => $user->id,
        ]);
        
        $this->assertDatabaseMissing('answer_dislikes', [
            'answer_id' => $answer->id,
            'user_id'   => $user->id,
        ]);
    }
    
    
    function test_an_user_can_toggle_like_a_answer()
    {
        
        $user = $this->signIn();
        
        $answer = Answer::factory()->create();

        $like = AnswerLike::factory([
            'user_id'   => $user->id,
            'answer_id' => $answer->id
        ])->create();

        $this->postJson('api/v1/answer/'.$answer->id.'/likes')
            ->assertStatus(200);
        
        $this->assertDatabaseMissing('answer_likes', [
            'answer_id' => $answer->id,
            'user_id'   => $user->id,
        ]);


    }

}