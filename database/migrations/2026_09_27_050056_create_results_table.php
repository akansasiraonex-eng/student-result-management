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
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_enrollment_id')
                ->constrained('course_enrollments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('coursework_mark', 5, 2)->default(0);
            $table->decimal('final_exam_mark', 5, 2)->default(0);

            $table->decimal('total_mark', 5, 2)->default(0);

            $table->string('grade', 5)->nullable();

            $table->decimal('grade_point', 4, 2)->nullable();

            $table->decimal('credit_units', 4, 1)->nullable();

            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'published',
                'rejected'
            ])->default('draft');

            $table->text('remarks')->nullable();

            $table->foreignId('entered_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->unique(
                'course_enrollment_id',
                'result_enrollment_unique'
            );

            $table->index(['status']);
            $table->index(['entered_by', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};