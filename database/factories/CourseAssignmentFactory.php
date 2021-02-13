<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\SchoolGrade;
use App\Models\SchoolLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseAssignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'level_id'  => SchoolLevel::factory()->create()->id,
            'grade_id'  => SchoolGrade::factory()->create()->id,
            'course_id' => Course::factory()->create()->id,
            'user_id'   => User::factory()->create()->id,
        ];
    }
}
