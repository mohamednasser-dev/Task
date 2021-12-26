<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Supervisor::create([
            'name' => 'Ahmed',
            'email' => 'super@gmail.com',
            'password' => '123456',
            'phone' => '01201636129',
            'image' => 'default.png',
        ]);
    }
}
