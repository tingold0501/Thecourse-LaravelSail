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
        Schema::table('bills', function (Blueprint $table) {
            $table->foreignId('classe_id')->constrained();
            $table->foreignId('courses_duration_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign('bills_classe_id_foreign');
            $table->dropColumn('classe_id');
            $table->dropForeign('bills_courses_duration_id_foreign');
            $table->dropColumn('courses_duration_id');
        });
    }
};
