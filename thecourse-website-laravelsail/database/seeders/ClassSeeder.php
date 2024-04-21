<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->insert([
            "schedule" => "08:00 - 09:30 AM | Buổi học Lập trình cơ bản ",
            "created_at"=>now(),
            "updated_at"=>now(),
            "user_id" => "1",
            "course_id" => "1",
        ]);
    }
}
