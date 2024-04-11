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
        Schema::create('pub_shares', function (Blueprint $table) {
            $table->string('id')->primary()->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('nik', 8)->nullable(false);
            $table->string('attachment')->nullable(false);
            $table->timestamps();

            $table->foreign('nik')->on('users')->references('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pub_shares');
    }
};
