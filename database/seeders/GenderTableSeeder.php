<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::create([
            'id'   => 1,
            'name' => 'Femenino'
        ]);
        
        Gender::create([
            'id'   => 2,
            'name' => 'Masculino'
        ]);

        Gender::create([
            'id'   => 3,
            'name' => 'Otro'
        ]);
    }
}
