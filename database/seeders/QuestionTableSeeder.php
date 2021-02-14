<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0; $i < 20; $i++) { 
            Question::create([
                'assignment_id' => 1,
                'user_id'       => 1,
                'question'      => Str::random(50),
                'description'   => Str::random(50)
            ]);
        }
    }
}
