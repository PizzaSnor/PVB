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
        Schema::table('occasion_images', function (Blueprint $table) {
            $table->unsignedBigInteger('occasion_id')->after('id');
            $table->foreign('occasion_id')->references('id')->on('occasions')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('occasion_images', function (Blueprint $table) {
            $table->drop('occasion_id');
        });
    }
};
