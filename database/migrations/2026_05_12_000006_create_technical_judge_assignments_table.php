<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_judge_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('judge_id')->constrained('ref_judges')->cascadeOnDelete();
            $table->foreignId('technical_category_id')->constrained('technical_categories')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['judge_id', 'technical_category_id'], 'tja_judge_techcat_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_judge_assignments');
    }
};
