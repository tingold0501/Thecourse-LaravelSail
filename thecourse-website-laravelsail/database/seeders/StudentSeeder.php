<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
            "name" => "Phạm Huỳnh Tín",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "phamhuynhtin050120@gmail.com",
            "phone" => "0981651108",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
            [
            "name" => "Nguyễn Thi Nguyễn",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "nguyentinhung@gmail",
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
            [
            "name" => "Nguyễn Tiên Hưng",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "nguyentinhung@gmail",
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
            [
            "name" => "Nguyễn Thúy Hưng",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "nguyentinhung@gmail",
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
            [
            "name" => "Nguyễn Thúy Cường",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "nguyentinhung@gmail",
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
            [
            "name" => "Nguyễn Thúy Hằng",
            "avatar" => "https://i.pinimg.com/564x/e8/9d/29/e89d292e76d2ffee19e7f17f7f9c6734.jpg",
            "password" => Hash::make("123"),
            "email" => "nguyentinhung@gmail",
            "phone" => "0981651109",
            "created_at"=>now(),
            "updated_at"=>now(),
            ],
        ]);
    }
}
