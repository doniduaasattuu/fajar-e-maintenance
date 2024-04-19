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
        Schema::create('issues', function (Blueprint $table) {
            $table->string('id', 13)->nullable(false)->primary();
            $table->timestamp('issued_date')->nullable(true);
            $table->timestamp('target_date')->nullable(true);
            $table->string('remaining_days')->nullable(true);
            $table->enum('section', ['ELC', 'INS', 'ELC/INS'])->nullable(true);
            $table->string('area')->nullable(true);
            $table->text('description')->nullable(true);
            $table->text('corrective_action')->nullable(true);
            $table->text('root_cause')->nullable(true);
            $table->text('preventive_action')->nullable(true);
            $table->enum('status', ['NOT', 'MONITORING', 'DONE'])->nullable(true);
            $table->string('remark')->nullable(true);
            $table->string('department')->nullable(true);
            $table->string('created_by')->nullable(true);
            $table->string('updated_by')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
