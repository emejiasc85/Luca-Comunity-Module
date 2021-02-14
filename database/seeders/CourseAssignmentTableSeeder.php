<?php

namespace Database\Seeders;

use App\Models\CourseAssignment;
use Illuminate\Database\Seeder;

class CourseAssignmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseAssignment::factory()->times(20)->create([
            'level_id' => 1,
            'grade_id' => 1,
            'course_id'   => rand(1,15),
            'user_id'     => rand(1,15)  
        ]);
    }
}
