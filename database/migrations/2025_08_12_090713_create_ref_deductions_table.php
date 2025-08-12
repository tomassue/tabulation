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
        Schema::create('ref_deductions', function (Blueprint $table) {
            $table->id();
            $table->text('category')->nullable();
            $table->text('deduction_name')->nullable();
            $table->text('deduction')->nullable();
            $table->integer('checked')->default(0)->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_deductions');
    }
};
