<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses_durations')->insert([
            "duration" => "6",
            "price" => "20000000",
            "created_at"=>now(),
            "updated_at"=>now(),
            "course_id" => "1",
        ]);
    }
}
