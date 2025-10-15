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
        Schema::create('jenisbarang', function (Blueprint $table) {
            $table->id('ID_Jenis'); // Primary Key
            $table->unsignedBigInteger('ID_Tipe'); // Foreign Key
            $table->string('Kategori_Barang', 100); // Nama kategori barang

            // Relasi ke tabel tipebarang
            $table->foreign('ID_Tipe')
                ->references('ID_Tipe')
                ->on('tipebarang')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenisbarang');
    }
};
