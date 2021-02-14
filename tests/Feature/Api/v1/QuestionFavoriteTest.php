<?php

namespace Tests\Feature\Api\v1;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionFavoriteTest extends TestCase{
    
    use RefreshDatabase;
    
    function test_an_user_can_toggle_favorite_a_question()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $question = Question::factory()->create();

        $this->postJson('api/v1/question/'.$question->id.'/favorites')
            ->assertStatus(200);

        $this->assertDatabaseHas('question_favorites', [
            'question_id' => $question->id,
            'user_id'     => $user->id,
        ]);
    }

}