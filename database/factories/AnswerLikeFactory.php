<?php

namespace Database\Factories;

use App\Models\AnswerLike;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerLikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerLike::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory()->create()->id,
            'answer_id' => Answer::factory()->create()->id
        ];
    }
}
