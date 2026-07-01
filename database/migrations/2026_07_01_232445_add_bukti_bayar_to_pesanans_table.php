<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->after('metodePembayaran');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'done', 'cancelled'])
                  ->default('pending')->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['bukti_bayar', 'status']);
        });
    }
};