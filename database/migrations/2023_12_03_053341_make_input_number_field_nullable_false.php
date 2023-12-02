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
            $table->unsignedTinyInteger("number_of_greasing")->nullable(false)->default(0)->change();
            $table->unsignedSmallInteger("temperature_de")->nullable(false)->default(0)->change();
            $table->unsignedSmallInteger("temperature_body")->nullable(false)->default(0)->change();
            $table->unsignedSmallInteger("temperature_nde")->nullable(false)->default(0)->change();
            $table->decimal("vibration_de_vertical_value", 4, 2)->nullable(false)->default(0)->change();
            $table->decimal("vibration_de_horizontal_value", 4, 2)->nullable(false)->default(0)->change();
            $table->decimal("vibration_de_axial_value", 4, 2)->nullable(false)->default(0)->change();
            $table->decimal("vibration_de_frame_value", 4, 2)->nullable(false)->default(0)->change();
            $table->enum("noise_de", ["Normal", "Abnormal"])->nullable(false)->change();
            $table->decimal("vibration_nde_vertical_value", 4, 2)->nullable(false)->default(0)->change();
            $table->decimal("vibration_nde_horizontal_value", 4, 2)->nullable(false)->default(0)->change();
            $table->decimal("vibration_nde_frame_value", 4, 2)->nullable(false)->default(0)->change();
            $table->enum("noise_nde", ["Normal", "Abnormal"])->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emo_records', function (Blueprint $table) {
            $table->unsignedTinyInteger("number_of_greasing")->nullable(true)->default(0)->change();
            $table->unsignedSmallInteger("temperature_de")->nullable(true)->default(0)->change();
            $table->unsignedSmallInteger("temperature_body")->nullable(true)->default(0)->change();
            $table->unsignedSmallInteger("temperature_nde")->nullable(true)->default(0)->change();
            $table->decimal("vibration_de_vertical_value", 4, 2)->nullable(true)->default(0)->change();
            $table->decimal("vibration_de_horizontal_value", 4, 2)->nullable(true)->default(0)->change();
            $table->decimal("vibration_de_axial_value", 4, 2)->nullable(true)->default(0)->change();
            $table->decimal("vibration_de_frame_value", 4, 2)->nullable(true)->default(0)->change();
            $table->enum("noise_de", ["Normal", "Abnormal"])->nullable(true)->change();
            $table->decimal("vibration_nde_vertical_value", 4, 2)->nullable(true)->default(0)->change();
            $table->decimal("vibration_nde_horizontal_value", 4, 2)->nullable(true)->default(0)->change();
            $table->decimal("vibration_nde_frame_value", 4, 2)->nullable(true)->default(0)->change();
            $table->enum("noise_nde", ["Normal", "Abnormal"])->nullable(true)->change();
        });
    }
};
