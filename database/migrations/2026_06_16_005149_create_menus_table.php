<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('idProduk', 6)->primary();
            $table->string('namaProduk', 255)->nullable();
            $table->integer('harga')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('ukuran')->nullable();
            $table->date('tglDitambahkan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};