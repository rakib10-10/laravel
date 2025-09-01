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
        Schema::create('doctors', function (Blueprint $table) {
        $table->id();
        
        // Relation to users table
        $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

        // Personal details
        $table->string('name'); // Doctor full name
        $table->string('contact')->nullable(); // phone number
        $table->string('address')->nullable();
        $table->string('country')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('blood_group', 3)->nullable(); // A+, O-, etc.

        // Professional details
        $table->string('specialization');
        $table->string('designation')->nullable(); // e.g., Consultant, Professor
        $table->string('department')->nullable();
        $table->string('license_number')->unique();
        $table->date('date_of_joining')->nullable();
        $table->integer('work_experience')->nullable(); // in years

        // Contact/email
        $table->string('email')->unique();

        // Laravel timestamps
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
