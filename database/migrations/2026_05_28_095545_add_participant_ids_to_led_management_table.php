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
        Schema::table('led_management', function (Blueprint $table) {
            $table->unsignedBigInteger('first_id')->nullable()->after('show_third');
            $table->unsignedBigInteger('second_id')->nullable()->after('first_id');
            $table->unsignedBigInteger('third_id')->nullable()->after('second_id');
        });
    }

    public function down(): void
    {
        Schema::table('led_management', function (Blueprint $table) {
            $table->dropColumn(['first_id', 'second_id', 'third_id', 'fourth_id']);
        });
    }
};
