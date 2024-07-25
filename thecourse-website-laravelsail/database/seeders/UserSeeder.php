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
            [
            "name" => "Admin",
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "huynhtin0501@gmail.com",
            "password" => Hash::make("123"),
            "phone" => "0981651106",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "1"
            ],
            [
            "name" => "User",
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "user@gmail",
            "password" => Hash::make("123"),
            "phone" => "0981651104",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "5"
            ],
            [
            "name" => "Phạm Huỳnh Tín",
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "phamhuynhtin050120@gmail.com",
            "password" => Hash::make("123"),
            "phone" => "0981651108",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "5"
            ],
            [
            "name" => "Nguyễn Tiên Hưng",
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "nguyentinhung@gmail",
            "password" => Hash::make("123"),
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "5"
            ],
            [
            "name" => "Nguyễn Thi Nguyễn",
            "avatar" => "http://localhost/images/46e29cd8e0e64b6b819f41442c08d6bd.jpg",
            "email" => "nguyentinhung1@gmail",
            "password" => Hash::make("123"),
            "phone" => "0981651101",
            "created_at"=>now(),
            "updated_at"=>now(),
            "role_id" => "5"
            ],
        ]);
    }
}
