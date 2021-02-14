<?php

namespace Database\Seeders;

use App\Models\QuestionFavorite;
use Illuminate\Database\Seeder;

class QuestionFavorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionFavorite::create([
            'question_id'=> 1,
            'user_id'    => 1,
        ]);
    }
}
