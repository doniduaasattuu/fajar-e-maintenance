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
            $table->string("power_rate", 10)->nullable(true);
            $table->enum("power_unit", ["kW", "HP"])->nullable(true);
            $table->string("voltage", 10)->nullable(true);
            $table->enum("electrical_current", ["AC", "DC"])->nullable(true);
            $table->string("current_nominal", 10)->nullable(true);
            $table->string("frequency", 10)->nullable(true);
            $table->string("pole", 5)->nullable(true);
            $table->string("rpm", 10)->nullable(true);
            $table->string("bearing_de", 25)->nullable(true);
            $table->string("bearing_nde", 25)->nullable(true);
            $table->string("frame_type", 25)->nullable(true);
            $table->string("shaft_diameter", 10)->nullable(true);
            $table->string("phase_supply", 3)->nullable(true);
            $table->string("cos_phi", 5)->nullable(true);
            $table->string("efficiency", 5)->nullable(true);
            $table->string("ip_rating", 10)->nullable(true);
            $table->string("insulation_class", 5)->nullable(true);
            $table->string("duty", 5)->nullable(true);
            $table->string("connection_type", 25)->nullable(true);
            $table->enum("nipple_grease", (["Available", "Not Available"]))->nullable(true);
            $table->string("greasing_type", 25)->nullable(true);
            $table->string("greasing_qty_de", 10)->nullable(true);
            $table->string("greasing_qty_nde", 10)->nullable(true);
            $table->string("length", 10)->nullable(true);
            $table->string("width", 10)->nullable(true);
            $table->string("height", 10)->nullable(true);
            $table->string("weight", 10)->nullable(true);
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
