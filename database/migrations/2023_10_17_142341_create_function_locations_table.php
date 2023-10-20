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
        Schema::create('function_locations', function (Blueprint $table) {
            $table->string("id", 150)->nullable(false)->primary();
            $table->string("emo", 9)->nullable(false);
            $table->string("tag_name", 100)->nullable(false);

            $table->foreign("emo")->references("id")->on("emos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('function_locations');
    }
};
