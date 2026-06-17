<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->string('idDetail', 20)->primary();
            $table->string('idPesanan', 20)->nullable();
            $table->string('idMenu', 20)->nullable();
            $table->string('namaMenu', 100)->nullable();
            $table->integer('jumlah')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->foreign('idPesanan')->references('idPesanan')->on('pesanans')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};