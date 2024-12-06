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
        Schema::create('medicals', function (Blueprint $table) {
            $table->id('medicalId');
            $table->unsignedBigInteger('studentId');
            $table->string('illness')->nullable();
            $table->string('allergies')->nullable();
            $table->string('dental')->nullable();
            $table->text('attitudes')->nullable(); // Use text to store array data
            $table->timestamps();

            $table->foreign('studentId')->references('studentId')->on('students')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
