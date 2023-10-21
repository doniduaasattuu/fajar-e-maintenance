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
        Schema::create('data_records', function (Blueprint $table) {
            $table->id();
            $table->string("funcloc", 150)->nullable(false);
            $table->string("emo", 9)->nullable(false);
            $table->enum("motor_status", ["Running", "Not Running"])->nullable(false);
            $table->enum("clean_status", ["Clean", "Dirty"])->nullable(false);
            $table->enum("nipple_grease", ["Available", "Not Available"])->nullable(false);
            $table->unsignedTinyInteger("number_of_greasing")->nullable(true);
            $table->unsignedSmallInteger("temperature_a")->nullable(false);
            $table->unsignedSmallInteger("temperature_b")->nullable(false);
            $table->unsignedSmallInteger("temperature_c")->nullable(false);
            $table->unsignedSmallInteger("temperature_d")->nullable(false);
            $table->decimal("vibration_value_de", 4, 2)->nullable(false);
            $table->enum("vibration_de", ["Normal", "Abnormal"])->nullable(true);
            $table->decimal("vibration_value_nde", 4, 2)->nullable(false);
            $table->enum("vibration_nde", ["Normal", "Abnormal"])->nullable(true);
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->string("checked_by", 150)->nullable(false);

            $table->foreign("funcloc")->references("id")->on("function_locations");
            $table->foreign("emo")->references("id")->on("emos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_records');
    }
};
