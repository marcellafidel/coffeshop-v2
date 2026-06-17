<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('idOrder', 20)->primary();
            $table->string('idCustomer', 6)->nullable();
            $table->dateTime('tanggal_order')->nullable();
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->enum('status_pembayaran', ['pending','paid','failed'])->nullable();
            $table->enum('payment_method', ['transfer','cod','ewallet'])->nullable();
            $table->string('confirmed_by', 6)->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->foreign('idCustomer')->references('idCust')->on('customers')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};