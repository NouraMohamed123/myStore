<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Noura Mohamed',
            'email' => 'noura@gmail.com',
            'password' => Hash::make('123123123'),
            'phone_number' => '1234567890',
            'store_id' => 1,
        ]);
    }
}