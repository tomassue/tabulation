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
        Schema::create('ref_participants', function (Blueprint $table) {
            $table->id();
            $table->string("participant_no")->nullable();
            $table->string("participant")->nullable();
            $table->text('category')->nullable();
            $table->text("school")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_participants');
    }
};
