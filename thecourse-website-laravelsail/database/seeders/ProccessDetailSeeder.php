<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProccessDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proccess_details')->insert([
            "created_at"=>now(),
            "updated_at"=>now(),
            "proccesse_id" => "1",
            "student_id" => "1",
        ]);
    }
}
