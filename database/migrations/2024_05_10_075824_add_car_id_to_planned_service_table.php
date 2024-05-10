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
        Schema::table('planned_service', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->after('id');
            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planned_service', function (Blueprint $table) {
            $table->dropColumn('car_id');
        });
    }
};
