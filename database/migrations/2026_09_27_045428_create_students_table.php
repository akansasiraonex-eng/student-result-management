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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('program_id')
                ->constrained('programs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('admission_academic_year_id')
                ->constrained('academic_years')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('student_number', 50)->unique();

            $table->string('registration_number', 50)->unique();

            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);

            $table->date('date_of_birth')->nullable();

            $table->string('gender', 20)->nullable();

            $table->string('nationality', 100)->nullable();

            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();

            $table->date('admission_date')->nullable();

            $table->enum('status', [
                'active',
                'graduated',
                'suspended',
                'withdrawn',
                'deferred'
            ])->default('active');

            $table->timestamps();

            $table->index(['program_id', 'status']);
            $table->index(['admission_academic_year_id', 'status']);
            $table->index(['last_name', 'first_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};