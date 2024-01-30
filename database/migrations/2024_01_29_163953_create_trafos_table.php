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
        Schema::create('trafos', function (Blueprint $table) {
            $table->string("id", 9)->nullable(false)->primary();
            $table->enum("status", ["Installed", "Repaired", "Available"])->nullable(false);
            $table->string("funcloc", 50)->nullable(true);
            $table->string("sort_field", 50)->nullable(true);
            $table->string("description", 50)->nullable(true);
            $table->string("material_number", 8)->nullable(true);
            $table->string("unique_id", 6)->nullable(false)->unique();
            $table->string("qr_code_link", 100)->nullable(false)->unique();
            $table->timestamps();

            $table->foreign("funcloc")->on("funclocs")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trafos');
    }
};
