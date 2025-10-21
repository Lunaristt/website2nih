<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migration untuk membuat tabel distributor.
     */
    public function up(): void
    {
        Schema::create('distributor', function (Blueprint $table) {
            $table->id('ID_Distributor');
            $table->string('Nama_Distributor', 100);
            $table->string('Telp_CS', 20)->nullable();
            $table->string('Nama_Salesman', 100)->nullable();
            $table->string('Notelp_Salesman', 20)->nullable();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor');
    }
};
