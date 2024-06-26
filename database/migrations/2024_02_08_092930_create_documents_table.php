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
        Schema::create('documents', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string('title', 50)->nullable(false);
            $table->string('area', 20)->nullable(true);
            $table->enum("department", ["EI1", "EI2", "EI3", "EI4", "EI5", "EI6", "EI7"])->nullable(true);
            $table->string('equipment', 9)->nullable(true);
            $table->string('funcloc', 50)->nullable(true);
            $table->string('uploaded_by', 50)->nullable(true);
            $table->string('attachment')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
