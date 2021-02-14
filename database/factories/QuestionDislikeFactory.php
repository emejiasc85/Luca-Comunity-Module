<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionDislike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionDislikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionDislike::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => User::factory()->create()->id,
            'question_id' => Question::factory()->create()->id
        ];
    }
}
