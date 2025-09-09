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
         Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('dosage_form')->nullable();   // e.g. Tablet, Syrup
        $table->string('strength')->nullable();      // e.g. 500mg
        $table->string('manufacturer')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
