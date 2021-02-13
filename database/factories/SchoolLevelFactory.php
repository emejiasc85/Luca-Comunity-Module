<?php

namespace Database\Factories;

use App\Models\SchoolLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word
        ];
    }
}
