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
        Schema::create('trafo_details', function (Blueprint $table) {
            $table->id();
            $table->string('trafo_detail', 9)->nullable(false)->unique();
            $table->string('power_rate', 50)->nullable(true);
            $table->enum('power_unit', ['VA', 'kVA', 'MVA'])->nullable(true);
            $table->string('primary_voltage', 50)->nullable(true);
            $table->string('secondary_voltage', 50)->nullable(true);
            $table->string('primary_current', 50)->nullable(true);
            $table->string('secondary_current', 50)->nullable(true);
            $table->string('primary_connection_type', 50)->nullable(true);
            $table->string('secondary_connection_type', 50)->nullable(true);
            $table->string('frequency', 50)->nullable(true);
            $table->enum('type', ['Step Up', 'Step Down'])->nullable(true);
            $table->string('manufacturer', 50)->nullable(true);
            $table->string('year_of_manufacture', 4)->nullable(true);
            $table->string('serial_number', 50)->nullable(true);
            $table->string('vector_group', 50)->nullable(true);
            $table->string('insulation_class', 50)->nullable(true);
            $table->string('type_of_cooling', 50)->nullable(true);
            $table->string('temp_rise_oil_winding', 50)->nullable(true);
            $table->string('weight', 50)->nullable(true);
            $table->string('weight_of_oil', 50)->nullable(true);
            $table->string('oil_type', 50)->nullable(true);
            $table->string('ip_rating', 50)->nullable(true);
            $table->timestamps();

            $table->foreign('trafo_detail')->references('id')->on('trafos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trafo_details');
    }
};
