<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class satuanbarang extends Model
{
    protected $table = 'satuanbarang';
    protected $primaryKey = 'ID_Satuan';

    protected $fillable = [
        'Nama_Satuan',
    ];

    public $timestamps = false;

    public function satuanBarang()
    {
        return $this->belongsTo(satuanbarang::class, 'ID_Satuan');
    }

}
