<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technical_category_id')->constrained('technical_categories')->cascadeOnDelete();
            $table->string('sub_group')->nullable();
            $table->string('name');
            $table->decimal('max_score', 6, 1)->default(10);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_sub_criterias');
    }
};
