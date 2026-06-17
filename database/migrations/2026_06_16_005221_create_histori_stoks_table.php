<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histori_stoks', function (Blueprint $table) {
            $table->string('id_histori')->primary();
            $table->string('idProduk', 6)->nullable();
            $table->string('namaProduk', 255)->nullable();
            $table->integer('stok_sebelum')->nullable();
            $table->integer('stok_sesudah')->nullable();
            $table->integer('perubahan')->nullable();
            $table->enum('jenis_perubahan', ['masuk', 'keluar'])->nullable();
            $table->text('keterangan')->nullable();
            $table->string('idAdmin', 6)->nullable();
            $table->string('nama', 255)->nullable();
            $table->foreign('idProduk')->references('idProduk')->on('menus')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histori_stoks');
    }
};