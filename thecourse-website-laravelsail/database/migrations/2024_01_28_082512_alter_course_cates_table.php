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
        Schema::table('course_cates', function (Blueprint $table) {
            $table->foreignId('edu_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_cates', function (Blueprint $table) {
            $table->dropForeign('course_cates_edu_id_foreign');
            $table->dropColumn('edu_id');
        });
    }
};
