<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\SatuanBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek kolom wajib
        if (empty($row['nama_barang']) || empty($row['kategori_barang']) || empty($row['nama_satuan'])) {
            return null;
        }

        // Cari ID Kategori berdasarkan nama kategori
        $kategori = KategoriBarang::where('Kategori_Barang', 'like', $row['kategori_barang'])->first();

        // Kalau kategori belum ada → tambahkan otomatis
        if (!$kategori) {
            $kategori = KategoriBarang::create([
                'Kategori_Barang' => ucfirst($row['kategori_barang']),
            ]);
        }

        // Cari ID Satuan berdasarkan nama satuan
        $satuan = SatuanBarang::where('Nama_Satuan', 'like', $row['nama_satuan'])->first();

        // Kalau satuan belum ada → tambahkan otomatis
        if (!$satuan) {
            $satuan = SatuanBarang::create([
                'Nama_Satuan' => ucfirst($row['nama_satuan']),
            ]);
        }

        // Simpan ke tabel Barang
        return new Barang([
            'Nama_Barang' => $row['nama_barang'],
            'ID_Kategori' => $kategori->ID_Kategori,
            'Merek_Barang' => $row['merek_barang'] ?? null,
            'Harga_Barang' => $row['harga_barang'] ?? 0,
            'Stok_Barang' => $row['stok_barang'] ?? 0,
            'Besar_Satuan' => $row['besar_satuan'] ?? 0,
            'ID_Satuan' => $satuan->ID_Satuan,
            'Deskripsi_Barang' => $row['deskripsi_barang'] ?? null,
        ]);
    }
}
