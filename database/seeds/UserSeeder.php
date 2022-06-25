<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Initialize Users
        User::create([
            'usr' => 'Teacher',
            'permissions' => 1,
            'password' => Hash::make("password"),
        ]);
        User::create([
            'usr' => 'Student',
            'permissions' => 2,
            'password' => Hash::make("password"),
        ]);
    }
}
