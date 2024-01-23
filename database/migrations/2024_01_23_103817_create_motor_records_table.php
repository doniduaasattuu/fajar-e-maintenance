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
        Schema::create('motor_records', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string("funcloc", 50)->nullable(false);
            $table->string("motor", 9)->nullable(false);
            $table->string("sort_field", 50)->nullable(false);
            $table->enum("motor_status", ["Running", "Not Running"])->nullable(true);
            $table->enum("cleanliness", ["Clean", "Dirty"])->nullable(true);
            $table->enum("nipple_grease", ["Available", "Not Available"])->nullable(true);
            $table->unsignedTinyInteger("number_of_greasing")->nullable(true)->default(0);
            $table->decimal("temperature_de", 5, 2)->nullable(true)->default(0.00);
            $table->decimal("temperature_body", 5, 2)->nullable(true)->default(0.00);
            $table->decimal("temperature_nde", 5, 2)->nullable(true)->default(0.00);
            $table->decimal("vibration_de_vertical_value", 4, 2)->nullable(true)->default(0.00);
            $table->enum("vibration_de_vertical_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_de_horizontal_value", 4, 2)->nullable(true)->default(0.00);
            $table->enum("vibration_de_horizontal_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_de_axial_value", 4, 2)->nullable(true)->default(0.00);
            $table->enum("vibration_de_axial_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_de_frame_value", 4, 2)->nullable(true)->default(0.00);
            $table->enum("vibration_de_frame_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->enum("noise_de", ["Normal", "Abnormal"])->nullable(true);
            $table->decimal("vibration_nde_vertical_value", 4, 2)->nullable(true)->default(0);
            $table->enum("vibration_nde_vertical_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_nde_horizontal_value", 4, 2)->nullable(true)->default(0);
            $table->enum("vibration_nde_horizontal_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_nde_frame_value", 4, 2)->nullable(true)->default(0);
            $table->enum("vibration_nde_frame_desc", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->enum("noise_nde", ["Normal", "Abnormal"])->nullable(true);
            $table->string("nik", 8)->nullable(false);
            $table->timestamps();

            $table->foreign('funcloc')->references('id')->on('funclocs');
            $table->foreign('motor')->references('id')->on('motors');
            $table->foreign("nik")->references("nik")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor_records');
    }
};
