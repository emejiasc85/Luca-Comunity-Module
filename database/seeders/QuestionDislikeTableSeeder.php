<?php

namespace Database\Seeders;

use App\Models\QuestionDislike;
use Illuminate\Database\Seeder;

class QuestionDislikeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionDislike::create([
            'question_id'=> 1,
            'user_id'    => 1,
        ]);
    }
}
