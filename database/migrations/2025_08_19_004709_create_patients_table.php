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

        Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('patient_id')->unique()->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name'); 
        $table->date('date_of_birth');
        $table->enum('gender', ['Male', 'Female', 'Other']);
        $table->string('blood_type', 3);
        $table->string('address');
        $table->string('phone');
        $table->string('email')->unique()->nullable();
        $table->string('emergency_contact');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
