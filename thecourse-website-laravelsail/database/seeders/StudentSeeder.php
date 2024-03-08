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
            "name" => "Phạm Huỳnh Tín",
            "password" => Hash::make("123"),
            "email" => "phamhuynhtin050120@gmail.com",
            "phone" => "0981651108",
            
        ]);
    }
}
