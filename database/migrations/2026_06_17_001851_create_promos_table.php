<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['persen', 'nominal']);
            $table->decimal('nilai', 10, 2);
            $table->decimal('min_belanja', 10, 2)->default(0);
            $table->decimal('maks_diskon', 10, 2)->nullable();
            $table->integer('kuota')->nullable();
            $table->integer('terpakai')->default(0);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};