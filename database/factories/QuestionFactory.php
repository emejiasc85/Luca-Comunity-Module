<?php

namespace Database\Factories;

use App\Models\CourseAssignment;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question'      => $this->faker->paragraph(1),
            'description'   => $this->faker->paragraph(2),
            'user_id'       => User::factory()->create()->id,
            'assignment_id' => CourseAssignment::factory()->create()->id,
        ];
    }
}
