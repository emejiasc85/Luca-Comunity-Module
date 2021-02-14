<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory([
            'email'    => 'enrique@emejias.com',
            'age'      => 35,
            'password' => 'password'
        ])->create();
    }
}
