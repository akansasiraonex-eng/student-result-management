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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('code', 30)->unique();

            $table->string('name', 150);

            $table->text('description')->nullable();

            $table->unsignedTinyInteger('credit_units');

            $table->enum('course_type', [
                'core',
                'elective',
                'practical',
                'project'
            ])->default('core');

            $table->unsignedTinyInteger('year_of_study');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index([
                'department_id',
                'year_of_study',
                'is_active'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};