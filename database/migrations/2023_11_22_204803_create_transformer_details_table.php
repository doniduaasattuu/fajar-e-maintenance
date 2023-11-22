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
        Schema::create('transformer_details', function (Blueprint $table) {
            $table->id();
            $table->string("transformer_detail", 9)->nullable(false);

            $table->string("power_rate", 25)->nullable(true);
            $table->enum("power_unit", ["kVA"])->nullable(true);

            $table->string("primary_voltage", 25)->nullable(true);
            $table->string("secondary_voltage", 25)->nullable(true);

            $table->string("primary_current", 25)->nullable(true);
            $table->string("secondary_current", 25)->nullable(true);

            $table->string("primary_connection_type", 25)->nullable(true);
            $table->string("secondary_connection_type", 25)->nullable(true);

            $table->enum("type", ["Step Up", "Step Down"])->nullable(true);
            $table->string("manufacturer", 25)->nullable(true);
            $table->string("year_of_manufacture", 5)->nullable(true);
            $table->string("serial_number", 25)->nullable(true);

            $table->string("vector_group", 25)->nullable(true);
            $table->string("frequency", 25)->nullable(true);
            $table->string("insulation_class", 25)->nullable(true);

            $table->string("type_of_cooling", 25)->nullable(true);
            $table->string("temp_rise_oil_winding", 25)->nullable(true);
            $table->string("weight", 25)->nullable(true);
            $table->string("weight_of_oil", 25)->nullable(true);
            $table->string("oil_type", 25)->nullable(true);
            $table->string("ip_rating", 25)->nullable(true);

            $table->foreign("transformer_detail")->references("id")->on("transformers");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transformer_details');
    }
};
