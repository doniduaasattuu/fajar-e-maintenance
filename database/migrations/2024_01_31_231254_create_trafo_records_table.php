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
        Schema::create('trafo_records', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string("funcloc", 50)->nullable(false);
            $table->string("trafo", 9)->nullable(false);
            $table->string("sort_field", 50)->nullable(false);
            $table->enum('trafo_status', ['Online', 'Offline'])->nullable(true);
            $table->decimal('primary_current_phase_r', 7, 2)->nullable(true);
            $table->decimal('primary_current_phase_s', 7, 2)->nullable(true);
            $table->decimal('primary_current_phase_t', 7, 2)->nullable(true);
            $table->decimal('secondary_current_phase_r', 7, 2)->nullable(true);
            $table->decimal('secondary_current_phase_s', 7, 2)->nullable(true);
            $table->decimal('secondary_current_phase_t', 7, 2)->nullable(true);
            $table->decimal('primary_voltage', 8, 2)->nullable(true);
            $table->decimal('secondary_voltage', 8, 2)->nullable(true);
            $table->decimal('oil_temperature', 5, 2)->nullable(true);
            $table->decimal('winding_temperature', 5, 2)->nullable(true);
            $table->enum('cleanliness', ["Clean", "Dirty"])->nullable(true);
            $table->enum('noise', ["Normal", "Abnormal"])->nullable(true);
            $table->enum('silica_gel', ["Dark blue", "Light blue", 'Pink', 'Brown'])->nullable(true);
            $table->enum('earthing_connection', ['No loose', 'Loose'])->nullable(true);
            $table->enum('oil_leakage', ['No leaks', 'Leaks'])->nullable(true);
            $table->unsignedTinyInteger('oil_level')->nullable(true);
            $table->enum('blower_condition', ['Good', 'Not good'])->nullable(true);
            $table->string("nik", 8)->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trafo_records');
    }
};
