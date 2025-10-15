<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna'; // nama tabel
    protected $primaryKey = 'ID_Pengguna'; // primary key
    protected $fillable = [
        'Nama',
        'Password',
        'No_Telp',
        'Role',
    ];
    public $timestamps = false; // karena di tabel tidak ada created_at & updated_at
}
