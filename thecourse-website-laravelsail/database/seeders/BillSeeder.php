<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bills')->insert([
            "name" => "Thanh Toán Khoá Học Lập Trình Website Dưới 18 Tuổi",
            "email" => "phamhuynhtin050120@gmail.com",
            "phone" => "0981651106",
            "created_at"=>now(),
            "updated_at"=>now(),
            "classe_id" => "1",
            "courses_duration_id" => "1",
        ]);
    }
}
