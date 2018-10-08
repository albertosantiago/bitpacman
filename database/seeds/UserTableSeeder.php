<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        User::create(['username' => 'user21',
                      'password' => Hash::make("Password_Test")
                      ]);
    }
}
