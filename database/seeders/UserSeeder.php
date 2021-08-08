<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => 'admin',
            'email' => 'appkadokita@gmail.com',
            'password' => bcrypt('kadokita2021'),
            'email_verified_at' => now(),
            'fullname' => 'Admin',
            'address' => 'Jl. Sendok gang Garpu No 4 Medan',
            'province_id' => 34,
            'city_id' => 278,
            'zip_code' => '20118',
            'phone_number' => '082304303505',
            'account_number' => '10600xxxxxx'
        ]);

        $admin->assignRole('admin');

    }
}
