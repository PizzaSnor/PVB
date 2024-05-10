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
        Schema::create('occasions', function (Blueprint $table) {
            $table->id();
            $table->char('title', 50);
            $table->text('description')->nullable();
            $table->char('price', 50);
            $table->char('licence_plate', 50);
            $table->integer('odometer');
            $table->boolean('sold')->default(false);
            $table->boolean('show_whel_sold')->default(true);
            $table->char('brand', 50);
            $table->char('model', 255);
            $table->char('color', 50);
            $table->integer('year');
            $table->char('body', 50);
            $table->char('fuel_type', 50);
            $table->char('transmission', 50);
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
        Schema::dropIfExists('occasions');
    }
};
