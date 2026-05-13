<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('ref_participants')->cascadeOnDelete();
            $table->foreignId('judge_id')->constrained('ref_judges')->cascadeOnDelete();
            $table->foreignId('sub_criteria_id')->constrained('technical_sub_criterias')->cascadeOnDelete();
            $table->string('competition_category');
            $table->decimal('score', 6, 1)->default(0);
            $table->timestamps();

            $table->unique(['participant_id', 'judge_id', 'sub_criteria_id', 'competition_category'], 'technical_scores_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_scores');
    }
};
