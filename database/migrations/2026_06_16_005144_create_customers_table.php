<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('idCust', 6)->primary();
            $table->string('nama', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password', 8);
            $table->string('telp')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tglDaftar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};