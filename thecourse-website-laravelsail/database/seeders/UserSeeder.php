<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            "name" => "Admin",
            "email" => "huynhtin0501@gmail.com",
            "password" => Hash::make("123"),
            "phone" => "0981651106",
            "role_id" => "1"
        ]);
    }
}
