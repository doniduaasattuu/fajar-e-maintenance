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
        Schema::table('emo_records', function (Blueprint $table) {
            $table->dropColumn("temperature_a");
            $table->dropColumn("temperature_b");
            $table->dropColumn("temperature_c");
            $table->dropColumn("temperature_d");
            $table->dropColumn("vibration_value_de");
            $table->dropColumn("vibration_de");
            $table->dropColumn("vibration_value_nde");
            $table->dropColumn("vibration_nde");

            // TEMP
            $table->unsignedSmallInteger("temperature_de")->nullable(true)->default(0)->after("number_of_greasing");
            $table->unsignedSmallInteger("temperature_body")->nullable(true)->default(0)->after("temperature_de");
            $table->unsignedSmallInteger("temperature_nde")->nullable(true)->default(0)->after("temperature_body");
            // DE
            $table->decimal("vibration_de_vertical_value", 4, 2)->nullable(true)->default(0)->after("temperature_nde");
            $table->enum("vibration_de_vertical_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_de_vertical_value");
            $table->decimal("vibration_de_horizontal_value", 4, 2)->nullable(true)->default(0)->after("vibration_de_vertical_desc");
            $table->enum("vibration_de_horizontal_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_de_horizontal_value");
            $table->decimal("vibration_de_axial_value", 4, 2)->nullable(true)->default(0)->after("vibration_de_horizontal_desc");
            $table->enum("vibration_de_axial_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_de_axial_value");
            $table->decimal("vibration_de_frame_value", 4, 2)->nullable(true)->default(0)->after("vibration_de_axial_desc");
            $table->enum("vibration_de_frame_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_de_frame_value");
            // NDE 
            $table->decimal("vibration_nde_vertical_value", 4, 2)->nullable(true)->default(0)->after("vibration_de_frame_desc");
            $table->enum("vibration_nde_vertical_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_nde_vertical_value");
            $table->decimal("vibration_nde_horizontal_value", 4, 2)->nullable(true)->default(0)->after("vibration_nde_vertical_desc");
            $table->enum("vibration_nde_horizontal_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_nde_horizontal_value");
            $table->decimal("vibration_nde_frame_value", 4, 2)->nullable(true)->default(0)->after("vibration_nde_horizontal_desc");
            $table->enum("vibration_nde_frame_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_nde_frame_value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emo_records', function (Blueprint $table) {
            $table->unsignedSmallInteger("temperature_a")->nullable(false)->default(0)->after("number_of_greasing");
            $table->unsignedSmallInteger("temperature_b")->nullable(false)->default(0)->after("temperature_a");
            $table->unsignedSmallInteger("temperature_c")->nullable(false)->default(0)->after("temperature_b");
            $table->unsignedSmallInteger("temperature_d")->nullable(false)->default(0)->after("temperature_c");
            $table->decimal("vibration_value_de", 4, 2)->nullable(false)->default(0)->after("temperature_d");
            $table->enum("vibration_de", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_value_de");
            $table->decimal("vibration_value_nde", 4, 2)->nullable(false)->default(0)->after("vibration_de");
            $table->enum("vibration_nde", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true)->after("vibration_value_nde");
            $table->dropColumn("temperature_de");
            $table->dropColumn("temperature_body");
            $table->dropColumn("temperature_nde");
            $table->dropColumn("vibration_de_vertical_value");
            $table->dropColumn("vibration_de_vertical_desc");
            $table->dropColumn("vibration_de_horizontal_value");
            $table->dropColumn("vibration_de_horizontal_desc");
            $table->dropColumn("vibration_de_axial_value");
            $table->dropColumn("vibration_de_axial_desc");
            $table->dropColumn("vibration_de_frame_value");
            $table->dropColumn("vibration_de_frame_desc");
            $table->dropColumn("vibration_nde_vertical_value");
            $table->dropColumn("vibration_nde_vertical_desc");
            $table->dropColumn("vibration_nde_horizontal_value");
            $table->dropColumn("vibration_nde_horizontal_desc");
            $table->dropColumn("vibration_nde_frame_value");
            $table->dropColumn("vibration_nde_frame_desc");
        });
    }
};
