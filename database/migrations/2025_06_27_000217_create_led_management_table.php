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
        Schema::create('led_management', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ["oral", "poster", "quiz"])->nullable();
            $table->integer("show_all")->default(false);
            $table->integer("show_first")->default(false);
            $table->integer("show_second")->default(false);
            $table->integer("show_third")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('led_management');
    }
};
