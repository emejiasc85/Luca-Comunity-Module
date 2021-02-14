<?php

namespace Database\Seeders;

use App\Models\SchoolGrade;
use Illuminate\Database\Seeder;

class SchoolGradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolGrade::create([
            'name'     => 'Primero',
            'level_id' => 1
        ]);
        SchoolGrade::create([
            'name'     => 'Segundo',
            'level_id' => 1
        ]);
    }
}
