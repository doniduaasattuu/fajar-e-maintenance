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
        Schema::create('user_role', function (Blueprint $table) {
            $table->string('nik', 8)->nullable(false);
            $table->string('role')->nullable(false);
            $table->foreign('nik')->references('nik')->on('users');
            $table->foreign('role')->references('role')->on('roles');
            $table->primary(['nik', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
