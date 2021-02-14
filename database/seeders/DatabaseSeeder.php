<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenderTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SchoolLevelTableSeeder::class);
        $this->call(SchoolGradeTableSeeder::class);
        $this->call(CourseTableSeeder::class);
        $this->call(CourseAssignmentTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(AnswerTableSeeder::class);
        $this->call(QuestionFollowTableSeeder::class);
        $this->call(QuestionFavorityTableSeeder::class);
        $this->call(QuestionLikeTableSeeder::class);
        $this->call(QuestionDislikeTableSeeder::class);
    }
}
