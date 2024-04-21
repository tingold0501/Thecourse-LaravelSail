<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('edus')->insert([
            "name" => "Lập Trình",
            "created_at"=>now(),
            "updated_at"=>now(),
        ]);
    }
}
