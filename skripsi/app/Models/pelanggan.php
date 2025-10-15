<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'No_Telp';
    public $incrementing = false; // karena primary key bukan integer auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'No_Telp',
        'Nama_Pelanggan',
        'Alamat',
    ];
    public $timestamps = false;
}
