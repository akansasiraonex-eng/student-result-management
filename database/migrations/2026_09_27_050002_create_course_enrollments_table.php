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
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('semester_id')
                ->constrained('semesters')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('status', [
                'enrolled',
                'completed',
                'dropped',
                'withdrawn',
                'deferred'
            ])->default('enrolled');

            $table->timestamp('enrolled_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['student_id', 'course_id', 'semester_id'],
                'student_course_semester_unique'
            );

            $table->index([
                'student_id',
                'semester_id',
                'status'
            ]);

            $table->index([
                'course_id',
                'semester_id',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};