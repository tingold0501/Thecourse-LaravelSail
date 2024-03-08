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
            "name" => "Lập Trình Dưới 18 Tuổi",
            "edu_id" => "1",
        ]);
    }
}
