<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jenisbarang', function (Blueprint $table) {
            // Hapus foreign key kalau ada
            $table->dropForeign(['ID_Tipe']);
            // Hapus kolom
            $table->dropColumn('ID_Tipe');
        });
    }

    public function down(): void
    {
        Schema::table('jenisbarang', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Tipe')->nullable(false);
            $table->foreign('ID_Tipe')->references('ID_Tipe')->on('tipebarang');
        });
    }
};
