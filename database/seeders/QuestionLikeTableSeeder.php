<?php

namespace Database\Seeders;

use App\Models\QuestionLike;
use Illuminate\Database\Seeder;

class QuestionLikeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionLike::create([
            'question_id'=> 1,
            'user_id'    => 1,
        ]);
    }
}
