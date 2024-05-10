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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->char('licence_plate', 50);
            $table->integer('odometer');
            $table->char('brand', 50);
            $table->char('model', 255);
            $table->char('color', 50);
            $table->integer('year');
            $table->char('body', 50);
            $table->char('fuel_type', 50);
            $table->char('power', 50);
            $table->char('doors', 50);
            $table->char('seats', 50);
            $table->dateTime('apk_end_date');
            $table->char('fuel_efficiency', 50);
            $table->char('cc', 50);
            $table->char('weight', 50);
            $table->char('tax', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
