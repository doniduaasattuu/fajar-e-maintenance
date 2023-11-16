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
            $table->enum("noise_de", ["Normal", "Abnormal"])->after("vibration_de_frame_desc")->nullable(true);
            $table->enum("noise_nde", ["Normal", "Abnormal"])->after("vibration_nde_frame_desc")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emo_records', function (Blueprint $table) {
            $table->dropColumn("noise_de");
            $table->dropColumn("noise_nde");
        });
    }
};
