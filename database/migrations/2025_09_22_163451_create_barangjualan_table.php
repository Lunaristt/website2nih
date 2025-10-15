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
        Schema::create('BarangJualan', function (Blueprint $table) {
            $table->id('ID_Penjualan'); // PK auto increment
            $table->unsignedBigInteger('ID_Barang'); // FK
            $table->integer('Jumlah');
            $table->decimal('Total_Harga', 15, 2);
            $table->timestamps();

            $table->foreign('ID_Barang')
                ->references('ID_Barang')->on('barang')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangjualan');
    }
};
