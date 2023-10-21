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
        Schema::create('emos', function (Blueprint $table) {
            $table->string("id", 9)->nullable(false)->primary();
            $table->string("funcloc", 150)->nullable(false);
            $table->string("material_number")->nullable(true);
            $table->string("equipment_description", 150)->nullable(false);
            $table->enum("status", ["Installed", "Repaired", "Available"])->nullable(false);
            $table->string("sort_field", 100)->nullable(false);
            $table->string("unique_id", 6)->nullable(false);
            $table->string("qr_code_link", 100)->nullable(false);
            $table->timestamps();

            $table->foreign("funcloc")->on("function_locations")->references("id");
            $table->unique("unique_id", "emo_unique_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emos');
    }
};
