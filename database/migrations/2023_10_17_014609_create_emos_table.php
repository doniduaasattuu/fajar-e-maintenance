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
            $table->enum("status", ["Installed", "Repaired", "Available"])->nullable(false);
            $table->string("sort_field", 100)->nullable(false);
            $table->unsignedSmallInteger("unique_id")->nullable(false);
            $table->string("qr_code_link", 100)->nullable(false);
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrentOnUpdate();

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
