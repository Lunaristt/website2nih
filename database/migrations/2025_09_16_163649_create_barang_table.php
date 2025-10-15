<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('ID_Barang'); // Primary Key
            $table->unsignedBigInteger('ID_Jenis'); // Foreign Key ke jenisbarang
            $table->string('Nama_Barang', 100); // harga barang (15 digit total)
            $table->integer('Harga_Barang', 15); // harga barang (15 digit total)
            $table->integer('Stok_Barang'); // stok barang
            $table->string('Satuan_Barang', 50); // satuan barang (misalnya kg, liter, pcs)
            $table->string('Merek_Barang', 100); // nama merek
            $table->string('Deskripsi_Barang', 200); // Deskripsi barang lanjutan seperti warna

            // Relasi ke tabel jenisbarang
            $table->foreign('ID_Jenis')
                ->references('ID_Jenis')
                ->on('jenisbarang')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
