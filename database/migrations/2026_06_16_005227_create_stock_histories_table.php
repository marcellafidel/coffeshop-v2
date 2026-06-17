<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idProduk', 6)->nullable();
            $table->string('admin_id', 6)->nullable();
            $table->enum('action_type', ['in', 'out', 'adjustment'])->nullable();
            $table->integer('old_stock')->nullable();
            $table->integer('new_stock')->nullable();
            $table->integer('quantity_changed')->nullable();
            $table->string('reason', 255)->nullable();
            $table->foreign('idProduk')->references('idProduk')->on('menus')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};