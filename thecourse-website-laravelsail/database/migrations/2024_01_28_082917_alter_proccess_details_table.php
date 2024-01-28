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
        Schema::table('proccess_details', function (Blueprint $table) {
            $table->foreignId('proccesse_id')->constrained();
            $table->foreignId('student_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proccess_details', function (Blueprint $table) {
            $table->dropForeign('proccess_details_proccesse_id_foreign');
            $table->dropColumn('proccesse_id');
            $table->dropForeign('proccess_details_student_id_foreign');
            $table->dropColumn('student_id');
        });
    }
};
