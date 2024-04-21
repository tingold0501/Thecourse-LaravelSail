<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proccesses')->insert([
            "name" => "Lập Trình",
            "schedules" => "08:00 - 09:30 AM | Buổi học Lập trình cơ bản",
            "duration" => "10",
            "pass" => "10",
            "created_at"=>now(),
            "updated_at"=>now(),
            "user_id" => "1",
            "course_id" => "1",
        ]);
    }
}
