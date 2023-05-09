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
        Schema::table('meeting_points', function (Blueprint $table) {
            $table->enum('type', ['event', 'meeting_point'])->default('meeting_point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_points', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
