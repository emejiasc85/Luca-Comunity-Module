<?php

namespace Database\Seeders;

use App\Models\QuestionFollow;
use Illuminate\Database\Seeder;

class QuestionFollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionFollow::create([
            'question_id'=> 1,
            'user_id'    => 1,
        ]);
    }
}
