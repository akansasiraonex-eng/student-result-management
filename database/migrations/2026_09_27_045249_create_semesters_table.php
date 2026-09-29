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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('academic_year_id')
                ->constrained('academic_years')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name', 50);
            $table->unsignedTinyInteger('semester_number');

            $table->date('start_date');
            $table->date('end_date');

            $table->boolean('is_current')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(
                ['academic_year_id', 'semester_number'],
                'academic_year_semester_unique'
            );

            $table->index(['academic_year_id', 'is_current']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};