<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20 ; $i++) { 
            Answer::create([
                'question_id' => 1,
                'description' => Str::random(50),
                'user_id'      => rand(1,5)
            ]);
        }
    }
}
