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
        Schema::table('emos', function (Blueprint $table) {
            $table->string("unique_id", 6)->nullable(false)->unique()->change();
            $table->string("qr_code_link", 150)->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emos', function (Blueprint $table) {
            $table->string("unique_id", 6)->nullable(false)->change();
            $table->string("qr_code_link", 150)->nullable(false)->change();
        });
    }
};
