<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipeBarang;

class TipeBarangSeeder extends Seeder
{
    public function run()
    {
        $satuan = [
            'kilogram',
            'kantong',
            'botol',
            'lembar',
            'kaleng',
            'buah',
            'set',
            'sak',
            'kol',
            'kotak',
            'ember',
            'rol',
            'meter',
            'Liter',
            'ML',
            'CC',
            'Batang',
            'Inch',
            'CM',
        ];

        foreach ($satuan as $nama) {
            TipeBarang::firstOrCreate(['Nama_Satuan' => $nama]);
        }
    }
}
