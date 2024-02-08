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
            $table->string('title')->nullable(false);
            $table->string('attachment')->nullable(false);
            $table->string('area')->nullable(true);
            $table->string('equipment')->nullable(true);
            $table->string('funcloc')->nullable(true);
            $table->string('uploaded_by')->nullable(true);
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
