<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This updates the 'role' column to include 'patient' as a valid type.
     */
    public function up(): void
    {
        // Change the existing role column to include 'patient'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'doctor', 'patient'])
                  ->default('patient') // Setting 'patient' as the new default role upon registration
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This reverts the role column back to the previous two roles.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'doctor'])
                  ->default('admin')
                  ->change();
        });
    }
};
