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
        Schema::table('emo_details', function (Blueprint $table) {
            $table->string("phase_supply", 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emo_details', function (Blueprint $table) {
            $table->char("phase_supply", 1)->nullable(true)->change();
        });
    }
};
