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
        Schema::create('transformer_records', function (Blueprint $table) {
            $table->id();
            $table->string("funcloc", 150)->nullable(false);
            $table->string("transformer", 9)->nullable(false);
            $table->string("sort_field", 150)->nullable(false);
            $table->enum("transformer_status", ["Online", "Offline"])->nullable(false);

            $table->unsignedSmallInteger("primary_current_phase_r")->nullable(false)->default(0); // 65535
            $table->unsignedSmallInteger("primary_current_phase_s")->nullable(false)->default(0); // 65535
            $table->unsignedSmallInteger("primary_current_phase_t")->nullable(false)->default(0); // 65535

            $table->unsignedSmallInteger("secondary_current_phase_r")->nullable(false)->default(0); // 65535
            $table->unsignedSmallInteger("secondary_current_phase_s")->nullable(false)->default(0); // 65535
            $table->unsignedSmallInteger("secondary_current_phase_t")->nullable(false)->default(0); // 65535

            $table->unsignedMediumInteger("primary_voltage")->nullable(false)->default(0); // 16777215
            $table->unsignedMediumInteger("secondary_voltage")->nullable(false)->default(0); // 16777215

            $table->unsignedSmallInteger("oil_temperature")->nullable(false)->default(0); // 65535
            $table->unsignedSmallInteger("winding_temperature")->nullable(false)->default(0); // 65535

            $table->enum("clean_status", ["Clean", "Dirty"])->nullable(false);
            $table->enum("noise", ["Normal", "Abnormal"])->nullable(false);
            $table->enum("silica_gel", ["Dark Blue", "Light Blue", "Pink", "Brown"])->nullable(false);
            $table->enum("earthing_connection", ["Tight", "Loose"])->nullable(false);
            $table->enum("oil_leakage", ["No Leaks", "Leaks"])->nullable(false);
            $table->enum("blower_condition", ["Normal", "Abnormal"])->nullable(false);
            $table->text("comment")->nullable(true);

            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->string("nik", 8)->nullable(false);

            $table->foreign("funcloc")->references("id")->on("function_locations");
            $table->foreign("transformer")->references("id")->on("transformers");
            $table->foreign("nik")->references("nik")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transformer_records');
    }
};
