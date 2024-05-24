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
        Schema::create('findings', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string('area', 20)->nullable(true);
            $table->enum("department", ["EI1", "EI2", "EI3", "EI4", "EI5", "EI6", "EI7"])->nullable(false);
            $table->enum('status', ['Open', 'Closed'])->nullable(true);
            $table->string('sort_field', 50)->nullable(true);
            $table->string('equipment', 9)->nullable(true);
            $table->string('funcloc', 50)->nullable(true);
            $table->char('notification', 8)->nullable(true);
            $table->string('reporter', 50)->nullable(true);
            $table->text('description')->nullable(false);
            $table->string('image', 20)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('findings');
    }
};
