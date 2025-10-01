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
        Schema::table('appointments', function (Blueprint $table) {
            // FIX: We are constraining to the 'users' table because the doctor's authenticated ID 
            // (Auth::id() = 655) comes from the central 'users' table, which is a common pattern 
            // in multi-role applications.
            if (!Schema::hasColumn('appointments', 'doctor_id')) {
                $table->foreignId('doctor_id')->nullable()->constrained('users')->after('patient_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Check if the column and foreign key exist before dropping them
            if (Schema::hasColumn('appointments', 'doctor_id')) {
                // Always drop the foreign key constraint before dropping the column
                $table->dropForeign(['doctor_id']);
                
                $table->dropColumn('doctor_id');
            }
        });
    }
};
