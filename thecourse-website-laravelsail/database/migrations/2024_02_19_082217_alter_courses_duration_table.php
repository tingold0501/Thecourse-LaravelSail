<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses_durations', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses_durations', function (Blueprint $table) {
            $table->dropForeign('courses_durations_course_id_foreign');
            $table->dropColumn('course_id');
        });
    }
};
