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
        Schema::create('motor_details', function (Blueprint $table) {
            $table->id();
            $table->string("motor_detail", 9)->nullable(false)->unique();
            $table->string("manufacturer", 50)->nullable(true);
            $table->string("serial_number", 50)->nullable(true);
            $table->string("type", 50)->nullable(true);
            $table->string("power_rate", 50)->nullable(true);
            $table->enum("power_unit", ["kW", "HP"])->nullable(true);
            $table->string("voltage", 50)->nullable(true);
            $table->enum("electrical_current", ["AC", "DC"])->nullable(true);
            $table->string("current_nominal", 50)->nullable(true);
            $table->string("frequency", 50)->nullable(true);
            $table->string("pole", 50)->nullable(true);
            $table->string("rpm", 50)->nullable(true);
            $table->string("bearing_de", 50)->nullable(true);
            $table->string("bearing_nde", 50)->nullable(true);
            $table->string("frame_type", 50)->nullable(true);
            $table->string("shaft_diameter", 50)->nullable(true);
            $table->string("phase_supply", 50)->nullable(true);
            $table->string("cos_phi", 50)->nullable(true);
            $table->string("efficiency", 50)->nullable(true);
            $table->string("ip_rating", 50)->nullable(true);
            $table->string("insulation_class", 50)->nullable(true);
            $table->string("duty", 50)->nullable(true);
            $table->string("connection_type", 50)->nullable(true);
            $table->enum("nipple_grease", (["Available", "Not Available"]))->nullable(true);
            $table->string("greasing_type", 50)->nullable(true);
            $table->string("greasing_qty_de", 50)->nullable(true);
            $table->string("greasing_qty_nde", 50)->nullable(true);
            $table->string("length", 50)->nullable(true);
            $table->string("width", 50)->nullable(true);
            $table->string("height", 50)->nullable(true);
            $table->string("weight", 50)->nullable(true);
            $table->enum("cooling_fan", (["Internal", "External", "Not Available"]))->nullable(true);
            $table->enum("mounting", ["Horizontal", "Vertical", "V/H", "MGM"])->nullable(true);
            $table->timestamps();

            $table->foreign("motor_detail")->references("id")->on("motors");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor_details');
    }
};
