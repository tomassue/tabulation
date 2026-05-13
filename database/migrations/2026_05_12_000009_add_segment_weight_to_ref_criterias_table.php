<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ref_criterias', function (Blueprint $table) {
            $table->unsignedTinyInteger('segment_weight')->nullable()->after('segment');
        });
    }

    public function down(): void
    {
        Schema::table('ref_criterias', function (Blueprint $table) {
            $table->dropColumn('segment_weight');
        });
    }
};
