<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->string('idBayar', 6)->primary();
            $table->string('metodePembayaran', 50)->nullable();
            $table->string('buktiBayar', 255)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->integer('total')->nullable();
            $table->date('tglBayar')->nullable();
            $table->string('statusBayar', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};