<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->string('idAdmin', 6)->primary();
            $table->string('email', 255);
            $table->string('password', 8);
            $table->integer('telp')->nullable();
            $table->string('role', 50)->nullable();
            $table->date('tglBergabung')->nullable();
            $table->string('nama', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};