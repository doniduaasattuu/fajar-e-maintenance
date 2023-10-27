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
        Schema::create('emo_details', function (Blueprint $table) {
            $table->id();
            $table->string("emo_detail", 9)->nullable(false);

            $table->string("manufacture", 150)->nullable(true);
            $table->string("serial_number", 150)->nullable(true);
            $table->string("type", 150)->nullable(true);
            $table->string("power_rate", 25)->nullable(true);
            $table->enum("power_unit", ["kW", "HP"])->nullable(true);

            $table->string("voltage", 25)->nullable(true);
            $table->string("current_nominal", 25)->nullable(true);
            $table->string("frequency", 25)->nullable(true);
            $table->string("pole", 25)->nullable(true);
            $table->string("rpm", 25)->nullable(true);

            $table->string("bearing_de", 50)->nullable(true);
            $table->string("bearing_nde", 50)->nullable(true);
            $table->string("frame_type", 50)->nullable(true);
            $table->string("shaft_diameter", 25)->nullable(true);
            $table->string("phase_supply", 25)->nullable(true);

            $table->string("cos_phi", 25)->nullable(true);
            $table->string("efficiency", 25)->nullable(true);
            $table->string("ip_rating", 25)->nullable(true);
            $table->string("insulation_class", 25)->nullable(true);
            $table->string("duty", 25)->nullable(true);

            $table->string("connection_type", 50)->nullable(true);
            $table->enum("nipple_grease", (["Available", "Not Available"]))->nullable(true);
            $table->string("greasing_type", 50)->nullable(true);
            $table->string("greasing_qty_de", 25)->nullable(true);
            $table->string("greasing_qty_nde", 25)->nullable(true);

            $table->string("length", 25)->nullable(true);
            $table->string("width", 25)->nullable(true);
            $table->string("height", 25)->nullable(true);
            $table->string("weight", 25)->nullable(true);
            $table->enum("cooling_fan", (["Internal", "External", "Not Available"]))->nullable(true);

            $table->enum("mounting", ["Horizontal", "Vertical", "V/H", "MGM"])->nullable(true);

            $table->foreign("emo_detail")->references("id")->on("emos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emo_details');
    }
};
