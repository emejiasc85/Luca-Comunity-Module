<?php

namespace Database\Factories;

use App\Models\SchoolGrade;
use App\Models\SchoolLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolGradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolGrade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => $this->faker->unique()->word,
            'level_id' => SchoolLevel::factory()->create()->id
        ];
    }
}
