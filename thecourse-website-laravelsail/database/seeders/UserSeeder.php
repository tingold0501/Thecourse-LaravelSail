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
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "huynhtin0501@gmail.com",
            "password" => Hash::make("123"),
            "phone" => "0981651106",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "1"
        ]);
    }
}
