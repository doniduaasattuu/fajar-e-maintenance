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
        Schema::create('users', function (Blueprint $table) {
            $table->string("nik", 8)->nullable(false)->primary();
            $table->string("password")->nullable(false);
            $table->string("fullname", 50)->nullable(false);
            $table->enum("department", ["EI1", "EI2", "EI3", "EI4", "EI5", "EI6", "EI7"])->nullable(false);
            $table->string("phone_number", 15)->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
