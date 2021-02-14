<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class SchoolLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolLevel::create([
            'name' => 'Primaria'
        ]);
        
        SchoolLevel::create([
            'name' => 'Secundaria'
        ]);
    }
}
