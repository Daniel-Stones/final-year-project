<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(['name' => 'User A', 'email' => 'userA@gmail.com', 'password' => Hash::make('UserAPassword')]);
        DB::table('users')->insert(['name' => 'User B', 'email' => 'userB@hotmail.co.uk', 'password' => Hash::make('UserBPassword')]);

    }
}
