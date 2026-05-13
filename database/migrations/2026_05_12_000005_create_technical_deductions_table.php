<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('ref_participants')->cascadeOnDelete();
            $table->string('competition_category');
            // technical_minor = 1pt, technical_major = 3pt, penalty = 10pt
            $table->enum('type', ['technical_minor', 'technical_major', 'penalty']);
            $table->integer('count')->default(0);
            $table->decimal('total_deduction', 7, 1)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['participant_id', 'competition_category', 'type'], 'technical_deductions_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_deductions');
    }
};
