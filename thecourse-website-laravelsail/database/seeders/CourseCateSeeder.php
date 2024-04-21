<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseCateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_cates')->insert([
            ["name" => "Lập Trình Dưới 18 Tuổi",
            "created_at"=>now(),
            "updated_at"=>now(),
            "edu_id" => "1"],
            ["name" => "Cơ sở lý thuyết về mạng máy tính",
            "created_at"=>now(),
            "updated_at"=>now(),
            "edu_id" => "1"],
        ]);
    }
}
