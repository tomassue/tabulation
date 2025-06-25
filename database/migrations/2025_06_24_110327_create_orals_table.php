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
        Schema::create('orals', function (Blueprint $table) {
            $table->id();
            $table->integer("participant_id")->nullable();
            $table->integer("score")->nullable();
            $table->integer("criteria_id")->nullable();
            $table->integer("judge_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orals');
    }
};
