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
        Schema::create('result_approvals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('result_id')
                ->constrained('results')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('action', [
                'submitted',
                'approved',
                'rejected',
                'returned',
                'published',
                'unpublished'
            ]);

            $table->text('comments')->nullable();

            $table->timestamp('action_at')->useCurrent();

            $table->timestamps();

            $table->index(['result_id', 'action_at']);
            $table->index(['approved_by', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_approvals');
    }
};