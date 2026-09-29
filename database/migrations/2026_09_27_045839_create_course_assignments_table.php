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
        Schema::create('course_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('lecturer_id')
                ->constrained('lecturers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('semester_id')
                ->constrained('semesters')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('is_primary')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(
                ['course_id', 'lecturer_id', 'semester_id'],
                'course_lecturer_semester_unique'
            );

            $table->index([
                'lecturer_id',
                'semester_id',
                'is_active'
            ]);

            $table->index([
                'course_id',
                'semester_id',
                'is_active'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignments');
    }
};