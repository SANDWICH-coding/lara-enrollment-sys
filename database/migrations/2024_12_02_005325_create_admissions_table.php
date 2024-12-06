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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id('admissionId');
            $table->string('admissionNo');
            $table->integer('schoolYearId');
            $table->integer('yearLevelId');
            $table->integer('sectionId')->nullable();
            $table->unsignedBigInteger('studentId');
            $table->string('status');
            $table->timestamps();

            $table->foreign('studentId')->references('studentId')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
