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
        Schema::create('jenisbarang_tipebarang', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Jenis');
            $table->unsignedBigInteger('ID_Tipe');

            // Composite Primary Key
            $table->primary(['ID_Jenis', 'ID_Tipe']);

            // Foreign Keys
            $table->foreign('ID_Jenis')
                ->references('ID_Jenis')->on('jenisbarang')
                ->onDelete('cascade');

            $table->foreign('ID_Tipe')
                ->references('ID_Tipe')->on('tipebarang')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenisbarang_tipebarang');
    }
};
