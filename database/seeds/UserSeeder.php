<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Tomas',
            'email' => 'tombozik@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
