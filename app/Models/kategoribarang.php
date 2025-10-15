<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoribarang extends Model
{
    protected $table = "kategoribarang";
    protected $primaryKey = "ID_Kategori";
    public $timestamps = false;

    protected $fillable = [
        "Kategori_Barang"
    ];

    /**
     * Relasi ke model TipeBarang
     * JenisBarang belongsTo TipeBarang
     */
    public function kategoriBarang()
    {
        return $this->belongsTo(satuanbarang::class, 'ID_Kategori');
    }

}
