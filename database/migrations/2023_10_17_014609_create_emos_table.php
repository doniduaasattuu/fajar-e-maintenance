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
            $table->string("material_number")->nullable(true);
            $table->string("equipment_description", 150)->nullable(false);
            $table->enum("status", ["Installed", "Repaired", "Available"])->nullable(false);
            $table->string("sort_field", 100)->nullable(false);
            $table->string("unique_id", 6)->nullable(false);
            $table->string("qr_code_link", 100)->nullable(false);
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(true);

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
