<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_categories', function (Blueprint $table) {
            $table->id();
            $table->string('competition_category');
            $table->string('name');
            $table->string('slug');
            $table->integer('max_score')->default(100);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_categories');
    }
};
