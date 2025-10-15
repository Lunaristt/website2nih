<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('ID_Detail'); // PK auto increment
            $table->unsignedBigInteger('ID_Penjualan'); // FK ke tabel barangjualan
            $table->integer('Harga_Keseluruhan');
            $table->timestamp('Tanggal')->useCurrent(); // default SYSDATE

            // ✅ Tambahkan kolom Status
            $table->string('Status')->default('Pending'); // Pending, Selesai, Batal

            // Relasi FK ke tabel BarangJualan
            $table->foreign('ID_Penjualan')
                ->references('ID_Penjualan')->on('BarangJualan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
