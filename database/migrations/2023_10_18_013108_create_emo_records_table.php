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
        Schema::create('emo_records', function (Blueprint $table) {
            $table->id();
            $table->string("funcloc", 150)->nullable(false);
            $table->string("emo", 9)->nullable(false);
            $table->string("sort_field", 150)->nullable(false);
            $table->enum("motor_status", ["Running", "Not Running"])->nullable(false);
            $table->enum("clean_status", ["Clean", "Dirty"])->nullable(false);
            $table->enum("nipple_grease", ["Available", "Not Available"])->nullable(false);
            $table->unsignedTinyInteger("number_of_greasing")->nullable(true)->default(0);
            $table->unsignedSmallInteger("temperature_a")->nullable(false)->default(0);
            $table->unsignedSmallInteger("temperature_b")->nullable(false)->default(0);
            $table->unsignedSmallInteger("temperature_c")->nullable(false)->default(0);
            $table->unsignedSmallInteger("temperature_d")->nullable(false)->default(0);
            $table->decimal("vibration_value_de", 4, 2)->nullable(false)->default(0);
            $table->enum("vibration_de", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->decimal("vibration_value_nde", 4, 2)->nullable(false)->default(0);
            $table->enum("vibration_nde", ["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"])->nullable(true);
            $table->text("comment")->nullable(true);
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->string("nik", 8)->nullable(false);

            $table->foreign("funcloc")->references("id")->on("function_locations");
            $table->foreign("emo")->references("id")->on("emos");
            $table->foreign("nik")->references("nik")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emo_records');
    }
};
