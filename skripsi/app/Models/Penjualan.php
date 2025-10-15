<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'ID_Penjualan';
    public $timestamps = false;

    protected $fillable = [
        'No_Telp',
        'Harga_Keseluruhan',
        'Tanggal',
        'Status',
    ];

    /**
     * Relasi Many-to-Many dengan Barang melalui tabel pivot BarangPenjualan
     */
    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'BarangPenjualan', 'ID_Penjualan', 'ID_Barang')
            ->withPivot('Jumlah', 'Total_Harga');
    }

    public function barangpenjualan()
    {
        return $this->hasMany(\App\Models\BarangPenjualan::class, 'ID_Penjualan', 'ID_Penjualan');
    }

    /**
     * Relasi ke Pelanggan (1 pelanggan bisa punya banyak penjualan)
     */
    // public function pelanggan()
    // {
    //     return $this->belongsTo(Pelanggan::class, 'No_TelpPelanggan', 'No_Telp');
    // }
}
