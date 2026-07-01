<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->string('idPesanan', 6)->primary();
            $table->unsignedBigInteger('idCust')->nullable();
            $table->string('idProduk', 6)->nullable();
            $table->string('idBayar', 6)->nullable();
            $table->date('tglPesanan')->nullable();
            $table->integer('jumPesanan')->nullable();
            $table->string('metodePembayaran', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('idCust')->references('id')->on('users')->nullOnDelete();
            $table->foreign('idProduk')->references('idProduk')->on('menus')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};