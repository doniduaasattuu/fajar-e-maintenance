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
            $table->string("emo", 9)->nullable(false);

            $table->string("manufacture", 150)->nullable(true);
            $table->string("serial_number", 150)->nullable(true);
            $table->string("type", 150)->nullable(true);
            $table->string("power_rate", 5)->nullable(true);
            $table->enum("power_unit", ["kW", "HP"])->nullable(true);

            $table->string("voltage", 25)->nullable(true);
            $table->string("current_nominal", 25)->nullable(true);
            $table->string("frequency", 3)->nullable(true);
            $table->enum("pole", ["2", "4", "6", "8", "10", "12", "14", "16"])->nullable(true);
            $table->string("rpm", 25)->nullable(true);

            $table->string("bearing_de", 50)->nullable(true);
            $table->string("bearing_nde", 50)->nullable(true);
            $table->string("frame_type", 50)->nullable(true);
            $table->unsignedSmallInteger("shaft_diameter")->nullable(true);
            $table->char("phase_supply", 1)->nullable(true);

            $table->char("cos_phi", 4)->nullable(true);
            $table->char("efficiency", 4)->nullable(true);
            $table->char("ip_rating", 2)->nullable(true);
            $table->char("insulation_class", 1)->nullable(true);
            $table->char("duty", 2)->nullable(true);

            $table->string("connection_type", 50)->nullable(true);
            $table->enum("nipple_grease", (["Available", "Not Available"]))->nullable(true);
            $table->string("greasing_type", 50)->nullable(true);
            $table->unsignedSmallInteger("greasing_qty_de")->nullable(true);
            $table->unsignedSmallInteger("greasing_qty_nde")->nullable(true);

            $table->unsignedSmallInteger("length")->nullable(true);
            $table->unsignedSmallInteger("width")->nullable(true);
            $table->unsignedSmallInteger("height")->nullable(true);
            $table->unsignedSmallInteger("weight")->nullable(true);
            $table->enum("cooling_fan", (["Internal", "External", "Not Available"]))->nullable(true);

            $table->enum("mounting", ["Horizontal", "Vertical", "V/H", "MGM"])->nullable(true);

            $table->foreign("emo")->references("id")->on("emos");
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
