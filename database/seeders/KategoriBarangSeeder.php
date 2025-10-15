<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBarang;
use App\Models\TipeBarang;

class KategoriBarangSeeder extends Seeder
{
    public function run()
    {
        // Mapping kategori barang ke ID_Tipe (boleh lebih dari satu)
        $data = [
            'cat tembok' => [5],
            'cat minyak' => [5],
            'pylox' => [5],
            'lampu' => [6],
            'cat anti air' => [5],
            'keran air' => [6],
            'kuas' => [6],
            'engsel' => [6, 7],
            'paku beton' => [2, 10],
            'paku baja ringan' => [2, 10],
            'amplas' => [4],
            'semen' => [1, 8],
            'pipa' => [13, 17],
            'sambungan pipa' => [6],
            'gagang pintu' => [6, 7],
            'kunci gembok' => [6],
            'tang' => [7],
            'lem besi' => [6],
            'lem putih' => [6],
            'thinner' => [3, 5],
            'sealant' => [3],
        ];

        foreach ($data as $kategori => $tipeIds) {
            $jenis = JenisBarang::firstOrCreate(['Kategori_Barang' => $kategori]);
            $jenis->tipeBarang()->sync($tipeIds); // assign banyak tipe
        }
    }
}