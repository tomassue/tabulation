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
            $table->unsignedBigInteger('fourth_id')->nullable()->after('third_id');
            $table->integer('show_fourth')->default(0)->after('show_third');
        });
    }

    public function down(): void
    {
        Schema::table('led_management', function (Blueprint $table) {
            $table->dropColumn(['fourth_id', 'show_fourth']);
        });
    }
};
