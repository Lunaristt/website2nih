<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            // No_Telp sebagai Primary Key
            $table->string('No_Telp', 13)->primary();

            // Nama Pelanggan
            $table->string('Nama_Pelanggan', 255);

            // Alamat max 500 karakter
            $table->string('Alamat', 500);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
