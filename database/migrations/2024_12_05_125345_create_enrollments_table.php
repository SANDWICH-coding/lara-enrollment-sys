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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id('enrollmentId');
            $table->string('admissionNo');
            $table->unsignedBigInteger('studentId');
            $table->integer('schoolYearId');
            $table->integer('yearLevelId');
            $table->integer('sectionId')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');            
            $table->timestamps();

            $table->foreign('studentId')->references('studentId')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
